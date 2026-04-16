<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Student_payment_model extends CI_Model { 
	
	function __construct(){
        parent::__construct();
    }



        function createStudentSinglePaymentFunction (){

            $page_data['invoice_number']    =   html_escape($this->input->post('invoice_number'));
            $page_data['student_id']        =   html_escape($this->input->post('student_id'));
            $page_data['title']             =   html_escape($this->input->post('title'));
            $page_data['description']       =   html_escape($this->input->post('description'));
            $page_data['amount']            =   html_escape($this->input->post('amount'));
            $page_data['discount']          =   html_escape($this->input->post('discount'));
            $page_data['amount_paid']       =   html_escape($this->input->post('amount_paid'));
            $page_data['due']               =   $page_data['amount']  - $page_data['amount_paid'] - $page_data['discount'];
            $page_data['creation_timestamp']    =   html_escape($this->input->post('creation_timestamp'));
            $page_data['payment_method']        =   html_escape($this->input->post('payment_method'));
            
            // Auto-calculate status: 1 = Paid, 2 = Unpaid
            if ($page_data['due'] <= 0) {
                $page_data['status'] = '1';
                $page_data['due'] = 0; // Avoid negative due
            } else {
                $page_data['status'] = '2';
            }
            
            $page_data['year']                  =  $this->db->get_where('settings', array('type' => 'session'))->row()->description;

            $this->db->insert('invoice', $page_data);
            $invoice_id = $this->db->insert_id();

            $page_data2['invoice_id']   =   $invoice_id;
            $page_data2['student_id']   =   html_escape($this->input->post('student_id'));
            $page_data2['title']        =   html_escape($this->input->post('title'));
            $page_data2['description']  =   html_escape($this->input->post('description'));
            $page_data2['payment_type'] =  'income';
            $page_data2['amount']       =   html_escape($this->input->post('amount_paid')); // Note: tracking actual paid amount, not total
            if ($page_data2['amount'] > 0) {
                $page_data2['discount']     =   html_escape($this->input->post('discount'));
                $page_data2['timestamp']    =   strtotime($this->input->post('creation_timestamp'));
                $page_data2['year']         =   $this->db->get_where('settings', array('type' => 'session'))->row()->description;
                $page_data2['method']       =   html_escape($this->input->post('payment_method'));

                $this->db->insert('payment', $page_data2);
                $payment_id = $this->db->insert_id();
            }
        }

        function createStudentMassPaymentFunction(){

            foreach($this->input->post('student_id') as $key => $id) {
                $page_data['invoice_number']    =   html_escape($this->input->post('invoice_number')) . '-' . $id;
                $page_data['student_id']        =   $id;
                $page_data['title']             =   html_escape($this->input->post('title'));
                $page_data['description']       =   html_escape($this->input->post('description'));
                $page_data['amount']            =   html_escape($this->input->post('amount'));
                $page_data['discount']          =   html_escape($this->input->post('discount'));
                $page_data['amount_paid']       =   html_escape($this->input->post('amount_paid'));
                $page_data['due']               =   $page_data['amount']  - $page_data['amount_paid'] - $page_data['discount'];
                $page_data['creation_timestamp']    =   html_escape($this->input->post('creation_timestamp'));
                $page_data['payment_method']        =   html_escape($this->input->post('payment_method'));
                
                // Auto-calculate status: 1 = Paid, 2 = Unpaid
                if ($page_data['due'] <= 0) {
                    $page_data['status'] = '1';
                    $page_data['due'] = 0;
                } else {
                    $page_data['status'] = '2';
                }
                
                $page_data['year']                  =  $this->db->get_where('settings', array('type' => 'session'))->row()->description;

                $this->db->insert('invoice', $page_data);
                $invoice_id = $this->db->insert_id();

                $page_data2['invoice_id']   =   $invoice_id;
                $page_data2['student_id']   =   $id;
                $page_data2['title']        =   html_escape($this->input->post('title'));
                $page_data2['description']  =   html_escape($this->input->post('description'));
                $page_data2['payment_type']  =  'income';
                $page_data2['amount']       =   html_escape($this->input->post('amount_paid')); // Track actual paid amount
                
                if ($page_data2['amount'] > 0) {
                    $page_data2['discount']     =   html_escape($this->input->post('discount'));
                    $page_data2['timestamp']    =   strtotime($this->input->post('creation_timestamp'));
                    $page_data2['year']         =   $this->db->get_where('settings', array('type' => 'session'))->row()->description;
                    $page_data2['method']       =   html_escape($this->input->post('payment_method'));

                    $this->db->insert('payment', $page_data2);
                    $payment_id = $this->db->insert_id();
                }
            }

        }


        function takeNewPaymentFromStudent($param2){
            $page_data['invoice_id']        =   html_escape($this->input->post('invoice_id'));
            $page_data['student_id']        =   html_escape($this->input->post('student_id'));
            $page_data['title']             =   html_escape($this->input->post('title'));
            $page_data['description']       =   html_escape($this->input->post('description'));
            $page_data['amount']            =   html_escape($this->input->post('amount'));
            $page_data['payment_type']      =   'income';
            $page_data['method']            =   html_escape($this->input->post('method'));
            $page_data['timestamp']         =   strtotime($this->input->post('timestamp'));
            $page_data['year']              =  $this->db->get_where('settings', array('type' => 'session'))->row()->description;
            
            $this->db->insert('payment', $page_data);
            $payment_id = $this->db->insert_id();

            $amount_paid = html_escape($this->input->post('amount'));
            
            // Get current invoice to check if this payment clears the due
            $invoice = $this->db->get_where('invoice', array('invoice_id' => $param2))->row();
            
            $new_amount_paid = $invoice->amount_paid + $amount_paid;
            $new_due = $invoice->due - $amount_paid;
            
            $update_data = array(
                'amount_paid' => $new_amount_paid,
                'due' => $new_due
            );
            
            // If fully paid, change status to 1 (Paid)
            if ($new_due <= 0) {
                $update_data['status'] = '1';
                $update_data['due'] = 0; // prevent negative due
            }

            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $update_data);

        }


        function updateStudentPaymentFunction($param2){

            $page_data['student_id']        =  html_escape($this->input->post('student_id'));
            $page_data['title']             =   html_escape($this->input->post('title'));
            $page_data['description']       =   html_escape($this->input->post('description'));
            $page_data['amount']            =   html_escape($this->input->post('amount'));
            $page_data['amount_paid']       =   html_escape($this->input->post('amount_paid'));
            $page_data['due']               =   $page_data['amount']  - $page_data['amount_paid'];
            $page_data['creation_timestamp']    =   html_escape($this->input->post('date'));
            $page_data['status']                =   html_escape($this->input->post('status'));

            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $page_data);


        }

        function deleteStudentPaymentFunction($param2){
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');

        }

    



}