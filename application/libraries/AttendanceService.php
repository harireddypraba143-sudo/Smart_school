<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AttendanceService Library
 * 
 * Handles attendance records and monthly/overall summaries.
 */
class AttendanceService {

    private $CI;

    // Status mapping: 0=undefined, 1=present, 2=absent, 3=holiday, 4=half_day, 5=late
    private $status_map = [
        0 => 'undefined',
        1 => 'present',
        2 => 'absent',
        3 => 'holiday',
        4 => 'half_day',
        5 => 'late'
    ];

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Get attendance records for a student with optional month/year filter.
     */
    public function get_attendance($student_id, $month = null, $year = null, $limit = 31, $offset = 0) {
        $this->CI->db->where('student_id', $student_id);

        if ($month && $year) {
            $this->CI->db->where('MONTH(date)', $month);
            $this->CI->db->where('YEAR(date)', $year);
        } elseif ($year) {
            $this->CI->db->where('YEAR(date)', $year);
        }

        $this->CI->db->order_by('date', 'DESC');
        $this->CI->db->limit($limit, $offset);

        $records = $this->CI->db->get('attendance')->result();

        return array_map(function($r) {
            return [
                'date'   => $r->date,
                'status' => $this->status_map[(int)$r->status] ?? 'undefined',
                'day'    => date('l', strtotime($r->date))
            ];
        }, $records);
    }

    /**
     * Count total attendance records for a student with optional filters.
     */
    public function count_attendance($student_id, $month = null, $year = null) {
        $this->CI->db->where('student_id', $student_id);
        if ($month && $year) {
            $this->CI->db->where('MONTH(date)', $month);
            $this->CI->db->where('YEAR(date)', $year);
        } elseif ($year) {
            $this->CI->db->where('YEAR(date)', $year);
        }
        return $this->CI->db->count_all_results('attendance');
    }

    /**
     * Get attendance summary (monthly breakdown + overall).
     */
    public function get_summary($student_id, $year = null) {
        if (!$year) $year = date('Y');

        // Monthly breakdown
        $monthly = [];
        $overall_present = 0;
        $overall_absent  = 0;
        $overall_late    = 0;
        $overall_total   = 0;

        for ($m = 1; $m <= 12; $m++) {
            $present = $this->CI->db->where(['student_id' => $student_id, 'status' => 1])
                ->where('MONTH(date)', $m)->where('YEAR(date)', $year)
                ->count_all_results('attendance');

            $absent = $this->CI->db->where(['student_id' => $student_id, 'status' => 2])
                ->where('MONTH(date)', $m)->where('YEAR(date)', $year)
                ->count_all_results('attendance');

            $late = $this->CI->db->where(['student_id' => $student_id, 'status' => 5])
                ->where('MONTH(date)', $m)->where('YEAR(date)', $year)
                ->count_all_results('attendance');

            $total = $present + $absent + $late;
            if ($total > 0) {
                $monthly[] = [
                    'month'      => date('F', mktime(0, 0, 0, $m, 1)),
                    'year'       => (int)$year,
                    'total'      => $total,
                    'present'    => $present,
                    'absent'     => $absent,
                    'late'       => $late,
                    'percentage' => round(($present / $total) * 100, 1)
                ];

                $overall_present += $present;
                $overall_absent  += $absent;
                $overall_late    += $late;
                $overall_total   += $total;
            }
        }

        return [
            'monthly' => $monthly,
            'overall' => [
                'total_days'  => $overall_total,
                'present'     => $overall_present,
                'absent'      => $overall_absent,
                'late'        => $overall_late,
                'percentage'  => $overall_total > 0 ? round(($overall_present / $overall_total) * 100, 1) : 0
            ]
        ];
    }
}
