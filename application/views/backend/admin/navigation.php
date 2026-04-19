    <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
                        <!-- /input-group -->
                    </li>

     <?php
     // === RBAC Permission Helper ===
     $user_role = $this->session->userdata('login_type');
     $user_permissions = $this->session->userdata('permissions');
     if (!is_array($user_permissions)) $user_permissions = array();
     $is_admin = ($user_role == 'admin');
     $is_accountant = ($user_role == 'accountant');
     $is_admission = ($user_role == 'admission');

     // For legacy admin_role table — only check if the user is an admin
     $check_admin_permission_dashboard = 1;
     $check_admin_permission_academics = 1;
     $check_admin_permission_employee = 1;
     $check_admin_permission_student = 1;
     $check_admin_permission_attendance = 1;
     $check_admin_permission_download = 1;
     $check_admin_permission_parent = 1;
     $check_admin_permission_alumni = 1;

     if ($is_admin) {
         $admin_role_row = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row();
         if ($admin_role_row) {
             $check_admin_permission_dashboard = $admin_role_row->dashboard;
             $check_admin_permission_academics = $admin_role_row->manage_academics;
             $check_admin_permission_employee = $admin_role_row->manage_employee;
             $check_admin_permission_student = $admin_role_row->manage_student;
             $check_admin_permission_attendance = $admin_role_row->manage_attendance;
             $check_admin_permission_download = $admin_role_row->download_page;
             $check_admin_permission_parent = $admin_role_row->manage_parent;
             $check_admin_permission_alumni = $admin_role_row->manage_alumni;
         }
     }
     // For staff roles (accountant & admission): same access — dashboard + student + finance
     if ($is_accountant || $is_admission) {
         $check_admin_permission_academics = 0;
         $check_admin_permission_employee = 0;
         $check_admin_permission_attendance = 0;
         $check_admin_permission_download = 0;
         $check_admin_permission_parent = 0;
         $check_admin_permission_alumni = 0;
         // Student management enabled for both
         $check_admin_permission_student = 1;
     }
     ?>

    <!-- ═══════════════════════════════════════ -->
    <!-- DASHBOARD -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_dashboard == '1'):?>
        <li class="<?php if ($page_name == 'dashboard') echo 'active';?>">
            <a href="<?php echo base_url();?>admin/dashboard" class="waves-effect" style="padding: 10px 15px;">
                <i class="fa fa-tachometer" style="width: 20px; text-align: center; color: #667eea; margin-right: 8px; font-size: 15px;"></i>
                <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Dashboard</span>
            </a>
        </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- ACADEMICS -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_academics == '1'):?>

        <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
            <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #11998e, #38ef7d); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>ACADEMICS
        </li>

        <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-graduation-cap" style="font-size: 15px; color: #11998e; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Academics<span class="fa arrow"></span></span></a>
            <ul class="nav nav-second-level<?php
                if ($page_name == 'enquiry_category'|| $page_name == 'list_enquiry'|| $page_name == 'club'|| $page_name == 'noticeboard' || $page_name == 'circular'|| $page_name == 'academic_syllabus') echo ' opened active';
                ?>" style="padding: 0;">

                <li class="<?php if ($page_name == 'enquiry_category') echo 'active';?>">
                    <a href="<?php echo base_url();?>admin/enquiry_category" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-question-circle" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                        <span class="hide-menu">Enquiry Category</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'enquiry') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/list_enquiry" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-list" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                        <span class="hide-menu">List Enquiries</span>
                    </a>
                </li>

                <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

                <li class="<?php if ($page_name == 'club') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/club" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-trophy" style="width: 20px; text-align: center; color: #f97316; margin-right: 8px;"></i>
                        <span class="hide-menu">School Clubs</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'circular') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/circular" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-bullhorn" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                        <span class="hide-menu">Circulars</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/academic_syllabus" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-book" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                        <span class="hide-menu">Syllabus</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/noticeboard" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-calendar" style="width: 20px; text-align: center; color: #9333ea; margin-right: 8px;"></i>
                        <span class="hide-menu">Events</span>
                    </a>
                </li>

            </ul>
        </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- HRMS -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_employee == '1'):?> 

        <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
            <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>HRMS
        </li>

        <li class="staff"> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-building" style="font-size: 15px; color: #667eea; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Human Resources<span class="fa arrow"></span></span></a>
        
            <ul class="nav nav-second-level<?php 
                if ($page_name == 'hrms/employee_directory' || 
                    $page_name == 'hrms/employee_profile' || 
                    $page_name == 'hrms/staff_directory' || 
                    $page_name == 'hrms/staff_attendance' || 
                    $page_name == 'hrms/payroll_list' || 
                    $page_name == 'department' || 
                    $page_name == 'hrms/hr_dashboard' || 
                    $page_name == 'hrms/leave_management') echo ' opened active';?>" style="padding: 0;">

                <li class="<?php if ($page_name == 'hrms/hr_dashboard') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/hr_dashboard" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-tachometer" style="width: 20px; text-align: center; color: #667eea; margin-right: 8px;"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

                <li class="<?php if ($page_name == 'hrms/employee_directory' || $page_name == 'hrms/employee_profile') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/teacher" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-graduation-cap" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                        <span class="hide-menu">Teachers</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'hrms/staff_directory') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/staff" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-wrench" style="width: 20px; text-align: center; color: #e67e22; margin-right: 8px;"></i>
                        <span class="hide-menu">Staff</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'department') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>department/department" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-sitemap" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                        <span class="hide-menu">Departments</span>
                    </a>
                </li>

                <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

                <li class="<?php if ($page_name == 'hrms/payroll_list') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/payroll" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-money" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                        <span class="hide-menu">Payroll & Salaries</span>
                    </a>
                </li>

                <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

                <li class="<?php if ($page_name == 'hrms/staff_attendance') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/teacher_attendance_report" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-calendar-check-o" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                        <span class="hide-menu">Attendance</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'hrms/leave_management') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/leave_management" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-calendar-times-o" style="width: 20px; text-align: center; color: #9333ea; margin-right: 8px;"></i>
                        <span class="hide-menu">Leave Management</span>
                    </a>
                </li>

            </ul>
   	 </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- STUDENTS -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_student == '1'):?>

        <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
            <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #f093fb, #f5576c); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>STUDENTS
        </li>

        <li class="student"> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-users" style="font-size: 15px; color: #f5576c; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Student Management<span class="fa arrow"></span></span></a>
        
            <ul class="nav nav-second-level<?php
                if ($page_name == 'new_student' || $page_name == 'student_class' || $page_name == 'student_information' || $page_name == 'view_student' || $page_name == 'student_certificates' || $page_name == 'searchStudent' || $page_name == 'student_promotion' || $page_name == 'alumni') echo ' opened active';
                ?>" style="padding: 0;">

                <li class="<?php if ($page_name == 'new_student') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/new_student" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-user-plus" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                        <span class="hide-menu">Admission Form</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'student_information' || $page_name == 'view_student') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/student_information" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-list-ul" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                        <span class="hide-menu">List Students</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'student_certificates') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/student_certificates" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-certificate" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                        <span class="hide-menu">Certificates</span>
                    </a>
                </li>

                <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

                <li class="<?php if ($page_name == 'studentCategory') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>studentcategory/studentCategory" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-tags" style="width: 20px; text-align: center; color: #9333ea; margin-right: 8px;"></i>
                        <span class="hide-menu">Categories</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'studentHouse') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>studenthouse/studentHouse" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-home" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                        <span class="hide-menu">Houses</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'clubActivity') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>activity/clubActivity" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-futbol-o" style="width: 20px; text-align: center; color: #0891b2; margin-right: 8px;"></i>
                        <span class="hide-menu">Activities</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'socialCategory') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>socialcategory/socialCategory" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-group" style="width: 20px; text-align: center; color: #667eea; margin-right: 8px;"></i>
                        <span class="hide-menu">Social Category</span>
                    </a>
                </li>

            <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

            <li class="<?php if ($page_name == 'student_promotion') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/student_promotion" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-level-up" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Promotion</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'alumni') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/alumni" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-graduation-cap" style="width: 20px; text-align: center; color: #f97316; margin-right: 8px;"></i>
                    <span class="hide-menu">Alumni</span>
                </a>
            </li>

            </ul>
        </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- ATTENDANCE -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_attendance == '1'):?>

        <li class="attendance"> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-calendar-check-o" style="font-size: 15px; color: #0891b2; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Attendance<span class="fa arrow"></span></span></a>
        
            <ul class="nav nav-second-level<?php if ($page_name == 'manage_attendance' || $page_name == 'attendance_report') echo ' opened active'; ?>" style="padding: 0;">

                <li class="<?php if ($page_name == 'manage_attendance') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/manage_attendance/<?php echo date("d/m/Y"); ?>" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-check-square-o" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                        <span class="hide-menu">Mark Attendance</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'attendance_report') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/attendance_report" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-bar-chart" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                        <span class="hide-menu">View Reports</span>
                    </a>
                </li>

            </ul>
        </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- DOWNLOADS -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_download == '1'):?>

        <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-download" style="font-size: 15px; color: #f97316; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Downloads<span class="fa arrow"></span></span></a>
        
            <ul class="nav nav-second-level<?php if ($page_name == 'assignment' || $page_name == 'study_material') echo ' opened active'; ?>" style="padding: 0;">

                <li class="<?php if ($page_name == 'assignment') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>assignment/assignment" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-file-text" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                        <span class="hide-menu">Assignments</span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'study_material') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>studymaterial/study_material" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                        <i class="fa fa-folder-open" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                        <span class="hide-menu">Study Materials</span>
                    </a>
                </li>

            </ul>
        </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- PARENTS -->
    <!-- ═══════════════════════════════════════ -->
    <?php if($check_admin_permission_parent == '1'):?>
        <li class="<?php if($page_name == 'parent')echo 'active';?>">
            <a href="<?php echo base_url();?>admin/parent" style="padding: 10px 15px;">
                <i class="fa fa-user-circle" style="width: 20px; text-align: center; color: #e11d48; margin-right: 8px; font-size: 15px;"></i>
                <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Parents</span>
            </a>
        </li>
    <?php endif;?>


    <!-- ═══════════════════════════════════════ -->
    <!-- CLASSES & SUBJECTS -->
    <!-- ═══════════════════════════════════════ -->
    <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
        <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #4facfe, #00f2fe); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>SCHOOL
    </li>

    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-university" style="font-size: 15px; color: #4facfe; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Classes & Sections<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'class' || $page_name == 'section' || $page_name == 'class_routine') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'class') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/classes" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-columns" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">Manage Classes</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'section') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/section" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-th-large" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Manage Sections</span>
                </a>
            </li>

        </ul>
    </li>

    <li class="<?php if ($page_name == 'subject') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>subject/subject/" style="padding: 10px 15px;">
            <i class="fa fa-book" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px; font-size: 15px;"></i>
            <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Subjects</span>
        </a>
    </li>

    <li class="<?php if ($page_name == 'library') echo 'active'; ?>">
        <a href="<?php echo base_url(); ?>admin/library" style="padding: 10px 15px;">
            <i class="fa fa-book" style="width: 20px; text-align: center; color: #7c3aed; margin-right: 8px; font-size: 15px;"></i>
            <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Library</span>
        </a>
    </li>


    <!-- ═══════════════════════════════════════ -->
    <!-- EXAMS & SCORES -->
    <!-- ═══════════════════════════════════════ -->
    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-pencil-square-o" style="font-size: 15px; color: #dc2626; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Examinations<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'submit_exam' || $page_name == 'grade' || $page_name == 'createExamination' || $page_name == 'examQuestion' || $page_name == 'marks' || $page_name == 'student_marksheet_subject' || $page_name == 'marksheet_view' || $page_name == 'co_scholastic') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'examQuestion') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/examQuestion" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-file-text-o" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Question Papers</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'createExamination') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/createExamination" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-plus-circle" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Add Examination</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'student_marksheet_subject') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/student_marksheet_subject" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-edit" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">Marks Enter</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'co_scholastic') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/co_scholastic" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-star-half-o" style="width: 20px; text-align: center; color: #ec4899; margin-right: 8px;"></i>
                    <span class="hide-menu">Co-Scholastic</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'marksheet_view') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/marksheet_view" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-clipboard" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Marksheet</span>
                </a>
            </li>

        </ul>
    </li>

    <!-- ═══════════════════════════════════════ -->
    <!-- FINANCE -->
    <!-- ═══════════════════════════════════════ -->
    <?php if ($is_admin || $is_accountant || $is_admission): ?>

    <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
        <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #fa709a, #fee140); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>FINANCE
    </li>

    <li class="collect_fee"> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-credit-card" style="font-size: 15px; color: #e11d48; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Fee Collection<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'income' || $page_name == 'student_payment'|| $page_name == 'view_invoice_details'|| $page_name == 'invoice_add'|| $page_name == 'list_invoice'|| $page_name == 'studentSpecificPaymentQuery'|| $page_name == 'student_invoice') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/student_payment" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-money" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Collect Fees</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'student_invoice') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/student_invoice" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-file-text-o" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">Manage Invoices</span>
                </a>
            </li>

        </ul>
    </li>

    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-line-chart" style="font-size: 15px; color: #f59e0b; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Expenses<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'expense' || $page_name == 'expense_category') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'expense') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>expense/expense" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-receipt" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                    <span class="hide-menu">All Expenses</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>expense/expense_category" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-tags" style="width: 20px; text-align: center; color: #9333ea; margin-right: 8px;"></i>
                    <span class="hide-menu">Categories</span>
                </a>
            </li>

        </ul>
    </li>

    <?php endif; ?>


    <!-- ═══════════════════════════════════════ -->
    <!-- ADMIN ONLY — HOSTEL, TRANSPORT, SETTINGS -->
    <!-- ═══════════════════════════════════════ -->
    <?php if ($is_admin): ?>

    <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
        <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #a8c0ff, #3f2b96); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>FACILITY
    </li>

    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-bed" style="font-size: 15px; color: #7c3aed; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Hostel<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'dormitory' || $page_name == 'hostel_category' || $page_name == 'room_type' || $page_name == 'hostel_room' || $page_name == 'hostel_attendance_report') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'dormitory') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/dormitory" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-building-o" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">Manage Hostel</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'hostel_attendance_report') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/hostel_attendance_report" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-calendar-check-o" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Attendance</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'hostel_category') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/hostel_category" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-tags" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Categories</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'hostel_room') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/hostel_room" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-key" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                    <span class="hide-menu">Rooms</span>
                </a>
            </li>

        </ul>
    </li>

    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-bus" style="font-size: 15px; color: #0891b2; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Transport<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'transport' || $page_name == 'transport_route' || $page_name == 'vehicle') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'transport') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>transportation/transport" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-map-marker" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                    <span class="hide-menu">Transports</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'transport_route') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>transportation/transport_route" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-road" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Routes</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'vehicle') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>transportation/vehicle" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-truck" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Vehicles</span>
                </a>
            </li>

        </ul>
    </li>


    <!-- ═══════════════════════════════════════ -->
    <!-- SETTINGS & ADMIN -->
    <!-- ═══════════════════════════════════════ -->

    <li class="nav-small-cap" style="padding: 8px 20px 4px; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; color: #7c8ea0; text-transform: uppercase; margin-top: 5px;">
        <span style="display: inline-block; width: 18px; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); vertical-align: middle; margin-right: 6px; border-radius: 1px;"></span>ADMIN
    </li>

    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-cog" style="font-size: 15px; color: #6b7280; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Settings<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'system_settings' || $page_name == 'manage_language' || $page_name == 'paymentSetting' || $page_name == 'sms_settings' || $page_name == 'rfid_settings' || $page_name == 'rfid_card_assignment' || $page_name == 'rfid_attendance_log') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>systemsetting/system_settings" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-sliders" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">General</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>smssetting/sms_settings" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-comment" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">SMS API</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/manage_language" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-globe" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Languages</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'paymentSetting') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>payment/paymentSetting" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-credit-card" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                    <span class="hide-menu">Payments</span>
                </a>
            </li>

            <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

            <li class="<?php if ($page_name == 'rfid_settings') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>systemsetting/rfid_settings" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-id-card" style="width: 20px; text-align: center; color: #9333ea; margin-right: 8px;"></i>
                    <span class="hide-menu">RFID Devices</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'rfid_card_assignment') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>systemsetting/rfid_cards" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-credit-card-alt" style="width: 20px; text-align: center; color: #0891b2; margin-right: 8px;"></i>
                    <span class="hide-menu">Card Assignment</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'rfid_attendance_log') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>systemsetting/rfid_attendance_log" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-list-alt" style="width: 20px; text-align: center; color: #667eea; margin-right: 8px;"></i>
                    <span class="hide-menu">RFID Scan Log</span>
                </a>
            </li>

            <li style="padding: 0 15px 0 20px;"><hr style="margin: 2px 0; border-color: #eee;"></li>

            <li>
                <a href="<?php echo base_url(); ?>dbdump" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-database" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                    <span class="hide-menu">Database Backup</span>
                </a>
            </li>

        </ul>
    </li>

    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-pie-chart" style="font-size: 15px; color: #e11d48; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Reports<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level" style="padding: 0;">

            <li class="<?php if ($page_name == 'studentPaymentReport') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>report/studentPaymentReport" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-money" style="width: 20px; text-align: center; color: #16a34a; margin-right: 8px;"></i>
                    <span class="hide-menu">Payment Report</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'classAttendanceReport') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>report/classAttendanceReport" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-calendar" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">Attendance Report</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'examMarkReport') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>report/examMarkReport" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-bar-chart" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Exam Report</span>
                </a>
            </li>

        </ul>
    </li>

    <?php endif; ?>

    <!-- ═══════════════════════════════════════ -->
    <!-- ROLE MANAGEMENT (SUPER ADMIN) -->
    <!-- ═══════════════════════════════════════ -->
    <?php if ($is_admin):
        $checking_level = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->level;
    ?>
    <?php if($checking_level == '1'):?>
    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-shield" style="font-size: 15px; color: #7c3aed; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Admin Roles<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'newAdministrator') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'newAdministrator') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/newAdministrator" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-user-secret" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px;"></i>
                    <span class="hide-menu">New Admin</span>
                </a>
            </li>

        </ul>
    </li>
    <?php endif;?>
    <?php endif; ?>

    <?php if ($is_admin):
        $checking_level_row = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row();
        $checking_level = $checking_level_row ? $checking_level_row->level : '0';
    ?>
    <?php if($checking_level == '2'):?>
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>admin/manage_profile" style="padding: 10px 15px;">
                <i class="fa fa-user-circle-o" style="width: 20px; text-align: center; color: #667eea; margin-right: 8px; font-size: 15px;"></i>
                <span class="hide-menu" style="font-weight: 600; font-size: 14px;">My Profile</span>
            </a>
        </li>
    <?php endif;?>
    <?php endif; ?>

    <?php if ($is_admin): ?>
    <!-- Enterprise Role Management -->
    <li> <a href="javascript:void(0);" class="waves-effect" style="padding: 10px 15px;"><i class="fa fa-lock" style="font-size: 15px; color: #475569; margin-right: 8px; width: 20px; text-align: center;"></i> <span class="hide-menu" style="font-weight: 600; font-size: 14px;">Access Control<span class="fa arrow"></span></span></a>
        
        <ul class="nav nav-second-level<?php if ($page_name == 'manage_users' || $page_name == 'audit_logs') echo ' opened active'; ?>" style="padding: 0;">

            <li class="<?php if ($page_name == 'manage_users') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/manage_users" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-users" style="width: 20px; text-align: center; color: #2563eb; margin-right: 8px;"></i>
                    <span class="hide-menu">Staff Users</span>
                </a>
            </li>

            <li class="<?php if ($page_name == 'audit_logs') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>admin/audit_logs" style="padding: 8px 15px 8px 20px; font-size: 13px;">
                    <i class="fa fa-history" style="width: 20px; text-align: center; color: #f59e0b; margin-right: 8px;"></i>
                    <span class="hide-menu">Audit Logs</span>
                </a>
            </li>

        </ul>
    </li>
    <?php endif; ?>


    <!-- ═══════════════════════════════════════ -->
    <!-- LOGOUT -->
    <!-- ═══════════════════════════════════════ -->
    <li style="margin-top: 10px; border-top: 1px solid #eee; padding-top: 5px;">
        <a href="<?php echo base_url(); ?>login/logout" style="padding: 10px 15px;">
            <i class="fa fa-sign-out" style="width: 20px; text-align: center; color: #dc2626; margin-right: 8px; font-size: 15px;"></i>
            <span class="hide-menu" style="font-weight: 600; font-size: 14px; color: #dc2626;">Logout</span>
        </a>
    </li>

                  
                </ul>
            </div>
        </div>
<!-- Left navbar-header end -->