<!-- Advanced Dashboard Aesthetic Styles -->
<style>
/* Glassmorphism & Modern UI Tokens */
.dashboard-canvas {
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    padding-top: 15px;
}
.glass-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 25px;
}
.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px 0 rgba(31, 38, 135, 0.1);
}

/* Gradient Metrics Icons */
.metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    float: left;
    margin-right: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.grad-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.grad-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.grad-info { background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); }
.grad-warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
.grad-danger { background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%); }

.metric-body h4 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: #2b2b2b;
}
.metric-body .text-muted {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

/* Quick Actions Bar */
.quick-action-btn {
    border-radius: 50px;
    padding: 10px 25px;
    font-weight: 600;
    margin-right: 10px;
    margin-bottom: 15px;
    transition: all 0.2s ease;
    border: none;
}
.quick-action-btn i { margin-right: 8px; }
.quick-action-btn:hover {
    transform: scale(1.05);
}

/* Live Feed Sidebar */
.feed-item {
    padding: 15px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
}
.feed-item:last-child { border-bottom: none; }
.feed-icon {
    width: 40px;height: 40px;border-radius: 50%;
    display: flex;align-items: center;justify-content: center;
    color: white;margin-right: 15px;
}
.feed-in { background: #38ef7d; }
.feed-out { background: #ff0844; }
.feed-meta {
    font-weight: 600; color: #333;
    display: block; margin-bottom: 3px;
}
.feed-time {
    font-size: 11px; color: #999;
}

/* Tables & Avatars */
.modern-table th {
    border-top: none !important;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 1px;
    color: #888;
}
.modern-table td {
    vertical-align: middle !important;
    border-color: rgba(0,0,0,0.03) !important;
}
.modern-table tbody tr:hover {
    background: rgba(0,0,0,0.02);
}
.avatar-circle {
    width: 45px; height: 45px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    border: 2px solid white;
}
</style>

<div class="dashboard-canvas">
    
    <!-- Quick Action Bar -->
    <div class="row">
        <div class="col-md-12">
            <div class="glass-card" style="padding: 15px 20px; display: flex; flex-wrap: wrap;">
                <h4 style="margin-top: 5px; margin-right: 30px; font-weight: 700; color: #555;">Quick Actions</h4>
                <a href="<?php echo base_url();?>admin/student/create" class="btn btn-primary quick-action-btn shadow"><i class="fa fa-user-plus"></i> Add Student</a>
                <a href="<?php echo base_url();?>admin/invoice" class="btn btn-success quick-action-btn shadow"><i class="fa fa-credit-card"></i> Create Invoice</a>
                <a href="<?php echo base_url();?>admin/manage_attendance" class="btn btn-info quick-action-btn shadow"><i class="fa fa-check-square-o"></i> Class Attendance</a>
                <a href="<?php echo base_url();?>admin/message" class="btn btn-warning quick-action-btn shadow" style="color:white;"><i class="fa fa-envelope"></i> Send Message</a>
                <a href="<?php echo base_url();?>systemsetting/rfid_settings" class="btn btn-danger quick-action-btn shadow"><i class="fa fa-hdd-o"></i> RFID Settings</a>
            </div>
        </div>
    </div>

    <!-- Core Metrics Row 1 -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-20">
                <div class="metric-icon grad-primary"><i class="fa fa-graduation-cap"></i></div>
                <div class="metric-body">
                    <h4><?php echo $this->db->count_all_results('student');?></h4>
                    <span class="text-muted">Total Students</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-20">
                <div class="metric-icon grad-info"><i class="fa fa-users"></i></div>
                <div class="metric-body">
                    <h4><?php echo $this->db->count_all_results('teacher');?></h4>
                    <span class="text-muted">Faculty Staff</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-20">
                <div class="metric-icon grad-success"><i class="fa fa-check-circle"></i></div>
                <div class="metric-body">
                    <h4>
                    <?php 
                    $check_daily_attendance = array('date' => date('Y-m-d'), 'status' => '1');
                    echo $this->db->get_where('attendance', $check_daily_attendance)->num_rows();
                    ?>
                    </h4>
                    <span class="text-muted">Present Today</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="glass-card p-20">
                <div class="metric-icon grad-warning"><i class="fa fa-bed"></i></div>
                <div class="metric-body">
                    <h4>
                    <?php 
                    $this->db->where('dormitory_id !=', '');
                    $this->db->where('dormitory_id !=', '0');
                    echo $this->db->get('student')->num_rows();
                    ?>
                    </h4>
                    <span class="text-muted">Hostel Occupancy</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Metrics Row 2 (Financials) -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="glass-card p-20">
                <div class="metric-icon grad-success"><i class="fa fa-money"></i></div>
                <div class="metric-body">
                    <?php 
                    $this->db->select_sum('amount');
                    $this->db->where('payment_type', 'income');
                    $inc = $this->db->get('payment')->row()->amount;
                    ?>
                    <h4><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description;?> <?php echo number_format($inc, 2);?></h4>
                    <span class="text-muted">Total Income</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="glass-card p-20">
                <div class="metric-icon grad-danger"><i class="fa fa-calculator"></i></div>
                <div class="metric-body">
                    <?php 
                    $this->db->select_sum('amount');
                    $this->db->where('payment_type', 'expense');
                    $exp = $this->db->get('payment')->row()->amount;
                    ?>
                    <h4><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description;?> <?php echo number_format($exp, 2);?></h4>
                    <span class="text-muted">Total Expenses</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="glass-card p-20">
                <div class="metric-icon grad-warning"><i class="fa fa-exclamation-triangle"></i></div>
                <div class="metric-body">
                    <?php 
                    $this->db->select_sum('due');
                    // Invoices with status unpaid typically have 'due'
                    // For logic simplicity, sum of 'due' is used
                    $due = $this->db->get('invoice')->row()->due;
                    ?>
                    <h4><?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description;?> <?php echo number_format($due, 2);?></h4>
                    <span class="text-muted">Unpaid Balances</span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Main Chart Section -->
        <div class="col-md-8 col-lg-8">
            <div class="glass-card p-20">
                <h4 style="margin-top:0; font-weight: 700; border-bottom: 2px solid #eee; padding-bottom: 10px;">Income Density Overview</h4>
                <!-- Styles -->
                <style>
                #chartdiv { width: 100%; height: 400px; }
                .amcharts-chart-div a{ display:none !important; }	
                </style>
                <!-- Chart code -->
                <script>
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("chartdiv", am4charts.XYChart);
                    chart.hiddenState.properties.opacity = 0;
                    chart.paddingBottom = 30;
                    chart.data = [
                    <?php $select_student = $this->db->get_where('invoice', array('year' => $running_year))->result_array();
                        foreach ($select_student as $key => $student_selected):?>
                        {
                        "name": "<?php echo $this->crud_model->get_type_name_by_id('student', $student_selected['student_id']);?>",
                        "steps": <?php echo $student_selected['amount_paid'];?>,
                        "href": "<?php echo base_url();?>uploads/student_image/<?php echo $student_selected['student_id']. '.jpg';?>"
                        }, 
                    <?php endforeach;?>
                    ];

                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "name";
                    categoryAxis.renderer.grid.template.strokeOpacity = 0;
                    categoryAxis.renderer.minGridDistance = 10;
                    categoryAxis.renderer.labels.template.dy = 35;
                    categoryAxis.renderer.tooltip.dy = 35;

                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.renderer.inside = true;
                    valueAxis.renderer.labels.template.fillOpacity = 0.3;
                    valueAxis.renderer.grid.template.strokeOpacity = 0;
                    valueAxis.min = 0;
                    valueAxis.cursorTooltipEnabled = false;
                    valueAxis.renderer.baseGrid.strokeOpacity = 0;

                    var series = chart.series.push(new am4charts.ColumnSeries);
                    series.dataFields.valueY = "steps";
                    series.dataFields.categoryX = "name";
                    series.tooltipText = "{valueY.value}";
                    series.tooltip.pointerOrientation = "vertical";
                    series.tooltip.dy = - 6;
                    series.columnsContainer.zIndex = 100;

                    var columnTemplate = series.columns.template;
                    columnTemplate.width = am4core.percent(50);
                    columnTemplate.maxWidth = 66;
                    columnTemplate.column.cornerRadius(60, 60, 10, 10);
                    columnTemplate.strokeOpacity = 0;

                    series.heatRules.push({ target: columnTemplate, property: "fill", dataField: "valueY", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46") });
                    series.mainContainer.mask = undefined;

                    var cursor = new am4charts.XYCursor();
                    chart.cursor = cursor;
                    cursor.lineX.disabled = true;
                    cursor.lineY.disabled = true;
                    cursor.behavior = "none";

                    var bullet = columnTemplate.createChild(am4charts.CircleBullet);
                    bullet.circle.radius = 30;
                    bullet.valign = "bottom";
                    bullet.align = "center";
                    bullet.isMeasured = true;
                    bullet.mouseEnabled = false;
                    bullet.verticalCenter = "bottom";
                    bullet.interactionsEnabled = false;

                    var image = bullet.createChild(am4core.Image);
                    image.width = 60;
                    image.height = 60;
                    image.horizontalCenter = "middle";
                    image.verticalCenter = "middle";
                    image.propertyFields.href = "href";

                    image.adapter.add("mask", function (mask, target) {
                        return target.parent.circle;
                    })
                }); // end am4core.ready()
                </script>
                <div id="chartdiv"></div>
            </div>
        </div>

        <!-- Live RFID Activity Feed -->
        <div class="col-md-4 col-lg-4">
            <div class="glass-card" style="padding: 0;">
                <h4 style="margin:0; padding: 20px; font-weight: 700; background: rgba(0,0,0,0.05);">Live Biometric Feed</h4>
                <div style="max-height: 400px; overflow-y: auto;">
                    <?php 
                    $this->db->order_by('log_id', 'desc');
                    $this->db->limit(6);
                    $rfid_logs = $this->db->get('rfid_attendance_log')->result_array();
                    
                    if (empty($rfid_logs)): ?>
                        <div style="padding: 30px; text-align: center; color: #888;">
                            <i class="fa fa-feed fa-3x" style="opacity: 0.2; margin-bottom: 10px;"></i><br>
                            Waiting for scan events...
                        </div>
                    <?php else: ?>
                        <?php foreach($rfid_logs as $log): 
                            $name = $this->crud_model->get_rfid_user_name($log['user_type'], $log['user_id']);
                            $iconClass = ($log['direction'] == 'in') ? 'fa-sign-in feed-in' : 'fa-sign-out feed-out';
                            $action = ($log['direction'] == 'in') ? 'Checked In' : 'Checked Out';
                        ?>
                        <div class="feed-item">
                            <div class="feed-icon <?php echo ($log['direction']=='in')?'feed-in':'feed-out';?>">
                                <i class="fa <?php echo ($log['direction']=='in')?'fa-sign-in':'fa-sign-out';?>"></i>
                            </div>
                            <div>
                                <span class="feed-meta">
                                    <?php echo $name; ?> <span style="font-weight: 400; color:#888;">has <?php echo strtolower($action); ?></span>
                                </span>
                                <div class="feed-time">
                                    <i class="fa fa-clock-o"></i> <?php echo date('M d, h:i A', strtotime($log['scan_time'])); ?>
                                    &nbsp;|&nbsp; <?php echo ucfirst($log['user_type']); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Tables Row -->
    <div class="row">
        <div class="col-sm-6">
            <div class="glass-card p-20">
                <h3 class="box-title m-b-0" style="font-weight: 700;">Recently Added Teachers</h3>
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email/Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $get_teacher_from_model = $this->crud_model->list_all_teacher_and_order_with_teacher_id();
                                foreach ($get_teacher_from_model as $key => $teacher):?>
                                <tr>
                                    <td><img src="<?php echo $teacher['face_file'];?>" class="avatar-circle"></td>
                                    <td><strong style="color: #444;"><?php echo $teacher['name'];?></strong></td>
                                    <td>
                                        <div style="font-size: 13px;"><?php echo $teacher['email'];?></div>
                                        <div style="font-size: 12px; color: #888;"><i class="fa fa-phone"></i> <?php echo $teacher['phone'];?></div>
                                    </td>
                                </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="glass-card p-20">
                <h3 class="box-title m-b-0" style="font-weight: 700;">Recently Added Students</h3>
                <div class="table-responsive">
                <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email/Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $get_student_from_model = $this->crud_model->list_all_student_and_order_with_student_id();
                                foreach ($get_student_from_model as $key => $student):?>
                                <tr>
                                    <td><img src="<?php echo $student['face_file'];?>" class="avatar-circle"></td>
                                    <td><strong style="color: #444;"><?php echo $student['name'];?></strong></td>
                                    <td>
                                        <div style="font-size: 13px;"><?php echo $student['email'];?></div>
                                        <div style="font-size: 12px; color: #888;"><i class="fa fa-phone"></i> <?php echo $student['phone'];?></div>
                                    </td>
                                </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!-- /dashboard-canvas -->