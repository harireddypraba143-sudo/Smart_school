 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="#"><b><img src="<?php echo base_url();?>uploads/logo.png" width="50" height="50" alt="home" /></b><span class="hidden-xs" style="color:white; font-size:18px; font-weight:700; vertical-align:middle; margin-left:10px;"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></span></a></div>

                    <ul class="nav navbar-top-links navbar-left hidden-xs">
                        <li><a href="javascript:void(0)" class="open-close hidden-xs "><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    </ul>

                    <!-- QUICK SHORTCUTS BAR -->
                    <ul class="nav navbar-top-links navbar-left hidden-xs" style="margin-left:5px; border-left:1px solid rgba(255,255,255,0.15); padding-left:5px;">
                        <li>
                            <a href="<?php echo base_url();?>admin/new_student" class="waves-effect" title="New Admission" style="padding:14px 10px;">
                                <i class="fa fa-user-plus" style="font-size:15px;"></i>
                                <span style="font-size:11px; margin-left:3px; display:none;">Admission</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/student_payment" class="waves-effect" title="Fee Collection" style="padding:14px 10px;">
                                <i class="fa fa-inr" style="font-size:15px;"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/manage_attendance/<?php echo date('d/m/Y');?>" class="waves-effect" title="Attendance" style="padding:14px 10px;">
                                <i class="fa fa-calendar-check-o" style="font-size:15px;"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/student_marksheet_subject" class="waves-effect" title="Marks Entry" style="padding:14px 10px;">
                                <i class="fa fa-pencil-square-o" style="font-size:15px;"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/noticeboard" class="waves-effect" title="Noticeboard" style="padding:14px 10px;">
                                <i class="fa fa-bullhorn" style="font-size:15px;"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/student_invoice" class="waves-effect" title="Invoices" style="padding:14px 10px;">
                                <i class="fa fa-file-text-o" style="font-size:15px;"></i>
                            </a>
                        </li>
                    </ul>

                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- SEARCH ICON -->
                    <li>
                        <a href="javascript:void(0)" onclick="toggleGlobalSearch()" class="waves-effect" title="Search" style="padding:14px 10px;">
                            <i class="fa fa-search" style="font-size:16px;"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>login/logout" class="waves-effect" title="Logout"><i class="fa fa-power-off"></i></a>
                    </li>
                    <li class="right-side-toggle"> <a class="" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                </ul>
            </div>
        </nav>

<!-- GLOBAL SEARCH OVERLAY -->
<div id="globalSearchOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.7); z-index:99999; backdrop-filter:blur(4px);" onclick="closeGlobalSearch(event)">
    <div style="max-width:580px; margin:60px auto 0; padding:0 16px;">
        <!-- Search Input -->
        <div style="background:#fff; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.3); overflow:hidden;">
            <div style="display:flex; align-items:center; padding:14px 18px; border-bottom:1px solid #f1f5f9;">
                <i class="fa fa-search" style="font-size:18px; color:#94a3b8; margin-right:12px;"></i>
                <input type="text" id="globalSearchInput" placeholder="Search students, pages, features..." autocomplete="off" onkeyup="globalSearch(this.value)"
                    style="border:none; outline:none; font-size:16px; font-weight:500; width:100%; color:#1a1a2e; font-family:inherit;">
                <span onclick="closeGlobalSearch()" style="cursor:pointer; color:#94a3b8; font-size:12px; padding:4px 10px; background:#f1f5f9; border-radius:6px; font-weight:600;">ESC</span>
            </div>
            <!-- Results -->
            <div id="searchResults" style="max-height:420px; overflow-y:auto;">
                <div style="padding:16px; text-align:center; color:#94a3b8; font-size:13px;">
                    Type to search students by name, phone, admission no...<br>
                    Or search pages like "fees", "attendance", "marks"
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#globalSearchOverlay a:hover { background:#f0f4ff !important; }
</style>

<script>
function toggleGlobalSearch() {
    var ov = document.getElementById('globalSearchOverlay');
    ov.style.display = ov.style.display === 'none' ? 'block' : 'none';
    if (ov.style.display === 'block') {
        setTimeout(function() { document.getElementById('globalSearchInput').focus(); }, 100);
    }
}
function closeGlobalSearch(e) {
    if (!e || e.target.id === 'globalSearchOverlay') {
        document.getElementById('globalSearchOverlay').style.display = 'none';
        document.getElementById('globalSearchInput').value = '';
    }
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeGlobalSearch();
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); toggleGlobalSearch(); }
});

var _sp = [
    {t:'Dashboard', u:'admin/dashboard', i:'fa-dashboard', c:'Pages'},
    {t:'New Admission', u:'admin/new_student', i:'fa-user-plus', c:'Admission'},
    {t:'Student Information', u:'admin/student_information', i:'fa-users', c:'Students'},
    {t:'Student Certificates', u:'admin/student_certificates', i:'fa-certificate', c:'Students'},
    {t:'Fee Collection', u:'admin/student_payment', i:'fa-inr', c:'Finance'},
    {t:'Invoices', u:'admin/student_invoice', i:'fa-file-text-o', c:'Finance'},
    {t:'Payroll', u:'admin/payroll', i:'fa-briefcase', c:'HR'},
    {t:'Teachers', u:'admin/teacher', i:'fa-user-secret', c:'HR'},
    {t:'Staff', u:'admin/staff', i:'fa-users', c:'HR'},
    {t:'Attendance', u:'admin/manage_attendance/<?php echo date("d/m/Y");?>', i:'fa-calendar-check-o', c:'Academic'},
    {t:'Attendance Report', u:'admin/attendance_report', i:'fa-bar-chart', c:'Academic'},
    {t:'Marks Entry', u:'admin/student_marksheet_subject', i:'fa-pencil-square-o', c:'Academic'},
    {t:'Create Exam', u:'admin/createExamination', i:'fa-file-text', c:'Exam'},
    {t:'Exam Questions', u:'admin/examQuestion', i:'fa-question', c:'Exam'},
    {t:'Report Cards', u:'admin/marksheet_view', i:'fa-id-card', c:'Academic'},
    {t:'Co-Scholastic', u:'admin/co_scholastic', i:'fa-star', c:'Academic'},
    {t:'Classes', u:'admin/classes', i:'fa-book', c:'Academic'},
    {t:'Sections', u:'admin/section', i:'fa-th-large', c:'Academic'},
    {t:'Promotion', u:'admin/student_promotion', i:'fa-arrow-up', c:'Academic'},
    {t:'Noticeboard', u:'admin/noticeboard', i:'fa-bullhorn', c:'Communication'},
    {t:'Circular', u:'admin/circular', i:'fa-newspaper-o', c:'Communication'},
    {t:'Enquiry List', u:'admin/list_enquiry', i:'fa-question-circle', c:'Admission'},
    {t:'Parents', u:'admin/parent', i:'fa-users', c:'People'},
    {t:'Alumni', u:'admin/alumni', i:'fa-graduation-cap', c:'Students'},
    {t:'Library', u:'admin/library', i:'fa-book', c:'Library'},
    {t:'Hostel', u:'admin/dormitory', i:'fa-building', c:'Hostel'},
    {t:'ID Card', u:'admin/id_card_generator', i:'fa-id-badge', c:'Documents'},
    {t:'Leave Management', u:'admin/leave_management', i:'fa-calendar-times-o', c:'HR'},
    {t:'Profile', u:'admin/manage_profile', i:'fa-cogs', c:'System'},
    {t:'Users', u:'admin/manage_users', i:'fa-user-circle', c:'System'}
];
var _sd = null;
function globalSearch(q) {
    clearTimeout(_sd);
    var box = document.getElementById('searchResults');
    if (!q || q.length < 1) {
        box.innerHTML = '<div style="padding:16px; text-align:center; color:#94a3b8; font-size:13px;">Type to search students, pages, features...</div>';
        return;
    }
    _sd = setTimeout(function() {
        var html = '', ql = q.toLowerCase();
        var pm = _sp.filter(function(p) { return p.t.toLowerCase().indexOf(ql) >= 0 || p.c.toLowerCase().indexOf(ql) >= 0; });
        if (pm.length > 0) {
            html += '<div style="padding:8px 18px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;">📄 Pages & Features</div>';
            pm.slice(0, 8).forEach(function(p) {
                html += '<a href="<?php echo base_url();?>' + p.u + '" style="display:flex;align-items:center;padding:10px 18px;text-decoration:none;color:#1a1a2e;border-bottom:1px solid #f8fafc;transition:background 0.15s;">'
                    + '<div style="width:32px;height:32px;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:13px;margin-right:12px;flex-shrink:0;"><i class="fa ' + p.i + '"></i></div>'
                    + '<div style="flex:1;"><div style="font-weight:600;font-size:14px;">' + p.t + '</div><div style="font-size:11px;color:#94a3b8;">' + p.c + '</div></div>'
                    + '<i class="fa fa-arrow-right" style="color:#cbd5e1;font-size:11px;"></i></a>';
            });
        }
        $.ajax({
            url: '<?php echo base_url();?>admin/search_students_ajax', data: {q: q}, dataType: 'json',
            success: function(students) {
                if (students && students.length > 0) {
                    html += '<div style="padding:8px 18px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;">👨‍🎓 Students</div>';
                    students.slice(0, 5).forEach(function(s) {
                        html += '<a href="<?php echo base_url();?>admin/student_information" style="display:flex;align-items:center;padding:10px 18px;text-decoration:none;color:#1a1a2e;border-bottom:1px solid #f8fafc;transition:background 0.15s;">'
                            + '<div style="width:32px;height:32px;background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;margin-right:12px;flex-shrink:0;">' + (s.name ? s.name[0].toUpperCase() : '?') + '</div>'
                            + '<div style="flex:1;"><div style="font-weight:600;font-size:14px;">' + s.name + '</div><div style="font-size:11px;color:#94a3b8;">' + (s.admission_no||'') + (s.phone ? ' • '+s.phone : '') + '</div></div>'
                            + '<i class="fa fa-arrow-right" style="color:#cbd5e1;font-size:11px;"></i></a>';
                    });
                }
                if (!html) html = '<div style="padding:24px;text-align:center;color:#94a3b8;font-size:13px;"><i class="fa fa-search" style="font-size:24px;display:block;margin-bottom:8px;opacity:0.4;"></i>No results for "' + q + '"</div>';
                box.innerHTML = html;
            },
            error: function() {
                if (!html) html = '<div style="padding:24px;text-align:center;color:#94a3b8;font-size:13px;">No results found</div>';
                box.innerHTML = html;
            }
        });
    }, 250);
}
</script>