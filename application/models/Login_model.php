<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }

    /**
     * Enterprise login function.
     * Checks the new unified `users` table first (bcrypt).
     * Falls back to legacy tables (sha1) for backward compatibility.
     * Implements login attempt tracking and account locking.
     */
    function loginFunctionForAllUsers() {
        
        $email = html_escape($this->input->post('email'));		
        $password = html_escape($this->input->post('password'));

        // ============================================
        // 1. Try the new unified USERS table (bcrypt)
        // ============================================
        $query = $this->db->get_where('users', array('email' => $email));
        if ($query->num_rows() > 0) {
            $user = $query->row();

            // Check if account is locked
            if ($user->is_locked) {
                if ($user->locked_until && strtotime($user->locked_until) > time()) {
                    // Still locked
                    return false;
                } else {
                    // Lock period expired, unlock the account
                    $this->db->where('user_id', $user->user_id);
                    $this->db->update('users', array('is_locked' => 0, 'failed_attempts' => 0, 'locked_until' => null));
                    $user->is_locked = 0;
                    $user->failed_attempts = 0;
                }
            }

            // Verify password with bcrypt
            if (password_verify($password, $user->password_hash)) {
                // Successful login — reset failed attempts
                $this->db->where('user_id', $user->user_id);
                $this->db->update('users', array(
                    'failed_attempts' => 0,
                    'is_locked' => 0,
                    'locked_until' => null,
                    'login_status' => 1
                ));

                // Get the role name
                $role = $this->db->get_where('roles', array('role_id' => $user->role_id))->row();
                $role_name = $role ? $role->name : 'admin';

                // Set session data
                $this->session->set_userdata('login_type', $role_name);
                $this->session->set_userdata($role_name . '_login', '1');
                $this->session->set_userdata($role_name . '_id', $user->user_id);
                $this->session->set_userdata('login_user_id', $user->user_id);
                $this->session->set_userdata('name', $user->name);
                $this->session->set_userdata('tenant_id', $user->tenant_id);
                $this->session->set_userdata('role_id', $user->role_id);

                // Load user permissions into session
                $perms = $this->db->select('p.name')
                    ->from('role_permissions rp')
                    ->join('permissions p', 'rp.permission_id = p.permission_id')
                    ->where('rp.role_id', $user->role_id)
                    ->get()->result_array();
                $perm_list = array_column($perms, 'name');
                $this->session->set_userdata('permissions', $perm_list);

                // Audit log
                $this->load->model('audit_model');
                $this->audit_model->log('User logged in', 'system');

                return true;
            } else {
                // Failed login — increment attempt counter
                $attempts = $user->failed_attempts + 1;
                $update = array('failed_attempts' => $attempts);

                // Lock after 5 failed attempts for 15 minutes
                if ($attempts >= 5) {
                    $update['is_locked'] = 1;
                    $update['locked_until'] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                }

                $this->db->where('user_id', $user->user_id);
                $this->db->update('users', $update);
                return false;
            }
        }

        // ============================================
        // 2. Legacy fallback: check old tables (sha1)
        //    Auto-upgrade to users table on success
        // ============================================
        $sha1_password = sha1($password);
        $credential = array('email' => $email, 'password' => $sha1_password);

        // Check admin table
        $query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            // Auto-migrate to users table with bcrypt
            $this->_migrate_legacy_user($row->name, $email, $row->phone, $password, 'admin', 1);
            
            $this->session->set_userdata('login_type', 'admin');
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('admin_id', $row->admin_id);
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('tenant_id', 1);

            // Grant all permissions for admin
            $perms = $this->db->select('name')->get('permissions')->result_array();
            $this->session->set_userdata('permissions', array_column($perms, 'name'));

            return $this->db->set('login_status', '1')
                    ->where('admin_id', $row->admin_id)
                    ->update('admin');
        }

        // Check parent table
        $query = $this->db->get_where('parent', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('login_type', 'parent');
            $this->session->set_userdata('parent_login', '1');
            $this->session->set_userdata('parent_id', $row->parent_id);
            $this->session->set_userdata('login_user_id', $row->parent_id);
            $this->session->set_userdata('name', $row->name);

            return $this->db->set('login_status', '1')
                    ->where('parent_id', $row->parent_id)
                    ->update('parent');
        }

        // Check student table
        $query = $this->db->get_where('student', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('login_type', 'student');
            $this->session->set_userdata('student_login', '1');
            $this->session->set_userdata('student_id', $row->student_id);
            $this->session->set_userdata('login_user_id', $row->student_id);
            $this->session->set_userdata('name', $row->name);

            return $this->db->set('login_status', '1')
                    ->where('student_id', $row->student_id)
                    ->update('student');
        }

        // Check teacher table
        $query = $this->db->get_where('teacher', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('login_type', 'teacher');
            $this->session->set_userdata('teacher_login', '1');
            $this->session->set_userdata('teacher_id', $row->teacher_id);
            $this->session->set_userdata('login_user_id', $row->teacher_id);
            $this->session->set_userdata('name', $row->name);

            return $this->db->set('login_status', '1')
                    ->where('teacher_id', $row->teacher_id)
                    ->update('teacher');
        }

        return false;
    }

    /**
     * Auto-migrate a legacy user into the new users table with bcrypt.
     */
    private function _migrate_legacy_user($name, $email, $phone, $plain_password, $role_name, $tenant_id = 1) {
        // Check if already exists
        $check = $this->db->get_where('users', array('email' => $email, 'tenant_id' => $tenant_id));
        if ($check->num_rows() > 0) return;

        // Get role_id
        $role = $this->db->get_where('roles', array('name' => $role_name))->row();
        $role_id = $role ? $role->role_id : 1;

        $data = array(
            'tenant_id'     => $tenant_id,
            'role_id'       => $role_id,
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'password_hash' => password_hash($plain_password, PASSWORD_BCRYPT),
            'login_status'  => 1,
        );
        $this->db->insert('users', $data);
    }

    // ============================================
    // Logout functions
    // ============================================
    
    function logout_model_for_admin(){
        // Also update the new users table
        $user_id = $this->session->userdata('login_user_id');
        $this->db->where('user_id', $user_id)->update('users', array('login_status' => 0));

        return $this->db->set('login_status', '0')
                    ->where('admin_id', $this->session->userdata('admin_id'))
                    ->update('admin');
    }

    function logout_model_for_accountant(){
        $user_id = $this->session->userdata('login_user_id');
        $this->db->where('user_id', $user_id)->update('users', array('login_status' => 0));
        return true;
    }

    function logout_model_for_admission(){
        $user_id = $this->session->userdata('login_user_id');
        $this->db->where('user_id', $user_id)->update('users', array('login_status' => 0));
        return true;
    }

    function logout_model_for_hrm(){
        return  $this->db->set('login_status', ('0'))
                    ->where('hrm_id', $this->session->userdata('hrm_id'))
                    ->update('hrm');
    }

    function logout_model_for_hostel(){
        return  $this->db->set('login_status', ('0'))
                    ->where('hostel_id', $this->session->userdata('hostel_id'))
                    ->update('hostel');
    }

    function logout_model_for_librarian(){
        return  $this->db->set('login_status', ('0'))
                    ->where('librarian_id', $this->session->userdata('librarian_id'))
                    ->update('librarian');
    }

    function logout_model_for_parent(){
        return  $this->db->set('login_status', ('0'))
                    ->where('parent_id', $this->session->userdata('parent_id'))
                    ->update('parent');
    }

    function logout_model_for_teacher(){
        return  $this->db->set('login_status', ('0'))
                    ->where('teacher_id', $this->session->userdata('teacher_id'))
                    ->update('teacher');
    }

    function logout_model_for_student(){
        return  $this->db->set('login_status', ('0'))
                    ->where('student_id', $this->session->userdata('student_id'))
                    ->update('student');
    }
	
	

}
