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

<!-- OCR Auto-Fill Button -->
<div class="row" style="margin-bottom:10px;">
    <div class="col-md-12">
        <button type="button" class="btn btn-lg" onclick="startOCRSession()" 
            style="background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; font-weight:700; border:none; border-radius:10px; padding:10px 24px;">
            <i class="fa fa-camera"></i> &nbsp;📸 OCR Auto Fill — Scan Aadhaar / Bank Passbook
        </button>
        <span id="ocr_connection_status" style="margin-left:10px; display:none;"></span>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="ocrModal" tabindex="-1">
    <div class="modal-dialog modal-sm" style="margin-top:80px;">
        <div class="modal-content" style="border-radius:16px; text-align:center; padding:24px;">
            <h4 style="font-weight:700; margin-bottom:4px;">📱 Scan with Phone</h4>
            <p style="color:#666; font-size:13px; margin-bottom:16px;">Open your phone camera and scan this QR code</p>
            <div id="qrcode_container" style="display:inline-block; padding:12px; background:#fff; border-radius:12px; border:2px solid #eee;"></div>
            <p style="margin-top:12px; font-size:11px; color:#999;">Or open this URL on your phone:</p>
            <input type="text" id="scanner_url_display" class="form-control" readonly style="font-size:11px; text-align:center; background:#f8f9fa; margin-bottom:12px;">
            <div id="ocr_waiting" style="color:#f59e0b; font-size:13px;">
                <i class="fa fa-spinner fa-spin"></i> Waiting for scans...
            </div>
            <button class="btn btn-default btn-block" data-dismiss="modal" style="margin-top:10px;">Close</button>
        </div>
    </div>
</div>

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
        
        <!-- Row 1: Name, DOB, Age -->
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

        <!-- Row 2: Gender, Blood Group, Religion, Nationality -->
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
                <label>Nationality *</label>
                <select name="nationality" class="form-control" required>
                    <option value="Indian" selected>Indian</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <!-- Row 3: Mother Tongue, Caste, Sub-Caste, Medium -->
        <div class="row">
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
            <div class="form-group col-md-3">
                <label>Medium *</label>
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
        </div>

        <!-- Row 4: Phone, Email, Place of Birth -->
        <div class="row">
            <div class="form-group col-md-4">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="e.g., 9876543210">
            </div>
            <div class="form-group col-md-4">
                <label>Email *</label>
                <input type="email" class="form-control" name="email" placeholder="e.g., student@email.com" required>
            </div>
            <div class="form-group col-md-4">
                <label>Place of Birth</label>
                <input type="text" class="form-control" name="place_birth" placeholder="e.g., Hyderabad">
            </div>
        </div>

        <!-- Row 5: Photo -->
        <div class="row">
            <div class="form-group col-md-4">
                <label>Photo</label>
                <input type='file' name="userfile" class="form-control" onChange="readURL(this);" style="font-size: 12px;">
            </div>
            <div class="form-group col-md-2" style="text-align: center;">
                <img id="preview_image" src="<?php echo base_url();?>uploads/student_image/default.jpg" style="width: 70px; height: 70px; border-radius: 50%; border: 3px solid #eee; object-fit: cover;">
            </div>
        </div>

        <!-- Row 6: Address -->
        <div class="row">
            <div class="form-group col-md-12">
                <label>Address *</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Full residential address (House No, Street, Village/Town, Mandal, PIN)" required></textarea>
            </div>
        </div>

        <!-- Row 7: PIN Code, State, City, Password -->
        <div class="row">
            <div class="form-group col-md-3">
                <label>PIN Code <small style="color:#999;">(auto-fills city & state)</small></label>
                <input type="text" class="form-control" name="pin_code" id="pin_code" placeholder="e.g., 500001" maxlength="6" onkeyup="if(this.value.length==6) lookupPincode(this.value)">
                <small id="pin_status" style="color:#16a34a; display:none;"><i class="fa fa-check-circle"></i> Found</small>
            </div>
            <div class="form-group col-md-3">
                <label>State</label>
                <select name="state" class="form-control" id="state_select" onchange="filterCities()">
                    <option value="">Select State</option>
                    <option value="Telangana" selected>Telangana</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
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
            <div class="form-group col-md-3">
                <label>City / District</label>
                <select name="city" class="form-control select2" style="width:100%" id="city_select">
                    <option value="">Select City</option>
                </select>
            </div>
            <div class="form-group col-md-3">
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
                        <label>Father's Phone * <small style="color:#999;">(auto-detects siblings)</small></label>
                        <input type="text" class="form-control" name="father_phone" id="father_phone" placeholder="e.g., 9876543210" onkeyup="if(this.value.length>=10) lookupParentByPhone(this.value)">
                        <div id="sibling_alert" style="display:none; margin-top:6px;"></div>
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
// ═══ State → City Mapping ═══
var stateCities = {
    'Telangana': ['Hyderabad','Warangal','Nizamabad','Karimnagar','Khammam','Mahbubnagar','Nalgonda','Adilabad','Medak','Rangareddy','Sangareddy','Siddipet','Suryapet','Mancherial','Jagtial','Peddapalli','Kamareddy','Wanaparthy','Nagarkurnool','Jogulamba Gadwal','Bhadradri Kothagudem','Jangaon','Jayashankar Bhupalpally','Medchal-Malkajgiri','Rajanna Sircilla','Vikarabad','Yadadri Bhuvanagiri','Mahabubabad','Nirmal','Kumuram Bheem Asifabad','Mulugu','Narayanpet'],
    'Andhra Pradesh': ['Visakhapatnam','Vijayawada','Guntur','Nellore','Kurnool','Tirupati','Anantapur','Rajahmundry','Kadapa','Kakinada','Eluru','Ongole','Srikakulam','Vizianagaram','Chittoor','Machilipatnam','Prakasam','Krishna','West Godavari','East Godavari','Palnadu','Bapatla','Anakapalli','Alluri Sitharama Raju','Nandyal','Sri Sathya Sai'],
    'Karnataka': ['Bangalore','Mysore','Hubli','Mangalore','Belgaum','Gulbarga','Davangere','Shimoga','Tumkur','Bellary','Bidar','Raichur','Hassan','Udupi','Chitradurga'],
    'Tamil Nadu': ['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Tuticorin','Kanchipuram','Tiruvannamalai','Nagercoil'],
    'Maharashtra': ['Mumbai','Pune','Nagpur','Thane','Nashik','Aurangabad','Solapur','Kolhapur','Sangli','Ahmednagar','Satara','Amravati','Nanded','Latur','Jalgaon'],
    'Kerala': ['Thiruvananthapuram','Kochi','Kozhikode','Thrissur','Kollam','Palakkad','Alappuzha','Kannur','Malappuram','Kottayam','Kasaragod','Idukki','Pathanamthitta','Wayanad'],
    'Delhi': ['New Delhi','Central Delhi','South Delhi','North Delhi','East Delhi','West Delhi','Shahdara','Dwarka','Rohini'],
    'Uttar Pradesh': ['Lucknow','Noida','Agra','Varanasi','Kanpur','Ghaziabad','Meerut','Allahabad','Bareilly','Aligarh','Moradabad','Gorakhpur','Mathura','Jhansi'],
    'Rajasthan': ['Jaipur','Jodhpur','Udaipur','Kota','Ajmer','Bikaner','Alwar','Bhilwara','Bharatpur','Sikar','Pali','Sri Ganganagar'],
    'Gujarat': ['Ahmedabad','Surat','Vadodara','Rajkot','Bhavnagar','Jamnagar','Gandhinagar','Junagadh','Anand','Nadiad','Mehsana','Morbi'],
    'Madhya Pradesh': ['Bhopal','Indore','Jabalpur','Gwalior','Ujjain','Sagar','Dewas','Satna','Ratlam','Rewa','Katni','Singrauli'],
    'West Bengal': ['Kolkata','Howrah','Durgapur','Siliguri','Asansol','Bardhaman','Malda','Kharagpur','Haldia','Baharampur'],
    'Bihar': ['Patna','Gaya','Bhagalpur','Muzaffarpur','Purnia','Darbhanga','Arrah','Begusarai','Katihar','Munger'],
    'Punjab': ['Chandigarh','Ludhiana','Amritsar','Jalandhar','Patiala','Bathinda','Mohali','Hoshiarpur','Pathankot'],
    'Haryana': ['Gurgaon','Faridabad','Panipat','Ambala','Karnal','Hisar','Rohtak','Sonipat','Yamunanagar','Sirsa'],
    'Odisha': ['Bhubaneswar','Cuttack','Rourkela','Berhampur','Sambalpur','Puri','Balasore','Baripada','Jharsuguda'],
    'Chhattisgarh': ['Raipur','Bhilai','Bilaspur','Korba','Durg','Rajnandgaon','Jagdalpur','Ambikapur'],
    'Jharkhand': ['Ranchi','Jamshedpur','Dhanbad','Bokaro','Hazaribagh','Deoghar','Giridih','Ramgarh'],
    'Assam': ['Guwahati','Silchar','Dibrugarh','Jorhat','Nagaon','Tinsukia','Tezpur','Bongaigaon'],
    'Goa': ['Panaji','Margao','Vasco da Gama','Mapusa','Ponda'],
    'Uttarakhand': ['Dehradun','Haridwar','Rishikesh','Haldwani','Roorkee','Kashipur','Rudrapur','Nainital'],
    'Himachal Pradesh': ['Shimla','Manali','Dharamshala','Solan','Mandi','Kullu','Bilaspur','Hamirpur'],
    'Jammu & Kashmir': ['Srinagar','Jammu','Anantnag','Baramulla','Udhampur','Kathua','Sopore']
};

function filterCities() {
    var state = document.getElementById('state_select').value;
    var citySelect = document.getElementById('city_select');
    // Destroy select2 before modifying
    if ($.fn.select2 && $(citySelect).data('select2')) {
        $(citySelect).select2('destroy');
    }
    citySelect.innerHTML = '<option value="">Select City</option>';
    if (state && stateCities[state]) {
        stateCities[state].forEach(function(city) {
            var opt = document.createElement('option');
            opt.value = city;
            opt.textContent = city;
            citySelect.appendChild(opt);
        });
    }
    // Add "Other" option always
    var otherOpt = document.createElement('option');
    otherOpt.value = 'Other';
    otherOpt.textContent = 'Other';
    citySelect.appendChild(otherOpt);
    // Re-initialize select2
    if ($.fn.select2) {
        $(citySelect).select2({width: '100%'});
    }
}

// ═══ PIN Code Auto-Lookup (India Post API) ═══
function lookupPincode(pin) {
    if (pin.length !== 6 || isNaN(pin)) return;
    var statusEl = document.getElementById('pin_status');
    statusEl.style.display = 'inline';
    statusEl.style.color = '#f59e0b';
    statusEl.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Looking up...';
    
    $.ajax({
        url: 'https://api.postalpincode.in/pincode/' + pin,
        type: 'GET',
        dataType: 'json',
        timeout: 5000,
        success: function(data) {
            if (data && data[0] && data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length > 0) {
                var po = data[0].PostOffice[0];
                var apiState = po.State || '';
                var apiDistrict = po.District || '';
                
                // Set state
                var stateSelect = document.getElementById('state_select');
                for (var i = 0; i < stateSelect.options.length; i++) {
                    if (stateSelect.options[i].value === apiState) {
                        stateSelect.value = apiState;
                        break;
                    }
                }
                
                // Filter cities for that state, then set city
                filterCities();
                setTimeout(function() {
                    var citySelect = document.getElementById('city_select');
                    var found = false;
                    for (var j = 0; j < citySelect.options.length; j++) {
                        if (citySelect.options[j].value === apiDistrict) {
                            $(citySelect).val(apiDistrict).trigger('change');
                            found = true;
                            break;
                        }
                    }
                    if (!found && apiDistrict) {
                        // Add it dynamically if not in list
                        var newOpt = new Option(apiDistrict, apiDistrict, true, true);
                        $(citySelect).prepend(newOpt).trigger('change');
                    }
                }, 200);
                
                statusEl.style.color = '#16a34a';
                statusEl.innerHTML = '<i class="fa fa-check-circle"></i> ' + apiDistrict + ', ' + apiState;
            } else {
                statusEl.style.color = '#dc2626';
                statusEl.innerHTML = '<i class="fa fa-times-circle"></i> Invalid PIN';
            }
        },
        error: function() {
            statusEl.style.color = '#dc2626';
            statusEl.innerHTML = '<i class="fa fa-exclamation-circle"></i> Could not verify';
        }
    });
}

// ═══ Parent Toggle ═══
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

// ═══ Sibling Detection — Auto-fill parent by phone ═══
function lookupParentByPhone(phone) {
    if (phone.length < 10) return;
    var alertEl = document.getElementById('sibling_alert');
    alertEl.style.display = 'block';
    alertEl.innerHTML = '<span style="color:#f59e0b;"><i class="fa fa-spinner fa-spin"></i> Searching for existing parent...</span>';
    
    $.ajax({
        url: '<?php echo base_url();?>admin/lookup_parent_by_phone',
        type: 'GET',
        data: { phone: phone },
        dataType: 'json',
        timeout: 5000,
        success: function(data) {
            if (data.found) {
                // Show sibling info
                var siblingHtml = '<div class="alert alert-success" style="padding:8px 12px; margin:0; border-radius:6px; font-size:12px;">';
                siblingHtml += '<i class="fa fa-users"></i> <strong>Parent found!</strong> ' + data.father_name;
                if (data.siblings && data.siblings.length > 0) {
                    siblingHtml += '<br><i class="fa fa-child"></i> Siblings: <strong>' + data.siblings.join(', ') + '</strong>';
                }
                siblingHtml += '<br><a href="#" onclick="useSiblingParent(' + data.parent_id + '); return false;" class="btn btn-success btn-xs" style="margin-top:4px;"><i class="fa fa-link"></i> Use this parent (skip filling)</a>';
                siblingHtml += ' <a href="#" onclick="fillParentFields(); return false;" class="btn btn-info btn-xs" style="margin-top:4px;"><i class="fa fa-pencil"></i> Auto-fill & edit</a>';
                siblingHtml += '</div>';
                alertEl.innerHTML = siblingHtml;
                
                // Store data globally for auto-fill
                window._siblingParentData = data;
            } else {
                alertEl.innerHTML = '<span style="color:#16a34a; font-size:12px;"><i class="fa fa-plus-circle"></i> New parent — please fill details below</span>';
                setTimeout(function() { alertEl.style.display = 'none'; }, 3000);
            }
        },
        error: function() {
            alertEl.style.display = 'none';
        }
    });
}

// Use existing parent directly (link sibling)
function useSiblingParent(parentId) {
    toggleParentMode('select');
    var sel = document.getElementById('parent_id_select');
    if ($.fn.select2 && $(sel).data('select2')) {
        $(sel).val(parentId).trigger('change');
    } else {
        sel.value = parentId;
    }
    document.getElementById('sibling_alert').innerHTML = '<div class="alert alert-info" style="padding:6px 10px; margin:0; border-radius:6px; font-size:12px;"><i class="fa fa-check"></i> Linked to existing parent. No need to fill parent details.</div>';
}

// Auto-fill all parent fields from sibling data
function fillParentFields() {
    var d = window._siblingParentData;
    if (!d) return;
    
    var fields = {
        'father_name': d.father_name,
        'father_phone': d.father_phone,
        'father_email': d.father_email,
        'father_occupation': d.father_occupation,
        'father_aadhaar': d.father_aadhaar,
        'father_qualification': d.father_qualification,
        'father_annual_income': d.father_annual_income,
        'mother_name': d.mother_name,
        'mother_phone': d.mother_phone,
        'mother_email': d.mother_email,
        'mother_occupation': d.mother_occupation,
        'mother_aadhaar': d.mother_aadhaar,
        'mother_qualification': d.mother_qualification
    };
    
    for (var name in fields) {
        var el = document.querySelector('[name="' + name + '"]');
        if (el && fields[name]) {
            el.value = fields[name];
            el.style.background = '#f0fff4';
            setTimeout((function(e) { return function() { e.style.background = ''; }; })(el), 3000);
        }
    }
    
    // Fill address if available
    if (d.address) {
        var addrEl = document.querySelector('[name="address"]');
        if (addrEl && !addrEl.value) {
            addrEl.value = d.address;
            addrEl.style.background = '#f0fff4';
        }
    }
    
    document.getElementById('sibling_alert').innerHTML = '<div class="alert alert-success" style="padding:6px 10px; margin:0; border-radius:6px; font-size:12px;"><i class="fa fa-check"></i> Parent details auto-filled! You can edit if needed.</div>';
}

// ═══════════════════════════════════════════════
// OCR AUTO-FILL SYSTEM
// ═══════════════════════════════════════════════
var ocrSessionId = null;
var ocrPollTimer = null;
var ocrAppliedTypes = {};

function startOCRSession() {
    $.ajax({
        url: '<?php echo base_url();?>admin/create_ocr_session',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.session_id) {
                ocrSessionId = res.session_id;
                
                // Generate QR Code
                var qrContainer = document.getElementById('qrcode_container');
                qrContainer.innerHTML = '';
                new QRCode(qrContainer, {
                    text: res.scanner_url,
                    width: 180,
                    height: 180,
                    correctLevel: QRCode.CorrectLevel.M
                });
                
                document.getElementById('scanner_url_display').value = res.scanner_url;
                $('#ocrModal').modal('show');
                
                // Start polling
                ocrAppliedTypes = {};
                startOCRPolling();
                
                // Show connection status
                var statusEl = document.getElementById('ocr_connection_status');
                statusEl.style.display = 'inline';
                statusEl.innerHTML = '<span style="color:#16a34a;"><i class="fa fa-wifi"></i> OCR Session Active</span>';
            }
        },
        error: function() { alert('Failed to create OCR session.'); }
    });
}

function startOCRPolling() {
    if (ocrPollTimer) clearInterval(ocrPollTimer);
    ocrPollTimer = setInterval(pollOCRData, 3000);
}

function pollOCRData() {
    if (!ocrSessionId) return;
    $.ajax({
        url: '<?php echo base_url();?>admin/get_ocr_data/' + ocrSessionId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status === 'has_data' && res.data) {
                var types = ['student_aadhaar', 'father_aadhaar', 'mother_aadhaar', 'bank', 'tc', 'admission_form'];
                types.forEach(function(type) {
                    if (res.data[type] && !ocrAppliedTypes[type]) {
                        applyOCRData(type, res.data[type]);
                        ocrAppliedTypes[type] = true;
                    }
                });
                
                var doneCount = Object.keys(ocrAppliedTypes).length;
                document.getElementById('ocr_waiting').innerHTML = 
                    '<span style="color:#16a34a;"><i class="fa fa-check-circle"></i> ' + doneCount + '/6 scans received</span>';
            }
        }
    });
}

function applyOCRData(type, data) {
    var fieldMap = {};
    
    if (type === 'student_aadhaar') {
        fieldMap = {
            'name': data.name,
            'aadhaar_number': data.aadhaar,
            'sex': data.gender,
            'address': data.address
        };
        // Handle DOB (convert DD/MM/YYYY to YYYY-MM-DD)
        if (data.dob) {
            var parts = data.dob.split('/');
            if (parts.length === 3) {
                var isoDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                var dobEl = document.getElementById('birthday_field');
                if (dobEl) { dobEl.value = isoDate; calculateAge(); }
            }
        }
    }
    else if (type === 'father_aadhaar') {
        fieldMap = {
            'father_name': data.name,
            'father_aadhaar': data.aadhaar
        };
        if (data.address && !document.querySelector('[name="address"]').value) {
            fieldMap['address'] = data.address;
        }
    }
    else if (type === 'mother_aadhaar') {
        fieldMap = {
            'mother_name': data.name,
            'mother_aadhaar': data.aadhaar
        };
    }
    else if (type === 'bank') {
        fieldMap = { 'bank_account_number': data.account_no, 'bank_ifsc': data.ifsc };
        if (data.bank_name) {
            var bankSel = document.querySelector('[name="bank_name"]');
            if (bankSel) { for (var i=0;i<bankSel.options.length;i++) { if (bankSel.options[i].value.indexOf(data.bank_name)>=0||data.bank_name.indexOf(bankSel.options[i].value)>=0) { bankSel.selectedIndex=i; break; } } }
        }
    }
    else if (type === 'tc') {
        fieldMap = {
            'name': data.student_name, 'father_name': data.father_name,
            'ps_attended': data.school_name, 'class_study': data.class_studied,
            'ps_purpose': data.reason
        };
        if (data.dob) {
            var parts = data.dob.replace(/-/g,'/').split('/');
            if (parts.length===3) { var dobEl=document.getElementById('birthday_field'); if(dobEl){dobEl.value=parts[2]+'-'+parts[1]+'-'+parts[0]; calculateAge();} }
        }
    }
    else if (type === 'admission_form') {
        fieldMap = {
            'name': data.student_name, 'father_name': data.father_name,
            'mother_name': data.mother_name, 'phone': data.phone
        };
        if (data.dob) {
            var parts = data.dob.replace(/-/g,'/').split('/');
            if (parts.length===3) { var dobEl=document.getElementById('birthday_field'); if(dobEl){dobEl.value=parts[2]+'-'+parts[1]+'-'+parts[0]; calculateAge();} }
        }
    }
    
    // Apply field values with green highlight
    for (var fieldName in fieldMap) {
        if (fieldMap[fieldName]) {
            var el = document.querySelector('[name="' + fieldName + '"]');
            if (el) {
                el.value = fieldMap[fieldName];
                el.style.background = '#f0fff4';
                el.style.transition = 'background 2s';
                setTimeout((function(e) { return function() { e.style.background = ''; }; })(el), 4000);
            }
        }
    }
    
    // Show notification
    var typeLabels = { student_aadhaar:'Student Aadhaar', father_aadhaar:'Father Aadhaar', mother_aadhaar:'Mother Aadhaar', bank:'Bank Passbook' };
    var statusEl = document.getElementById('ocr_connection_status');
    statusEl.innerHTML = '<span style="color:#16a34a;"><i class="fa fa-check-circle"></i> ' + typeLabels[type] + ' filled!</span>';
}

// Load Telangana cities on page load
$(document).ready(function() {
    filterCities();
});
</script>

<!-- QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>