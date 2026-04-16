<?php 
$edit_teacher		=	$this->db->get_where('teacher' , array('teacher_id' => $param2) )->result_array();
foreach ( $edit_teacher as $key => $row):
$salary = $this->db->get_where('salary_structures', array('employee_id' => $row['teacher_id']))->row();
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <?php echo get_phrase('edit_teacher');?></div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">

<?php echo form_open(base_url() . 'admin/teacher/update/'. $row['teacher_id'] , array('class' => 'form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>

<!-- Employee ID Badge -->
<div class="alert alert-info" style="padding: 10px 15px; font-size: 13px;">
    <i class="fa fa-id-badge"></i> Employee ID: <strong><?php echo $row['teacher_number'];?></strong>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <i class="fa fa-calendar"></i> Joined: <strong><?php echo $row['date_of_joining'];?></strong>
</div>

<div class="row">
    <!-- LEFT COLUMN: Personal Info -->
    <div class="col-md-6">
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 20px;"><i class="fa fa-user text-info"></i> Personal Information</h3>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Full Name *</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" placeholder="e.g., Rajesh Kumar">
                    <small class="text-muted">Employee's full legal name</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Role *</label>
                    <select name="role" class="form-control select2" required>
                        <option value="1" <?php if($row['role'] == '1')echo 'selected';?>>Class Teacher</option>
                        <option value="2" <?php if($row['role'] == '2')echo 'selected';?>>Subject Teacher</option>
                    </select>
                    <small class="text-muted">Primary teaching role</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Email *</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>" placeholder="e.g., rajesh@school.com">
                    <small class="text-muted">Official email address</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone *</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $row['phone'];?>" placeholder="e.g., 9876543210">
                    <small class="text-muted">10-digit mobile number</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Gender</label>
                    <select name="sex" class="form-control select2">
                        <option value="male" <?php if($row['sex'] == 'male')echo 'selected';?>>Male</option>
                        <option value="female" <?php if($row['sex'] == 'female')echo 'selected';?>>Female</option>
                    </select>
                    <small class="text-muted">Gender as per records</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Birthday</label>
                    <input type="date" class="form-control" name="birthday" value="<?php echo $row['birthday'];?>">
                    <small class="text-muted">Date of birth (YYYY-MM-DD)</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Marital Status</label>
                    <select class="form-control select2" name="marital_status">
                        <option value="Married" <?php if($row['marital_status'] == 'Married')echo 'selected';?>>Married</option>
                        <option value="Single" <?php if($row['marital_status'] == 'Single')echo 'selected';?>>Single</option>
                        <option value="Divorced" <?php if($row['marital_status'] == 'Divorced')echo 'selected';?>>Divorced</option>
                        <option value="Engaged" <?php if($row['marital_status'] == 'Engaged')echo 'selected';?>>Engaged</option>
                    </select>
                    <small class="text-muted">Current marital status</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Blood Group</label>
                    <input type="text" class="form-control" name="blood_group" value="<?php echo $row['blood_group'];?>" placeholder="e.g., O+, A-, B+">
                    <small class="text-muted">Blood group for emergency</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Religion</label>
                    <input type="text" class="form-control" name="religion" value="<?php echo $row['religion'];?>" placeholder="e.g., Hindu, Muslim">
                    <small class="text-muted">Religion (optional)</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Qualification</label>
                    <input type="text" class="form-control" name="qualification" value="<?php echo $row['qualification'];?>" placeholder="e.g., M.Ed, B.Sc">
                    <small class="text-muted">Highest educational qualification</small>
                </div>
            </div>

            <div class="form-group">
                <label>Detailed Address</label>
                <textarea class="form-control" name="address" rows="2" placeholder="e.g., H.No 12, Main Road, City - 500001"><?php echo $row['address'];?></textarea>
                <small class="text-muted">Full residential address with PIN code</small>
            </div>

            <div class="form-group">
                <label>Update Profile Photo</label>
                <input type='file' class="form-control" name="userfile">
                <img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" style="margin-top: 10px; border-radius: 8px;" height="80" width="80">
                <small class="text-muted">Upload new photo (JPG/PNG, max 2MB)</small>
            </div>

        </div>
    </div><!-- END LEFT COL -->

    <!-- RIGHT COLUMN: HR & Compliance -->
    <div class="col-md-6">
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 20px;"><i class="fa fa-briefcase text-success"></i> HR & Compliance</h3>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>PAN Card</label>
                    <input type="text" class="form-control" name="pan_num" value="<?php echo $row['pan_num'];?>" placeholder="e.g., ABCDE1234F">
                    <small class="text-muted">10-character PAN number</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Aadhaar / National ID</label>
                    <input type="text" class="form-control" name="aadhaar_num" value="<?php echo $row['aadhaar_num'];?>" placeholder="e.g., 1234-5678-9012">
                    <small class="text-muted">12-digit Aadhaar number</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>EPF UAN Number</label>
                    <input type="text" class="form-control" name="uan_num" value="<?php echo $row['uan_num'];?>" placeholder="e.g., 100012345678">
                    <small class="text-muted">Universal Account Number</small>
                </div>
                <div class="form-group col-md-6">
                    <label>ESI IP Number</label>
                    <input type="text" class="form-control" name="esi_num" value="<?php echo $row['esi_num'];?>" placeholder="e.g., 1100000012">
                    <small class="text-muted">ESI Insurance number</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Experience (Years)</label>
                    <input type="number" class="form-control" name="experience" value="<?php echo $row['experience'];?>" placeholder="e.g., 5">
                    <small class="text-muted">Total years of teaching experience</small>
                </div>
                <div class="form-group col-md-6">
                    <label>Religion</label>
                    <input type="text" class="form-control" name="religion" value="<?php echo $row['religion'];?>" placeholder="e.g., Hindu" disabled>
                    <small class="text-muted">Shown from personal info</small>
                </div>
            </div>

        </div>

        <!-- Payroll Deductions -->
        <div class="white-box" style="border-radius: 12px; border: 1px solid #eee; margin-top: 20px; padding: 25px;">
            <h3 class="box-title" style="margin-bottom: 20px;"><i class="fa fa-money text-warning"></i> Payroll Deductions</h3>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>EPF (Provident Fund)</label>
                    <input type="number" step="0.01" class="form-control" name="pf" value="<?php echo isset($salary->pf) ? $salary->pf : '';?>" placeholder="e.g., 1800.00">
                    <small class="text-muted">Monthly EPF deduction amount</small>
                </div>
                <div class="form-group col-md-6">
                    <label>ESI (State Insurance)</label>
                    <input type="number" step="0.01" class="form-control" name="esi" value="<?php echo isset($salary->esi) ? $salary->esi : '';?>" placeholder="e.g., 112.50">
                    <small class="text-muted">Monthly ESI deduction amount</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>PT (Professional Tax)</label>
                    <input type="number" step="0.01" class="form-control" name="pt" value="<?php echo isset($salary->pt) ? $salary->pt : '';?>" placeholder="e.g., 200.00">
                    <small class="text-muted">Monthly professional tax</small>
                </div>
                <div class="form-group col-md-6">
                    <label>TDS (Tax at Source)</label>
                    <input type="number" step="0.01" class="form-control" name="tax" value="<?php echo isset($salary->tax) ? $salary->tax : '';?>" placeholder="e.g., 660.00">
                    <small class="text-muted">Monthly TDS deduction</small>
                </div>
            </div>

        </div>
    </div><!-- END RIGHT COL -->

</div><!-- END ROW -->

<div class="form-group" style="margin-top: 20px;">
    <button type="submit" class="btn btn-info btn-rounded btn-block btn-sm">
        <i class="fa fa-check"></i>&nbsp; UPDATE TEACHER PROFILE
    </button>
</div>

<?php echo form_close();?>
</div>
</div>
</div>
</div>
</div>

<?php endforeach;?>
