<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    public function generate_employee_id($branch_code = '001', $type_code = 'STF') {
        $year = date('Y');
        
        $this->db->select('staff_number');
        $this->db->from('staff');
        $this->db->like('staff_number', "SCH{$branch_code}-{$type_code}-{$year}");
        $this->db->order_by('staff_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $last_id = $query->row()->staff_number;
            $parts = explode('-', $last_id);
            $sequence = intval(end($parts)) + 1;
        } else {
            $sequence = 1;
        }
        
        $sequence_padded = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        return "SCH{$branch_code}-{$type_code}-{$year}-{$sequence_padded}";
    }

    function insertStaffFunction(){

        $employee_id = $this->generate_employee_id('001', 'STF');

        $staff_array = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'staff_number'          => $employee_id,
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
			'phone'                 => $this->input->post('phone'),
			'marital_status'        => $this->input->post('marital_status'),
			'password'              => sha1($this->input->post('password')),
        	'department_id'         => $this->input->post('department_id'),
            'designation_id'        => $this->input->post('designation_id'),
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary'),
			'status'                => $this->input->post('status'),
			'date_of_leaving'       => $this->input->post('date_of_leaving'),
            'pf'                    => $this->input->post('pf'),
            'esi'                   => $this->input->post('esi'),
            'tax'                   => $this->input->post('tax'),
            'pt'                    => $this->input->post('pt')
        );
        
        $staff_array['file_name'] = $_FILES["file_name"]["name"];
        $staff_array['email'] = $this->input->post('email');
        
        // Manual Bank details creation (same as teacher)
        $bank_data = array(
            'account_holder_name' => $this->input->post('account_holder_name'),
            'account_number'      => $this->input->post('account_number'),
            'bank_name'           => $this->input->post('bank_name'),
            'branch'              => $this->input->post('branch')
        );
        $this->db->insert('bank', $bank_data);
        $bank_id = $this->db->insert_id();
        $staff_array['bank_id'] = $bank_id;

        $check_email = $this->db->get_where('staff', array('email' => $staff_array['email']))->row()->email;
        if($check_email != null && $staff_array['email'] != '') 
        {
            $this->session->set_flashdata('error_message', get_phrase('email_already_exist'));
            redirect(base_url() . 'admin/staff/', 'refresh');
        }
        else
        {
            $this->db->insert('staff', $staff_array);
            $staff_id = $this->db->insert_id();
            
            if ($_FILES["file_name"]["name"]) {
                if(!is_dir("uploads/staff_image/")){
                    mkdir("uploads/staff_image/", 0777, true);
                }
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/staff_image/" . $_FILES["file_name"]["name"]);
            }
            if ($_FILES['userfile']['name']) {
                if(!is_dir("uploads/staff_image/")){
                    mkdir("uploads/staff_image/", 0777, true);
                }
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $staff_id . '.jpg');
            }
            
            // Sync Salary Structure
            $salary_data = array(
                'employee_id' => $staff_id,
                'employee_type' => 'staff',
                'basic' => $this->input->post('joining_salary') ? $this->input->post('joining_salary') : 0,
                'pf' => $this->input->post('pf') ? $this->input->post('pf') : 0,
                'esi' => $this->input->post('esi') ? $this->input->post('esi') : 0,
                'tax' => $this->input->post('tax') ? $this->input->post('tax') : 0,
                'pt' => $this->input->post('pt') ? $this->input->post('pt') : 200
            );
            $this->db->insert('salary_structures', $salary_data);
        }
    }

    function updateStaffFunction($param2){
        $staff_array = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
			'phone'                 => $this->input->post('phone'),
			'marital_status'        => $this->input->post('marital_status'),
        	'department_id'         => $this->input->post('department_id'),
            'designation_id'        => $this->input->post('designation_id'),
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary'),
			'status'                => $this->input->post('status'),
			'date_of_leaving'       => $this->input->post('date_of_leaving'),
            'pf'                    => $this->input->post('pf'),
            'esi'                   => $this->input->post('esi'),
            'tax'                   => $this->input->post('tax'),
            'pt'                    => $this->input->post('pt')
        );
        $staff_array['email'] = $this->input->post('email');
        if($this->input->post('password')){
            $staff_array['password'] = sha1($this->input->post('password'));
        }

        $this->db->where('staff_id', $param2);
        $this->db->update('staff', $staff_array);

        if ($_FILES['userfile']['name']) {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $param2 . '.jpg');
        }

        // Update salary structure
        $this->db->where('employee_id', $param2);
        $this->db->where('employee_type', 'staff');
        $this->db->update('salary_structures', array(
            'basic' => $this->input->post('joining_salary') ? $this->input->post('joining_salary') : 0,
            'pf' => $this->input->post('pf') ? $this->input->post('pf') : 0,
            'esi' => $this->input->post('esi') ? $this->input->post('esi') : 0,
            'tax' => $this->input->post('tax') ? $this->input->post('tax') : 0,
            'pt' => $this->input->post('pt') ? $this->input->post('pt') : 200
        ));
    }

    function deleteStaffFunction($param2){
        $this->db->where('staff_id', $param2);
        $this->db->delete('staff');
        $this->db->where('employee_id', $param2);
        $this->db->where('employee_type', 'staff');
        $this->db->delete('salary_structures');
    }
}
