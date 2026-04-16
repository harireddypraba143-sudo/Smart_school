<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card - <?php echo $student['name']; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body, html {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: 'Inter', sans-serif;
            color: #334155;
        }

        .ms-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .ms-a4-container {
            border: 2px solid #1e3a5f;
            border-radius: 8px;
            padding: 20px;
            margin: 0 auto;
            background: #fff;
            position: relative;
        }

        /* Student Profile Header */
        .ms-header-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .ms-school-logo { width: 80px; height: 80px; }
        .ms-school-info { flex-grow: 1; padding-left: 20px; }
        .ms-school-name { font-size: 24px; font-weight: 800; color: #1e3a5f; text-transform: uppercase; margin-bottom: 4px; }
        .ms-school-addr { font-size: 11px; color: #475569; font-weight: 500; }
        .ms-school-contact { font-size: 11px; color: #475569; font-weight: 600; margin-top: 4px; }
        
        .ms-acad-year-box {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 16px;
            text-align: center;
        }
        .ms-acad-year-box .lbl { font-size: 9px; font-weight: 700; color: #1e3a5f; text-transform: uppercase; margin-bottom: 4px; }
        .ms-acad-year-box .val { font-size: 13px; font-weight: 800; color: #1e293b; }

        .ms-divider {
            position: relative;
            text-align: center;
            margin: 15px 0 25px 0;
        }
        .ms-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #cbd5e1;
            z-index: 1;
        }
        .ms-divider-text {
            display: inline-block;
            background: #1e3a5f;
            color: #fff;
            padding: 6px 30px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 1px;
            position: relative;
            z-index: 2;
        }

        .ms-profile { 
            display: flex; align-items: flex-start; justify-content: flex-start; 
            margin-bottom: 25px; 
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        .ms-profile-photo { width: 110px; height: 110px; border-radius: 6px; border: 2px solid #e2e8f0; object-fit: cover; background: #e2e8f0; margin-right: 30px; }
        
        .ms-student-details {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
        }
        .ms-details-col {
            display: grid;
            grid-template-columns: auto auto auto;
            gap: 8px 15px;
            font-size: 12px;
        }
        .ms-details-col .plabel { font-weight: 700; color: #1e3a5f; }
        .ms-details-col .psep { font-weight: 700; color: #1e3a5f; }
        .ms-details-col .pval { font-weight: 500; color: #334155; }

        /* Scholastic Table */
        .ms-section-title { 
            background: linear-gradient(135deg, #1e3a5f, #1e293b); color: #fff; 
            text-align: center; padding: 10px; border-radius: 8px 8px 0 0; 
            font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin: 0; 
            -webkit-print-color-adjust: exact !important;
        }
        .ms-marks-table { width: 100%; border-collapse: collapse; font-size: 13px; border: 1px solid #cbd5e1; page-break-inside: avoid; }
        .ms-marks-table thead th { 
            background: #f1f5f9; color: #334155; font-weight: 700; 
            padding: 10px 8px; border: 1px solid #cbd5e1; text-align: center; 
            font-size: 11.5px; text-transform: uppercase; 
            -webkit-print-color-adjust: exact !important;
        }
        .ms-marks-table thead th.th-sub { text-align: left; min-width: 120px; }
        .ms-marks-table tbody td { padding: 10px 8px; border: 1px solid #e2e8f0; text-align: center; color: #334155; font-weight: 500; }
        .ms-marks-table tbody td:first-child { text-align: left; font-weight: 600; }
        .ms-marks-table tbody tr:nth-child(even) td { background: #f8fafc; -webkit-print-color-adjust: exact !important; }
        .ms-marks-table tfoot td { 
            background: #f1f5f9; font-weight: 700; padding: 10px 8px; border: 1px solid #cbd5e1; 
            text-align: center; color: #1e293b; 
            -webkit-print-color-adjust: exact !important;
        }
        .ms-marks-table tfoot td:first-child { text-align: left; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }

        /* Grade Badges */
        .ms-grade { display: inline-block; padding: 3px 10px; border-radius: 4px; font-weight: 700; font-size: 12px; color: #fff; min-width: 32px; text-align: center; -webkit-print-color-adjust: exact !important; }
        .ms-grade-A1, .ms-grade-A2 { background: #16a34a !important; }
        .ms-grade-B1, .ms-grade-B2 { background: #2563eb !important; }
        .ms-grade-C1, .ms-grade-C2 { background: #f59e0b !important; color: #1e293b !important; }
        .ms-grade-D { background: #ea580c !important; }
        .ms-grade-E { background: #dc2626 !important; }

        /* Grand Total Bar */
        .ms-grand-bar { 
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; 
            border: 2px solid #1e3a5f; border-radius: 8px; overflow: hidden; margin: 20px 0; 
            page-break-inside: avoid;
        }
        .ms-grand-item { text-align: center; padding: 14px 10px; border-right: 1px solid #cbd5e1; }
        .ms-grand-item:last-child { border-right: none; }
        .ms-grand-item .glab { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .ms-grand-item .gval { font-size: 20px; font-weight: 800; color: #1e293b; }

        /* Bottom Sections */
        .ms-bottom-grid { 
            display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0; 
            border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; margin-bottom: 20px; 
            page-break-inside: avoid;
        }
        .ms-bottom-section { padding: 16px; border-right: 1px solid #cbd5e1; }
        .ms-bottom-section:last-child { border-right: none; }
        .ms-bottom-title { 
            font-size: 11px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; 
            padding: 6px 12px; border-radius: 4px; margin-bottom: 12px; display: inline-block; 
            -webkit-print-color-adjust: exact !important;
        }
        .ms-bt-red { background: #dc2626 !important; }
        .ms-bt-green { background: #16a34a !important; }
        .ms-bt-blue { background: #2563eb !important; }

        .ms-co-table { width: 100%; font-size: 12px; }
        .ms-co-table td { padding: 4px 0; color: #334155; }
        .ms-co-table td:last-child { text-align: right; font-weight: 700; }

        .ms-grade-scale { width: 100%; font-size: 11px; border-collapse: collapse; }
        .ms-grade-scale thead th { background: #f1f5f9; padding: 6px 8px; font-weight: 700; border: 1px solid #e2e8f0; text-align: center; color: #334155; -webkit-print-color-adjust: exact !important; }
        .ms-grade-scale tbody td { padding: 5px 8px; border: 1px solid #e2e8f0; text-align: center; }

        .ms-remark-text { font-size: 12.5px; color: #334155; line-height: 1.7; font-style: italic; }

        /* Signatures */
        .ms-signatures { 
            display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; 
            margin-top: 24px; padding-top: 20px; border-top: 2px solid #e2e8f0; 
            page-break-inside: avoid;
        }
        .ms-sig-block { text-align: center; }
        .ms-sig-line { border-bottom: 1px solid #1e293b; width: 80%; margin: 30px auto 6px; }
        .ms-sig-name { font-size: 13px; font-weight: 700; color: #1e293b; }
        .ms-sig-role { font-size: 11px; color: #64748b; }
        .ms-sig-date { font-size: 10px; color: #94a3b8; margin-top: 2px; }

        /* AUTO STAMP / SEAL - SVG based circular text */
        .ms-stamp-container {
            width: 100px; height: 100px;
            display: inline-block;
        }
        .ms-stamp-svg {
            width: 100px; height: 100px;
            transform: rotate(-10deg);
            opacity: 0.8;
            -webkit-print-color-adjust: exact !important;
        }

        .ms-footer-text { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 12px; font-style: italic; }

        /* Print Override */
        @media print {
            @page { size: A4 portrait; margin: 5mm; }
            body { background: white; margin: 0; padding: 0; -webkit-print-color-adjust: exact !important; }
            .ms-wrapper { width: 100%; max-width: 100%; padding: 0; margin: 0; }
            .btn-print-top { display: none !important; }
            .ms-a4-container { padding: 10px !important; margin: 0 !important; width: 100% !important; box-sizing: border-box; page-break-inside: avoid; border-width: 1px !important; }
            /* Force exact sizing for A4 constraints */
            html { zoom: 0.85; }
        }

        .btn-print-top {
            display: block; width: 250px; margin: 20px auto; padding: 12px;
            background: #1e3a5f; color: #fff; text-align: center; border-radius: 6px;
            text-decoration: none; font-weight: bold; cursor: pointer;
        }
        .btn-print-top:hover { background: #0f1c30; }
    </style>
</head>
<body>

<a href="javascript:void(0)" onclick="window.print()" class="btn-print-top">🖨️ Print Marksheet</a>

<div class="ms-wrapper" id="printable-marksheet">
<div class="ms-a4-container">

    <?php 
        $running_year = $this->db->get_where('settings', array('type' => 'session'))->row()->description;
        $school_name = $this->db->get_where('settings', ['type' => 'system_name'])->row()->description;
        $school_address = $this->db->get_where('settings', ['type' => 'address'])->row();
        $school_phone = $this->db->get_where('settings', ['type' => 'phone'])->row();
        $school_email = $this->db->get_where('settings', ['type' => 'system_email'])->row();
    ?>

    <!-- HEADER: LOGO, SCHOOL NAME, ACADEMIC YEAR -->
    <div class="ms-header-top">
        <img src="<?php echo base_url(); ?>uploads/logo.png" class="ms-school-logo" alt="Logo" onerror="this.style.display='none'">
        <div class="ms-school-info">
            <div class="ms-school-name"><?php echo $school_name; ?></div>
            <div class="ms-school-addr"><?php echo strtoupper($school_address ? $school_address->description : ''); ?></div>
            <div class="ms-school-contact">
                <?php if($school_email && !empty($school_email->description)) echo 'Email: ' . strtolower($school_email->description) . ' | '; ?>
                <?php if($school_phone && !empty($school_phone->description)) echo 'Phone: ' . $school_phone->description; ?>
            </div>
        </div>
        <div class="ms-acad-year-box">
            <div class="lbl">Academic Year</div>
            <div class="val"><?php echo $running_year; ?></div>
        </div>
    </div>

    <!-- MAIN BADGE -->
    <div class="ms-divider">
        <div class="ms-divider-text">MARKSHEET</div>
    </div>

    <!-- STUDENT PROFILE GRID -->
    <div class="ms-profile">
        <img src="<?php echo base_url(); ?>uploads/student_image/<?php echo $student['student_id']; ?>.jpg" class="ms-profile-photo" alt="Photo" onerror="this.src='<?php echo base_url(); ?>uploads/student_image/default.jpg'">
        
        <div class="ms-student-details">
            <div class="ms-details-col">
                <span class="plabel">Student Name</span> <span class="psep">:</span> <span class="pval"><?php echo $student['name']; ?></span>
                <span class="plabel">Roll No.</span> <span class="psep">:</span> <span class="pval"><?php echo $student['roll']; ?></span>
                <span class="plabel">Admission No.</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student['admission_no']) ? $student['admission_no'] : $student['student_id']; ?></span>
                <span class="plabel">Mother's Name</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student['mother_name']) ? $student['mother_name'] : 'N/A'; ?></span>
                <span class="plabel">Father's Name</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student['father_name']) ? $student['father_name'] : 'N/A'; ?></span>
            </div>
            <div class="ms-details-col">
                <span class="plabel">Class & Section</span> <span class="psep">:</span> <span class="pval"><?php echo $class['name'] . (isset($section['name']) ? ' - '.$section['name'] : ''); ?></span>
                <?php 
                    $board = $this->db->get_where('settings', array('type' => 'board'))->row();
                    $board_name = $board ? $board->description : 'State Board';
                ?>
                <span class="plabel">Board</span> <span class="psep">:</span> <span class="pval"><?php echo $board_name; ?></span>
                <span class="plabel">Date of Birth</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student['date_of_birth']) ? date('d M Y', strtotime($student['date_of_birth'])) : $student['birthday']; ?></span>
                <span class="plabel">Examination</span> <span class="psep">:</span> <span class="pval"><?php echo $exam['name']; ?></span>
                <span class="plabel">Exam Date</span> <span class="psep">:</span> <span class="pval"><?php echo date('M Y'); ?></span>
                <span class="plabel">Result Date</span> <span class="psep">:</span> <span class="pval"><?php echo date('d M Y'); ?></span>
            </div>
        </div>
    </div>

    <!-- SCHOLASTIC TABLE -->
    <div class="ms-section-title">Scholastic Areas (Academic)</div>
        <?php
            // Check exam pattern logic
            $is_state_board = false;
            $max_state_marks = 100;
            
            // Check global setting first
            $board_setting = $this->db->get_where('settings', array('type' => 'board'))->row();
            if (!$board_setting || strpos(strtolower($board_setting->description), 'state') !== false) {
                $is_state_board = true;
                $max_state_marks = 100; // Force 100 for display
            } else {
                $is_state_board = false;
            }
        ?>
        <table class="ms-marks-table">
            <thead>
                <?php if ($is_state_board): ?>
                <tr>
                    <th class="th-sub">Subject</th>
                    <th style="background:#fef3c7; color:#92400e;">Marks Obtained<br>(<?php echo $max_state_marks; ?>)</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                </tr>
                <?php else: ?>
                <tr>
                    <th class="th-sub" rowspan="2">Subject</th>
                    <th colspan="3" style="background:#e8f0fe; color:#1e3a5f;">Internal Assessment (20 Marks)</th>
                    <th rowspan="2" style="background:#fef3c7; color:#92400e;">Written Exam<br>(80)</th>
                    <th rowspan="2">Total<br>(100)</th>
                    <th rowspan="2">Grade</th>
                    <th rowspan="2">Remarks</th>
                </tr>
                <tr>
                    <th style="background:#e8f0fe; color:#1e3a5f;">PT / Internal<br>(10)</th>
                    <th style="background:#e8f0fe; color:#1e3a5f;">Note Book / Port.<br>(5)</th>
                    <th style="background:#e8f0fe; color:#1e3a5f;">Enrichment<br>(5)</th>
                </tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php 
                    $grand_total = 0;
                    $grand_max = 0;
                    $subject_count = 0;
                    
                    $student_id = $student['student_id'];
                    $exam_id = $exam['exam_id'];
                    
                    $subjects = $this->db->get_where('subject', ['class_id' => $student['class_id']])->result_array();
                    
                    foreach($subjects as $subj):
                        $sid = $subj['subject_id'];
                        $subject_count++;
                        
                        if ($is_state_board) {
                            $comp_names = ['WRITTEN'];
                            $row_max = $max_state_marks;
                        } else {
                            $comp_names = ['PT', 'NOTEBOOK', 'ENRICHMENT', 'WRITTEN'];
                            $row_max = 100;
                        }
                        
                        $marks = [];
                        $row_total = 0;
                        
                        foreach($comp_names as $ci => $cn) {
                            $q = $this->db->get_where('mark', [
                                'student_id' => $student_id,
                                'subject_id' => $sid,
                                'exam_id' => $exam_id,
                                'component_type' => $cn
                            ]);
                            if ($q->num_rows() > 0) {
                                $marks[$cn] = $q->row()->marks_obtained;
                                $row_total += (float)$marks[$cn];
                            } else {
                                $marks[$cn] = '-';
                            }
                        }
                        
                        $grand_total += $row_total;
                        $grand_max += $row_max;
                        
                        // Grade Logic
                        $pct = ($row_max > 0) ? ($row_total / $row_max) * 100 : 0;
                        if ($pct >= 91) { $grade = 'A1'; $remark = 'Outstanding'; }
                        elseif ($pct >= 81) { $grade = 'A2'; $remark = 'Excellent'; }
                        elseif ($pct >= 71) { $grade = 'B1'; $remark = 'Very Good'; }
                        elseif ($pct >= 61) { $grade = 'B2'; $remark = 'Good'; }
                        elseif ($pct >= 51) { $grade = 'C1'; $remark = 'Satisfactory'; }
                        elseif ($pct >= 41) { $grade = 'C2'; $remark = 'Average'; }
                        elseif ($pct >= 33) { $grade = 'D'; $remark = 'Needs Improvement'; }
                        else { $grade = 'E'; $remark = 'Unsatisfactory'; }
                        
                        if ($row_total == 0 && (!isset($marks['PT']) || $marks['PT'] == '-') && $marks['WRITTEN'] == '-') { $grade = '-'; $remark = '-'; }
                ?>
                <tr>
                    <td><?php echo $subj['name']; ?></td>
                    <?php if ($is_state_board): ?>
                        <td><strong><?php echo $marks['WRITTEN']; ?></strong> <?php if($marks['WRITTEN'] != '-') echo '<span style="color:#94a3b8">/'.$max_state_marks.'</span>'; ?></td>
                    <?php else: ?>
                        <td><?php echo $marks['PT']; ?> <?php if($marks['PT'] != '-') echo '<span style="color:#94a3b8">/10</span>'; ?></td>
                        <td><?php echo $marks['NOTEBOOK']; ?> <?php if($marks['NOTEBOOK'] != '-') echo '<span style="color:#94a3b8">/5</span>'; ?></td>
                        <td><?php echo $marks['ENRICHMENT']; ?> <?php if($marks['ENRICHMENT'] != '-') echo '<span style="color:#94a3b8">/5</span>'; ?></td>
                        <td><?php echo $marks['WRITTEN']; ?> <?php if($marks['WRITTEN'] != '-') echo '<span style="color:#94a3b8">/80</span>'; ?></td>
                        <td><strong><?php echo ($row_total > 0) ? $row_total : '-'; ?></strong> <?php if($row_total > 0) echo '<span style="color:#94a3b8">/100</span>'; ?></td>
                    <?php endif; ?>
                    <td><span class="ms-grade ms-grade-<?php echo $grade; ?>"><?php echo $grade; ?></span></td>
                    <td style="font-size:11.5px; color:#64748b;"><?php echo $remark; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <?php
                $overall_pct = ($grand_max > 0) ? ($grand_total / $grand_max) * 100 : 0;
                if ($overall_pct >= 91) { $overall_grade = 'A1';}
                elseif ($overall_pct >= 81) { $overall_grade = 'A2';}
                elseif ($overall_pct >= 71) { $overall_grade = 'B1';}
                elseif ($overall_pct >= 61) { $overall_grade = 'B2';}
                elseif ($overall_pct >= 51) { $overall_grade = 'C1';}
                elseif ($overall_pct >= 41) { $overall_grade = 'C2';}
                elseif ($overall_pct >= 33) { $overall_grade = 'D';}
                else { $overall_grade = 'E';}
                if ($grand_total == 0) $overall_grade = '-';
            ?>
            <tr>
                <td class="th-sub" style="font-weight:700;">TOTAL (ALL SUBJECTS)</td>
                <?php if ($is_state_board): ?>
                    <td style="text-align:left; font-weight:700; font-size:13px; color:#1e293b;">
                        <?php echo $grand_total; ?> <span style="color:#94a3b8">/<?php echo $grand_max; ?></span>
                    </td>
                    <td style="text-align:center;">
                        <span class="ms-grade ms-grade-<?php echo $overall_grade; ?>"><?php echo $overall_grade; ?></span>
                    </td>
                    <td style="text-align:center; font-weight:700;">-</td>
                <?php else: ?>
                    <td colspan="3" style="text-align:center;">-</td>
                    <td style="text-align:center; font-weight:700;">-</td>
                    <td style="text-align:left; font-weight:700; font-size:13px; color:#1e293b;">
                        <?php echo $grand_total; ?> <span style="color:#94a3b8">/<?php echo $grand_max; ?></span>
                    </td>
                    <td style="text-align:center;">
                        <span class="ms-grade ms-grade-<?php echo $overall_grade; ?>"><?php echo $overall_grade; ?></span>
                    </td>
                    <td style="text-align:center; font-weight:700;">-</td>
                <?php endif; ?>
            </tr>
        </tfoot>
    </table>

    <!-- GRAND TOTAL BAR -->
    <div class="ms-grand-bar">
        <div class="ms-grand-item">
            <div class="glab">Grand Total</div>
            <div class="gval"><?php echo $grand_total; ?> / <?php echo $grand_max; ?></div>
        </div>
        <div class="ms-grand-item">
            <div class="glab">Percentage</div>
            <div class="gval"><?php echo number_format($overall_pct, 2); ?> %</div>
        </div>
        <div class="ms-grand-item">
            <div class="glab">Grade</div>
            <div class="gval"><?php echo $overall_grade; ?></div>
        </div>
        <div class="ms-grand-item">
            <div class="glab">Rank in Class</div>
            <?php
                // Count total students in class
                $total_students_in_class = $this->db->get_where('student', ['class_id' => $class['class_id']])->num_rows();
            ?>
            <div class="gval"><?php echo isset($class_rank) && $class_rank != '-' ? $class_rank : '-'; ?> / <?php echo $total_students_in_class; ?></div>
        </div>
        <div class="ms-grand-item">
            <div class="glab">Attendance</div>
            <div class="gval"><?php echo isset($student['attendance']) ? $student['attendance'] . '%' : '—'; ?></div>
        </div>
    </div>

    <!-- BOTTOM THREE SECTIONS -->
    <div class="ms-bottom-grid">
        <!-- Co-Scholastic -->
        <div class="ms-bottom-section">
            <div class="ms-bottom-title ms-bt-red">Co-Scholastic Areas (On a 5 Point Scale)</div>
                <?php
                    $cq = $this->db->get_where('co_scholastic_marks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                    if ($cq->num_rows() > 0) {
                        $co_row = $cq->row_array();
                        $co_art = $co_row['art_grade'];
                        $co_pe = $co_row['pe_grade'];
                        $co_work = $co_row['work_grade'];
                        $co_disc = $co_row['discipline_grade'];
                        $co_cond = $co_row['conduct_grade'];
                    } else {
                        $co_art = '-'; $co_pe = '-'; $co_work = '-'; $co_disc = '-'; $co_cond = '-';
                    }
                ?>
                <table class="ms-co-table">
                    <tr><td>Art Education</td><td><?php echo $co_art; ?></td></tr>
                    <tr><td>Physical Education</td><td><?php echo $co_pe; ?></td></tr>
                    <tr><td>Work Education</td><td><?php echo $co_work; ?></td></tr>
                    <tr><td>Discipline</td><td><?php echo $co_disc; ?></td></tr>
                    <tr><td>General Conduct</td><td><?php echo $co_cond; ?></td></tr>
                </table>
        </div>

        <!-- General Remarks -->
        <div class="ms-bottom-section">
            <div class="ms-bottom-title ms-bt-green">General Remarks</div>
            <p class="ms-remark-text"><?php echo !empty($remarks) ? $remarks : 'No remarks available.'; ?></p>
        </div>

        <!-- Grading Scale -->
        <div class="ms-bottom-section">
            <div class="ms-bottom-title ms-bt-blue">Grading Scale</div>
            <table class="ms-grade-scale">
                <thead>
                    <tr><th>Grade</th><th>Marks Range (%)</th><th>Remarks</th></tr>
                </thead>
                <tbody>
                    <tr><td><span class="ms-grade ms-grade-A1">A1</span></td><td>91 - 100</td><td>Outstanding</td></tr>
                    <tr><td><span class="ms-grade ms-grade-A2">A2</span></td><td>81 - 90</td><td>Excellent</td></tr>
                    <tr><td><span class="ms-grade ms-grade-B1">B1</span></td><td>71 - 80</td><td>Very Good</td></tr>
                    <tr><td><span class="ms-grade ms-grade-B2">B2</span></td><td>61 - 70</td><td>Good</td></tr>
                    <tr><td><span class="ms-grade ms-grade-C1">C1</span></td><td>51 - 60</td><td>Satisfactory</td></tr>
                    <tr><td><span class="ms-grade ms-grade-C2">C2</span></td><td>41 - 50</td><td>Average</td></tr>
                    <tr><td><span class="ms-grade ms-grade-D">D</span></td><td>33 - 40</td><td>Needs Improvement</td></tr>
                    <tr><td><span class="ms-grade ms-grade-E">E</span></td><td>0 - 32</td><td>Unsatisfactory</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SIGNATURES & STAMP -->
    <?php
        $stamp_name = strtoupper($school_name);
        $stamp_location = $school_address ? strtoupper($school_address->description) : '';
        $loc_parts = explode(',', $stamp_location);
        $stamp_city = trim(end($loc_parts));
        if (strlen($stamp_city) < 3) $stamp_city = trim($loc_parts[0]);
    ?>
    <div class="ms-signatures">
        <div class="ms-sig-block">
            <div class="ms-sig-line"></div>
            <div class="ms-sig-name">Class Teacher</div>
            <div class="ms-sig-date">Date: <?php echo date('d-m-Y'); ?></div>
        </div>
        <div class="ms-sig-block">
            <div class="ms-sig-line"></div>
            <div class="ms-sig-name">Checked By</div>
            <div class="ms-sig-role">Academic Coordinator</div>
            <div class="ms-sig-date">Date: <?php echo date('d-m-Y'); ?></div>
        </div>
        <div class="ms-sig-block" style="position: relative;">
            
            <!-- STAMP OVERLAY -->
            <div class="ms-stamp-container" style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); z-index: 0; pointer-events: none;">
                <svg class="ms-stamp-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- Outer circle -->
                    <circle cx="50" cy="50" r="47" fill="none" stroke="#1e3a5f" stroke-width="3"/>
                    <!-- Inner circle -->
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#1e3a5f" stroke-width="1.5"/>
                    
                    <defs>
                        <path id="topArc1" d="M 10,50 a 40,40 0 1,1 80,0" fill="none"/>
                        <path id="bottomArc1" d="M 90,50 a 40,40 0 1,1 -80,0" fill="none"/>
                    </defs>
                    
                    <!-- School name -->
                    <text font-family="Inter, Arial, sans-serif" font-size="7.5" font-weight="800" fill="#1e3a5f" letter-spacing="2">
                        <textPath href="#topArc1" startOffset="50%" text-anchor="middle"><?php echo $stamp_name; ?></textPath>
                    </text>
                    <!-- Location -->
                    <text font-family="Inter, Arial, sans-serif" font-size="7" font-weight="700" fill="#1e3a5f" letter-spacing="1.5">
                        <textPath href="#bottomArc1" startOffset="50%" text-anchor="middle"><?php echo $stamp_city; ?></textPath>
                    </text>
                    
                    <!-- School logo -->
                    <image href="<?php echo base_url(); ?>uploads/logo.png" x="30" y="30" width="40" height="40" opacity="0.9"/>
                    
                    <!-- Star separators -->
                    <circle cx="10" cy="50" r="2" fill="#1e3a5f"/>
                    <circle cx="90" cy="50" r="2" fill="#1e3a5f"/>
                </svg>
            </div>

            <!-- PRINCIPAL TEXT -->
            <div class="ms-sig-line" style="position: relative; z-index: 1;"></div>
            <div class="ms-sig-name" style="position: relative; z-index: 1;">Principal</div>
            <div class="ms-sig-date" style="position: relative; z-index: 1;">Date: <?php echo date('d-m-Y'); ?></div>
        </div>
    </div>

    <div class="ms-footer-text">This is a computer generated marksheet. Does not require physical signature.</div>

</div> <!-- /ms-a4-container -->
</div> <!-- /ms-wrapper -->

<script>
    // Automatically trigger print dialog when page loads
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>
