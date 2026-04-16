<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * RFID API Controller
 * 
 * Public REST API endpoint for RFID/Card machines (ZKTeco, eSSL, Hikvision)
 * to push scan events in real-time. Authenticated via device API key.
 * 
 * Endpoints:
 *   POST /rfidapi/push       — Receive scan event from device
 *   GET  /rfidapi/heartbeat   — Device health check
 */
class Rfidapi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        // Allow JSON input
        header('Content-Type: application/json');
    }

    /**
     * POST /rfidapi/push
     * 
     * Receives a card scan event from an RFID device.
     * Validates API key, checks idempotency cooldown, logs the scan,
     * and syncs to the appropriate attendance table.
     * 
     * Expected JSON payload:
     * {
     *   "device_serial": "ZK-ABC123",
     *   "api_key": "xxx",
     *   "card_number": "A1B2C3D4",
     *   "scan_time": "2026-04-14 09:00:00",  // optional, defaults to now
     *   "direction": "in"                      // optional, defaults to "in"
     * }
     */
    function push() {
        // Only accept POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(array('status' => 'error', 'message' => 'Only POST method allowed'));
            return;
        }

        // Parse JSON body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            // Fallback to form POST data
            $data = array(
                'device_serial' => $this->input->post('device_serial'),
                'api_key'       => $this->input->post('api_key'),
                'card_number'   => $this->input->post('card_number'),
                'scan_time'     => $this->input->post('scan_time'),
                'direction'     => $this->input->post('direction')
            );
        }

        // Validate required fields
        $device_serial = isset($data['device_serial']) ? trim($data['device_serial']) : '';
        $api_key       = isset($data['api_key']) ? trim($data['api_key']) : '';
        $card_number   = isset($data['card_number']) ? trim($data['card_number']) : '';
        $scan_time     = isset($data['scan_time']) && !empty($data['scan_time']) ? $data['scan_time'] : date('Y-m-d H:i:s');
        $direction     = isset($data['direction']) && in_array($data['direction'], array('in', 'out')) ? $data['direction'] : 'in';

        if (empty($device_serial) || empty($api_key) || empty($card_number)) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing required fields: device_serial, api_key, card_number'));
            return;
        }

        // ── Step 1: Authenticate device via API key ──
        $device = $this->db->get_where('rfid_devices', array(
            'device_serial' => $device_serial,
            'api_key' => $api_key,
            'status' => 1
        ))->row();

        if (!$device) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid device credentials or device inactive'));
            return;
        }

        // Update last heartbeat
        $this->db->where('device_id', $device->device_id);
        $this->db->update('rfid_devices', array('last_heartbeat' => date('Y-m-d H:i:s')));

        // ── Step 2: Idempotency — Check cooldown window ──
        $cooldown_row = $this->db->get_where('settings', array('type' => 'rfid_scan_cooldown'))->row();
        $cooldown_seconds = $cooldown_row ? intval($cooldown_row->description) : 60;

        $cutoff_time = date('Y-m-d H:i:s', strtotime($scan_time) - $cooldown_seconds);
        
        $this->db->where('card_number', $card_number);
        $this->db->where('scan_time >=', $cutoff_time);
        $duplicate_count = $this->db->get('rfid_attendance_log')->num_rows();

        if ($duplicate_count > 0) {
            echo json_encode(array(
                'status' => 'duplicate',
                'message' => 'Scan ignored — cooldown active (' . $cooldown_seconds . 's)'
            ));
            return;
        }

        // ── Step 3: Look up card owner ──
        $card = $this->db->get_where('rfid_cards', array(
            'card_number' => $card_number,
            'status' => 1
        ))->row();

        $user_type = $card ? $card->user_type : 'unknown';
        $user_id   = $card ? $card->user_id : 0;

        // ── Step 4: Log the scan ──
        $log_data = array(
            'device_id'   => $device->device_id,
            'card_number' => $card_number,
            'user_type'   => $user_type,
            'user_id'     => $user_id,
            'scan_time'   => $scan_time,
            'direction'   => $direction,
            'synced'      => 0
        );
        $this->db->insert('rfid_attendance_log', $log_data);
        $log_id = $this->db->insert_id();

        // ── Step 5: Sync to attendance tables ──
        $synced = false;
        $scan_date = date('Y-m-d', strtotime($scan_time));
        $scan_time_only = date('H:i:s', strtotime($scan_time));

        // Get late threshold
        $late_row = $this->db->get_where('settings', array('type' => 'rfid_late_threshold'))->row();
        $late_threshold = $late_row ? $late_row->description : '09:00';

        if ($device->device_type === 'hostel' && $user_type === 'student' && $user_id > 0) {
            $synced = $this->_sync_hostel_attendance($user_id, $scan_date, $scan_time, $scan_time_only, $direction);
        } else {
            if ($user_type === 'student' && $user_id > 0) {
                $synced = $this->_sync_student_attendance($user_id, $scan_date, $scan_time_only, $late_threshold, $direction);
            } elseif ($user_type === 'teacher' && $user_id > 0) {
                $synced = $this->_sync_teacher_attendance($user_id, $scan_date, $scan_time_only, $late_threshold, $direction);
            }
        }

        // Mark log as synced
        if ($synced) {
            $this->db->where('log_id', $log_id);
            $this->db->update('rfid_attendance_log', array('synced' => 1));
        }

        echo json_encode(array(
            'status'     => 'ok',
            'log_id'     => $log_id,
            'user_type'  => $user_type,
            'user_id'    => $user_id,
            'synced'     => $synced,
            'message'    => $user_type === 'unknown' ? 'Card not assigned to any user' : 'Attendance recorded'
        ));
    }

    /**
     * Sync student attendance — upsert into `attendance` table
     */
    private function _sync_student_attendance($student_id, $date, $time, $late_threshold, $direction) {
        // Check if attendance record exists for today
        $existing = $this->db->get_where('attendance', array(
            'student_id' => $student_id,
            'date' => $date
        ))->row();

        // Determine status: present (1) or late (3)
        $status = ($time <= $late_threshold . ':00') ? 1 : 3;

        if ($existing) {
            // Only update if currently undefined (0)
            if ($existing->status == 0) {
                $this->db->where('attendance_id', $existing->attendance_id);
                $this->db->update('attendance', array('status' => $status));
            }
        } else {
            // Create new attendance record
            $this->db->insert('attendance', array(
                'student_id' => $student_id,
                'date' => $date,
                'status' => $status,
                'session' => ''
            ));
        }
        return true;
    }

    /**
     * Sync hostel attendance for student
     */
    private function _sync_hostel_attendance($student_id, $date, $scan_time_full, $time_only, $direction) {
        $existing = $this->db->get_where('hostel_attendance', array(
            'student_id' => $student_id,
            'date' => $date
        ))->row();

        // 1: Present(In), 2: Absent(Out), 3: Late
        // Assume check-in by default
        $status = ($direction === 'out') ? 2 : 1; 

        if ($existing) {
            $this->db->where('hostel_attendance_id', $existing->hostel_attendance_id);
            $this->db->update('hostel_attendance', array(
                'status' => $status,
                'scan_time' => $scan_time_full
            ));
        } else {
            $this->db->insert('hostel_attendance', array(
                'student_id' => $student_id,
                'date' => $date,
                'status' => $status,
                'scan_time' => $scan_time_full
            ));
        }
        return true;
    }

    /**
     * Sync teacher attendance — upsert into `teacher_attendance` table
     */
    private function _sync_teacher_attendance($teacher_id, $date, $time, $late_threshold, $direction) {
        $existing = $this->db->get_where('teacher_attendance', array(
            'teacher_id' => $teacher_id,
            'date' => $date
        ))->row();

        $status = ($time <= $late_threshold . ':00') ? 1 : 3;

        if ($existing) {
            if ($direction === 'in' && empty($existing->check_in)) {
                $this->db->where('id', $existing->id);
                $this->db->update('teacher_attendance', array(
                    'check_in' => $time,
                    'status' => $status,
                    'source' => 'rfid'
                ));
            } elseif ($direction === 'out') {
                $this->db->where('id', $existing->id);
                $this->db->update('teacher_attendance', array(
                    'check_out' => $time,
                    'source' => 'rfid'
                ));
            }
        } else {
            $insert = array(
                'teacher_id' => $teacher_id,
                'date' => $date,
                'status' => $status,
                'source' => 'rfid'
            );
            if ($direction === 'in') {
                $insert['check_in'] = $time;
            } else {
                $insert['check_out'] = $time;
            }
            $this->db->insert('teacher_attendance', $insert);
        }
        return true;
    }

    /**
     * GET /rfidapi/heartbeat/{device_serial}
     * 
     * Device health check endpoint. Updates last_heartbeat timestamp.
     */
    function heartbeat($device_serial = '') {
        if (empty($device_serial)) {
            echo json_encode(array('status' => 'error', 'message' => 'Device serial required'));
            return;
        }

        $device = $this->db->get_where('rfid_devices', array(
            'device_serial' => $device_serial,
            'status' => 1
        ))->row();

        if (!$device) {
            echo json_encode(array('status' => 'error', 'message' => 'Device not found'));
            return;
        }

        $this->db->where('device_id', $device->device_id);
        $this->db->update('rfid_devices', array('last_heartbeat' => date('Y-m-d H:i:s')));

        echo json_encode(array(
            'status' => 'ok',
            'device_name' => $device->device_name,
            'server_time' => date('Y-m-d H:i:s')
        ));
    }
}
