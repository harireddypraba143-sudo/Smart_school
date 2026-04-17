<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
|--------------------------------------------------------------------------
| Smart_school REST API v1 Routes
|--------------------------------------------------------------------------
| Maps clean kebab-case URLs to Api controller methods.
| Base: /api/v1/
*/

// Authentication
$route['api/v1/auth/send-otp']     = 'api/auth_send_otp';
$route['api/v1/auth/verify-otp']   = 'api/auth_verify_otp';
$route['api/v1/auth/refresh']      = 'api/auth_refresh';
$route['api/v1/auth/profile']      = 'api/auth_profile';
$route['api/v1/auth/logout']       = 'api/auth_logout';

// Students (Children)
$route['api/v1/students']                = 'api/students_list';
$route['api/v1/students/(\d+)']          = 'api/students_detail/$1';

// Exam Results & Report Card
$route['api/v1/students/(\d+)/exams']                   = 'api/students_exams/$1';
$route['api/v1/students/(\d+)/results']                  = 'api/students_results/$1';
$route['api/v1/students/(\d+)/results/(\d+)']            = 'api/students_results_detail/$1/$2';
$route['api/v1/students/(\d+)/report-card/(\d+)']        = 'api/students_report_card/$1/$2';

// Fee Payments & Invoices
$route['api/v1/students/(\d+)/fee-summary']              = 'api/students_fee_summary/$1';
$route['api/v1/students/(\d+)/invoices']                 = 'api/students_invoices/$1';
$route['api/v1/students/(\d+)/invoices/(\d+)']           = 'api/students_invoice_detail/$1/$2';
$route['api/v1/students/(\d+)/payments']                 = 'api/students_payments/$1';

// Attendance
$route['api/v1/students/(\d+)/attendance']               = 'api/students_attendance/$1';
$route['api/v1/students/(\d+)/attendance/summary']       = 'api/students_attendance_summary/$1';

// Notices & Circulars
$route['api/v1/notices']             = 'api/notices_list';
$route['api/v1/notices/(\d+)']       = 'api/notices_detail/$1';
$route['api/v1/circulars']           = 'api/circulars_list';

// Assignments
$route['api/v1/students/(\d+)/assignments']              = 'api/students_assignments/$1';

// Admin Stats (API Key only)
$route['api/v1/stats/overview']      = 'api/stats_overview';
$route['api/v1/stats/admissions']    = 'api/stats_admissions';
$route['api/v1/stats/fees']          = 'api/stats_fees';

// API Setup (run once, then disable)
$route['api_setup/install']          = 'ApiSetup/install';
