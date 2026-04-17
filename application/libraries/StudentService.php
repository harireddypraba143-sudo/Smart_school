<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * StudentService Library
 * 
 * Handles student queries with parent scoping.
 * Ensures parents can only access their own children's data.
 */
class StudentService {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Get all children of a parent (with pagination).
     */
    public function get_children($parent_id, $limit = 20, $offset = 0) {
        $this->CI->db->select('
            s.student_id, s.name, s.roll, s.birthday, s.sex, s.phone, s.email,
            s.father_name, s.mother_name, s.address, s.city, s.state,
            s.am_date as admission_date, s.aadhaar_number, s.session,
            c.name as class_name, c.class_id,
            sec.name as section_name, sec.section_id
        ');
        $this->CI->db->from('student s');
        $this->CI->db->join('class c', 'c.class_id = s.class_id', 'left');
        $this->CI->db->join('section sec', 'sec.section_id = s.section_id', 'left');
        $this->CI->db->where('s.parent_id', $parent_id);
        $this->CI->db->limit($limit, $offset);

        $students = $this->CI->db->get()->result();

        // Mask sensitive data
        foreach ($students as &$s) {
            $s->aadhaar_number = $this->_mask_aadhaar($s->aadhaar_number);
            $s->photo_url = base_url('uploads/student_image/' . $s->student_id . '.jpg');
            // Structure class and section as objects
            $s->class = (object)['id' => $s->class_id, 'name' => $s->class_name];
            $s->section = (object)['id' => $s->section_id, 'name' => $s->section_name];
            unset($s->class_id, $s->class_name, $s->section_id, $s->section_name);
        }

        return $students;
    }

    /**
     * Count total children of a parent.
     */
    public function count_children($parent_id) {
        return $this->CI->db->where('parent_id', $parent_id)->count_all_results('student');
    }

    /**
     * Get a single student by ID with parent scoping.
     * Returns NULL if student doesn't belong to this parent.
     */
    public function get_student($student_id, $parent_id) {
        $this->CI->db->select('
            s.*, c.name as class_name, sec.name as section_name,
            p.name as parent_name, p.phone as parent_phone, p.email as parent_email
        ');
        $this->CI->db->from('student s');
        $this->CI->db->join('class c', 'c.class_id = s.class_id', 'left');
        $this->CI->db->join('section sec', 'sec.section_id = s.section_id', 'left');
        $this->CI->db->join('parent p', 'p.parent_id = s.parent_id', 'left');
        $this->CI->db->where('s.student_id', $student_id);
        $this->CI->db->where('s.parent_id', $parent_id);

        $student = $this->CI->db->get()->row();
        if (!$student) return NULL;

        // Remove sensitive fields
        unset($student->password);
        $student->aadhaar_number = $this->_mask_aadhaar($student->aadhaar_number ?? '');
        $student->photo_url = base_url('uploads/student_image/' . $student->student_id . '.jpg');

        return $student;
    }

    /**
     * Check if a student belongs to a parent.
     */
    public function belongs_to_parent($student_id, $parent_id) {
        return $this->CI->db->where([
            'student_id' => $student_id,
            'parent_id'  => $parent_id
        ])->count_all_results('student') > 0;
    }

    /**
     * Mask Aadhaar number: show only last 4 digits.
     */
    private function _mask_aadhaar($aadhaar) {
        if (empty($aadhaar) || strlen($aadhaar) < 4) return $aadhaar;
        return '****-****-' . substr($aadhaar, -4);
    }
}
