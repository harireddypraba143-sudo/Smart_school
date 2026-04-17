<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FeeService Library
 * 
 * Handles invoice, payment, and fee summary queries.
 */
class FeeService {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Get fee summary for a student (total invoiced, paid, pending).
     */
    public function get_fee_summary($student_id) {
        // Get all invoices
        $invoices = $this->CI->db->get_where('invoice', ['student_id' => $student_id])->result();

        $total_invoiced = 0;
        $total_paid     = 0;
        $total_discount = 0;
        $total_due      = 0;
        $paid_count     = 0;
        $unpaid_count   = 0;
        $invoice_list   = [];

        foreach ($invoices as $inv) {
            $amount   = (float)$inv->amount;
            $paid     = (float)$inv->amount_paid;
            $discount = (float)$inv->discount;
            $due      = (float)$inv->due;

            $total_invoiced += $amount;
            $total_paid     += $paid;
            $total_discount += $discount;
            $total_due      += $due;

            if ($inv->status == 1) {
                $paid_count++;
            } else {
                $unpaid_count++;
            }

            $invoice_list[] = [
                'invoice_id'     => (int)$inv->invoice_id,
                'invoice_number' => $inv->invoice_number,
                'title'          => $inv->title,
                'amount'         => $amount,
                'paid'           => $paid,
                'discount'       => $discount,
                'due'            => max(0, $due),
                'status'         => $inv->status == 1 ? 'paid' : 'unpaid',
                'date'           => $inv->creation_timestamp
            ];
        }

        return [
            'total_invoiced' => $total_invoiced,
            'total_paid'     => $total_paid,
            'total_discount' => $total_discount,
            'total_due'      => max(0, $total_due),
            'paid_count'     => $paid_count,
            'unpaid_count'   => $unpaid_count,
            'invoices'       => $invoice_list
        ];
    }

    /**
     * Get all invoices for a student (paginated).
     */
    public function get_invoices($student_id, $limit = 20, $offset = 0) {
        $invoices = $this->CI->db
            ->where('student_id', $student_id)
            ->order_by('invoice_id', 'DESC')
            ->limit($limit, $offset)
            ->get('invoice')
            ->result();

        return array_map(function($inv) {
            return [
                'invoice_id'     => (int)$inv->invoice_id,
                'invoice_number' => $inv->invoice_number,
                'title'          => $inv->title,
                'description'    => $inv->description,
                'amount'         => (float)$inv->amount,
                'discount'       => (float)$inv->discount,
                'amount_paid'    => (float)$inv->amount_paid,
                'due'            => max(0, (float)$inv->due),
                'status'         => $inv->status == 1 ? 'paid' : 'unpaid',
                'payment_method' => $inv->payment_method,
                'date'           => $inv->creation_timestamp,
                'year'           => $inv->year
            ];
        }, $invoices);
    }

    /**
     * Count total invoices for a student.
     */
    public function count_invoices($student_id) {
        return $this->CI->db->where('student_id', $student_id)->count_all_results('invoice');
    }

    /**
     * Get a single invoice with its payment history.
     */
    public function get_invoice_detail($invoice_id, $student_id) {
        $invoice = $this->CI->db->get_where('invoice', [
            'invoice_id' => $invoice_id,
            'student_id' => $student_id
        ])->row();

        if (!$invoice) return NULL;

        // Get payment transactions for this invoice
        $payments = $this->CI->db
            ->where(['invoice_id' => $invoice_id, 'student_id' => $student_id])
            ->order_by('payment_id', 'ASC')
            ->get('payment')
            ->result();

        $payment_trail = array_map(function($p) {
            return [
                'payment_id'  => (int)$p->payment_id,
                'title'       => $p->title,
                'amount'      => (float)$p->amount,
                'method'      => $p->method,
                'date'        => $p->timestamp ? date('Y-m-d', $p->timestamp) : '',
                'description' => $p->description
            ];
        }, $payments);

        return [
            'invoice_id'     => (int)$invoice->invoice_id,
            'invoice_number' => $invoice->invoice_number,
            'title'          => $invoice->title,
            'description'    => $invoice->description,
            'amount'         => (float)$invoice->amount,
            'discount'       => (float)$invoice->discount,
            'amount_paid'    => (float)$invoice->amount_paid,
            'due'            => max(0, (float)$invoice->due),
            'status'         => $invoice->status == 1 ? 'paid' : 'unpaid',
            'payment_method' => $invoice->payment_method,
            'date'           => $invoice->creation_timestamp,
            'year'           => $invoice->year,
            'payment_trail'  => $payment_trail
        ];
    }

    /**
     * Get all payments for a student (paginated).
     */
    public function get_payments($student_id, $limit = 20, $offset = 0) {
        $payments = $this->CI->db
            ->where('student_id', $student_id)
            ->where('payment_type', 'income')
            ->order_by('payment_id', 'DESC')
            ->limit($limit, $offset)
            ->get('payment')
            ->result();

        return array_map(function($p) {
            return [
                'payment_id'  => (int)$p->payment_id,
                'invoice_id'  => (int)$p->invoice_id,
                'title'       => $p->title,
                'amount'      => (float)$p->amount,
                'method'      => $p->method,
                'date'        => $p->timestamp ? date('Y-m-d', $p->timestamp) : '',
                'description' => $p->description,
                'year'        => $p->year
            ];
        }, $payments);
    }

    /**
     * Count total payments for a student.
     */
    public function count_payments($student_id) {
        return $this->CI->db->where(['student_id' => $student_id, 'payment_type' => 'income'])->count_all_results('payment');
    }
}
