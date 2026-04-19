<?php 
$teacher_id = $param2;
$letter_type = $param3;

$teacher = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row();
$system_name = $this->db->get_where('settings', array('type'=>'system_title'))->row()->description;
$system_email = $this->db->get_where('settings', array('type'=>'system_email'))->row()->description;
$system_address = $this->db->get_where('settings', array('type'=>'address'))->row()->description;
$system_phone = $this->db->get_where('settings', array('type'=>'phone'))->row()->description;

$dept = $this->db->get_where('department', array('department_id'=>$teacher->department_id))->row();
$dept_name = $dept ? $dept->name : 'Staff';

$designation = $this->db->get_where('designation', array('designation_id'=>$teacher->designation_id))->row();
$designation_name = $designation ? $designation->name : 'Teacher';

$salary = $this->db->get_where('salary_structures', array('employee_id'=>$teacher_id))->row();
$gross = $teacher->joining_salary ? $teacher->joining_salary : 0;
$basic = isset($salary->basic) ? $salary->basic : round($gross * 0.40);
$hra = isset($salary->hra) ? $salary->hra : round($gross * 0.20);
$da = round($gross * 0.10);
$special = $gross - $basic - $hra - $da;
$epf = isset($salary->pf) ? $salary->pf : 0;
$esi_amt = isset($salary->esi) ? $salary->esi : 0;
$pt = isset($salary->pt) ? $salary->pt : 0;
$tds = isset($salary->tax) ? $salary->tax : 0;
$ctc = $gross + $epf;

$title = "";
$content = "";
$date = date('d F, Y');
$joining_date = date('d M, Y', strtotime($teacher->date_of_joining));
$ref_no = $system_name . '/HR/' . date('Y') . '/' . strtoupper(substr($letter_type, 0, 3)) . '-' . $teacher->teacher_number;

// ===================== LETTER CONTENT BY TYPE =====================

if ($letter_type == 'joining') {
    $title = "EMPLOYMENT OFFER LETTER";
    $content = "
    <table style='width:100%; margin-bottom:25px;'>
        <tr><td style='color:#555; font-size:14px;'>
            <b>To,</b><br>
            <b style='color:#1a1a2e;'>{$teacher->name}</b><br>
            {$teacher->address}<br>
            Phone: {$teacher->phone}
        </td></tr>
    </table>

    <p style='background:#f0f4ff; padding:12px 18px; border-left:4px solid #2563eb; border-radius:4px; font-weight:600; color:#1a1a2e; font-size:14px;'>
        SUB: OFFER OF APPOINTMENT FOR THE POST OF <u>" . strtoupper($designation_name) . "</u>
    </p>

    <p>Dear <b>{$teacher->name}</b>,</p>

    <p>With reference to your application and subsequent interview, the Management of <b>{$system_name}</b> is pleased to offer you the position of <b>{$designation_name}</b> in the <b>{$dept_name}</b> department.</p>

    <p>Your appointment is subject to the following professional and legally structured terms:</p>

    <!-- Section 1 -->
    <div style='margin:25px 0 15px 0; padding-bottom:8px; border-bottom:2px solid #e5e7eb;'>
        <span style='background:#1a1a2e; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;'>SECTION 1</span>
        <span style='margin-left:10px; font-weight:700; color:#1a1a2e; font-size:15px;'>Commencement and Probation</span>
    </div>
    <table style='width:100%; font-size:14px; line-height:2;'>
        <tr><td style='width:30%; color:#666; padding:5px 0;'>Joining Date</td><td style='padding:5px 0;'>You are required to join on or before <b>{$joining_date}</b></td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Probation Period</td><td style='padding:5px 0;'><b>1 Year</b> (may be extended based on performance)</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Confirmation</td><td style='padding:5px 0;'>Formal Letter of Confirmation upon successful completion</td></tr>
    </table>

    <!-- Section 2 -->
    <div style='margin:25px 0 15px 0; padding-bottom:8px; border-bottom:2px solid #e5e7eb;'>
        <span style='background:#1a1a2e; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;'>SECTION 2</span>
        <span style='margin-left:10px; font-weight:700; color:#1a1a2e; font-size:15px;'>Compensation and Statutory Benefits</span>
    </div>
    <table style='width:100%; font-size:14px; line-height:2;'>
        <tr><td style='width:30%; color:#666; padding:5px 0;'>Gross Salary</td><td style='padding:5px 0;'>₹<b>" . number_format($gross) . "</b> per month (see Annexure A)</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Statutory Deductions</td><td style='padding:5px 0;'>EPF, PT, ESIC as per Government of India norms</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Gratuity</td><td style='padding:5px 0;'>As per Payment of Gratuity Act, 1972 (after 5 years)</td></tr>
    </table>

    <!-- Section 3 -->
    <div style='margin:25px 0 15px 0; padding-bottom:8px; border-bottom:2px solid #e5e7eb;'>
        <span style='background:#1a1a2e; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;'>SECTION 3</span>
        <span style='margin-left:10px; font-weight:700; color:#1a1a2e; font-size:15px;'>Duties and Working Hours</span>
    </div>
    <table style='width:100%; font-size:14px; line-height:2;'>
        <tr><td style='width:30%; color:#666; padding:5px 0;'>Work Load</td><td style='padding:5px 0;'>Teaching and non-teaching duties as assigned by the Principal</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>School Hours</td><td style='padding:5px 0;'><b>9:00 AM</b> to <b>5:00 PM</b> (may stay for meetings/functions)</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Code of Conduct</td><td style='padding:5px 0;'>As prescribed by CBSE/ICSE/State Board and School Rules</td></tr>
    </table>

    <!-- Section 4 -->
    <div style='margin:25px 0 15px 0; padding-bottom:8px; border-bottom:2px solid #e5e7eb;'>
        <span style='background:#1a1a2e; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;'>SECTION 4</span>
        <span style='margin-left:10px; font-weight:700; color:#1a1a2e; font-size:15px;'>Exclusivity and Confidentiality</span>
    </div>
    <table style='width:100%; font-size:14px; line-height:2;'>
        <tr><td style='width:30%; color:#666; padding:5px 0;'>Private Tuition</td><td style='padding:5px 0;'>Strictly prohibited as per RTE Act during tenure</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Data Privacy</td><td style='padding:5px 0;'>Absolute secrecy on student records & exam papers</td></tr>
    </table>

    <!-- Section 5 -->
    <div style='margin:25px 0 15px 0; padding-bottom:8px; border-bottom:2px solid #e5e7eb;'>
        <span style='background:#1a1a2e; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;'>SECTION 5</span>
        <span style='margin-left:10px; font-weight:700; color:#1a1a2e; font-size:15px;'>Resignation and Termination</span>
    </div>
    <table style='width:100%; font-size:14px; line-height:2;'>
        <tr><td style='width:30%; color:#666; padding:5px 0;'>During Probation</td><td style='padding:5px 0;'><b>1 month</b> notice or salary in lieu thereof</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>After Confirmation</td><td style='padding:5px 0;'><b>3 months</b> notice or salary in lieu thereof</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Mid-Session</td><td style='padding:5px 0;'>Generally not accepted, except under exceptional circumstances</td></tr>
        <tr><td style='color:#666; padding:5px 0;'>Summary Dismissal</td><td style='padding:5px 0;'>Reserved for moral turpitude, corporal punishment, gross negligence</td></tr>
    </table>

    <!-- Section 6 -->
    <div style='margin:25px 0 15px 0; padding-bottom:8px; border-bottom:2px solid #e5e7eb;'>
        <span style='background:#1a1a2e; color:#fff; padding:4px 12px; border-radius:4px; font-size:12px; font-weight:600;'>SECTION 6</span>
        <span style='margin-left:10px; font-weight:700; color:#1a1a2e; font-size:15px;'>Documents Required at Joining</span>
    </div>
    <table style='width:100%; font-size:14px;'>
        <tr><td style='padding:6px 0; color:#444;'>☑ Educational Certificates (10th, 12th, Graduation, B.Ed, PG)</td></tr>
        <tr><td style='padding:6px 0; color:#444;'>☑ Experience Certificates from previous employers</td></tr>
        <tr><td style='padding:6px 0; color:#444;'>☑ Relieving Letter from the last employer</td></tr>
        <tr><td style='padding:6px 0; color:#444;'>☑ PAN Card and Aadhaar Card</td></tr>
        <tr><td style='padding:6px 0; color:#444;'>☑ Medical Fitness Certificate from a registered practitioner</td></tr>
    </table>

    <!-- Annexure A -->
    <div style='margin-top:35px; page-break-before: auto;'>
        <div style='background:#1a1a2e; color:#fff; padding:12px 18px; border-radius:6px 6px 0 0; text-align:center;'>
            <b style='font-size:15px; letter-spacing:1px;'>ANNEXURE A — SALARY BREAKDOWN</b>
        </div>
        <table style='width:100%; border-collapse:collapse; font-size:14px;'>
            <thead>
                <tr style='background:#f8f9fa;'>
                    <th style='padding:12px 15px; text-align:left; border:1px solid #dee2e6; font-weight:600; color:#1a1a2e;'>Component</th>
                    <th style='padding:12px 15px; text-align:right; border:1px solid #dee2e6; font-weight:600; color:#1a1a2e;'>Monthly (₹)</th>
                    <th style='padding:12px 15px; text-align:right; border:1px solid #dee2e6; font-weight:600; color:#1a1a2e;'>Annual (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td style='padding:10px 15px; border:1px solid #dee2e6;'>Basic Pay</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($basic) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($basic*12) . "</td></tr>
                <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6;'>HRA</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($hra) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($hra*12) . "</td></tr>
                <tr><td style='padding:10px 15px; border:1px solid #dee2e6;'>Dearness Allowance (DA)</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($da) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($da*12) . "</td></tr>
                <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6;'>Special Allowance</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($special) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($special*12) . "</td></tr>
                <tr style='background:#1a1a2e; color:#fff; font-weight:600;'><td style='padding:12px 15px; border:1px solid #dee2e6;'>GROSS SALARY</td><td style='padding:12px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($gross) . "</td><td style='padding:12px 15px; text-align:right; border:1px solid #dee2e6;'>" . number_format($gross*12) . "</td></tr>
                <tr><td style='padding:10px 15px; border:1px solid #dee2e6; color:#c0392b;'>(-) EPF Contribution</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($epf) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($epf*12) . "</td></tr>
                <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6; color:#c0392b;'>(-) ESI</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($esi_amt) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($esi_amt*12) . "</td></tr>
                <tr><td style='padding:10px 15px; border:1px solid #dee2e6; color:#c0392b;'>(-) Professional Tax</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($pt) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($pt*12) . "</td></tr>
                <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6; color:#c0392b;'>(-) TDS</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($tds) . "</td><td style='padding:10px 15px; text-align:right; border:1px solid #dee2e6; color:#c0392b;'>" . number_format($tds*12) . "</td></tr>
                <tr style='background:#d4efdf; font-weight:700;'><td style='padding:12px 15px; border:1px solid #dee2e6; color:#1a1a2e;'>COST TO COMPANY (CTC)</td><td style='padding:12px 15px; text-align:right; border:1px solid #dee2e6; color:#1a1a2e;'>" . number_format($ctc) . "</td><td style='padding:12px 15px; text-align:right; border:1px solid #dee2e6; color:#1a1a2e;'>" . number_format($ctc*12) . "</td></tr>
            </tbody>
        </table>
        <p style='margin-top:10px; font-size:11px; color:#999; font-style:italic;'>* Subject to statutory changes as mandated by the Government of India.</p>
    </div>
    ";

} elseif ($letter_type == 'joining_report') {
    $title = "JOINING REPORT";
    $content = "
    <table style='width:100%; margin-bottom:25px;'>
        <tr><td style='color:#555; font-size:14px;'>
            <b>To,</b><br>
            The Principal / The Director,<br>
            <b style='color:#1a1a2e;'>{$system_name}</b>,<br>
            {$system_address}.
        </td></tr>
    </table>

    <p style='background:#f0f4ff; padding:12px 18px; border-left:4px solid #2563eb; border-radius:4px; font-weight:600; color:#1a1a2e; font-size:14px;'>
        SUB: JOINING REPORT FOR THE POST OF <u>" . strtoupper($designation_name) . "</u>
    </p>

    <p>Respected Sir/Madam,</p>

    <p>With reference to the Appointment Letter / Offer Letter No. <b>{$ref_no}</b> dated <b>{$joining_date}</b>, I am pleased to report for duty as <b>{$designation_name}</b> at <b>{$system_name}</b> today, <b>{$joining_date}</b>, in the <b>Forenoon</b> session.</p>

    <p>I hereby accept all the terms and conditions of service as outlined in the aforementioned Appointment Letter and the School's Service Rules.</p>

    <p style='font-weight:600; color:#1a1a2e; margin-top:20px;'>I am enclosing the following documents for your records:</p>

    <table style='width:100%; font-size:14px; border-collapse:collapse; margin:10px 0 20px 0;'>
        <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6;'>1.</td><td style='padding:10px 15px; border:1px solid #dee2e6;'>Relieving Certificate from previous employer</td><td style='padding:10px 15px; border:1px solid #dee2e6; text-align:center; width:80px;'>☐</td></tr>
        <tr><td style='padding:10px 15px; border:1px solid #dee2e6;'>2.</td><td style='padding:10px 15px; border:1px solid #dee2e6;'>Medical Fitness Certificate</td><td style='padding:10px 15px; border:1px solid #dee2e6; text-align:center;'>☐</td></tr>
        <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6;'>3.</td><td style='padding:10px 15px; border:1px solid #dee2e6;'>Self-attested Academic & Professional Credentials</td><td style='padding:10px 15px; border:1px solid #dee2e6; text-align:center;'>☐</td></tr>
        <tr><td style='padding:10px 15px; border:1px solid #dee2e6;'>4.</td><td style='padding:10px 15px; border:1px solid #dee2e6;'>Aadhaar Card (No: <b>" . ($teacher->aadhaar_num ?: '____________________') . "</b>)</td><td style='padding:10px 15px; border:1px solid #dee2e6; text-align:center;'>☐</td></tr>
        <tr style='background:#f8f9fa;'><td style='padding:10px 15px; border:1px solid #dee2e6;'>5.</td><td style='padding:10px 15px; border:1px solid #dee2e6;'>PAN Card (No: <b>" . ($teacher->pan_num ?: '____________________') . "</b>)</td><td style='padding:10px 15px; border:1px solid #dee2e6; text-align:center;'>☐</td></tr>
    </table>

    <p>I assure you that I will discharge my duties with the utmost sincerity, dedication, and professional integrity to contribute to the academic excellence of the institution.</p>

    <p>Kindly accept this report and mark my presence in the school records.</p>

    <p style='margin-top:35px;'>Yours faithfully,</p>
    <br><br>
    
    <!-- Employee Details Card -->
    <div style='background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px; padding:20px; margin:10px 0;'>
        <table style='width:100%; font-size:14px;'>
            <tr><td style='padding:5px 0; width:40%; color:#666;'>Signature</td><td style='padding:5px 0;'>__________________________</td></tr>
            <tr><td style='padding:5px 0; color:#666;'>Full Name</td><td style='padding:5px 0;'><b>{$teacher->name}</b></td></tr>
            <tr><td style='padding:5px 0; color:#666;'>Employee ID</td><td style='padding:5px 0;'><b>{$teacher->teacher_number}</b></td></tr>
            <tr><td style='padding:5px 0; color:#666;'>Contact No</td><td style='padding:5px 0;'><b>{$teacher->phone}</b></td></tr>
            <tr><td style='padding:5px 0; color:#666;'>Department</td><td style='padding:5px 0;'><b>{$dept_name}</b></td></tr>
            <tr><td style='padding:5px 0; color:#666;'>Designation</td><td style='padding:5px 0;'><b>{$designation_name}</b></td></tr>
        </table>
    </div>

    <!-- Office Use Only -->
    <div style='margin-top:35px; border:2px solid #1a1a2e; border-radius:8px; overflow:hidden;'>
        <div style='background:#1a1a2e; color:#fff; padding:10px 18px; font-weight:600; font-size:13px; letter-spacing:1px;'>
            FOR OFFICE USE ONLY
        </div>
        <div style='padding:20px;'>
            <table style='width:100%; font-size:14px;'>
                <tr><td style='padding:8px 0; color:#666; width:35%;'>Date of Reporting</td><td style='padding:8px 0;'><b>{$joining_date}</b></td></tr>
                <tr><td style='padding:8px 0; color:#666;'>Time of Reporting</td><td style='padding:8px 0;'>_________________ (FN / AN)</td></tr>
                <tr><td style='padding:8px 0; color:#666;'>Documents Verified</td><td style='padding:8px 0;'>☐ Yes &nbsp;&nbsp; ☐ No &nbsp;&nbsp; ☐ Pending</td></tr>
                <tr><td style='padding:8px 0; color:#666;'>Remarks</td><td style='padding:8px 0;'>_________________________________________</td></tr>
            </table>
            <br>
            <table style='width:100%;'>
                <tr>
                    <td style='width:50%; padding:10px 0; vertical-align:bottom;'>
                        <img src='" . base_url('uploads/signature.png') . "?v=" . time() . "' style='height: 40px; margin-bottom: 5px;' onerror='this.style.display=\"none\"'>
                        <div style='border-top:1px dashed #999; max-width:220px; padding-top:8px;'>
                            <b>Principal's Signature & Seal</b>
                        </div>
                    </td>
                    <td style='width:50%; padding:10px 0; text-align:right; vertical-align:bottom;'>
                        <br><br>
                        <div style='border-top:1px dashed #999; max-width:220px; padding-top:8px; margin-left:auto;'>
                            <b>HOD / HR Signature</b>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Key Rules -->
    <div style='margin-top:25px; padding:15px 18px; background:#fff8e1; border-left:4px solid #f59e0b; border-radius:4px; font-size:12px;'>
        <b style='color:#1a1a2e;'>⚡ Key Rules for Indian School Joining Reports:</b>
        <ul style='color:#555; margin:8px 0 0 0; padding-left:18px; line-height:1.9;'>
            <li><b>Session:</b> Specify FN or AN. Joining in FN ensures full day's pay.</li>
            <li><b>Service Rules:</b> Employee is legally bound to school's Service Rules incl. RTE Act.</li>
            <li><b>Originals:</b> School may verify originals but only retains photocopies.</li>
        </ul>
    </div>
    ";

} elseif ($letter_type == 'welcome') {
    $title = "WELCOME LETTER";
    $content = "
    <p>Dear <b>{$teacher->name}</b>,</p>
    <p>Welcome to <b>{$system_name}</b>! We are thrilled to have you join our team as a <b>{$designation_name}</b> in the <b>{$dept_name}</b> department.</p>
    <p>We believe that your skills and experience will be a great asset to our institution. We are excited about the fresh ideas and energy you will bring.</p>
    <p>Please feel free to reach out to the HR department if you need any assistance getting settled.</p>
    ";

} elseif ($letter_type == 'hike') {
    $title = "SALARY REVISION LETTER";
    $content = "
    <p>Dear <b>{$teacher->name}</b>,</p>
    <p>In recognition of your performance and continuous contribution to <b>{$system_name}</b>, we are pleased to inform you of a revision in your compensation.</p>
    <p>Your revised salary structure has been updated in the payroll system and will be effective starting this month.</p>
    <p>We appreciate your dedication and encourage you to keep up the excellent work.</p>
    ";

} elseif ($letter_type == 'relieving') {
    $title = "RELIEVING & EXPERIENCE LETTER";
    $content = "
    <p>To Whom It May Concern,</p>
    <p>This is to certify that <b>{$teacher->name}</b> was employed with <b>{$system_name}</b> as a <b>{$designation_name}</b> in the <b>{$dept_name}</b> department.</p>
    <p>We confirm that their date of joining was <b>{$joining_date}</b>. They have successfully resolved all their responsibilities and dues, and are officially relieved from their duties as of today, <b>{$date}</b>.</p>
    <p>During their tenure, we found them to be highly professional and committed. We wish them all the best in their future endeavors.</p>
    ";
}
?>

<!-- ==================== PROFESSIONAL LETTER TEMPLATE ==================== -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default" style="border: none; box-shadow: 0 2px 20px rgba(0,0,0,0.08);">
            <div class="panel-body" id="printable_hr_letter" style="padding: 0; background: white; margin: 0 auto; font-family: 'Inter', sans-serif;">
                
                <!-- ===== LETTERHEAD ===== -->
                <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 30px 50px; color: #fff;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 70%;">
                                <h1 style="margin: 0; font-weight: 800; font-size: 22px; letter-spacing: 1px; color: #fff;"><?php echo strtoupper($system_name); ?></h1>
                                <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.7); font-size: 12px; line-height: 1.6;">
                                    <?php echo $system_address; ?><br>
                                    ✉ <?php echo $system_email; ?> &nbsp;|&nbsp; ☎ <?php echo $system_phone; ?>
                                </p>
                            </td>
                            <td style="width: 30%; text-align: right; vertical-align: middle;">
                                <img src="<?php echo base_url();?>uploads/logo.png" alt="Logo" style="max-height: 60px; filter: brightness(0) invert(1); opacity: 0.9;">
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- ===== META BAR ===== -->
                <div style="background: #f8f9fa; border-bottom: 1px solid #e5e7eb; padding: 12px 50px; display: flex; justify-content: space-between;">
                    <table style="width: 100%; font-size: 12px; color: #666;">
                        <tr>
                            <td><b style="color: #1a1a2e;">Date:</b> <?php echo $date; ?></td>
                            <td style="text-align: center;"><b style="color: #1a1a2e;">Employee ID:</b> <?php echo $teacher->teacher_number; ?></td>
                            <td style="text-align: right;"><b style="color: #1a1a2e;">Ref:</b> <?php echo $ref_no; ?></td>
                        </tr>
                    </table>
                </div>

                <!-- ===== TITLE ===== -->
                <div style="padding: 25px 50px 0 50px; text-align: center;">
                    <h2 style="margin: 0; font-weight: 700; color: #1a1a2e; font-size: 20px; letter-spacing: 2px; text-transform: uppercase;">
                        <?php echo $title; ?>
                    </h2>
                    <div style="width: 60px; height: 3px; background: linear-gradient(90deg, #2563eb, #7c3aed); margin: 10px auto 0 auto; border-radius: 2px;"></div>
                </div>

                <!-- ===== BODY ===== -->
                <div style="padding: 30px 50px 40px 50px; font-size: 14px; line-height: 1.8; color: #333;">
                    <?php echo $content; ?>
                </div>

                <!-- ===== ACCEPTANCE (for offer/joining) ===== -->
                <?php if($letter_type == 'joining'): ?>
                <div style="margin: 0 50px 30px 50px; padding: 18px 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;">
                    <p style="margin: 0; font-size: 13px; color: #166534;"><b>✓ Acceptance:</b> Please sign the duplicate copy of this letter as a token of your acceptance of the above terms and conditions.</p>
                </div>
                <?php endif; ?>

                <!-- ===== SIGNATORY ===== -->
                <div style="padding: 0 50px 40px 50px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; vertical-align: bottom;">
                                <p style="margin: 0 0 5px 0; font-size: 13px; color: #666;">For <b style="color: #1a1a2e;"><?php echo $system_name; ?></b></p>
                                <img src="<?php echo base_url('uploads/signature.png'); ?>?v=<?php echo time(); ?>" style="height: 45px; display: block; margin: 10px 0; -webkit-print-color-adjust: exact !important;" onerror="this.style.display='none'">
                                <div style="border-top: 1px solid #ccc; max-width: 220px; padding-top: 8px;">
                                    <b style="color: #1a1a2e; font-size: 13px;">Authorized Signatory</b><br>
                                    <span style="font-size: 12px; color: #888;">Director / Principal</span>
                                </div>
                            </td>
                            <?php if($letter_type != 'relieving' && $letter_type != 'joining_report'): ?>
                            <td style="width: 50%; text-align: right; vertical-align: bottom;">
                                <p style="margin: 0 0 5px 0; font-size: 13px; color: #666;">Accepted & Agreed,</p>
                                <br><br><br>
                                <div style="border-top: 1px solid #ccc; max-width: 220px; padding-top: 8px; margin-left: auto;">
                                    <b style="color: #1a1a2e; font-size: 13px;"><?php echo $teacher->name; ?></b><br>
                                    <span style="font-size: 12px; color: #888;">ID: <?php echo $teacher->teacher_number; ?></span>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                    </table>
                </div>

                <!-- ===== FOOTER ===== -->
                <div style="background: #f8f9fa; border-top: 1px solid #e5e7eb; padding: 20px 50px; text-align: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?php echo urlencode("Verify: " . $system_name . " / " . $title . " / " . $teacher->teacher_number); ?>" alt="QR" style="max-height: 50px; opacity: 0.5;">
                    <p style="font-size: 10px; color: #bbb; margin: 8px 0 0 0; letter-spacing: 0.5px;">This document is electronically generated by <?php echo $system_name; ?> HR System. Verify via QR code.</p>
                </div>

            </div>
        </div>
        
        <div class="text-right m-t-20">
            <button class="btn btn-primary btn-rounded" onclick="PrintLetter('#printable_hr_letter')"><i class="fa fa-print"></i> Print Official Letter</button>
        </div>

    </div>
</div>

<script type="text/javascript">
    function PrintLetter(elem) {
        var mywindow = window.open('', 'PRINT', 'height=900,width=900');
        
        mywindow.document.write('<html><head><title><?php echo $title; ?> - <?php echo $teacher->name; ?></title>');
        mywindow.document.write('<style>');
        mywindow.document.write('@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap");');
        mywindow.document.write('body { font-family: "Inter", sans-serif; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; background: #fff; margin: 0; padding: 0; }');
        mywindow.document.write('table { width: 100%; border-collapse: collapse; }');
        mywindow.document.write('h1, h2, h3, h4, p { margin-top: 0; }');
        mywindow.document.write('ul, ol { padding-left: 20px; }');
        mywindow.document.write('@page { margin: 10mm; }');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(document.querySelector(elem).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close();
        mywindow.focus();

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 800);

        return true;
    }
</script>
