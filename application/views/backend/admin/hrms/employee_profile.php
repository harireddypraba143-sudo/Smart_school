<?php
$teacher = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row();
if (!$teacher) { echo '<div class="alert alert-danger">Employee not found.</div>'; return; }

$dept = $this->db->get_where('department', array('department_id'=>$teacher->department_id))->row();
$dept_name = $dept ? $dept->name : '—';
$designation = $this->db->get_where('designation', array('designation_id'=>$teacher->designation_id))->row();
$designation_name = $designation ? $designation->name : '—';
$salary = $teacher->joining_salary ?: 0;
$system_name = $this->db->get_where('settings', array('type'=>'system_title'))->row()->description;
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Employee Profile</h4>
        </div>
        <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin/dashboard">Smart School System</a></li>
                <li><a href="<?php echo base_url();?>admin/hr_dashboard">HRMS</a></li>
                <li><a href="<?php echo base_url();?>admin/teacher">Employee Directory</a></li>
                <li class="active"><?php echo $teacher->name; ?></li>
            </ol>
        </div>
    </div>

    <!-- Profile Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="white-box" style="border-radius: 12px; overflow: hidden; padding: 0;">
                <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 30px 40px; color: #fff;">
                    <div class="row">
                        <div class="col-md-1">
                            <img src="<?php echo base_url(); ?>uploads/teacher_image/<?php echo $teacher->file_name; ?>" 
                                 alt="<?php echo $teacher->name; ?>" 
                                 style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3); object-fit: cover; background: #eee;">
                        </div>
                        <div class="col-md-6" style="padding-top: 5px;">
                            <h2 style="margin: 0; font-weight: 700; color: #fff;"><?php echo $teacher->name; ?></h2>
                            <p style="margin: 5px 0 0 0; color: rgba(255,255,255,0.7); font-size: 14px;">
                                <?php echo $designation_name; ?> &bull; <?php echo $dept_name; ?> Department
                            </p>
                        </div>
                        <div class="col-md-5 text-right" style="padding-top: 10px;">
                            <code style="background: rgba(255,255,255,0.15); color: #fff; padding: 6px 15px; border-radius: 6px; font-size: 14px;">
                                <?php echo $teacher->teacher_number; ?>
                            </code>
                            <br>
                            <span style="color: rgba(255,255,255,0.5); font-size: 12px; margin-top: 5px; display: inline-block;">Employee ID</span>
                        </div>
                    </div>
                </div>
                <!-- Quick Info Bar -->
                <div style="background: #f8f9fa; padding: 15px 40px; border-bottom: 1px solid #e5e7eb;">
                    <div class="row" style="font-size: 13px;">
                        <div class="col-md-2"><i class="fa fa-phone text-info"></i> &nbsp;<?php echo $teacher->phone; ?></div>
                        <div class="col-md-3"><i class="fa fa-envelope text-info"></i> &nbsp;<?php echo $teacher->email; ?></div>
                        <div class="col-md-2"><i class="fa fa-calendar text-info"></i> &nbsp;Joined: <?php echo date('d M Y', strtotime($teacher->date_of_joining)); ?></div>
                        <div class="col-md-2"><i class="fa fa-money text-info"></i> &nbsp;₹<?php echo number_format($salary); ?>/month</div>
                        <div class="col-md-3 text-right">
                            <button class="btn btn-info btn-sm btn-rounded" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/edit_employee/<?php echo $teacher->teacher_id;?>');">
                                <i class="fa fa-edit"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column — Personal Details -->
        <div class="col-md-4">
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-user text-info"></i> Personal Information</h3>
                <table class="table" style="font-size: 14px;">
                    <tr><td style="color: #888; width: 40%;">Full Name</td><td><b><?php echo $teacher->name; ?></b></td></tr>
                    <tr><td style="color: #888;">Gender</td><td><?php echo ucfirst($teacher->sex); ?></td></tr>
                    <tr><td style="color: #888;">Date of Birth</td><td><?php echo $teacher->birthday ? date('d M Y', strtotime($teacher->birthday)) : '—'; ?></td></tr>
                    <tr><td style="color: #888;">Blood Group</td><td><?php echo $teacher->blood_group ?: '—'; ?></td></tr>
                    <tr><td style="color: #888;">Address</td><td><?php echo $teacher->address ?: '—'; ?></td></tr>
                    <tr><td style="color: #888;">Phone</td><td><?php echo $teacher->phone; ?></td></tr>
                    <tr><td style="color: #888;">Email</td><td><?php echo $teacher->email; ?></td></tr>
                </table>
            </div>

            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-id-card text-warning"></i> Compliance</h3>
                <table class="table" style="font-size: 14px;">
                    <tr><td style="color: #888; width: 40%;">Aadhaar No.</td><td><?php echo $teacher->aadhaar_num ?: '—'; ?></td></tr>
                    <tr><td style="color: #888;">PAN No.</td><td><?php echo $teacher->pan_num ?: '—'; ?></td></tr>
                    <tr><td style="color: #888;">UAN (EPF)</td><td><?php echo isset($teacher->uan_num) ? ($teacher->uan_num ?: '—') : '—'; ?></td></tr>
                    <tr><td style="color: #888;">Bank A/C</td><td><?php echo isset($teacher->bank_account) ? ($teacher->bank_account ?: '—') : '—'; ?></td></tr>
                    <tr><td style="color: #888;">IFSC</td><td><?php echo isset($teacher->bank_ifsc) ? ($teacher->bank_ifsc ?: '—') : '—'; ?></td></tr>
                </table>
            </div>
        </div>

        <!-- Right Column — Documents & Actions -->
        <div class="col-md-8">
            <!-- HR Documents -->
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-file-text text-success"></i> HR Documents</h3>
                <p style="color: #888; font-size: 13px;">Click any document below to generate and preview it. All documents are auto-filled with the employee's data.</p>

                <div class="row" style="margin-top: 15px;">
                    <!-- Offer Letter -->
                    <div class="col-md-4" style="margin-bottom: 15px;">
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher->teacher_id;?>/joining');" style="text-decoration: none;">
                            <div style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 10px; padding: 20px; text-align: center; color: #fff; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fa fa-file-text-o" style="font-size: 32px; opacity: 0.8;"></i>
                                <h5 style="margin: 10px 0 3px 0; font-weight: 600;">Offer Letter</h5>
                                <small style="opacity: 0.7;">Employment terms & salary</small>
                            </div>
                        </a>
                    </div>
                    <!-- Joining Report -->
                    <div class="col-md-4" style="margin-bottom: 15px;">
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher->teacher_id;?>/joining_report');" style="text-decoration: none;">
                            <div style="background: linear-gradient(135deg, #11998e, #38ef7d); border-radius: 10px; padding: 20px; text-align: center; color: #fff; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fa fa-clipboard" style="font-size: 32px; opacity: 0.8;"></i>
                                <h5 style="margin: 10px 0 3px 0; font-weight: 600;">Joining Report</h5>
                                <small style="opacity: 0.7;">Duty reporting document</small>
                            </div>
                        </a>
                    </div>
                    <!-- Welcome Letter -->
                    <div class="col-md-4" style="margin-bottom: 15px;">
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher->teacher_id;?>/welcome');" style="text-decoration: none;">
                            <div style="background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 10px; padding: 20px; text-align: center; color: #fff; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fa fa-heart" style="font-size: 32px; opacity: 0.8;"></i>
                                <h5 style="margin: 10px 0 3px 0; font-weight: 600;">Welcome Letter</h5>
                                <small style="opacity: 0.7;">Onboarding welcome</small>
                            </div>
                        </a>
                    </div>
                    <!-- Salary Hike -->
                    <div class="col-md-4" style="margin-bottom: 15px;">
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher->teacher_id;?>/hike');" style="text-decoration: none;">
                            <div style="background: linear-gradient(135deg, #4facfe, #00f2fe); border-radius: 10px; padding: 20px; text-align: center; color: #fff; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fa fa-arrow-up" style="font-size: 32px; opacity: 0.8;"></i>
                                <h5 style="margin: 10px 0 3px 0; font-weight: 600;">Salary Revision</h5>
                                <small style="opacity: 0.7;">Hike / increment letter</small>
                            </div>
                        </a>
                    </div>
                    <!-- Relieving Letter -->
                    <div class="col-md-4" style="margin-bottom: 15px;">
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher->teacher_id;?>/relieving');" style="text-decoration: none;">
                            <div style="background: linear-gradient(135deg, #fa709a, #fee140); border-radius: 10px; padding: 20px; text-align: center; color: #fff; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fa fa-sign-out" style="font-size: 32px; opacity: 0.8;"></i>
                                <h5 style="margin: 10px 0 3px 0; font-weight: 600;">Relieving Letter</h5>
                                <small style="opacity: 0.7;">Experience & relieving</small>
                            </div>
                        </a>
                    </div>
                    <!-- Download CV -->
                    <div class="col-md-4" style="margin-bottom: 15px;">
                        <a href="<?php echo base_url().'uploads/teacher_image/'.$teacher->file_name;?>" style="text-decoration: none;" download>
                            <div style="background: linear-gradient(135deg, #a8c0ff, #3f2b96); border-radius: 10px; padding: 20px; text-align: center; color: #fff; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fa fa-download" style="font-size: 32px; opacity: 0.8;"></i>
                                <h5 style="margin: 10px 0 3px 0; font-weight: 600;">Download CV</h5>
                                <small style="opacity: 0.7;">Uploaded resume file</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Salary Structure -->
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-money text-danger"></i> Salary Structure</h3>
                <?php
                $sal = $this->db->get_where('salary_structures', array('employee_id' => $teacher_id))->row();
                $gross = $salary;
                $basic = isset($sal->basic) ? $sal->basic : round($gross * 0.40);
                $hra = isset($sal->hra) ? $sal->hra : round($gross * 0.20);
                $da = round($gross * 0.10);
                $special = $gross - $basic - $hra - $da;
                $epf = isset($sal->pf) ? $sal->pf : 0;
                $esi = isset($sal->esi) ? $sal->esi : 0;
                $pt = isset($sal->pt) ? $sal->pt : 0;
                $tds = isset($sal->tax) ? $sal->tax : 0;
                $net = $gross - $epf - $esi - $pt - $tds;
                ?>
                <table class="table table-striped" style="font-size: 14px;">
                    <thead><tr style="background: #1a1a2e; color: #fff;"><th>Component</th><th class="text-right">Monthly (₹)</th><th class="text-right">Annual (₹)</th></tr></thead>
                    <tbody>
                        <tr><td>Basic Pay</td><td class="text-right"><?php echo number_format($basic); ?></td><td class="text-right"><?php echo number_format($basic*12); ?></td></tr>
                        <tr><td>HRA</td><td class="text-right"><?php echo number_format($hra); ?></td><td class="text-right"><?php echo number_format($hra*12); ?></td></tr>
                        <tr><td>Dearness Allowance</td><td class="text-right"><?php echo number_format($da); ?></td><td class="text-right"><?php echo number_format($da*12); ?></td></tr>
                        <tr><td>Special Allowance</td><td class="text-right"><?php echo number_format($special); ?></td><td class="text-right"><?php echo number_format($special*12); ?></td></tr>
                        <tr style="background: #ecf0f1; font-weight: 700;"><td>Gross Salary</td><td class="text-right"><?php echo number_format($gross); ?></td><td class="text-right"><?php echo number_format($gross*12); ?></td></tr>
                        <tr><td style="color: #c0392b;">(-) EPF</td><td class="text-right" style="color: #c0392b;"><?php echo number_format($epf); ?></td><td class="text-right" style="color: #c0392b;"><?php echo number_format($epf*12); ?></td></tr>
                        <tr><td style="color: #c0392b;">(-) ESI</td><td class="text-right" style="color: #c0392b;"><?php echo number_format($esi); ?></td><td class="text-right" style="color: #c0392b;"><?php echo number_format($esi*12); ?></td></tr>
                        <tr><td style="color: #c0392b;">(-) Professional Tax</td><td class="text-right" style="color: #c0392b;"><?php echo number_format($pt); ?></td><td class="text-right" style="color: #c0392b;"><?php echo number_format($pt*12); ?></td></tr>
                        <tr><td style="color: #c0392b;">(-) TDS</td><td class="text-right" style="color: #c0392b;"><?php echo number_format($tds); ?></td><td class="text-right" style="color: #c0392b;"><?php echo number_format($tds*12); ?></td></tr>
                        <tr style="background: #d4efdf; font-weight: 700;"><td>Net Take-Home</td><td class="text-right"><?php echo number_format($net); ?></td><td class="text-right"><?php echo number_format($net*12); ?></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Payslip History -->
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-history text-primary"></i> Payslip History</h3>
                <?php
                $payslips = $this->db->get_where('payroll', array('employee_id' => $teacher_id))->result();
                ?>
                <?php if(!empty($payslips)): ?>
                <table class="table table-hover" style="font-size: 14px;">
                    <thead><tr style="background: #f8f9fa;"><th>Month/Year</th><th class="text-right">Gross</th><th class="text-right">Deductions</th><th class="text-right">Net Pay</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach($payslips as $slip): 
                        $total_deductions = ($slip->epf ?: 0) + ($slip->esi ?: 0) + ($slip->pt ?: 0) + ($slip->tds ?: 0);
                    ?>
                    <tr>
                        <td><b><?php echo $slip->month; ?>/<?php echo $slip->year; ?></b></td>
                        <td class="text-right">₹<?php echo number_format($slip->gross_salary); ?></td>
                        <td class="text-right" style="color: #c0392b;">₹<?php echo number_format($total_deductions); ?></td>
                        <td class="text-right"><b>₹<?php echo number_format($slip->net_salary); ?></b></td>
                        <td>
                            <?php if($slip->status == 'paid'): ?>
                                <span class="label label-success">Paid</span>
                            <?php else: ?>
                                <span class="label label-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #999; text-align: center; padding: 20px;">No payslips generated yet. Go to <a href="<?php echo base_url();?>admin/payroll">Payroll & Salaries</a> to generate.</p>
                <?php endif; ?>
            </div>

            <!-- Leave History -->
            <?php if($this->db->table_exists('leave_requests')): ?>
            <div class="white-box" style="border-radius: 12px;">
                <h3 class="box-title"><i class="fa fa-calendar-times-o text-warning"></i> Leave History</h3>
                <?php
                $this->db->order_by('created_at', 'DESC');
                $leaves = $this->db->get_where('leave_requests', array('employee_id' => $teacher_id))->result();
                ?>
                <?php if(!empty($leaves)): ?>
                <table class="table table-hover" style="font-size: 14px;">
                    <thead><tr style="background: #f8f9fa;"><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach($leaves as $leave): 
                        $days = (strtotime($leave->to_date) - strtotime($leave->from_date)) / 86400 + 1;
                    ?>
                    <tr>
                        <td><?php echo $leave->leave_type; ?></td>
                        <td><?php echo date('d M Y', strtotime($leave->from_date)); ?></td>
                        <td><?php echo date('d M Y', strtotime($leave->to_date)); ?></td>
                        <td><b><?php echo $days; ?></b></td>
                        <td>
                            <?php if($leave->status == 'approved'): ?>
                                <span class="label label-success">Approved</span>
                            <?php elseif($leave->status == 'pending'): ?>
                                <span class="label label-warning">Pending</span>
                            <?php else: ?>
                                <span class="label label-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #999; text-align: center; padding: 20px;">No leave records yet.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
