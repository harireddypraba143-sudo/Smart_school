<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Systemsetting extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();							// load database library
        		$this->load->library('session');					//Load library for session
    }


/**default functin, redirects to login page if no admin logged in yet***/
    public function index() {
        	if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        	if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }

   

   /************** Manage system setings  ********************/
	function system_settings($param1 = '', $param2 = '', $param3 = '') 
	{
    if ($this->session->userdata('admin_login') != 1)
    redirect(base_url() . 'login', 'refresh');


        if ($param1 == 'do_update') {
           
        $this->crud_model->update_settings();

        $this->session->set_flashdata('flash_message', get_phrase('Data Updated'));
        redirect(base_url(). 'systemsetting/system_settings', 'refresh');
    }

    if ($param1 == 'upload_logo') 
	{
       $this->crud_model->system_logo();
       $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
       redirect(base_url() . 'systemsetting/system_settings', 'refresh');
    }

    if ($param1 == 'upload_upi_qr') 
	{
       $this->crud_model->system_upi_qr();
       $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
       redirect(base_url() . 'systemsetting/system_settings', 'refresh');
    }


    if ($param1 == 'themeSettings') 
	{
        $this->crud_model->update_theme();
        $this->session->set_flashdata('flash_message', get_phrase('Theme Selected'));
        redirect(base_url() . 'systemsetting/system_settings', 'refresh');
    }


    $page_data['page_name'] = 'system_settings';
    $page_data['page_title'] = get_phrase('system_settings');
    $page_data['settings'] = $this->db->get('settings')->result_array();
    $this->load->view('backend/index', $page_data);
    }


    /************** RFID / Card Machine Settings ********************/
    function rfid_settings($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'login', 'refresh');

        if ($param1 == 'create_device') {
            $this->crud_model->create_rfid_device();
            $this->session->set_flashdata('flash_message', get_phrase('Device added successfully'));
            redirect(base_url() . 'systemsetting/rfid_settings', 'refresh');
        }

        if ($param1 == 'update_device') {
            $this->crud_model->update_rfid_device($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Device updated successfully'));
            redirect(base_url() . 'systemsetting/rfid_settings', 'refresh');
        }

        if ($param1 == 'delete_device') {
            $this->crud_model->delete_rfid_device($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Device deleted successfully'));
            redirect(base_url() . 'systemsetting/rfid_settings', 'refresh');
        }

        if ($param1 == 'regenerate_key') {
            $this->crud_model->regenerate_device_api_key($param2);
            $this->session->set_flashdata('flash_message', get_phrase('API Key regenerated'));
            redirect(base_url() . 'systemsetting/rfid_settings', 'refresh');
        }

        if ($param1 == 'update_rfid_settings') {
            $this->crud_model->update_rfid_settings();
            $this->session->set_flashdata('flash_message', get_phrase('RFID Settings updated'));
            redirect(base_url() . 'systemsetting/rfid_settings', 'refresh');
        }

        $page_data['page_name'] = 'rfid_settings';
        $page_data['page_title'] = 'RFID / Card Machine Setup';
        $page_data['devices'] = $this->crud_model->get_rfid_devices();
        $this->load->view('backend/index', $page_data);
    }


    /************** RFID Card Assignment ********************/
    function rfid_cards($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'login', 'refresh');

        if ($param1 == 'assign') {
            $this->crud_model->assign_rfid_card();
            $this->session->set_flashdata('flash_message', get_phrase('Card assigned successfully'));
            redirect(base_url() . 'systemsetting/rfid_cards', 'refresh');
        }

        if ($param1 == 'update') {
            $this->crud_model->update_rfid_card($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Card updated successfully'));
            redirect(base_url() . 'systemsetting/rfid_cards', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->crud_model->delete_rfid_card($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Card removed'));
            redirect(base_url() . 'systemsetting/rfid_cards', 'refresh');
        }

        $page_data['page_name'] = 'rfid_card_assignment';
        $page_data['page_title'] = 'RFID Card Assignment';
        $page_data['cards'] = $this->crud_model->get_rfid_cards();
        $this->load->view('backend/index', $page_data);
    }


    /************** RFID Attendance Log ********************/
    function rfid_attendance_log() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'login', 'refresh');

        $filters = array(
            'date_from'  => $this->input->get('date_from'),
            'date_to'    => $this->input->get('date_to'),
            'device_id'  => $this->input->get('device_id'),
            'user_type'  => $this->input->get('user_type')
        );

        $page_data['page_name'] = 'rfid_attendance_log';
        $page_data['page_title'] = 'RFID Attendance Log';
        $page_data['logs'] = $this->crud_model->get_rfid_attendance_logs($filters);
        $page_data['devices'] = $this->crud_model->get_rfid_devices();
        $page_data['filters'] = $filters;
        $this->load->view('backend/index', $page_data);
    }

    /************** Quick DB Fix — currency + branding ********************/
    function quick_fix() {
        // Update currency to INR
        $this->db->where('type', 'currency');
        $this->db->update('settings', array('description' => '₹'));

        // Update system name
        $this->db->where('type', 'system_name');
        $this->db->update('settings', array('description' => 'Smart School System'));

        // Update system title
        $this->db->where('type', 'system_title');
        $this->db->update('settings', array('description' => 'Smart School System'));

        // Update footer
        $this->db->where('type', 'footer');
        $this->db->update('settings', array('description' => 'Chaturveda Software Solutions. All Rights Reserved.'));

        echo "OK: Currency updated to ₹ (INR), System name updated to Smart School System.";
    }

    function debug_all_invoices() {
        // Fix any existing bad invoices in the DB where due > 0 but status is '1' (Paid)
        $this->db->query("UPDATE invoice SET status = '2' WHERE due > 0");

        echo "<pre>";
        echo "All Invoices:\n";
        $this->db->order_by('invoice_id', 'desc');
        $this->db->limit(10);
        $res = $this->db->get('invoice')->result_array();
        print_r($res);
        echo "</pre>";
    }

	
}
