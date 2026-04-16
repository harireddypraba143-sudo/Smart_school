#
# TABLE STRUCTURE FOR: academic_syllabus
#

DROP TABLE IF EXISTS `academic_syllabus`;

CREATE TABLE `academic_syllabus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `academic_syllabus_code` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `uploader_type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `uploader_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `session` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` int NOT NULL,
  `file_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: activity
#

DROP TABLE IF EXISTS `activity`;

CREATE TABLE `activity` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `colour` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `icon` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `club_id` int NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: admin
#

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `level` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `login_status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `admin` (`admin_id`, `name`, `email`, `phone`, `password`, `level`, `login_status`) VALUES (1, 'Administrator', 'admin@admin.com', '07133445656', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '1', '0');
INSERT INTO `admin` (`admin_id`, `name`, `email`, `phone`, `password`, `level`, `login_status`) VALUES (9, 'Udemy Instructor', 'udemy@udemy.com', '+1564783934', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2', '0');


#
# TABLE STRUCTURE FOR: admin_role
#

DROP TABLE IF EXISTS `admin_role`;

CREATE TABLE `admin_role` (
  `admin_role_id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `dashboard` int NOT NULL,
  `manage_academics` int NOT NULL,
  `manage_employee` int NOT NULL,
  `manage_student` int NOT NULL,
  `manage_attendance` int NOT NULL,
  `download_page` int NOT NULL,
  `manage_parent` int NOT NULL,
  `manage_alumni` int NOT NULL,
  PRIMARY KEY (`admin_role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `admin_role` (`admin_role_id`, `admin_id`, `dashboard`, `manage_academics`, `manage_employee`, `manage_student`, `manage_attendance`, `download_page`, `manage_parent`, `manage_alumni`) VALUES (4, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `admin_role` (`admin_role_id`, `admin_id`, `dashboard`, `manage_academics`, `manage_employee`, `manage_student`, `manage_attendance`, `download_page`, `manage_parent`, `manage_alumni`) VALUES (7, 9, 1, 1, 1, 1, 1, 1, 1, 1);


#
# TABLE STRUCTURE FOR: assignment
#

DROP TABLE IF EXISTS `assignment`;

CREATE TABLE `assignment` (
  `assignment_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `subject_id` int NOT NULL,
  `class_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`assignment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `assignment` (`assignment_id`, `name`, `subject_id`, `class_id`, `teacher_id`, `description`, `file_name`, `file_type`, `timestamp`) VALUES (1, 'Assignment for Nursery One', 4, 2, 1, 'DESC', 'invoice.docx', 'pdf', '2018-08-19');


#
# TABLE STRUCTURE FOR: attendance
#

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `status` int NOT NULL COMMENT '0 undefined , 1 present , 2  absent, 3 holiday, 4 half day, 5 late',
  `student_id` int NOT NULL,
  `date` date NOT NULL,
  `session` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

INSERT INTO `attendance` (`attendance_id`, `status`, `student_id`, `date`, `session`) VALUES (39, 1, 45, '2019-12-20', '');
INSERT INTO `attendance` (`attendance_id`, `status`, `student_id`, `date`, `session`) VALUES (40, 1, 45, '2019-12-22', '');
INSERT INTO `attendance` (`attendance_id`, `status`, `student_id`, `date`, `session`) VALUES (41, 1, 45, '2021-12-02', '');
INSERT INTO `attendance` (`attendance_id`, `status`, `student_id`, `date`, `session`) VALUES (42, 2, 45, '2021-12-03', '');


#
# TABLE STRUCTURE FOR: audit_logs
#

DROP TABLE IF EXISTS `audit_logs`;

CREATE TABLE `audit_logs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '1',
  `user_id` int DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `action` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `module` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (1, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 18:26:10');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (2, 1, 1, 'Administrator', 'admin', 'Created new user: harinatha reddy (role_id: 3)', 'system', '::1', '2026-04-14 18:27:29');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (3, 1, 3, 'harinatha reddy', 'admission', 'User logged in', 'system', '::1', '2026-04-14 18:27:55');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (4, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 18:31:59');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (5, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 20:44:11');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (6, 1, 3, 'harinatha reddy', 'admission', 'User logged in', 'system', '::1', '2026-04-14 20:46:38');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (7, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 20:52:42');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (8, 1, 3, 'harinatha reddy', 'admission', 'User logged in', 'system', '::1', '2026-04-14 20:59:55');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (9, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 21:03:06');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (10, 1, 3, 'harinatha reddy', 'admission', 'User logged in', 'system', '::1', '2026-04-14 21:12:58');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (11, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 21:46:18');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (12, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 21:52:23');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (13, 1, 3, 'harinatha reddy', 'admission', 'User logged in', 'system', '::1', '2026-04-14 21:53:30');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (14, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-14 22:13:50');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (15, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-15 06:53:34');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (16, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-15 07:05:14');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (17, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-15 20:55:03');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (18, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-15 23:24:38');
INSERT INTO `audit_logs` (`log_id`, `tenant_id`, `user_id`, `user_name`, `role`, `action`, `module`, `ip_address`, `created_at`) VALUES (19, 1, 1, 'Administrator', 'admin', 'User logged in', 'system', '::1', '2026-04-16 07:48:09');


#
# TABLE STRUCTURE FOR: bank
#

DROP TABLE IF EXISTS `bank`;

CREATE TABLE `bank` (
  `bank_id` int NOT NULL AUTO_INCREMENT,
  `account_holder_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `account_number` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bank_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `branch` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `bank` (`bank_id`, `account_holder_name`, `account_number`, `bank_name`, `branch`) VALUES (2, 'Udemy Instructor', '1234567', 'Payoneer or paypal', 'USA');
INSERT INTO `bank` (`bank_id`, `account_holder_name`, `account_number`, `bank_name`, `branch`) VALUES (3, 'Udemy Instructor', '1234567', 'Payoneer or paypal', 'USA');
INSERT INTO `bank` (`bank_id`, `account_holder_name`, `account_number`, `bank_name`, `branch`) VALUES (4, 'Udemy Instructor', '1234567', 'Payoneer or paypal', 'USA');
INSERT INTO `bank` (`bank_id`, `account_holder_name`, `account_number`, `bank_name`, `branch`) VALUES (5, '5318902394239', 'harinathreddy basireddy', 'SBI', 'Banaganapalli');


#
# TABLE STRUCTURE FOR: book
#

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `author_id` int NOT NULL,
  `publisher_id` int NOT NULL,
  `book_category_id` int NOT NULL,
  `isbn` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `edition` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `subject_id` int NOT NULL,
  `quantity` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` int NOT NULL,
  `class_id` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `book` (`book_id`, `name`, `description`, `author_id`, `publisher_id`, `book_category_id`, `isbn`, `edition`, `subject_id`, `quantity`, `timestamp`, `class_id`, `status`, `price`) VALUES (1, 'Advance Java.', 'This is the newly released book by Sheg', 2, 1, 2, 'DS34FD', '1st', 0, '1', 1576951200, 2, '1', '200');
INSERT INTO `book` (`book_id`, `name`, `description`, `author_id`, `publisher_id`, `book_category_id`, `isbn`, `edition`, `subject_id`, `quantity`, `timestamp`, `class_id`, `status`, `price`) VALUES (2, 'Python', 'Python', 2, 1, 2, 'DS34FD', '1st', 4, '2', 1574186400, 2, '2', '500');


#
# TABLE STRUCTURE FOR: book_category
#

DROP TABLE IF EXISTS `book_category`;

CREATE TABLE `book_category` (
  `book_category_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`book_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `book_category` (`book_category_id`, `name`, `description`) VALUES (2, 'Non fictional.', 'This is another non-fictional book');


#
# TABLE STRUCTURE FOR: book_issue
#

DROP TABLE IF EXISTS `book_issue`;

CREATE TABLE `book_issue` (
  `issue_id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `student_id` int NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'issued',
  `fine` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# TABLE STRUCTURE FOR: ci_sessions
#

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('005d059c5b65d4d1d0c223fb17753f118530fdeb', '::1', 1776270977, '__ci_last_regenerate|i:1776270977;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('00f2af180557c2fbd16c80959786cf1c38e0864a', '::1', 1776272059, '__ci_last_regenerate|i:1776272059;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0529e700adca82bb0a4acb4a87146bf6fd6c726d', '::1', 1776280472, '__ci_last_regenerate|i:1776280472;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0d2d8f0c25f7e2db824ff050361076ce99b6ee0f', '::1', 1776310483, '__ci_last_regenerate|i:1776310483;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:27:\"Grades Updated Successfully\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0f91c56450cfafafcf743077e80e9ab2f4d2137b', '::1', 1776278758, '__ci_last_regenerate|i:1776278758;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0fa6d7bddd36a51c7cd28f515d0f5242a87a35b0', '::1', 1776274212, '__ci_last_regenerate|i:1776274212;error_message|s:24:\"Pleasen Select Something\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1e23f014308d12b8fbb8ffdb9f4da05811cff7ff', '::1', 1776307182, '__ci_last_regenerate|i:1776307182;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('22c472c776a2aa978b4c3f24a1c4bba6e4c04a3e', '::1', 1776269671, '__ci_last_regenerate|i:1776269671;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2cc95f13734c3910be8669ff72df16201c815e30', '::1', 1776275659, '__ci_last_regenerate|i:1776275659;error_message|s:24:\"Pleasen Select Something\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2da7312c76bbd0369296be2f50afca96c7091782', '::1', 1776275116, '__ci_last_regenerate|i:1776275116;error_message|s:24:\"Pleasen Select Something\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3284dfc6cf71e622b3f2d6acc1ed055baa9217e6', '::1', 1776280167, '__ci_last_regenerate|i:1776280167;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('346ad2dd6c3e7f610b55e3a13b55c6b4a5e79f79', '::1', 1776266818, '__ci_last_regenerate|i:1776266818;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3f7e29af69abf2f893ac0acd8706ac110b7ca03e', '::1', 1776270570, '__ci_last_regenerate|i:1776270570;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('421e26ff77137f5ef2d7cb1659a34226609514de', '::1', 1776306347, '__ci_last_regenerate|i:1776306347;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4349d55783297830c7b68d504d56f1d94c1e15e0', '::1', 1776273513, '__ci_last_regenerate|i:1776273513;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4992c94e72ec913743253daf29a9100402bc965d', '::1', 1776269314, '__ci_last_regenerate|i:1776269314;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4b31b8c69febee9eed1d3f861a16c4931593b541', '::1', 1776279164, '__ci_last_regenerate|i:1776279164;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('512044672560f37e43414177ffeabd7fad398daa', '::1', 1776267455, '__ci_last_regenerate|i:1776267455;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('51ee13820731345bf22e30afd6fe3125940fa6c7', '::1', 1776278454, '__ci_last_regenerate|i:1776278454;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('616517aba05dbeff1ddf5e71cafe6057cd4bd7d5', '::1', 1776273878, '__ci_last_regenerate|i:1776273878;error_message|s:24:\"Pleasen Select Something\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('65125c69046e6a5795b9ab01bc514c611fd0fa6c', '::1', 1776276447, '__ci_last_regenerate|i:1776276447;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('72efd734489811c1b2609139700e4683e5c61ba1', '::1', 1776267140, '__ci_last_regenerate|i:1776267140;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('74ec607a98747e37aeab54f22cc7310fcb2b9231', '::1', 1776281290, '__ci_last_regenerate|i:1776281290;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7ac54c36fcdd1af1d71bb5fadfb58075544f954d', '::1', 1776270260, '__ci_last_regenerate|i:1776270260;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7d41bbae9bbf997fa77ed9f08c7798d9ac92792e', '::1', 1776306859, '__ci_last_regenerate|i:1776306859;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('84fbe16ec5f64687de0ab7ba2810bc962a887073', '::1', 1776268992, '__ci_last_regenerate|i:1776268992;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('888f1170ec728eddfd11c88ad6635ab24cf59318', '::1', 1776271367, '__ci_last_regenerate|i:1776271367;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8ca79c5c685e910d1d5ec42ef626ee56f3ae3c2b', '::1', 1776311447, '__ci_last_regenerate|i:1776311447;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:27:\"Grades Updated Successfully\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9006d3a3e7386a574279c7fc05c37fd7d284db7e', '::1', 1776272734, '__ci_last_regenerate|i:1776272734;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('911fd3bf41d24ae74ba9bf02527f9cd33eacd66c', '::1', 1776267762, '__ci_last_regenerate|i:1776267762;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('913e6defad9601869a4ff2885bbc930c2cafb4ac', '::1', 1776307259, '__ci_last_regenerate|i:1776307253;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('92da57813b54e77619f1c4fefff4a3a2a13f8fab', '::1', 1776281377, '__ci_last_regenerate|i:1776281290;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('92f602bf5beced48100f48fb89bd0cd5aaea0e2c', '::1', 1776312210, '__ci_last_regenerate|i:1776312210;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:27:\"Grades Updated Successfully\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9e3fb54489d2ec3eb0d59243db4b8de03c9664b4', '::1', 1776307491, '__ci_last_regenerate|i:1776307491;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:27:\"Grades Updated Successfully\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a16c5d76a4d76c84d62d7304b1e3b1fd01bd5a68', '::1', 1776311883, '__ci_last_regenerate|i:1776311883;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:27:\"Grades Updated Successfully\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a6569a61ec60f8b6751c8b24302095cba7052739', '::1', 1776275973, '__ci_last_regenerate|i:1776275973;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b3e077a794c16f4301df6f475b18716c44b30dc5', '::1', 1776268065, '__ci_last_regenerate|i:1776268065;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:12:\"Data Updated\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c3056732cf4349121c6f71d624f05a37db5b9c47', '::1', 1776277262, '__ci_last_regenerate|i:1776277262;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d292d15facfd72c9dbdcf4caa56c4c435aed9126', '::1', 1776276871, '__ci_last_regenerate|i:1776276871;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d41b4552314dc64ad671b713401de632c295d863', '::1', 1776279512, '__ci_last_regenerate|i:1776279512;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d7e747864f14b03b8eec5aea7632971ba055fb48', '::1', 1776277629, '__ci_last_regenerate|i:1776277629;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('de76701b43821ee7f353957521ef4e74b5c81473', '::1', 1776278012, '__ci_last_regenerate|i:1776278012;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ed4d1d51c727d8832924f1c0c7efafe231874e81', '::1', 1776268371, '__ci_last_regenerate|i:1776268371;error_message|s:23:\"Wrong Email Or Password\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ede18529072db2f4983864a9c4a6592826f60502', '::1', 1776312407, '__ci_last_regenerate|i:1776312210;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:27:\"Grades Updated Successfully\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ee01294c0a21da57a3e8e782d89fbd1b94c07dc9', '::1', 1776274802, '__ci_last_regenerate|i:1776274802;error_message|s:24:\"Pleasen Select Something\";__ci_vars|a:2:{s:13:\"error_message\";s:3:\"old\";s:13:\"flash_message\";s:3:\"old\";}login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:25:\"Data Updated Successfully\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f6366fe592630493bfec3dbe0d54fb4ebaeb19b7', '::1', 1776279852, '__ci_last_regenerate|i:1776279852;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fc4123f90a4dac3e77ccfa9dcfb5d8c5f5013ab5', '::1', 1776280781, '__ci_last_regenerate|i:1776280781;login_type|s:5:\"admin\";admin_login|s:1:\"1\";admin_id|s:1:\"1\";login_user_id|s:1:\"1\";name|s:13:\"Administrator\";tenant_id|s:1:\"1\";role_id|s:1:\"1\";permissions|a:20:{i:0;s:12:\"add_students\";i:1;s:12:\"collect_fees\";i:2;s:14:\"create_invoice\";i:3;s:14:\"delete_invoice\";i:4;s:15:\"delete_students\";i:5;s:12:\"edit_invoice\";i:6;s:13:\"edit_students\";i:7;s:14:\"manage_classes\";i:8;s:16:\"manage_enquiries\";i:9;s:12:\"manage_exams\";i:10;s:15:\"manage_expenses\";i:11;s:12:\"manage_roles\";i:12;s:15:\"manage_settings\";i:13;s:15:\"manage_teachers\";i:14;s:15:\"view_audit_logs\";i:15;s:14:\"view_dashboard\";i:16;s:14:\"view_enquiries\";i:17;s:13:\"view_expenses\";i:18;s:13:\"view_payments\";i:19;s:13:\"view_students\";}flash_message|s:18:\"Successfully Login\";__ci_vars|a:1:{s:13:\"flash_message\";s:3:\"old\";}');


#
# TABLE STRUCTURE FOR: circular
#

DROP TABLE IF EXISTS `circular`;

CREATE TABLE `circular` (
  `circular_id` int NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `reference` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`circular_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `circular` (`circular_id`, `title`, `reference`, `content`, `date`) VALUES (2, 'Meeting for all the members of the school', 'DF46SFGH', 'This is for all the teaching staff. Ensure you are all present.', '2018-08-24');


#
# TABLE STRUCTURE FOR: class
#

DROP TABLE IF EXISTS `class`;

CREATE TABLE `class` (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name_numeric` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `class` (`class_id`, `name`, `name_numeric`, `teacher_id`) VALUES (2, 'Nursery One', 'Nursery 1', 1);


#
# TABLE STRUCTURE FOR: club
#

DROP TABLE IF EXISTS `club`;

CREATE TABLE `club` (
  `club_id` int NOT NULL AUTO_INCREMENT,
  `club_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `desc` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`club_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `club` (`club_id`, `club_name`, `desc`, `date`) VALUES (1, 'Jet club', 'This is for those who love science.', '2019-08-25');


#
# TABLE STRUCTURE FOR: co_scholastic_marks
#

DROP TABLE IF EXISTS `co_scholastic_marks`;

CREATE TABLE `co_scholastic_marks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `class_id` int NOT NULL,
  `art_grade` varchar(5) NOT NULL DEFAULT '-',
  `pe_grade` varchar(5) NOT NULL DEFAULT '-',
  `work_grade` varchar(5) NOT NULL DEFAULT '-',
  `discipline_grade` varchar(5) NOT NULL DEFAULT '-',
  `conduct_grade` varchar(5) NOT NULL DEFAULT '-',
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `co_scholastic_marks` (`id`, `student_id`, `exam_id`, `class_id`, `art_grade`, `pe_grade`, `work_grade`, `discipline_grade`, `conduct_grade`, `remarks`) VALUES (1, 45, 5, 2, 'A', 'A', 'B', 'B', 'B', NULL);


#
# TABLE STRUCTURE FOR: department
#

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `department_code` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `department` (`department_id`, `name`, `department_code`) VALUES (2, 'Bursar', 'aed7c689d676c7c');


#
# TABLE STRUCTURE FOR: designation
#

DROP TABLE IF EXISTS `designation`;

CREATE TABLE `designation` (
  `designation_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `department_id` int NOT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `designation` (`designation_id`, `name`, `department_id`) VALUES (5, 'Tutorial', 2);
INSERT INTO `designation` (`designation_id`, `name`, `department_id`) VALUES (4, 'Udemy', 2);
INSERT INTO `designation` (`designation_id`, `name`, `department_id`) VALUES (6, 'Student', 2);


#
# TABLE STRUCTURE FOR: dormitory
#

DROP TABLE IF EXISTS `dormitory`;

CREATE TABLE `dormitory` (
  `dormitory_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `hostel_room_id` int NOT NULL,
  `hostel_category_id` int NOT NULL,
  `capacity` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`dormitory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `dormitory` (`dormitory_id`, `name`, `hostel_room_id`, `hostel_category_id`, `capacity`, `address`, `description`) VALUES (2, 'Wiz Hostel', 2, 3, '200', 'Address for hostel location', 'Address for hostel location');


#
# TABLE STRUCTURE FOR: enquiry
#

DROP TABLE IF EXISTS `enquiry`;

CREATE TABLE `enquiry` (
  `enquiry_id` int NOT NULL AUTO_INCREMENT,
  `category` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `purpose` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `whom_to_meet` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` timestamp NOT NULL,
  PRIMARY KEY (`enquiry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: enquiry_category
#

DROP TABLE IF EXISTS `enquiry_category`;

CREATE TABLE `enquiry_category` (
  `enquiry_category_id` int NOT NULL AUTO_INCREMENT,
  `category` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `purpose` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `whom` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`enquiry_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `enquiry_category` (`enquiry_category_id`, `category`, `purpose`, `whom`) VALUES (3, 'This is for ID 3 information.', 'Payment', 'Tutorial');
INSERT INTO `enquiry_category` (`enquiry_category_id`, `category`, `purpose`, `whom`) VALUES (4, 'This is Udemy Information', 'School fees information', 'Just edited now');


#
# TABLE STRUCTURE FOR: exam
#

DROP TABLE IF EXISTS `exam`;

CREATE TABLE `exam` (
  `exam_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `comment` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `academic_year` varchar(50) DEFAULT '2023-2024',
  PRIMARY KEY (`exam_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `exam` (`exam_id`, `name`, `comment`, `timestamp`, `academic_year`) VALUES (1, 'First Term Examination', 'First Term', '2019-10-30', '2023-2024');
INSERT INTO `exam` (`exam_id`, `name`, `comment`, `timestamp`, `academic_year`) VALUES (3, 'PT-1 (Pre-Mid Term)', 'Standard Term Exam', '', '2023-2024');
INSERT INTO `exam` (`exam_id`, `name`, `comment`, `timestamp`, `academic_year`) VALUES (4, 'Half-Yearly (Mid-Term)', 'Standard Term Exam', '', '2023-2024');
INSERT INTO `exam` (`exam_id`, `name`, `comment`, `timestamp`, `academic_year`) VALUES (5, 'Annual (Final) Exam', 'Standard Term Exam', '', '2023-2024');


#
# TABLE STRUCTURE FOR: exam_components
#

DROP TABLE IF EXISTS `exam_components`;

CREATE TABLE `exam_components` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `max_marks` int NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (1, 4, 'PT', 10);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (2, 4, 'NOTEBOOK', 5);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (3, 4, 'ENRICHMENT', 5);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (4, 4, 'WRITTEN', 80);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (5, 5, 'PT', 10);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (6, 5, 'NOTEBOOK', 5);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (7, 5, 'ENRICHMENT', 5);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (8, 5, 'WRITTEN', 80);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (9, 6, 'PT', 10);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (10, 6, 'NOTEBOOK', 5);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (11, 6, 'ENRICHMENT', 5);
INSERT INTO `exam_components` (`id`, `subject_id`, `component_name`, `max_marks`) VALUES (12, 6, 'WRITTEN', 80);


#
# TABLE STRUCTURE FOR: exam_question
#

DROP TABLE IF EXISTS `exam_question`;

CREATE TABLE `exam_question` (
  `exam_question_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `teacher_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `subject_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`exam_question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: exam_remarks
#

DROP TABLE IF EXISTS `exam_remarks`;

CREATE TABLE `exam_remarks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `exam_remarks` (`id`, `student_id`, `teacher_id`, `exam_id`, `text`) VALUES (1, 45, 1, 1, 'Good performance.');


#
# TABLE STRUCTURE FOR: exam_results
#

DROP TABLE IF EXISTS `exam_results`;

CREATE TABLE `exam_results` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `class_id` int NOT NULL,
  `total_marks` float NOT NULL,
  `percentage` float NOT NULL,
  `grade` varchar(10) NOT NULL,
  `class_rank` int DEFAULT NULL,
  `section_rank` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `exam_results` (`id`, `student_id`, `exam_id`, `class_id`, `total_marks`, `percentage`, `grade`, `class_rank`, `section_rank`) VALUES (1, 45, 5, 2, '279', '93', 'A1', NULL, NULL);


#
# TABLE STRUCTURE FOR: expense_category
#

DROP TABLE IF EXISTS `expense_category`;

CREATE TABLE `expense_category` (
  `expense_category_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`expense_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `expense_category` (`expense_category_id`, `name`) VALUES (5, 'Reading Books.');


#
# TABLE STRUCTURE FOR: hostel_attendance
#

DROP TABLE IF EXISTS `hostel_attendance`;

CREATE TABLE `hostel_attendance` (
  `hostel_attendance_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `date` date NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0:Undefine, 1:Present(In), 2:Absent(Out), 3:Late, 4:HalfDay',
  `scan_time` datetime NOT NULL,
  PRIMARY KEY (`hostel_attendance_id`),
  KEY `student_id` (`student_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

#
# TABLE STRUCTURE FOR: hostel_category
#

DROP TABLE IF EXISTS `hostel_category`;

CREATE TABLE `hostel_category` (
  `hostel_category_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`hostel_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `hostel_category` (`hostel_category_id`, `name`, `description`) VALUES (2, 'Female', 'This is for female only.');
INSERT INTO `hostel_category` (`hostel_category_id`, `name`, `description`) VALUES (3, 'Male', 'This is for male only. Female are not allowed.');


#
# TABLE STRUCTURE FOR: hostel_room
#

DROP TABLE IF EXISTS `hostel_room`;

CREATE TABLE `hostel_room` (
  `hostel_room_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `room_type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `num_bed` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cost_bed` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`hostel_room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `hostel_room` (`hostel_room_id`, `name`, `room_type`, `num_bed`, `cost_bed`, `description`) VALUES (2, 'Room One', 'Single', '2', '5000', 'This is for the big guys among us.');


#
# TABLE STRUCTURE FOR: house
#

DROP TABLE IF EXISTS `house`;

CREATE TABLE `house` (
  `house_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`house_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `house` (`house_id`, `name`, `description`) VALUES (1, 'Purple House', 'This is for students in purple house');


#
# TABLE STRUCTURE FOR: invoice
#

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `invoice_id` int NOT NULL AUTO_INCREMENT,
  `invoice_number` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `student_id` int NOT NULL,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `discount` int NOT NULL,
  `amount_paid` int NOT NULL,
  `due` int NOT NULL,
  `creation_timestamp` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_method` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `year` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `invoice` (`invoice_id`, `invoice_number`, `student_id`, `title`, `description`, `amount`, `discount`, `amount_paid`, `due`, `creation_timestamp`, `payment_method`, `status`, `year`) VALUES (2, '742593INV2019', 45, 'Another Part payment for eLibrary', 'Another Part payment for eLibrary.', 7000, 0, 6200, 800, '2019-11-12', '1', 2, '2019-2020');
INSERT INTO `invoice` (`invoice_id`, `invoice_number`, `student_id`, `title`, `description`, `amount`, `discount`, `amount_paid`, `due`, `creation_timestamp`, `payment_method`, `status`, `year`) VALUES (4, '797604', 45, 'School fee', 'without books only school fee', 10000, 0, 2996, 7004, '2026-04-14', '2', 2, '2019-2020');


#
# TABLE STRUCTURE FOR: language
#

DROP TABLE IF EXISTS `language`;

CREATE TABLE `language` (
  `phrase_id` int NOT NULL AUTO_INCREMENT,
  `phrase` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `english` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `arabic` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `french` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `korea` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`phrase_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40558 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `language` (`phrase_id`, `phrase`, `english`, `arabic`, `french`, `korea`) VALUES (1, 'Manage Language', 'Manage Language', 'إدارة اللغة', NULL, NULL);
INSERT INTO `language` (`phrase_id`, `phrase`, `english`, `arabic`, `french`, `korea`) VALUES (2, 'active language', 'Active Language', 'اللغة النشطة', NULL, NULL);
INSERT INTO `language` (`phrase_id`, `phrase`, `english`, `arabic`, `french`, `korea`) VALUES (40557, 'add', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: language_list
#

DROP TABLE IF EXISTS `language_list`;

CREATE TABLE `language_list` (
  `language_list_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `db_field` varchar(300) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`language_list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: leave
#

DROP TABLE IF EXISTS `leave`;

CREATE TABLE `leave` (
  `leave_id` int NOT NULL AUTO_INCREMENT,
  `leave_code` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `teacher_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `start_date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `end_date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `reason` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: leave_requests
#

DROP TABLE IF EXISTS `leave_requests`;

CREATE TABLE `leave_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `leave_type` varchar(100) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# TABLE STRUCTURE FOR: library
#

DROP TABLE IF EXISTS `library`;

CREATE TABLE `library` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT '',
  `isbn` varchar(50) DEFAULT '',
  `category` varchar(100) DEFAULT 'General',
  `quantity` int NOT NULL DEFAULT '1',
  `available` int NOT NULL DEFAULT '1',
  `rack_number` varchar(50) DEFAULT '',
  `added_date` date DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# TABLE STRUCTURE FOR: mark
#

DROP TABLE IF EXISTS `mark`;

CREATE TABLE `mark` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `class_id` int NOT NULL,
  `component_type` varchar(50) NOT NULL,
  `marks_obtained` varchar(10) NOT NULL,
  `max_marks` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;

INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (1, 45, 4, 3, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (2, 45, 5, 1, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (3, 45, 4, 1, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (4, 45, 6, 1, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (5, 45, 5, 3, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (6, 45, 6, 3, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (7, 45, 5, 1, 2, 'PT', '10', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (8, 45, 5, 1, 2, 'NOTEBOOK', '9', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (9, 45, 5, 1, 2, 'ENRICHMENT', '8', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (10, 45, 5, 1, 2, 'WRITTEN', '70', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (11, 45, 4, 1, 2, 'PT', '10', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (12, 45, 4, 1, 2, 'NOTEBOOK', '7', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (13, 45, 4, 1, 2, 'ENRICHMENT', '9', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (14, 45, 4, 1, 2, 'WRITTEN', '69', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (15, 45, 6, 1, 2, 'PT', '0', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (16, 45, 6, 1, 2, 'NOTEBOOK', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (17, 45, 6, 1, 2, 'ENRICHMENT', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (18, 45, 6, 1, 2, 'WRITTEN', '0', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (19, 0, 5, 1, 2, 'PT', '0', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (20, 0, 5, 1, 2, 'NOTEBOOK', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (21, 0, 5, 1, 2, 'ENRICHMENT', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (22, 0, 5, 1, 2, 'WRITTEN', '0', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (23, 0, 4, 1, 2, 'PT', '0', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (24, 0, 4, 1, 2, 'NOTEBOOK', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (25, 0, 4, 1, 2, 'ENRICHMENT', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (26, 0, 4, 1, 2, 'WRITTEN', '0', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (27, 0, 6, 1, 2, 'PT', '0', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (28, 0, 6, 1, 2, 'NOTEBOOK', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (29, 0, 6, 1, 2, 'ENRICHMENT', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (30, 0, 6, 1, 2, 'WRITTEN', '0', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (31, 45, 0, 1, 2, 'PT', '0', 10);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (32, 45, 0, 1, 2, 'NOTEBOOK', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (33, 45, 0, 1, 2, 'ENRICHMENT', '0', 5);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (34, 45, 0, 1, 2, 'WRITTEN', '0', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (35, 45, 5, 4, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (36, 45, 4, 4, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (37, 45, 6, 4, 2, '', '', 0);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (38, 45, 4, 5, 2, 'WRITTEN', '89', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (39, 45, 5, 5, 2, 'WRITTEN', '94', 80);
INSERT INTO `mark` (`id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `component_type`, `marks_obtained`, `max_marks`) VALUES (40, 45, 6, 5, 2, 'WRITTEN', '96', 80);


#
# TABLE STRUCTURE FOR: mark_old
#

DROP TABLE IF EXISTS `mark_old`;

CREATE TABLE `mark_old` (
  `mark_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `exam_id` int NOT NULL,
  `class_id` int NOT NULL,
  `class_score1` int NOT NULL,
  `class_score2` int NOT NULL,
  `class_score3` int NOT NULL,
  `exam_score` int NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`mark_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (1, 45, 5, 1, 2, 10, 9, 8, 70, 'Good performance.');
INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (2, 45, 4, 1, 2, 10, 7, 9, 69, 'Excellent performance.');
INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (3, 45, 6, 1, 2, 0, 0, 0, 0, '');
INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (4, 0, 5, 1, 2, 0, 0, 0, 0, '');
INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (5, 0, 4, 1, 2, 0, 0, 0, 0, '');
INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (6, 0, 6, 1, 2, 0, 0, 0, 0, '');
INSERT INTO `mark_old` (`mark_id`, `student_id`, `subject_id`, `exam_id`, `class_id`, `class_score1`, `class_score2`, `class_score3`, `exam_score`, `comment`) VALUES (7, 45, 0, 1, 2, 0, 0, 0, 0, '');


#
# TABLE STRUCTURE FOR: material
#

DROP TABLE IF EXISTS `material`;

CREATE TABLE `material` (
  `material_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `material` (`material_id`, `name`, `class_id`, `subject_id`, `teacher_id`, `description`, `file_name`, `file_type`, `timestamp`) VALUES (1, 'Study material for Nursery One', 2, 5, 1, 'This is for class only.', 'profile.png', 'docx', '2018-08-19');


#
# TABLE STRUCTURE FOR: noticeboard
#

DROP TABLE IF EXISTS `noticeboard`;

CREATE TABLE `noticeboard` (
  `noticeboard_id` int NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `location` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` int NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`noticeboard_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `noticeboard` (`noticeboard_id`, `title`, `location`, `timestamp`, `description`) VALUES (3, 'Second meeting coming up soon', 'Udemy Forum', 1575136800, 'The meeting is coming up soon. Ensure you are fully prepared.');
INSERT INTO `noticeboard` (`noticeboard_id`, `title`, `location`, `timestamp`, `description`) VALUES (4, 'Parent Teacher Association Meeting.', 'Ontario Location', 1575050400, 'This is the new updated information as regards the meeting.');


#
# TABLE STRUCTURE FOR: parent
#

DROP TABLE IF EXISTS `parent`;

CREATE TABLE `parent` (
  `parent_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `profession` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `login_status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_phone` varchar(20) DEFAULT NULL,
  `father_email` varchar(100) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `father_aadhaar` varchar(20) DEFAULT NULL,
  `father_qualification` varchar(100) DEFAULT NULL,
  `father_annual_income` varchar(30) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_phone` varchar(20) DEFAULT NULL,
  `mother_email` varchar(100) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `mother_aadhaar` varchar(20) DEFAULT NULL,
  `mother_qualification` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `parent` (`parent_id`, `name`, `email`, `password`, `phone`, `address`, `profession`, `login_status`, `father_name`, `father_phone`, `father_email`, `father_occupation`, `father_aadhaar`, `father_qualification`, `father_annual_income`, `mother_name`, `mother_phone`, `mother_email`, `mother_occupation`, `mother_aadhaar`, `mother_qualification`) VALUES (4, 'Mr. Parent', 'parent@parent.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '+912345667', 'Udemy Address', 'Learners', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: payment
#

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `expense_category_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `invoice_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `student_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `method` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `amount` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `discount` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `timestamp` int NOT NULL,
  `year` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (2, '5', 'Purchase of school reading', 'expense', '', '', '2', 'This was purchase by the school administrator for the purpose of having reading books in the school.<br>', '5000', '', 556644564, '2019-2020');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (5, '5', 'Purchase of school chalks', 'expense', '', '', '1', 'Purchase of school chalks<br>', '3000', '', 556644564, '2019-2020');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (6, '', 'Part payment for eLibrary', '', '2', '45', '1', 'income', '5000', '0', 556644564, '');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (7, '', 'Another payment for eLibrary', 'income', '3', '45', '1', 'Another payment for eLibrary', '2000', '0', 445667865, '');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (8, '', 'Part payment for eLibrary', 'income', '2', '45', '1', 'Part payment for eLibrary', '1200', '', 556644564, '');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (9, '5', 'New chalk purchased', 'expense', '', '', '3', 'New chalk purchased<br>', '1000', '', 556644564, '2019-2020');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (10, '', 'Another Part payment for eLibrary.', 'income', '2', '45', '1', 'Another Part payment for eLibrary.', '5000', '', 1576951200, '2019-2020');
INSERT INTO `payment` (`payment_id`, `expense_category_id`, `title`, `payment_type`, `invoice_id`, `student_id`, `method`, `description`, `amount`, `discount`, `timestamp`, `year`) VALUES (11, '', 'School fee', 'income', '4', '45', '2', 'without books only school fee', '10000', '0', 1776103200, '2019-2020');


#
# TABLE STRUCTURE FOR: payment_ledger
#

DROP TABLE IF EXISTS `payment_ledger`;

CREATE TABLE `payment_ledger` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `payroll_id` bigint NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `transaction_ref` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `payment_ledger` (`id`, `payroll_id`, `amount`, `method`, `status`, `transaction_ref`) VALUES ('1', '1', '5000.00', 'Bank Transfer', 'SUCCESS', '');
INSERT INTO `payment_ledger` (`id`, `payroll_id`, `amount`, `method`, `status`, `transaction_ref`) VALUES ('2', '2', '21227.50', 'Bank Transfer', 'SUCCESS', 'ak2jdi208nkjhehiji4');


#
# TABLE STRUCTURE FOR: payroll
#

DROP TABLE IF EXISTS `payroll`;

CREATE TABLE `payroll` (
  `payroll_id` bigint NOT NULL AUTO_INCREMENT,
  `employee_id` bigint NOT NULL,
  `school_id` bigint DEFAULT NULL,
  `month` int NOT NULL,
  `year` int NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL DEFAULT '0.00',
  `allowances` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deductions` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_salary` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int NOT NULL DEFAULT '0' COMMENT '0=Draft, 1=Generated, 2=Paid, 3=Failed',
  `is_locked` tinyint(1) DEFAULT '0',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `payslip_no` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gross_salary` decimal(10,2) NOT NULL DEFAULT '0.00',
  `epf` decimal(10,2) NOT NULL DEFAULT '0.00',
  `esi` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tds` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`payroll_id`),
  UNIQUE KEY `unique_payroll_month` (`employee_id`,`month`,`year`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `payroll` (`payroll_id`, `employee_id`, `school_id`, `month`, `year`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `status`, `is_locked`, `payment_method`, `payment_date`, `transaction_reference`, `payslip_no`, `created_at`, `updated_at`, `gross_salary`, `epf`, `esi`, `pt`, `tds`) VALUES ('1', '1', NULL, 4, 2026, '5000.00', '0.00', '0.00', '5000.00', 2, 1, 'Bank Transfer', '2026-04-14 23:54:37', '', 'PAY-2604-7356', '2026-04-14 23:23:57', '2026-04-14 23:24:37', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `payroll` (`payroll_id`, `employee_id`, `school_id`, `month`, `year`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `status`, `is_locked`, `payment_method`, `payment_date`, `transaction_reference`, `payslip_no`, `created_at`, `updated_at`, `gross_salary`, `epf`, `esi`, `pt`, `tds`) VALUES ('2', '2', NULL, 4, 2026, '15000.00', '9000.00', '2772.50', '21227.50', 2, 1, 'Bank Transfer', '2026-04-15 07:27:51', 'ak2jdi208nkjhehiji4', 'PAY-2604-9794', '2026-04-15 06:57:08', '2026-04-15 06:57:51', '0.00', '0.00', '0.00', '0.00', '0.00');


#
# TABLE STRUCTURE FOR: payroll_audit_logs
#

DROP TABLE IF EXISTS `payroll_audit_logs`;

CREATE TABLE `payroll_audit_logs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `payroll_id` bigint NOT NULL,
  `action` varchar(255) NOT NULL,
  `performed_by` bigint NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `payroll_audit_logs` (`id`, `payroll_id`, `action`, `performed_by`, `timestamp`) VALUES ('1', '1', 'System Auto-Generated', '1', '2026-04-14 23:53:57');
INSERT INTO `payroll_audit_logs` (`id`, `payroll_id`, `action`, `performed_by`, `timestamp`) VALUES ('2', '1', 'Salary Marked as Paid by Admin', '1', '2026-04-14 23:54:37');
INSERT INTO `payroll_audit_logs` (`id`, `payroll_id`, `action`, `performed_by`, `timestamp`) VALUES ('3', '2', 'System Auto-Generated', '1', '2026-04-15 07:27:08');
INSERT INTO `payroll_audit_logs` (`id`, `payroll_id`, `action`, `performed_by`, `timestamp`) VALUES ('4', '2', 'Salary Marked as Paid by Admin', '1', '2026-04-15 07:27:51');


#
# TABLE STRUCTURE FOR: payroll_items
#

DROP TABLE IF EXISTS `payroll_items`;

CREATE TABLE `payroll_items` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `payroll_id` bigint NOT NULL,
  `type` enum('allowance','deduction') NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('1', '2', 'allowance', 'House Rent Allowance (HRA)', '3000.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('2', '2', 'allowance', 'Dearness Allowance (DA)', '1500.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('3', '2', 'allowance', 'Conveyance Allowance', '750.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('4', '2', 'allowance', 'Medical Allowance', '750.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('5', '2', 'allowance', 'Special Allowance', '3000.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('6', '2', 'deduction', 'Employee Provident Fund (EPF)', '1800.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('7', '2', 'deduction', 'Employee State Insurance (ESI)', '112.50');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('8', '2', 'deduction', 'Professional Tax (PT)', '200.00');
INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `amount`) VALUES ('9', '2', 'deduction', 'Tax Deducted at Source (TDS)', '660.00');


#
# TABLE STRUCTURE FOR: permissions
#

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `module` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (1, 'view_dashboard', 'View dashboard', 'general');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (2, 'view_payments', 'View payment records', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (3, 'create_invoice', 'Create invoices', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (4, 'edit_invoice', 'Edit invoices', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (5, 'delete_invoice', 'Delete invoices', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (6, 'collect_fees', 'Collect student fees', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (7, 'view_expenses', 'View expenses', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (8, 'manage_expenses', 'Add/edit/delete expenses', 'finance');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (9, 'view_students', 'View student list', 'admission');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (10, 'add_students', 'Add/admit new students', 'admission');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (11, 'edit_students', 'Edit student records', 'admission');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (12, 'delete_students', 'Delete students', 'admission');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (13, 'view_enquiries', 'View enquiries', 'admission');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (14, 'manage_enquiries', 'Add/edit/delete enquiries', 'admission');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (15, 'manage_teachers', 'CRUD teachers', 'hr');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (16, 'manage_classes', 'CRUD classes & sections', 'academic');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (17, 'manage_exams', 'CRUD exams & marks', 'academic');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (18, 'manage_settings', 'System settings', 'system');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (19, 'manage_roles', 'Manage roles & users', 'system');
INSERT INTO `permissions` (`permission_id`, `name`, `description`, `module`) VALUES (20, 'view_audit_logs', 'View audit trail', 'system');


#
# TABLE STRUCTURE FOR: rfid_attendance_log
#

DROP TABLE IF EXISTS `rfid_attendance_log`;

CREATE TABLE `rfid_attendance_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `device_id` int NOT NULL,
  `card_number` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_type` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'unknown',
  `user_id` int NOT NULL DEFAULT '0',
  `scan_time` datetime NOT NULL,
  `direction` enum('in','out') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'in',
  `synced` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=written to attendance, 0=pending',
  PRIMARY KEY (`log_id`),
  KEY `idx_cooldown_check` (`card_number`,`scan_time`),
  KEY `idx_device` (`device_id`),
  KEY `idx_scan_time` (`scan_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

#
# TABLE STRUCTURE FOR: rfid_cards
#

DROP TABLE IF EXISTS `rfid_cards`;

CREATE TABLE `rfid_cards` (
  `card_id` int NOT NULL AUTO_INCREMENT,
  `card_number` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_type` enum('student','teacher') COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=disabled',
  `assigned_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`card_id`),
  UNIQUE KEY `uk_card_number` (`card_number`),
  KEY `idx_user_lookup` (`user_type`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

#
# TABLE STRUCTURE FOR: rfid_devices
#

DROP TABLE IF EXISTS `rfid_devices`;

CREATE TABLE `rfid_devices` (
  `device_id` int NOT NULL AUTO_INCREMENT,
  `device_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `device_brand` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'zkteco, essl, hikvision',
  `device_ip` varchar(45) COLLATE utf8mb3_unicode_ci NOT NULL,
  `device_serial` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `device_type` enum('school','hostel') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'school',
  `api_key` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `last_heartbeat` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`device_id`),
  UNIQUE KEY `uk_device_serial` (`device_serial`),
  UNIQUE KEY `uk_api_key` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

#
# TABLE STRUCTURE FOR: role_permissions
#

DROP TABLE IF EXISTS `role_permissions`;

CREATE TABLE `role_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_perm` (`role_id`,`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (16, 1, 1);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (19, 1, 2);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (3, 1, 3);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (6, 1, 4);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (4, 1, 5);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (2, 1, 6);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (18, 1, 7);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (11, 1, 8);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (20, 1, 9);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (1, 1, 10);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (7, 1, 11);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (5, 1, 12);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (17, 1, 13);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (9, 1, 14);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (14, 1, 15);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (8, 1, 16);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (10, 1, 17);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (13, 1, 18);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (12, 1, 19);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (15, 1, 20);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (32, 2, 1);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (33, 2, 2);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (34, 2, 3);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (35, 2, 4);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (36, 2, 5);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (37, 2, 6);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (38, 2, 7);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (39, 2, 8);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (47, 3, 1);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (48, 3, 9);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (49, 3, 10);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (50, 3, 11);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (51, 3, 12);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (52, 3, 13);
INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES (53, 3, 14);


#
# TABLE STRUCTURE FOR: roles
#

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `roles` (`role_id`, `name`, `description`, `is_system`) VALUES (1, 'admin', 'Full system access', 1);
INSERT INTO `roles` (`role_id`, `name`, `description`, `is_system`) VALUES (2, 'accountant', 'Finance & fee management', 1);
INSERT INTO `roles` (`role_id`, `name`, `description`, `is_system`) VALUES (3, 'admission', 'Student admissions & enquiries', 1);


#
# TABLE STRUCTURE FOR: salary_structures
#

DROP TABLE IF EXISTS `salary_structures`;

CREATE TABLE `salary_structures` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `employee_id` bigint NOT NULL,
  `basic` decimal(10,2) NOT NULL DEFAULT '0.00',
  `hra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pf` decimal(10,2) NOT NULL DEFAULT '0.00',
  `esi` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pt` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `salary_structures` (`id`, `employee_id`, `basic`, `hra`, `pf`, `esi`, `tax`, `pt`) VALUES ('1', '1', '0.00', '0.00', '134.00', '0.00', '0.00', '0.00');
INSERT INTO `salary_structures` (`id`, `employee_id`, `basic`, `hra`, `pf`, `esi`, `tax`, `pt`) VALUES ('2', '2', '15000.00', '0.00', '0.00', '0.00', '0.00', '0.00');


#
# TABLE STRUCTURE FOR: section
#

DROP TABLE IF EXISTS `section`;

CREATE TABLE `section` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nick_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `section` (`section_id`, `name`, `nick_name`, `class_id`, `teacher_id`) VALUES (3, 'First Term', 'Term 1', 2, 1);
INSERT INTO `section` (`section_id`, `name`, `nick_name`, `class_id`, `teacher_id`) VALUES (4, 'Second Term', '2nd', 2, 1);


#
# TABLE STRUCTURE FOR: settings
#

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `settings_id` int NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (1, 'system_name', 'Viswabharathi High School');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (2, 'system_title', 'Viswabharathi HIgh School');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (3, 'address', 'Goothi Road, Banaganapalli');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (4, 'phone', '+1564783934');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (6, 'currency', '₹');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (7, 'system_email', 'payment@optimumlinkup.com');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (11, 'language', 'english');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (12, 'text_align', 'left-to-right');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (16, 'skin_colour', 'green');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (21, 'session', '2025-2026');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (22, 'footer', 'Chaturveda Software Solutions. All Rights Reserved.');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (116, 'paypal_email', 'info@gosfem.com');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (119, 'stripe_setting', '[{\"stripe_active\":\"1\",\"testmode\":\"off\",\"secret_key\":\"test secret key\",\"public_key\":\"test public key\",\"secret_live_key\":\"live secret key\",\"public_live_key\":\"live public key\"}]');
INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES (122, 'paypal_setting', '[{\"paypal_active\":\"1\",\"paypal_mode\":\"sandbox\",\"sandbox_client_id\":\"client id sandbox\",\"production_client_id\":\"client - production\"}]');


#
# TABLE STRUCTURE FOR: sms_settings
#

DROP TABLE IF EXISTS `sms_settings`;

CREATE TABLE `sms_settings` (
  `sms_setting_id` int NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `info` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`sms_setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (12, 'msg91_sender_id', 'sender id');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (11, 'msg91_authentication_key', 'msg91 auth key');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (10, 'clickatell_apikey', 'clickattel api');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (9, 'clickatell_password', 'clickattel paasword');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (8, 'clickatell_username', 'clickattel username');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (13, 'msg91_route', 'route');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (14, 'msg91_country_code', 'country code');
INSERT INTO `sms_settings` (`sms_setting_id`, `type`, `info`) VALUES (15, 'active_sms_gateway', 'msg91');


#
# TABLE STRUCTURE FOR: social_category
#

DROP TABLE IF EXISTS `social_category`;

CREATE TABLE `social_category` (
  `social_category_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `colour` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `icon` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`social_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `social_category` (`social_category_id`, `name`, `colour`, `icon`, `description`) VALUES (2, 'Romance', 'danger', 'fa-male', 'This is for romance chat room');
INSERT INTO `social_category` (`social_category_id`, `name`, `colour`, `icon`, `description`) VALUES (3, 'Event', 'primary', 'fa-book', 'This is for event chat room');


#
# TABLE STRUCTURE FOR: student
#

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `birthday` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `age` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `place_birth` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sex` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `m_tongue` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `religion` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `blood_group` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `city` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `state` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nationality` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ps_attended` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ps_address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ps_purpose` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_study` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date_of_leaving` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `am_date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `tran_cert` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dob_cert` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mark_join` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `physical_h` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `father_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mother_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_id` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `section_id` int NOT NULL,
  `parent_id` int NOT NULL,
  `roll` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `transport_id` int NOT NULL,
  `dormitory_id` int NOT NULL,
  `house_id` int NOT NULL,
  `student_category_id` int NOT NULL,
  `club_id` int NOT NULL,
  `session` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `card_number` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `issue_date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `expire_date` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dormitory_room_number` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `more_entries` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `login_status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `aadhaar_number` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `appar_number` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `caste` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sub_caste` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `medium` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `identification_mark_1` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `identification_mark_2` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bank_ifsc` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `student` (`student_id`, `name`, `birthday`, `age`, `place_birth`, `sex`, `m_tongue`, `religion`, `blood_group`, `address`, `city`, `state`, `nationality`, `phone`, `email`, `ps_attended`, `ps_address`, `ps_purpose`, `class_study`, `date_of_leaving`, `am_date`, `tran_cert`, `dob_cert`, `mark_join`, `physical_h`, `password`, `father_name`, `mother_name`, `class_id`, `section_id`, `parent_id`, `roll`, `transport_id`, `dormitory_id`, `house_id`, `student_category_id`, `club_id`, `session`, `card_number`, `issue_date`, `expire_date`, `dormitory_room_number`, `more_entries`, `login_status`, `aadhaar_number`, `appar_number`, `caste`, `sub_caste`, `medium`, `identification_mark_1`, `identification_mark_2`, `bank_name`, `bank_account_number`, `bank_ifsc`) VALUES (45, 'Testing Student', '09/30/2003', '16', 'Lagos', 'female', 'Mother Tongue', 'Muslim', 'B+', 'Address', 'City', 'Lagos', 'Canadian', '+912345667', 'student@student.com', 'Previous school attended', 'Previous school address', 'Purpose Of Leaving', 'Class In Which Was Studying', '2011-08-10', '2011-08-19', 'Yes', 'Yes', 'Yes', 'No', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '', '2', 0, 4, '5bf8161', 0, 2, 1, 2, 1, '2019-2020', '', '', '', '', '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: student_category
#

DROP TABLE IF EXISTS `student_category`;

CREATE TABLE `student_category` (
  `student_category_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`student_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `student_category` (`student_category_id`, `name`, `description`) VALUES (2, 'Boarding Student', 'This is for the boarding student.');


#
# TABLE STRUCTURE FOR: subject
#

DROP TABLE IF EXISTS `subject`;

CREATE TABLE `subject` (
  `subject_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `subject` (`subject_id`, `name`, `class_id`, `teacher_id`) VALUES (5, 'Economics', 2, 1);
INSERT INTO `subject` (`subject_id`, `name`, `class_id`, `teacher_id`) VALUES (4, 'Mathematics', 2, 1);
INSERT INTO `subject` (`subject_id`, `name`, `class_id`, `teacher_id`) VALUES (6, 'English', 2, 1);


#
# TABLE STRUCTURE FOR: teacher
#

DROP TABLE IF EXISTS `teacher`;

CREATE TABLE `teacher` (
  `teacher_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `teacher_number` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `birthday` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sex` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `religion` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `blood_group` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `facebook` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `twitter` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `googleplus` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `linkedin` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `qualification` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `marital_status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `department_id` int NOT NULL,
  `designation_id` int NOT NULL,
  `date_of_joining` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `joining_salary` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `date_of_leaving` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bank_id` int NOT NULL,
  `login_status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `experience` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pan_num` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `aadhaar_num` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `uan_num` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `esi_num` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bank_account` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `bank_ifsc` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `teacher` (`teacher_id`, `name`, `role`, `teacher_number`, `birthday`, `sex`, `religion`, `blood_group`, `address`, `phone`, `email`, `facebook`, `twitter`, `googleplus`, `linkedin`, `qualification`, `marital_status`, `file_name`, `password`, `department_id`, `designation_id`, `date_of_joining`, `joining_salary`, `status`, `date_of_leaving`, `bank_id`, `login_status`, `experience`, `pan_num`, `aadhaar_num`, `uan_num`, `esi_num`, `bank_account`, `bank_ifsc`) VALUES (1, 'Testing Teacher', '1', 'f82e5cc', '2018-08-19', 'male', 'Christianity', 'B+', '546787, Kertz shopping complext, Silicon Valley, United State of America, New York city.', '+912345667', 'teacher@teacher.com', 'facebook', 'twitter', 'googleplus', 'linkedin', 'PhD', 'Married', 'profile.png', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 2, 4, '2019-09-15', '5000', 1, '2019-09-18', 3, '0', '', '', '', '', '', NULL, NULL);
INSERT INTO `teacher` (`teacher_id`, `name`, `role`, `teacher_number`, `birthday`, `sex`, `religion`, `blood_group`, `address`, `phone`, `email`, `facebook`, `twitter`, `googleplus`, `linkedin`, `qualification`, `marital_status`, `file_name`, `password`, `department_id`, `designation_id`, `date_of_joining`, `joining_salary`, `status`, `date_of_leaving`, `bank_id`, `login_status`, `experience`, `pan_num`, `aadhaar_num`, `uan_num`, `esi_num`, `bank_account`, `bank_ifsc`) VALUES (2, 'Basireddy harinathareddy', '1', 'eb4d1ea', '1998-02-03', 'male', 'Hindu', 'o', '1-253-11, near power station, banaganapalle', '09440388737', 'harireddypraba143@gmail.com', '', '', '', '', 'B.E.D', 'Single', 'office.png', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 5, '2026-03-01', '15000', 1, '2026-03-01', 5, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: teacher_attendance
#

DROP TABLE IF EXISTS `teacher_attendance`;

CREATE TABLE `teacher_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=undefined, 1=present, 2=absent, 3=late, 4=half_day',
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `source` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'manual' COMMENT 'manual or rfid',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_teacher_date` (`teacher_id`,`date`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

#
# TABLE STRUCTURE FOR: transport
#

DROP TABLE IF EXISTS `transport`;

CREATE TABLE `transport` (
  `transport_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `transport_route_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `route_fare` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`transport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: transport_route
#

DROP TABLE IF EXISTS `transport_route`;

CREATE TABLE `transport_route` (
  `transport_route_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`transport_route_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `transport_route` (`transport_route_id`, `name`, `description`) VALUES (2, 'Toronto to Usa', 'This is vehicle is going from Canada to Usa');
INSERT INTO `transport_route` (`transport_route_id`, `name`, `description`) VALUES (3, 'Lagos to Canada', 'This is going to Canada');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '1',
  `role_id` int NOT NULL DEFAULT '1',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `failed_attempts` int NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `locked_until` datetime DEFAULT NULL,
  `login_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_tenant` (`email`(191),`tenant_id`),
  KEY `role_id` (`role_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `users` (`user_id`, `tenant_id`, `role_id`, `name`, `email`, `phone`, `address`, `password_hash`, `reset_token`, `reset_token_expiry`, `failed_attempts`, `is_locked`, `locked_until`, `login_status`, `created_at`, `updated_at`) VALUES (1, 1, 1, 'Administrator', 'admin@admin.com', '07133445656', NULL, '$2y$12$I9e.EpUfyNVDkoWmerk/8uZmeOuPfFEnC8BmrWFUI9E6U120Gt49K', NULL, NULL, 0, 0, NULL, 1, '2026-04-14 18:16:15', '2026-04-15 23:24:38');
INSERT INTO `users` (`user_id`, `tenant_id`, `role_id`, `name`, `email`, `phone`, `address`, `password_hash`, `reset_token`, `reset_token_expiry`, `failed_attempts`, `is_locked`, `locked_until`, `login_status`, `created_at`, `updated_at`) VALUES (2, 1, 1, 'Udemy Instructor', 'udemy@udemy.com', '+1564783934', NULL, '$2y$12$xeNMPzdeNeVGipBavs.UQOWCnRv82Fj0hAQr.LsItP34r4nLaRADG', NULL, NULL, 0, 0, NULL, 0, '2026-04-14 18:16:15', NULL);
INSERT INTO `users` (`user_id`, `tenant_id`, `role_id`, `name`, `email`, `phone`, `address`, `password_hash`, `reset_token`, `reset_token_expiry`, `failed_attempts`, `is_locked`, `locked_until`, `login_status`, `created_at`, `updated_at`) VALUES (3, 1, 3, 'harinatha reddy', 'hari@a.com', '', NULL, '$2y$12$9aVKBbpg1SSxIzgUQwxbB.wc1B4wfR124O9P5eCKp/tVPboJS4lVS', NULL, NULL, 0, 0, NULL, 0, '2026-04-14 18:27:29', '2026-04-14 22:13:38');


#
# TABLE STRUCTURE FOR: vehicle
#

DROP TABLE IF EXISTS `vehicle`;

CREATE TABLE `vehicle` (
  `vehicle_id` int NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `vehicle_number` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `vehicle_model` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `vehicle_quantity` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `year_made` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `driver_name` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `driver_license` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `driver_contact` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `vehicle` (`vehicle_id`, `name`, `vehicle_number`, `vehicle_model`, `vehicle_quantity`, `year_made`, `driver_name`, `driver_license`, `driver_contact`, `description`, `status`) VALUES (2, 'Toyota', '423', 'Camry', '2', '2019', 'Udemy Sheg', 'License', 'Contact address here', 'description here', 'available');


