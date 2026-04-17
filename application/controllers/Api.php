<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Controller — Smart_school REST API v1
 * 
 * Enterprise-grade API with dual auth (API Key + JWT),
 * service layer architecture, rate limiting, and logging.
 * 
 * Base URL: /api/v1/
 */
class Api extends CI_Controller {

    private $api_key_row = null;  // Validated API key record
    private $parent_data = null;  // Decoded JWT parent data

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('ApiResponse', null, 'response');
        $this->load->library('AuthService', null, 'auth');

        // Set CORS headers on every request
        $this->response->set_cors_headers();
    }

    // ========================================================================
    // MIDDLEWARE: Auth & Rate Limiting
    // ========================================================================

    /**
     * Require valid API key. Returns api_key row or sends 401.
     */
    private function _require_api_key() {
        $key = $this->auth->validate_api_key();
        if (!$key) {
            $this->response->log_request(null, null, 401);
            $this->response->error('Invalid or missing API key', 401, 'UNAUTHORIZED');
        }
        $this->api_key_row = $key;

        // Rate limiting
        if (!$this->auth->check_rate_limit('apikey_' . $key->id)) {
            $this->response->log_request($key->id, null, 429);
            $this->response->error('Rate limit exceeded. Max 60 requests per minute.', 429, 'RATE_LIMITED');
        }

        return $key;
    }

    /**
     * Require valid JWT access token. Returns parent payload or sends 401.
     */
    private function _require_jwt() {
        $this->_require_api_key();

        $payload = $this->auth->validate_access_token();
        if (!$payload) {
            $this->response->log_request($this->api_key_row->id, null, 401);
            $this->response->error('Invalid or expired access token', 401, 'UNAUTHORIZED');
        }
        $this->parent_data = $payload;
        return $payload;
    }

    /**
     * Verify student belongs to authenticated parent. Sends 403 if not.
     */
    private function _require_student_access($student_id) {
        $this->load->library('StudentService', null, 'students');
        $parent_id = $this->parent_data['sub'];

        if (!$this->students->belongs_to_parent($student_id, $parent_id)) {
            $this->response->log_request($this->api_key_row->id, $parent_id, 403);
            $this->response->error('You do not have access to this student', 403, 'FORBIDDEN');
        }
    }

    // ========================================================================
    // MODULE 1: AUTHENTICATION
    // ========================================================================

    /**
     * POST /api/v1/auth/send-otp
     * Body: phone
     */
    public function auth_send_otp() {
        $this->_require_api_key();

        $phone = $this->input->post('phone');
        if (empty($phone)) {
            $this->response->error('Phone number is required', 400, 'BAD_REQUEST');
        }

        $result = $this->auth->send_otp($phone);
        if (!$result) {
            $this->response->error('No parent account found with this phone number', 404, 'NOT_FOUND');
        }

        $this->response->log_request($this->api_key_row->id, null, 200);
        $this->response->success(
            ['phone' => $phone],
            'OTP sent successfully. Valid for 5 minutes.'
        );
    }

    /**
     * POST /api/v1/auth/verify-otp
     * Body: phone, otp
     */
    public function auth_verify_otp() {
        $this->_require_api_key();

        $phone = $this->input->post('phone');
        $otp   = $this->input->post('otp');

        if (empty($phone) || empty($otp)) {
            $this->response->error('Phone and OTP are required', 400, 'BAD_REQUEST');
        }

        $parent = $this->auth->verify_otp($phone, $otp);
        if (!$parent) {
            $this->response->error('Invalid or expired OTP', 401, 'UNAUTHORIZED');
        }

        // Generate tokens
        $access_token  = $this->auth->generate_access_token($parent->parent_id, [
            'name'  => $parent->name,
            'phone' => $parent->phone
        ]);
        $refresh_token = $this->auth->generate_refresh_token($parent->parent_id);

        // Count children
        $this->load->library('StudentService', null, 'students');
        $children_count = $this->students->count_children($parent->parent_id);

        $this->response->log_request($this->api_key_row->id, $parent->parent_id, 200);
        $this->response->success([
            'access_token'  => $access_token,
            'refresh_token' => $refresh_token,
            'token_type'    => 'Bearer',
            'expires_in'    => 3600,
            'parent' => [
                'parent_id'      => (int)$parent->parent_id,
                'name'           => $parent->name,
                'phone'          => $parent->phone,
                'email'          => $parent->email,
                'children_count' => $children_count
            ]
        ], 'Login successful');
    }

    /**
     * POST /api/v1/auth/refresh
     * Body: refresh_token
     */
    public function auth_refresh() {
        $this->_require_api_key();

        $refresh_token = $this->input->post('refresh_token');
        if (empty($refresh_token)) {
            $this->response->error('Refresh token is required', 400, 'BAD_REQUEST');
        }

        $result = $this->auth->refresh_access_token($refresh_token);
        if (!$result) {
            $this->response->error('Invalid or expired refresh token', 401, 'UNAUTHORIZED');
        }

        $this->response->log_request($this->api_key_row->id, $result['parent_id'], 200);
        $this->response->success([
            'access_token' => $result['access_token'],
            'token_type'   => 'Bearer',
            'expires_in'   => 3600
        ], 'Token refreshed successfully');
    }

    /**
     * GET /api/v1/auth/profile
     */
    public function auth_profile() {
        $jwt = $this->_require_jwt();

        $parent = $this->db->get_where('parent', ['parent_id' => $jwt['sub']])->row();
        if (!$parent) {
            $this->response->error('Parent not found', 404, 'NOT_FOUND');
        }

        $this->load->library('StudentService', null, 'students');

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success([
            'parent_id'       => (int)$parent->parent_id,
            'name'            => $parent->name,
            'email'           => $parent->email,
            'phone'           => $parent->phone,
            'address'         => $parent->address,
            'father_name'     => $parent->father_name,
            'mother_name'     => $parent->mother_name,
            'children_count'  => $this->students->count_children($parent->parent_id)
        ], 'Profile retrieved');
    }

    /**
     * POST /api/v1/auth/logout
     * Body: refresh_token (optional — revokes all if not provided)
     */
    public function auth_logout() {
        $jwt = $this->_require_jwt();

        $refresh_token = $this->input->post('refresh_token');
        if ($refresh_token) {
            $this->auth->revoke_token($refresh_token);
        } else {
            $this->auth->revoke_refresh_tokens($jwt['sub']);
        }

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success(null, 'Logged out successfully');
    }

    // ========================================================================
    // MODULE 2: CHILDREN (STUDENTS)
    // ========================================================================

    /**
     * GET /api/v1/students
     */
    public function students_list() {
        $jwt = $this->_require_jwt();
        $this->load->library('StudentService', null, 'students');

        $parent_id = $jwt['sub'];
        $p = $this->response->get_pagination_params();

        $data  = $this->students->get_children($parent_id, $p['limit'], $p['offset']);
        $total = $this->students->count_children($parent_id);

        $this->response->log_request($this->api_key_row->id, $parent_id, 200);
        $this->response->success(
            $data,
            'Children retrieved successfully',
            200,
            $this->response->paginate($p['page'], $p['limit'], $total)
        );
    }

    /**
     * GET /api/v1/students/{id}
     */
    public function students_detail($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('StudentService', null, 'students');

        $student = $this->students->get_student($student_id, $jwt['sub']);
        if (!$student) {
            $this->response->error('Student not found', 404, 'NOT_FOUND');
        }

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($student, 'Student details retrieved');
    }

    // ========================================================================
    // MODULE 3: EXAM RESULTS & REPORT CARD
    // ========================================================================

    /**
     * GET /api/v1/students/{id}/exams
     */
    public function students_exams($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('ResultService', null, 'results');

        $data = $this->results->get_exams($student_id);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Exams retrieved');
    }

    /**
     * GET /api/v1/students/{id}/results
     */
    public function students_results($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('ResultService', null, 'results');

        $data = $this->results->get_results_summary($student_id);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Results summary retrieved');
    }

    /**
     * GET /api/v1/students/{id}/results/{exam_id}
     */
    public function students_results_detail($student_id, $exam_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('ResultService', null, 'results');

        $data = $this->results->get_detailed_marksheet($student_id, $exam_id);
        if (!$data) {
            $this->response->error('No results found for this exam', 404, 'NOT_FOUND');
        }

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Detailed marksheet retrieved');
    }

    /**
     * GET /api/v1/students/{id}/report-card/{exam_id}
     */
    public function students_report_card($student_id, $exam_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('ResultService', null, 'results');

        $data = $this->results->get_report_card($student_id, $exam_id);
        if (!$data) {
            $this->response->error('Report card not found', 404, 'NOT_FOUND');
        }

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Report card retrieved');
    }

    // ========================================================================
    // MODULE 4: FEE PAYMENTS & INVOICES
    // ========================================================================

    /**
     * GET /api/v1/students/{id}/fee-summary
     */
    public function students_fee_summary($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('FeeService', null, 'fees');

        $data = $this->fees->get_fee_summary($student_id);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Fee summary retrieved');
    }

    /**
     * GET /api/v1/students/{id}/invoices
     */
    public function students_invoices($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('FeeService', null, 'fees');

        $p = $this->response->get_pagination_params();
        $data  = $this->fees->get_invoices($student_id, $p['limit'], $p['offset']);
        $total = $this->fees->count_invoices($student_id);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Invoices retrieved', 200,
            $this->response->paginate($p['page'], $p['limit'], $total));
    }

    /**
     * GET /api/v1/students/{id}/invoices/{invoice_id}
     */
    public function students_invoice_detail($student_id, $invoice_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('FeeService', null, 'fees');

        $data = $this->fees->get_invoice_detail($invoice_id, $student_id);
        if (!$data) {
            $this->response->error('Invoice not found', 404, 'NOT_FOUND');
        }

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Invoice detail retrieved');
    }

    /**
     * GET /api/v1/students/{id}/payments
     */
    public function students_payments($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('FeeService', null, 'fees');

        $p = $this->response->get_pagination_params();
        $data  = $this->fees->get_payments($student_id, $p['limit'], $p['offset']);
        $total = $this->fees->count_payments($student_id);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Payments retrieved', 200,
            $this->response->paginate($p['page'], $p['limit'], $total));
    }

    // ========================================================================
    // MODULE 5: ATTENDANCE
    // ========================================================================

    /**
     * GET /api/v1/students/{id}/attendance
     * Query: month, year
     */
    public function students_attendance($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('AttendanceService', null, 'attendance');

        $month = $this->input->get('month');
        $year  = $this->input->get('year');
        $p     = $this->response->get_pagination_params();

        $data  = $this->attendance->get_attendance($student_id, $month, $year, $p['limit'], $p['offset']);
        $total = $this->attendance->count_attendance($student_id, $month, $year);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Attendance records retrieved', 200,
            $this->response->paginate($p['page'], $p['limit'], $total));
    }

    /**
     * GET /api/v1/students/{id}/attendance/summary
     * Query: year
     */
    public function students_attendance_summary($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('AttendanceService', null, 'attendance');

        $year = $this->input->get('year') ?: date('Y');
        $data = $this->attendance->get_summary($student_id, $year);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Attendance summary retrieved');
    }

    // ========================================================================
    // MODULE 6: NOTICES & CIRCULARS
    // ========================================================================

    /**
     * GET /api/v1/notices
     */
    public function notices_list() {
        $jwt = $this->_require_jwt();
        $this->load->library('NoticeService', null, 'notices');

        $p = $this->response->get_pagination_params();
        $data  = $this->notices->get_notices($p['limit'], $p['offset']);
        $total = $this->notices->count_notices();

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Notices retrieved', 200,
            $this->response->paginate($p['page'], $p['limit'], $total));
    }

    /**
     * GET /api/v1/notices/{id}
     */
    public function notices_detail($id) {
        $jwt = $this->_require_jwt();
        $this->load->library('NoticeService', null, 'notices');

        $data = $this->notices->get_notice($id);
        if (!$data) {
            $this->response->error('Notice not found', 404, 'NOT_FOUND');
        }

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Notice detail retrieved');
    }

    /**
     * GET /api/v1/circulars
     */
    public function circulars_list() {
        $jwt = $this->_require_jwt();
        $this->load->library('NoticeService', null, 'notices');

        $p = $this->response->get_pagination_params();
        $data  = $this->notices->get_circulars($p['limit'], $p['offset']);
        $total = $this->notices->count_circulars();

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Circulars retrieved', 200,
            $this->response->paginate($p['page'], $p['limit'], $total));
    }

    // ========================================================================
    // MODULE 7: ASSIGNMENTS
    // ========================================================================

    /**
     * GET /api/v1/students/{id}/assignments
     */
    public function students_assignments($student_id) {
        $jwt = $this->_require_jwt();
        $this->_require_student_access($student_id);
        $this->load->library('NoticeService', null, 'notices');

        $p = $this->response->get_pagination_params();
        $data  = $this->notices->get_assignments($student_id, $p['limit'], $p['offset']);
        $total = $this->notices->count_assignments($student_id);

        $this->response->log_request($this->api_key_row->id, $jwt['sub'], 200);
        $this->response->success($data, 'Assignments retrieved', 200,
            $this->response->paginate($p['page'], $p['limit'], $total));
    }

    // ========================================================================
    // MODULE 8: ADMIN STATS (API Key only, no JWT required)
    // ========================================================================

    /**
     * GET /api/v1/stats/overview
     */
    public function stats_overview() {
        $this->_require_api_key();

        $total_students  = $this->db->count_all_results('student');
        $total_teachers  = $this->db->count_all_results('teacher');
        $total_classes   = $this->db->count_all_results('class');
        $total_parents   = $this->db->count_all_results('parent');

        // Fee stats
        $fee_query = $this->db->query("SELECT 
            COALESCE(SUM(amount), 0) as total_invoiced,
            COALESCE(SUM(amount_paid), 0) as total_paid,
            COALESCE(SUM(due), 0) as total_due,
            COUNT(*) as total_invoices,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as paid_invoices,
            SUM(CASE WHEN status != 1 THEN 1 ELSE 0 END) as unpaid_invoices
        FROM invoice")->row();

        $this->response->log_request($this->api_key_row->id, null, 200);
        $this->response->success([
            'total_students'    => (int)$total_students,
            'total_teachers'    => (int)$total_teachers,
            'total_classes'     => (int)$total_classes,
            'total_parents'     => (int)$total_parents,
            'fees' => [
                'total_invoiced'  => (float)($fee_query->total_invoiced ?? 0),
                'total_paid'      => (float)($fee_query->total_paid ?? 0),
                'total_due'       => (float)($fee_query->total_due ?? 0),
                'total_invoices'  => (int)($fee_query->total_invoices ?? 0),
                'paid_invoices'   => (int)($fee_query->paid_invoices ?? 0),
                'unpaid_invoices' => (int)($fee_query->unpaid_invoices ?? 0)
            ]
        ], 'Dashboard stats retrieved');
    }

    /**
     * GET /api/v1/stats/admissions
     */
    public function stats_admissions() {
        $this->_require_api_key();

        $classes = $this->db->query("
            SELECT c.class_id, c.name as class_name, COUNT(s.student_id) as student_count
            FROM class c
            LEFT JOIN student s ON s.class_id = c.class_id
            GROUP BY c.class_id, c.name
            ORDER BY c.class_id
        ")->result();

        $this->response->log_request($this->api_key_row->id, null, 200);
        $this->response->success($classes, 'Admission stats retrieved');
    }

    /**
     * GET /api/v1/stats/fees
     */
    public function stats_fees() {
        $this->_require_api_key();

        // Fee breakdown by class
        $data = $this->db->query("
            SELECT c.name as class_name,
                COUNT(DISTINCT i.invoice_id) as total_invoices,
                COALESCE(SUM(i.amount), 0) as total_amount,
                COALESCE(SUM(i.amount_paid), 0) as total_paid,
                COALESCE(SUM(i.due), 0) as total_due
            FROM invoice i
            JOIN student s ON s.student_id = i.student_id
            JOIN class c ON c.class_id = s.class_id
            GROUP BY c.class_id, c.name
            ORDER BY c.class_id
        ")->result();

        $this->response->log_request($this->api_key_row->id, null, 200);
        $this->response->success($data, 'Fee stats retrieved');
    }
}
