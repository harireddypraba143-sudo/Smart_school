<style>
    .premium-wrapper { font-family: 'Inter', sans-serif; }
    .premium-card { background: #fff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 5px; margin-top: 0; }
    .breadcrumb-text { font-size: 13px; color: #64748b; margin-bottom: 20px; }
    .filter-label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block; }
    .filter-label span { color: #ef4444; }
    .filter-select { border-radius: 6px; border: 1px solid #cbd5e1; height: 42px; width: 100%; padding: 0 12px; font-size: 14px; color: #334155; }
    .btn-promote { background: linear-gradient(135deg, #16a34a, #059669); color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 700; font-size: 15px; transition: 0.2s; margin-top: 20px; }
    .btn-promote:hover { background: linear-gradient(135deg, #15803d, #047857); color: white; }
    .student-row { display: flex; align-items: center; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 8px; transition: 0.15s; }
    .student-row:hover { border-color: #3b82f6; background: #f0f9ff; }
    .student-row input[type="checkbox"] { width: 18px; height: 18px; margin-right: 15px; accent-color: #1e3a8a; }
    .student-row .name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .student-row .roll { font-size: 12px; color: #94a3b8; margin-left: 8px; }
    .student-row .admission { font-size: 12px; color: #667eea; margin-left: 8px; font-weight: 600; }
    .student-row .status-badge { font-size: 11px; padding: 2px 8px; border-radius: 10px; margin-left: 10px; }
    .status-active { background: #dcfce7; color: #166534; }
    .status-left { background: #fef3c7; color: #92400e; }
    .status-completed { background: #dbeafe; color: #1e40af; }
    .arrow-icon { font-size: 40px; color: #16a34a; text-align: center; margin: 20px 0; }
    .select-all-bar { background: #f1f5f9; padding: 10px 15px; border-radius: 6px; margin-bottom: 15px; display: flex; align-items: center; font-size: 13px; font-weight: 600; color: #475569; }
    .select-all-bar input { margin-right: 10px; width: 18px; height: 18px; accent-color: #1e3a8a; }
    .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 15px 20px; font-size: 13px; color: #1e40af; margin-bottom: 20px; }
    .section-divider { border-top: 2px dashed #e2e8f0; margin: 30px 0 20px 0; }
</style>

<div class="premium-wrapper">
<div class="row">
    <div class="col-md-12">
        <div class="premium-card">
            <h2 class="page-title"><i class="fa fa-level-up" style="color:#16a34a;"></i> Student Promotion & Status Management</h2>
            <div class="breadcrumb-text">Dashboard &rsaquo; Students &rsaquo; Promotion</div>

            <div class="info-box">
                <i class="fa fa-info-circle"></i> <strong>How to use:</strong><br>
                <strong>1. Promote:</strong> Select "From Class" → load students → choose "To Class" + "New Session" → check students → click Promote.<br>
                <strong>2. Mark Status:</strong> Select students from a class → choose status (Left School / Completed) → click Mark Status.<br>
                <strong>For old data entry:</strong> Enter students in their admission class/session, then use this tool to mark them as "Left" or "Completed" as needed.
            </div>

            <!-- ═══════ PROMOTION FORM ═══════ -->
            <?php echo form_open(base_url() . 'admin/student_promotion'); ?>
            <input type="hidden" name="operation" value="promote" id="form_operation">
            <input type="hidden" name="new_status" value="" id="form_new_status">
            <div class="row">
                <div class="col-md-3">
                    <label class="filter-label">From Class (Current) <span>*</span></label>
                    <select name="from_class" id="from_class" class="filter-select" onchange="loadStudents(this.value)" required>
                        <option value="">Select Current Class</option>
                        <?php $classes = $this->db->get('class')->result_array();
                        foreach ($classes as $c): ?>
                            <option value="<?php echo $c['class_id']; ?>"><?php echo $c['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1" style="text-align:center;">
                    <div class="arrow-icon"><i class="fa fa-long-arrow-right"></i></div>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">To Class (Promoted) <span>*</span></label>
                    <select name="to_class" class="filter-select" id="to_class">
                        <option value="">Select Target Class</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?php echo $c['class_id']; ?>"><?php echo $c['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">New Session (After Promotion)</label>
                    <select name="new_session" class="filter-select" id="new_session">
                        <option value="">Keep Same</option>
                        <?php
                        $current_year = (int)date('Y');
                        if ((int)date('m') < 6) $current_year--;
                        for ($y = $current_year; $y >= 2012; $y--) {
                            $session_str = $y . '-' . ($y + 1);
                            $is_current = ($y == $current_year) ? ' (Current)' : '';
                            echo '<option value="' . $session_str . '">' . $session_str . $is_current . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">&nbsp;</label>
                    <div style="display: flex; gap: 5px; flex-direction: column;">
                        <button type="button" class="btn btn-sm" style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; font-size: 12px; padding: 4px 8px;" id="student_count_badge">
                            <i class="fa fa-users"></i> <span id="count_text">0 students</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="student-list" style="margin-top: 25px;">
                <!-- Dynamic student list loads here -->
            </div>

            <!-- Action Buttons -->
            <div id="actionButtons" style="display:none; margin-top: 20px;">
                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" class="btn-promote btn-block" onclick="setOperation('promote')">
                            <i class="fa fa-arrow-up"></i> Promote Selected Students
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 700; font-size: 15px; margin-top: 20px;" onclick="setOperation('mark_status'); document.getElementById('form_new_status').value='left';">
                            <i class="fa fa-sign-out"></i> Mark as Left School
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 700; font-size: 15px; margin-top: 20px;" onclick="setOperation('mark_status'); document.getElementById('form_new_status').value='completed';">
                            <i class="fa fa-graduation-cap"></i> Mark as Completed (10th Pass)
                        </button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</div>

<script>
function setOperation(op) {
    document.getElementById('form_operation').value = op;
}

function loadStudents(classId) {
    if (!classId) { 
        document.getElementById('student-list').innerHTML = ''; 
        document.getElementById('actionButtons').style.display = 'none';
        document.getElementById('count_text').textContent = '0 students';
        return; 
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '<?php echo base_url(); ?>admin/get_students_by_class/' + classId, true);
    xhr.onload = function() {
        var students = JSON.parse(this.responseText);
        var html = '';
        if (students.length === 0) {
            html = '<div style="color:#94a3b8; text-align:center; padding:30px;"><i class="fa fa-info-circle fa-2x"></i><br>No students found in this class.</div>';
            document.getElementById('actionButtons').style.display = 'none';
        } else {
            // Count by status
            var activeCount = 0, leftCount = 0, completedCount = 0;
            for (var i = 0; i < students.length; i++) {
                var s = students[i].student_status || 'active';
                if (s == 'active') activeCount++;
                else if (s == 'left') leftCount++;
                else if (s == 'completed') completedCount++;
            }

            html += '<div class="select-all-bar"><input type="checkbox" id="selectAll" onchange="toggleAll()"> Select All (' + students.length + ' students) &nbsp; ';
            html += '<span class="status-badge status-active" style="margin-left:10px;">Active: ' + activeCount + '</span> ';
            html += '<span class="status-badge status-left" style="margin-left:5px;">Left: ' + leftCount + '</span> ';
            html += '<span class="status-badge status-completed" style="margin-left:5px;">Completed: ' + completedCount + '</span>';
            html += '</div>';

            for (var i = 0; i < students.length; i++) {
                var st = students[i].student_status || 'active';
                var statusBadge = '';
                if (st == 'active') statusBadge = '<span class="status-badge status-active">✅ Active</span>';
                else if (st == 'left') statusBadge = '<span class="status-badge status-left">🚪 Left</span>';
                else if (st == 'completed') statusBadge = '<span class="status-badge status-completed">🎓 Completed</span>';

                var admNo = students[i].admission_no ? '<span class="admission">' + students[i].admission_no + '</span>' : '';

                html += '<div class="student-row">';
                html += '<input type="checkbox" name="student_ids[]" value="' + students[i].student_id + '" class="student-cb">';
                html += '<span class="name">' + students[i].name + '</span>';
                html += admNo;
                html += '<span class="roll">Session: ' + (students[i].session || '—') + '</span>';
                html += statusBadge;
                html += '</div>';
            }
            document.getElementById('actionButtons').style.display = 'block';
        }
        document.getElementById('student-list').innerHTML = html;
        document.getElementById('count_text').textContent = students.length + ' students';
    };
    xhr.send();
}

function toggleAll() {
    var checked = document.getElementById('selectAll').checked;
    var cbs = document.querySelectorAll('.student-cb');
    for (var i = 0; i < cbs.length; i++) { cbs[i].checked = checked; }
}
</script>
