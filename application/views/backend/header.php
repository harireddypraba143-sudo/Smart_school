 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="#"><b><img src="<?php echo base_url();?>uploads/logo.png" width="50" height="50" alt="home" /></b><span class="hidden-xs" style="color:white; font-size:18px; font-weight:700; vertical-align:middle; margin-left:10px;"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></span></a></div>

                    <ul class="nav navbar-top-links navbar-left hidden-xs">
                        <li><a href="javascript:void(0)" class="open-close hidden-xs "><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                        
                        <!-- GLOBAL SEARCH BAR -->
                        <li style="position:relative;">
                            <form role="search" class="app-search hidden-xs" onsubmit="return false;" style="position:relative;">
                                <input type="text" placeholder="🔍 Search students, pages..." class="form-control" id="globalSearchInput" autocomplete="off" onkeyup="globalSearch(this.value)" onfocus="this.select()" style="width:280px; border-radius:20px; padding-left:15px; font-size:13px;">
                                <a href="javascript:void(0)"><i class="fa fa-search"></i></a>
                                <div id="searchResults" style="display:none; position:absolute; top:46px; left:0; width:400px; background:#fff; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.18); z-index:9999; max-height:380px; overflow-y:auto;"></div>
                            </form>
                        </li>

                        <!-- QUICK SHORTCUTS -->
                        <li><a href="<?php echo base_url();?>admin/new_student" title="New Admission" style="color:#fff; padding:15px 7px;"><i class="fa fa-user-plus"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/student_payment" title="Fee Collection" style="color:#fff; padding:15px 7px;"><i class="fa fa-money"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/manage_attendance/<?php echo date('d/m/Y');?>" title="Attendance" style="color:#fff; padding:15px 7px;"><i class="fa fa-calendar-check-o"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/student_marksheet_subject" title="Marks Entry" style="color:#fff; padding:15px 7px;"><i class="fa fa-pencil-square-o"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/noticeboard" title="Noticeboard" style="color:#fff; padding:15px 7px;"><i class="fa fa-bullhorn"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/student_invoice" title="Invoices" style="color:#fff; padding:15px 7px;"><i class="fa fa-file-text-o"></i></a></li>
                    </ul>

                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a href="<?php echo base_url();?>login/logout" class="waves-effect" title="Logout"><i class="fa fa-power-off"></i></a>
                    </li>
                    <li class="right-side-toggle"> <a class="" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                </ul>
            </div>
        </nav>

<!-- GLOBAL SEARCH SCRIPT -->
<script>
var _searchPages = [
    {t:'Dashboard', u:'admin/dashboard', i:'fa-dashboard', c:'Pages'},
    {t:'New Admission', u:'admin/new_student', i:'fa-user-plus', c:'Admission'},
    {t:'Student Information', u:'admin/student_information', i:'fa-users', c:'Students'},
    {t:'Student Certificates', u:'admin/student_certificates', i:'fa-certificate', c:'Students'},
    {t:'Fee Collection', u:'admin/student_payment', i:'fa-money', c:'Finance'},
    {t:'Invoices', u:'admin/student_invoice', i:'fa-file-text-o', c:'Finance'},
    {t:'Payroll', u:'admin/payroll', i:'fa-briefcase', c:'HR'},
    {t:'Teachers', u:'admin/teacher', i:'fa-user-secret', c:'HR'},
    {t:'Staff', u:'admin/staff', i:'fa-users', c:'HR'},
    {t:'Attendance', u:'admin/manage_attendance/<?php echo date("d/m/Y");?>', i:'fa-calendar-check-o', c:'Academic'},
    {t:'Attendance Report', u:'admin/attendance_report', i:'fa-bar-chart', c:'Academic'},
    {t:'Marks Entry', u:'admin/student_marksheet_subject', i:'fa-pencil-square-o', c:'Academic'},
    {t:'Create Exam', u:'admin/createExamination', i:'fa-file-text', c:'Academic'},
    {t:'Exam Questions', u:'admin/examQuestion', i:'fa-question', c:'Academic'},
    {t:'Report Cards', u:'admin/marksheet_view', i:'fa-id-card', c:'Academic'},
    {t:'Co-Scholastic', u:'admin/co_scholastic', i:'fa-star', c:'Academic'},
    {t:'Classes', u:'admin/classes', i:'fa-book', c:'Academic'},
    {t:'Sections', u:'admin/section', i:'fa-th-large', c:'Academic'},
    {t:'Promotion', u:'admin/student_promotion', i:'fa-arrow-up', c:'Academic'},
    {t:'Noticeboard', u:'admin/noticeboard', i:'fa-bullhorn', c:'Communication'},
    {t:'Circular', u:'admin/circular', i:'fa-newspaper-o', c:'Communication'},
    {t:'Enquiry', u:'admin/list_enquiry', i:'fa-question-circle', c:'Admission'},
    {t:'Enquiry Category', u:'admin/enquiry_category', i:'fa-list', c:'Admission'},
    {t:'Parents', u:'admin/parent', i:'fa-users', c:'People'},
    {t:'Alumni', u:'admin/alumni', i:'fa-graduation-cap', c:'Students'},
    {t:'Library', u:'admin/library', i:'fa-book', c:'Library'},
    {t:'Hostel', u:'admin/dormitory', i:'fa-building', c:'Hostel'},
    {t:'Hostel Rooms', u:'admin/hostel_room', i:'fa-bed', c:'Hostel'},
    {t:'ID Card Generator', u:'admin/id_card_generator', i:'fa-id-badge', c:'Documents'},
    {t:'Leave Management', u:'admin/leave_management', i:'fa-calendar-times-o', c:'HR'},
    {t:'System Settings', u:'admin/manage_profile', i:'fa-cogs', c:'System'},
    {t:'User Management', u:'admin/manage_users', i:'fa-user-circle', c:'System'},
    {t:'Audit Logs', u:'admin/audit_logs', i:'fa-history', c:'System'}
];
var _sDebounce = null;
function globalSearch(q) {
    clearTimeout(_sDebounce);
    var box = document.getElementById('searchResults');
    if (!q || q.length < 2) { box.style.display = 'none'; return; }
    _sDebounce = setTimeout(function() {
        var html = '', ql = q.toLowerCase();
        var pm = _searchPages.filter(function(p) { return p.t.toLowerCase().indexOf(ql) >= 0 || p.c.toLowerCase().indexOf(ql) >= 0; });
        if (pm.length > 0) {
            html += '<div style="padding:8px 14px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc;">📄 Pages & Features</div>';
            pm.slice(0, 8).forEach(function(p) {
                html += '<a href="<?php echo base_url();?>' + p.u + '" style="display:flex;align-items:center;padding:10px 14px;text-decoration:none;color:#1a1a2e;border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background=\'#f0f4ff\'" onmouseout="this.style.background=\'#fff\'">'
                    + '<i class="fa ' + p.i + '" style="width:28px;height:28px;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;margin-right:10px;"></i>'
                    + '<div><div style="font-weight:600;font-size:13px;">' + p.t + '</div><div style="font-size:10px;color:#94a3b8;">' + p.c + '</div></div></a>';
            });
        }
        $.ajax({
            url: '<?php echo base_url();?>admin/search_students_ajax', data: {q: q}, dataType: 'json',
            success: function(students) {
                if (students && students.length > 0) {
                    html += '<div style="padding:8px 14px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;background:#f8fafc;">👨‍🎓 Students</div>';
                    students.slice(0, 5).forEach(function(s) {
                        html += '<a href="<?php echo base_url();?>admin/student_information" style="display:flex;align-items:center;padding:10px 14px;text-decoration:none;color:#1a1a2e;border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background=\'#f0fff4\'" onmouseout="this.style.background=\'#fff\'">'
                            + '<div style="width:28px;height:28px;background:#16a34a;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin-right:10px;">' + (s.name ? s.name[0] : '?') + '</div>'
                            + '<div><div style="font-weight:600;font-size:13px;">' + s.name + '</div><div style="font-size:10px;color:#94a3b8;">' + (s.admission_no || '') + ' • ' + (s.phone || '') + '</div></div></a>';
                    });
                }
                box.innerHTML = html || '<div style="padding:20px;text-align:center;color:#94a3b8;font-size:13px;">No results found</div>';
                box.style.display = 'block';
            },
            error: function() {
                box.innerHTML = html || '<div style="padding:20px;text-align:center;color:#94a3b8;">No results found</div>';
                if (html) box.style.display = 'block';
            }
        });
    }, 300);
}
document.addEventListener('click', function(e) { if (!e.target.closest('.app-search')) document.getElementById('searchResults').style.display = 'none'; });
</script>