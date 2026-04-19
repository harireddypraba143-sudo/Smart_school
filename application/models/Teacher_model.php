<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Teacher_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate a structured Employee ID in the format:
     * SCH{school_id}-EMP-{YYYY}-{sequence}
     * Example: SCH001-EMP-2026-0001
     */
    function generate_employee_id($school_id = '001', $type_code = 'EMP') {
        $year = date('Y');
        $prefix = 'SCH' . $school_id . '-' . $type_code . '-' . $year . '-';
        
        // Find the highest existing sequence for this year
        $this->db->like('teacher_number', 'SCH' . $school_id . '-' . $type_code . '-' . $year . '-', 'after');
        $this->db->order_by('teacher_number', 'DESC');
        $last = $this->db->get('teacher')->row();
        
        if ($last && !empty($last->teacher_number)) {
            // Extract the sequence number from the last ID
            $parts = explode('-', $last->teacher_number);
            $last_seq = intval(end($parts));
            $next_seq = $last_seq + 1;
        } else {
            $next_seq = 1;
        }
        
        return $prefix . str_pad($next_seq, 4, '0', STR_PAD_LEFT);
    }


/**************************** The function below insert into bank and teacher tables   **************************** */
    function insetTeacherFunction (){

        $bank_data['account_holder_name'] = $this->input->post('account_holder_name');
        $bank_data['account_number'] = $this->input->post('account_number');
        $bank_data['bank_name'] = $this->input->post('bank_name');
        $bank_data['branch'] = $this->input->post('branch');

        $this->db->insert('bank', $bank_data);
        $bank_id = $this->db->insert_id();

        // Generate structured employee ID based on staff_type
        $staff_type = $this->input->post('staff_type');
        $type_code = ($staff_type == 'non_teaching') ? 'STF' : 'TCH';
        $employee_id = $this->generate_employee_id('001', $type_code);

        $teacher_array = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'teacher_number'        => $employee_id,
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
			'phone'                 => $this->input->post('phone'),
			'experience'            => $this->input->post('experience'),
			'pan_num'               => $this->input->post('pan_num'),
			'aadhaar_num'           => $this->input->post('aadhaar_num'),
			'uan_num'               => $this->input->post('uan_num'),
			'esi_num'               => $this->input->post('esi_num'),
            'qualification'         => $this->input->post('qualification'),
			'marital_status'        => $this->input->post('marital_status'),
			'password'              => sha1($this->input->post('password')),
        	'department_id'         => $this->input->post('department_id'),
            'designation_id'        => $this->input->post('designation_id'),
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary'),
			'status'                => $this->input->post('status'),
			'date_of_leaving'       => $this->input->post('date_of_leaving'),
            'staff_type'            => $this->input->post('staff_type') ?: 'teaching'
            );
        
            $teacher_array['file_name'] = $_FILES["file_name"]["name"];
            $teacher_array['email'] = $this->input->post('email');
            $teacher_array['bank_id'] = $bank_id;
            $check_email = $this->db->get_where('teacher', array('email' => $teacher_array['email']))->row()->email;	// checking if email exists in database
            if($check_email != null) 
            {
            $this->session->set_flashdata('error_message', get_phrase('email_already_exist'));
            redirect(base_url() . 'admin/teacher/', 'refresh');
            }
            else
            {
            $this->db->insert('teacher', $teacher_array);
            $teacher_id = $this->db->insert_id();
            
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/teacher_image/" . $_FILES["file_name"]["name"]);	// upload files
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');			// image with user ID
                
                // Initialize manual MNC salary structures (Deductions/Allowances)
                $salary_data = array(
                    'employee_id' => $teacher_id,
                    'basic' => $this->input->post('basic_salary') ?: ($this->input->post('joining_salary') * 0.40),
                    'hra' => $this->input->post('hra') ?: ($this->input->post('joining_salary') * 0.20),
                    'pf' => $this->input->post('pf') ?: 0,
                    'esi' => $this->input->post('esi') ?: 0,
                    'pt' => $this->input->post('pt') ?: 0,
                    'tax' => $this->input->post('tax') ?: 0
                );
                $this->db->insert('salary_structures', $salary_data);
            }

    }


    function updateTeacherFunction($param2){

        $teacher_data = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
            'phone'                 => $this->input->post('phone'),
            'email'                 => $this->input->post('email'),
			'experience'            => $this->input->post('experience'),
			'pan_num'               => $this->input->post('pan_num'),
			'aadhaar_num'           => $this->input->post('aadhaar_num'),
			'uan_num'               => $this->input->post('uan_num'),
			'esi_num'               => $this->input->post('esi_num'),
            'qualification'         => $this->input->post('qualification'),
			'marital_status'        => $this->input->post('marital_status')
            );

            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $teacher_data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg'); 			// image with user ID
            
            // Update manual MNC salary structures
            $salary_data = array(
                'basic' => $this->input->post('basic_salary'),
                'hra' => $this->input->post('hra'),
                'pf' => $this->input->post('pf'),
                'esi' => $this->input->post('esi'),
                'pt' => $this->input->post('pt'),
                'tax' => $this->input->post('tax')
            );
            $this->db->where('employee_id', $param2);
            if ($this->db->get('salary_structures')->num_rows() > 0) {
                $this->db->where('employee_id', $param2);
                $this->db->update('salary_structures', $salary_data);
            } else {
                $salary_data['employee_id'] = $param2;
                $this->db->insert('salary_structures', $salary_data);
            }
    }


    function deleteTeacherFunction($param2){

        $this->db->where('teacher_id', $param2);
        $this->db->delete('teacher');
    }
	


	
	
}
