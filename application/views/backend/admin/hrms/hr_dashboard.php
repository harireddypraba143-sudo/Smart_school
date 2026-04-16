<?php
$total_employees = $this->db->count_all('teacher');
$active_employees = $this->db->get_where('teacher', array('status' => '1'))->num_rows();
$inactive_employees = $total_employees - $active_employees;
$departments = $this->db->get('department')->result_array();
$total_departments = count($departments);

// Recent hires (last 30 days)
$this->db->where('date_of_joining >=', date('Y-m-d', strtotime('-30 days')));
$recent_hires = $this->db->get('teacher')->num_rows();

// Total payroll cost
$this->db->select_sum('joining_salary');
$payroll_data = $this->db->get('teacher')->row();
$total_payroll = $payroll_data->joining_salary ?: 0;
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">HR Dashboard</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin/dashboard">Smart School System</a></li>
                <li><a href="#">HRMS</a></li>
                <li class="active">HR Dashboard</li>
            </ol>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row">
        <!-- Total Employees -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #2563eb;">
                <div class="row">
                    <div class="col-xs-8">
                        <h3 style="margin: 0; font-weight: 700; color: #1a1a2e;"><?php echo $total_employees; ?></h3>
                        <p style="margin: 5px 0 0 0; color: #888; font-size: 13px;">Total Employees</p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <i class="fa fa-users" style="font-size: 40px; color: #2563eb; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #16a34a;">
                <div class="row">
                    <div class="col-xs-8">
                        <h3 style="margin: 0; font-weight: 700; color: #1a1a2e;"><?php echo $active_employees; ?></h3>
                        <p style="margin: 5px 0 0 0; color: #888; font-size: 13px;">Active Employees</p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <i class="fa fa-check-circle" style="font-size: 40px; color: #16a34a; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #f59e0b;">
                <div class="row">
                    <div class="col-xs-8">
                        <h3 style="margin: 0; font-weight: 700; color: #1a1a2e;"><?php echo $total_departments; ?></h3>
                        <p style="margin: 5px 0 0 0; color: #888; font-size: 13px;">Departments</p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <i class="fa fa-sitemap" style="font-size: 40px; color: #f59e0b; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Payroll -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #dc2626;">
                <div class="row">
                    <div class="col-xs-8">
                        <h3 style="margin: 0; font-weight: 700; color: #1a1a2e;">₹<?php echo number_format($total_payroll); ?></h3>
                        <p style="margin: 5px 0 0 0; color: #888; font-size: 13px;">Monthly Payroll</p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <i class="fa fa-money" style="font-size: 40px; color: #dc2626; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Department Breakdown -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="white-box" style="border-radius: 12px; min-height: 350px;">
                <h3 class="box-title" style="margin-bottom: 20px;"><i class="fa fa-bolt text-warning"></i> Quick Actions</h3>
                
                <a href="<?php echo base_url();?>admin/teacher" class="btn btn-info btn-block btn-rounded" style="margin-bottom: 10px; text-align: left; padding: 12px 20px;">
                    <i class="fa fa-plus"></i> &nbsp; Add New Employee
                </a>
                <a href="<?php echo base_url();?>admin/payroll" class="btn btn-success btn-block btn-rounded" style="margin-bottom: 10px; text-align: left; padding: 12px 20px;">
                    <i class="fa fa-money"></i> &nbsp; Process Payroll
                </a>
                <a href="<?php echo base_url();?>admin/teacher_attendance_report" class="btn btn-warning btn-block btn-rounded" style="margin-bottom: 10px; text-align: left; padding: 12px 20px;">
                    <i class="fa fa-calendar-check-o"></i> &nbsp; View Attendance
                </a>
                <a href="<?php echo base_url();?>department/department" class="btn btn-default btn-block btn-rounded" style="margin-bottom: 10px; text-align: left; padding: 12px 20px;">
                    <i class="fa fa-sitemap"></i> &nbsp; Manage Departments
                </a>
                <a href="<?php echo base_url();?>admin/leave_management" class="btn btn-danger btn-block btn-rounded" style="text-align: left; padding: 12px 20px;">
                    <i class="fa fa-calendar-times-o"></i> &nbsp; Leave Management
                </a>
            </div>
        </div>

        <!-- Department Breakdown -->
        <div class="col-md-8">
            <div class="white-box" style="border-radius: 12px; min-height: 350px;">
                <h3 class="box-title" style="margin-bottom: 20px;"><i class="fa fa-sitemap text-info"></i> Department Breakdown</h3>
                
                <table class="table table-striped" style="font-size: 14px;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th>Department</th>
                            <th>Employees</th>
                            <th>Monthly Cost</th>
                            <th>Head Count %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($departments as $dept): 
                            $dept_count = $this->db->get_where('teacher', array('department_id' => $dept['department_id']))->num_rows();
                            $this->db->select_sum('joining_salary');
                            $this->db->where('department_id', $dept['department_id']);
                            $dept_salary = $this->db->get('teacher')->row()->joining_salary ?: 0;
                            $percentage = ($total_employees > 0) ? round(($dept_count / $total_employees) * 100) : 0;
                        ?>
                        <tr>
                            <td><b><?php echo $dept['name']; ?></b></td>
                            <td>
                                <span class="label label-info" style="font-size: 12px;"><?php echo $dept_count; ?></span>
                            </td>
                            <td>₹<?php echo number_format($dept_salary); ?></td>
                            <td>
                                <div class="progress" style="margin: 0; height: 8px; background: #eee; border-radius: 4px;">
                                    <div class="progress-bar" style="width: <?php echo $percentage; ?>%; background: #2563eb; border-radius: 4px;"></div>
                                </div>
                                <small style="color: #888;"><?php echo $percentage; ?>%</small>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Employees -->
    <div class="row">
        <div class="col-md-12">
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-clock-o text-success"></i> Recent Employees (Last 30 Days)</h3>

                <table class="table table-hover" style="font-size: 14px;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Joining Date</th>
                            <th>Salary</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $this->db->where('date_of_joining >=', date('Y-m-d', strtotime('-30 days')));
                        $this->db->order_by('date_of_joining', 'DESC');
                        $recent = $this->db->get('teacher')->result();
                        foreach($recent as $emp):
                            $d = $this->db->get_where('department', array('department_id'=>$emp->department_id))->row();
                            $des = $this->db->get_where('designation', array('designation_id'=>$emp->designation_id))->row();
                        ?>
                        <tr>
                            <td><code style="font-size: 12px; background: #f5f5f5; padding: 3px 8px; border-radius: 4px;"><?php echo $emp->teacher_number; ?></code></td>
                            <td><b><?php echo $emp->name; ?></b></td>
                            <td><?php echo $d ? $d->name : '-'; ?></td>
                            <td><?php echo $des ? $des->name : '-'; ?></td>
                            <td><?php echo date('d M Y', strtotime($emp->date_of_joining)); ?></td>
                            <td>₹<?php echo number_format($emp->joining_salary); ?></td>
                            <td>
                                <?php if($emp->status == 1): ?>
                                    <span class="label label-success">Active</span>
                                <?php else: ?>
                                    <span class="label label-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($recent)): ?>
                        <tr><td colspan="7" class="text-center" style="color: #999; padding: 30px;">No new employees in the last 30 days</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
