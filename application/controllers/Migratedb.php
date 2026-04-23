<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migratedb extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        $queries = [
            "CREATE TABLE IF NOT EXISTS `salary_structures` (
              `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
              `employee_id` BIGINT NOT NULL,
              `basic` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              `hra` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              `pf` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              `tax` DECIMAL(10,2) NOT NULL DEFAULT '0.00'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
        
            "CREATE TABLE IF NOT EXISTS `payroll` (
              `payroll_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
              `employee_id` BIGINT NOT NULL,
              `school_id` BIGINT NULL,
              `month` INT NOT NULL,
              `year` INT NOT NULL,
              
              `basic_salary` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              `allowances` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              `deductions` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              `net_salary` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
              
              `status` INT NOT NULL DEFAULT 0 COMMENT '0=Draft, 1=Generated, 2=Paid, 3=Failed',
              `is_locked` BOOLEAN DEFAULT FALSE,
              
              `payment_method` VARCHAR(50) DEFAULT NULL,
              `payment_date` DATETIME DEFAULT NULL,
              `transaction_reference` VARCHAR(255) DEFAULT NULL,
              
              `payslip_no` VARCHAR(50) DEFAULT NULL,
              
              `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
              `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              
              UNIQUE KEY `unique_payroll_month` (`employee_id`, `month`, `year`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
        
            "CREATE TABLE IF NOT EXISTS `payroll_items` (
              `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
              `payroll_id` BIGINT NOT NULL,
              `type` ENUM('allowance', 'deduction') NOT NULL,
              `name` VARCHAR(100) NOT NULL,
              `amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
        
            "CREATE TABLE IF NOT EXISTS `payment_ledger` (
              `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
              `payroll_id` BIGINT NOT NULL,
              `amount` DECIMAL(10,2) NOT NULL,
              `method` VARCHAR(50) NOT NULL,
              `status` VARCHAR(20) NOT NULL,
              `transaction_ref` VARCHAR(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
        
            "CREATE TABLE IF NOT EXISTS `payroll_audit_logs` (
              `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
              `payroll_id` BIGINT NOT NULL,
              `action` VARCHAR(255) NOT NULL,
              `performed_by` BIGINT NOT NULL,
              `timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        ];

        foreach ($queries as $i => $sql) {
            if ($this->db->query($sql)) {
                echo "Table " . ($i+1) . " created successfully<br>";
            } else {
                echo "Error creating table " . ($i+1) . "<br>";
            }
        }
        echo "Done.";
    }

    /**
     * HRMS Migration — adds missing columns to teacher table and salary_structures
     * Run once: http://localhost:8000/migratedb/hrms
     */
    public function hrms() {
        $alter_queries = [
            // Teacher table — HRMS columns
            "ALTER TABLE `teacher` ADD COLUMN `experience` VARCHAR(50) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `pan_num` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `aadhaar_num` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `uan_num` VARCHAR(30) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `esi_num` VARCHAR(30) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `qualification` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `marital_status` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `bank_account` VARCHAR(30) DEFAULT NULL",
            "ALTER TABLE `teacher` ADD COLUMN `bank_ifsc` VARCHAR(20) DEFAULT NULL",
            
            // Salary structures — add missing columns
            "ALTER TABLE `salary_structures` ADD COLUMN `esi` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",
            "ALTER TABLE `salary_structures` ADD COLUMN `pt` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",
            
            // Payroll table — add gross/deduction breakdown columns
            "ALTER TABLE `payroll` ADD COLUMN `gross_salary` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",
            "ALTER TABLE `payroll` ADD COLUMN `epf` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",
            "ALTER TABLE `payroll` ADD COLUMN `esi` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",
            "ALTER TABLE `payroll` ADD COLUMN `pt` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",
            "ALTER TABLE `payroll` ADD COLUMN `tds` DECIMAL(10,2) NOT NULL DEFAULT '0.00'",

            // Leave requests table
            "CREATE TABLE IF NOT EXISTS `leave_requests` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `employee_id` int(11) NOT NULL,
              `leave_type` varchar(100) NOT NULL,
              `from_date` date NOT NULL,
              `to_date` date NOT NULL,
              `reason` text NOT NULL,
              `status` varchar(20) NOT NULL DEFAULT 'pending',
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        ];

        $success = 0;
        $skipped = 0;
        foreach ($alter_queries as $sql) {
            try {
                $this->db->query($sql);
                $success++;
                echo "✓ OK: " . substr($sql, 0, 80) . "...<br>";
            } catch (Exception $e) {
                $skipped++;
                echo "⊘ Skipped (already exists): " . substr($sql, 0, 80) . "...<br>";
            }
        }
        echo "<br><strong>HRMS Migration Complete: $success applied, $skipped skipped.</strong>";
    }

    /**
     * Student Admission Migration — adds missing columns to student and parent tables
     * Run once: http://localhost:8000/migratedb/student_admission
     */
    public function student_admission() {
        $queries = [
            // Student table — admission number
            "ALTER TABLE `student` ADD COLUMN `admission_no` VARCHAR(50) DEFAULT NULL",
            // Student table — status tracking (active / left / completed)
            "ALTER TABLE `student` ADD COLUMN `student_status` VARCHAR(20) NOT NULL DEFAULT 'active'",
            // Student table — new identity fields
            "ALTER TABLE `student` ADD COLUMN `aadhaar_number` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `appar_number` VARCHAR(30) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `caste` VARCHAR(50) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `sub_caste` VARCHAR(50) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `medium` VARCHAR(30) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `identification_mark_1` VARCHAR(200) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `identification_mark_2` VARCHAR(200) DEFAULT NULL",
            
            // Student table — bank details
            "ALTER TABLE `student` ADD COLUMN `bank_name` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `bank_account_number` VARCHAR(30) DEFAULT NULL",
            "ALTER TABLE `student` ADD COLUMN `bank_ifsc` VARCHAR(20) DEFAULT NULL",

            // Parent table — father details
            "ALTER TABLE `parent` ADD COLUMN `father_name` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `father_phone` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `father_email` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `father_occupation` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `father_aadhaar` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `father_qualification` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `father_annual_income` VARCHAR(30) DEFAULT NULL",
            
            // Parent table — mother details
            "ALTER TABLE `parent` ADD COLUMN `mother_name` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `mother_phone` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `mother_email` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `mother_occupation` VARCHAR(100) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `mother_aadhaar` VARCHAR(20) DEFAULT NULL",
            "ALTER TABLE `parent` ADD COLUMN `mother_qualification` VARCHAR(100) DEFAULT NULL",
        ];

        $success = 0;
        $skipped = 0;
        foreach ($queries as $sql) {
            try {
                $this->db->query($sql);
                $success++;
                echo "✓ OK: " . substr($sql, 0, 80) . "...<br>";
            } catch (Exception $e) {
                $skipped++;
                echo "⊘ Skipped (already exists): " . substr($sql, 0, 80) . "...<br>";
            }
        }
        echo "<br><strong>Student Admission Migration Complete: $success applied, $skipped skipped.</strong>";
    }

    /**
     * Create ALL missing tables
     * Run: /migratedb/create_tables
     */
    public function create_tables() {
        $queries = [
            // Alumni
            "CREATE TABLE IF NOT EXISTS `alumni` (
              `alumni_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) NOT NULL, `email` varchar(100) DEFAULT NULL,
              `sex` varchar(10) DEFAULT NULL, `address` text DEFAULT NULL,
              `phone` varchar(20) DEFAULT NULL, `profession` varchar(100) DEFAULT NULL,
              `g_year` varchar(20) DEFAULT NULL, `club_id` int(11) DEFAULT NULL,
              `interest` text DEFAULT NULL, PRIMARY KEY (`alumni_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Admin Role
            "CREATE TABLE IF NOT EXISTS `admin_role` (
              `admin_role_id` int(11) NOT NULL AUTO_INCREMENT,
              `admin_id` int(11) NOT NULL,
              `dashboard` int(1) DEFAULT 1, `manage_academics` int(1) DEFAULT 1,
              `manage_employee` int(1) DEFAULT 1, `manage_student` int(1) DEFAULT 1,
              `manage_attendance` int(1) DEFAULT 1, `download_page` int(1) DEFAULT 1,
              `manage_parent` int(1) DEFAULT 1, `manage_alumni` int(1) DEFAULT 1,
              PRIMARY KEY (`admin_role_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Enquiry
            "CREATE TABLE IF NOT EXISTS `enquiry` (
              `enquiry_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL, `email` varchar(100) DEFAULT NULL,
              `phone` varchar(20) DEFAULT NULL, `address` text DEFAULT NULL,
              `enquiry_category_id` int(11) DEFAULT NULL,
              `description` text DEFAULT NULL, `date` varchar(50) DEFAULT NULL,
              `status` varchar(20) DEFAULT 'pending',
              PRIMARY KEY (`enquiry_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Enquiry Category
            "CREATE TABLE IF NOT EXISTS `enquiry_category` (
              `enquiry_category_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`enquiry_category_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Co-Scholastic Marks
            "CREATE TABLE IF NOT EXISTS `co_scholastic_marks` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `student_id` int(11) NOT NULL, `exam_id` int(11) NOT NULL,
              `class_id` int(11) NOT NULL, `area` varchar(100) DEFAULT NULL,
              `grade` varchar(10) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Exam Components
            "CREATE TABLE IF NOT EXISTS `exam_components` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `exam_id` int(11) NOT NULL, `subject_id` int(11) NOT NULL,
              `class_id` int(11) NOT NULL, `component_name` varchar(100) DEFAULT NULL,
              `max_marks` decimal(10,2) DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Exam Results
            "CREATE TABLE IF NOT EXISTS `exam_results` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `student_id` int(11) NOT NULL, `exam_id` int(11) NOT NULL,
              `component_id` int(11) DEFAULT NULL, `subject_id` int(11) DEFAULT NULL,
              `marks_obtained` decimal(10,2) DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Exam Remarks
            "CREATE TABLE IF NOT EXISTS `exam_remarks` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `student_id` int(11) NOT NULL, `exam_id` int(11) NOT NULL,
              `class_id` int(11) DEFAULT NULL, `remark` text DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // RFID Devices
            "CREATE TABLE IF NOT EXISTS `rfid_devices` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `device_id` varchar(100) NOT NULL, `device_name` varchar(100) DEFAULT NULL,
              `location` varchar(200) DEFAULT NULL, `status` varchar(20) DEFAULT 'active',
              `api_key` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // RFID Cards
            "CREATE TABLE IF NOT EXISTS `rfid_cards` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `card_uid` varchar(100) NOT NULL, `user_type` varchar(20) DEFAULT NULL,
              `user_id` int(11) DEFAULT NULL, `status` varchar(20) DEFAULT 'active',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // RFID Attendance Log
            "CREATE TABLE IF NOT EXISTS `rfid_attendance_log` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `card_uid` varchar(100) DEFAULT NULL, `device_id` varchar(100) DEFAULT NULL,
              `user_type` varchar(20) DEFAULT NULL, `user_id` int(11) DEFAULT NULL,
              `scan_type` varchar(20) DEFAULT NULL, `scan_time` datetime DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Audit Logs
            "CREATE TABLE IF NOT EXISTS `audit_logs` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_type` varchar(30) DEFAULT NULL, `user_id` int(11) DEFAULT NULL,
              `action` varchar(255) DEFAULT NULL, `module` varchar(100) DEFAULT NULL,
              `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Hostel Category
            "CREATE TABLE IF NOT EXISTS `hostel_category` (
              `hostel_category_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`hostel_category_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Hostel Attendance
            "CREATE TABLE IF NOT EXISTS `hostel_attendance` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `student_id` int(11) NOT NULL, `date` varchar(50) DEFAULT NULL,
              `status` varchar(20) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Transport Route
            "CREATE TABLE IF NOT EXISTS `transport_route` (
              `transport_route_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL, `description` text DEFAULT NULL,
              PRIMARY KEY (`transport_route_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Staff
            "CREATE TABLE IF NOT EXISTS `staff` (
              `staff_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) NOT NULL, `designation` varchar(100) DEFAULT NULL,
              `department_id` int(11) DEFAULT NULL, `phone` varchar(20) DEFAULT NULL,
              `email` varchar(100) DEFAULT NULL, `sex` varchar(10) DEFAULT NULL,
              `address` text DEFAULT NULL, `joining_date` varchar(50) DEFAULT NULL,
              `salary` decimal(10,2) DEFAULT 0, `login_status` int(1) DEFAULT 0,
              PRIMARY KEY (`staff_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Staff Attendance
            "CREATE TABLE IF NOT EXISTS `staff_attendance` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `staff_id` int(11) NOT NULL, `date` varchar(50) DEFAULT NULL,
              `status` varchar(20) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Designation
            "CREATE TABLE IF NOT EXISTS `designation` (
              `designation_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`designation_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Circular
            "CREATE TABLE IF NOT EXISTS `circular` (
              `circular_id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(200) DEFAULT NULL, `description` text DEFAULT NULL,
              `date` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`circular_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Academic Syllabus
            "CREATE TABLE IF NOT EXISTS `academic_syllabus` (
              `academic_syllabus_id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(200) DEFAULT NULL, `class_id` int(11) DEFAULT NULL,
              `subject_id` int(11) DEFAULT NULL, `file_name` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`academic_syllabus_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Social Category
            "CREATE TABLE IF NOT EXISTS `social_category` (
              `social_category_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`social_category_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Book Category
            "CREATE TABLE IF NOT EXISTS `book_category` (
              `book_category_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`book_category_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Book Issue
            "CREATE TABLE IF NOT EXISTS `book_issue` (
              `book_issue_id` int(11) NOT NULL AUTO_INCREMENT,
              `book_id` int(11) DEFAULT NULL, `student_id` int(11) DEFAULT NULL,
              `issue_date` varchar(50) DEFAULT NULL, `return_date` varchar(50) DEFAULT NULL,
              `status` varchar(20) DEFAULT 'issued',
              PRIMARY KEY (`book_issue_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        ];

        $success = 0; $skipped = 0;
        foreach ($queries as $sql) {
            try {
                $this->db->query($sql);
                $success++;
                echo "✓ OK: " . substr($sql, 0, 80) . "...<br>";
            } catch (Exception $e) {
                $skipped++;
                echo "⊘ Skipped: " . substr($sql, 0, 80) . "...<br>";
            }
        }

        // Create upload directory
        $dirs = ['uploads/alumni_image'];
        foreach ($dirs as $d) {
            $path = FCPATH . $d;
            if (!is_dir($path)) { mkdir($path, 0755, true); echo "✓ Created $d/<br>"; }
        }

        echo "<br><strong>Tables Migration Complete: $success created/verified, $skipped skipped.</strong>";
    }
}
