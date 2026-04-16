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

    .marks-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .marks-table th, .marks-table td { border: 1px solid #e2e8f0; padding: 12px 10px; text-align: center; vertical-align: middle; }
    .marks-table th { background: #ffffff; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; }
    .marks-table td { font-size: 14px; color: #334155; }
    .marks-table .student-name { text-align: left; font-weight: 600; display: flex; align-items: center; }
    .marks-table .student-name img { width: 32px; height: 32px; border-radius: 50%; margin-right: 12px; border: 1px solid #cbd5e1; }
    
    .th-co { background: #faf5ff !important; color: #9333ea !important; }

    .score-select { width: 60px; height: 36px; border: 1px solid #cbd5e1; border-radius: 4px; text-align: center; font-size: 14px; font-weight: 600; color: #0f172a; outline: none; }
    .score-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.2); }

    .btn-save { background: #1e3a8a; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; font-size: 14px; width: 100%; transition: 0.2s; margin-top: 20px; }
    .btn-save:hover { background: #172554; color: white; }

    .scale-row { display: flex; align-items: center; margin-bottom: 8px; font-size: 13px; color: #475569; }
    .scale-mark { width: 35px; text-align: center; margin-right: 15px; font-weight: bold; }
    
    .grade-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; }
    .grade-A { background: #dcfce7; color: #166534; }
    .grade-B { background: #fef9c3; color: #854d0e; }
    .grade-C { background: #fed7aa; color: #c2410c; }
    .grade-D { background: #e0e7ff; color: #4338ca; }
    .grade-E { background: #fee2e2; color: #b91c1c; }
</style>

<div class="premium-wrapper">
<div class="row">
    <div class="col-md-12">
        <div class="premium-card" style="margin-bottom: 0;">
            <h2 class="page-title">Manage Co-Scholastic Grades</h2>
            <div class="breadcrumb-text">Dashboard &rsaquo; Examination &rsaquo; Co-Scholastic</div>
            
            <?php echo form_open(base_url() . 'admin/co_scholastic', array('id' => 'filterForm', 'target'=>'_top'));?>
            <input type="hidden" name="operation" value="selection">
            <div class="row">
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <label class="filter-label">Class & Section <span>*</span></label>
                    <select name="class_id" class="filter-select" required>
                        <option value="">Select Class</option>
                        <?php $classes = $this->db->get('class')->result_array();
                        foreach($classes as $row):?>
                        <option value="<?php echo $row['class_id'];?>" <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label" style="color:transparent;">Action</label>
                    <button type="submit" class="btn-load">Load Students <i class="fa fa-arrow-right" style="margin-left: 8px;"></i></button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<?php if ($exam_id > 0 && $class_id > 0): ?>
<?php 
    $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
?>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-9">
        <div class="premium-card">
            <?php echo form_open(base_url() . 'admin/co_scholastic/' . $exam_id . '/' . $class_id);?>
            <input type="hidden" name="operation" value="update">
            
            <table class="marks-table">
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 15px; width: 35%;">Student Name</th>
                        <th class="th-co">Art Education</th>
                        <th class="th-co">P.E.</th>
                        <th class="th-co">Work Education</th>
                        <th class="th-co">Discipline</th>
                        <th class="th-co">Conduct</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $options = ['-', 'A', 'B', 'C', 'D', 'E'];
                    foreach($students as $row):
                        $sid = $row['student_id'];
                        // Fetch existing
                        $q = $this->db->get_where('co_scholastic_marks', ['student_id' => $sid, 'exam_id' => $exam_id]);
                        $existing = $q->num_rows() > 0 ? $q->row_array() : null;
                        
                        $art = $existing ? $existing['art_grade'] : '-';
                        $pe = $existing ? $existing['pe_grade'] : '-';
                        $work = $existing ? $existing['work_grade'] : '-';
                        $discipline = $existing ? $existing['discipline_grade'] : '-';
                        $conduct = $existing ? $existing['conduct_grade'] : '-';
                    ?>
                    <tr>
                        <td class="student-name">
                            <img src="<?php echo $this->crud_model->get_image_url('student', $sid);?>">
                            <div>
                                <?php echo $row['name'];?>
                                <div style="font-size: 11px; color:#94a3b8; font-weight: 500; margin-top:2px;">Roll: <?php echo $row['roll'];?></div>
                            </div>
                        </td>
                        
                        <!-- Art -->
                        <td>
                            <select class="score-select" name="art_grade_<?php echo $sid; ?>">
                                <?php foreach($options as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php if($art == $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        
                        <!-- P.E. -->
                        <td>
                            <select class="score-select" name="pe_grade_<?php echo $sid; ?>">
                                <?php foreach($options as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php if($pe == $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        
                        <!-- Work -->
                        <td>
                            <select class="score-select" name="work_grade_<?php echo $sid; ?>">
                                <?php foreach($options as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php if($work == $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        
                        <!-- Discipline -->
                        <td>
                            <select class="score-select" name="discipline_grade_<?php echo $sid; ?>">
                                <?php foreach($options as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php if($discipline == $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        
                        <!-- Conduct -->
                        <td>
                            <select class="score-select" name="conduct_grade_<?php echo $sid; ?>">
                                <?php foreach($options as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php if($conduct == $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <button type="submit" class="btn-save"><i class="fa fa-save"></i> Save All Grades</button>
            <?php echo form_close();?>
            
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="premium-card">
            <h4 style="margin-top:0; border-bottom:1px solid #e2e8f0; padding-bottom:10px;">Grading Scale (5-Point)</h4>
            <div class="scale-row">
                <span class="grade-badge grade-A scale-mark">A</span> <span>Outstanding</span>
            </div>
            <div class="scale-row">
                <span class="grade-badge grade-B scale-mark">B</span> <span>Excellent</span>
            </div>
            <div class="scale-row">
                <span class="grade-badge grade-C scale-mark">C</span> <span>Very Good</span>
            </div>
            <div class="scale-row">
                <span class="grade-badge grade-D scale-mark">D</span> <span>Good</span>
            </div>
            <div class="scale-row">
                <span class="grade-badge grade-E scale-mark">E</span> <span>Average</span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
