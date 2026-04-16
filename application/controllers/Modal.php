<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
	
    }
	
	public function index()
	{
		
	}
	

	function popup($page_name = '' , $param2 = '' , $param3 = '', $param4 = '')
	{
		$account_type = $this->session->userdata('login_type');
		$view_path = 'backend/'.$account_type.'/'.$page_name;
		
		// Support subdirectory views (e.g., hrms/edit_employee, hrms/modal_hr_letter)
		if ($param2 != '' && !is_numeric($param2) && file_exists(APPPATH . 'views/' . $view_path . '/' . $param2 . '.php')) {
			$view_path = $view_path . '/' . $param2;
			$param2 = $param3;
			$param3 = $param4;
		}
		
		$page_data['param2'] = $param2;
		$page_data['param3'] = $param3;
		$this->load->view($view_path.'.php', $page_data);
		
	}
}
