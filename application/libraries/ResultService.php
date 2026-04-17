<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ResultService Library
 * 
 * Handles exam results, marksheets, and report card data aggregation.
 * Supports component-wise marks (PT, Notebook, Enrichment, Written).
 */
class ResultService {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Get all exams available for a student's class.
     */
    public function get_exams($student_id) {
        // Get student's class
        $student = $this->CI->db->select('class_id')->get_where('student', ['student_id' => $student_id])->row();
        if (!$student) return [];

        // Get exams that have marks for this student
        $this->CI->db->select('DISTINCT(e.exam_id), e.name, e.comment, e.timestamp as exam_date, e.academic_year');
        $this->CI->db->from('exam e');
        $this->CI->db->join('mark m', 'm.exam_id = e.exam_id AND m.student_id = ' . (int)$student_id, 'inner');
        $this->CI->db->order_by('e.exam_id', 'ASC');

        return $this->CI->db->get()->result();
    }

    /**
     * Get results summary across all exams for a student.
     */
    public function get_results_summary($student_id) {
        $results = $this->CI->db->select('
            er.*, e.name as exam_name, e.academic_year
        ')
        ->from('exam_results er')
        ->join('exam e', 'e.exam_id = er.exam_id')
        ->where('er.student_id', $student_id)
        ->order_by('er.exam_id', 'ASC')
        ->get()->result();

        return $results;
    }

    /**
     * Get detailed marksheet for a specific exam.
     * Returns component-wise marks per subject.
     */
    public function get_detailed_marksheet($student_id, $exam_id) {
        // Get student info
        $student = $this->CI->db->select('s.name, s.roll, s.class_id, c.name as class_name')
            ->from('student s')
            ->join('class c', 'c.class_id = s.class_id', 'left')
            ->where('s.student_id', $student_id)
            ->get()->row();

        if (!$student) return NULL;

        // Get exam info
        $exam = $this->CI->db->get_where('exam', ['exam_id' => $exam_id])->row();
        if (!$exam) return NULL;

        // Get all marks for this student in this exam
        $marks = $this->CI->db->select('m.*, sub.name as subject_name')
            ->from('mark m')
            ->join('subject sub', 'sub.subject_id = m.subject_id', 'left')
            ->where(['m.student_id' => $student_id, 'm.exam_id' => $exam_id])
            ->order_by('m.subject_id', 'ASC')
            ->get()->result();

        // Group marks by subject with components
        $subjects = [];
        foreach ($marks as $mark) {
            $sid = $mark->subject_id;
            if (!isset($subjects[$sid])) {
                $subjects[$sid] = [
                    'subject_id'     => (int)$sid,
                    'name'           => $mark->subject_name,
                    'components'     => [],
                    'total_obtained' => 0,
                    'total_max'      => 0
                ];
            }

            if (!empty($mark->component_type) && $mark->marks_obtained !== '') {
                $obtained = (float)$mark->marks_obtained;
                $max      = (int)$mark->max_marks;

                $subjects[$sid]['components'][] = [
                    'name'     => $mark->component_type,
                    'obtained' => $obtained,
                    'max'      => $max
                ];
                $subjects[$sid]['total_obtained'] += $obtained;
                $subjects[$sid]['total_max']      += $max;
            }
        }

        // Calculate grades per subject
        foreach ($subjects as &$sub) {
            $pct = $sub['total_max'] > 0 ? ($sub['total_obtained'] / $sub['total_max']) * 100 : 0;
            $sub['grade'] = $this->_calculate_grade($pct);
        }

        // Get overall results
        $overall = $this->CI->db->get_where('exam_results', [
            'student_id' => $student_id,
            'exam_id'    => $exam_id
        ])->row();

        // Get remarks
        $remarks = $this->CI->db->get_where('exam_remarks', [
            'student_id' => $student_id,
            'exam_id'    => $exam_id
        ])->row();

        return [
            'student' => [
                'name'      => $student->name,
                'roll'      => $student->roll,
                'class'     => $student->class_name,
                'photo_url' => base_url('uploads/student_image/' . $student_id . '.jpg')
            ],
            'exam' => [
                'exam_id'       => (int)$exam->exam_id,
                'name'          => $exam->name,
                'academic_year' => $exam->academic_year ?? ''
            ],
            'subjects' => array_values($subjects),
            'overall'  => [
                'total_marks' => $overall ? (float)$overall->total_marks : 0,
                'max_marks'   => $this->_get_total_max_marks($subjects),
                'percentage'  => $overall ? (float)$overall->percentage : 0,
                'grade'       => $overall ? $overall->grade : '',
                'class_rank'  => $overall ? $overall->class_rank : null,
                'section_rank'=> $overall ? $overall->section_rank : null,
                'remarks'     => $remarks ? $remarks->text : '',
                'result'      => ($overall && $overall->percentage >= 33) ? 'PASS' : 'FAIL'
            ]
        ];
    }

    /**
     * Get full report card data (marksheet + co-scholastic + attendance).
     */
    public function get_report_card($student_id, $exam_id) {
        $marksheet = $this->get_detailed_marksheet($student_id, $exam_id);
        if (!$marksheet) return NULL;

        // Get student full info
        $student = $this->CI->db->select('s.*, c.name as class_name, sec.name as section_name')
            ->from('student s')
            ->join('class c', 'c.class_id = s.class_id', 'left')
            ->join('section sec', 'sec.section_id = s.section_id', 'left')
            ->where('s.student_id', $student_id)
            ->get()->row();

        // Get co-scholastic marks
        $co_scholastic = $this->CI->db->get_where('co_scholastic_marks', [
            'student_id' => $student_id,
            'exam_id'    => $exam_id
        ])->result();

        // Get attendance summary
        $total_present = $this->CI->db->where(['student_id' => $student_id, 'status' => 1])->count_all_results('attendance');
        $total_absent  = $this->CI->db->where(['student_id' => $student_id, 'status' => 2])->count_all_results('attendance');
        $total_days    = $total_present + $total_absent;

        $marksheet['student_info'] = [
            'name'        => $student->name,
            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'class'       => $student->class_name,
            'section'     => $student->section_name ?? '',
            'roll'        => $student->roll,
            'dob'         => $student->birthday,
            'aadhaar'     => !empty($student->aadhaar_number) ? '****-****-' . substr($student->aadhaar_number, -4) : '',
            'photo_url'   => base_url('uploads/student_image/' . $student_id . '.jpg')
        ];

        $marksheet['co_scholastic'] = array_map(function($cs) {
            return [
                'activity' => $cs->activity ?? '',
                'grade'    => $cs->grade ?? ''
            ];
        }, $co_scholastic);

        $marksheet['attendance_summary'] = [
            'total_days' => $total_days,
            'present'    => $total_present,
            'absent'     => $total_absent
        ];

        return $marksheet;
    }

    /**
     * Calculate grade from percentage.
     */
    private function _calculate_grade($percentage) {
        if ($percentage >= 91) return 'A1';
        if ($percentage >= 81) return 'A2';
        if ($percentage >= 71) return 'B1';
        if ($percentage >= 61) return 'B2';
        if ($percentage >= 51) return 'C1';
        if ($percentage >= 41) return 'C2';
        if ($percentage >= 33) return 'D';
        return 'E';
    }

    /**
     * Sum max marks across all subjects.
     */
    private function _get_total_max_marks($subjects) {
        $total = 0;
        foreach ($subjects as $sub) {
            $total += $sub['total_max'];
        }
        return $total;
    }
}
