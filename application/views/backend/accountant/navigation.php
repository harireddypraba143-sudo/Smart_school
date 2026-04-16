<!-- Accountant Navigation — Finance Only -->
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
            <a href="<?php echo base_url(); ?>accountant/dashboard" class="waves-effect">
                <i class="ti-dashboard p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- Fee Collection -->
        <li>
            <a href="#" class="waves-effect">
                <i class="fa fa-money p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('fee_collection'); ?><span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level <?php
                if ($page_name == 'student_payment' || $page_name == 'student_invoice')
                    echo 'in';
            ?>">
                <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>accountant/student_payment">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('collect_fees'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'student_invoice') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>accountant/student_invoice">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('manage_invoice'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Expenses -->
        <li>
            <a href="#" class="waves-effect">
                <i class="fa fa-credit-card p-r-10"></i>
                <span class="hide-menu"><?php echo get_phrase('expenses'); ?><span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level <?php
                if ($page_name == 'expense' || $page_name == 'expense_category')
                    echo 'in';
            ?>">
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>accountant/expense">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('manage_expense'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>accountant/expense_category">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('expense_category'); ?></span>
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
