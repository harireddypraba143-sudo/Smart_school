<?php
// Check if leave_requests table exists, if not show setup message
$table_exists = $this->db->table_exists('leave_requests');
$employees = $this->db->get('teacher')->result();
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Leave Management</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin/dashboard">Smart School System</a></li>
                <li><a href="<?php echo base_url();?>admin/hr_dashboard">HRMS</a></li>
                <li class="active">Leave Management</li>
            </ol>
        </div>
    </div>

    <?php if(!$table_exists): ?>
    <!-- Setup Message -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="white-box text-center" style="border-radius: 12px; padding: 50px;">
                <i class="fa fa-calendar-times-o" style="font-size: 60px; color: #ddd; margin-bottom: 20px;"></i>
                <h3 style="color: #1a1a2e;">Leave Management Module</h3>
                <p style="color: #888; font-size: 15px;">The leave management database table needs to be created first. Click below to set it up.</p>
                <a href="<?php echo base_url(); ?>admin/setup_leave_table" class="btn btn-info btn-rounded" style="margin-top: 15px; padding: 12px 30px;">
                    <i class="fa fa-database"></i> &nbsp; Setup Leave Management
                </a>
            </div>
        </div>
    </div>
    <?php else: ?>

    <?php
    $pending = $this->db->get_where('leave_requests', array('status' => 'pending'))->num_rows();
    $approved = $this->db->get_where('leave_requests', array('status' => 'approved'))->num_rows();
    $rejected = $this->db->get_where('leave_requests', array('status' => 'rejected'))->num_rows();
    ?>

    <!-- Stats -->
    <div class="row">
        <div class="col-md-4">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #f59e0b;">
                <h2 style="margin: 0; font-weight: 700; color: #f59e0b;"><?php echo $pending; ?></h2>
                <p style="margin: 5px 0 0 0; color: #888;">Pending Requests</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #16a34a;">
                <h2 style="margin: 0; font-weight: 700; color: #16a34a;"><?php echo $approved; ?></h2>
                <p style="margin: 5px 0 0 0; color: #888;">Approved</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="white-box" style="border-radius: 12px; border-left: 4px solid #dc2626;">
                <h2 style="margin: 0; font-weight: 700; color: #dc2626;"><?php echo $rejected; ?></h2>
                <p style="margin: 5px 0 0 0; color: #888;">Rejected</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Leave Request -->
        <div class="col-md-4">
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-plus text-info"></i> New Leave Request</h3>
                
                <?php echo form_open(base_url() . 'admin/add_leave_request', array('class' => 'form-horizontal'));?>
                
                <div class="form-group">
                    <label>Employee *</label>
                    <select name="employee_id" class="form-control select2" required>
                        <option value="">Select Employee</option>
                        <?php foreach($employees as $emp): ?>
                            <option value="<?php echo $emp->teacher_id; ?>"><?php echo $emp->name; ?> (<?php echo $emp->teacher_number; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Select the employee</small>
                </div>
                
                <div class="form-group">
                    <label>Leave Type *</label>
                    <select name="leave_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="Casual Leave">Casual Leave (CL)</option>
                        <option value="Sick Leave">Sick Leave (SL)</option>
                        <option value="Earned Leave">Earned Leave (EL)</option>
                        <option value="Maternity Leave">Maternity Leave</option>
                        <option value="Paternity Leave">Paternity Leave</option>
                        <option value="Compensatory Off">Compensatory Off</option>
                        <option value="Loss of Pay">Loss of Pay (LOP)</option>
                    </select>
                    <small class="text-muted">Type of leave request</small>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>From Date *</label>
                        <input type="date" name="from_date" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>To Date *</label>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Reason</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="e.g., Personal work, Medical emergency"></textarea>
                    <small class="text-muted">Brief reason for leave</small>
                </div>

                <button type="submit" class="btn btn-info btn-rounded btn-block">
                    <i class="fa fa-paper-plane"></i> Submit Leave Request
                </button>
                <?php echo form_close(); ?>
            </div>
        </div>

        <!-- Leave Requests Table -->
        <div class="col-md-8">
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-list text-success"></i> Leave Requests</h3>
                
                <table class="table table-hover" id="leave_table" style="font-size: 14px;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th>Employee</th>
                            <th>Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $this->db->order_by('created_at', 'DESC');
                        $leaves = $this->db->get('leave_requests')->result();
                        foreach($leaves as $leave):
                            $emp = $this->db->get_where('teacher', array('teacher_id'=>$leave->employee_id))->row();
                            $days = (strtotime($leave->to_date) - strtotime($leave->from_date)) / 86400 + 1;
                        ?>
                        <tr>
                            <td>
                                <b><?php echo $emp ? $emp->name : 'Unknown'; ?></b><br>
                                <small style="color: #999;"><?php echo $emp ? $emp->teacher_number : ''; ?></small>
                            </td>
                            <td><span class="label label-default"><?php echo $leave->leave_type; ?></span></td>
                            <td><?php echo date('d M', strtotime($leave->from_date)); ?></td>
                            <td><?php echo date('d M', strtotime($leave->to_date)); ?></td>
                            <td><b><?php echo $days; ?></b></td>
                            <td>
                                <?php if($leave->status == 'pending'): ?>
                                    <span class="label label-warning">Pending</span>
                                <?php elseif($leave->status == 'approved'): ?>
                                    <span class="label label-success">Approved</span>
                                <?php else: ?>
                                    <span class="label label-danger">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($leave->status == 'pending'): ?>
                                <a href="<?php echo base_url();?>admin/approve_leave/<?php echo $leave->id; ?>" class="btn btn-success btn-xs" title="Approve"><i class="fa fa-check"></i></a>
                                <a href="<?php echo base_url();?>admin/reject_leave/<?php echo $leave->id; ?>" class="btn btn-danger btn-xs" title="Reject"><i class="fa fa-times"></i></a>
                                <?php else: ?>
                                <span style="color: #ccc;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($leaves)): ?>
                        <tr><td colspan="7" class="text-center" style="color: #999; padding: 30px;">No leave requests yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php endif; ?>
</div>
