<?php error_reporting(E_ALL); ini_set('display_errors', 1); ?>

  <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-info ">
                            <div class="panel-heading"><i class="fa fa-id-card"></i>&nbsp;&nbsp;Register New Staff
                                <div class="pull-right"><a href="#" data-perform="panel-collapse" class="btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD NEW STAFF</a> <a href="#" data-perform="panel-dismiss"></a> </div>
                            </div>
                            <div class="panel-wrapper collapse out" aria-expanded="true">
                                <div class="panel-body">
                                    
								
								 <?php echo form_open(base_url() . 'admin/staff/insert/' , array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

<div class="row">
    <!-- COL 1: Personal & Contact -->
    <div class="col-md-6">
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 25px;"><i class="fa fa-user text-info"></i> Personal Information</h3>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Full Name *</label>
                    <input type="text" class="form-control" name="name" placeholder="e.g., Ramesh Kumar" required>
                    <small class="text-muted">Staff ID: <strong>SCH001-STF-<?php echo date('Y');?>-XXXX</strong> (auto)</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Staff Role *</label>
                    <select name="role" class="form-control select2" style="width:100%;" required>
                        <option value="">Select Role</option>
                        <option value="10">Driver</option>
                        <option value="11">Watchman / Security</option>
                        <option value="12">Peon / Office Boy</option>
                        <option value="13">Caretaker / Ayah</option>
                        <option value="14">Cook</option>
                        <option value="15">Lab Assistant</option>
                        <option value="16">Clerk</option>
                        <option value="17">Librarian</option>
                        <option value="18">Sweeper / Cleaner</option>
                        <option value="19">Gardener</option>
                        <option value="20">Helper / General</option>
                        <option value="99">Other</option>
                    </select>
                    <small class="text-muted">Staff category / type</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="e.g., ramesh@school.com">
                    <small class="text-muted">Optional for non-teaching staff</small>
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
                    <select name="marital_status" class="form-control select2">
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
                    <small class="text-muted">Password for staff portal login</small>
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
            <h3 class="box-title" style="margin-bottom: 25px;"><i class="fa fa-briefcase text-success"></i> Documents & Identity</h3>

            <div class="form-group">
                <label>Documents (ID Proof / Certificates)</label>
                <input type="file" name="file_name" class="form-control dropify">
                <small class="text-muted">Upload any required ID proof or certificates (PDF/ZIP/DOC)</small>
            </div>
        </div>

        <!-- BANK & DEDUCTIONS -->
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; margin-top: 20px; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 25px;"><i class="fa fa-bank text-warning"></i> Payroll Details</h3>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Department *</label>
                    <select name="department_id" class="form-control select2" onchange="get_designation_val_staff(this.value)" required>
                        <option value="">Select Dept</option>
                        <?php $dept = $this->db->get('department')->result_array(); foreach ($dept as $row): ?>
                            <option value="<?php echo $row['department_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Assigned department</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Designation</label>
                    <select name="designation_id" class="form-control select2" id="designation_holder_staff">
                        <option value="">Select Dept First</option>
                    </select>
                    <small class="text-muted">Job title / designation</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Joining Salary *</label>
                    <input type="number" class="form-control" name="joining_salary" placeholder="e.g., 12000" required>
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
            <h4 class="box-title" style="font-size: 14px;"><i class="fa fa-money"></i> Bank Details</h4>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Account Holder Name</label>
                    <input type="text" class="form-control" name="account_holder_name" placeholder="As per bank records">
                </div>
                <div class="form-group col-md-6">
                    <label>Account Number</label>
                    <input type="text" class="form-control" name="account_number" placeholder="Bank account number">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" name="bank_name" placeholder="e.g., SBI, HDFC">
                </div>
                <div class="form-group col-md-6">
                    <label>Branch</label>
                    <input type="text" class="form-control" name="branch" placeholder="Branch name">
                </div>
            </div>

            <hr>
            <h4 class="box-title" style="font-size: 14px;"><i class="fa fa-money"></i> Manual Deductions</h4>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>EPF</label>
                    <input type="number" step="0.01" class="form-control" name="pf" placeholder="0">
                    <small class="text-muted">Provident Fund</small>
                </div>
                <div class="form-group col-md-3">
                    <label>ESI</label>
                    <input type="number" step="0.01" class="form-control" name="esi" placeholder="0">
                    <small class="text-muted">State Insurance</small>
                </div>
                <div class="form-group col-md-3">
                    <label>PT</label>
                    <input type="number" step="0.01" class="form-control" name="pt" placeholder="0">
                    <small class="text-muted">Professional Tax</small>
                </div>
                <div class="form-group col-md-3">
                    <label>TDS</label>
                    <input type="number" step="0.01" class="form-control" name="tax" placeholder="0">
                    <small class="text-muted">Tax at Source</small>
                </div>
            </div>
            
        </div>
    </div> <!-- END COL 2 -->

</div> <!-- END ROW -->

<div class="form-group" style="margin-top: 20px;">
    <button type="submit" class="btn btn-info btn-rounded btn-block btn-sm">
        <i class="fa fa-plus"></i> ADD STAFF MEMBER
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
                            <div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;Non-Teaching Staff List</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body" style="overflow: visible;">
			
                                <table id="example23" class="display nowrap " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="80"><div>Photo</div></th>
                            <th><div>Name</div></th>
                            <th><div>Staff ID</div></th>
                            <th><div>Role</div></th>
                            <th><div>Phone</div></th>
                            <th><div>Gender</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
        <?php 
        if(isset($select_staff)) {
        foreach($select_staff as $key => $staff){ ?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher', $staff['teacher_id']);?>" class="img-circle" width="40px"></td>
                            <td>
                                <strong><?php echo $staff['name'];?></strong><br>
                                <small style="color: #999;"><?php echo isset($staff['email']) ? $staff['email'] : '';?></small>
                            </td>
                            <td>
                                <code style="font-size: 12px; background: #f5f5f5; padding: 3px 8px; border-radius: 4px;"><?php echo $staff['teacher_number'];?></code>
                            </td>
                            <td>
                                <span class="label label-warning">
                                   <?php 
                                       $staff_roles = array(
                                           10 => 'Driver',
                                           11 => 'Watchman / Security',
                                           12 => 'Peon / Office Boy',
                                           13 => 'Caretaker / Ayah',
                                           14 => 'Cook',
                                           15 => 'Lab Assistant',
                                           16 => 'Clerk',
                                           17 => 'Librarian',
                                           18 => 'Sweeper / Cleaner',
                                           19 => 'Gardener',
                                           20 => 'Helper / General',
                                           99 => 'Other'
                                       );
                                       echo isset($staff_roles[$staff['role']]) ? $staff_roles[$staff['role']] : 'Staff';
                                   ?>
                                </span>
                            </td>
                            <td><?php echo $staff['phone'];?></td>
                            <td><?php echo ucfirst($staff['sex']);?></td>

                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Options <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_teacher/<?php echo $staff['teacher_id'];?>');">                                            
                                            <i class="fa fa-edit text-info"></i>
                                            Edit Profile
                                        </a>
                                    </li>
                                    <li class="divider"></li>

                                    <!-- HR LETTERS -->
                                    <li class="dropdown-header">HR DOCUMENTS</li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_hr_letter/<?php echo $staff['teacher_id'];?>/joining');">
                                            <i class="fa fa-file-text-o text-success"></i> Joining Letter
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_hr_letter/<?php echo $staff['teacher_id'];?>/relieving');">
                                            <i class="fa fa-sign-out text-danger"></i> Relieving Letter
                                        </a>
                                    </li>
                                    <li class="divider"></li>

                                    <!-- DELETE -->
                                    <li>
                                        <a href="#" style="color: #e74c3c !important;" onclick="confirm_modal('<?php echo base_url();?>admin/staff/delete/<?php echo $staff['teacher_id'];?>');">
                                            <i class="fa fa-trash"></i> Delete Record
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            </td>
                        </tr>

        <?php } 
        } ?>
						
                    </tbody>
                </table>


</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
    
    function get_designation_val_staff(department_id) {
        if(department_id != '')
            $.ajax({
                url: '<?php echo base_url();?>admin/get_designation/' + department_id,
                success: function(response)
                {
                    jQuery('#designation_holder_staff').html(response);
                }
            });
        else
            jQuery('#designation_holder_staff').html('<option value=""><?php echo get_phrase("select_a_department_first"); ?></option>');
    }
    
</script>
