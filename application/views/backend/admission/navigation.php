<!-- Admission Navigation — Student Enrollment & Enquiries Only -->
    <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
                    </li>
                    <li class="user-pro">
                    <a href="#" class="waves-effect"><img src="<?php echo base_url(); ?>uploads/default.jpg" alt="user-img" class="img-circle"> <span class="hide-menu">
                       <?php echo $this->session->userdata('name'); ?>
                        <span class="fa arrow"></span></span>
                    </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>

        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>admission/dashboard" class="waves-effect">
                <i class="ti-dashboard p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- Student Management -->
        <li>
            <a href="#" class="waves-effect">
                <i class="fa fa-graduation-cap p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('student_information'); ?><span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level <?php
                if ($page_name == 'addStudent' || $page_name == 'student_information')
                    echo 'in';
            ?>">
                <li class="<?php if ($page_name == 'addStudent') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admission/add_student">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'student_information') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admission/student_information">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('student_information'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Enquiries -->
        <li>
            <a href="#" class="waves-effect">
                <i class="fa fa-question-circle p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('enquiry'); ?><span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level <?php
                if ($page_name == 'enquiry' || $page_name == 'enquiry_category')
                    echo 'in';
            ?>">
                <li class="<?php if ($page_name == 'enquiry') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admission/enquiry">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('enquiry'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'enquiry_category') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admission/enquiry_category">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('enquiry_category'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="<?php echo base_url(); ?>login/logout" class="waves-effect">
                <i class="fa fa-sign-out p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('Logout'); ?></span>
            </a>
        </li>

                </ul>
            </div>
        </div>
<!-- Left navbar-header end -->
