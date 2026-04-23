<!-- Modern Header -->
<style>
.top-header-bar {
    background: #fff;
    border-bottom: 1px solid #e8ecf1;
    padding: 0 20px;
    display: flex;
    align-items: center;
    height: 64px;
    box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    position: sticky;
    top: 0;
    z-index: 999;
}
.hdr-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 200px;
    border-right: 1px solid #e8ecf1;
    padding-right: 20px;
    margin-right: 10px;
}
.hdr-brand img { width: 38px; height: 38px; border-radius: 10px; }
.hdr-brand .name { font-weight: 700; font-size: 15px; color: #1a1a2e; line-height: 1.2; }
.hdr-brand .sub { font-size: 11px; color: #94a3b8; font-weight: 400; }
.hdr-shortcuts {
    display: flex;
    align-items: center;
    gap: 2px;
    flex: 1;
}
.hdr-shortcuts a {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 8px 14px;
    text-decoration: none;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.2s;
    position: relative;
    gap: 3px;
}
.hdr-shortcuts a i {
    font-size: 18px;
    line-height: 1;
}
.hdr-shortcuts a:hover {
    background: #f0f4ff;
    color: #4f6af5;
}
.hdr-shortcuts a.active {
    color: #4f6af5;
}
.hdr-shortcuts a.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 3px;
    background: #4f6af5;
    border-radius: 3px;
}
.hdr-right {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-left: auto;
}
.hdr-search {
    display: flex;
    align-items: center;
    background: #f4f6fa;
    border-radius: 10px;
    padding: 0 14px;
    height: 38px;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid transparent;
    margin-right: 8px;
}
.hdr-search:hover { border-color: #4f6af5; background: #fff; }
.hdr-search i { color: #94a3b8; font-size: 14px; margin-right: 8px; }
.hdr-search span { color: #94a3b8; font-size: 13px; font-weight: 500; }
.hdr-search kbd { background: #e2e8f0; color: #64748b; font-size: 10px; padding: 2px 6px; border-radius: 4px; margin-left: 16px; font-family: inherit; }
.hdr-icon-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    background: transparent;
    border: none;
    position: relative;
}
.hdr-icon-btn:hover { background: #f0f4ff; color: #4f6af5; }
.hdr-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 8px;
    height: 8px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid #fff;
}
.hdr-admin {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 10px 4px 4px;
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.2s;
    margin-left: 6px;
    text-decoration: none;
}
.hdr-admin:hover { background: #f4f6fa; }
.hdr-admin-avatar {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4f6af5, #7c3aed);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 14px;
}
.hdr-admin-info .name { font-size: 13px; font-weight: 600; color: #1a1a2e; line-height: 1.2; }
.hdr-admin-info .role { font-size: 10px; color: #94a3b8; }

/* Hide old navbar */
.navbar.navbar-default { display: none !important; }

/* Fix page wrapper margin */
@media (min-width: 768px) {
    .top-header-bar { margin-left: 240px; }
}
@media (max-width: 767px) {
    .hdr-shortcuts { display: none; }
    .hdr-brand .name { font-size: 13px; }
    .hdr-brand { min-width: auto; border: none; padding-right: 10px; }
    .hdr-search span, .hdr-search kbd { display: none; }
}
</style>

<?php
    $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
    $admin_name = $this->session->userdata('name') ?: 'Admin';
    $active_page = $this->uri->segment(2);
?>

<!-- Original navbar (hidden by CSS, needed for sidebar toggle) -->
<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg" href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
        <div class="top-left-part"><a class="logo" href="#"><b><img src="<?php echo base_url();?>uploads/logo.png" width="50" height="50" alt="home" /></b><span class="hidden-xs" style="color:white; font-size:18px; font-weight:700; vertical-align:middle; margin-left:10px;"><?php echo $sys_name; ?></span></a></div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li><a href="javascript:void(0)" class="open-close hidden-xs"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
            <li><a href="<?php echo base_url();?>login/logout" class="waves-effect" title="Logout"><i class="fa fa-power-off"></i></a></li>
            <li class="right-side-toggle"><a href="javascript:void(0)"><i class="ti-settings"></i></a></li>
        </ul>
    </div>
</nav>

<!-- NEW MODERN HEADER -->
<div class="top-header-bar">
    <!-- Brand -->
    <div class="hdr-brand">
        <img src="<?php echo base_url();?>uploads/logo.png" alt="Logo">
        <div>
            <div class="name"><?php echo $sys_name; ?></div>
            <div class="sub">Smart School Management</div>
        </div>
    </div>

    <!-- Shortcuts -->
    <div class="hdr-shortcuts">
        <a href="<?php echo base_url();?>admin/student_information" class="<?php echo in_array($active_page, ['student_information','new_student','edit_student']) ? 'active' : ''; ?>" title="Students">
            <i class="fa fa-users"></i>
            <span>Students</span>
        </a>
        <a href="<?php echo base_url();?>admin/student_payment" class="<?php echo in_array($active_page, ['student_payment','student_invoice']) ? 'active' : ''; ?>" title="Fees">
            <i class="fa fa-inr"></i>
            <span>Fees</span>
        </a>
        <a href="<?php echo base_url();?>admin/manage_attendance/<?php echo date('d/m/Y');?>" class="<?php echo in_array($active_page, ['manage_attendance','attendance_report']) ? 'active' : ''; ?>" title="Attendance">
            <i class="fa fa-calendar-check-o"></i>
            <span>Attendance</span>
        </a>
        <a href="<?php echo base_url();?>admin/createExamination" class="<?php echo in_array($active_page, ['createExamination','examQuestion','student_marksheet_subject']) ? 'active' : ''; ?>" title="Exams">
            <i class="fa fa-file-text-o"></i>
            <span>Exams</span>
        </a>
        <a href="<?php echo base_url();?>admin/noticeboard" class="<?php echo in_array($active_page, ['noticeboard','circular']) ? 'active' : ''; ?>" title="Messages">
            <i class="fa fa-bell-o"></i>
            <span>Messages</span>
        </a>
        <a href="<?php echo base_url();?>admin/marksheet_view" class="<?php echo in_array($active_page, ['marksheet_view','co_scholastic','marks']) ? 'active' : ''; ?>" title="Reports">
            <i class="fa fa-bar-chart"></i>
            <span>Reports</span>
        </a>
        <a href="<?php echo base_url();?>admin/student_certificates" class="<?php echo in_array($active_page, ['student_certificates','id_card_generator']) ? 'active' : ''; ?>" title="Documents">
            <i class="fa fa-folder-open-o"></i>
            <span>Documents</span>
        </a>
    </div>

    <!-- Right Side -->
    <div class="hdr-right">
        <!-- Search -->
        <div class="hdr-search" onclick="toggleGlobalSearch()">
            <i class="fa fa-search"></i>
            <span>Search...</span>
            <kbd>⌘K</kbd>
        </div>

        <!-- Notification -->
        <a href="<?php echo base_url();?>admin/noticeboard" class="hdr-icon-btn" title="Notifications">
            <i class="fa fa-bell-o"></i>
            <span class="hdr-badge"></span>
        </a>

        <!-- Settings -->
        <a href="<?php echo base_url();?>admin/manage_profile" class="hdr-icon-btn" title="Settings">
            <i class="fa fa-cog"></i>
        </a>

        <!-- Admin Profile -->
        <a href="<?php echo base_url();?>admin/manage_profile" class="hdr-admin">
            <div class="hdr-admin-avatar"><?php echo strtoupper(substr($admin_name, 0, 1)); ?></div>
            <div class="hdr-admin-info hidden-xs">
                <div class="name"><?php echo $admin_name; ?></div>
                <div class="role">Super Admin</div>
            </div>
            <i class="fa fa-chevron-down" style="font-size:10px; color:#94a3b8; margin-left:2px;"></i>
        </a>
    </div>
</div>

<!-- GLOBAL SEARCH OVERLAY -->
<div id="globalSearchOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.6); z-index:99999; backdrop-filter:blur(4px);" onclick="closeGlobalSearch(event)">
    <div style="max-width:560px; margin:80px auto 0; padding:0 16px;">
        <div style="background:#fff; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.25); overflow:hidden;">
            <div style="display:flex; align-items:center; padding:14px 18px; border-bottom:1px solid #f1f5f9;">
                <i class="fa fa-search" style="font-size:17px; color:#94a3b8; margin-right:12px;"></i>
                <input type="text" id="globalSearchInput" placeholder="Search students, pages, features..." autocomplete="off" onkeyup="globalSearch(this.value)"
                    style="border:none; outline:none; font-size:15px; font-weight:500; width:100%; color:#1a1a2e; font-family:inherit;">
                <span onclick="closeGlobalSearch()" style="cursor:pointer; color:#64748b; font-size:11px; padding:3px 8px; background:#f1f5f9; border-radius:5px; font-weight:600;">ESC</span>
            </div>
            <div id="searchResults" style="max-height:400px; overflow-y:auto;">
                <div style="padding:16px; text-align:center; color:#94a3b8; font-size:13px;">Type to search students, pages, features...</div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleGlobalSearch() {
    var ov = document.getElementById('globalSearchOverlay');
    ov.style.display = ov.style.display === 'none' ? 'block' : 'none';
    if (ov.style.display === 'block') setTimeout(function() { document.getElementById('globalSearchInput').focus(); }, 100);
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
    {t:'Dashboard',u:'admin/dashboard',i:'fa-dashboard',c:'Pages'},
    {t:'New Admission',u:'admin/new_student',i:'fa-user-plus',c:'Admission'},
    {t:'Student Information',u:'admin/student_information',i:'fa-users',c:'Students'},
    {t:'Student Certificates',u:'admin/student_certificates',i:'fa-certificate',c:'Students'},
    {t:'Fee Collection',u:'admin/student_payment',i:'fa-inr',c:'Finance'},
    {t:'Invoices',u:'admin/student_invoice',i:'fa-file-text-o',c:'Finance'},
    {t:'Payroll',u:'admin/payroll',i:'fa-briefcase',c:'HR'},
    {t:'Teachers',u:'admin/teacher',i:'fa-user-secret',c:'HR'},
    {t:'Staff',u:'admin/staff',i:'fa-users',c:'HR'},
    {t:'Attendance',u:'admin/manage_attendance/<?php echo date("d/m/Y");?>',i:'fa-calendar-check-o',c:'Academic'},
    {t:'Attendance Report',u:'admin/attendance_report',i:'fa-bar-chart',c:'Academic'},
    {t:'Marks Entry',u:'admin/student_marksheet_subject',i:'fa-pencil-square-o',c:'Academic'},
    {t:'Create Exam',u:'admin/createExamination',i:'fa-file-text',c:'Exam'},
    {t:'Report Cards',u:'admin/marksheet_view',i:'fa-id-card',c:'Academic'},
    {t:'Co-Scholastic',u:'admin/co_scholastic',i:'fa-star',c:'Academic'},
    {t:'Classes',u:'admin/classes',i:'fa-book',c:'Academic'},
    {t:'Sections',u:'admin/section',i:'fa-th-large',c:'Academic'},
    {t:'Promotion',u:'admin/student_promotion',i:'fa-arrow-up',c:'Academic'},
    {t:'Noticeboard',u:'admin/noticeboard',i:'fa-bullhorn',c:'Communication'},
    {t:'Circular',u:'admin/circular',i:'fa-newspaper-o',c:'Communication'},
    {t:'Enquiry',u:'admin/list_enquiry',i:'fa-question-circle',c:'Admission'},
    {t:'Parents',u:'admin/parent',i:'fa-users',c:'People'},
    {t:'Alumni',u:'admin/alumni',i:'fa-graduation-cap',c:'Students'},
    {t:'Library',u:'admin/library',i:'fa-book',c:'Library'},
    {t:'Hostel',u:'admin/dormitory',i:'fa-building',c:'Hostel'},
    {t:'ID Card',u:'admin/id_card_generator',i:'fa-id-badge',c:'Documents'},
    {t:'Leave Management',u:'admin/leave_management',i:'fa-calendar-times-o',c:'HR'},
    {t:'Profile',u:'admin/manage_profile',i:'fa-cogs',c:'System'},
    {t:'Users',u:'admin/manage_users',i:'fa-user-circle',c:'System'}
];
var _sd=null;
function globalSearch(q) {
    clearTimeout(_sd);
    var box=document.getElementById('searchResults');
    if(!q||q.length<1){box.innerHTML='<div style="padding:16px;text-align:center;color:#94a3b8;font-size:13px;">Type to search...</div>';return;}
    _sd=setTimeout(function(){
        var html='',ql=q.toLowerCase();
        var pm=_sp.filter(function(p){return p.t.toLowerCase().indexOf(ql)>=0||p.c.toLowerCase().indexOf(ql)>=0;});
        if(pm.length>0){
            html+='<div style="padding:8px 18px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;">Pages & Features</div>';
            pm.slice(0,8).forEach(function(p){
                html+='<a href="<?php echo base_url();?>'+p.u+'" style="display:flex;align-items:center;padding:10px 18px;text-decoration:none;color:#1a1a2e;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background=\'#f0f4ff\'" onmouseout="this.style.background=\'#fff\'">'
                +'<div style="width:32px;height:32px;background:linear-gradient(135deg,#4f6af5,#7c3aed);color:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:13px;margin-right:12px;flex-shrink:0;"><i class="fa '+p.i+'"></i></div>'
                +'<div style="flex:1;"><div style="font-weight:600;font-size:14px;">'+p.t+'</div><div style="font-size:11px;color:#94a3b8;">'+p.c+'</div></div>'
                +'<i class="fa fa-arrow-right" style="color:#cbd5e1;font-size:11px;"></i></a>';
            });
        }
        $.ajax({url:'<?php echo base_url();?>admin/search_students_ajax',data:{q:q},dataType:'json',
            success:function(students){
                if(students&&students.length>0){
                    html+='<div style="padding:8px 18px;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;">Students</div>';
                    students.slice(0,5).forEach(function(s){
                        html+='<a href="<?php echo base_url();?>admin/student_information" style="display:flex;align-items:center;padding:10px 18px;text-decoration:none;color:#1a1a2e;border-bottom:1px solid #f8fafc;" onmouseover="this.style.background=\'#f0fff4\'" onmouseout="this.style.background=\'#fff\'">'
                        +'<div style="width:32px;height:32px;background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;margin-right:12px;">'+((s.name||'?')[0].toUpperCase())+'</div>'
                        +'<div style="flex:1;"><div style="font-weight:600;font-size:14px;">'+s.name+'</div><div style="font-size:11px;color:#94a3b8;">'+(s.admission_no||'')+(s.phone?' • '+s.phone:'')+'</div></div></a>';
                    });
                }
                if(!html) html='<div style="padding:24px;text-align:center;color:#94a3b8;">No results for "'+q+'"</div>';
                box.innerHTML=html;
            },
            error:function(){if(!html)html='<div style="padding:24px;text-align:center;color:#94a3b8;">No results found</div>';box.innerHTML=html;}
        });
    },250);
}
</script>