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

</style>

<div class="dashboard-canvas">
    
    <!-- Greeting Header -->
    <div class="row m-b-20" style="align-items: center; display: flex; flex-wrap: wrap;">
        <div class="col-md-8">
            <h2 style="font-weight: 800; color: #1e293b; margin-top: 10px; font-size: 24px;">Good Morning, Admin! <span style="font-size: 24px;">👋</span></h2>
            <p style="color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 0;">Here's what's happening in your school today.</p>
        </div>
        <div class="col-md-4 text-right hidden-xs">
            <span class="btn btn-outline" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #334155; font-weight: 600; padding: 8px 16px; font-size: 13px;">
                <i class="fa fa-calendar" style="color: #64748b; margin-right: 8px;"></i> Today, <?php echo date('d M Y'); ?> <i class="fa fa-chevron-down" style="font-size: 10px; margin-left: 8px; color: #cbd5e1;"></i>
            </span>
        </div>
    </div>

    <!-- 5 Column Core Metrics Grid -->
    <div class="metric-5-col">
        <!-- 1: Total Students -->
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
    
</div>
<!-- /dashboard-canvas -->s -->