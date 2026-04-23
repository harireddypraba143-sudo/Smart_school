 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="#"><b><img src="<?php echo base_url();?>uploads/logo.png" width="50" height="50" alt="home" /></b><span class="hidden-xs" style="color:white; font-size:18px; font-weight:700; vertical-align:middle; margin-left:10px;"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></span></a></div>
                    <ul class="nav navbar-top-links navbar-left hidden-xs">
                        <li><a href="javascript:void(0)" class="open-close hidden-xs "><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                        <li>
                            <!-- GLOBAL SEARCH BAR -->
                            <form role="search" class="app-search hidden-xs" onsubmit="return false;" style="position:relative;">
                            <input type="text" placeholder="🔍 Search students, pages, features..." class="form-control" id="globalSearchInput" autocomplete="off" onkeyup="globalSearch(this.value)" style="width:320px; border-radius:20px; padding-left:16px; font-size:13px;">
                            <a href="javascript:void(0)"><i class="fa fa-search"></i></a>
                            <div id="searchResults" style="display:none; position:absolute; top:100%; left:0; width:420px; background:#fff; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.15); z-index:9999; max-height:400px; overflow-y:auto; margin-top:4px;"></div>
                            </form>
                        </li>
                    </ul>

                    <!-- QUICK SHORTCUTS -->
                    <ul class="nav navbar-top-links navbar-left hidden-xs" style="margin-left:8px;">
                        <li><a href="<?php echo base_url();?>admin/new_student" title="New Admission" style="color:#fff; font-size:13px; padding:15px 8px;"><i class="fa fa-user-plus"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/fee_collection" title="Fee Collection" style="color:#fff; font-size:13px; padding:15px 8px;"><i class="fa fa-money"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/student_attendance" title="Attendance" style="color:#fff; font-size:13px; padding:15px 8px;"><i class="fa fa-calendar-check-o"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/manage_marks" title="Marks Entry" style="color:#fff; font-size:13px; padding:15px 8px;"><i class="fa fa-pencil-square-o"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/sms" title="Send SMS" style="color:#fff; font-size:13px; padding:15px 8px;"><i class="fa fa-envelope"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/payment" title="Online Payments" style="color:#fff; font-size:13px; padding:15px 8px;"><i class="fa fa-credit-card"></i></a></li>
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
var searchPages = [
    {title:'Dashboard', url:'admin/dashboard', icon:'fa-dashboard', cat:'Pages'},
    {title:'New Admission', url:'admin/new_student', icon:'fa-user-plus', cat:'Admission'},
    {title:'Student List', url:'admin/manage_students', icon:'fa-users', cat:'Students'},
    {title:'Fee Collection', url:'admin/fee_collection', icon:'fa-money', cat:'Finance'},
    {title:'Fee Structure', url:'admin/fee_structure', icon:'fa-list-alt', cat:'Finance'},
    {title:'Online Payments', url:'admin/payment', icon:'fa-credit-card', cat:'Finance'},
    {title:'Income', url:'admin/income', icon:'fa-plus-circle', cat:'Finance'},
    {title:'Expense', url:'admin/expense', icon:'fa-minus-circle', cat:'Finance'},
    {title:'Payroll', url:'admin/payroll', icon:'fa-briefcase', cat:'HR'},
    {title:'Staff Management', url:'admin/manage_teachers', icon:'fa-user-secret', cat:'HR'},
    {title:'Attendance', url:'admin/student_attendance', icon:'fa-calendar-check-o', cat:'Academic'},
    {title:'Marks Entry', url:'admin/manage_marks', icon:'fa-pencil-square-o', cat:'Academic'},
    {title:'Exam List', url:'admin/manage_exam', icon:'fa-file-text', cat:'Academic'},
    {title:'Report Cards', url:'admin/report_card', icon:'fa-id-card', cat:'Academic'},
    {title:'Class Management', url:'admin/manage_class', icon:'fa-book', cat:'Academic'},
    {title:'Subject Management', url:'admin/manage_subject', icon:'fa-bookmark', cat:'Academic'},
    {title:'Send SMS', url:'admin/sms', icon:'fa-envelope', cat:'Communication'},
    {title:'Noticeboard', url:'admin/noticeboard', icon:'fa-bullhorn', cat:'Communication'},
    {title:'Settings', url:'admin/system_settings', icon:'fa-cogs', cat:'System'},
    {title:'Alumni', url:'admin/alumni', icon:'fa-graduation-cap', cat:'Students'},
    {title:'Transport', url:'admin/transport', icon:'fa-bus', cat:'Transport'},
    {title:'Library', url:'admin/library', icon:'fa-book', cat:'Library'},
    {title:'Hostel', url:'admin/hostel', icon:'fa-building', cat:'Hostel'},
    {title:'Enquiry', url:'admin/enquiry', icon:'fa-question-circle', cat:'Admission'},
    {title:'Promotion', url:'admin/promotion', icon:'fa-arrow-up', cat:'Academic'},
    {title:'Certificate', url:'admin/certificate', icon:'fa-certificate', cat:'Documents'},
    {title:'ID Card', url:'admin/id_card', icon:'fa-id-badge', cat:'Documents'}
];
var searchDebounce = null;
function globalSearch(q) {
    clearTimeout(searchDebounce);
    var box = document.getElementById('searchResults');
    if (!q || q.length < 2) { box.style.display = 'none'; return; }
    searchDebounce = setTimeout(function() {
        var html = '';
        var ql = q.toLowerCase();
        var pageMatches = searchPages.filter(function(p) { return p.title.toLowerCase().indexOf(ql) >= 0 || p.cat.toLowerCase().indexOf(ql) >= 0; });
        if (pageMatches.length > 0) {
            html += '<div style="padding:8px 14px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; background:#f8fafc;">📄 Pages & Features</div>';
            pageMatches.slice(0, 8).forEach(function(p) {
                html += '<a href="<?php echo base_url();?>' + p.url + '" style="display:flex; align-items:center; padding:10px 14px; text-decoration:none; color:#1a1a2e; border-bottom:1px solid #f1f5f9;"'
                    + ' onmouseover="this.style.background=\'#f0f4ff\'" onmouseout="this.style.background=\'#fff\'">'
                    + '<i class="fa ' + p.icon + '" style="width:28px; height:28px; background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; margin-right:10px;"></i>'
                    + '<div><div style="font-weight:600; font-size:13px;">' + p.title + '</div><div style="font-size:10px; color:#94a3b8;">' + p.cat + '</div></div></a>';
            });
        }
        // Search students via AJAX
        $.ajax({
            url: '<?php echo base_url();?>admin/search_students_ajax',
            data: {q: q}, dataType: 'json',
            success: function(students) {
                if (students && students.length > 0) {
                    html += '<div style="padding:8px 14px; font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; background:#f8fafc;">👨‍🎓 Students</div>';
                    students.slice(0, 5).forEach(function(s) {
                        html += '<a href="<?php echo base_url();?>admin/manage_students" style="display:flex; align-items:center; padding:10px 14px; text-decoration:none; color:#1a1a2e; border-bottom:1px solid #f1f5f9;"'
                            + ' onmouseover="this.style.background=\'#f0fff4\'" onmouseout="this.style.background=\'#fff\'">'
                            + '<div style="width:28px;height:28px;background:#16a34a;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin-right:10px;">' + (s.name ? s.name[0] : '?') + '</div>'
                            + '<div><div style="font-weight:600;font-size:13px;">' + s.name + '</div><div style="font-size:10px;color:#94a3b8;">' + (s.admission_no || '') + ' • ' + (s.phone || '') + '</div></div></a>';
                    });
                }
                box.innerHTML = html || '<div style="padding:20px; text-align:center; color:#94a3b8;">No results found</div>';
                box.style.display = 'block';
            },
            error: function() {
                box.innerHTML = html || '<div style="padding:20px; text-align:center; color:#94a3b8;">No results found</div>';
                box.style.display = 'block';
            }
        });
    }, 300);
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.app-search')) document.getElementById('searchResults').style.display = 'none';
});
</script>