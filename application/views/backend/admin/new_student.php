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
            <div class="form-group col-md-3">
                <label>Admission No *</label>
                <input type="text" class="form-control" name="admission_no" placeholder="e.g., SS/2026/0001" required style="font-weight: 600;">
            </div>
            <div class="form-group col-md-3">
                <label>Session *</label>
                <select name="session" class="form-control select2" style="width:100%" required>
                    <option value="">Select Session</option>
                    <?php
                    $current_year = (int)date('Y');
                    // If current month is before June, current academic session started last year
                    if ((int)date('m') < 6) $current_year--;
                    for ($y = $current_year; $y >= 2012; $y--) {
                        $session_str = $y . '-' . ($y + 1);
                        $is_current = ($y == $current_year) ? ' (Current)' : '';
                        $selected = ($y == $current_year) ? 'selected' : '';
                        echo '<option value="' . $session_str . '" ' . $selected . '>' . $session_str . $is_current . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
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
            <div class="form-group col-md-3">
                <label>Section *</label>
                <select name="section_id" class="form-control select2" style="width:100%" id="section_selector_holder">
                    <option value="">Select class first</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Student Status *</label>
                <select name="student_status" class="form-control" required style="font-weight: 600;">
                    <option value="active" selected>✅ Active (Currently Studying)</option>
                    <option value="left">🚪 Left School</option>
                    <option value="completed">🎓 Completed (10th Pass / Passed Out)</option>
                </select>
            </div>
            <div class="form-group col-md-8">
                <label>&nbsp;</label>
                <div class="alert alert-info" style="margin: 0; padding: 8px 12px; font-size: 12px; border-radius: 6px;">
                    <i class="fa fa-info-circle"></i> <strong>For old students:</strong> Set the <strong>Session</strong> to their admission year, <strong>Class</strong> to their last/current class, and <strong>Status</strong> accordingly.
                </div>
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
                <select name="religion" class="form-control">
                    <option value="">Select</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Christian">Christian</option>
                    <option value="Sikh">Sikh</option>
                    <option value="Buddhist">Buddhist</option>
                    <option value="Jain">Jain</option>
                    <option value="Other">Other</option>
                </select>
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
                <select name="m_tongue" class="form-control">
                    <option value="">Select</option>
                    <option value="Telugu">Telugu</option>
                    <option value="Hindi">Hindi</option>
                    <option value="English">English</option>
                    <option value="Urdu">Urdu</option>
                    <option value="Tamil">Tamil</option>
                    <option value="Kannada">Kannada</option>
                    <option value="Malayalam">Malayalam</option>
                    <option value="Marathi">Marathi</option>
                    <option value="Bengali">Bengali</option>
                    <option value="Gujarati">Gujarati</option>
                    <option value="Odia">Odia</option>
                    <option value="Punjabi">Punjabi</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Caste</label>
                <select name="caste" class="form-control">
                    <option value="">Select</option>
                    <option value="OC">OC (General)</option>
                    <option value="BC-A">BC-A</option>
                    <option value="BC-B">BC-B</option>
                    <option value="BC-C">BC-C</option>
                    <option value="BC-D">BC-D</option>
                    <option value="BC-E">BC-E</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                    <option value="EWS">EWS</option>
                    <option value="Other">Other</option>
                </select>
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
                <select name="state" class="form-control">
                    <option value="">Select State</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Telangana" selected>Telangana</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="West Bengal">West Bengal</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Assam">Assam</option>
                    <option value="Goa">Goa</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                    <option value="Other">Other</option>
                </select>
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
                <select name="bank_name" class="form-control select2" style="width:100%">
                    <option value="">Select Bank</option>
                    <option value="State Bank of India">State Bank of India (SBI)</option>
                    <option value="Andhra Bank">Andhra Bank</option>
                    <option value="Bank of Baroda">Bank of Baroda</option>
                    <option value="Canara Bank">Canara Bank</option>
                    <option value="Central Bank of India">Central Bank of India</option>
                    <option value="HDFC Bank">HDFC Bank</option>
                    <option value="ICICI Bank">ICICI Bank</option>
                    <option value="Indian Bank">Indian Bank</option>
                    <option value="Indian Overseas Bank">Indian Overseas Bank</option>
                    <option value="Punjab National Bank">Punjab National Bank</option>
                    <option value="Union Bank of India">Union Bank of India</option>
                    <option value="Axis Bank">Axis Bank</option>
                    <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                    <option value="Yes Bank">Yes Bank</option>
                    <option value="IDBI Bank">IDBI Bank</option>
                    <option value="Telangana Grameena Bank">Telangana Grameena Bank</option>
                    <option value="Andhra Pradesh Grameena Vikas Bank">AP Grameena Vikas Bank</option>
                    <option value="Post Office">Post Office Savings</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Account Number</label>
                <input type="text" class="form-control" name="bank_account_number" placeholder="e.g., 12345678901234">
            </div>
            <div class="form-group col-md-4">
                <label>IFSC Code</label>
                <input type="text" class="form-control" name="bank_ifsc" placeholder="e.g., SBIN0001234" style="text-transform: uppercase;">
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
                    <a class="btn btn-default" id="btnSelectParent" onclick="toggleParentMode('select')">
                        <i class="fa fa-search"></i> Select Existing Parent
                    </a>
                    <a class="btn btn-info active" id="btnNewParent" onclick="toggleParentMode('new')">
                        <i class="fa fa-plus"></i> Create New Parent
                    </a>
                </div>
            </div>
        </div>

        <!-- SELECT EXISTING -->
        <div id="existingParentSection" style="display: none;">
            <div class="form-group">
                <label>Select Parent *</label>
                <select name="parent_id" class="form-control select2" style="width:100%" id="parent_id_select" disabled>
                    <option value="">Select parent</option>
                    <?php $parents = $this->db->get('parent')->result_array();
                    foreach($parents as $row){ ?>
                        <option value="<?php echo $row['parent_id'];?>"><?php echo $row['name'];?> (<?php echo $row['phone'];?>)</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <!-- CREATE NEW PARENT -->
        <div id="newParentSection">
            <input type="hidden" name="parent_id" id="parent_id_hidden" value="new">

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
                <select name="ps_purpose" class="form-control">
                    <option value="">Select Reason</option>
                    <option value="Transfer">Transfer to another school</option>
                    <option value="Promotion">Promotion / Class completed</option>
                    <option value="Family Relocation">Family Relocation</option>
                    <option value="Financial Reasons">Financial Reasons</option>
                    <option value="Health Issues">Health Issues</option>
                    <option value="Completed Studies">Completed Studies</option>
                    <option value="Discontinued">Discontinued</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Class Studied</label>
                <select name="class_study" class="form-control">
                    <option value="">Select Class</option>
                    <option value="Pre-KG">Pre-KG / Nursery</option>
                    <option value="LKG">LKG</option>
                    <option value="UKG">UKG</option>
                    <option value="1st">1st Class</option>
                    <option value="2nd">2nd Class</option>
                    <option value="3rd">3rd Class</option>
                    <option value="4th">4th Class</option>
                    <option value="5th">5th Class</option>
                    <option value="6th">6th Class</option>
                    <option value="7th">7th Class</option>
                    <option value="8th">8th Class</option>
                    <option value="9th">9th Class</option>
                    <option value="10th">10th Class</option>
                </select>
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
                            <th>Admission No</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Session</th>
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
                            <td><strong style="color: #667eea;"><?php echo isset($student['admission_no']) && $student['admission_no'] ? $student['admission_no'] : '—';?></strong></td>
                            <td>
                                <strong><?php echo $student['name'];?></strong><br>
                                <small style="color: #999;"><?php echo $student['roll'];?></small>
                            </td>
                            <td><?php echo $class ? $class->name : '—';?></td>
                            <td><?php echo isset($student['session']) ? $student['session'] : '—';?></td>
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