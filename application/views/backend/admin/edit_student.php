<?php $students = $this->db->get_where('student', array('student_id' => $student_id))->result_array();
        foreach($students as $key => $student):
        $parent_row = $this->db->get_where('parent', array('parent_id' => $student['parent_id']))->row();
?>

<div class="row bg-title">
    <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title" style="font-weight: 700;">Edit Student: <?php echo $student['name'];?></h4>
    </div>
    <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
            <li><a href="<?php echo base_url();?>admin/student_information">Students</a></li>
            <li class="active">Edit</li>
        </ol>
    </div>
</div>

<?php echo form_open(base_url() . 'admin/new_student/update/' . $student_id , array('class' => 'form-horizontal validate', 'enctype' => 'multipart/form-data'));?>

<div class="row">

<!-- ═══════ COLUMN 1 ═══════ -->
<div class="col-md-6">

    <!-- Academic Info -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #667eea; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-graduation-cap" style="color: #667eea;"></i> Academic Information</h3>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Class *</label>
                <select name="class_id" class="form-control select2" style="width:100%" id="class_id" 
                    onchange="return get_class_sections(this.value)" required>
                    <option value="">Select</option>
                    <?php $classes = $this->db->get('class')->result_array();
                    foreach($classes as $class){ ?>
                        <option value="<?php echo $class['class_id'];?>" <?php if($student['class_id'] == $class['class_id']) echo 'selected';?>><?php echo $class['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Section *</label>
                <select name="section_id" class="form-control select2" style="width:100%" id="section_selector_holder">
                    <option value="">Select class first</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Parent *</label>
                <select name="parent_id" class="form-control select2" style="width:100%" required>
                    <option value="">Select</option>
                    <?php $parents = $this->db->get('parent')->result_array();
                    foreach($parents as $parent){ ?>
                        <option value="<?php echo $parent['parent_id'];?>" <?php if($student['parent_id'] == $parent['parent_id']) echo 'selected';?>><?php echo $parent['name'];?> (<?php echo $parent['phone'];?>)</option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #16a34a; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-user" style="color: #16a34a;"></i> Personal Information</h3>
        
        <div class="row">
            <div class="form-group col-md-4">
                <label>Photo</label>
                <input type='file' name="userfile" class="form-control" onChange="readURL(this);" style="font-size: 12px;">
            </div>
            <div class="form-group col-md-4" style="text-align: center;">
                <img id="preview_image" src="<?php echo base_url();?>uploads/student_image/<?php echo $student['student_id'].'.jpg';?>" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #eee; object-fit: cover;" onerror="this.src='<?php echo base_url();?>uploads/student_image/default.jpg'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Full Name *</label>
                <input type="text" class="form-control" name="name" value="<?php echo $student['name'];?>" required>
            </div>
            <div class="form-group col-md-3">
                <label>Date of Birth *</label>
                <input type="date" class="form-control" name="birthday" id="birthday_field" value="<?php echo $student['birthday'];?>" onchange="calculateAge()" required>
            </div>
            <div class="form-group col-md-3">
                <label>Age</label>
                <input type="text" class="form-control" name="age" id="age" value="<?php echo $student['age'];?>" readonly style="background: #f5f5f5;">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label>Gender *</label>
                <select name="sex" class="form-control" required>
                    <option value="">Select</option>
                    <option value="male" <?php if($student['sex'] == 'male') echo 'selected';?>>Male</option>
                    <option value="female" <?php if($student['sex'] == 'female') echo 'selected';?>>Female</option>
                    <option value="other" <?php if($student['sex'] == 'other') echo 'selected';?>>Other</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Blood Group</label>
                <select name="blood_group" class="form-control">
                    <option value="">Select</option>
                    <?php foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg) { ?>
                        <option value="<?php echo $bg;?>" <?php if($student['blood_group'] == $bg) echo 'selected';?>><?php echo $bg;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Religion</label>
                <input type="text" class="form-control" name="religion" value="<?php echo $student['religion'];?>">
            </div>
            <div class="form-group col-md-3">
                <label>Place of Birth</label>
                <input type="text" class="form-control" name="place_birth" value="<?php echo $student['place_birth'];?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label>Nationality</label>
                <input type="text" class="form-control" name="nationality" value="<?php echo $student['nationality'];?>">
            </div>
            <div class="form-group col-md-3">
                <label>Mother Tongue</label>
                <input type="text" class="form-control" name="m_tongue" value="<?php echo $student['m_tongue'];?>">
            </div>
            <div class="form-group col-md-3">
                <label>Caste</label>
                <input type="text" class="form-control" name="caste" value="<?php echo isset($student['caste']) ? $student['caste'] : '';?>">
            </div>
            <div class="form-group col-md-3">
                <label>Sub-Caste</label>
                <input type="text" class="form-control" name="sub_caste" value="<?php echo isset($student['sub_caste']) ? $student['sub_caste'] : '';?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Medium of Instruction</label>
                <select name="medium" class="form-control">
                    <option value="">Select</option>
                    <?php foreach(['English','Telugu','Hindi','Urdu','Tamil','Kannada'] as $m) { ?>
                        <option value="<?php echo $m;?>" <?php if(isset($student['medium']) && $student['medium'] == $m) echo 'selected';?>><?php echo $m;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $student['phone'];?>">
            </div>
            <div class="form-group col-md-4">
                <label>Email *</label>
                <input type="email" class="form-control" name="email" value="<?php echo $student['email'];?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="2"><?php echo $student['address'];?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>City</label>
                <input type="text" class="form-control" name="city" value="<?php echo $student['city'];?>">
            </div>
            <div class="form-group col-md-6">
                <label>State</label>
                <input type="text" class="form-control" name="state" value="<?php echo $student['state'];?>">
            </div>
        </div>
    </div>

    <!-- Identity & Compliance -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #f59e0b; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-id-card" style="color: #f59e0b;"></i> Identity & Compliance</h3>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Aadhaar Number</label>
                <input type="text" class="form-control" name="aadhaar_number" value="<?php echo isset($student['aadhaar_number']) ? $student['aadhaar_number'] : '';?>" maxlength="14">
            </div>
            <div class="form-group col-md-4">
                <label>APPAR Number</label>
                <input type="text" class="form-control" name="appar_number" value="<?php echo isset($student['appar_number']) ? $student['appar_number'] : '';?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Identification Mark 1</label>
                <input type="text" class="form-control" name="identification_mark_1" value="<?php echo isset($student['identification_mark_1']) ? $student['identification_mark_1'] : '';?>">
            </div>
            <div class="form-group col-md-6">
                <label>Identification Mark 2</label>
                <input type="text" class="form-control" name="identification_mark_2" value="<?php echo isset($student['identification_mark_2']) ? $student['identification_mark_2'] : '';?>">
            </div>
        </div>
    </div>

    <!-- Bank Details -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #dc2626; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-bank" style="color: #dc2626;"></i> Bank Details</h3>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Bank Name</label>
                <input type="text" class="form-control" name="bank_name" value="<?php echo isset($student['bank_name']) ? $student['bank_name'] : '';?>">
            </div>
            <div class="form-group col-md-4">
                <label>Account Number</label>
                <input type="text" class="form-control" name="bank_account_number" value="<?php echo isset($student['bank_account_number']) ? $student['bank_account_number'] : '';?>">
            </div>
            <div class="form-group col-md-4">
                <label>IFSC Code</label>
                <input type="text" class="form-control" name="bank_ifsc" value="<?php echo isset($student['bank_ifsc']) ? $student['bank_ifsc'] : '';?>">
            </div>
        </div>
    </div>

</div><!-- END COL 1 -->


<!-- ═══════ COLUMN 2 ═══════ -->
<div class="col-md-6">

    <!-- School Assignment -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #0891b2; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-university" style="color: #0891b2;"></i> School Assignment</h3>
        <div class="row">
            <div class="form-group col-md-4">
                <label>House</label>
                <select name="house_id" class="form-control select2" style="width:100%">
                    <option value="">Select</option>
                    <?php $houses = $this->db->get('house')->result_array();
                    foreach($houses as $h){ ?>
                        <option value="<?php echo $h['house_id'];?>" <?php if($student['house_id'] == $h['house_id']) echo 'selected';?>><?php echo $h['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Club</label>
                <select name="club_id" class="form-control select2" style="width:100%">
                    <option value="">Select</option>
                    <?php $clubs = $this->db->get('club')->result_array();
                    foreach($clubs as $c){ ?>
                        <option value="<?php echo $c['club_id'];?>" <?php if($student['club_id'] == $c['club_id']) echo 'selected';?>><?php echo $c['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Category</label>
                <select name="student_category_id" class="form-control select2" style="width:100%">
                    <option value="">Select</option>
                    <?php $cats = $this->db->get('student_category')->result_array();
                    foreach($cats as $cat){ ?>
                        <option value="<?php echo $cat['student_category_id'];?>" <?php if($student['student_category_id'] == $cat['student_category_id']) echo 'selected';?>><?php echo $cat['name'];?></option>
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
                    foreach($dorms as $d){ ?>
                        <option value="<?php echo $d['dormitory_id'];?>" <?php if($student['dormitory_id'] == $d['dormitory_id']) echo 'selected';?>><?php echo $d['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Transport</label>
                <select name="transport_id" class="form-control select2" style="width:100%">
                    <option value="">No Transport</option>
                    <?php $transports = $this->db->get('transport')->result_array();
                    foreach($transports as $t){ ?>
                        <option value="<?php echo $t['transport_id'];?>" <?php if($student['transport_id'] == $t['transport_id']) echo 'selected';?>><?php echo $t['route_name'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Parent / Guardian Details -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #9333ea; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 15px; font-size: 16px;"><i class="fa fa-users" style="color: #9333ea;"></i> Parent / Guardian Details</h3>
        
        <!-- Father Details -->
        <div style="background: #f0f4ff; border-radius: 8px; padding: 15px; margin-bottom: 12px;">
            <h5 style="margin: 0 0 12px 0; font-weight: 700; color: #1a1a2e; font-size: 14px;">
                <i class="fa fa-male" style="color: #2563eb;"></i> Father's Details
            </h5>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Father's Name</label>
                    <input type="text" class="form-control" name="father_name" value="<?php echo isset($parent_row->father_name) ? $parent_row->father_name : (isset($parent_row->name) ? $parent_row->name : '');?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Father's Phone</label>
                    <input type="text" class="form-control" name="father_phone" value="<?php echo isset($parent_row->father_phone) ? $parent_row->father_phone : (isset($parent_row->phone) ? $parent_row->phone : '');?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Father's Email</label>
                    <input type="email" class="form-control" name="father_email" value="<?php echo isset($parent_row->father_email) ? $parent_row->father_email : '';?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Occupation</label>
                    <input type="text" class="form-control" name="father_occupation" value="<?php echo isset($parent_row->father_occupation) ? $parent_row->father_occupation : '';?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Father's Aadhaar</label>
                    <input type="text" class="form-control" name="father_aadhaar" value="<?php echo isset($parent_row->father_aadhaar) ? $parent_row->father_aadhaar : '';?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Qualification</label>
                    <input type="text" class="form-control" name="father_qualification" value="<?php echo isset($parent_row->father_qualification) ? $parent_row->father_qualification : '';?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Annual Income</label>
                    <input type="text" class="form-control" name="father_annual_income" value="<?php echo isset($parent_row->father_annual_income) ? $parent_row->father_annual_income : '';?>">
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
                    <label>Mother's Name</label>
                    <input type="text" class="form-control" name="mother_name" value="<?php echo isset($parent_row->mother_name) ? $parent_row->mother_name : '';?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Mother's Phone</label>
                    <input type="text" class="form-control" name="mother_phone" value="<?php echo isset($parent_row->mother_phone) ? $parent_row->mother_phone : '';?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Mother's Email</label>
                    <input type="email" class="form-control" name="mother_email" value="<?php echo isset($parent_row->mother_email) ? $parent_row->mother_email : '';?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Occupation</label>
                    <input type="text" class="form-control" name="mother_occupation" value="<?php echo isset($parent_row->mother_occupation) ? $parent_row->mother_occupation : '';?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Mother's Aadhaar</label>
                    <input type="text" class="form-control" name="mother_aadhaar" value="<?php echo isset($parent_row->mother_aadhaar) ? $parent_row->mother_aadhaar : '';?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Qualification</label>
                    <input type="text" class="form-control" name="mother_qualification" value="<?php echo isset($parent_row->mother_qualification) ? $parent_row->mother_qualification : '';?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Previous School -->
    <div class="white-box" style="border-radius: 12px; border-left: 4px solid #6b7280; margin-bottom: 15px;">
        <h3 class="box-title" style="margin-bottom: 20px; font-size: 16px;"><i class="fa fa-history" style="color: #6b7280;"></i> Previous School Details</h3>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Previous School</label>
                <input type="text" class="form-control" name="ps_attended" value="<?php echo $student['ps_attended'];?>">
            </div>
            <div class="form-group col-md-6">
                <label>School Address</label>
                <textarea name="ps_address" class="form-control" rows="1"><?php echo $student['ps_address'];?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Reason for Leaving</label>
                <input type="text" class="form-control" name="ps_purpose" value="<?php echo $student['ps_purpose'];?>">
            </div>
            <div class="form-group col-md-4">
                <label>Class Studied</label>
                <input type="text" class="form-control" name="class_study" value="<?php echo $student['class_study'];?>">
            </div>
            <div class="form-group col-md-4">
                <label>Date of Leaving</label>
                <input type="date" class="form-control" name="date_of_leaving" value="<?php echo $student['date_of_leaving'];?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label>Admission Date</label>
                <input type="date" class="form-control" name="am_date" value="<?php echo $student['am_date'];?>">
            </div>
            <div class="form-group col-md-4">
                <label>Transfer Certificate</label>
                <select name="tran_cert" class="form-control">
                    <option value="">Select</option>
                    <option value="yes" <?php if($student['tran_cert'] == 'yes' || $student['tran_cert'] == 'Yes') echo 'selected';?>>Yes</option>
                    <option value="no" <?php if($student['tran_cert'] == 'no' || $student['tran_cert'] == 'No') echo 'selected';?>>No</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>DOB Certificate</label>
                <select name="dob_cert" class="form-control">
                    <option value="">Select</option>
                    <option value="yes" <?php if($student['dob_cert'] == 'yes' || $student['dob_cert'] == 'Yes') echo 'selected';?>>Yes</option>
                    <option value="no" <?php if($student['dob_cert'] == 'no' || $student['dob_cert'] == 'No') echo 'selected';?>>No</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Marks Statement</label>
                <select name="mark_join" class="form-control">
                    <option value="">Select</option>
                    <option value="yes" <?php if($student['mark_join'] == 'yes' || $student['mark_join'] == 'Yes') echo 'selected';?>>Yes</option>
                    <option value="no" <?php if($student['mark_join'] == 'no' || $student['mark_join'] == 'No') echo 'selected';?>>No</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Physically Handicapped</label>
                <select name="physical_h" class="form-control">
                    <option value="">Select</option>
                    <option value="yes" <?php if($student['physical_h'] == 'yes' || $student['physical_h'] == 'Yes') echo 'selected';?>>Yes</option>
                    <option value="no" <?php if($student['physical_h'] == 'no' || $student['physical_h'] == 'No') echo 'selected';?>>No</option>
                </select>
            </div>
        </div>
    </div>

</div><!-- END COL 2 -->
</div><!-- END ROW -->

<!-- SUBMIT -->
<div class="row" style="margin-bottom: 30px;">
    <div class="col-md-12">
        <button type="submit" class="btn btn-success btn-rounded btn-block btn-lg" style="font-weight: 700; font-size: 16px; padding: 12px; background: linear-gradient(135deg, #16a34a, #0891b2); border: none;">
            <i class="fa fa-check-circle"></i> &nbsp; UPDATE STUDENT DETAILS
        </button>
    </div>
</div>

<?php echo form_close();?>
<?php endforeach;?>

<script type="text/javascript">
function get_class_sections(class_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function calculateAge() {
    var birthday = document.getElementById('birthday_field').value;
    if (birthday) {
        var birthDate = new Date(birthday);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) age--;
        document.getElementById('age').value = age + ' years';
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) { document.getElementById('preview_image').src = e.target.result; }
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-load sections on page load
$(document).ready(function() {
    var class_id = $('#class_id').val();
    var current_section = '<?php echo $student['section_id'];?>';
    if (class_id) {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
            success: function(response) {
                $('#section_selector_holder').html(response);
                if (current_section) {
                    $('#section_selector_holder').val(current_section);
                }
            }
        });
    }
});
</script>