<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MigrateDB extends CI_Controller {
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
}
