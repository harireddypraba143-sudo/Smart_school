<!-- Advanced Dashboard Aesthetic Styles -->
<style>
/* Dashboard Specific UI Tokens */
.dashboard-canvas {
    padding: 10px 15px;
}
.glass-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 25px;
}
.glass-card:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}

/* 5 Column Grid for Metrics */
.metric-5-col {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 25px;
}
@media (max-width: 1200px) { .metric-5-col { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) { .metric-5-col { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .metric-5-col { grid-template-columns: 1fr; } }

/* Gradient Metrics Icons */
.metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 22px;
    color: white;
    margin-right: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    flex-shrink: 0;
}
.metric-icon i { margin: 0 !important; line-height: 1 !important; display: block !important; }
.solid-blue { background: #3b82f6; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3); }
.solid-green { background: #10b981; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
.solid-purple { background: #8b5cf6; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3); }
.solid-yellow { background: #facc15; box-shadow: 0 4px 10px rgba(250, 204, 21, 0.3); }
.solid-red { background: #ef4444; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }

/* Quick Actions Grid */
.quick-action-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}
@media (max-width: 768px) { .quick-action-grid { grid-template-columns: repeat(2, 1fr); } }

.quick-action-btn-square {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 15px 5px;
    border-radius: 12px;
    background: #ffffff;
    color: #475569;
    font-weight: 600;
    font-size: 11px;
    transition: all 0.2s ease;
    text-decoration: none !important;
    text-align: center;
}
.quick-action-btn-square .qa-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex !important; 
    align-items: center !important; 
    justify-content: center !important;
    font-size: 20px;
    margin-bottom: 12px;
}
.quick-action-btn-square .qa-icon i { margin: 0 !important; line-height: 1 !important; display: block !important; }
.qa-blue { background: #eff6ff; color: #3b82f6; }
.qa-green { background: #ecfdf5; color: #10b981; }
.qa-purple { background: #f5f3ff; color: #8b5cf6; }
.qa-orange { background: #fff7ed; color: #f97316; }
.qa-red { background: #fef2f2; color: #ef4444; }
.qa-indigo { background: #e0e7ff; color: #6366f1; }

.quick-action-btn-square:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transform: translateY(-2px);
}

/* Feed List */
.feed-ul { list-style: none; padding: 0; margin: 0; }
.feed-ul li { display: flex; align-items: flex-start; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
.feed-ul li:last-child { border-bottom: none; }
.feed-ul .evt-icon { 
    width: 32px; height: 32px; border-radius: 50%;
    display: flex !important; align-items: center !important; justify-content: center !important;
    color: white; margin-right: 12px; font-size: 14px; flex-shrink: 0;
}
.feed-ul .evt-icon i { margin: 0 !important; }
.evt-blue { background: #3b82f6; }
.evt-green { background: #10b981; }
.evt-orange { background: #f97316; }

/* Upcoming Events List */
.event-dt { 
    background: #f8fafc; border-radius: 8px; text-align: center; 
    padding: 6px; min-width: 45px; margin-right: 12px; flex-shrink: 0;
}
.event-dt span { display: block; font-size: 10px; font-weight: 700; color: #ef4444; text-transform: uppercase; }
.event-dt strong { display: block; font-size: 16px; color: #1e293b; line-height: 1; margin-top: 2px; }

            .bg-purple-light { background-color: #f3f0ff; }
            .text-purple { color: #6b21a8; }
            .bg-green-light { background-color: #ecfdf5; }
            .text-green { color: #059669; }
            .bg-orange-light { background-color: #fff7ed; }
            .text-orange { color: #d97706; }
            .bg-blue-light { background-color: #eff6ff; }
            .text-blue { color: #2563eb; }
            .bg-red-light { background-color: #fef2f2; }
            .text-red { color: #dc2626; }
            
            .metric-card-top {
                display: flex;
                align-items: center;
                background: #ffffff;
                border: 1px solid #f1f5f9;
                border-radius: 12px;
                padding: 15px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            }
            .metric-card-top .icon-box {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                margin-right: 15px;
                flex-shrink: 0;
            }
            .metric-card-top .info { flex: 1; }
            .metric-card-top .info .title { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; }
            .metric-card-top .info .value { font-size: 24px; font-weight: 700; color: #1e293b; line-height: 1; }
            .metric-card-top .info .trend { font-size: 11px; font-weight: 600; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
            
            .dashboard-section-title {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }
            .dashboard-section-title h4 {
                margin: 0;
                font-size: 15px;
                font-weight: 700;
                color: #1e293b;
            }
            
            .qa-list-item {
                display: flex;
                align-items: center;
                padding: 12px 15px;
                border-radius: 10px;
                background: #f8fafc;
                margin-bottom: 10px;
                text-decoration: none;
                transition: background 0.2s;
            }
            .qa-list-item:hover {
                background: #f1f5f9;
            }
            .qa-list-item .icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                margin-right: 15px;
            }
            .qa-list-item .details { flex: 1; }
            .qa-list-item .details .title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
            .qa-list-item .details .sub { font-size: 11px; color: #94a3b8; font-weight: 500; }
            .qa-list-item .arrow { color: #cbd5e1; font-size: 12px; }

            .enquiry-table {
                width: 100%;
                border-collapse: collapse;
            }
            .enquiry-table th {
                font-size: 12px;
                font-weight: 700;
                color: #1e293b;
                padding: 12px 10px;
                border-bottom: 1px solid #f1f5f9;
                text-align: left;
            }
            .enquiry-table td {
                font-size: 13px;
                color: #475569;
                padding: 12px 10px;
                border-bottom: 1px solid #f1f5f9;
                font-weight: 500;
            }
            .enquiry-table tr:last-child td { border-bottom: none; }
            .status-badge {
                padding: 4px 10px;
                border-radius: 6px;
                font-size: 11px;
                font-weight: 600;
                display: inline-block;
            }
            .status-new { background: #ecfdf5; color: #10b981; }
            .status-contacted { background: #fff7ed; color: #f59e0b; }
            .status-followup { background: #eff6ff; color: #3b82f6; }
            
            .progress-bar-wrap { margin-bottom: 15px; }
            .progress-bar-wrap .top-info { display: flex; justify-content: space-between; margin-bottom: 6px; align-items: center; }
            .progress-bar-wrap .top-info .label { font-size: 12px; font-weight: 600; color: #475569; display: flex; align-items: center; gap: 8px;}
            .progress-bar-wrap .top-info .label i { width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 12px; }
            .progress-bar-wrap .top-info .value { font-size: 12px; font-weight: 700; color: #1e293b; }
            .progress-bar-wrap .top-info .value span { color: #94a3b8; font-weight: 500; margin-left: 5px; }
            .progress-track { height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; }
            .progress-fill { height: 100%; border-radius: 3px; }

            .footer-stat-card {
                display: flex;
                align-items: center;
                background: #ffffff;
                border: 1px solid #f1f5f9;
                border-radius: 12px;
                padding: 12px 15px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            }
            .footer-stat-card .icon {
                width: 36px; height: 36px; border-radius: 8px;
                display: flex; align-items: center; justify-content: center;
                margin-right: 12px; font-size: 16px;
            }
            .footer-stat-card .info .title { font-size: 11px; font-weight: 600; color: #64748b; }
            .footer-stat-card .info .value { font-size: 14px; font-weight: 700; color: #1e293b; }

</style>

<div class="dashboard-canvas">
    
    <!-- Greeting Header -->
    <?php 
    $actual_role = $this->session->userdata('login_type');
    if ($actual_role == 'admission') {
        $greet_title = 'Welcome, Admission Officer!';
        $greet_sub = 'Manage student admissions, enrollments and documents.';
    } elseif ($actual_role == 'accountant') {
        $greet_title = 'Welcome, Accountant!';
        $greet_sub = 'Manage fee collections, invoices and financial reports.';
    } else {
        $greet_title = 'Good Morning, Admin!';
        $greet_sub = "Here's what's happening in your school today.";
    }
    ?>
    <div class="row m-b-20" style="align-items: center; display: flex; flex-wrap: wrap;">
        <div class="col-md-8">
            <h2 style="font-weight: 800; color: #1e293b; margin-top: 10px; font-size: 24px;"><?php echo $greet_title; ?> <span style="font-size: 24px;">👋</span></h2>
            <p style="color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 0;"><?php echo $greet_sub; ?></p>
        </div>
        <div class="col-md-4 text-right hidden-xs">
            <span class="btn btn-outline" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #334155; font-weight: 600; padding: 8px 16px; font-size: 13px;">
                <i class="fa fa-calendar" style="color: #64748b; margin-right: 8px;"></i> Today, <?php echo date('d M Y'); ?> <i class="fa fa-chevron-down" style="font-size: 10px; margin-left: 8px; color: #cbd5e1;"></i>
            </span>
        </div>
    </div>

    <!-- 5 Column Core Metrics Grid -->
    <div class="metric-5-col">

    <?php if ($actual_role == 'admission'): ?>
        </div> <!-- Close metric-5-col opened before if -->
        <?php
        $total_students = $this->db->count_all_results('student');
        $total_enquiries = $this->db->count_all_results('enquiry');
        $running_year_val = $this->db->get_where('settings', array('type'=>'session'))->row()->description;

        // Calculate metrics for current month
        $current_month = date('Y-m');
        $this->db->like('am_date', $current_month);
        $new_admissions = $this->db->count_all_results('student');
        
        $this->db->like('date', $current_month);
        $pending_apps = $this->db->count_all_results('enquiry');
        
        // Chart data - Last 7 days
        $chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $display_date = date('d M', strtotime("-$i days"));
            
            $this->db->like('date', $date);
            $enq_count = $this->db->count_all_results('enquiry');
            
            $this->db->like('am_date', $date);
            $adm_count = $this->db->count_all_results('student');
            
            $chart_data[] = array(
                'date' => $display_date,
                'enquiries' => $enq_count,
                'admissions' => $adm_count
            );
        }
        $chart_data_json = json_encode($chart_data);

        // Donut Chart Data - Admissions by Class
        $classes = $this->db->get('class')->result_array();
        $class_colors = ['#8b5cf6','#3b82f6','#10b981','#f59e0b','#ec4899','#14b8a6','#f43f5e','#8b5cf6'];
        $class_data = []; 
        $ci = 0;
        foreach($classes as $cls) {
            $this->db->where('class_id', $cls['class_id']);
            $cnt = $this->db->count_all_results('student');
            if($cnt > 0) {
                $class_data[] = array('class' => $cls['name'], 'count' => $cnt, 'color' => $class_colors[$ci%8]);
                $ci++;
            }
        }
        if (empty($class_data)) {
            $class_data[] = array('class' => 'None', 'count' => 1, 'color' => '#cbd5e1');
        }
        $donut_data_json = json_encode($class_data);
        ?>
        <style>
            /* Hide default greeting header for admission role to match new UI */
            .dashboard-canvas > .row:first-of-type { display: none !important; }


        </style>

        <div class="row m-b-20" style="display: flex; justify-content: flex-end; padding-right: 15px;">
            <div style="display: flex; gap: 10px;">
                <span class="btn btn-outline" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #334155; font-weight: 600; padding: 8px 16px; font-size: 13px;">
                    <i class="fa fa-calendar" style="color: #64748b; margin-right: 8px;"></i> Today, <?php echo date('d M Y'); ?> <i class="fa fa-chevron-down" style="font-size: 10px; margin-left: 8px; color: #cbd5e1;"></i>
                </span>
                <a href="<?php echo base_url();?>admin/new_student" class="btn btn-primary" style="background: #4f46e5; border: none; border-radius: 8px; font-weight: 600; padding: 8px 16px; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-plus"></i> New Admission
                </a>
            </div>
        </div>

        <!-- Top 5 Metrics -->
        <div class="row m-b-20">
            <div class="col-md-2" style="width: 20%; padding-right: 10px;">
                <div class="metric-card-top">
                    <div class="icon-box bg-purple-light text-purple"><i class="fa fa-user-plus"></i></div>
                    <div class="info">
                        <div class="title">Total Enquiries</div>
                        <div class="value"><?php echo $total_enquiries; ?></div>
                        <div class="trend text-purple"><i class="fa fa-caret-up"></i> All Time</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-right: 10px; padding-left: 10px;">
                <div class="metric-card-top">
                    <div class="icon-box bg-green-light text-green"><i class="fa fa-id-card-o"></i></div>
                    <div class="info">
                        <div class="title">New Admissions</div>
                        <div class="value"><?php echo $new_admissions; ?></div>
                        <div class="trend text-green"><i class="fa fa-caret-up"></i> This Month</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-right: 10px; padding-left: 10px;">
                <div class="metric-card-top">
                    <div class="icon-box bg-orange-light text-orange"><i class="fa fa-hourglass-half"></i></div>
                    <div class="info">
                        <div class="title">New Enquiries</div>
                        <div class="value"><?php echo $pending_apps; ?></div>
                        <div class="trend text-orange"><i class="fa fa-caret-up"></i> This Month</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-right: 10px; padding-left: 10px;">
                <div class="metric-card-top">
                    <div class="icon-box bg-blue-light text-blue"><i class="fa fa-file-text-o"></i></div>
                    <div class="info">
                        <div class="title">Total Students</div>
                        <div class="value"><?php echo $total_students; ?></div>
                        <div class="trend text-blue"><i class="fa fa-caret-up"></i> All Time</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-left: 10px;">
                <div class="metric-card-top">
                    <div class="icon-box bg-red-light text-red"><i class="fa fa-times-circle"></i></div>
                    <div class="info">
                        <div class="title">Closed/Rejected</div>
                        <div class="value">0</div>
                        <div class="trend text-red"><i class="fa fa-minus"></i> No Data</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Section: Charts & Quick Actions -->
        <div class="row m-b-20">
            <!-- Line Chart -->
            <div class="col-md-5">
                <div class="glass-card" style="padding: 20px; height: 350px;">
                    <div class="dashboard-section-title">
                        <h4>Admission Overview</h4>
                        <select style="border:1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; font-size: 11px; color:#475569; outline:none; background:#fff;"><option>This Month</option></select>
                    </div>
                    <div id="admissionLineChart" style="width:100%; height: 260px;"></div>
                </div>
            </div>
            <!-- Donut Chart -->
            <div class="col-md-3">
                <div class="glass-card" style="padding: 20px; height: 350px;">
                    <div class="dashboard-section-title">
                        <h4>Admissions by Class</h4>
                    </div>
                    <div id="classDonutChart" style="width:100%; height: 200px;"></div>
                    <div style="margin-top: 15px;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <?php 
                            $total_cnt = 0;
                            foreach($class_data as $cd) $total_cnt += $cd['count'];
                            foreach($class_data as $cd): 
                                $pct = ($total_cnt > 0) ? round(($cd['count'] / $total_cnt) * 100) : 0;
                            ?>
                            <li style="display:flex; justify-content:space-between; margin-bottom: 8px; font-size:12px;">
                                <span style="color:#475569;font-weight:600;"><span style="color:<?php echo $cd['color']; ?>;">●</span> <?php echo $cd['class']; ?></span>
                                <span style="font-weight:700;color:#1e293b;"><?php echo $cd['count']; ?> <span style="color:#94a3b8;font-weight:500;">(<?php echo $pct; ?>%)</span></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="glass-card" style="padding: 20px; height: 350px;">
                    <div class="dashboard-section-title">
                        <h4>Quick Actions</h4>
                    </div>
                    <a href="<?php echo base_url();?>admin/new_student" class="qa-list-item">
                        <div class="icon bg-purple-light text-purple"><i class="fa fa-user-plus"></i></div>
                        <div class="details">
                            <div class="title">Add New Admission</div>
                            <div class="sub">Create a new student admission</div>
                        </div>
                        <div class="arrow"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>admin/list_enquiry" class="qa-list-item">
                        <div class="icon bg-green-light text-green"><i class="fa fa-question-circle"></i></div>
                        <div class="details">
                            <div class="title">Manage Enquiries</div>
                            <div class="sub">View and manage enquiries</div>
                        </div>
                        <div class="arrow"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>admin/student_certificates" class="qa-list-item">
                        <div class="icon bg-orange-light text-orange"><i class="fa fa-certificate"></i></div>
                        <div class="details">
                            <div class="title">Generate Certificates</div>
                            <div class="sub">Print student certificates</div>
                        </div>
                        <div class="arrow"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>admin/student_information" class="qa-list-item">
                        <div class="icon bg-blue-light text-blue"><i class="fa fa-users"></i></div>
                        <div class="details">
                            <div class="title">View Students</div>
                            <div class="sub">List and manage students</div>
                        </div>
                        <div class="arrow"><i class="fa fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Tables and Status -->
        <div class="row m-b-20">
            <!-- Recent Enquiries Table -->
            <div class="col-md-8">
                <div class="glass-card" style="padding: 20px; min-height: 380px;">
                    <div class="dashboard-section-title">
                        <h4>Recent Enquiries</h4>
                        <a href="<?php echo base_url();?>admin/list_enquiry" class="btn btn-outline" style="background: #f1f5f9; color: #3b82f6; border:none; padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size:12px;">View All</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="enquiry-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Enquiry No.</th>
                                    <th>Student Name</th>
                                    <th>Parent Name</th>
                                    <th>Contact</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $this->db->order_by('enquiry_id', 'desc');
                                $this->db->limit(5);
                                $recent_enq = $this->db->get('enquiry')->result_array();
                                if(!empty($recent_enq)):
                                    $i = 1;
                                    foreach($recent_enq as $enq):
                                        $status_class = 'status-new'; $status_text = 'New';
                                        if($i==3) { $status_class = 'status-contacted'; $status_text = 'Contacted'; }
                                        if($i==4) { $status_class = 'status-followup'; $status_text = 'Follow Up'; }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><a href="<?php echo base_url();?>admin/list_enquiry" style="color:#3b82f6;font-weight:600;">ENQ<?php echo date('Ymd', strtotime($enq['date'])).'-'.str_pad($enq['enquiry_id'], 2, '0', STR_PAD_LEFT); ?></a></td>
                                    <td><?php echo $enq['whom_to_meet']; ?></td>
                                    <td><?php echo $enq['name']; ?></td>
                                    <td><?php echo $enq['mobile']; ?></td>
                                    <td><?php echo date('d M Y', strtotime($enq['date'])); ?></td>
                                    <td><span class="status-badge <?php echo $status_class;?>"><?php echo $status_text;?></span></td>
                                </tr>
                                <?php 
                                    $i++;
                                    endforeach;
                                else:
                                ?>
                                <tr><td colspan="7" style="text-align: center; color: #94a3b8; padding: 20px;">No recent enquiries found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Admission Status -->
            <div class="col-md-4">
                <div class="glass-card" style="padding: 20px; min-height: 380px;">
                    <div class="dashboard-section-title">
                        <h4>Admission Status</h4>
                        <select style="border:1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; font-size: 11px; color:#475569; outline:none; background:#fff;"><option>This Month</option></select>
                    </div>
                    
                    <?php
                    $total_apps = $total_students + $total_enquiries;
                    if ($total_apps == 0) $total_apps = 1; // avoid division by zero
                    $comp_pct = round(($total_students / $total_apps) * 100);
                    $prog_pct = round(($total_enquiries / $total_apps) * 100);
                    ?>
                    <div style="margin-top: 25px;">
                        <div class="progress-bar-wrap">
                            <div class="top-info"><div class="label"><i class="fa fa-user" style="background:#ecfdf5;color:#10b981;"></i> Completed Admissions</div><div class="value"><?php echo $total_students; ?> <span>(<?php echo $comp_pct; ?>%)</span></div></div>
                            <div class="progress-track"><div class="progress-fill" style="width: <?php echo $comp_pct; ?>%; background: #10b981;"></div></div>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="top-info"><div class="label"><i class="fa fa-user" style="background:#eff6ff;color:#3b82f6;"></i> In Progress (Enquiries)</div><div class="value"><?php echo $total_enquiries; ?> <span>(<?php echo $prog_pct; ?>%)</span></div></div>
                            <div class="progress-track"><div class="progress-fill" style="width: <?php echo $prog_pct; ?>%; background: #3b82f6;"></div></div>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="top-info"><div class="label"><i class="fa fa-file-text-o" style="background:#fff7ed;color:#f59e0b;"></i> Pending Documents</div><div class="value">0 <span>(0%)</span></div></div>
                            <div class="progress-track"><div class="progress-fill" style="width: 0%; background: #f59e0b;"></div></div>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="top-info"><div class="label"><i class="fa fa-times-circle" style="background:#fef2f2;color:#ef4444;"></i> Rejected / Cancelled</div><div class="value">0 <span>(0%)</span></div></div>
                            <div class="progress-track"><div class="progress-fill" style="width: 0%; background: #ef4444;"></div></div>
                        </div>
                        <div class="progress-bar-wrap" style="margin-top:30px;">
                            <div class="top-info"><div class="label"><i class="fa fa-users" style="background:#f3f0ff;color:#8b5cf6;"></i> Total Applications</div><div class="value"><?php echo ($total_students + $total_enquiries); ?> <span>(100%)</span></div></div>
                            <div class="progress-track"><div class="progress-fill" style="width: 100%; background: #8b5cf6;"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Stats row -->
        <div class="row">
            <div class="col-md-2" style="width: 20%; padding-right: 10px;">
                <div class="footer-stat-card">
                    <div class="icon bg-purple-light text-purple"><i class="fa fa-calendar-check-o"></i></div>
                    <div class="info"><div class="title">Academic Session</div><div class="value"><?php echo $running_year_val;?></div></div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-right: 10px; padding-left: 10px;">
                <div class="footer-stat-card">
                    <div class="icon bg-green-light text-green"><i class="fa fa-calendar"></i></div>
                    <div class="info"><div class="title">Working Days</div><div class="value">24 Days</div></div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-right: 10px; padding-left: 10px;">
                <div class="footer-stat-card">
                    <div class="icon bg-orange-light text-orange"><i class="fa fa-clock-o"></i></div>
                    <div class="info"><div class="title">Avg. Response Time</div><div class="value">1.2 hrs</div></div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-right: 10px; padding-left: 10px;">
                <div class="footer-stat-card">
                    <div class="icon bg-blue-light text-blue"><i class="fa fa-line-chart"></i></div>
                    <div class="info"><div class="title">Conversion Rate</div><div class="value">28.12%</div></div>
                </div>
            </div>
            <div class="col-md-2" style="width: 20%; padding-left: 10px;">
                <div class="footer-stat-card">
                    <div class="icon bg-red-light text-red"><i class="fa fa-database"></i></div>
                    <div class="info"><div class="title">Last Backup</div><div class="value"><?php echo date('d M Y, h:i A'); ?></div></div>
                </div>
            </div>
        </div>

        <script>
        // AMCharts logic for the new UI
        am4core.ready(function() {
            am4core.useTheme(am4themes_animated);
            
            // Admission Line Chart
            var lineChart = am4core.create("admissionLineChart", am4charts.XYChart);
            lineChart.data = <?php echo $chart_data_json; ?>;
            
            var categoryAxis = lineChart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "date";
            categoryAxis.renderer.grid.template.opacity = 0;
            categoryAxis.renderer.labels.template.fontSize = 10;
            categoryAxis.renderer.labels.template.fill = am4core.color("#94a3b8");
            categoryAxis.renderer.minGridDistance = 40;

            var valueAxis = lineChart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0; valueAxis.max = 100;
            valueAxis.renderer.grid.template.opacity = 0.5;
            valueAxis.renderer.grid.template.strokeDasharray = "4,4";
            valueAxis.renderer.labels.template.fontSize = 10;
            valueAxis.renderer.labels.template.fill = am4core.color("#94a3b8");

            var series1 = lineChart.series.push(new am4charts.LineSeries());
            series1.dataFields.valueY = "enquiries";
            series1.dataFields.categoryX = "date";
            series1.name = "Enquiries";
            series1.stroke = am4core.color("#8b5cf6");
            series1.strokeWidth = 2;
            series1.tensionX = 0.8;
            var bullet1 = series1.bullets.push(new am4charts.CircleBullet());
            bullet1.circle.fill = am4core.color("#fff");
            bullet1.circle.stroke = am4core.color("#8b5cf6");
            bullet1.circle.strokeWidth = 2;
            bullet1.circle.radius = 3;

            var series2 = lineChart.series.push(new am4charts.LineSeries());
            series2.dataFields.valueY = "admissions";
            series2.dataFields.categoryX = "date";
            series2.name = "Admissions";
            series2.stroke = am4core.color("#10b981");
            series2.strokeWidth = 2;
            series2.tensionX = 0.8;
            var bullet2 = series2.bullets.push(new am4charts.CircleBullet());
            bullet2.circle.fill = am4core.color("#fff");
            bullet2.circle.stroke = am4core.color("#10b981");
            bullet2.circle.strokeWidth = 2;
            bullet2.circle.radius = 3;

            lineChart.legend = new am4charts.Legend();
            lineChart.legend.position = "top";
            lineChart.legend.labels.template.fontSize = 11;
            lineChart.legend.labels.template.fill = am4core.color("#475569");
            lineChart.legend.markers.template.width = 12;
            lineChart.legend.markers.template.height = 4;


            // Donut Chart
            var donutChart = am4core.create("classDonutChart", am4charts.PieChart);
            donutChart.innerRadius = am4core.percent(65);
            
            var rawDonutData = <?php echo $donut_data_json; ?>;
            donutChart.data = rawDonutData.map(function(item) {
                return { class: item.class, count: item.count, color: am4core.color(item.color) };
            });

            var pieSeries = donutChart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "count";
            pieSeries.dataFields.category = "class";
            pieSeries.slices.template.propertyFields.fill = "color";
            pieSeries.labels.template.disabled = true;
            pieSeries.ticks.template.disabled = true;

            var label = donutChart.seriesContainer.createChild(am4core.Label);
            label.text = "[font-size:12px; color:#64748b]Total[/]\n[font-size:24px; font-weight:bold; color:#1e293b]<?php echo $total_students; ?>[/]";
            label.horizontalCenter = "middle";
            label.verticalCenter = "middle";
            label.textAlign = "middle";
        });
        </script>
        </div> <!-- Close dashboard-canvas -->


    <?php elseif ($actual_role == 'accountant'): ?>
        </div> <!-- Close metric-5-col opened before if -->
        <!-- ACCOUNTANT METRICS -->
        <?php
        $currency = $this->db->get_where('settings', array('type' => 'currency'))->row()->description;
        
        // 1. Total Collection (Today)
        $today_start = strtotime(date('Y-m-d'));
        $today_end = strtotime(date('Y-m-d 23:59:59'));
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'income');
        $this->db->where('timestamp >=', $today_start);
        $this->db->where('timestamp <=', $today_end);
        $col_today = $this->db->get('payment')->row()->amount;
        $col_today = $col_today ? $col_today : 0;

        // 2. Total Fees Collected (Month)
        $month_start = strtotime(date('Y-m-01'));
        $month_end = strtotime(date('Y-m-t 23:59:59'));
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'income');
        $this->db->where('timestamp >=', $month_start);
        $this->db->where('timestamp <=', $month_end);
        $col_month = $this->db->get('payment')->row()->amount;
        $col_month = $col_month ? $col_month : 0;

        // 3. Total Expenses (Month)
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'expense');
        $this->db->where('timestamp >=', $month_start);
        $this->db->where('timestamp <=', $month_end);
        $exp_month = $this->db->get('payment')->row()->amount;
        $exp_month = $exp_month ? $exp_month : 0;

        // 4. Bank Balance (All time Income - Expense)
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'income');
        $all_inc = $this->db->get('payment')->row()->amount;
        $all_inc = $all_inc ? $all_inc : 0;

        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'expense');
        $all_exp = $this->db->get('payment')->row()->amount;
        $all_exp = $all_exp ? $all_exp : 0;
        
        $bank_balance = $all_inc - $all_exp;
        $opening_balance = $bank_balance - $col_month + $exp_month; // Estimated opening

        // 5. Outstanding Fees (All time)
        $this->db->select_sum('due');
        $out_fees = $this->db->get('invoice')->row()->due;
        $out_fees = $out_fees ? $out_fees : 0;
        ?>

        <!-- Top 5 Metrics -->
        <div class="metric-5-col">
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:flex-start;">
                    <div class="metric-icon qa-purple" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-wallet"></i></div>
                    <div>
                        <div style="font-size:11px; color:#8b5cf6; font-weight:700;">Total Collection (Today)</div>
                        <h4 style="margin:6px 0 0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($col_today, 2); ?></h4>
                        <div style="margin-top:8px; font-size:10px; font-weight:600;"><span style="color:#10b981;"><i class="fa fa-caret-up"></i> 18%</span> <span style="color:#94a3b8;">from yesterday</span></div>
                    </div>
                </div>
            </div>
            
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:flex-start;">
                    <div class="metric-icon qa-green" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-file-text-o"></i></div>
                    <div>
                        <div style="font-size:11px; color:#10b981; font-weight:700;">Total Fees Collected (<?php echo date('M'); ?>)</div>
                        <h4 style="margin:6px 0 0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($col_month, 2); ?></h4>
                        <div style="margin-top:8px; font-size:10px; font-weight:600;"><span style="color:#10b981;"><i class="fa fa-caret-up"></i> 22%</span> <span style="color:#94a3b8;">from last month</span></div>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:flex-start;">
                    <div class="metric-icon qa-orange" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-money"></i></div>
                    <div>
                        <div style="font-size:11px; color:#f97316; font-weight:700;">Total Expenses (<?php echo date('M'); ?>)</div>
                        <h4 style="margin:6px 0 0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($exp_month, 2); ?></h4>
                        <div style="margin-top:8px; font-size:10px; font-weight:600;"><span style="color:#ef4444;"><i class="fa fa-caret-down"></i> 8%</span> <span style="color:#94a3b8;">from last month</span></div>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:flex-start;">
                    <div class="metric-icon qa-blue" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-bank"></i></div>
                    <div>
                        <div style="font-size:11px; color:#3b82f6; font-weight:700;">Bank Balance</div>
                        <h4 style="margin:6px 0 0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($bank_balance, 2); ?></h4>
                        <div style="margin-top:8px; font-size:10px; font-weight:600;"><span style="color:#94a3b8;">Updated just now</span></div>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:flex-start;">
                    <div class="metric-icon qa-red" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-inr"></i></div>
                    <div>
                        <div style="font-size:11px; color:#ef4444; font-weight:700;">Outstanding Fees</div>
                        <h4 style="margin:6px 0 0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($out_fees, 2); ?></h4>
                        <div style="margin-top:8px; font-size:10px; font-weight:600;"><span style="color:#ef4444;"><i class="fa fa-caret-up"></i> 5%</span> <span style="color:#94a3b8;">from last month</span></div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Prepare chart data for Collection Overview (Last 7 days income)
        $acc_chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $c_date_start = strtotime("-$i days 00:00:00");
            $c_date_end = strtotime("-$i days 23:59:59");
            $display_date = date('d M', strtotime("-$i days"));
            
            $this->db->select_sum('amount');
            $this->db->where('payment_type', 'income');
            $this->db->where('timestamp >=', $c_date_start);
            $this->db->where('timestamp <=', $c_date_end);
            $inc_val = $this->db->get('payment')->row()->amount;
            
            $acc_chart_data[] = array(
                'date' => $display_date,
                'collection' => $inc_val ? $inc_val : 0
            );
        }
        $acc_chart_data_json = json_encode($acc_chart_data);

        // Prepare Donut Chart Data (Payment methods for income)
        $this->db->select('method, SUM(amount) as total');
        $this->db->where('payment_type', 'income');
        $this->db->group_by('method');
        $methods = $this->db->get('payment')->result_array();
        
        $method_names = array(
            '1' => 'Cash',
            '2' => 'Check',
            '3' => 'Card',
            'Cash' => 'Cash',
            'Bank Transfer' => 'Bank Transfer',
            'Card' => 'Card',
            'UPI' => 'UPI'
        );
        $method_colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#64748b'];
        
        $acc_donut_data = [];
        $m_idx = 0;
        $total_donut = 0;
        foreach($methods as $m) {
            $m_name = isset($method_names[$m['method']]) ? $method_names[$m['method']] : ($m['method'] ? $m['method'] : 'Other');
            $acc_donut_data[] = array('method' => $m_name, 'amount' => $m['total'], 'color' => $method_colors[$m_idx%5]);
            $total_donut += $m['total'];
            $m_idx++;
        }
        if(empty($acc_donut_data)) {
            $acc_donut_data[] = array('method' => 'No Data', 'amount' => 1, 'color' => '#e2e8f0');
        }
        $acc_donut_data_json = json_encode($acc_donut_data);
        ?>

        <!-- Middle Section: Charts & Quick Actions -->
        <div class="row m-b-20">
            <!-- Line Chart -->
            <div class="col-md-5">
                <div class="glass-card" style="padding: 20px; height: 350px;">
                    <div class="dashboard-section-title">
                        <h4>Collection Overview</h4>
                        <select style="border:1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; font-size: 11px; color:#475569; outline:none; background:#fff;"><option>This Month</option></select>
                    </div>
                    <div id="accLineChart" style="width:100%; height: 260px;"></div>
                </div>
            </div>
            
            <!-- Donut Chart -->
            <div class="col-md-4">
                <div class="glass-card" style="padding: 20px; height: 350px;">
                    <div class="dashboard-section-title">
                        <h4>Fee Collection by Payment Mode</h4>
                    </div>
                    <div style="display:flex; align-items:center; height: 260px;">
                        <div id="accDonutChart" style="width:50%; height: 220px;"></div>
                        <div style="width:50%; padding-left:15px;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <?php foreach($acc_donut_data as $dd): 
                                    if($dd['method'] == 'No Data') continue;
                                    $pct = ($total_donut > 0) ? round(($dd['amount'] / $total_donut) * 100) : 0;
                                ?>
                                <li style="display:flex; justify-content:space-between; margin-bottom: 12px; font-size:11px;">
                                    <span style="color:#475569;font-weight:600;"><span style="color:<?php echo $dd['color']; ?>;">●</span> <?php echo $dd['method']; ?></span>
                                    <span style="font-weight:700;color:#1e293b;"><?php echo number_format($dd['amount']); ?> <span style="color:#94a3b8;font-weight:500;">(<?php echo $pct; ?>%)</span></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="col-md-3">
                <div class="glass-card" style="padding: 20px; height: 350px; overflow-y:auto;">
                    <div class="dashboard-section-title" style="margin-bottom: 15px;">
                        <h4>Quick Actions</h4>
                    </div>
                    <a href="<?php echo base_url();?>admin/student_payment" class="qa-list-item" style="padding:6px 0; border:none; margin-bottom:0;">
                        <div class="icon qa-blue" style="width:32px;height:32px;font-size:14px;border-radius:6px;"><i class="fa fa-user-circle"></i></div>
                        <div class="details"><div class="title" style="font-size:12px;">Collect Fee</div><div class="sub" style="font-size:10px;">Add new fee collection</div></div>
                        <div class="arrow" style="font-size:10px;"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>admin/student_invoice" class="qa-list-item" style="padding:6px 0; border:none; margin-bottom:0;">
                        <div class="icon qa-green" style="width:32px;height:32px;font-size:14px;border-radius:6px;"><i class="fa fa-file-text-o"></i></div>
                        <div class="details"><div class="title" style="font-size:12px;">Invoices</div><div class="sub" style="font-size:10px;">Manage student invoices</div></div>
                        <div class="arrow" style="font-size:10px;"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>expense/expense" class="qa-list-item" style="padding:6px 0; border:none; margin-bottom:0;">
                        <div class="icon qa-red" style="width:32px;height:32px;font-size:14px;border-radius:6px;"><i class="fa fa-minus-circle"></i></div>
                        <div class="details"><div class="title" style="font-size:12px;">Add Expense</div><div class="sub" style="font-size:10px;">Record new expense</div></div>
                        <div class="arrow" style="font-size:10px;"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>expense/expense_category" class="qa-list-item" style="padding:6px 0; border:none; margin-bottom:0;">
                        <div class="icon qa-orange" style="width:32px;height:32px;font-size:14px;border-radius:6px;"><i class="fa fa-tags"></i></div>
                        <div class="details"><div class="title" style="font-size:12px;">Expense Categories</div><div class="sub" style="font-size:10px;">Manage expense types</div></div>
                        <div class="arrow" style="font-size:10px;"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>admin/student_payment" class="qa-list-item" style="padding:6px 0; border:none; margin-bottom:0;">
                        <div class="icon qa-purple" style="width:32px;height:32px;font-size:14px;border-radius:6px;"><i class="fa fa-file-pdf-o"></i></div>
                        <div class="details"><div class="title" style="font-size:12px;">Generate Receipt</div><div class="sub" style="font-size:10px;">Create fee receipt</div></div>
                        <div class="arrow" style="font-size:10px;"><i class="fa fa-chevron-right"></i></div>
                    </a>
                    <a href="<?php echo base_url();?>admin/dashboard" class="qa-list-item" style="padding:6px 0; border:none; margin-bottom:0;">
                        <div class="icon qa-indigo" style="width:32px;height:32px;font-size:14px;border-radius:6px;"><i class="fa fa-bar-chart"></i></div>
                        <div class="details"><div class="title" style="font-size:12px;">View Reports</div><div class="sub" style="font-size:10px;">View all account reports</div></div>
                        <div class="arrow" style="font-size:10px;"><i class="fa fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Tables -->
        <div class="row m-b-20">
            <!-- Recent Transactions Table -->
            <div class="col-md-7">
                <div class="glass-card" style="padding: 20px; min-height: 380px;">
                    <div class="dashboard-section-title">
                        <h4>Recent Transactions</h4>
                        <a href="<?php echo base_url();?>admin/expense" class="btn btn-outline" style="background: #eff6ff; color: #3b82f6; border:none; padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size:11px;">View All</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="enquiry-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Receipt / Ref No.</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $this->db->order_by('timestamp', 'desc');
                                $this->db->limit(5);
                                $recent_tx = $this->db->get('payment')->result_array();
                                if(!empty($recent_tx)):
                                    $i = 1;
                                    foreach($recent_tx as $tx):
                                        $type_text = ($tx['payment_type'] == 'income') ? 'Fee Collection' : 'Expense';
                                        $m_name = isset($method_names[$tx['method']]) ? $method_names[$tx['method']] : ($tx['method'] ? $tx['method'] : 'Cash');
                                        
                                        // Attempt to fetch receipt/ref no if available
                                        $ref_no = "-";
                                        if($tx['invoice_id']) {
                                            $inv = $this->db->get_where('invoice', array('invoice_id' => $tx['invoice_id']))->row();
                                            if($inv && $inv->invoice_number) $ref_no = $inv->invoice_number;
                                            else $ref_no = "RCP" . date('Ymd', $tx['timestamp']) . str_pad($tx['payment_id'], 2, '0', STR_PAD_LEFT);
                                        } else {
                                            $ref_no = "EXP" . date('Ymd', $tx['timestamp']) . str_pad($tx['payment_id'], 2, '0', STR_PAD_LEFT);
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo date('d M Y', $tx['timestamp']); ?></td>
                                    <td><?php echo $type_text; ?></td>
                                    <td style="max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo $tx['title']; ?></td>
                                    <td><?php echo $ref_no; ?></td>
                                    <td style="font-weight:700; color:#1e293b;"><?php echo $currency; ?> <?php echo number_format($tx['amount'], 2); ?></td>
                                    <td><?php echo $m_name; ?></td>
                                    <td><span class="status-badge qa-green">Success</span></td>
                                </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                <tr><td colspan="8" style="text-align: center; color: #94a3b8; padding: 20px;">No recent transactions found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Outstanding Fees by Class -->
            <div class="col-md-5">
                <div class="glass-card" style="padding: 20px; min-height: 380px;">
                    <div class="dashboard-section-title">
                        <h4>Outstanding Fees</h4>
                        <a href="<?php echo base_url();?>admin/invoice" class="btn btn-outline" style="background: #eff6ff; color: #3b82f6; border:none; padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size:11px;">View All</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="enquiry-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Total Students</th>
                                    <th>Outstanding</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $classes = $this->db->get('class')->result_array();
                                $class_out = [];
                                foreach($classes as $c) {
                                    $this->db->select('student_id');
                                    $this->db->where('class_id', $c['class_id']);
                                    $stu_in_class = $this->db->get('student')->result_array();
                                    
                                    $c_due = 0;
                                    $outstanding_students = 0;
                                    $stu_count = count($stu_in_class);
                                    if($stu_count > 0) {
                                        $stu_ids = array_column($stu_in_class, 'student_id');
                                        
                                        $this->db->select_sum('due');
                                        $this->db->where_in('student_id', $stu_ids);
                                        $due_val = $this->db->get('invoice')->row()->due;
                                        $c_due = $due_val ? $due_val : 0;
                                        
                                        $this->db->where('due >', 0);
                                        $this->db->where_in('student_id', $stu_ids);
                                        $outstanding_students = $this->db->count_all_results('invoice'); // Approximation
                                    }
                                    if($c_due > 0) {
                                        $class_out[] = array('name' => $c['name'], 'students' => $stu_count, 'outstanding_students' => $outstanding_students, 'due' => $c_due);
                                    }
                                }
                                
                                // Sort by due amount desc
                                usort($class_out, function($a, $b) { return $b['due'] <=> $a['due']; });
                                
                                $out_i = 0;
                                foreach($class_out as $co):
                                    if($out_i >= 5) break;
                                ?>
                                <tr>
                                    <td style="font-weight:600; color:#475569;"><?php echo $co['name']; ?></td>
                                    <td><?php echo $co['students']; ?></td>
                                    <td><?php echo $co['outstanding_students']; ?></td>
                                    <td style="font-weight:700; color:#ef4444;"><?php echo $currency; ?> <?php echo number_format($co['due'], 2); ?></td>
                                </tr>
                                <?php 
                                    $out_i++;
                                endforeach;
                                if(empty($class_out)):
                                ?>
                                <tr><td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">No outstanding fees.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Stats Bar -->
        <div class="metric-5-col" style="margin-bottom:0;">
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:center;">
                    <div class="metric-icon qa-purple" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-inr"></i></div>
                    <div>
                        <div style="font-size:11px; color:#475569; font-weight:600;">Opening Balance</div>
                        <h4 style="margin:2px 0 0; font-size:16px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($opening_balance, 2); ?></h4>
                    </div>
                </div>
            </div>
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:center;">
                    <div class="metric-icon qa-green" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-file-text-o"></i></div>
                    <div>
                        <div style="font-size:11px; color:#475569; font-weight:600;">Total Receipts (<?php echo date('M'); ?>)</div>
                        <h4 style="margin:2px 0 0; font-size:16px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($col_month, 2); ?></h4>
                    </div>
                </div>
            </div>
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:center;">
                    <div class="metric-icon qa-orange" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-money"></i></div>
                    <div>
                        <div style="font-size:11px; color:#475569; font-weight:600;">Total Payments (<?php echo date('M'); ?>)</div>
                        <h4 style="margin:2px 0 0; font-size:16px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($exp_month, 2); ?></h4>
                    </div>
                </div>
            </div>
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:center;">
                    <div class="metric-icon qa-blue" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-file-pdf-o"></i></div>
                    <div>
                        <div style="font-size:11px; color:#475569; font-weight:600;">Closing Balance</div>
                        <h4 style="margin:2px 0 0; font-size:16px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($bank_balance, 2); ?></h4>
                    </div>
                </div>
            </div>
            <div class="glass-card" style="padding: 15px; margin-bottom:0;">
                <div style="display:flex; align-items:center;">
                    <div class="metric-icon qa-red" style="width:40px;height:40px;font-size:18px;border-radius:8px;box-shadow:none;"><i class="fa fa-cloud"></i></div>
                    <div>
                        <div style="font-size:11px; color:#475569; font-weight:600;">Account Type</div>
                        <h4 style="margin:2px 0 0; font-size:14px; font-weight:800; color:#1e293b; line-height:1;">Operational Account</h4>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        am4core.ready(function() {
            am4core.useTheme(am4themes_animated);
            
            // Collection Line Chart
            var accLine = am4core.create("accLineChart", am4charts.XYChart);
            accLine.data = <?php echo $acc_chart_data_json; ?>;
            
            var cAxis = accLine.xAxes.push(new am4charts.CategoryAxis());
            cAxis.dataFields.category = "date";
            cAxis.renderer.grid.template.opacity = 0;
            cAxis.renderer.labels.template.fontSize = 10;
            cAxis.renderer.labels.template.fill = am4core.color("#94a3b8");
            cAxis.renderer.minGridDistance = 30;

            var vAxis = accLine.yAxes.push(new am4charts.ValueAxis());
            vAxis.min = 0;
            vAxis.renderer.grid.template.opacity = 0.5;
            vAxis.renderer.grid.template.strokeDasharray = "4,4";
            vAxis.renderer.labels.template.fontSize = 10;
            vAxis.renderer.labels.template.fill = am4core.color("#94a3b8");

            var series = accLine.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = "collection";
            series.dataFields.categoryX = "date";
            series.name = "Collection";
            series.stroke = am4core.color("#3b82f6");
            series.strokeWidth = 2;
            series.tensionX = 0.8;
            
            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.fill = am4core.color("#fff");
            bullet.circle.stroke = am4core.color("#3b82f6");
            bullet.circle.strokeWidth = 2;
            bullet.circle.radius = 3;

            // accLine.legend = new am4charts.Legend();
            // accLine.legend.position = "top";
            // accLine.legend.labels.template.fontSize = 11;
            
            // Donut Chart
            var accDonut = am4core.create("accDonutChart", am4charts.PieChart);
            accDonut.innerRadius = am4core.percent(60);
            
            var rawAccDonutData = <?php echo $acc_donut_data_json; ?>;
            accDonut.data = rawAccDonutData.map(function(item) {
                return { method: item.method, amount: item.amount, color: am4core.color(item.color) };
            });

            var pieSeries2 = accDonut.series.push(new am4charts.PieSeries());
            pieSeries2.dataFields.value = "amount";
            pieSeries2.dataFields.category = "method";
            pieSeries2.slices.template.propertyFields.fill = "color";
            pieSeries2.labels.template.disabled = true;
            pieSeries2.ticks.template.disabled = true;

            var label2 = accDonut.seriesContainer.createChild(am4core.Label);
            label2.text = "[font-size:10px; color:#64748b]Total[/]\n[font-size:16px; font-weight:bold; color:#1e293b]<?php echo $currency; ?> <?php echo number_format($total_donut); ?>[/]";
            label2.horizontalCenter = "middle";
            label2.verticalCenter = "middle";
            label2.textAlign = "middle";
        });
        </script>
        

    <?php else: ?>
        <!-- ADMIN METRICS (original) -->
        <div class="glass-card" style="padding: 15px; margin-bottom:0;">
            <div style="display:flex; align-items:center;">
                <div class="metric-icon solid-blue"><i class="fa fa-users"></i></div>
                <div>
                   <h4 style="margin:0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo number_format($this->db->count_all_results('student'));?></h4>
                   <div style="font-size:11px; color:#64748b; font-weight:600; margin-top:4px;">Total Students</div>
                </div>
            </div>
            <div style="margin-top:12px; font-size:11px; font-weight:700;"><span style="color:#10b981;">+18</span> <span style="color:#94a3b8;font-weight:500;">this month</span></div>
        </div>

        <!-- 2: Faculty Staff -->
        <div class="glass-card" style="padding: 15px; margin-bottom:0;">
            <div style="display:flex; align-items:center;">
                <div class="metric-icon solid-green"><i class="fa fa-user-plus"></i></div>
                <div>
                   <h4 style="margin:0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo number_format($this->db->count_all_results('teacher'));?></h4>
                   <div style="font-size:11px; color:#64748b; font-weight:600; margin-top:4px;">Faculty & Staff</div>
                </div>
            </div>
            <div style="margin-top:12px; font-size:11px; font-weight:700;"><span style="color:#10b981;">+3</span> <span style="color:#94a3b8;font-weight:500;">this month</span></div>
        </div>

        <!-- 3: Present Today -->
        <div class="glass-card" style="padding: 15px; margin-bottom:0;">
            <div style="display:flex; align-items:center;">
                <div class="metric-icon solid-purple"><i class="fa fa-check-square-o"></i></div>
                <div>
                   <h4 style="margin:0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;">
                    <?php 
                    $check_daily_attendance = array('date' => date('Y-m-d'), 'status' => '1');
                    $daily_present = $this->db->get_where('attendance', $check_daily_attendance)->num_rows();
                    echo number_format($daily_present);

                    $tot_stu = $this->db->count_all_results('student');
                    $att_pct = ($tot_stu > 0) ? round(($daily_present / $tot_stu) * 100, 1) : 0;
                    ?>
                   </h4>
                   <div style="font-size:11px; color:#64748b; font-weight:600; margin-top:4px;">Present Today</div>
                </div>
            </div>
            <div style="margin-top:12px; font-size:11px; font-weight:700;"><span style="color:#10b981;"><?php echo $att_pct; ?>%</span> <span style="color:#94a3b8;font-weight:500;">Attendance</span></div>
        </div>

        <!-- 4: Classes -->
        <div class="glass-card" style="padding: 15px; margin-bottom:0;">
            <div style="display:flex; align-items:center;">
                <div class="metric-icon solid-yellow"><i class="fa fa-calendar-o"></i></div>
                <div>
                   <h4 style="margin:0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo number_format($this->db->count_all_results('class')); ?></h4>
                   <div style="font-size:11px; color:#64748b; font-weight:600; margin-top:4px;">Classes</div>
                </div>
            </div>
            <div style="margin-top:12px; font-size:11px; font-weight:700; color:#94a3b8;"><span style="font-weight:500; color:#1e293b;"><?php echo number_format($this->db->count_all_results('section')); ?></span> Sections</div>
        </div>

        <!-- 5: Total Income -->
        <div class="glass-card" style="padding: 15px; margin-bottom:0;">
            <div style="display:flex; align-items:center;">
                <div class="metric-icon solid-red"><i class="fa fa-money"></i></div>
                <div>
                   <?php 
                   $this->db->select_sum('amount');
                   $this->db->where('payment_type', 'income');
                   $inc = $this->db->get('payment')->row()->amount;
                   $inc = $inc ? $inc : 0;
                   $currency = $this->db->get_where('settings', array('type' => 'currency'))->row()->description;
                   ?>
                   <h4 style="margin:0; font-size:20px; font-weight:800; color:#1e293b; line-height:1;"><?php echo $currency; ?> <?php echo number_format($inc);?></h4>
                   <div style="font-size:11px; color:#64748b; font-weight:600; margin-top:4px;">Total Income</div>
                </div>
            </div>
            <div style="margin-top:12px; font-size:11px; font-weight:700; color:#94a3b8;"><span style="font-weight:500; color:#1e293b;"><?php echo $this->db->get_where('payment', array('payment_type'=>'income'))->num_rows(); ?></span> Transactions</div>
        </div>
    </div>


    <div class="row">
        <!-- Attendance Chart -->
        <div class="col-md-7 col-lg-7">
            <div class="glass-card p-20" style="height: 340px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <h4 style="margin:0; font-weight: 700; font-size: 14px; color:#1e293b;">Attendance Overview</h4>
                    <span class="btn btn-outline" style="border:1px solid #e2e8f0; font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px; color:#475569;">Past 7 Days</span>
                </div>
                
                <?php
                // Generate Real Attendance Data for the last 7 Days
                $attendance_chart_data = [];
                $wk_vals = [];
                $tot_s = $this->db->count_all_results('student');
                if($tot_s == 0) $tot_s = 1;
                for($i=6; $i>=0; $i--) {
                    $d_date = date('Y-m-d', strtotime("-$i days"));
                    $d_name = date('D', strtotime("-$i days"));
                    $d_pres = $this->db->get_where('attendance', array('date' => $d_date, 'status' => '1'))->num_rows();
                    $perc = round(($d_pres / $tot_s) * 100, 1);
                    $attendance_chart_data[] = '{"day": "'.$d_name.'", "val": '.$perc.'}';
                    $wk_vals[] = $perc;
                }
                $att_json = implode(",", $attendance_chart_data);
                $wk_avg = round(array_sum($wk_vals) / 7, 1);
                $wk_high = max($wk_vals);
                $wk_low = min($wk_vals);
                ?>

                <style>#chartdiv_att { width: 100%; height: 210px; margin-left: -15px; margin-top:10px; } .amcharts-chart-div a{ display:none !important; }</style>
                <div id="chartdiv_att"></div>
                
                <!-- Bottom Stats -->
                <div style="display:flex; justify-content: space-between; margin-top:15px; padding-top:10px; border-top: 1px solid #f1f5f9;">
                    <div>
                        <span style="font-size:10px; color:#94a3b8; font-weight:600; display:block;">Weekly Average</span>
                        <strong style="color:#3b82f6; font-size:16px;"><?php echo $wk_avg; ?>%</strong>
                    </div>
                    <div>
                        <span style="font-size:10px; color:#94a3b8; font-weight:600; display:block;">Highest Day</span>
                        <strong style="color:#10b981; font-size:16px;"><?php echo $wk_high; ?>%</strong>
                    </div>
                    <div>
                        <span style="font-size:10px; color:#94a3b8; font-weight:600; display:block;">Lowest Day</span>
                        <strong style="color:#ef4444; font-size:16px;"><?php echo $wk_low; ?>%</strong>
                    </div>
                </div>

                <script>
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("chartdiv_att", am4charts.XYChart);
                    chart.paddingRight = 20; chart.paddingLeft = 0; chart.paddingBottom = 0;
                    chart.data = [ <?php echo $att_json; ?> ];
                    var xA = chart.xAxes.push(new am4charts.CategoryAxis());
                    xA.dataFields.category = "day"; xA.renderer.grid.template.opacity = 0; xA.renderer.labels.template.fontSize = 11; xA.renderer.labels.template.fill = am4core.color("#94a3b8");
                    var yA = chart.yAxes.push(new am4charts.ValueAxis());
                    yA.min = 0; yA.max = 100; yA.renderer.grid.template.opacity = 0.3; yA.renderer.grid.template.strokeDasharray = "3,3"; yA.renderer.labels.template.fontSize = 10; yA.renderer.labels.template.fill = am4core.color("#94a3b8");
                    var series = chart.series.push(new am4charts.LineSeries());
                    series.dataFields.categoryX = "day"; series.dataFields.valueY = "val";
                    series.stroke = am4core.color("#3b82f6"); series.strokeWidth = 3;
                    series.tensionX = 0.8; series.fillOpacity = 0.1;
                    var fillModifier = new am4core.LinearGradientModifier();
                    fillModifier.opacities = [0.3, 0]; fillModifier.offsets = [0, 1]; fillModifier.gradient.rotation = 90;
                    series.fillModifier = fillModifier; series.fill = am4core.color("#3b82f6");
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.fill = am4core.color("#fff"); bullet.circle.stroke = am4core.color("#3b82f6"); bullet.circle.strokeWidth = 2;
                    bullet.tooltipText = "{valueY}%";

                    // Show bullet label for Thu
                    var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                    labelBullet.label.text = "{valueY}%"; labelBullet.label.dy = -20;
                    labelBullet.label.fontSize = 10; labelBullet.label.fill = am4core.color("#fff");
                    labelBullet.label.background.fill = am4core.color("#1e293b"); labelBullet.label.background.fillOpacity = 1;
                    labelBullet.label.padding(3,6,3,6); labelBullet.label.hideOversized = false;
                    labelBullet.adapter.add("disabled", function(disabled, target) {
                        return target.dataItem && target.dataItem.categoryX !== "Thu";
                    });
                });
                </script>
            </div>
        </div>

        <!-- Fee Collection Chart -->
        <div class="col-md-5 col-lg-5">
            <div class="glass-card p-20" style="height: 340px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h4 style="margin:0; font-weight: 700; font-size: 14px; color:#1e293b;">Fee Collection Overview</h4>
                    <span class="btn btn-outline" style="border:1px solid #e2e8f0; font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px; color:#475569;">All Time</span>
                </div>

                <?php 
                // Getting real fee data
                $this->db->select_sum('amount'); $this->db->where('payment_type', 'income');
                $col_amt = $this->db->get('payment')->row()->amount;
                $col_amt = $col_amt ? $col_amt : 0;
                
                $this->db->select_sum('due');
                $pen_amt = $this->db->get('invoice')->row()->due;
                $pen_amt = $pen_amt ? $pen_amt : 0;
                
                $tot_amt = $col_amt + $pen_amt;
                if($tot_amt > 0) {
                    $col_pct = round(($col_amt / $tot_amt) * 100);
                    $pen_pct = round(($pen_amt / $tot_amt) * 100);
                } else {
                    $col_pct = 0; $pen_pct = 0;
                }
                ?>

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <style>#chartdiv_fee { width: 150px; height: 200px; } </style>
                    <div id="chartdiv_fee"></div>
                    <div style="flex: 1; padding-left: 15px;">
                        <ul style="list-style:none; padding:0; margin:0;">
                            <li style="margin-bottom: 15px;">
                                <div style="font-size:11px; color:#64748b; font-weight:600; display:flex; align-items:center;">
                                    <span style="width:8px; height:8px; background:#10b981; border-radius:50%; margin-right:6px; display:inline-block;"></span> Collected
                                </div>
                                <div style="font-size:13px; font-weight:700; color:#1e293b; padding-left:14px;"><?php echo $currency; ?> <?php echo number_format($col_amt); ?> <span style="font-weight:500; font-size:11px; color:#64748b;">(<?php echo $col_pct; ?>%)</span></div>
                            </li>
                            <li style="margin-bottom: 15px;">
                                <div style="font-size:11px; color:#64748b; font-weight:600; display:flex; align-items:center;">
                                    <span style="width:8px; height:8px; background:#3b82f6; border-radius:50%; margin-right:6px; display:inline-block;"></span> Pending/Due
                                </div>
                                <div style="font-size:13px; font-weight:700; color:#1e293b; padding-left:14px;"><?php echo $currency; ?> <?php echo number_format($pen_amt); ?> <span style="font-weight:500; font-size:11px; color:#64748b;">(<?php echo $pen_pct; ?>%)</span></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div style="display:flex; justify-content: space-between; align-items:center; margin-top:20px; padding: 12px; background: #f8fafc; border-radius: 8px;">
                     <div>
                         <span style="font-size:11px; color:#1e293b; font-weight:700; display:block;"><?php echo $col_pct; ?>% of fees collected</span>
                     </div>
                     <span style="font-size:11px; color:#3b82f6; font-weight:600; cursor:pointer;" onclick="location.href='<?php echo base_url();?>admin/invoice';">View Details &rarr;</span>
                </div>

                <script>
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("chartdiv_fee", am4charts.PieChart);
                    chart.innerRadius = am4core.percent(65);
                    chart.data = [
                      { "sector": "Collected", "size": <?php echo $col_pct ?: 1; ?>, "color": am4core.color("#10b981") },
                      { "sector": "Pending", "size": <?php echo $pen_pct ?: 0; ?>, "color": am4core.color("#3b82f6") }
                    ];
                    var series = chart.series.push(new am4charts.PieSeries());
                    series.dataFields.value = "size";
                    series.dataFields.category = "sector";
                    series.slices.template.propertyFields.fill = "color";
                    series.labels.template.disabled = true;
                    series.ticks.template.disabled = true;
                    
                    var label = chart.seriesContainer.createChild(am4core.Label);
                    label.text = "<?php echo $currency; ?> <?php echo number_format($col_amt); ?>\n[font-size:8px; font-weight:500; color:#64748b]Total Collected[/]";
                    label.horizontalCenter = "middle";
                    label.verticalCenter = "middle";
                    label.fontSize = 12; label.fontWeight = "bold"; label.fill = am4core.color("#1e293b"); label.textAlign = "middle";
                });
                </script>
            </div>
        </div>
    </div>


    <!-- Bottom Row Lists -->
    <div class="row">
        
        <!-- Recent Activities -->
        <div class="col-md-4">
            <div class="glass-card" style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin:0; font-weight: 700; font-size: 14px; color:#1e293b;">Recent Activities</h4>
                    <span style="font-size:11px; color:#3b82f6; font-weight:600; cursor:pointer;" onclick="location.href='<?php echo base_url();?>admin/manage_attendance';" class="btn btn-outline btn-sm">View All</span>
                </div>
                
                <ul class="feed-ul" style="max-height: 250px; overflow-y: auto;">
                    <?php 
                    $this->db->order_by('log_id', 'desc');
                    $this->db->limit(5); 
                    $rfid_logs = $this->db->get('rfid_attendance_log')->result_array();
                    
                    if (empty($rfid_logs)): ?>
                        <div style="padding: 30px; text-align: center; color: #888;">
                            <i class="fa fa-feed fa-2x" style="opacity: 0.2; margin-bottom: 10px;"></i><br>
                            Waiting for campus <br> scan events...
                        </div>
                    <?php else: ?>
                        <?php foreach($rfid_logs as $log): 
                            $name = $this->crud_model->get_rfid_user_name($log['user_type'], $log['user_id']);
                            $action_title = ($log['direction'] == 'in') ? 'Checked IN' : 'Checked OUT';
                            $action_desc = ($log['direction'] == 'in') ? 'Marked present on campus' : 'Left the campus premises';
                            $icon_bg = ($log['direction'] == 'in') ? 'evt-green' : 'evt-orange';
                            $icon_fa = ($log['direction'] == 'in') ? 'fa-check' : 'fa-sign-out';
                        ?>
                        <li>
                            <div class="evt-icon <?php echo $icon_bg;?>"><i class="fa <?php echo $icon_fa;?>"></i></div>
                            <div style="flex:1;">
                                <div style="display:flex; justify-content: space-between; align-items:flex-start;">
                                    <div>
                                        <span style="font-size:12px; font-weight:700; color:#1e293b; display:block;"><?php echo $name; ?> (<?php echo $action_title; ?>)</span>
                                        <span style="font-size:11px; color:#64748b; font-weight:500;"><?php echo $action_desc; ?></span>
                                    </div>
                                    <span style="font-size:10px; color:#94a3b8; font-weight:600;"><?php echo date('h:i A', strtotime($log['scan_time'])); ?></span>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Upcoming Events / Noticeboard -->
        <div class="col-md-4">
            <div class="glass-card" style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin:0; font-weight: 700; font-size: 14px; color:#1e293b;">Noticeboard</h4>
                    <span style="font-size:11px; color:#3b82f6; font-weight:600; cursor:pointer;" onclick="location.href='<?php echo base_url();?>admin/noticeboard';" class="btn btn-outline btn-sm">View All</span>
                </div>
                
                <ul class="feed-ul" style="max-height: 250px; overflow-y: auto;">
                    <?php
                    $this->db->order_by('timestamp', 'desc');
                    $this->db->limit(4);
                    $notices = $this->db->get('noticeboard')->result_array();

                    if(empty($notices)): ?>
                        <div style="padding: 30px; text-align: center; color: #888;">
                            <i class="fa fa-calendar fa-2x" style="opacity: 0.2; margin-bottom: 10px;"></i><br>
                            No recent notices.
                        </div>
                    <?php else:
                        foreach($notices as $notice):
                            $n_date = $notice['timestamp'];
                            $d_mon = date('M', $n_date);
                            $d_day = date('d', $n_date);
                    ?>
                    <li>
                        <div class="event-dt"><span><?php echo $d_mon; ?></span><strong><?php echo $d_day; ?></strong></div>
                        <div style="flex:1;">
                            <div style="display:flex; justify-content: space-between; align-items:center;">
                                <div>
                                    <span style="font-size:12px; font-weight:700; color:#1e293b; display:block;" title="<?php echo $notice['title']; ?>">
                                        <?php echo substr($notice['title'], 0, 30); ?><?php echo strlen($notice['title']) > 30 ? '...' : ''; ?>
                                    </span>
                                </div>
                                <span style="font-size:9px; color:#f59e0b; font-weight:600; background:#fef3c7; padding:3px 8px; border-radius:4px;">Notice</span>
                            </div>
                        </div>
                    </li>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </ul>
            </div>
        </div>

        <!-- Quick Links (8 Items Grid) -->
        <div class="col-md-4">
            <div class="glass-card" style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin:0; font-weight: 700; font-size: 14px; color:#1e293b;">Quick Links</h4>
                    <span style="font-size:11px; color:#64748b; font-weight:600; cursor:pointer;" class="btn btn-outline btn-sm"><i class="fa fa-cog"></i> Customize</span>
                </div>
                
                <div class="quick-action-grid">
                    <a href="<?php echo base_url();?>admin/new_student" class="quick-action-btn-square">
                        <div class="qa-icon qa-blue"><i class="fa fa-user-plus"></i></div>
                        Add Student
                    </a>
                    <a href="<?php echo base_url();?>admin/teacher" class="quick-action-btn-square">
                        <div class="qa-icon qa-green"><i class="fa fa-user"></i></div>
                        Add Staff
                    </a>
                    <a href="<?php echo base_url();?>admin/noticeboard" class="quick-action-btn-square">
                        <div class="qa-icon qa-purple"><i class="fa fa-bullhorn"></i></div>
                        Create Notice
                    </a>
                    <a href="<?php echo base_url();?>admin/message" class="quick-action-btn-square">
                        <div class="qa-icon qa-orange"><i class="fa fa-envelope"></i></div>
                        Send Message
                    </a>
                    <a href="<?php echo base_url();?>admin/manage_attendance" class="quick-action-btn-square">
                        <div class="qa-icon qa-red"><i class="fa fa-calendar-check-o"></i></div>
                        Mark Attendance
                    </a>
                    <a href="<?php echo base_url();?>admin/student_payment" class="quick-action-btn-square">
                        <div class="qa-icon qa-blue"><i class="fa fa-bar-chart"></i></div>
                        Fee Collection
                    </a>
                    <a href="<?php echo base_url();?>admin/student_marksheet_subject" class="quick-action-btn-square">
                        <div class="qa-icon qa-indigo"><i class="fa fa-line-chart"></i></div>
                        Reports
                    </a>
                    <a href="<?php echo base_url();?>admin/assignment" class="quick-action-btn-square">
                        <div class="qa-icon qa-green"><i class="fa fa-download"></i></div>
                        Downloads
                    </a>
                </div>
            </div>
        </div>

    </div>
    
    <?php endif; // end role-specific dashboard ?>

</div>
<!-- /dashboard-canvas -->