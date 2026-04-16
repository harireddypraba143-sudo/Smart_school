
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    .ms-wrapper { font-family: 'Inter', sans-serif; }
    .ms-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); padding: 24px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .ms-title { font-size: 24px; font-weight: 800; color: #1e293b; margin: 0 0 4px 0; }
    .ms-breadcrumb { font-size: 13px; color: #64748b; margin-bottom: 18px; }
    .ms-filter-label { font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 5px; display: block; }
    .ms-filter-label span { color: #ef4444; }
    .ms-filter-select { width: 100%; height: 40px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 0 12px; font-size: 13px; color: #334155; background: #fff; outline: none; transition: border 0.2s; }
    .ms-filter-select:focus { border-color: #2563eb; }
    .ms-btn-generate { background: linear-gradient(135deg, #1e3a5f, #1e293b); color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; height: 40px; white-space: nowrap; }
    .ms-btn-generate:hover { opacity: 0.9; }

    /* NEW A4 DESIGN LAYOUT */
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
    .ms-section-title { background: linear-gradient(135deg, #1e3a5f, #1e293b); color: #fff; text-align: center; padding: 10px; border-radius: 8px 8px 0 0; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin: 0; }
    .ms-marks-table { width: 100%; border-collapse: collapse; font-size: 13px; border: 1px solid #cbd5e1; }
    .ms-marks-table thead th { background: #f1f5f9; color: #334155; font-weight: 700; padding: 10px 8px; border: 1px solid #cbd5e1; text-align: center; font-size: 11.5px; text-transform: uppercase; }
    .ms-marks-table thead th.th-sub { text-align: left; min-width: 120px; }
    .ms-marks-table tbody td { padding: 10px 8px; border: 1px solid #e2e8f0; text-align: center; color: #334155; font-weight: 500; }
    .ms-marks-table tbody td:first-child { text-align: left; font-weight: 600; }
    .ms-marks-table tbody tr:nth-child(even) { background: #f8fafc; }
    .ms-marks-table tbody tr:hover { background: #eef2ff; }
    .ms-marks-table tfoot td { background: #f1f5f9; font-weight: 700; padding: 10px 8px; border: 1px solid #cbd5e1; text-align: center; color: #1e293b; }
    .ms-marks-table tfoot td:first-child { text-align: left; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }

    /* Grade Badges */
    .ms-grade { display: inline-block; padding: 3px 10px; border-radius: 4px; font-weight: 700; font-size: 12px; color: #fff; min-width: 32px; text-align: center; }
    .ms-grade-A1, .ms-grade-A2 { background: #16a34a; }
    .ms-grade-B1, .ms-grade-B2 { background: #2563eb; }
    .ms-grade-C1, .ms-grade-C2 { background: #f59e0b; color: #1e293b; }
    .ms-grade-D { background: #ea580c; }
    .ms-grade-E { background: #dc2626; }

    /* Grand Total Bar */
    .ms-grand-bar { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; border: 2px solid #1e3a5f; border-radius: 8px; overflow: hidden; margin: 20px 0; }
    .ms-grand-item { text-align: center; padding: 14px 10px; border-right: 1px solid #cbd5e1; }
    .ms-grand-item:last-child { border-right: none; }
    .ms-grand-item .glab { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .ms-grand-item .gval { font-size: 20px; font-weight: 800; color: #1e293b; }

    /* Bottom Sections */
    .ms-bottom-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; margin-bottom: 20px; }
    .ms-bottom-section { padding: 16px; border-right: 1px solid #cbd5e1; }
    .ms-bottom-section:last-child { border-right: none; }
    .ms-bottom-title { font-size: 11px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; padding: 6px 12px; border-radius: 4px; margin-bottom: 12px; display: inline-block; }
    .ms-bt-red { background: #dc2626; }
    .ms-bt-green { background: #16a34a; }
    .ms-bt-blue { background: #2563eb; }

    .ms-co-table { width: 100%; font-size: 12px; }
    .ms-co-table td { padding: 4px 0; color: #334155; }
    .ms-co-table td:last-child { text-align: right; font-weight: 700; }

    .ms-grade-scale { width: 100%; font-size: 11px; border-collapse: collapse; }
    .ms-grade-scale thead th { background: #f1f5f9; padding: 6px 8px; font-weight: 700; border: 1px solid #e2e8f0; text-align: center; color: #334155; }
    .ms-grade-scale tbody td { padding: 5px 8px; border: 1px solid #e2e8f0; text-align: center; }

    /* Signatures */
    .ms-signatures { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-top: 24px; padding-top: 20px; border-top: 2px solid #e2e8f0; }
    .ms-sig-block { text-align: center; }
    .ms-sig-line { border-bottom: 1px solid #1e293b; width: 80%; margin: 30px auto 6px; }
    .ms-sig-name { font-size: 13px; font-weight: 700; color: #1e293b; }
    .ms-sig-role { font-size: 11px; color: #64748b; }
    .ms-sig-date { font-size: 10px; color: #94a3b8; margin-top: 2px; }

    /* Action Sidebar */
    .ms-action-btn { display: block; width: 100%; padding: 10px 16px; margin-bottom: 10px; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; transition: 0.2s; }
    .ms-btn-print { background: #1e3a5f; color: #fff; }
    .ms-btn-print:hover { background: #1e293b; color: #fff; }
    .ms-btn-pdf { background: #16a34a; color: #fff; }
    .ms-btn-pdf:hover { background: #15803d; color: #fff; }
    .ms-btn-send { background: #f59e0b; color: #1e293b; }
    .ms-btn-send:hover { background: #d97706; }
    .ms-btn-back { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .ms-btn-back:hover { background: #e2e8f0; color: #475569; }

    /* Summary Card */
    .ms-summary-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-top: 16px; }
    .ms-summary-card h4 { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0 0 12px 0; }
    .ms-summary-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 12.5px; border-bottom: 1px solid #e2e8f0; }
    .ms-summary-row:last-child { border-bottom: none; }
    .ms-summary-row .slab { color: #64748b; }
    .ms-summary-row .sval { font-weight: 700; color: #1e293b; }
    .ms-summary-row .sval.highlight { color: #2563eb; }

    /* Note Card */
    .ms-note-card { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px; margin-top: 16px; }
    .ms-note-card .ntitle { font-size: 13px; font-weight: 700; color: #f59e0b; margin-bottom: 6px; }
    .ms-note-card .ntext { font-size: 11.5px; color: #92400e; line-height: 1.6; }

    .ms-footer-text { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 12px; font-style: italic; }

    .ms-remark-text { font-size: 12.5px; color: #334155; line-height: 1.7; font-style: italic; }

    /* AUTO STAMP / SEAL */
    .ms-stamp-container {
        width: 100px; height: 100px;
        display: inline-block;
    }
    .ms-stamp-svg {
        width: 100px; height: 100px;
        transform: rotate(-10deg);
        opacity: 0.8;
    }

    /* Print Styles */
    /* Print Styles */
    @media print {
        @page { size: A4 portrait; margin: 10mm; }
        
        html, body { 
            background: #fff !important; 
            margin: 0; padding: 0; 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
            zoom: 0.95; 
        }
        
        body * { visibility: hidden; }
        
        #printable-marksheet, #printable-marksheet * { 
            visibility: visible; 
        }
        
        #printable-marksheet { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%;
            margin: 0;
            padding: 0;
        }
        
        .ms-a4-container {
            border: 2px solid #1e3a5f !important;
            padding: 15px !important;
            width: 100% !important;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        
        .ms-action-sidebar, .ms-filter-section, .ms-card.ms-filter-section { 
            display: none !important; 
        }
    }
</style>

<div class="ms-wrapper">

<!-- FILTER SECTION -->
<div class="ms-card ms-filter-section">
    <h1 class="ms-title">Individual Marksheet</h1>
    <div class="ms-breadcrumb">Dashboard &rsaquo; Examinations &rsaquo; Marksheet</div>

    <?php echo form_open(base_url() . 'admin/marksheet_view', array('id' => 'marksheetFilter', 'target' => '_top')); ?>
    <div class="row">
        <div class="col-md-3">
            <label class="ms-filter-label">Academic Year <span>*</span></label>
            <?php $running_year = $this->db->get_where('settings', array('type' => 'session'))->row()->description; ?>
            <select class="ms-filter-select" disabled>
                <option selected><?php echo $running_year; ?></option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="ms-filter-label">Examination <span>*</span></label>
            <select name="exam_id" class="ms-filter-select" required>
                <option value="">Select Exam</option>
                <?php $exams = $this->db->get('exam')->result_array();
                foreach($exams as $row): ?>
                <option value="<?php echo $row['exam_id'];?>" <?php if($exam_id == $row['exam_id']) echo 'selected'; ?>><?php echo $row['name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="ms-filter-label">Class <span>*</span></label>
            <select name="class_id" class="ms-filter-select" onchange="ms_show_students(this.value)" required>
                <option value="">Select Class</option>
                <?php $classes = $this->db->get('class')->result_array();
                foreach($classes as $row): ?>
                <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected'; ?>><?php echo $row['name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="ms-filter-label">Student <span>*</span></label>
            <select name="student_id" class="ms-filter-select" id="ms_student_select" required>
                <?php if($class_id > 0 && $student_id > 0):
                    $students = $this->db->get_where('student', ['class_id' => $class_id])->result_array();
                    echo '<option value="">Select Student</option>';
                    foreach($students as $st) {
                        $sel = ($student_id == $st['student_id']) ? 'selected' : '';
                        echo '<option value="'.$st['student_id'].'" '.$sel.'>'.$st['name'].' ('.$st['roll'].')</option>';
                    }
                else: ?>
                <option value="">Select Class First</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-1">
            <label class="ms-filter-label">&nbsp;</label>
            <input type="hidden" value="selection" name="operation">
            <button type="submit" class="ms-btn-generate"><i class="fa fa-eye"></i> View</button>
        </div>
    </div>
    <?php echo form_close(); ?>

    <?php if ($exam_id > 0 && $class_id > 0): ?>
    <div style="margin-top: 10px;">
        <a href="<?php echo base_url(); ?>admin/bulk_print_report_card/<?php echo $exam_id; ?>/<?php echo $class_id; ?>" 
           class="ms-btn-generate" style="background: linear-gradient(135deg, #7c3aed, #a855f7); text-decoration: none; display: inline-block; line-height: 20px;" target="_blank">
            <i class="fa fa-print"></i> Print All (Entire Class)
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- MARKSHEET CONTENT -->
<?php if($class_id > 0 && $student_id > 0 && $exam_id > 0):

    // Fetch student data
    $student = $this->db->get_where('student', ['student_id' => $student_id])->row();
    $class = $this->db->get_where('class', ['class_id' => $class_id])->row();
    $exam = $this->db->get_where('exam', ['exam_id' => $exam_id])->row();
    $subjects = $this->db->get_where('subject', ['class_id' => $class_id])->result_array();
    $school_name = $this->db->get_where('settings', ['type' => 'system_name'])->row()->description;
    $school_address = $this->db->get_where('settings', ['type' => 'address'])->row();
    $school_phone = $this->db->get_where('settings', ['type' => 'phone'])->row();
    $school_email = $this->db->get_where('settings', ['type' => 'system_email'])->row();
    
    // Count total students for rank
    $total_students_in_class = $this->db->get_where('student', ['class_id' => $class_id])->num_rows();
?>

<div class="ms-main-layout" style="display:flex; gap:20px; align-items:flex-start; width: 100%;">
    
    <!-- LEFT MAIN CONTENT (Printable Area) -->
    <div style="flex:1; padding:0; min-width:0;">
        <div id="printable-marksheet">
            <div class="ms-a4-container">

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
                    <img src="<?php echo base_url(); ?>uploads/student_image/<?php echo $student->student_id; ?>.jpg" class="ms-profile-photo" alt="Photo" onerror="this.src='<?php echo base_url(); ?>uploads/student_image/default.jpg'">
                    
                    <div class="ms-student-details">
                        <div class="ms-details-col">
                            <span class="plabel">Student Name</span> <span class="psep">:</span> <span class="pval"><?php echo $student->name; ?></span>
                            <span class="plabel">Roll No.</span> <span class="psep">:</span> <span class="pval"><?php echo $student->roll; ?></span>
                            <span class="plabel">Admission No.</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student->admission_no) ? $student->admission_no : $student->student_id; ?></span>
                            <span class="plabel">Mother's Name</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student->mother_name) ? $student->mother_name : 'N/A'; ?></span>
                            <span class="plabel">Father's Name</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student->father_name) ? $student->father_name : 'N/A'; ?></span>
                        </div>
                        <div class="ms-details-col">
                            <span class="plabel">Class & Section</span> <span class="psep">:</span> <span class="pval"><?php echo $class->name; ?></span>
                            <?php 
                                $board = $this->db->get_where('settings', array('type' => 'board'))->row();
                                $board_name = $board ? $board->description : 'State Board';
                            ?>
                            <span class="plabel">Board</span> <span class="psep">:</span> <span class="pval"><?php echo $board_name; ?></span>
                            <span class="plabel">Date of Birth</span> <span class="psep">:</span> <span class="pval"><?php echo isset($student->date_of_birth) ? date('d M Y', strtotime($student->date_of_birth)) : 'N/A'; ?></span>
                            <span class="plabel">Examination</span> <span class="psep">:</span> <span class="pval"><?php echo $exam->name; ?></span>
                            <span class="plabel">Exam Date</span> <span class="psep">:</span> <span class="pval"><?php echo date('M Y'); ?></span>
                            <span class="plabel">Result Date</span> <span class="psep">:</span> <span class="pval"><?php echo date('d M Y'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- SCHOLASTIC TABLE -->
                <div class="ms-section-title">Scholastic Areas (Academic)</div>
        <?php
            // First determine what pattern this student's exam relies on
            $is_state_board = false;
            $max_state_marks = 100;
            
            // Check global setting first
            $board_setting = $this->db->get_where('settings', array('type' => 'board'))->row();
            if (!$board_setting || strpos(strtolower($board_setting->description), 'state') !== false) {
                $is_state_board = true;
                $max_state_marks = 100; // Force 100 for display
            } else {
                // If CBSE
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
                    <th style="background:#e8f0fe; color:#1e3a5f;">Periodic Test /<br>Internal (10)</th>
                    <th style="background:#e8f0fe; color:#1e3a5f;">Note Book /<br>Portfolio (5)</th>
                    <th style="background:#e8f0fe; color:#1e3a5f;">Subject<br>Enrichment (5)</th>
                </tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php 
                    $grand_total = 0;
                    $grand_max = 0;
                    $subject_count = 0;
                    
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
                        
                        // Grade
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
                    <td style="font-weight:700; text-transform:uppercase; color:#1e293b; background:#f1f5f9;">Total (All Subjects)</td>
                    <?php if ($is_state_board): ?>
                        <td style="text-align:left; font-weight:700; font-size:13px; color:#1e293b; background:#f1f5f9;">
                            <?php echo $grand_total; ?> <span style="color:#94a3b8">/<?php echo $grand_max; ?></span>
                        </td>
                        <td style="text-align:center; background:#f1f5f9;">
                            <span class="ms-grade ms-grade-<?php echo $overall_grade; ?>"><?php echo $overall_grade; ?></span>
                        </td>
                        <td style="text-align:center; font-weight:700; background:#f1f5f9;">-</td>
                    <?php else: ?>
                        <td colspan="3" style="text-align:center; background:#f1f5f9;">-</td>
                        <td style="text-align:center; font-weight:700; background:#f1f5f9;">-</td>
                        <td style="text-align:left; font-weight:700; font-size:13px; color:#1e293b; background:#f1f5f9;">
                            <?php echo $grand_total; ?> <span style="color:#94a3b8">/<?php echo $grand_max; ?></span>
                        </td>
                        <td style="text-align:center; background:#f1f5f9;">
                            <span class="ms-grade ms-grade-<?php echo $overall_grade; ?>"><?php echo $overall_grade; ?></span>
                        </td>
                        <td style="text-align:center; font-weight:700; background:#f1f5f9;">-</td>
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
                    // Calculate rank
                    $all_students = $this->db->get_where('student', ['class_id' => $class_id])->result_array();
                    $student_totals = [];
                    foreach ($all_students as $ast) {
                        $st_marks = $this->db->get_where('mark', ['student_id' => $ast['student_id'], 'exam_id' => $exam_id])->result_array();
                        $st_total = 0;
                        foreach ($st_marks as $sm) {
                            $st_total += (float)$sm['marks_obtained'];
                        }
                        $student_totals[$ast['student_id']] = $st_total;
                    }
                    arsort($student_totals);
                    $rank = 1;
                    $student_rank = '-';
                    foreach ($student_totals as $sid => $stot) {
                        if ($sid == $student_id) { $student_rank = $rank; break; }
                        $rank++;
                    }
                ?>
                <div class="gval"><?php echo $student_rank; ?> / <?php echo $total_students_in_class; ?></div>
            </div>
            <div class="ms-grand-item">
                <div class="glab">Attendance</div>
                <div class="gval"><?php echo isset($student->attendance) ? $student->attendance . '%' : '—'; ?></div>
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
                <?php
                    $rq = $this->db->get_where('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                    $remark_text = ($rq->num_rows() > 0) ? $rq->row()->text : 'No remarks available.';
                ?>
                <p class="ms-remark-text"><?php echo $remark_text; ?></p>
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

        <!-- SIGNATURES -->
        <?php
            // Extract school name and location for stamp
            $stamp_name = strtoupper($school_name);
            $stamp_location = $school_address ? strtoupper($school_address->description) : '';
            // Keep location short for stamp
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
                    
                    <!-- Text paths -->
                    <defs>
                        <path id="topArc1" d="M 10,50 a 40,40 0 1,1 80,0" fill="none"/>
                        <path id="bottomArc1" d="M 90,50 a 40,40 0 1,1 -80,0" fill="none"/>
                    </defs>
                    
                    <!-- School name on top arc -->
                    <text font-family="Inter, Arial, sans-serif" font-size="7.5" font-weight="800" fill="#1e3a5f" letter-spacing="2">
                        <textPath href="#topArc1" startOffset="50%" text-anchor="middle"><?php echo $stamp_name; ?></textPath>
                    </text>
                    
                    <!-- Location on bottom arc -->
                    <text font-family="Inter, Arial, sans-serif" font-size="7" font-weight="700" fill="#1e3a5f" letter-spacing="1.5">
                        <textPath href="#bottomArc1" startOffset="50%" text-anchor="middle"><?php echo $stamp_city; ?></textPath>
                    </text>
                    
                    <!-- School logo in center -->
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
    </div> <!-- /printable-marksheet -->
    </div> <!-- /flex:1 container -->

    <!-- RIGHT SIDEBAR -->
    <div class="ms-action-sidebar" style="width: 280px; flex-shrink: 0;">
        <div class="ms-card" style="padding:18px;">
            <h4 style="font-size:15px; font-weight:700; color:#1e293b; margin:0 0 14px 0;">Actions</h4>
            <a href="<?php echo base_url(); ?>admin/print_report_card/<?php echo $student_id; ?>/<?php echo $exam_id; ?>" target="_blank" class="ms-action-btn ms-btn-print"><i class="fa fa-print"></i> &nbsp;Print Marksheet</a>
            <a href="<?php echo base_url(); ?>admin/print_report_card/<?php echo $student_id; ?>/<?php echo $exam_id; ?>" target="_blank" class="ms-action-btn ms-btn-pdf"><i class="fa fa-download"></i> &nbsp;Download PDF</a>
            <a href="javascript:void(0);" class="ms-action-btn ms-btn-send"><i class="fa fa-envelope"></i> &nbsp;Send to Parent</a>
            <a href="<?php echo base_url(); ?>admin/marksheet_view" class="ms-action-btn ms-btn-back"><i class="fa fa-arrow-left"></i> &nbsp;Back to List</a>
        </div>

        <div class="ms-summary-card">
            <h4>Summary</h4>
            <div class="ms-summary-row"><span class="slab">Total Subjects</span><span class="sval"><?php echo $subject_count; ?></span></div>
            <div class="ms-summary-row"><span class="slab">Total Marks</span><span class="sval"><?php echo $grand_total; ?> / <?php echo $grand_max; ?></span></div>
            <div class="ms-summary-row"><span class="slab">Percentage</span><span class="sval highlight"><?php echo number_format($overall_pct, 2); ?> %</span></div>
            <div class="ms-summary-row"><span class="slab">Overall Grade</span><span class="sval"><?php echo $overall_grade; ?></span></div>
            <div class="ms-summary-row"><span class="slab">Rank in Class</span><span class="sval"><?php echo $student_rank; ?> / <?php echo $total_students_in_class; ?></span></div>
            <div class="ms-summary-row"><span class="slab">Attendance</span><span class="sval"><?php echo isset($student->attendance) ? $student->attendance . '%' : '—'; ?></span></div>
        </div>

        <div class="ms-note-card">
            <div class="ntitle"><i class="fa fa-lightbulb-o"></i> &nbsp;Note</div>
            <div class="ntext">
                Result published on<br><strong><?php echo date('d M Y'); ?></strong>
                <br><br>
                Next Examination:<br>
                <strong>
                <?php 
                    // Show next exam
                    $next = $this->db->where('exam_id >', $exam_id)->order_by('exam_id', 'ASC')->limit(1)->get('exam')->row();
                    echo $next ? $next->name : 'Final';
                ?>
                </strong>
            </div>
        </div>
    </div>
</div>

</div>
<?php endif; ?>

</div>

<script>
function ms_show_students(class_id) {
    if (class_id !== "") {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_class_student/' + class_id,
            success: function(response) {
                var sel = document.getElementById('ms_student_select');
                sel.innerHTML = '<option value="">Select Student</option>' + response;
                sel.removeAttribute('disabled');
            },
            error: function() {
                // Fallback: use student list from get_class_subject as proxy
                $.ajax({
                    url: '<?php echo base_url(); ?>modal/get_student_by_class/' + class_id,
                    success: function(r) {
                        var sel = document.getElementById('ms_student_select');
                        sel.innerHTML = '<option value="">Select Student</option>' + r;
                        sel.removeAttribute('disabled');
                    }
                });
            }
        });
    } else {
        document.getElementById('ms_student_select').innerHTML = '<option value="">Select Class First</option>';
    }
}
</script>
