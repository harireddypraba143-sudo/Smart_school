<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();                                //Load Databse Class
                $this->load->library('session');					    //Load library for session
                $this->load->model('academic_model');                   // Load Apllication Model Here
                $this->load->model('student_model');                    // Load Apllication Model Here
                $this->load->model('exam_question_model');              // Load Apllication Model Here
                $this->load->model('student_payment_model');            // Load Apllication Model Here
                $this->load->model('event_model');                      // Load Apllication Model Here
                $this->load->model('language_model');                      // Load Apllication Model Here
                $this->load->model('admin_model');                      // Load Apllication Model Here
    }

    /** Check if any staff role is logged in (admin, accountant, admission) **/
    private function _is_staff_logged_in() {
        return ($this->session->userdata('admin_login') == 1 || 
                $this->session->userdata('accountant_login') == 1 || 
                $this->session->userdata('admission_login') == 1);
    }

    /** Check if user has a specific permission **/
    private function _has_permission($perm_name) {
        $permissions = $this->session->userdata('permissions');
        if (!$permissions) return false;
        // Admin has all permissions
        if ($this->session->userdata('login_type') == 'admin') return true;
        return in_array($perm_name, $permissions);
    }

    /**default functin, redirects to login page if no admin logged in yet***/
    public function index() 
	{
    if (!$this->_is_staff_logged_in()) redirect(base_url() . 'login', 'refresh');
    redirect(base_url() . 'admin/dashboard', 'refresh');
    }
	  /************* / default functin, redirects to login page if no admin logged in yet***/

    /*Admin dashboard code to redirect to admin page if successfull login** */
    function dashboard() {
        if (!$this->_is_staff_logged_in()) redirect(base_url(), 'refresh');
       	$page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
	/******************* / Admin dashboard code to redirect to admin page if successfull login** */


    function manage_profile($param1 = null, $param2 = null, $param3 = null){
    if (!$this->_is_staff_logged_in()) redirect(base_url(), 'refresh');
    if ($param1 == 'update') {


        $data['name']   =   $this->input->post('name');
        $data['email']  =   $this->input->post('email');

        $this->db->where('admin_id', $this->session->userdata('admin_id'));
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $this->session->userdata('admin_id') . '.jpg');
        $this->session->set_flashdata('flash_message', get_phrase('Info Updated'));
        redirect(base_url() . 'admin/manage_profile', 'refresh');
       
    }

    if ($param1 == 'change_password') {
        $data['new_password']           =   sha1($this->input->post('new_password'));
        $data['confirm_new_password']   =   sha1($this->input->post('confirm_new_password'));

        if ($data['new_password'] == $data['confirm_new_password']) {
           
           $this->db->where('admin_id', $this->session->userdata('admin_id'));
           $this->db->update('admin', array('password' => $data['new_password']));
           $this->session->set_flashdata('flash_message', get_phrase('Password Changed'));
        }

        else{
            $this->session->set_flashdata('error_message', get_phrase('Type the same password'));
        }
        redirect(base_url() . 'admin/manage_profile', 'refresh');
    }

        $page_data['page_name']     = 'manage_profile';
        $page_data['page_title']    = get_phrase('Manage Profile');
        $page_data['edit_profile']  = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }


    function enquiry_category($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'insert'){
   
        $this->crud_model->enquiry_category();

        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/enquiry_category', 'refresh');
    }

    if($param1 == 'update'){

       $this->crud_model->update_category($param2);


        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/enquiry_category', 'refresh');

        }

    if($param1 == 'delete'){

       $this->crud_model->delete_category($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/enquiry_category', 'refresh');

        }

        $page_data['page_name']     = 'enquiry_category';
        $page_data['page_title']    = get_phrase('Manage Category');
        $page_data['enquiry_category']  = $this->db->get('enquiry_category')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    function list_enquiry ($param1 = null, $param2 = null, $param3 = null){


        if($param1 == 'delete')
        {
            $this->crud_model->delete_enquiry($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/list_enquiry', 'refresh');
    
        }

        $page_data['page_name']     = 'list_enquiry';
        $page_data['page_title']    = get_phrase('All Enquiries');
        $page_data['select_enquiry']  = $this->db->get('enquiry')->result_array();
        $this->load->view('backend/index', $page_data);

    }



    function club ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'insert'){
            $this->crud_model->insert_club();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/club', 'refresh');
        }

        if($param1 == 'update'){
            $this->crud_model->update_club($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/club', 'refresh');
        }


        if($param1 == 'delete'){
            $this->crud_model->delete_club($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/club', 'refresh');
    
            }


        $page_data['page_name']     = 'club';
        $page_data['page_title']    = get_phrase('Manage Club');
        $page_data['select_club']  = $this->db->get('club')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    function circular($param1 = null, $param2 = null, $param3 = null){

        if ($param1 == 'insert'){

            $this->crud_model->insert_circular();
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully saved'));
            redirect(base_url(). 'admin/circular', 'refresh');
        }


        if($param1 == 'update'){

            $this->crud_model->update_circular($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully updated'));
            redirect(base_url(). 'admin/circular', 'refresh');

        }


        if($param1 == 'delete'){
            $this->crud_model->delete_circular($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully deleted'));
            redirect(base_url(). 'admin/circular', 'refresh');


        }

        $page_data['page_name']         = 'circular';
        $page_data['page_title']        = get_phrase('Manage Circular');
        $page_data['select_circular']   = $this->db->get('circular')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    function parent($param1 = null, $param2 = null, $param3 = null){

        if ($param1 == 'insert'){

            $this->crud_model->insert_parent();
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully saved'));
            redirect(base_url(). 'admin/parent', 'refresh');
        }


        if($param1 == 'update'){

            $this->crud_model->update_parent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully updated'));
            redirect(base_url(). 'admin/parent', 'refresh');

        }

        if($param1 == 'delete'){
            $this->crud_model->delete_parent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully deleted'));
            redirect(base_url(). 'admin/parent', 'refresh');

        }

        $page_data['page_name']         = 'parent';
        $page_data['page_title']        = get_phrase('Manage Parent');
        $page_data['select_parent']   = $this->db->get('parent')->result_array();
        $this->load->view('backend/index', $page_data);
    }


 





  


    // ===============================================
    // CR80 PVC ID CARD GENERATOR
    // ===============================================
    function id_card_generator() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'id_card_generator';
        $page_data['page_title'] = 'Generate ID Cards';
        $this->load->view('backend/index', $page_data);
    }

    function print_id_card() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $user_type = $this->input->post('user_type');
        $session_validity = $this->input->post('session_validity');
        
        $users = array();
        
        // Hard limit to 100 cards per batch to prevent thermal printer buffer overload
        $this->db->limit(100);

        if ($user_type == 'student') {
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $this->db->where('class_id', $class_id);
            if ($section_id != '') {
                $this->db->where('section_id', $section_id);
            }
            $users = $this->db->get('student')->result_array();

        } else if ($user_type == 'teacher') {
            $this->db->where('status', '1');
            $users = $this->db->get('teacher')->result_array();

        } else if ($user_type == 'staff') {
            $this->db->where('status', '1');
            $users = $this->db->get('staff')->result_array();
        }

        $page_data['type'] = $user_type;
        $page_data['users'] = $users;
        $page_data['session_validity'] = $session_validity;

        // Render directly the printing view (no sidebar/header)
        $this->load->view('backend/admin/print_id_card', $page_data);
    }
    // ===============================================

    function teacher ($param1 = null, $param2 = null, $param3 = null){
        
        // Auto-migrate missing columns for payroll integration
        if (!$this->db->field_exists('joining_salary', 'teacher')) {
            $this->db->query("ALTER TABLE `teacher` ADD `joining_salary` decimal(10,2) NOT NULL DEFAULT '0.00'");
        }
        if (!$this->db->field_exists('date_of_joining', 'teacher')) {
            $this->db->query("ALTER TABLE `teacher` ADD `date_of_joining` date DEFAULT NULL");
        }
        // Auto-migrate staff_type column
        if (!$this->db->field_exists('staff_type', 'teacher')) {
            $this->db->query("ALTER TABLE `teacher` ADD `staff_type` VARCHAR(20) NOT NULL DEFAULT 'teaching'");
        }

        if($param1 == 'insert'){
            $_POST['staff_type'] = 'teaching'; // Force teaching type
            $this->teacher_model->insetTeacherFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/teacher', 'refresh');
        }

        if($param1 == 'update'){
            $this->teacher_model->updateTeacherFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/teacher', 'refresh');
        }


        if($param1 == 'delete'){
            $this->teacher_model->deleteTeacherFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/teacher', 'refresh');
    
        }

        $page_data['page_name']     = 'hrms/employee_directory';
        $page_data['page_title']    = get_phrase('Manage Teachers');
        // Filter to only show teaching staff
        $this->db->where('staff_type', 'teaching');
        $page_data['select_teacher']  = $this->db->get('teacher')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    /***********  Staff Management (Non-Teaching: Drivers, Watchmen, Peons, etc.) ***********************/
    function staff ($param1 = null, $param2 = null, $param3 = null){
        
        // Auto-migration for completely separate staff table architecture
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff` (
            `staff_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) NOT NULL,
            `staff_number` varchar(50) DEFAULT NULL,
            `role` int(11) DEFAULT NULL,
            `birthday` varchar(250) DEFAULT NULL,
            `sex` varchar(250) DEFAULT NULL,
            `blood_group` varchar(250) DEFAULT NULL,
            `religion` varchar(250) DEFAULT NULL,
            `phone` varchar(250) DEFAULT NULL,
            `email` varchar(250) DEFAULT NULL,
            `address` longtext,
            `password` varchar(250) DEFAULT NULL,
            `marital_status` varchar(250) DEFAULT NULL,
            `department_id` int(11) DEFAULT NULL,
            `designation_id` int(11) DEFAULT NULL,
            `date_of_joining` varchar(250) DEFAULT NULL,
            `joining_salary` varchar(250) DEFAULT NULL,
            `status` int(11) DEFAULT '1',
            `date_of_leaving` varchar(250) DEFAULT NULL,
            `file_name` varchar(250) DEFAULT NULL,
            `bank_id` int(11) DEFAULT NULL,
            `pf` varchar(250) DEFAULT NULL,
            `esi` varchar(250) DEFAULT NULL,
            `tax` varchar(250) DEFAULT NULL,
            `pt` varchar(250) DEFAULT NULL,
            PRIMARY KEY (`staff_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_attendance` (
            `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
            `status` int(11) NOT NULL DEFAULT '0',
            `date` varchar(250) NOT NULL,
            `staff_id` int(11) NOT NULL,
            PRIMARY KEY (`attendance_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        // Migrate existing payroll structure to support polymorphism
        if (!$this->db->field_exists('employee_type', 'payroll')) {
            $this->db->query("ALTER TABLE `payroll` ADD `employee_type` ENUM('teacher', 'staff') NOT NULL DEFAULT 'teacher' AFTER `employee_id`");
        }
        if (!$this->db->field_exists('employee_type', 'salary_structures')) {
            $this->db->query("ALTER TABLE `salary_structures` ADD `employee_type` ENUM('teacher', 'staff') NOT NULL DEFAULT 'teacher' AFTER `employee_id`");
        }
        if (!$this->db->field_exists('employee_type', 'leave')) {
            $this->db->query("ALTER TABLE `leave` ADD `employee_type` ENUM('teacher', 'staff') NOT NULL DEFAULT 'teacher' AFTER `teacher_id`");
        }
        $this->load->model('staff_model');

        if($param1 == 'insert'){
            $this->staff_model->insertStaffFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Staff added successfully'));
            redirect(base_url(). 'admin/staff', 'refresh');
        }

        if($param1 == 'update'){
            $this->staff_model->updateStaffFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Staff updated successfully'));
            redirect(base_url(). 'admin/staff', 'refresh');
        }

        if($param1 == 'delete'){
            $this->staff_model->deleteStaffFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Staff deleted successfully'));
            redirect(base_url(). 'admin/staff', 'refresh');
        }

        $page_data['page_name']     = 'staff';
        $page_data['page_title']    = get_phrase('Manage Staff');
        // Fetch from new separate staff table
        $page_data['select_staff']  = $this->db->get('staff')->result_array();
        $this->load->view('backend/index', $page_data);

    }

    function get_designation($department_id = null){

        $designation = $this->db->get_where('designation', array('department_id' => $department_id))->result_array();
        foreach($designation as $key => $row)
        echo '<option value="'.$row['designation_id'].'">' . $row['name'] . '</option>';
    }

 


    function get_employees($department_id = null)
    {
        $employees = $this->db->get_where('teacher', array('department_id' => $department_id))->result_array();
        foreach($employees as $key => $employees)
            echo '<option value="' . $employees['teacher_id'] . '">' . $employees['name'] . '</option>';
    }

 


    /***********  The function manages Class Information  ***********************/
      function classes ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->class_model->createClassFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/classes', 'refresh');
        }

        if($param1 == 'update'){
            $this->class_model->updateClassFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/classes', 'refresh');
        }


        if($param1 == 'delete'){
            $this->class_model->deleteClassFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/classes', 'refresh');
    
        }

        $page_data['page_name']     = 'class';
        $page_data['page_title']    = get_phrase('Manage Class');
        $this->load->view('backend/index', $page_data);

    }


    /***********  The function manages Section  ***********************/
    function section ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
        $this->section_model->createSectionFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/section', 'refresh');
        }

        if($param1 == 'update'){
        $this->section_model->updateSectionFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/section', 'refresh');
        }

        if($param1 == 'delete'){
        $this->section_model->deleteSectionFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/section', 'refresh');
        }

        $page_data['page_name']     = 'section';
        $page_data['page_title']    = get_phrase('Manage Section');
        $this->load->view('backend/index', $page_data);
    }

        function sections ($class_id = null){

            if($class_id == '')
            $class_id = $this->db->get('class')->first_row()->class_id;
            
            $page_data['page_name']     = 'section';
            $page_data['class_id']      = $class_id;
            $page_data['page_title']    = get_phrase('Manage Section');
            $this->load->view('backend/index', $page_data);

        }
    



    function get_class_section_subject($class_id){
        $page_data['class_id']  =   $class_id;
        $this->load->view('backend/admin/class_routine_section_subject_selector', $page_data);

    }



    function section_subject_edit($class_id, $class_routine_id){

    $page_data['class_id']          =   $class_id;
    $page_data['class_routine_id']  =   $class_routine_id;
    $this->load->view('backend/admin/class_routine_section_subject_edit', $page_data);

    }


    /***********  The function manages school dormitory  ***********************/
    function dormitory ($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'create'){
        $this->dormitory_model->createDormitoryFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/dormitory', 'refresh');
    }

    if($param1 == 'update'){
        $this->dormitory_model->updateDormitoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/dormitory', 'refresh');
    }


    if($param1 == 'delete'){
        $this->dormitory_model->deleteDormitoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/dormitory', 'refresh');

    }

    $page_data['page_name']     = 'dormitory';
    $page_data['page_title']    = get_phrase('Manage Dormitory');
    $this->load->view('backend/index', $page_data);

    }

    /******************** Hostel Attendance Report **********************/
    function hostel_attendance_report($month = NULL, $year = NULL) {
        if (!$this->_is_staff_logged_in())
            redirect(base_url() . 'login', 'refresh');

        if ($_POST) {
            redirect(base_url() . 'admin/hostel_attendance_report/' . $month . '/' . $year, 'refresh');
        }

        $page_data['month'] = $month;
        $page_data['year'] = $year;
        $page_data['page_name'] = 'hostel_attendance_report';
        $page_data['page_title'] = "Hostel Attendance Report";
        $this->load->view('backend/index', $page_data);
    }

    function loadHostelAttendanceReport($month, $year) {
        $page_data['month'] = $month;
        $page_data['year']  = $year;
        $this->load->view('backend/admin/loadHostelAttendanceReport', $page_data);
    }


    /***********  The function manages hostel room  ***********************/
    function hostel_room ($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'create'){
        $this->dormitory_model->createHostelRoomFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/hostel_room', 'refresh');
    }

    if($param1 == 'update'){
        $this->dormitory_model->updateHostelRoomFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/hostel_room', 'refresh');
    }


    if($param1 == 'delete'){
        $this->dormitory_model->deleteHostelRoomFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/hostel_room', 'refresh');

    }

    $page_data['page_name']     = 'hostel_room';
    $page_data['page_title']    = get_phrase('Hostel Room');
    $this->load->view('backend/index', $page_data);

    }


    /***********  The function manages hostel category  ***********************/
    function hostel_category ($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'create'){
        $this->dormitory_model->createHostelCategoryFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/hostel_category', 'refresh');
    }

    if($param1 == 'update'){
        $this->dormitory_model->updateHostelCategoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/hostel_category', 'refresh');
    }


    if($param1 == 'delete'){
        $this->dormitory_model->deleteHostelCategoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/hostel_category', 'refresh');

    }

    $page_data['page_name']     = 'hostel_category';
    $page_data['page_title']    = get_phrase('Hostel Category');
    $this->load->view('backend/index', $page_data);
    }



    /***********  The function manages academic syllabus ***********************/
    function academic_syllabus ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
        $this->academic_model->createAcademicSyllabus();
        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/academic_syllabus', 'refresh');
    }

    if($param1 == 'update'){
        $this->academic_model->updateAcademicSyllabus($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/academic_syllabus', 'refresh');
    }


    if($param1 == 'delete'){
        $this->academic_model->deleteAcademicSyllabus($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/academic_syllabus', 'refresh');

        }

        $page_data['page_name']     = 'academic_syllabus';
        $page_data['page_title']    = get_phrase('Academic Syllabus');
        $this->load->view('backend/index', $page_data);

    }

    function get_class_subject($class_id){
        $subjects = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
            foreach($subjects as $key => $subject)
            {
                echo '<option value="'.$subject['subject_id'].'">'.$subject['name'].'</option>';
            }
    }

    function get_class_section($class_id){
        $sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();
            foreach($sections as $key => $section)
            {
                echo '<option value="'.$section['section_id'].'">'.$section['name'].'</option>';
            }
    }


    function download_academic_syllabus($academic_syllabus_code){
        $get_file_name = $this->db->get_where('academic_syllabus', array('academic_syllabus_code' => $academic_syllabus_code))->row()->file_name;
        // Loading download from helper.
        $this->load->helper('download');
        $get_download_content = file_get_contents('uploads/syllabus' . $get_file_name);
        $name = $file_name;
        force_download($name, $get_download_content);
    }

    function get_academic_syllabus ($class_id = null){

        if($class_id == '')
        $class_id = $this->db->get('class')->first_row()->class_id;
        
        $page_data['page_name']     = 'academic_syllabus';
        $page_data['class_id']      = $class_id;
        $page_data['page_title']    = get_phrase('Academic Syllabus');
        $this->load->view('backend/index', $page_data);

    }

    /***********  The function below add, update and delete student from students' table ***********************/
    function new_student ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->student_model->createNewStudent();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/student_information', 'refresh');
        }

        if($param1 == 'update'){
            $this->student_model->updateNewStudent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_information', 'refresh');
        }

        if($param1 == 'delete'){
            $this->student_model->deleteNewStudent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/student_information', 'refresh');

        }

        $page_data['page_name']     = 'new_student';
        $page_data['page_title']    = get_phrase('Manage Student');
        $this->load->view('backend/index', $page_data);

    }

    function student_certificates() {
        $allowed = array('admin', 'accountant', 'admission');
        if (!in_array($this->session->userdata('login_type'), $allowed)) {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']     = 'student_certificates';
        $page_data['page_title']    = 'Student Certificates';
        $this->load->view('backend/index', $page_data);
    }

    function get_students_for_cert($class_id = '') {
        $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
        echo '<option value="">-- Select Student --</option>';
        foreach($students as $student) {
            echo '<option value="' . $student['student_id'] . '">' . $student['name'] . '</option>';
        }
    }

    function generate_certificate($student_id = '', $cert_type = '') {
        $page_data['student_id'] = $student_id;
        $page_data['cert_type'] = $cert_type;
        $this->load->view('backend/admin/certificate_template', $page_data);
    }

    function student_information(){

        $page_data['page_name']     = 'student_information';
        $page_data['page_title']    = get_phrase('List Student');
        $page_data['class_id']      = '';
        $this->load->view('backend/index', $page_data);
    }


    /**************************  search student function with ajax starts here   ***********************************/
    function getStudentClasswise($class_id){

        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/showStudentClasswise', $page_data);
    }
    /**************************  search student function with ajax ends here   ***********************************/


    function edit_student($student_id){

        $page_data['student_id']      = $student_id;
        $page_data['page_name']     = 'edit_student';
        $page_data['page_title']    = get_phrase('Edit Student');
        $this->load->view('backend/index', $page_data);
    }


    function resetStudentPassword ($student_id) {
        $password['password']               =   sha1($this->input->post('new_password'));
        $confirm_password['confirm_new_password']   =   sha1($this->input->post('confirm_new_password'));
        if ($password['password'] == $confirm_password['confirm_new_password']) {
           $this->db->where('student_id', $student_id);
           $this->db->update('student', $password);
           $this->session->set_flashdata('flash_message', get_phrase('Password Changed'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('Type the same password'));
        }
        redirect(base_url() . 'admin/student_information', 'refresh');
    }

    function manage_attendance($date = null, $month= null, $year = null, $class_id = null, $section_id = null ){
        $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
        
        if ($_POST) {
	
            // Loop all the students of $class_id
            $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
            foreach ($students as $key => $student) {
            $attendance_status = $this->input->post('status_' . $student['student_id']);
            $full_date = $year . "-" . $month . "-" . $date;
            $this->db->where('student_id', $student['student_id']);
            $this->db->where('date', $full_date);
    
            $this->db->update('attendance', array('status' => $attendance_status));
    
                   if ($attendance_status == 2) 
            {
                     if ($active_sms_gateway != '' || $active_sms_gateway != 'disabled') {
                        $student_name   = $this->db->get_where('student' , array('student_id' => $student['student_id']))->row()->name;
                        $parent_id      = $this->db->get_where('student' , array('student_id' => $student['student_id']))->row()->parent_id;
                        $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                        if($parent_id != null && $parent_id != 0){
                            $recieverPhoneNumber = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                            if($recieverPhoneNumber != '' || $recieverPhoneNumber != null){
                                $this->sms_model->send_sms($message, $recieverPhoneNumber);
                            }
                            else{
                                $this->session->set_flashdata('error_message' , get_phrase('Parent Phone Not Found'));
                            }
                        }
                        else{
                            $this->session->set_flashdata('error_message' , get_phrase('SMS Gateway Not Found'));
                        }
                    }
           }
        }
    
            $this->session->set_flashdata('flash_message', get_phrase('Updated Successfully'));
            redirect(base_url() . 'admin/manage_attendance/' . $date . '/' . $month . '/' . $year . '/' . $class_id . '/' . $section_id, 'refresh');
        }

        $page_data['date'] = $date;
        $page_data['month'] = $month;
        $page_data['year'] = $year;
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['page_name'] = 'manage_attendance';
        $page_data['page_title'] = get_phrase('Manage Attendance');
        $this->load->view('backend/index', $page_data);

    }

    function attendance_selector(){
        $date = $this->input->post('timestamp');
        $date = date_create($date);
        $date = date_format($date, "d/m/Y");
        redirect(base_url(). 'admin/manage_attendance/' .$date. '/' . $this->input->post('class_id'). '/' . $this->input->post('section_id'), 'refresh');
    }


    function attendance_report($class_id = NULL, $section_id = NULL, $month = NULL, $year = NULL) {
        
        $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
        
        
        if ($_POST) {
        redirect(base_url() . 'admin/attendance_report/' . $class_id . '/' . $section_id . '/' . $month . '/' . $year, 'refresh');
        }
        
        $classes = $this->db->get('class')->result_array();
        foreach ($classes as $key => $class) {
            if (isset($class_id) && $class_id == $class['class_id'])
                $class_name = $class['name'];
            }
                    
        $sections = $this->db->get('section')->result_array();
            foreach ($sections as $key => $section) {
                if (isset($section_id) && $section_id == $section['section_id'])
                    $section_name = $section['name'];
        }
        
        $page_data['month'] = $month;
        $page_data['year'] = $year;
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['page_name'] = 'attendance_report';
        $page_data['page_title'] = "Attendance Report:" . $class_name . " : Section " . $section_name;
        $this->load->view('backend/index', $page_data);
    }


    /******************** Load attendance with ajax code starts from here **********************/
	function loadAttendanceReport($class_id, $section_id, $month, $year)
    {
        $page_data['class_id'] 		= $class_id;					// get all class_id
		$page_data['section_id'] 	= $section_id;					// get all section_id
		$page_data['month'] 		= $month;						// get all month
		$page_data['year'] 			= $year;						// get all class year
		
        $this->load->view('backend/admin/loadAttendanceReport' , $page_data);
    }
    /******************** Load attendance with ajax code ends from here **********************/


    /******************** Teacher Attendance Report **********************/
    function teacher_attendance_report($month = NULL, $year = NULL) {
        if (!$this->_is_staff_logged_in())
            redirect(base_url() . 'login', 'refresh');

        $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;

        if ($_POST) {
            redirect(base_url() . 'admin/teacher_attendance_report/' . $month . '/' . $year, 'refresh');
        }

        $page_data['month'] = $month;
        $page_data['year'] = $year;
        $page_data['page_name'] = 'hrms/staff_attendance';
        $page_data['page_title'] = "Staff & Teacher Attendance";
        $this->load->view('backend/index', $page_data);
    }

    function loadTeacherAttendanceReport($month, $year) {
        $page_data['month'] = $month;
        $page_data['year']  = $year;
        
        $this->load->view('backend/admin/hrms/loadTeacherAttendanceReport', $page_data);
    }

    

    /******************** print attendance report **********************/
	function printAttendanceReport($class_id=NULL, $section_id=NULL, $month=NULL, $year=NULL)
    {
        $page_data['class_id'] 		= $class_id;					// get all class_id
		$page_data['section_id'] 	= $section_id;					// get all section_id
		$page_data['month'] 		= $month;						// get all month
		$page_data['year'] 			= $year;						// get all class year
		
        $page_data['page_name'] = 'printAttendanceReport';
        $page_data['page_title'] = "Attendance Report";
        $this->load->view('backend/index', $page_data);
    }
    /******************** /Ends here **********************/
    


     /***********  The function below add, update and delete exam question table ***********************/
    function examQuestion ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->exam_question_model->createexamQuestion();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/examQuestion', 'refresh');
        }

        if($param1 == 'update'){
            $this->exam_question_model->updateexamQuestion($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/examQuestion', 'refresh');
        }

        if($param1 == 'delete'){
            $this->exam_question_model->deleteexamQuestion($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/examQuestion', 'refresh');
        }

        $page_data['page_name']     = 'examQuestion';
        $page_data['page_title']    = get_phrase('Exam Question');
        $this->load->view('backend/index', $page_data);
    }
     /***********  The function below add, update and delete exam question table ends here ***********************/


    /***********  The function below add, update and delete examination table ***********************/
    function createExamination ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->exam_model->createExamination();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/createExamination', 'refresh');
        }

        if($param1 == 'update'){
            $this->exam_model->updateExamination($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/createExamination', 'refresh');
        }

        if($param1 == 'delete'){
            $this->exam_model->deleteExamination($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/createExamination', 'refresh');
        }

        $page_data['page_name']     = 'createExamination';
        $page_data['page_title']    = get_phrase('Create Exam');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function below add, update and delete examination table ends here ***********************/

    /***********  The function below add, update and delete student payment table ***********************/
    function student_payment ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'single_invoice'){
            $this->student_payment_model->createStudentSinglePaymentFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        if($param1 == 'mass_invoice'){
            $this->student_payment_model->createStudentMassPaymentFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        if($param1 == 'update_invoice'){
            $this->student_payment_model->updateStudentPaymentFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        if($param1 == 'take_payment'){
            $this->student_payment_model->takeNewPaymentFromStudent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }


        if($param1 == 'delete_invoice'){
            $this->student_payment_model->deleteStudentPaymentFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        $page_data['page_name']     = 'student_payment';
        $page_data['page_title']    = get_phrase('Student Payment');
        $this->load->view('backend/index', $page_data);
    }   
    /***********  / Student payment ends here ***********************/
    
    function get_class_student($class_id){
        $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
            foreach($students as $key => $student)
            {
                echo '<option value="'.$student['student_id'].'">'.$student['name'].'</option>';
            }
    }

    /***********  AJAX: Get student fee balance for current academic year ***********************/
    function get_student_balance($student_id) {
        $current_year = $this->db->get_where('settings', array('type' => 'session'))->row()->description;

        // Sum of all 'due' amounts for this student in the current academic year
        $this->db->select_sum('due');
        $this->db->where('student_id', $student_id);
        $this->db->where('year', $current_year);
        $result = $this->db->get('invoice')->row();

        $total_due = ($result && $result->due) ? floatval($result->due) : 0;

        // Get student name
        $student = $this->db->get_where('student', array('student_id' => $student_id))->row();
        $student_name = $student ? $student->name : '';

        header('Content-Type: application/json');
        echo json_encode(array(
            'balance' => $total_due,
            'student_name' => $student_name,
            'academic_year' => $current_year
        ));
    }


    function get_class_mass_student($class_id){

        $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
        foreach($students as $key => $student)
        {
            echo '<div class="">
            <label><input type="checkbox" class="check" name="student_id[]" value="' . $student['student_id'] . '">' . '&nbsp;'. $student['name'] .'</label></div>';
        }

        echo '<br><button type ="button" class="btn btn-success btn-sm btn-rounded" onClick="select()">'.get_phrase('Select All').'</button>';
        echo '<button type ="button" class="btn btn-primary btn-sm btn-rounded" onClick="unselect()">'.get_phrase('Unselect All').'</button>';
    }

    function student_invoice(){
        // Auto-correct any invoices that have due amount but were wrongly marked as Paid (status 1)
        $this->db->query("UPDATE invoice SET status = '2' WHERE due > 0");

        $page_data['page_name']     = 'student_invoice';
        $page_data['page_title']    = get_phrase('Manage Invoice');
        $this->load->view('backend/index', $page_data);
    }



    /***********  The function below manages school event ***********************/
    function noticeboard ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->event_model->createNoticeboardFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/noticeboard', 'refresh');
        }

        if($param1 == 'update'){
            $this->event_model->updateNoticeboardFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/noticeboard', 'refresh');
        }

        if($param1 == 'delete'){
            $this->event_model->deleteNoticeboardFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/noticeboard', 'refresh');
        }

        $page_data['page_name']     = 'noticeboard';
        $page_data['page_title']    = get_phrase('School Event');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school events ends here ***********************/

     /***********  The function below manages school language ***********************/
     function manage_language ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'edit_phrase'){
            $page_data['edit_profile']  =   $param2;
        }

        if($param1 == 'add_language'){
            $this->language_model->createNewLanguage();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/manage_language', 'refresh');
        }

        if($param1 == 'add_phrase'){
            $this->language_model->createNewLanguagePhrase();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/manage_language', 'refresh');
        }

        if($param1 == 'delete_language'){
            $this->language_model->deleteLanguage($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/manage_language', 'refresh');
        }

        $page_data['page_name']     = 'manage_language';
        $page_data['page_title']    = get_phrase('Manage Language');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school language ends here ***********************/

    function updatePhraseWithAjax(){

        $checker['phrase_id']   =   $this->input->post('phraseId');
        $updater[$this->input->post('currentEditingLanguage')]  =   $this->input->post('updatedValue');

        $this->db->where('phrase_id', $checker['phrase_id'] );
        $this->db->update('language', $updater);

        echo $checker['phrase_id']. ' '. $this->input->post('currentEditingLanguage'). ' '. $this->input->post('updatedValue');

    }


    /***********  The function below manages school marks ***********************/
    function marks ($exam_id = null, $class_id = null, $student_id = null){

            if($this->input->post('operation') == 'selection'){

                $page_data['exam_id']       =  $this->input->post('exam_id'); 
                $page_data['class_id']      =  $this->input->post('class_id');
                $page_data['student_id']    =  $this->input->post('student_id');

                if($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['student_id'] > 0){

                    redirect(base_url(). 'admin/marks/'. $page_data['exam_id'] .'/' . $page_data['class_id'] . '/' . $page_data['student_id'], 'refresh');
                }
                else{
                    $this->session->set_flashdata('error_message', get_phrase('Pleasen select something'));
                    redirect(base_url(). 'admin/marks', 'refresh');
                }
            }

            if($this->input->post('operation') == 'update_student_subject_score'){

                $select_subject_first = $this->db->get_where('subject', array('class_id' => $class_id ))->result_array();
                
                foreach ($select_subject_first as $key => $subject){
                    $subject_id = $subject['subject_id'];
                    $total_marks = 0;
                    $max_total = 0;

                    // Get components for this subject
                    $components = $this->db->get_where('exam_components', ['subject_id' => $subject_id])->result_array();
                    if (empty($components)) {
                        $this->db->insert_batch('exam_components', [
                            ['subject_id' => $subject_id, 'component_name' => 'PT', 'max_marks' => 10],
                            ['subject_id' => $subject_id, 'component_name' => 'NOTEBOOK', 'max_marks' => 5],
                            ['subject_id' => $subject_id, 'component_name' => 'ENRICHMENT', 'max_marks' => 5],
                            ['subject_id' => $subject_id, 'component_name' => 'WRITTEN', 'max_marks' => 80]
                        ]);
                        $components = $this->db->get_where('exam_components', ['subject_id' => $subject_id])->result_array();
                    }

                    foreach ($components as $comp) {
                        $comp_name = $comp['component_name'];
                        if ($this->input->post('mark_' . $subject_id . '_' . $comp_name) !== null) {
                            $obtained = $this->input->post('mark_' . $subject_id . '_' . $comp_name);
                            
                            $total_marks += (float) $obtained;
                            $max_total += (float) $comp['max_marks'];

                            $where = [
                                'student_id' => $student_id,
                                'subject_id' => $subject_id,
                                'exam_id' => $exam_id,
                                'class_id' => $class_id,
                                'component_type' => $comp_name
                            ];
                            $q = $this->db->get_where('mark', $where);
                            if ($q->num_rows() > 0) {
                                $this->db->where('id', $q->row()->id);
                                $this->db->update('mark', ['marks_obtained' => $obtained, 'max_marks' => $comp['max_marks']]);
                            } else {
                                $where['marks_obtained'] = $obtained;
                                $where['max_marks'] = $comp['max_marks'];
                                $this->db->insert('mark', $where);
                            }
                        }
                    }
                    
                    // Remarks
                    $comment = $this->input->post('comment_' . $subject_id);
                    if ($comment) {
                        $rq = $this->db->get_where('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                        if ($rq->num_rows() > 0) {
                            $this->db->update('exam_remarks', ['text' => $comment], ['id' => $rq->row()->id]);
                        } else {
                            $this->db->insert('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id, 'teacher_id' => $this->session->userdata('login_user_id'), 'text' => $comment]);
                        }
                    }
                    
                    // Result Aggregate Base
                    $res_q = $this->db->get_where('exam_results', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                    if ($res_q->num_rows() == 0) {
                        $this->db->insert('exam_results', ['student_id' => $student_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'total_marks' => 0, 'percentage' => 0]);
                    }
                }

                $this->session->set_flashdata('flash_message', get_phrase('Data Updated Successfully'));
                redirect(base_url(). 'admin/marks/'. $this->input->post('exam_id') .'/' . $this->input->post('class_id') . '/' . $this->input->post('student_id'), 'refresh');
            }

        $page_data['exam_id']       =   $exam_id;
        $page_data['class_id']      =   $class_id;
        $page_data['student_id']    =   $student_id;
        $page_data['subject_id']   =    $subject_id;
        $page_data['page_name']     =   'marks';
        $page_data['page_title']    = get_phrase('Student Marks');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school marks ends here ***********************/



    /***********  The function below manages school marks ***********************/
     function student_marksheet_subject ($exam_id = null, $class_id = null, $subject_id = null, $pattern = 80){

        if($this->input->post('operation') == 'selection'){

            $page_data['exam_id']       =  $this->input->post('exam_id'); 
            $page_data['class_id']      =  $this->input->post('class_id');
            $page_data['subject_id']    =  $this->input->post('subject_id');
            $patt                       =  $this->input->post('pattern') ? $this->input->post('pattern') : 80;

            if($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0){

                redirect(base_url(). 'admin/student_marksheet_subject/'. $page_data['exam_id'] .'/' . $page_data['class_id'] . '/' . $page_data['subject_id'] . '/' . $patt, 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('Pleasen select something'));
                redirect(base_url(). 'admin/student_marksheet_subject', 'refresh');
            }
        }

        if($this->input->post('operation') == 'update_student_subject_score'){

            $select_student_first = $this->db->get_where('student', array('class_id' => $class_id ))->result_array();
            
            // Get components for this subject
            if ($pattern == 50 || $pattern == 100) {
                // State Board Mode
                $components = [['component_name' => 'WRITTEN', 'max_marks' => $pattern]];
            } else {
                // CBSE Mode
                $components = $this->db->get_where('exam_components', ['subject_id' => $subject_id])->result_array();
                if (empty($components)) {
                    $this->db->insert_batch('exam_components', [
                        ['subject_id' => $subject_id, 'component_name' => 'PT', 'max_marks' => 10],
                        ['subject_id' => $subject_id, 'component_name' => 'NOTEBOOK', 'max_marks' => 5],
                        ['subject_id' => $subject_id, 'component_name' => 'ENRICHMENT', 'max_marks' => 5],
                        ['subject_id' => $subject_id, 'component_name' => 'WRITTEN', 'max_marks' => 80]
                    ]);
                    $components = $this->db->get_where('exam_components', ['subject_id' => $subject_id])->result_array();
                }
            }

            foreach ($select_student_first as $key => $student){
                $student_id = $student['student_id'];
                $total_marks = 0;
                $max_total = 0;

                // Process each component for this student
                foreach ($components as $comp) {
                    $comp_name = $comp['component_name'];
                    // The HTML input name will be like: mark_15_PT
                    if ($this->input->post('mark_' . $student_id . '_' . $comp_name) !== null) {
                        $obtained = $this->input->post('mark_' . $student_id . '_' . $comp_name);
                        
                        $total_marks += (float) $obtained;
                        $max_total += (float) $comp['max_marks'];

                        // Check if record exists
                        $where = [
                            'student_id' => $student_id,
                            'subject_id' => $subject_id,
                            'exam_id' => $exam_id,
                            'class_id' => $class_id,
                            'component_type' => $comp_name
                        ];
                        $q = $this->db->get_where('mark', $where);
                        if ($q->num_rows() > 0) {
                            $this->db->where('id', $q->row()->id);
                            $this->db->update('mark', ['marks_obtained' => $obtained, 'max_marks' => $comp['max_marks']]);
                        } else {
                            $where['marks_obtained'] = $obtained;
                            $where['max_marks'] = $comp['max_marks'];
                            $this->db->insert('mark', $where);
                        }
                    }
                }
                
                // Remarks processing
                $comment = $this->input->post('comment_' . $student_id);
                if ($comment) {
                    $rq = $this->db->get_where('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                    if ($rq->num_rows() > 0) {
                        $this->db->update('exam_remarks', ['text' => $comment], ['id' => $rq->row()->id]);
                    } else {
                        $this->db->insert('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id, 'teacher_id' => $this->session->userdata('login_user_id'), 'text' => $comment]);
                    }
                }

                // Update Result Aggregate for this exam (we total all subject totals later, but for now we aggregate the full exams)
                // We'll calculate the final grade globally during report card generation, but let's record a base results row if it doesn't exist
                $res_q = $this->db->get_where('exam_results', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                if ($res_q->num_rows() == 0) {
                    $this->db->insert('exam_results', ['student_id' => $student_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'total_marks' => 0, 'percentage' => 0]);
                }
            }

            $this->session->set_flashdata('flash_message', get_phrase('Data Updated Successfully'));
            redirect(base_url(). 'admin/student_marksheet_subject/'. $exam_id .'/' . $class_id . '/' . $subject_id . '/' . $pattern, 'refresh');
        }

    $page_data['exam_id']       =   $exam_id;
    $page_data['class_id']      =   $class_id;
    $page_data['student_id']    =   $student_id;
    $page_data['subject_id']    =   $subject_id;
    $page_data['pattern']       =   $pattern;
    $page_data['page_name']     =   'student_marksheet_subject';
    $page_data['page_title']    =   get_phrase('Student Marks');
    $this->load->view('backend/index', $page_data);
    }
    
    // Grading Engine
    private function get_grade($total, $max = 100) {
        $percentage = ($total / $max) * 100;
        if ($percentage >= 91) return "A1";
        if ($percentage >= 81) return "A2";
        if ($percentage >= 71) return "B1";
        if ($percentage >= 61) return "B2";
        if ($percentage >= 51) return "C1";
        if ($percentage >= 41) return "C2";
        if ($percentage >= 33) return "D";
        return "E";
    }

    // Individual Marksheet View
    function marksheet_view($exam_id = null, $class_id = null, $student_id = null) {
        
        if ($this->input->post('operation') == 'selection') {
            $exam_id    = $this->input->post('exam_id');
            $class_id   = $this->input->post('class_id');
            $student_id = $this->input->post('student_id');

            if ($exam_id > 0 && $class_id > 0 && $student_id > 0) {
                redirect(base_url() . 'admin/marksheet_view/' . $exam_id . '/' . $class_id . '/' . $student_id, 'refresh');
            } else {
                $this->session->set_flashdata('error_message', get_phrase('Please select all fields'));
                redirect(base_url() . 'admin/marksheet_view', 'refresh');
            }
        }

        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['student_id'] = $student_id;
        $page_data['page_name']  = 'marksheet_view';
        $page_data['page_title'] = get_phrase('Individual Marksheet');
        $this->load->view('backend/index', $page_data);
    }

    // CBSE Style Report Card Print
    public function print_report_card($student_id, $exam_id) {
        $this->load->database();
        $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
        $class_id = $student['class_id'];
        
        $page_data['student'] = $student;
        $page_data['exam'] = $this->db->get_where('exam', ['exam_id' => $exam_id])->row_array();
        $page_data['class'] = $this->db->get_where('class', ['class_id' => $class_id])->row_array();
        $page_data['section'] = $this->db->get_where('section', ['section_id' => $student['section_id']])->row_array();
        
        // Fetch subjects
        $subjects = $this->db->get_where('subject', ['class_id' => $class_id])->result_array();
        $marks_data = [];
        $grand_total = 0;
        $grand_max = 0;
        
        foreach($subjects as $sub) {
            $subj_id = $sub['subject_id'];
            $components = $this->db->get_where('exam_components', ['subject_id' => $subj_id])->result_array();
            if(empty($components)) continue;
            
            $sub_total = 0;
            $sub_max = 0;
            $comp_marks = [];
            foreach($components as $comp) {
                $q = $this->db->get_where('mark', ['student_id' => $student_id, 'exam_id' => $exam_id, 'subject_id' => $subj_id, 'component_type' => $comp['component_name']]);
                if($q->num_rows() > 0) {
                    $obtained = (float)$q->row()->marks_obtained;
                    $comp_marks[$comp['component_name']] = $obtained;
                    $sub_total += $obtained;
                } else {
                    $comp_marks[$comp['component_name']] = '-';
                }
                $sub_max += (float)$comp['max_marks'];
            }
            $grade = $this->get_grade($sub_total, $sub_max);
            $marks_data[] = [
                'subject' => $sub['name'],
                'components' => $comp_marks,
                'total' => $sub_total,
                'max' => $sub_max,
                'grade' => $grade
            ];
            $grand_total += $sub_total;
            $grand_max += $sub_max;
        }

        // Remarks
        $rem_q = $this->db->get_where('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
        $page_data['remarks'] = ($rem_q->num_rows() > 0) ? $rem_q->row()->text : '';
        
        // Update Aggregate results
        if ($grand_max > 0) {
            $percentage = ($grand_total / $grand_max) * 100;
            $overall_grade = $this->get_grade($grand_total, $grand_max);
            
            $res_where = ['student_id' => $student_id, 'exam_id' => $exam_id];
            $res_q = $this->db->get_where('exam_results', $res_where);
            $update_data = [
                'total_marks' => $grand_total,
                'percentage' => $percentage,
                'grade' => $overall_grade,
                'class_id' => $class_id
            ];
            if ($res_q->num_rows() > 0) {
                $this->db->update('exam_results', $update_data, ['id' => $res_q->row()->id]);
            } else {
                $update_data['student_id'] = $student_id;
                $update_data['exam_id'] = $exam_id;
                $this->db->insert('exam_results', $update_data);
            }
            
            $page_data['total_marks'] = $grand_total;
            $page_data['percentage'] = $percentage;
            $page_data['overall_grade'] = $overall_grade;
        } else {
            $page_data['total_marks'] = 0;
            $page_data['percentage'] = 0;
            $page_data['overall_grade'] = '-';
        }
        
        // Ranking Data Calculation
        $this->db->order_by('percentage', 'DESC');
        $all_results = $this->db->get_where('exam_results', ['exam_id' => $exam_id, 'class_id' => $class_id])->result_array();
        $rank = 1;
        $student_rank = '-';
        foreach($all_results as $res) {
            if ($res['student_id'] == $student_id) {
                $student_rank = $rank;
                break;
            }
            $rank++;
        }
        $page_data['class_rank'] = $student_rank;

        $page_data['marks_data'] = $marks_data;
        $page_data['page_title']    = 'Print Report Card';
        $this->load->view('backend/admin/print_report_card', $page_data);
    }
    /***********  The function that manages school marks ends here ***********************/



    
    /***********  The function below manages new admin ***********************/
    function newAdministrator ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->admin_model->createNewAdministrator();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/newAdministrator', 'refresh');
        }

        if($param1 == 'update'){
            $this->admin_model->updateAdministrator($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/newAdministrator', 'refresh');
        }

        if($param1 == 'delete'){
            $this->admin_model->deleteAdministrator($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/newAdministrator', 'refresh');
        }

        $page_data['page_name']     = 'newAdministrator';
        $page_data['page_title']    = get_phrase('New Administrator');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages administrator ends here ***********************/

    function updateAdminRole($param2){
        $this->admin_model->updateAllDetailsForAdminRole($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/newAdministrator', 'refresh');
    }


    /************** Co-Scholastic Grades Module ********************/
    function co_scholastic($exam_id = '', $class_id = '') {
        // Auto-migrate table if needed
        $sql = "CREATE TABLE IF NOT EXISTS `co_scholastic_marks` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `student_id` int(11) NOT NULL,
          `exam_id` int(11) NOT NULL,
          `class_id` int(11) NOT NULL,
          `art_grade` varchar(5) NOT NULL DEFAULT '-',
          `pe_grade` varchar(5) NOT NULL DEFAULT '-',
          `work_grade` varchar(5) NOT NULL DEFAULT '-',
          `discipline_grade` varchar(5) NOT NULL DEFAULT '-',
          `conduct_grade` varchar(5) NOT NULL DEFAULT '-',
          `remarks` text NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);

        // Handle POST form saving
        if ($this->input->post('operation') == 'update') {
            $students = $this->db->get_where('student', ['class_id' => $class_id])->result_array();
            foreach ($students as $student) {
                $sid = $student['student_id'];
                
                $data = [
                    'student_id' => $sid,
                    'exam_id' => $exam_id,
                    'class_id' => $class_id,
                    'art_grade' => $this->input->post('art_grade_' . $sid),
                    'pe_grade' => $this->input->post('pe_grade_' . $sid),
                    'work_grade' => $this->input->post('work_grade_' . $sid),
                    'discipline_grade' => $this->input->post('discipline_grade_' . $sid),
                    'conduct_grade' => $this->input->post('conduct_grade_' . $sid)
                ];

                // Check if exists
                $q = $this->db->get_where('co_scholastic_marks', ['student_id' => $sid, 'exam_id' => $exam_id]);
                if ($q->num_rows() > 0) {
                    $this->db->update('co_scholastic_marks', $data, ['id' => $q->row()->id]);
                } else {
                    $this->db->insert('co_scholastic_marks', $data);
                }
            }
            $this->session->set_flashdata('flash_message', get_phrase('Grades Updated Successfully'));
            redirect(base_url() . 'admin/co_scholastic/' . $exam_id . '/' . $class_id, 'refresh');
        }

        // Selection
        if ($this->input->post('operation') == 'selection') {
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            if ($exam_id > 0 && $class_id > 0) {
                redirect(base_url() . 'admin/co_scholastic/' . $exam_id . '/' . $class_id, 'refresh');
            } else {
                $this->session->set_flashdata('error_message', 'Please select both Exam and Class');
                redirect(base_url() . 'admin/co_scholastic', 'refresh');
            }
        }

        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['page_info']  = 'Manage Co-Scholastic grades';
        $page_data['page_name']  = 'co_scholastic';
        $page_data['page_title'] = 'Co-Scholastic Grades';
        $this->load->view('backend/index', $page_data);
    }

    /************** RFID AJAX Helpers ********************/
    function get_rfid_students() {
        $students = $this->db->get('student')->result_array();
        foreach ($students as $student) {
            $class_name = $this->crud_model->get_class_name($student['class_id']);
            echo '<option value="' . $student['student_id'] . '">' . $student['name'] . ' (' . $class_name . ')</option>';
        }
    }

    function get_rfid_teachers() {
        $teachers = $this->db->get('teacher')->result_array();
        foreach ($teachers as $teacher) {
            echo '<option value="' . $teacher['teacher_id'] . '">' . $teacher['name'] . '</option>';
        }
    }

    // ============================================
    // ENTERPRISE ROLE & USER MANAGEMENT
    // ============================================

    function manage_users($param1 = '', $param2 = '') {
        
        if ($param1 == 'create') {
            $name     = html_escape($this->input->post('name'));
            $email    = html_escape($this->input->post('email'));
            $phone    = html_escape($this->input->post('phone'));
            $password = $this->input->post('password');
            $role_id  = html_escape($this->input->post('role_id'));

            $data = array(
                'tenant_id'     => 1,
                'role_id'       => $role_id,
                'name'          => $name,
                'email'         => $email,
                'phone'         => $phone,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'login_status'  => 0,
            );
            $this->db->insert('users', $data);

            $this->load->model('audit_model');
            $this->audit_model->log('Created new user: ' . $name . ' (role_id: ' . $role_id . ')', 'system');
            $this->session->set_flashdata('flash_message', get_phrase('User created successfully'));
            redirect(base_url() . 'admin/manage_users', 'refresh');
        }

        if ($param1 == 'update') {
            $data = array(
                'name'    => html_escape($this->input->post('name')),
                'email'   => html_escape($this->input->post('email')),
                'phone'   => html_escape($this->input->post('phone')),
                'role_id' => html_escape($this->input->post('role_id')),
            );
            $this->db->where('user_id', $param2);
            $this->db->update('users', $data);

            $this->load->model('audit_model');
            $this->audit_model->log('Updated user #' . $param2, 'system');
            $this->session->set_flashdata('flash_message', get_phrase('User updated successfully'));
            redirect(base_url() . 'admin/manage_users', 'refresh');
        }

        if ($param1 == 'change_password') {
            $new_password = $this->input->post('password');
            $this->db->where('user_id', $param2);
            $this->db->update('users', array(
                'password_hash'  => password_hash($new_password, PASSWORD_BCRYPT),
                'failed_attempts' => 0,
                'is_locked'      => 0,
                'locked_until'   => null,
            ));

            $this->load->model('audit_model');
            $this->audit_model->log('Changed password for user #' . $param2, 'system');
            $this->session->set_flashdata('flash_message', get_phrase('Password changed successfully'));
            redirect(base_url() . 'admin/manage_users', 'refresh');
        }

        if ($param1 == 'delete') {
            $user = $this->db->get_where('users', array('user_id' => $param2))->row();
            $this->db->where('user_id', $param2);
            $this->db->delete('users');

            $this->load->model('audit_model');
            $this->audit_model->log('Deleted user: ' . ($user ? $user->name : '#' . $param2), 'system');
            $this->session->set_flashdata('flash_message', get_phrase('User deleted'));
            redirect(base_url() . 'admin/manage_users', 'refresh');
        }

        if ($param1 == 'unlock') {
            $this->db->where('user_id', $param2);
            $this->db->update('users', array('is_locked' => 0, 'failed_attempts' => 0, 'locked_until' => null));
            $this->session->set_flashdata('flash_message', get_phrase('Account unlocked'));
            redirect(base_url() . 'admin/manage_users', 'refresh');
        }

        // List view
        $page_data['users'] = $this->db->select('u.*, r.name as role_name')
            ->from('users u')
            ->join('roles r', 'u.role_id = r.role_id')
            ->order_by('u.user_id', 'asc')
            ->get()->result_array();
        $page_data['roles'] = $this->db->get('roles')->result_array();
        $page_data['page_name']  = 'manage_users';
        $page_data['page_title'] = 'Manage Staff & Roles';
        $this->load->view('backend/index', $page_data);
    }

    function audit_logs() {
        $filters = array(
            'user_id'   => $this->input->get('user_id'),
            'module'    => $this->input->get('module'),
            'date_from' => $this->input->get('date_from'),
            'date_to'   => $this->input->get('date_to'),
        );
        $this->load->model('audit_model');
        $page_data['logs']       = $this->audit_model->get_logs($filters, 200);
        $page_data['filters']    = $filters;
        $page_data['page_name']  = 'audit_logs';
        $page_data['page_title'] = 'Audit Logs';
        $this->load->view('backend/index', $page_data);
    }
    /* =========================================
     * ENTERPRISE PAYROLL MODULE
     * ========================================= */

    function payroll() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        // Auto-migrate tables
        $this->db->query("CREATE TABLE IF NOT EXISTS `payroll` (
            `payroll_id` int(11) NOT NULL AUTO_INCREMENT,
            `employee_id` int(11) NOT NULL,
            `month` int(11) NOT NULL,
            `year` int(11) NOT NULL,
            `basic_salary` decimal(10,2) NOT NULL DEFAULT '0.00',
            `allowances` decimal(10,2) NOT NULL DEFAULT '0.00',
            `deductions` decimal(10,2) NOT NULL DEFAULT '0.00',
            `net_salary` decimal(10,2) NOT NULL DEFAULT '0.00',
            `status` int(11) NOT NULL DEFAULT '0',
            `payslip_no` varchar(50) DEFAULT NULL,
            `payment_method` varchar(50) DEFAULT NULL,
            `payment_date` datetime DEFAULT NULL,
            `transaction_reference` varchar(100) DEFAULT NULL,
            `is_locked` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`payroll_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `salary_structures` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `employee_id` int(11) NOT NULL,
            `basic` decimal(10,2) NOT NULL DEFAULT '0.00',
            `hra` decimal(10,2) DEFAULT '0.00',
            `pf` decimal(10,2) DEFAULT '0.00',
            `esi` decimal(10,2) DEFAULT '0.00',
            `tax` decimal(10,2) DEFAULT '0.00',
            `pt` decimal(10,2) DEFAULT '0.00',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `payroll_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `payroll_id` int(11) NOT NULL,
            `type` enum('allowance','deduction') NOT NULL,
            `name` varchar(100) NOT NULL,
            `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `payment_ledger` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `payroll_id` int(11) NOT NULL,
            `amount` decimal(10,2) NOT NULL,
            `method` varchar(50) NOT NULL,
            `status` varchar(20) NOT NULL,
            `transaction_ref` varchar(100) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `payroll_audit_logs` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `payroll_id` int(11) NOT NULL,
            `action` varchar(255) NOT NULL,
            `performed_by` int(11) NOT NULL,
            `timestamp` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $page_data['page_name']  = 'hrms/payroll_list';
        $page_data['page_title'] = 'Payroll & Salaries';
        
        $month = $this->input->post('month') ? $this->input->post('month') : date('m');
        $year = $this->input->post('year') ? $this->input->post('year') : date('Y');
        
        $page_data['selected_month'] = $month;
        $page_data['selected_year'] = $year;
        
        $this->load->view('backend/index', $page_data);
    }

    function payroll_bulk_generate() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        
        $this->load->model('payroll_model');
        $count = $this->payroll_model->create_payroll_bulk($month, $year);
        
        if ($count > 0) {
            $this->session->set_flashdata('flash_message', "$count Payslips Generated Successfully for $month/$year");
        } else {
            $this->session->set_flashdata('error_message', "No new payslips were generated. They might already exist.");
        }
        
        redirect(base_url() . 'admin/payroll', 'refresh');
    }

    function pay_salary_single() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $payroll_id = $this->input->post('payroll_id');
        $amount = $this->input->post('amount');
        $method = $this->input->post('method');
        $ref = $this->input->post('transaction_ref');
        
        $this->load->model('payroll_model');
        if ($this->payroll_model->pay_salary($payroll_id, $amount, $method, $ref)) {
            $this->session->set_flashdata('flash_message', "Salary marked as PAID successfully.");
        } else {
            $this->session->set_flashdata('error_message', "Failed to process payment. Record might be locked.");
        }
        
        redirect(base_url() . 'admin/payroll', 'refresh');
    }

    // ==========================================
    // HRMS MODULE
    // ==========================================
    
    function employee_profile($teacher_id) {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $page_data['teacher_id'] = $teacher_id;
        $page_data['page_name']  = 'hrms/employee_profile';
        $page_data['page_title'] = 'Employee Profile';
        $this->load->view('backend/index', $page_data);
    }

    function hr_dashboard() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $page_data['page_name']  = 'hrms/hr_dashboard';
        $page_data['page_title'] = 'HR Dashboard';
        $this->load->view('backend/index', $page_data);
    }

    function leave_management() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $page_data['page_name']  = 'hrms/leave_management';
        $page_data['page_title'] = 'Leave Management';
        $this->load->view('backend/index', $page_data);
    }

    function setup_leave_table() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $sql = "CREATE TABLE IF NOT EXISTS `leave_requests` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `employee_id` int(11) NOT NULL,
          `leave_type` varchar(100) NOT NULL,
          `from_date` date NOT NULL,
          `to_date` date NOT NULL,
          `reason` text NOT NULL,
          `status` varchar(20) NOT NULL DEFAULT 'pending',
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        $this->db->query($sql);
        $this->session->set_flashdata('flash_message', 'Leave Management table setup successfully.');
        redirect(base_url() . 'admin/leave_management', 'refresh');
    }

    function add_leave_request() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $data['employee_id'] = $this->input->post('employee_id');
        $data['leave_type'] = $this->input->post('leave_type');
        $data['from_date'] = $this->input->post('from_date');
        $data['to_date'] = $this->input->post('to_date');
        $data['reason'] = $this->input->post('reason');
        $data['status'] = 'pending';
        
        $this->db->insert('leave_requests', $data);
        $this->session->set_flashdata('flash_message', 'Leave request submitted successfully.');
        redirect(base_url() . 'admin/leave_management', 'refresh');
    }

    function approve_leave($id) {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $this->db->where('id', $id);
        $this->db->update('leave_requests', array('status' => 'approved'));
        $this->session->set_flashdata('flash_message', 'Leave request approved.');
        redirect(base_url() . 'admin/leave_management', 'refresh');
    }

    function reject_leave($id) {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        
        $this->db->where('id', $id);
        $this->db->update('leave_requests', array('status' => 'rejected'));
        $this->session->set_flashdata('flash_message', 'Leave request rejected.');
        redirect(base_url() . 'admin/leave_management', 'refresh');
    }


    /************** FEATURE 1: LIBRARY MANAGEMENT ********************/
    function library($param1 = '', $param2 = '') {
        // Auto-migrate tables
        $this->db->query("CREATE TABLE IF NOT EXISTS `library` (
            `book_id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `author` varchar(255) DEFAULT '',
            `isbn` varchar(50) DEFAULT '',
            `category` varchar(100) DEFAULT 'General',
            `quantity` int(11) NOT NULL DEFAULT 1,
            `available` int(11) NOT NULL DEFAULT 1,
            `rack_number` varchar(50) DEFAULT '',
            `added_date` date DEFAULT NULL,
            PRIMARY KEY (`book_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `book_issue` (
            `issue_id` int(11) NOT NULL AUTO_INCREMENT,
            `book_id` int(11) NOT NULL,
            `student_id` int(11) NOT NULL,
            `issue_date` date NOT NULL,
            `due_date` date NOT NULL,
            `return_date` date DEFAULT NULL,
            `status` varchar(20) NOT NULL DEFAULT 'issued',
            `fine` decimal(10,2) DEFAULT 0.00,
            PRIMARY KEY (`issue_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        // Add Book
        if ($param1 == 'add') {
            $data = [
                'title' => $this->input->post('title'),
                'author' => $this->input->post('author'),
                'isbn' => $this->input->post('isbn'),
                'category' => $this->input->post('category'),
                'quantity' => $this->input->post('quantity'),
                'available' => $this->input->post('quantity'),
                'rack_number' => $this->input->post('rack_number'),
                'added_date' => date('Y-m-d')
            ];
            $this->db->insert('library', $data);
            $this->session->set_flashdata('flash_message', 'Book added successfully.');
            redirect(base_url() . 'admin/library', 'refresh');
        }

        // Delete Book
        if ($param1 == 'delete') {
            $this->db->delete('library', ['book_id' => $param2]);
            $this->session->set_flashdata('flash_message', 'Book removed.');
            redirect(base_url() . 'admin/library', 'refresh');
        }

        $page_data['page_name']  = 'library';
        $page_data['page_title'] = 'Library Management';
        $this->load->view('backend/index', $page_data);
    }

    function issue_book() {
        $book_id = $this->input->post('book_id');
        $student_id = $this->input->post('student_id');
        $due_date = $this->input->post('due_date');
        
        $data = [
            'book_id' => $book_id,
            'student_id' => $student_id,
            'issue_date' => date('Y-m-d'),
            'due_date' => $due_date,
            'status' => 'issued'
        ];
        $this->db->insert('book_issue', $data);
        
        // Decrease available count
        $this->db->set('available', 'available - 1', FALSE);
        $this->db->where('book_id', $book_id);
        $this->db->update('library');
        
        $this->session->set_flashdata('flash_message', 'Book issued successfully.');
        redirect(base_url() . 'admin/library', 'refresh');
    }

    function return_book($issue_id) {
        $issue = $this->db->get_where('book_issue', ['issue_id' => $issue_id])->row();
        if ($issue) {
            // Calculate fine: ₹2 per day overdue
            $fine = 0;
            $today = date('Y-m-d');
            if ($today > $issue->due_date) {
                $diff = (strtotime($today) - strtotime($issue->due_date)) / 86400;
                $fine = $diff * 2;
            }
            $this->db->update('book_issue', ['status' => 'returned', 'return_date' => $today, 'fine' => $fine], ['issue_id' => $issue_id]);
            
            // Increase available count
            $this->db->set('available', 'available + 1', FALSE);
            $this->db->where('book_id', $issue->book_id);
            $this->db->update('library');
        }
        $this->session->set_flashdata('flash_message', 'Book returned successfully.');
        redirect(base_url() . 'admin/library', 'refresh');
    }


    /************** FEATURE 2: STUDENT PROMOTION ********************/
    function student_promotion() {
        if ($this->input->post('operation') == 'promote') {
            $from_class = $this->input->post('from_class');
            $to_class = $this->input->post('to_class');
            $new_session = $this->input->post('new_session');
            $student_ids = $this->input->post('student_ids');
            
            if (!empty($student_ids) && is_array($student_ids)) {
                $update_data = ['class_id' => $to_class];
                if (!empty($new_session)) {
                    $update_data['session'] = $new_session;
                }
                foreach ($student_ids as $sid) {
                    $this->db->update('student', $update_data, ['student_id' => $sid]);
                }
                $this->session->set_flashdata('flash_message', count($student_ids) . ' students promoted successfully!');
            } else {
                $this->session->set_flashdata('error_message', 'No students selected.');
            }
            redirect(base_url() . 'admin/student_promotion', 'refresh');
        }

        // Mark completed: if operation is mark_status
        if ($this->input->post('operation') == 'mark_status') {
            $student_ids = $this->input->post('student_ids');
            $new_status = $this->input->post('new_status');
            if (!empty($student_ids) && is_array($student_ids) && in_array($new_status, ['active','left','completed'])) {
                foreach ($student_ids as $sid) {
                    $this->db->update('student', ['student_status' => $new_status], ['student_id' => $sid]);
                }
                $this->session->set_flashdata('flash_message', count($student_ids) . ' students marked as ' . ucfirst($new_status) . '!');
            }
            redirect(base_url() . 'admin/student_promotion', 'refresh');
        }

        $page_data['page_name']  = 'student_promotion';
        $page_data['page_title'] = 'Student Promotion';
        $this->load->view('backend/index', $page_data);
    }

    function get_students_by_class($class_id) {
        // Only return active students for promotion
        $this->db->where('class_id', $class_id);
        $students = $this->db->get('student')->result_array();
        echo json_encode($students);
    }


    /************** FEATURE 3: ALUMNI MANAGEMENT (FIX) ********************/
    function alumni($param1 = null, $param2 = null) {
        if ($param1 == 'insert') {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'sex' => $this->input->post('sex'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'profession' => $this->input->post('profession'),
                'g_year' => $this->input->post('g_year'),
                'club_id' => $this->input->post('club_id'),
                'interest' => $this->input->post('interest')
            ];
            $this->db->insert('alumni', $data);
            
            // Upload image
            $alumni_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/alumni_image/' . $alumni_id . '.jpg');
            
            $this->session->set_flashdata('flash_message', 'Alumni added successfully.');
            redirect(base_url() . 'admin/alumni', 'refresh');
        }

        if ($param1 == 'update') {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'sex' => $this->input->post('sex'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'profession' => $this->input->post('profession'),
                'g_year' => $this->input->post('g_year'),
                'club_id' => $this->input->post('club_id'),
                'interest' => $this->input->post('interest')
            ];
            $this->db->update('alumni', $data, ['alumni_id' => $param2]);
            
            if ($_FILES['userfile']['tmp_name'] != '') {
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/alumni_image/' . $param2 . '.jpg');
            }
            
            $this->session->set_flashdata('flash_message', 'Alumni updated.');
            redirect(base_url() . 'admin/alumni', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->delete('alumni', ['alumni_id' => $param2]);
            $this->session->set_flashdata('flash_message', 'Alumni removed.');
            redirect(base_url() . 'admin/alumni', 'refresh');
        }

        $page_data['select_alumni'] = $this->db->get('alumni')->result_array();
        $page_data['page_name']  = 'alumni';
        $page_data['page_title'] = 'Alumni Management';
        $this->load->view('backend/index', $page_data);
    }


    /************** FEATURE 5: BULK REPORT CARD PRINTING ********************/
    function bulk_print_report_card($exam_id, $class_id) {
        $students = $this->db->get_where('student', ['class_id' => $class_id])->result_array();
        $class = $this->db->get_where('class', ['class_id' => $class_id])->row_array();
        $exam = $this->db->get_where('exam', ['exam_id' => $exam_id])->row_array();
        
        $page_data['students'] = $students;
        $page_data['class'] = $class;
        $page_data['exam'] = $exam;
        $page_data['exam_id'] = $exam_id;
        $page_data['class_id'] = $class_id;
        $page_data['page_name'] = 'bulk_print_report_card';
        $page_data['page_title'] = 'Bulk Report Cards';
        $this->load->view('backend/index', $page_data);
    }

}
