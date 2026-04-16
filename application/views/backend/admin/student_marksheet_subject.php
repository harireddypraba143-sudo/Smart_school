
<style>
    .premium-wrapper { font-family: 'Inter', sans-serif; }
    .premium-card { background: #fff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 5px; margin-top: 0; }
    .breadcrumb-text { font-size: 13px; color: #64748b; margin-bottom: 20px; }
    
    .filter-label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block; }
    .filter-label span { color: #ef4444; }
    .filter-select { border-radius: 6px; border: 1px solid #cbd5e1; height: 42px; width: 100%; padding: 0 12px; font-size: 14px; color: #334155; }
    .btn-load { background: #1e3a8a; color: white; border-radius: 6px; height: 42px; font-weight: 500; font-size: 14px; width: 100%; border: none; transition: 0.2s; }
    .btn-load:hover { background: #172554; color: white; }

    .info-banner { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; margin-top: 20px; font-size: 13px; font-weight: 600; color: #166534; }
    .info-banner .badge-item { padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 12px; margin-left: 10px; }
    .badge-pt { background: #eff6ff; color: #2563eb; }
    .badge-nb { background: #f0fdf4; color: #16a34a; }
    .badge-en { background: #fff7ed; color: #ea580c; }
    .badge-wr { background: #faf5ff; color: #9333ea; }

    .marks-table { width: 100%; border-collapse: collapse; }
    .marks-table th, .marks-table td { border: 1px solid #e2e8f0; padding: 12px 10px; text-align: center; vertical-align: middle; }
    .marks-table th { background: #ffffff; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; }
    .marks-table td { font-size: 14px; color: #334155; }
    .marks-table .student-name { text-align: left; font-weight: 600; display: flex; align-items: center; }
    .marks-table .student-name img { width: 32px; height: 32px; border-radius: 50%; margin-right: 12px; border: 1px solid #cbd5e1; }
    
    .th-pt { color: #2563eb !important; background: #eff6ff !important; }
    .th-nb { color: #16a34a !important; background: #f0fdf4 !important; }
    .th-en { color: #ea580c !important; background: #fff7ed !important; }
    .th-wr { color: #9333ea !important; background: #faf5ff !important; }

    .input-wrapper { display: flex; align-items: center; justify-content: center; }
    .score-input { width: 45px; height: 36px; border: 1px solid #cbd5e1; border-radius: 4px; text-align: center; font-size: 14px; font-weight: 600; color: #0f172a; margin-right: 5px; outline: none; }
    .score-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.2); }
    .max-text { font-size: 12px; color: #94a3b8; font-weight: 500; }

    .total-val { font-size: 16px; font-weight: 700; color: #0f172a; }
    
    .grade-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; }
    .grade-A1 { background: #dcfce7; color: #166534; }
    .grade-A2 { background: #dcfce7; color: #15803d; }
    .grade-B1 { background: #fef9c3; color: #854d0e; }
    .grade-B2 { background: #fef08a; color: #a16207; }
    .grade-C1 { background: #fed7aa; color: #c2410c; }
    .grade-C2 { background: #ffedd5; color: #ea580c; }
    .grade-D  { background: #e0e7ff; color: #4338ca; }
    .grade-E  { background: #fee2e2; color: #b91c1c; }

    .remark-input { border: 1px solid #cbd5e1; border-radius: 4px; height: 36px; padding: 0 8px; width: 100%; font-size: 12px; }

    .right-card { background: #fff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .right-card h4 { font-size: 14px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }
    .summary-row { display: flex; justify-content: space-between; font-size: 13px; color: #475569; margin-bottom: 12px; }
    .summary-row b { color: #0f172a; font-size: 14px; }

    .scale-row { display: flex; align-items: center; margin-bottom: 8px; font-size: 13px; color: #475569; }
    .scale-mark { width: 35px; text-align: center; margin-right: 15px; }

    .btn-save { background: #1e3a8a; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; font-size: 14px; width: 100%; transition: 0.2s; }
    .btn-save:hover { background: #172554; color: white; }
    .btn-reset { background: #fff; color: #475569; border: 1px solid #cbd5e1; padding: 10px 20px; border-radius: 6px; font-weight: 600; font-size: 14px; width: 100%; transition: 0.2s; }
    .btn-reset:hover { background: #f1f5f9; }

    .note-banner { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 15px 20px; margin-top: 20px; color: #92400e; font-size: 13px; display: flex; align-items: flex-start; }
    .note-banner i { margin-right: 15px; font-size: 20px; color: #f59e0b; margin-top: 2px; }
    .note-banner ul { margin: 5px 0 0 0; padding-left: 20px; }
</style>

<div class="premium-wrapper">
<div class="row">
    <div class="col-md-12">
        <div class="premium-card" style="margin-bottom: 0;">
            <h2 class="page-title">Add / Enter Student Marks</h2>
            <div class="breadcrumb-text">Dashboard &rsaquo; Examination &rsaquo; Add Marks</div>
            
            <?php echo form_open(base_url() . 'admin/student_marksheet_subject', array('id' => 'filterForm', 'target'=>'_top'));?>
            <div class="row">
                <div class="col-md-2">
                    <label class="filter-label">Academic Year <span>*</span></label>
                    <?php $running_year = $this->db->get_where('settings', array('type' => 'session'))->row()->description; ?>
                    <select class="filter-select" name="academic_year" disabled>
                        <option selected><?php echo $running_year; ?></option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Examination <span>*</span></label>
                    <select name="exam_id" class="filter-select" required>
                        <option value="">Select Exam</option>
                        <?php $exams = $this->db->get('exam')->result_array();
                        foreach($exams as $row):?>
                        <option value="<?php echo $row['exam_id'];?>" <?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Class & Section <span>*</span></label>
                    <select name="class_id" class="filter-select" onchange="show_subjects(this.value)" required>
                        <option value="">Select Class</option>
                        <?php $classes = $this->db->get('class')->result_array();
                        foreach($classes as $row):?>
                        <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Subject <span>*</span></label>
                    <div id="subject_holder">
                        <?php 
                        if ($class_id > 0) {
                            $subjects = $this->db->get_where('subject', ['class_id' => $class_id])->result_array();
                            echo '<select name="subject_id" class="filter-select" id="subject_selector" required>';
                            echo '<option value="">Select Subject</option>';
                            foreach($subjects as $row) {
                                $sel = ($subject_id == $row['subject_id']) ? 'selected' : '';
                                echo '<option value="'.$row['subject_id'].'" '.$sel.'>'.$row['name'].'</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<select name="subject_id" class="filter-select" id="subject_selector" disabled><option>Select Class First</option></select>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Exam Pattern <span>*</span></label>
                    <select name="pattern" class="filter-select" required>
                        <option value="80" <?php if(isset($pattern) && $pattern == 80) echo 'selected'; ?>>CBSE Pattern (80)</option>
                        <option value="100" <?php if(isset($pattern) && $pattern == 100) echo 'selected'; ?>>State Board (100)</option>
                        <option value="50" <?php if(isset($pattern) && $pattern == 50) echo 'selected'; ?>>State Board (50)</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="filter-label">&nbsp;</label>
                    <input type="hidden" value="selection" name="operation">
                    <button type="submit" class="btn-load"><i class="fa fa-refresh"></i> Load</button>
                </div>
            </div>
            <?php echo form_close(); ?>

            <?php if($class_id > 0 && $subject_id > 0 && $exam_id > 0):?>
            
            <?php 
                $pattern_val = isset($pattern) ? (int)$pattern : 80;
                if ($pattern_val == 50 || $pattern_val == 100) {
                    $components = [
                        ['component_name' => 'WRITTEN', 'max_marks' => $pattern_val]
                    ];
                } else {
                    $components = $this->db->get_where('exam_components', ['subject_id' => $subject_id])->result_array();
                    if (empty($components)) {
                        $components = [
                            ['component_name' => 'PT', 'max_marks' => 10], ['component_name' => 'NOTEBOOK', 'max_marks' => 5],
                            ['component_name' => 'ENRICHMENT', 'max_marks' => 5], ['component_name' => 'WRITTEN', 'max_marks' => 80]
                        ];
                    }
                }
                
                // Color mapping logic natively tailored to exact screenshot CSS
                $col_classes = ['th-pt', 'th-nb', 'th-en', 'th-wr'];
                $bg_classes = ['badge-pt', 'badge-nb', 'badge-en', 'badge-wr'];
            ?>

            <div class="info-banner">
                <div>
                    <i class="fa fa-info-circle" style="color: #2563eb; margin-right: 8px;"></i> Maximum Marks per Component
                </div>
                    <?php 
                        $total_max = 0;
                        foreach($components as $i => $c): 
                            $total_max += $c['max_marks'];
                            // Force written color if there's only 1 component (State board mode)
                            $color_class = (count($components) == 1) ? 'badge-wr' : (isset($bg_classes[$i]) ? $bg_classes[$i] : 'badge-pt');
                    ?>
                    <span class="badge-item <?php echo $color_class; ?>"><?php echo $c['component_name'];?> (<?php echo $c['max_marks']; ?>)</span>
                    <?php endforeach; ?>
                    <span class="badge-item" style="background:transparent; border-left: 2px solid #cbd5e1; padding-left: 15px; margin-left:15px;">Total: <?php echo $total_max; ?> Marks</span>
                </div>
            </div>
            
            <?php endif; ?>

        </div>
    </div>
</div>

<?php if($class_id > 0 && $subject_id > 0 && $exam_id > 0):?>
<div class="row" style="margin-top:20px;">
    <!-- LEFT TABLE SECTION -->
    <div class="col-md-9">
        <div class="premium-card">
            <?php echo form_open(base_url() . 'admin/student_marksheet_subject/'. $exam_id . '/' . $class_id . '/' . $subject_id);?>
            <table class="marks-table" id="marksTable">
                <thead>
                    <tr>
                        <th rowspan="2" style="width:40px;">#</th>
                        <th rowspan="2">Roll No.</th>
                        <th rowspan="2">Student Name</th>
                        <th colspan="<?php echo count($components); ?>">MARKS OBTAINED</th>
                        <th rowspan="2" style="width:60px;">Total<br>(<?php echo $total_max; ?>)</th>
                        <th rowspan="2" style="width:60px;">Grade</th>
                        <th rowspan="2" style="width:100px;">Remark</th>
                    </tr>
                    <tr>
                        <?php foreach($components as $i => $c): 
                            $th_color = (count($components) == 1) ? 'th-wr' : (isset($col_classes[$i]) ? $col_classes[$i] : '');
                        ?>
                        <th class="<?php echo $th_color; ?>">
                            <?php echo $c['component_name']; ?><br>(<?php echo $c['max_marks']; ?>)
                        </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $students = $this->crud_model->get_students($class_id);
                        $count = 1;
                        $marks_entered = 0;
                        foreach($students as $st):
                            $student_id = $st['student_id'];
                            
                            // To determine if marks entered
                            $has_marks = false;
                    ?>
                    <tr id="row_<?php echo $student_id; ?>">
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $st['roll']; ?></td>
                        <td class="student-name">
                            <img src="<?php echo $this->crud_model->get_image_url('student', $student_id);?>" alt="User">
                            <?php echo $st['name']; ?>
                        </td>
                        
                        <?php foreach($components as $c): 
                            $val = '';
                            $q = $this->db->get_where('mark', ['student_id' => $student_id, 'subject_id' => $subject_id, 'exam_id' => $exam_id, 'component_type' => $c['component_name']]);
                            if($q->num_rows() > 0 && $q->row()->marks_obtained !== '') {
                                $val = $q->row()->marks_obtained;
                                $has_marks = true;
                            }
                        ?>
                        <td>
                            <div class="input-wrapper">
                                <input type="text" class="score-input mark_input_<?php echo $student_id; ?>" 
                                       data-student="<?php echo $student_id; ?>" 
                                       data-max="<?php echo $c['max_marks']; ?>" 
                                       value="<?php echo $val; ?>" 
                                       name="mark_<?php echo $student_id; ?>_<?php echo $c['component_name']; ?>" 
                                       onkeyup="calcTotal(<?php echo $student_id; ?>)">
                                <span class="max-text">/<?php echo $c['max_marks']; ?></span>
                            </div>
                        </td>
                        <?php endforeach; 
                            if($has_marks) $marks_entered++;
                        ?>
                        
                        <td><span class="total-val" id="total_<?php echo $student_id; ?>">0</span></td>
                        <td><span class="grade-badge" id="grade_<?php echo $student_id; ?>">-</span></td>
                        
                        <?php 
                            $rem = '';
                            $rq = $this->db->get_where('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                            if($rq->num_rows() > 0) $rem = $rq->row()->text;
                        ?>
                        <td>
                            <input type="text" name="comment_<?php echo $student_id; ?>" class="remark-input" placeholder="Remark..." value="<?php echo $rem; ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <input type="hidden" name="exam_id" value="<?php echo $exam_id;?>" />
            <input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
            <input type="hidden" name="subject_id" value="<?php echo $subject_id;?>" />
            <input type="hidden" name="operation" value="update_student_subject_score" />

            <!-- BOTTOM ACTION BAR -->
            <div style="display:flex; justify-content: space-between; align-items: center; margin-top:25px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <div>
                    <!-- Blank div to push buttons right, matching the screenshot spacing -->
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="button" class="btn-reset" onclick="window.location.reload()"><i class="fa fa-refresh"></i> Reset</button>
                    <button type="submit" class="btn-save"><i class="fa fa-check"></i> Save & Publish</button>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>

    <!-- RIGHT SIDEBAR SECTION -->
    <div class="col-md-3">
        <!-- Class Summary -->
        <div class="right-card">
            <h4>Class Summary</h4>
            <div class="summary-row"><span>Total Students</span> <b><?php echo count($students); ?></b></div>
            <div class="summary-row"><span>Marks Entered</span> <b><?php echo $marks_entered; ?></b></div>
            <div class="summary-row" style="margin-bottom:0;"><span>Pending</span> <b style="color:#ef4444;"><?php echo count($students) - $marks_entered; ?></b></div>
        </div>

        <!-- Grading Legend -->
        <div class="right-card">
            <h4>Grading Scale (Total Marks)</h4>
            <div class="scale-row"><div class="grade-badge grade-A1 scale-mark">A1</div> 91 - 100</div>
            <div class="scale-row"><div class="grade-badge grade-A2 scale-mark">A2</div> 81 - 90</div>
            <div class="scale-row"><div class="grade-badge grade-B1 scale-mark">B1</div> 71 - 80</div>
            <div class="scale-row"><div class="grade-badge grade-B2 scale-mark">B2</div> 61 - 70</div>
            <div class="scale-row"><div class="grade-badge grade-C1 scale-mark">C1</div> 51 - 60</div>
            <div class="scale-row"><div class="grade-badge grade-C2 scale-mark">C2</div> 41 - 50</div>
            <div class="scale-row"><div class="grade-badge grade-D scale-mark">D</div> 33 - 40</div>
            <div class="scale-row" style="margin-bottom:0;"><div class="grade-badge grade-E scale-mark">E</div> 0 - 32</div>
        </div>
    </div>
</div>

<!-- Note Banner -->
<div class="row">
    <div class="col-md-12">
        <div class="note-banner">
            <i class="fa fa-lightbulb-o"></i>
            <div>
                <strong>Note:</strong>
                <ul>
                    <li>Please enter marks carefully. Once published, marks are recorded securely.</li>
                    <li>Total is auto-calculated. Grade is based on total marks (100).</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<script>
    // AJAX load subjects dropdown
    function show_subjects(class_id) {
        if(class_id !== "") {
            $.ajax({
                url: '<?php echo base_url();?>admin/get_class_subject/' + class_id,
                success: function(response) {
                    $('#subject_selector').removeAttr('disabled').html('<option value="">Select Subject</option>' + response);
                }
            });
        } else {
            $('#subject_selector').attr('disabled', 'disabled').html('<option value="">Select Class First</option>');
        }
    }

    // Live Total & Grade Calculator
    function calcTotal(student_id) {
        var inputs = document.getElementsByClassName('mark_input_' + student_id);
        var total = 0;
        var max_total_marks = 0;
        
        for (var i = 0; i < inputs.length; i++) {
            var max = parseFloat(inputs[i].getAttribute('data-max'));
            max_total_marks += max;

            var val = parseFloat(inputs[i].value);
            
            if(!isNaN(val)) {
                if(val > max) {
                    alert('Score cannot exceed ' + max);
                    inputs[i].value = '';
                    val = 0;
                }
                total += val;
            }
        }
        
        // Update Total
        document.getElementById('total_' + student_id).innerText = total;
        
        // Calculate Percentage safely
        var percentage = 0;
        if (max_total_marks > 0) {
            percentage = (total / max_total_marks) * 100;
        }
        
        // Update Grade Badge
        var gBadge = document.getElementById('grade_' + student_id);
        gBadge.className = 'grade-badge'; // reset
        
        if (total === 0 && Array.from(inputs).every(i => i.value === '')) {
            gBadge.innerText = '-';
            return;
        }
        
        var gradeText = '';
        var gradeClass = '';
        if (percentage >= 91) { gradeText = 'A1'; gradeClass = 'grade-A1'; }
        else if (percentage >= 81) { gradeText = 'A2'; gradeClass = 'grade-A2'; }
        else if (percentage >= 71) { gradeText = 'B1'; gradeClass = 'grade-B1'; }
        else if (percentage >= 61) { gradeText = 'B2'; gradeClass = 'grade-B2'; }
        else if (percentage >= 51) { gradeText = 'C1'; gradeClass = 'grade-C1'; }
        else if (percentage >= 41) { gradeText = 'C2'; gradeClass = 'grade-C2'; }
        else if (percentage >= 33) { gradeText = 'D';  gradeClass = 'grade-D'; }
        else { gradeText = 'E'; gradeClass = 'grade-E'; }
        
        gBadge.innerText = gradeText;
        gBadge.classList.add(gradeClass);
    }

    // Trigger calculation on page load for existing data
    window.onload = function() {
        <?php if(isset($students)): foreach($students as $st): ?>
            calcTotal(<?php echo $st['student_id']; ?>);
        <?php endforeach; endif; ?>
    };
</script>
</div>