<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print ID Cards</title>
    <!-- We load Roboto from Google Fonts to match the clean professional sans-serif -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        /* CR80 PVC Standard Settings */
        @page {
            size: 85.6mm 54mm landscape;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        
        .id-card-wrapper {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            overflow: hidden;
            background: #ffffff;
            page-break-after: always;
        }

        /* Front Card Elements */
        .header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 18mm;
            /* Default Blue, changed via inline styles based on type */
            background: #1e3a8a; 
            z-index: 1;
        }
        
        .header-curve {
            position: absolute;
            top: 15mm;
            left: -10mm;
            width: 120%;
            height: 15mm;
            background: #ffffff;
            border-top: 3px solid #eab308; /* Gold Accent */
            border-top-left-radius: 50% 100%;
            border-top-right-radius: 50% 100%;
            z-index: 2;
        }

        .school-logo {
            position: absolute;
            top: 2mm;
            left: 4mm;
            width: 14mm;
            height: 14mm;
            z-index: 3;
            object-fit: contain;
            background: #fff;
            border-radius: 50%;
            padding: 1px;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 35mm;
            opacity: 0.08;
            z-index: 0;
            user-select: none;
        }

        .school-title {
            position: absolute;
            top: 3mm;
            left: 20mm;
            right: 2mm;
            color: #ffffff;
            text-align: center;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.5px;
            z-index: 3;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .card-body {
            position: absolute;
            top: 18mm;
            left: 0;
            width: 100%;
            height: 36mm;
            z-index: 3;
        }

        .student-name {
            position: absolute;
            top: 2mm;
            left: 4mm;
            font-weight: 900;
            font-size: 11.5px;
            color: #1e3a8a; /* Theme variable */
            text-transform: uppercase;
            letter-spacing: 0.2px;
            width: 45mm;
        }

        .details-grid {
            position: absolute;
            top: 7mm;
            left: 4mm;
            font-size: 8px;
            color: #1e293b;
        }

        .details-grid table {
            border-collapse: collapse;
        }
        .details-grid td {
            padding: 1.5px 0;
            vertical-align: top;
            font-weight: 500;
        }
        .details-grid td.label-col {
            width: 15mm;
            font-weight: 700;
            color: #334155;
        }

        .photo-container {
            position: absolute;
            top: -2mm;
            right: 12mm;
            width: 20mm;
            height: 23mm;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            z-index: 4;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .role-tag {
            position: absolute;
            top: -2mm;
            right: 4mm;
            height: 23mm;
            width: 6mm;
            z-index: 4;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .role-tag-text {
            transform: rotate(-90deg);
            white-space: nowrap;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #64748b;
        }

        .signature-block {
            position: absolute;
            top: 22mm;
            right: 12mm;
            width: 20mm;
            text-align: center;
        }
        .signature-img {
            max-height: 5mm;
            margin-bottom: 0px;
        }
        .signature-title {
            font-size: 6px;
            font-weight: 700;
            color: #000;
            border-top: 0.5px solid #000;
            padding-top: 1px;
        }

        .bottom-strip {
            position: absolute;
            bottom: 2mm;
            right: 0;
            width: 65mm;
            height: 2mm;
            background: #dc2626; /* Red stripe */
            text-align: center;
            color: #fff;
            font-size: 5.5px;
            font-weight: 700;
            line-height: 2mm;
        }
        .bottom-url {
            position: absolute;
            bottom: 4mm;
            right: 4mm;
            font-size: 7px;
            font-weight: 700;
            color: #dc2626;
        }

        /* Back Side Variables */
        .back-rules {
            font-size: 7.5px;
            line-height: 1.4;
            padding: 8mm 6mm;
            color: #1e293b;
            width: 60mm;
            font-weight: 500;
        }
        .back-rules ul {
            padding-left: 3mm;
            margin-top: 2mm;
        }
        .qr-block {
            position: absolute;
            top: 8mm;
            right: 4mm;
            width: 18mm;
            text-align: center;
        }
        .qr-block img {
            width: 18mm;
            height: 18mm;
            margin-bottom: 2mm;
        }
        .return-policy {
            position: absolute;
            bottom: 6mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 7px;
            font-weight: 700;
            color: #dc2626;
        }
    </style>
</head>
<body onload="window.print()">

<?php 
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$school_logo = base_url('uploads/logo.png');

foreach($users as $user): 
    
    // Fallback Image handling
    if ($type == 'student') {
        $img_src = $this->crud_model->get_image_url('student', $user['student_id']);
        $name = $user['name'];
        
        $role_lbl = "Parent";
        $role_val = $this->db->get_where('parent', array('parent_id' => $user['parent_id']))->row()->name;
        
        $sub_lbl = "Class";
        $class_n = $this->db->get_where('class', array('class_id' => $user['class_id']))->row()->name;
        $sec_n   = $this->db->get_where('section', array('section_id' => $user['section_id']))->row()->name;
        $sub_val = $class_n . ' (' . $sec_n . ')';
        
        $id_lbl = "Roll No";
        $id_val = $user['roll'] ? $user['roll'] : 'SCH'.rand(1000,9999);
        
        $aux_lbl = "D.O.B";
        $aux_val = $user['birthday'];
        
        $theme_hex = '#1e3a8a'; /* Blue */
        $role_vertical = 'STUDENT';
        
        $qr_link = base_url() . 'student/profile/' . $user['student_id'];
        
    } elseif ($type == 'teacher') {
        $img_src = $this->crud_model->get_image_url('teacher', $user['teacher_id']);
        $name = $user['name'];
        
        $role_lbl = "Role";
        $role_val = "Senior Faculty";
        
        $sub_lbl = "Dept";
        $dept = $this->db->get_where('department', array('department_id' => $user['department_id']))->row();
        $sub_val = $dept ? $dept->name : 'Academics';
        
        $id_lbl = "Emp ID";
        $id_val = $user['teacher_number'];
        
        $aux_lbl = "D.O.B";
        $aux_val = $user['birthday'];
        
        $theme_hex = '#166534'; /* Green */
        $role_vertical = 'TEACHER';
        
        $qr_link = base_url() . 'teacher/profile/' . $user['teacher_id'];
        
    } else { // Staff
        $img_src = base_url('uploads/staff_image/' . $user['staff_id'] . '.jpg');
        $name = $user['name'];
        
        $role_lbl = "Role";
        $staff_roles = array(10=>'Driver', 11=>'Watchman', 12=>'Peon', 13=>'Caretaker', 14=>'Cook', 16=>'Clerk');
        $role_val = isset($staff_roles[$user['role']]) ? $staff_roles[$user['role']] : 'Staff Member';
        
        $sub_lbl = "Dept";
        $dept = $this->db->get_where('department', array('department_id' => $user['department_id']))->row();
        $sub_val = $dept ? $dept->name : 'Administration';
        
        $id_lbl = "Emp ID";
        $id_val = $user['staff_number'];
        
        $aux_lbl = "Blood";
        $aux_val = $user['blood_group'];
        
        $theme_hex = '#c2410c'; /* Orange */
        $role_vertical = 'STAFF';
        
        $qr_link = base_url() . 'staff/profile/' . $user['staff_id'];
    }

    // Default image check. get_image_url handles most, but for staff we must ensure fallback
    if($type == 'staff') {
        if(!file_exists('uploads/staff_image/' . $user['staff_id'] . '.jpg')){
            $img_src = base_url('uploads/default.jpg');
        }
    }
?>

    <!-- ============================================== -->
    <!-- FRONT OF ID CARD -->
    <!-- ============================================== -->
    <div class="id-card-wrapper">
        <img src="<?php echo $school_logo; ?>" class="watermark" alt="watermark">
        
        <div class="header-bg" style="background: <?php echo $theme_hex; ?>;"></div>
        <div class="header-curve"></div>
        
        <img src="<?php echo $school_logo; ?>" class="school-logo">
        <div class="school-title"><?php echo $system_name; ?></div>
        
        <div class="card-body">
            <div class="student-name" style="color: <?php echo $theme_hex; ?>;">
                <?php echo $name; ?>
            </div>
            
            <div class="details-grid">
                <table>
                    <tr><td class="label-col"><?php echo $role_lbl; ?></td><td>: <?php echo $role_val; ?></td></tr>
                    <tr><td class="label-col"><?php echo $sub_lbl; ?></td><td>: <?php echo $sub_val; ?></td></tr>
                    <tr><td class="label-col"><?php echo $id_lbl; ?></td><td>: <?php echo $id_val; ?></td></tr>
                    <tr><td class="label-col">Session</td><td>: <?php echo $session_validity; ?></td></tr>
                    <tr><td class="label-col"><?php echo $aux_lbl; ?></td><td>: <?php echo $aux_val; ?></td></tr>
                </table>
            </div>
            
            <div class="photo-container">
                <img src="<?php echo $img_src; ?>" alt="Photo">
            </div>
            <div class="role-tag">
                <div class="role-tag-text" style="color: <?php echo $theme_hex; ?>; opacity: 0.8;"><?php echo $role_vertical; ?></div>
            </div>

            <div class="signature-block">
                <!-- Replace with actual signature image -->
                <img src="<?php echo base_url('uploads/signature.png'); ?>" class="signature-img" onerror="this.style.display='none'">
                <div class="signature-title">Principal Signature</div>
            </div>

            <div class="bottom-url">www.chaturvedasoftware.in</div>
            <div class="bottom-strip">SMART SCHOOL SYSTEM</div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- BACK OF ID CARD -->
    <!-- ============================================== -->
    <div class="id-card-wrapper">
        <div class="header-bg" style="height: 6mm; background: <?php echo $theme_hex; ?>; border-bottom: 2px solid #eab308;"></div>
        
        <div class="back-rules">
            <strong>Rules & Regulations:</strong>
            <ul>
                <li>This card is property of <?php echo $system_name; ?>.</li>
                <li>It must be worn visible at all times within premises.</li>
                <li>Report loss of the card immediately to admin.</li>
                <li>Transfer of card to another person is punishable.</li>
            </ul>
        </div>
        
        <div class="qr-block">
            <!-- Dynamic QR Code (No heavy local lib needed, uses secure standard API) -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode($qr_link); ?>" alt="QR Code">
        </div>

        <div class="return-policy">
            If found, please return to: <?php echo $system_name; ?> Office
        </div>
    </div>

<?php endforeach; ?>

</body>
</html>
