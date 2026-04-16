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
    .btn-promote { background: linear-gradient(135deg, #16a34a, #059669); color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 700; font-size: 15px; transition: 0.2s; margin-top: 20px; }
    .btn-promote:hover { background: linear-gradient(135deg, #15803d, #047857); color: white; }
    .student-row { display: flex; align-items: center; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 8px; transition: 0.15s; }
    .student-row:hover { border-color: #3b82f6; background: #f0f9ff; }
    .student-row input[type="checkbox"] { width: 18px; height: 18px; margin-right: 15px; accent-color: #1e3a8a; }
    .student-row .name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .student-row .roll { font-size: 12px; color: #94a3b8; margin-left: 8px; }
    .arrow-icon { font-size: 40px; color: #16a34a; text-align: center; margin: 20px 0; }
    .select-all-bar { background: #f1f5f9; padding: 10px 15px; border-radius: 6px; margin-bottom: 15px; display: flex; align-items: center; font-size: 13px; font-weight: 600; color: #475569; }
    .select-all-bar input { margin-right: 10px; width: 18px; height: 18px; accent-color: #1e3a8a; }
    .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 15px 20px; font-size: 13px; color: #1e40af; margin-bottom: 20px; }
</style>

<div class="premium-wrapper">
<div class="row">
    <div class="col-md-12">
        <div class="premium-card">
            <h2 class="page-title"><i class="fa fa-level-up" style="color:#16a34a;"></i> Student Promotion</h2>
            <div class="breadcrumb-text">Dashboard &rsaquo; Students &rsaquo; Promotion</div>

            <div class="info-box">
                <i class="fa fa-info-circle"></i> Select a "From Class" to load students, choose a "To Class" (the next grade), check the students who passed, and click Promote.
            </div>

            <?php echo form_open(base_url() . 'admin/student_promotion'); ?>
            <input type="hidden" name="operation" value="promote">
            <div class="row">
                <div class="col-md-5">
                    <label class="filter-label">From Class (Current) <span>*</span></label>
                    <select name="from_class" id="from_class" class="filter-select" onchange="loadStudents(this.value)" required>
                        <option value="">Select Current Class</option>
                        <?php $classes = $this->db->get('class')->result_array();
                        foreach ($classes as $c): ?>
                            <option value="<?php echo $c['class_id']; ?>"><?php echo $c['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2" style="text-align:center;">
                    <div class="arrow-icon"><i class="fa fa-long-arrow-right"></i></div>
                </div>
                <div class="col-md-5">
                    <label class="filter-label">To Class (Promoted) <span>*</span></label>
                    <select name="to_class" class="filter-select" required>
                        <option value="">Select Target Class</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?php echo $c['class_id']; ?>"><?php echo $c['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="student-list" style="margin-top: 25px;">
                <!-- Dynamic student list loads here -->
            </div>

            <button type="submit" class="btn-promote" id="promoteBtn" style="display:none;">
                <i class="fa fa-arrow-up"></i> Promote Selected Students
            </button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</div>

<script>
function loadStudents(classId) {
    if (!classId) { document.getElementById('student-list').innerHTML = ''; document.getElementById('promoteBtn').style.display = 'none'; return; }
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '<?php echo base_url(); ?>admin/get_students_by_class/' + classId, true);
    xhr.onload = function() {
        var students = JSON.parse(this.responseText);
        var html = '';
        if (students.length === 0) {
            html = '<div style="color:#94a3b8; text-align:center; padding:30px;">No students found in this class.</div>';
            document.getElementById('promoteBtn').style.display = 'none';
        } else {
            html += '<div class="select-all-bar"><input type="checkbox" id="selectAll" onchange="toggleAll()"> Select All (' + students.length + ' students)</div>';
            for (var i = 0; i < students.length; i++) {
                html += '<div class="student-row">';
                html += '<input type="checkbox" name="student_ids[]" value="' + students[i].student_id + '" class="student-cb">';
                html += '<span class="name">' + students[i].name + '</span>';
                html += '<span class="roll">Roll: ' + students[i].roll + '</span>';
                html += '</div>';
            }
            document.getElementById('promoteBtn').style.display = 'inline-block';
        }
        document.getElementById('student-list').innerHTML = html;
    };
    xhr.send();
}

function toggleAll() {
    var checked = document.getElementById('selectAll').checked;
    var cbs = document.querySelectorAll('.student-cb');
    for (var i = 0; i < cbs.length; i++) { cbs[i].checked = checked; }
}
</script>
