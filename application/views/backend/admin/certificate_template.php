<?php
// Fetch data
$student = $this->db->get_where('student', array('student_id' => $student_id))->row_array();
$class = $this->db->get_where('class', array('class_id' => $student['class_id']))->row();
$class_name = $class ? $class->name : 'N/A';
$parent = $this->db->get_where('parent', array('parent_id' => $student['parent_id']))->row();
$parent_name = $parent ? $parent->name : 'N/A';
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$system_address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;

// Auto-calc session
$cm = (int)date('n'); $cy = (int)date('Y');
$session = ($cm >= 6) ? $cy.'-'.($cy+1) : ($cy-1).'-'.$cy;
$today = date('d F Y');
$serial = strtoupper(substr(md5($student_id . $cert_type . time()), 0, 10));

// Certificate titles
$titles = array(
    'transfer'    => 'TRANSFER CERTIFICATE',
    'bonafide'    => 'BONAFIDE CERTIFICATE',
    'achievement' => 'ACHIEVEMENT CERTIFICATE',
    'study'       => 'STUDY CERTIFICATE',
    'character'   => 'CHARACTER CERTIFICATE',
    'migration'   => 'MIGRATION CERTIFICATE'
);
$cert_title = isset($titles[$cert_type]) ? $titles[$cert_type] : 'CERTIFICATE';

// Accent colors per type
$colors = array(
    'transfer'    => '#1a237e',
    'bonafide'    => '#004d40',
    'achievement' => '#e65100',
    'study'       => '#1b5e20',
    'character'   => '#4a148c',
    'migration'   => '#b71c1c'
);
$accent = isset($colors[$cert_type]) ? $colors[$cert_type] : '#1a237e';
?>

<div style="
    width: 800px;
    margin: 0 auto;
    padding: 40px;
    border: 8px double <?php echo $accent; ?>;
    background: #fffef5;
    font-family: 'Georgia', 'Times New Roman', serif;
    color: #222;
    position: relative;
    box-sizing: border-box;
">
    <!-- Corner accents -->
    <div style="position:absolute;top:15px;left:15px;width:40px;height:40px;border-top:3px solid <?php echo $accent; ?>;border-left:3px solid <?php echo $accent; ?>;"></div>
    <div style="position:absolute;top:15px;right:15px;width:40px;height:40px;border-top:3px solid <?php echo $accent; ?>;border-right:3px solid <?php echo $accent; ?>;"></div>
    <div style="position:absolute;bottom:15px;left:15px;width:40px;height:40px;border-bottom:3px solid <?php echo $accent; ?>;border-left:3px solid <?php echo $accent; ?>;"></div>
    <div style="position:absolute;bottom:15px;right:15px;width:40px;height:40px;border-bottom:3px solid <?php echo $accent; ?>;border-right:3px solid <?php echo $accent; ?>;"></div>

    <!-- Header -->
    <div style="text-align: center; margin-bottom: 25px;">
        <div style="display: inline-block; vertical-align: middle; margin-right: 15px;">
            <img src="<?php echo base_url(); ?>uploads/logo.png" style="height: 70px; width: auto;" onerror="this.style.display='none'">
        </div>
        <div style="display: inline-block; vertical-align: middle; text-align: center;">
            <h1 style="margin: 0; font-size: 28px; color: <?php echo $accent; ?>; letter-spacing: 2px; font-weight: bold;"><?php echo strtoupper($system_name); ?></h1>
            <p style="margin: 3px 0; font-size: 13px; color: #555;"><?php echo $system_address; ?></p>
        </div>
    </div>

    <!-- Serial -->
    <div style="display: flex; justify-content: space-between; font-size: 12px; color: #888; margin-bottom: 15px;">
        <span>Serial No: <strong><?php echo $serial; ?></strong></span>
        <span>Academic Session: <strong><?php echo $session; ?></strong></span>
    </div>

    <!-- Title -->
    <div style="text-align: center; margin: 20px 0;">
        <h2 style="
            margin: 0;
            font-size: 26px;
            color: <?php echo $accent; ?>;
            letter-spacing: 4px;
            border-bottom: 2px solid <?php echo $accent; ?>;
            border-top: 2px solid <?php echo $accent; ?>;
            display: inline-block;
            padding: 8px 30px;
        "><?php echo $cert_title; ?></h2>
    </div>

    <!-- Body -->
    <div style="font-size: 16px; line-height: 2.2; margin: 30px 20px; text-align: justify;">

    <?php if ($cert_type == 'transfer'): ?>
        <p>This is to certify that <strong style="color:<?php echo $accent; ?>;"><?php echo $student['name']; ?></strong>,
        Son/Daughter of <strong><?php echo $parent_name; ?></strong>,
        was a bonafide student of this institution. The details are as follows:</p>

        <table style="width:100%; border-collapse:collapse; margin: 15px 0; font-size: 14px;">
            <tr><td style="padding:8px; border:1px solid #ccc; width:40%; background:#f9f9f9;"><strong>Admission No</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo !empty($student['admission_no']) ? $student['admission_no'] : $student['roll']; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Class</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo $class_name; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Date of Birth</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo $student['birthday']; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Date of Admission</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo $student['am_date']; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Date of Leaving</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo !empty($student['date_of_leaving']) ? $student['date_of_leaving'] : $today; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Reason for Leaving</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo !empty($student['ps_purpose']) ? $student['ps_purpose'] : 'On parent\'s request'; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Character & Conduct</strong></td><td style="padding:8px; border:1px solid #ccc;">Good</td></tr>
        </table>
        <p>He/She is hereby granted this Transfer Certificate for the purpose of further studies.</p>

    <?php elseif ($cert_type == 'bonafide'): ?>
        <p>This is to certify that <strong style="color:<?php echo $accent; ?>;"><?php echo $student['name']; ?></strong>,
        Son/Daughter of <strong><?php echo $parent_name; ?></strong>,
        bearing Roll Number <strong><?php echo $student['roll']; ?></strong>,
        is a bonafide student of Class <strong><?php echo $class_name; ?></strong>
        of this institution for the Academic Session <strong><?php echo $session; ?></strong>.</p>

        <p>Date of Birth as per school records: <strong><?php echo $student['birthday']; ?></strong>.</p>
        <p>Address: <strong><?php echo $student['address']; ?>, <?php echo $student['city']; ?>, <?php echo $student['state']; ?></strong>.</p>

        <p>This certificate is issued on request for official purposes.</p>

    <?php elseif ($cert_type == 'achievement'): ?>
        <p style="text-align: center; font-size: 18px; margin-top: 10px;">This certificate is proudly presented to</p>
        <p style="text-align: center; font-size: 32px; color: <?php echo $accent; ?>; font-weight: bold; margin: 15px 0; font-style: italic;">
            <?php echo $student['name']; ?>
        </p>
        <p style="text-align: center; font-size: 16px;">Student of Class <strong><?php echo $class_name; ?></strong></p>
        <p style="text-align: center; font-size: 16px; margin-top: 20px;">
            In recognition of outstanding performance and exemplary dedication<br>
            during the Academic Session <strong><?php echo $session; ?></strong>.
        </p>
        <p style="text-align: center; font-size: 14px; color: #666; margin-top: 20px; font-style: italic;">
            "Excellence is not a destination but a continuous journey."
        </p>

    <?php elseif ($cert_type == 'study'): ?>
        <p>This is to certify that <strong style="color:<?php echo $accent; ?>;"><?php echo $student['name']; ?></strong>,
        Son/Daughter of <strong><?php echo $parent_name; ?></strong>,
        has been studying in Class <strong><?php echo $class_name; ?></strong>
        of this institution since <strong><?php echo !empty($student['am_date']) ? $student['am_date'] : 'date of admission'; ?></strong>.</p>

        <p>Roll Number: <strong><?php echo $student['roll']; ?></strong></p>
        <p>Date of Birth: <strong><?php echo $student['birthday']; ?></strong></p>
        <p>Nationality: <strong><?php echo !empty($student['nationality']) ? $student['nationality'] : 'Indian'; ?></strong></p>

        <p>This certificate is issued upon request for academic verification purposes.</p>

    <?php elseif ($cert_type == 'character'): ?>
        <p>This is to certify that <strong style="color:<?php echo $accent; ?>;"><?php echo $student['name']; ?></strong>,
        Son/Daughter of <strong><?php echo $parent_name; ?></strong>,
        is/was a student of Class <strong><?php echo $class_name; ?></strong>
        in this institution during the Academic Session <strong><?php echo $session; ?></strong>.</p>

        <p>During the period of study, he/she has maintained <strong>Good Moral Character and Conduct</strong>.
        He/She has been found to be disciplined, well-behaved, and sincere in studies.</p>

        <p>To the best of our knowledge, he/she bears no adverse record whatsoever.</p>

        <p>This certificate is issued at his/her request for the purpose it may serve.</p>

    <?php elseif ($cert_type == 'migration'): ?>
        <p>This is to certify that <strong style="color:<?php echo $accent; ?>;"><?php echo $student['name']; ?></strong>,
        Son/Daughter of <strong><?php echo $parent_name; ?></strong>,
        formerly a student of Class <strong><?php echo $class_name; ?></strong>
        of this institution, is hereby granted this Migration Certificate.</p>

        <table style="width:100%; border-collapse:collapse; margin: 15px 0; font-size: 14px;">
            <tr><td style="padding:8px; border:1px solid #ccc; width:40%; background:#f9f9f9;"><strong>Roll No</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo $student['roll']; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Date of Birth</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo $student['birthday']; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Previous School</strong></td><td style="padding:8px; border:1px solid #ccc;"><?php echo !empty($student['ps_attended']) ? $student['ps_attended'] : 'N/A'; ?></td></tr>
            <tr><td style="padding:8px; border:1px solid #ccc; background:#f9f9f9;"><strong>Migration To</strong></td><td style="padding:8px; border:1px solid #ccc;">__________________________</td></tr>
        </table>

        <p>He/She is permitted to seek admission in any other recognized institution.
        No dues are pending against the student.</p>
    <?php endif; ?>

    </div>

    <!-- Footer Signatures -->
    <div style="display: flex; justify-content: space-between; margin-top: 60px; padding: 0 20px;">
        <div style="text-align: center;">
            <div style="border-top: 1px solid #555; width: 180px; margin: 0 auto; padding-top: 5px;">
                <strong>Date</strong><br>
                <span style="font-size: 13px;"><?php echo $today; ?></span>
            </div>
        </div>
        <div style="text-align: center;">
            <div style="border-top: 1px solid #555; width: 180px; margin: 0 auto; padding-top: 5px;">
                <strong>Class Teacher</strong>
            </div>
        </div>
        <div style="text-align: center; position: relative;">
            <img src="<?php echo base_url('uploads/signature.png'); ?>?v=<?php echo time(); ?>" style="height: 40px; position: absolute; bottom: 25px; left: 50%; transform: translateX(-50%); -webkit-print-color-adjust: exact !important;" onerror="this.style.display='none'">
            <div style="border-top: 1px solid #555; width: 180px; margin: 0 auto; padding-top: 5px; position: relative; z-index: 1;">
                <strong>Principal</strong>
            </div>
        </div>
    </div>

    <!-- Seal placeholder -->
    <div style="text-align: center; margin-top: 30px; color: #ccc; font-size: 11px;">
        <div style="border: 2px dashed #ddd; border-radius: 50%; width: 80px; height: 80px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
            <span style="font-size: 10px; color: #bbb;">SEAL</span>
        </div>
    </div>
</div>
