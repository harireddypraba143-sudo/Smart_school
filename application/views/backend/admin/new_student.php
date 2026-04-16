<?php
$auto_session = $this->db->get_where('settings', array('type' => 'running_session'))->row()->description;
?>

<div class="row bg-title">
    <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title" style="font-weight: 700;">Student Admission</h4>
    </div>
    <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
            <li class="active">New Admission</li>
        </ol>
    </div>
</div>

<?php echo form_open(base_url() . 'admin/new_student/create/' , array('class' => 'form-horizontal validate', 'enctype' => 'multipart/form-data', 'id' => 'admissionForm'));?>

<div class="row">

<!-- ════════════════════════════════════════════════════════════════ -->
<!-- COLUMN 1 — Student Details -->
<!-- ════════════════════════════════════════════════════════════════ -->
<div class="col-md-6">

    <!-- SECTION 1: Academic Info -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #667eea; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-graduation-cap" style="color: #667eea;"></i> Academic Information</h3>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Session *</label>
                <select name="session" class="form-control">
                    <option value="<?php echo $auto_session; ?>" selected><?php echo $auto_session; ?> (Current)</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Class *</label>
                <select name="class_id" class="form-control select2" style="width:100%" id="class_id" 
                    onchange="$.ajax({url: '<?php echo base_url();?>admin/get_class_section/' + this.value, success: function(response){jQuery('#section_selector_holder').html(response);}});" required>
                    <option value="">Select</option>
                    <?php $classes = $this->db->get('class')->result_array();
                    foreach($classes as $row){ ?>
                        <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Section *</label>
                <select name="section_id" class="form-control select2" style="width:100%" id="section_selector_holder">
                    <option value="">Select class first</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="roll" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>">
    </div>

    <!-- SECTION 2: Personal Information -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #16a34a; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-user" style="color: #16a34a;"></i> Personal Information</h3>
        
        <div class="row">
            <div class="form-group col-md-4">
                <label>Photo</label>
                <input type='file' name="userfile" class="form-control" onChange="readURL(this);" style="font-size: 12px;">
            </div>
            <div class="form-group col-md-4" style="text-align: center;">
                <img id="preview_image" src="<?php echo base_url();?>uploads/student_image/default.jpg" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #eee; object-fit: cover;">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Full Name *</label>
                <input type="text" class="form-control" name="name" placeholder="e.g., Rahul Sharma" required>
            </div>
            <div class="form-group col-md-3">
                <label>Date of Birth *</label>
                <input type="date" class="form-control" name="birthday" id="birthday_field" onchange="calculateAge()" required>
            </div>
            <div class="form-group col-md-3">
                <label>Age</label>
                <input type="text" class="form-control" name="age" id="age" readonly style="background: #f5f5f5;">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label>Gender *</label>
                <select name="sex" class="form-control" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Blood Group</label>
                <select name="blood_group" class="form-control">
                    <option value="">Select</option>
                    <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                    <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Religion</label>
                <input type="text" class="form-control" name="religion" placeholder="e.g., Hindu">
            </div>
            <div class="form-group col-md-3">
                <label>Place of Birth</label>
                <input type="text" class="form-control" name="place_birth" placeholder="e.g., Hyderabad">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label>Nationality *</label>
                <input type="text" class="form-control" name="nationality" value="Indian" required>
            </div>
            <div class="form-group col-md-3">
                <label>Mother Tongue</label>
                <input type="text" class="form-control" name="m_tongue" placeholder="e.g., Telugu">
            </div>
            <div class="form-group col-md-3">
                <label>Caste</label>
                <input type="text" class="form-control" name="caste" placeholder="e.g., OBC / General">
            </div>
            <div class="form-group col-md-3">
                <label>Sub-Caste</label>
                <input type="text" class="form-control" name="sub_caste" placeholder="e.g., Reddy">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Medium of Instruction *</label>
                <select name="medium" class="form-control" required>
                    <option value="">Select</option>
                    <option value="English">English</option>
                    <option value="Telugu">Telugu</option>
                    <option value="Hindi">Hindi</option>
                    <option value="Urdu">Urdu</option>
                    <option value="Tamil">Tamil</option>
                    <option value="Kannada">Kannada</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="e.g., 9876543210">
            </div>
            <div class="form-group col-md-4">
                <label>Email *</label>
                <input type="email" class="form-control" name="email" placeholder="e.g., student@email.com" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label>Address *</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Full residential address with PIN code" required></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>City</label>
                <input type="text" class="form-control" name="city" placeholder="e.g., Hyderabad">
            </div>
            <div class="form-group col-md-4">
                <label>State</label>
                <input type="text" class="form-control" name="state" placeholder="e.g., Telangana">
            </div>
            <div class="form-group col-md-4">
                <label>Password *</label>
                <input type="password" class="form-control" name="password" placeholder="Student portal login" required>
            </div>
        </div>
    </div>

    <!-- SECTION 3: Identity & Compliance -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #f59e0b; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-id-card" style="color: #f59e0b;"></i> Identity & Compliance</h3>
        
        <div class="row">
            <div class="form-group col-md-4">
                <label>Aadhaar Number</label>
                <input type="text" class="form-control" name="aadhaar_number" placeholder="e.g., 1234-5678-9012" maxlength="14">
            </div>
            <div class="form-group col-md-4">
                <label>APPAR Number</label>
                <input type="text" class="form-control" name="appar_number" placeholder="Automated Permanent Academic A/C">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Identification Mark 1</label>
                <input type="text" class="form-control" name="identification_mark_1" placeholder="e.g., Mole on right cheek">
            </div>
            <div class="form-group col-md-6">
                <label>Identification Mark 2</label>
                <input type="text" class="form-control" name="identification_mark_2" placeholder="e.g., Scar on left hand">
            </div>
        </div>
    </div>

    <!-- SECTION 4: Bank Details -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #dc2626; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-bank" style="color: #dc2626;"></i> Bank Details</h3>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Bank Name</label>
                <input type="text" class="form-control" name="bank_name" placeholder="e.g., State Bank of India">
            </div>
            <div class="form-group col-md-4">
                <label>Account Number</label>
                <input type="text" class="form-control" name="bank_account_number" placeholder="e.g., 12345678901234">
            </div>
            <div class="form-group col-md-4">
                <label>IFSC Code</label>
                <input type="text" class="form-control" name="bank_ifsc" placeholder="e.g., SBIN0001234">
            </div>
        </div>
    </div>

</div><!-- END COL 1 -->


<!-- ════════════════════════════════════════════════════════════════ -->
<!-- COLUMN 2 — Parent & School Details -->
<!-- ════════════════════════════════════════════════════════════════ -->
<div class="col-md-6">

    <!-- SECTION 5: Parent / Guardian (Inline Creation) -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #9333ea; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 15px; font-size: 16px;"><i class="fa fa-users" style="color: #9333ea;"></i> Parent / Guardian Details</h3>
        
        <!-- Toggle: Existing vs New -->
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <div class="btn-group btn-group-justified" role="group">
                    <a class="btn btn-info active" id="btnSelectParent" onclick="toggleParentMode('select')">
                        <i class="fa fa-search"></i> Select Existing Parent
                    </a>
                    <a class="btn btn-default" id="btnNewParent" onclick="toggleParentMode('new')">
                        <i class="fa fa-plus"></i> Create New Parent
                    </a>
                </div>
            </div>
        </div>

        <!-- SELECT EXISTING -->
        <div id="existingParentSection">
            <div class="form-group">
                <label>Select Parent *</label>
                <select name="parent_id" class="form-control select2" style="width:100%" id="parent_id_select" required>
                    <option value="">Select parent</option>
                    <?php $parents = $this->db->get('parent')->result_array();
                    foreach($parents as $row){ ?>
                        <option value="<?php echo $row['parent_id'];?>"><?php echo $row['name'];?> (<?php echo $row['phone'];?>)</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <!-- CREATE NEW PARENT -->
        <div id="newParentSection" style="display: none;">
            <input type="hidden" name="parent_id" id="parent_id_hidden" value="" disabled>

            <!-- Father Details -->
            <div style="background: #f0f4ff; border-radius: 8px; padding: 15px; margin-bottom: 12px;">
                <h5 style="margin: 0 0 12px 0; font-weight: 700; color: #1a1a2e; font-size: 14px;">
                    <i class="fa fa-male" style="color: #2563eb;"></i> Father's Details
                </h5>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Father's Name *</label>
                        <input type="text" class="form-control" name="father_name" placeholder="e.g., Ramesh Kumar">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Father's Phone *</label>
                        <input type="text" class="form-control" name="father_phone" placeholder="e.g., 9876543210">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Father's Email</label>
                        <input type="email" class="form-control" name="father_email" placeholder="e.g., father@email.com">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Father's Occupation</label>
                        <input type="text" class="form-control" name="father_occupation" placeholder="e.g., Engineer">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Father's Aadhaar</label>
                        <input type="text" class="form-control" name="father_aadhaar" placeholder="1234-5678-9012">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Qualification</label>
                        <input type="text" class="form-control" name="father_qualification" placeholder="e.g., B.Tech">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Annual Income</label>
                        <input type="text" class="form-control" name="father_annual_income" placeholder="e.g., 500000">
                    </div>
                </div>
            </div>

            <!-- Mother Details -->
            <div style="background: #fdf0f4; border-radius: 8px; padding: 15px; margin-bottom: 12px;">
                <h5 style="margin: 0 0 12px 0; font-weight: 700; color: #1a1a2e; font-size: 14px;">
                    <i class="fa fa-female" style="color: #e11d48;"></i> Mother's Details
                </h5>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mother's Name *</label>
                        <input type="text" class="form-control" name="mother_name" placeholder="e.g., Sita Devi">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Mother's Phone</label>
                        <input type="text" class="form-control" name="mother_phone" placeholder="e.g., 9876543210">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mother's Email</label>
                        <input type="email" class="form-control" name="mother_email" placeholder="e.g., mother@email.com">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Mother's Occupation</label>
                        <input type="text" class="form-control" name="mother_occupation" placeholder="e.g., Homemaker">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mother's Aadhaar</label>
                        <input type="text" class="form-control" name="mother_aadhaar" placeholder="1234-5678-9012">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Qualification</label>
                        <input type="text" class="form-control" name="mother_qualification" placeholder="e.g., B.A.">
                    </div>
                </div>
            </div>

            <!-- Parent Login -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Parent Login Email *</label>
                    <input type="email" class="form-control" name="parent_email" placeholder="For parent portal login">
                </div>
                <div class="form-group col-md-6">
                    <label>Parent Password</label>
                    <input type="password" class="form-control" name="parent_password" placeholder="Default: 123456">
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 6: School Assignment -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #0891b2; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-university" style="color: #0891b2;"></i> School Assignment</h3>

        <div class="row">
            <div class="form-group col-md-4">
                <label>House *</label>
                <select name="house_id" class="form-control select2" style="width:100%" required>
                    <option value="">Select</option>
                    <?php $houses = $this->db->get('house')->result_array();
                    foreach($houses as $row){ ?>
                        <option value="<?php echo $row['house_id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Club *</label>
                <select name="club_id" class="form-control select2" style="width:100%" required>
                    <option value="">Select</option>
                    <?php $clubs = $this->db->get('club')->result_array();
                    foreach($clubs as $row){ ?>
                        <option value="<?php echo $row['club_id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Category</label>
                <select name="student_category_id" class="form-control select2" style="width:100%">
                    <option value="">Select</option>
                    <?php $cats = $this->db->get('student_category')->result_array();
                    foreach($cats as $row){ ?>
                        <option value="<?php echo $row['student_category_id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Hostel</label>
                <select name="dormitory_id" class="form-control select2" style="width:100%">
                    <option value="">No Hostel</option>
                    <?php $dorms = $this->db->get('dormitory')->result_array();
                    foreach($dorms as $row){ ?>
                        <option value="<?php echo $row['dormitory_id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Transport</label>
                <select name="transport_id" class="form-control select2" style="width:100%">
                    <option value="">No Transport</option>
                    <?php $transports = $this->db->get('transport')->result_array();
                    foreach($transports as $row){ ?>
                        <option value="<?php echo $row['transport_id'];?>"><?php echo $row['route_name'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <!-- SECTION 7: Previous School -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #6b7280; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-history" style="color: #6b7280;"></i> Previous School Details</h3>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Previous School Attended</label>
                <input type="text" class="form-control" name="ps_attended" placeholder="School name">
            </div>
            <div class="form-group col-md-6">
                <label>Previous School Address</label>
                <textarea name="ps_address" class="form-control" rows="1" placeholder="Address"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Purpose of Leaving</label>
                <input type="text" class="form-control" name="ps_purpose" placeholder="Reason for leaving">
            </div>
            <div class="form-group col-md-4">
                <label>Class Studied</label>
                <input type="text" class="form-control" name="class_study" placeholder="Last class studied">
            </div>
            <div class="form-group col-md-4">
                <label>Date of Leaving</label>
                <input type="date" class="form-control" name="date_of_leaving">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Admission Date</label>
                <input type="date" class="form-control" name="am_date" value="<?php echo date('Y-m-d');?>">
            </div>
            <div class="form-group col-md-4">
                <label>Transfer Certificate</label>
                <select name="tran_cert" class="form-control">
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>DOB Certificate</label>
                <select name="dob_cert" class="form-control">
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Marks Statement</label>
                <select name="mark_join" class="form-control">
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Physically Handicapped</label>
                <select name="physical_h" class="form-control">
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
    </div>

</div><!-- END COL 2 -->
</div><!-- END ROW -->

<!-- SUBMIT BUTTON -->
<div class="row" style="margin-bottom: 30px;">
    <div class="col-md-12">
        <button type="submit" class="btn btn-info btn-rounded btn-block btn-lg" style="font-weight: 700; font-size: 16px; padding: 12px; background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
            <i class="fa fa-check-circle"></i> &nbsp; SUBMIT ADMISSION FORM
        </button>
    </div>
</div>

<?php echo form_close();?>

<!-- ══════════════ STUDENT LIST ══════════════ -->
<div class="row">
    <div class="col-sm-12">
        <div class="white-box" style="border-radius: 12px;">
            <h3 class="box-title"><i class="fa fa-list text-info"></i> Admitted Students</h3>
            <div class="table-responsive">
                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="50">Photo</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Parent</th>
                            <th>Phone</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $students = $this->db->get('student')->result_array();
                        foreach($students as $student){ 
                            $class = $this->db->get_where('class', array('class_id' => $student['class_id']))->row();
                            $parent = $this->db->get_where('parent', array('parent_id' => $student['parent_id']))->row();
                        ?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student', $student['student_id']);?>" class="img-circle" width="40"></td>
                            <td>
                                <strong><?php echo $student['name'];?></strong><br>
                                <small style="color: #999;"><?php echo $student['roll'];?></small>
                            </td>
                            <td><?php echo $class ? $class->name : '—';?></td>
                            <td><?php echo $parent ? $parent->name : '—';?></td>
                            <td><?php echo $student['phone'];?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-info btn-xs" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_student/<?php echo $student['student_id'];?>');">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-xs" onclick="confirm_modal('<?php echo base_url();?>admin/new_student/delete/<?php echo $student['student_id'];?>');">
                                        <i class="fa fa-trash"></i>
                                    </a>
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

<script type="text/javascript">
function toggleParentMode(mode) {
    if (mode === 'new') {
        document.getElementById('existingParentSection').style.display = 'none';
        document.getElementById('newParentSection').style.display = 'block';
        document.getElementById('parent_id_select').disabled = true;
        document.getElementById('parent_id_select').removeAttribute('required');
        document.getElementById('parent_id_hidden').disabled = false;
        document.getElementById('parent_id_hidden').value = 'new';
        document.getElementById('btnNewParent').className = 'btn btn-info active';
        document.getElementById('btnSelectParent').className = 'btn btn-default';
    } else {
        document.getElementById('existingParentSection').style.display = 'block';
        document.getElementById('newParentSection').style.display = 'none';
        document.getElementById('parent_id_select').disabled = false;
        document.getElementById('parent_id_select').setAttribute('required', 'required');
        document.getElementById('parent_id_hidden').disabled = true;
        document.getElementById('btnSelectParent').className = 'btn btn-info active';
        document.getElementById('btnNewParent').className = 'btn btn-default';
    }
}

function calculateAge() {
    var birthday = document.getElementById('birthday_field').value;
    if (birthday) {
        var birthDate = new Date(birthday);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age + ' years';
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview_image').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>