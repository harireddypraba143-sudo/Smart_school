<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }

    /**
     * Audit logger for payroll actions
     */
    public function log_audit($payroll_id, $action) 
    {
        $data = array(
            'payroll_id' => $payroll_id,
            'action' => $action,
            'performed_by' => $this->session->userdata('login_user_id'),
            'timestamp' => date('Y-m-d H:i:s')
        );
        $this->db->insert('payroll_audit_logs', $data);
    }

    /**
     * Safely sync teacher base salary into salary_structures if missing.
     * In the future, this can be expanded with specific HR views.
     */
    public function sync_salary_structure($teacher_id, $joining_salary) 
    {
        $existing = $this->db->get_where('salary_structures', array('employee_id' => $teacher_id))->row();
        if (!$existing) {
            $data = array(
                'employee_id' => $teacher_id,
                'basic' => $joining_salary ? $joining_salary : 0
            );
            $this->db->insert('salary_structures', $data);
            return $this->db->insert_id();
        }
        return $existing->id;
    }

    /**
     * Phase 2: Core Backend Logic - Bulk Generation Safety
     * Generate Draft/Generated payslips for all active teachers
     */
    public function create_payroll_bulk($month, $year) 
    {
        // Get all active teachers
        $teachers = $this->db->get_where('teacher', array('status' => '1'))->result_array();
        $generated_count = 0;

        foreach ($teachers as $teacher) {
            $teacher_id = $teacher['teacher_id'];
            
            // Check if already generated for this month/year (Safety Check)
            $existing = $this->db->get_where('payroll', array(
                'employee_id' => $teacher_id,
                'month' => $month,
                'year' => $year
            ))->row();

            if (!$existing) {
                // Ensure salary structure exists
                $this->sync_salary_structure($teacher_id, $teacher['joining_salary']);
                
                // Fetch structure
                $structure = $this->db->get_where('salary_structures', array('employee_id' => $teacher_id))->row();
                
                // Base formula calculations based on joining salary
                // Base formula calculations based on joining salary
                $gross = $teacher['joining_salary'] > 0 ? $teacher['joining_salary'] : 0;
                
                $basic = $structure->basic > 0 ? $structure->basic : ($gross * 0.40);
                $hra = $structure->hra > 0 ? $structure->hra : ($gross * 0.20);
                
                // Extra Allowances Logic
                $da = ($gross * 0.10);
                $conveyance = ($gross * 0.05);
                $medical = ($gross * 0.05);
                $special = ($gross * 0.20); // Balances out to 100% of gross
                
                // Deductions Logic
                $pf = $structure->pf > 0 ? $structure->pf : ($basic * 0.12);
                $esi = isset($structure->esi) && $structure->esi > 0 ? $structure->esi : ($gross * 0.0075);
                $tax = $structure->tax > 0 ? $structure->tax : (($gross - $pf) * 0.05);
                $pt = isset($structure->pt) && $structure->pt > 0 ? $structure->pt : 200; // Manual PT override

                $total_allow = $hra + $da + $conveyance + $medical + $special;
                $total_deduct = $pf + $esi + $tax + $pt;

                $net_salary = $basic + $total_allow - $total_deduct;

                $payroll_data = array(
                    'employee_id' => $teacher_id,
                    'month' => $month,
                    'year' => $year,
                    'basic_salary' => $basic,
                    'allowances' => $total_allow, 
                    'deductions' => $total_deduct,
                    'net_salary' => $net_salary,
                    'status' => 1, // 1 = Generated
                    'payslip_no' => 'PAY-' . date('ym') . '-' . rand(1000, 9999)
                );
                
                $this->db->insert('payroll', $payroll_data);
                $payroll_id = $this->db->insert_id();

                // Add richer breakdown items to dynamic table
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'allowance', 'name' => 'House Rent Allowance (HRA)', 'amount' => $hra));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'allowance', 'name' => 'Dearness Allowance (DA)', 'amount' => $da));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'allowance', 'name' => 'Conveyance Allowance', 'amount' => $conveyance));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'allowance', 'name' => 'Medical Allowance', 'amount' => $medical));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'allowance', 'name' => 'Special Allowance', 'amount' => $special));
                
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'deduction', 'name' => 'Employee Provident Fund (EPF)', 'amount' => $pf));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'deduction', 'name' => 'Employee State Insurance (ESI)', 'amount' => $esi));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'deduction', 'name' => 'Professional Tax (PT)', 'amount' => $pt));
                $this->db->insert('payroll_items', array('payroll_id' => $payroll_id, 'type' => 'deduction', 'name' => 'Tax Deducted at Source (TDS)', 'amount' => $tax));

                $this->log_audit($payroll_id, 'System Auto-Generated');
                $generated_count++;
            }
        }
        
        return $generated_count;
    }

    /**
     * Executes payment for a specific payroll
     */
    public function pay_salary($payroll_id, $amount, $method, $transaction_ref) 
    {
        $payroll = $this->db->get_where('payroll', array('payroll_id' => $payroll_id))->row();
        
        if ($payroll && !$payroll->is_locked) {
            // Update Core Record
            $update_data = array(
                'status' => 2, // 2 = Paid
                'payment_method' => $method,
                'payment_date' => date('Y-m-d H:i:s'),
                'transaction_reference' => $transaction_ref,
                'is_locked' => 1 // Lock record to prevent edits after payment
            );
            $this->db->where('payroll_id', $payroll_id);
            $this->db->update('payroll', $update_data);

            // Create Fintech Ledger Entry
            $ledger_data = array(
                'payroll_id' => $payroll_id,
                'amount' => $amount,
                'method' => $method,
                'status' => 'SUCCESS',
                'transaction_ref' => $transaction_ref
            );
            $this->db->insert('payment_ledger', $ledger_data);

            $this->log_audit($payroll_id, 'Salary Marked as Paid by Admin');
            return true;
        }
        return false;
    }
}
