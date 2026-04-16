<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Student_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }



    // The function below insert into student house //
    function createStudentHouse(){

        $page_data = array(
            'name'          => html_escape($this->input->post('name')),
            'description'      => html_escape($this->input->post('description'))
	    );

        $this->db->insert('house', $page_data);
    }

// The function below update student house //
    function updateStudentHouse($param2){
        $page_data = array(
            'name'         => html_escape($this->input->post('name')),
            'description'  => html_escape($this->input->post('description'))
	    );

        $this->db->where('house_id', $param2);
        $this->db->update('house', $page_data);
    }

    // The function below delete from student house table //
    function deleteStudentHouse($param2){
        $this->db->where('house_id', $param2);
        $this->db->delete('house');
    }



    // The function below insert into student category //
    function createstudentCategory(){

        $page_data = array(
            'name'        => html_escape($this->input->post('name')),
            'description' => html_escape($this->input->post('description'))
	    );
        $this->db->insert('student_category', $page_data);
    }

// The function below update student category //
    function updatestudentCategory($param2){
        $page_data = array(
            'name'        => html_escape($this->input->post('name')),
            'description' => html_escape($this->input->post('description'))
	    );

        $this->db->where('student_category_id', $param2);
        $this->db->update('student_category', $page_data);
    }

    // The function below delete from student category table //
    function deletestudentCategory($param2){
        $this->db->where('student_category_id', $param2);
        $this->db->delete('student_category');
    }




    //  the function below insert into student table
    function createNewStudent(){

        // Handle inline parent creation
        $parent_id = $this->input->post('parent_id');
        if ($parent_id == 'new') {
            $parent_data = array(
                'name'          => html_escape($this->input->post('father_name')),
                'email'         => html_escape($this->input->post('parent_email')),
                'phone'         => html_escape($this->input->post('father_phone')),
                'password'      => sha1($this->input->post('parent_password') ?: '123456'),
                'address'       => html_escape($this->input->post('address')),
                'father_name'   => html_escape($this->input->post('father_name')),
                'father_phone'  => html_escape($this->input->post('father_phone')),
                'father_email'  => html_escape($this->input->post('father_email')),
                'father_occupation'    => html_escape($this->input->post('father_occupation')),
                'father_aadhaar'       => html_escape($this->input->post('father_aadhaar')),
                'father_qualification' => html_escape($this->input->post('father_qualification')),
                'father_annual_income' => html_escape($this->input->post('father_annual_income')),
                'mother_name'   => html_escape($this->input->post('mother_name')),
                'mother_phone'  => html_escape($this->input->post('mother_phone')),
                'mother_email'  => html_escape($this->input->post('mother_email')),
                'mother_occupation'    => html_escape($this->input->post('mother_occupation')),
                'mother_aadhaar'       => html_escape($this->input->post('mother_aadhaar')),
                'mother_qualification' => html_escape($this->input->post('mother_qualification')),
            );
            $this->db->insert('parent', $parent_data);
            $parent_id = $this->db->insert_id();
        }

        $page_data = array(
            'name'          => html_escape($this->input->post('name')),
            'birthday'      => html_escape($this->input->post('birthday')),
            'age'           => html_escape($this->input->post('age')),
            'place_birth'   => html_escape($this->input->post('place_birth')),
            'sex'           => html_escape($this->input->post('sex')),
            'm_tongue'      => html_escape($this->input->post('m_tongue')),
            'religion'      => html_escape($this->input->post('religion')),
            'blood_group'   => html_escape($this->input->post('blood_group')),
            'address'       => html_escape($this->input->post('address')),
            'city'          => html_escape($this->input->post('city')),
            'state'         => html_escape($this->input->post('state')),
            'nationality'   => html_escape($this->input->post('nationality')),
            'phone'         => html_escape($this->input->post('phone')),
            'email'         => html_escape($this->input->post('email')),
            // New identity fields
            'aadhaar_number'        => html_escape($this->input->post('aadhaar_number')),
            'appar_number'          => html_escape($this->input->post('appar_number')),
            'caste'                 => html_escape($this->input->post('caste')),
            'sub_caste'             => html_escape($this->input->post('sub_caste')),
            'medium'                => html_escape($this->input->post('medium')),
            'identification_mark_1' => html_escape($this->input->post('identification_mark_1')),
            'identification_mark_2' => html_escape($this->input->post('identification_mark_2')),
            // Bank details
            'bank_name'             => html_escape($this->input->post('bank_name')),
            'bank_account_number'   => html_escape($this->input->post('bank_account_number')),
            'bank_ifsc'             => html_escape($this->input->post('bank_ifsc')),
            // Previous school
            'ps_attended'   => html_escape($this->input->post('ps_attended')),
            'ps_address'    => html_escape($this->input->post('ps_address')),
            'ps_purpose'    => html_escape($this->input->post('ps_purpose')),
            'class_study'   => html_escape($this->input->post('class_study')),
            'date_of_leaving' => html_escape($this->input->post('date_of_leaving')),
            'am_date'         => html_escape($this->input->post('am_date')),
            'tran_cert'       => html_escape($this->input->post('tran_cert')),
            'dob_cert'        => html_escape($this->input->post('dob_cert')),
            'mark_join'        => html_escape($this->input->post('mark_join')),
            'physical_h'      => html_escape($this->input->post('physical_h')),
            'password'        => sha1($this->input->post('password')),
            'class_id'        => html_escape($this->input->post('class_id')),
            'section_id'      => html_escape($this->input->post('section_id')),
            'parent_id'       => $parent_id,
            'roll'            => html_escape($this->input->post('roll')),
            'transport_id'    => html_escape($this->input->post('transport_id')),
            'dormitory_id'    => html_escape($this->input->post('dormitory_id')),
            'house_id'        => html_escape($this->input->post('house_id')),
            'student_category_id' => html_escape($this->input->post('student_category_id')),
            'club_id'             => html_escape($this->input->post('club_id')),
            'session'             => html_escape($this->input->post('session'))
        );
        
    $this->db->insert('student', $page_data);
    $student_id = $this->db->insert_id();
    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');

    }


    //the function below update student
    function updateNewStudent($param2){
        $page_data = array(
            'name'          => html_escape($this->input->post('name')),
            'birthday'      => html_escape($this->input->post('birthday')),
            'age'           => html_escape($this->input->post('age')),
            'place_birth'   => html_escape($this->input->post('place_birth')),
            'sex'           => html_escape($this->input->post('sex')),
            'm_tongue'      => html_escape($this->input->post('m_tongue')),
            'religion'      => html_escape($this->input->post('religion')),
            'blood_group'   => html_escape($this->input->post('blood_group')),
            'address'       => html_escape($this->input->post('address')),
            'city'          => html_escape($this->input->post('city')),
            'state'         => html_escape($this->input->post('state')),
            'nationality'   => html_escape($this->input->post('nationality')),
            'phone'         => html_escape($this->input->post('phone')),
            'email'         => html_escape($this->input->post('email')),
            // New identity fields
            'aadhaar_number'        => html_escape($this->input->post('aadhaar_number')),
            'appar_number'          => html_escape($this->input->post('appar_number')),
            'caste'                 => html_escape($this->input->post('caste')),
            'sub_caste'             => html_escape($this->input->post('sub_caste')),
            'medium'                => html_escape($this->input->post('medium')),
            'identification_mark_1' => html_escape($this->input->post('identification_mark_1')),
            'identification_mark_2' => html_escape($this->input->post('identification_mark_2')),
            // Bank details
            'bank_name'             => html_escape($this->input->post('bank_name')),
            'bank_account_number'   => html_escape($this->input->post('bank_account_number')),
            'bank_ifsc'             => html_escape($this->input->post('bank_ifsc')),
            // Previous school
            'ps_attended'   => html_escape($this->input->post('ps_attended')),
            'ps_address'    => html_escape($this->input->post('ps_address')),
            'ps_purpose'    => html_escape($this->input->post('ps_purpose')),
            'class_study'   => html_escape($this->input->post('class_study')),
            'date_of_leaving' => html_escape($this->input->post('date_of_leaving')),
            'am_date'         => html_escape($this->input->post('am_date')),
            'tran_cert'       => html_escape($this->input->post('tran_cert')),
            'dob_cert'        => html_escape($this->input->post('dob_cert')),
            'mark_join'        => html_escape($this->input->post('mark_join')),
            'physical_h'      => html_escape($this->input->post('physical_h')),
            'class_id'        => html_escape($this->input->post('class_id')),
            'section_id'      => html_escape($this->input->post('section_id')),
            'parent_id'       => html_escape($this->input->post('parent_id')),
            'transport_id'    => html_escape($this->input->post('transport_id')),
            'dormitory_id'    => html_escape($this->input->post('dormitory_id')),
            'house_id'        => html_escape($this->input->post('house_id')),
            'student_category_id' => html_escape($this->input->post('student_category_id')),
            'club_id'             => html_escape($this->input->post('club_id'))
	    );
        $this->db->where('student_id', $param2);
        $this->db->update('student', $page_data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param2 . '.jpg');

        // Update parent details if provided
        $parent_id = html_escape($this->input->post('parent_id'));
        if (!empty($parent_id) && $this->input->post('father_name')) {
            $parent_data = array(
                'name'          => html_escape($this->input->post('father_name')),
                'phone'         => html_escape($this->input->post('father_phone')),
                'father_name'   => html_escape($this->input->post('father_name')),
                'father_phone'  => html_escape($this->input->post('father_phone')),
                'father_email'  => html_escape($this->input->post('father_email')),
                'father_occupation'    => html_escape($this->input->post('father_occupation')),
                'father_aadhaar'       => html_escape($this->input->post('father_aadhaar')),
                'father_qualification' => html_escape($this->input->post('father_qualification')),
                'father_annual_income' => html_escape($this->input->post('father_annual_income')),
                'mother_name'   => html_escape($this->input->post('mother_name')),
                'mother_phone'  => html_escape($this->input->post('mother_phone')),
                'mother_email'  => html_escape($this->input->post('mother_email')),
                'mother_occupation'    => html_escape($this->input->post('mother_occupation')),
                'mother_aadhaar'       => html_escape($this->input->post('mother_aadhaar')),
                'mother_qualification' => html_escape($this->input->post('mother_qualification')),
            );
            $this->db->where('parent_id', $parent_id);
            $this->db->update('parent', $parent_data);
        }

    }

    // the function below deletes from student table
    function deleteNewStudent($param2){
        $this->db->where('student_id', $param2);
        $this->db->delete('student');
    }

	


	
	
}

