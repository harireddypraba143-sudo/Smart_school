<?php error_reporting(E_ALL); ini_set('display_errors', 1); ?>

				
  <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-info ">
                            <div class="panel-heading"><?php echo get_phrase('new_teacher');?>
                                <div class="pull-right"><a href="#" data-perform="panel-collapse" class="btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD NEW TEACHER</a> <a href="#" data-perform="panel-dismiss"></a> </div>
                            </div>
                            <div class="panel-wrapper collapse out" aria-expanded="true">
                                <div class="panel-body">
                                    
									
								 <?php echo form_open(base_url() . 'admin/teacher/insert/' , array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

<div class="row">
    <!-- COL 1: Personal & Contact -->
    <div class="col-md-6">
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 25px;"><i class="fa fa-user text-info"></i> Personal Information</h3>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Full Name *</label>
                    <input type="text" class="form-control" name="name" placeholder="e.g., Rajesh Kumar" required>
                    <small class="text-muted">Employee ID: <strong>SCH001-EMP-<?php echo date('Y');?>-XXXX</strong> (auto)</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Role *</label>
                    <select name="role" class="form-control select2" style="width:100%;" required>
                        <option value="">Select Role</option>
                        <option value="1">Class Teacher</option>
                        <option value="2">Subject Teacher</option>
                    </select>
                    <small class="text-muted">Primary teaching role</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Email *</label>
                    <input type="email" class="form-control" name="email" placeholder="e.g., rajesh@school.com" required>
                    <small class="text-muted">Official email for login</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone *</label>
                    <input type="text" class="form-control" name="phone" placeholder="e.g., 9876543210" required>
                    <small class="text-muted">10-digit mobile number</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Gender *</label>
                    <select name="sex" class="form-control select2" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <small class="text-muted">Gender as per records</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Birthday *</label>
                    <input type="date" class="form-control" name="birthday" required>
                    <small class="text-muted">Date of birth (YYYY-MM-DD)</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Marital Status</label>
                    <select name="marital_status" class="form-control select2" required>
                        <option value="">Select</option>
                        <option value="Married">Married</option>
                        <option value="Single">Single</option>
                        <option value="Divorced">Divorced</option>
                    </select>
                    <small class="text-muted">Current marital status</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Blood Group</label>
                    <input type="text" class="form-control" name="blood_group" placeholder="e.g., O+, A-, B+">
                    <small class="text-muted">Blood group for emergency</small>
                </div>
            </div>

            <div class="form-group">
                <label>Detailed Address *</label>
                <textarea class="form-control" name="address" rows="2" placeholder="e.g., H.No 12, Main Road, City - 500001" required></textarea>
                <small class="text-muted">Full residential address with PIN code</small>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Login Password *</label>
                    <input type="password" class="form-control" name="password" placeholder="Min 6 characters" required>
                    <small class="text-muted">Password for employee portal login</small>
                </div>
                 <div class="form-group col-md-6">
                    <label>Profile Image *</label>
                    <input type='file' name="userfile" class="form-control dropify" required>
                    <small class="text-muted">Passport-size photo (JPG/PNG)</small>
                </div>
            </div>

        </div>
    </div> <!-- END COL 1 -->

    <!-- COL 2: HR & Compliance -->
    <div class="col-md-6">
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 25px;"><i class="fa fa-briefcase text-success"></i> HR & Compliance</h3>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>PAN Card</label>
                    <input type="text" class="form-control" name="pan_num" placeholder="e.g., ABCDE1234F">
                    <small class="text-muted">10-character PAN number</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Aadhaar / National ID</label>
                    <input type="text" class="form-control" name="aadhaar_num" placeholder="e.g., 1234-5678-9012">
                    <small class="text-muted">12-digit Aadhaar number</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>EPF UAN Number</label>
                    <input type="text" class="form-control" name="uan_num" placeholder="e.g., 100012345678">
                    <small class="text-muted">Universal Account Number</small>
                </div>
                <div class="form-group col-md-6">
                    <label>ESI IP Number</label>
                    <input type="text" class="form-control" name="esi_num" placeholder="e.g., 1100000012">
                    <small class="text-muted">ESI Insurance number</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Qualification</label>
                    <input type="text" class="form-control" name="qualification" placeholder="e.g., M.Ed, B.Sc, Ph.D">
                    <small class="text-muted">Highest educational degree</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Experience (Years)</label>
                    <input type="number" class="form-control" name="experience" placeholder="e.g., 5">
                    <small class="text-muted">Total years of teaching</small>
                </div>
            </div>

            <div class="form-group">
                <label>Documents (CV / Offer Letters)</label>
                <input type="file" name="file_name" class="form-control dropify" required>
                <small class="text-muted">Upload CV, certificates (PDF/ZIP/DOC)</small>
            </div>

        </div>

        <!-- BANK & DEDUCTIONS -->
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; margin-top: 20px; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 25px;"><i class="fa fa-bank text-warning"></i> Payroll Details</h3>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Department *</label>
                    <select name="department_id" class="form-control select2" onchange="get_designation_val(this.value)" required>
                        <option value="">Select Dept</option>
                        <?php $dept = $this->db->get('department')->result_array(); foreach ($dept as $row): ?>
                            <option value="<?php echo $row['department_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Assigned department</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Designation</label>
                    <select name="designation_id" class="form-control select2" id="designation_holder">
                        <option value="">Select Dept First</option>
                    </select>
                    <small class="text-muted">Job title / designation</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Joining Salary *</label>
                    <input type="number" class="form-control" name="joining_salary" placeholder="e.g., 25000" required>
                    <small class="text-muted">Monthly gross salary (INR)</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Employment Status</label>
                    <select name="status" class="form-control select2">
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                    <small class="text-muted">Current employment status</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Date of Joining *</label>
                    <input type="date" class="form-control" name="date_of_joining" value="<?php echo date('Y-m-d');?>" required>
                    <small class="text-muted">Official start date</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Date of Leaving</label>
                    <input type="date" class="form-control" name="date_of_leaving">
                    <small class="text-muted">Leave blank if still employed</small>
                </div>
            </div>

            <hr>
            <h4 class="box-title" style="font-size: 14px;"><i class="fa fa-money"></i> Manual Deductions</h4>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>EPF</label>
                    <input type="number" step="0.01" class="form-control" name="pf" placeholder="1800">
                    <small class="text-muted">Provident Fund</small>
                </div>
                <div class="form-group col-md-3">
                    <label>ESI</label>
                    <input type="number" step="0.01" class="form-control" name="esi" placeholder="112.50">
                    <small class="text-muted">State Insurance</small>
                </div>
                <div class="form-group col-md-3">
                    <label>PT</label>
                    <input type="number" step="0.01" class="form-control" name="pt" placeholder="200">
                    <small class="text-muted">Professional Tax</small>
                </div>
                <div class="form-group col-md-3">
                    <label>TDS</label>
                    <input type="number" step="0.01" class="form-control" name="tax" placeholder="660">
                    <small class="text-muted">Tax at Source</small>
                </div>
            </div>
            
        </div>
    </div> <!-- END COL 2 -->

</div> <!-- END ROW -->

<div class="form-group" style="margin-top: 20px;">
    <button type="submit" class="btn btn-info btn-rounded btn-block btn-sm">
        <i class="fa fa-plus"></i> ADD TEACHER
    </button>
</div>
<?php echo form_close();?>	
									
									
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
					
            <div class="row">
                    <div class="col-sm-12">
				  	<div class="panel panel-info ">
                            <div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo get_phrase('list_teachers');?></div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body" style="overflow: visible;">
			
                                <table id="example23" class="display nowrap " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div>Employee ID</div></th>
                            <th><div><?php echo get_phrase('role');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('gender');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
        <?php foreach($select_teacher as $key => $teacher){ ?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher', $teacher['teacher_id']);?>" class="img-circle" width="40px"></td>
                            <td>
                                <a href="<?php echo base_url();?>admin/employee_profile/<?php echo $teacher['teacher_id'];?>" style="color: #1a1a2e; font-weight: 600;"><?php echo $teacher['name'];?></a><br>
                                <small style="color: #999;"><?php echo $teacher['phone'];?></small>
                            </td>
                            <td>
                                <code style="font-size: 12px; background: #f5f5f5; padding: 3px 8px; border-radius: 4px;"><?php echo $teacher['teacher_number'];?></code>
                            </td>
                            <td>
                                <span class="label label-info">
                                   <?php if($teacher['role']== 1) echo 'Class Teacher';?>
                                   <?php if($teacher['role']== 2) echo 'Subject Teacher';?>
                                </span>
                            </td>
                            <td><?php echo $teacher['email'];?></td>
                            <td><?php echo ucfirst($teacher['sex']);?></td>

                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Options <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/edit_employee/<?php echo $teacher['teacher_id'];?>');">                                            
                                            <i class="fa fa-edit text-info"></i>
                                            <?php echo get_phrase('edit_profile');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>

                                    <!-- HR LETTERS -->
                                    <li class="dropdown-header">HR DOCUMENTS</li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher['teacher_id'];?>/joining');">
                                            <i class="fa fa-file-text-o text-success"></i> Joining Letter
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher['teacher_id'];?>/joining_report');">
                                            <i class="fa fa-clipboard text-primary"></i> Joining Report
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher['teacher_id'];?>/welcome');">
                                            <i class="fa fa-file-pdf-o text-warning"></i> Welcome Letter
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher['teacher_id'];?>/hike');">
                                            <i class="fa fa-arrow-up text-primary"></i> Salary Hike Letter
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/hrms/modal_hr_letter/<?php echo $teacher['teacher_id'];?>/relieving');">
                                            <i class="fa fa-sign-out text-danger"></i> Relieving Letter
                                        </a>
                                    </li>
                                    <li class="divider"></li>

                                    <!-- DOWNLOAD/DELETE -->
                                    <li>
                                        <a href="<?php echo base_url().'uploads/teacher_image/'.  $teacher['file_name'];?>">
                                            <i class="fa fa-download text-info"></i> Download CV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" style="color: #e74c3c !important;" onclick="confirm_modal('<?php echo base_url();?>admin/teacher/delete/<?php echo $teacher['teacher_id'];?>');">
                                            <i class="fa fa-trash"></i> <?php echo get_phrase('delete_record');?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            </td>
                        </tr>

        <?php } ?>
						
                    </tbody>
                </table>



</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
    
    function get_designation_val(department_id) {
        if(department_id != '')
            $.ajax({
                url: '<?php echo base_url();?>admin/get_designation/' + department_id,
                success: function(response)
                {
                    console.log(response);
                    jQuery('#designation_holder').html(response);
                }
            });
        else
            jQuery('#designation_holder').html('<option value=""><?php echo get_phrase("select_a_department_first"); ?></option>');
    }
    
</script>
