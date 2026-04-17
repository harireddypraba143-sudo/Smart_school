<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NoticeService Library
 * 
 * Handles noticeboard entries, circulars, and assignments.
 */
class NoticeService {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Get all noticeboard entries (paginated).
     */
    public function get_notices($limit = 20, $offset = 0) {
        $notices = $this->CI->db
            ->order_by('noticeboard_id', 'DESC')
            ->limit($limit, $offset)
            ->get('noticeboard')
            ->result();

        return array_map(function($n) {
            return [
                'id'          => (int)$n->noticeboard_id,
                'title'       => $n->title,
                'description' => $n->description,
                'location'    => $n->location,
                'date'        => $n->timestamp ? date('Y-m-d', $n->timestamp) : ''
            ];
        }, $notices);
    }

    /**
     * Count total notices.
     */
    public function count_notices() {
        return $this->CI->db->count_all_results('noticeboard');
    }

    /**
     * Get a single notice by ID.
     */
    public function get_notice($id) {
        $n = $this->CI->db->get_where('noticeboard', ['noticeboard_id' => $id])->row();
        if (!$n) return NULL;

        return [
            'id'          => (int)$n->noticeboard_id,
            'title'       => $n->title,
            'description' => $n->description,
            'location'    => $n->location,
            'date'        => $n->timestamp ? date('Y-m-d', $n->timestamp) : ''
        ];
    }

    /**
     * Get all circulars (paginated).
     */
    public function get_circulars($limit = 20, $offset = 0) {
        $circulars = $this->CI->db
            ->order_by('circular_id', 'DESC')
            ->limit($limit, $offset)
            ->get('circular')
            ->result();

        return array_map(function($c) {
            return [
                'id'        => (int)$c->circular_id,
                'title'     => $c->title,
                'reference' => $c->reference,
                'content'   => $c->content,
                'date'      => $c->date
            ];
        }, $circulars);
    }

    /**
     * Count total circulars.
     */
    public function count_circulars() {
        return $this->CI->db->count_all_results('circular');
    }

    /**
     * Get assignments for a student's class (paginated).
     */
    public function get_assignments($student_id, $limit = 20, $offset = 0) {
        // Get student's class
        $student = $this->CI->db->select('class_id')->get_where('student', ['student_id' => $student_id])->row();
        if (!$student) return [];

        $assignments = $this->CI->db->select('a.*, sub.name as subject_name, t.name as teacher_name')
            ->from('assignment a')
            ->join('subject sub', 'sub.subject_id = a.subject_id', 'left')
            ->join('teacher t', 't.teacher_id = a.teacher_id', 'left')
            ->where('a.class_id', $student->class_id)
            ->order_by('a.assignment_id', 'DESC')
            ->limit($limit, $offset)
            ->get()->result();

        return array_map(function($a) {
            return [
                'assignment_id' => (int)$a->assignment_id,
                'name'          => $a->name,
                'subject'       => $a->subject_name,
                'teacher'       => $a->teacher_name,
                'description'   => $a->description,
                'file_url'      => !empty($a->file_name) ? base_url('uploads/assignment/' . $a->file_name) : null,
                'file_type'     => $a->file_type,
                'date'          => $a->timestamp
            ];
        }, $assignments);
    }

    /**
     * Count assignments for a student's class.
     */
    public function count_assignments($student_id) {
        $student = $this->CI->db->select('class_id')->get_where('student', ['student_id' => $student_id])->row();
        if (!$student) return 0;
        return $this->CI->db->where('class_id', $student->class_id)->count_all_results('assignment');
    }
}
