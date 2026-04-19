<style>
    .att-filter-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        padding: 28px;
        margin-bottom: 24px;
    }
    .att-filter-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 20px 0;
    }
    .att-filter-row {
        display: flex;
        gap: 16px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    .att-filter-group {
        flex: 1;
        min-width: 150px;
    }
    .att-filter-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
    }
    .att-filter-group select,
    .att-filter-group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        color: #334155;
        background: #f8fafc;
        transition: all 0.2s ease;
        outline: none;
    }
    .att-filter-group select:focus,
    .att-filter-group input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        background: #fff;
    }
    .att-btn-primary {
        padding: 10px 28px;
        background: linear-gradient(90deg, #6366f1, #3b82f6);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-width: 140px;
        justify-content: center;
    }
    .att-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
    }
    .att-btn-outline {
        padding: 10px 20px;
        background: transparent;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .att-btn-outline:hover {
        background: #f1f5f9;
        color: #334155;
        border-color: #cbd5e1;
    }
    .att-legend {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        padding: 14px 20px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 16px;
        border: 1px solid #e2e8f0;
    }
    .att-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #475569;
        font-weight: 500;
    }
    .att-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .att-stats-row {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .att-stat-card {
        flex: 1;
        min-width: 120px;
        background: #ffffff;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        text-align: center;
    }
    .att-stat-card .stat-num {
        font-size: 28px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 4px;
    }
    .att-stat-card .stat-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .att-search-box {
        position: relative;
        margin-bottom: 16px;
    }
    .att-search-box input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s ease;
    }
    .att-search-box input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        background: #fff;
    }
    .att-search-box i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }
</style>

<!-- ===== FILTER CARD ===== -->
<div class="att-filter-card">
    <h4><i class="fa fa-calendar-check-o" style="color: #6366f1; margin-right: 8px;"></i>Staff & Teacher Attendance Report</h4>
    
    <div class="att-filter-row">
        <div class="att-filter-group">
            <label>Month</label>
            <select id="month">
                <?php $current_month = date('m'); ?>
                <?php
                $months = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
                foreach($months as $num => $name):
                ?>
                    <option value="<?php echo $num; ?>"<?php if($current_month == $num) echo ' selected'; ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="att-filter-group">
            <label>Year</label>
            <select id="year">
                <?php $current_year = date('Y');
                for($y = $current_year - 2; $y <= $current_year + 1; $y++): ?>
                    <option value="<?php echo $y;?>"<?php if($y == $current_year) echo ' selected';?>><?php echo $y;?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="att-filter-group">
            <label>Staff Type</label>
            <select id="staff_type_filter">
                <option value="all">All Employees</option>
                <option value="teaching">Teachers Only</option>
                <option value="non_teaching">Support Staff Only</option>
            </select>
        </div>
        
        <div class="att-filter-group" style="flex: 0 0 auto;">
            <label>&nbsp;</label>
            <button type="button" class="att-btn-primary" id="find">
                <i class="fa fa-search"></i> Get Report
            </button>
        </div>
    </div>
</div>

<!-- ===== LEGEND ===== -->
<div class="att-legend">
    <div class="att-legend-item"><span class="att-legend-dot" style="background: #22c55e;"></span> Present</div>
    <div class="att-legend-item"><span class="att-legend-dot" style="background: #ef4444;"></span> Absent</div>
    <div class="att-legend-item"><span class="att-legend-dot" style="background: #3b82f6;"></span> Half Day</div>
    <div class="att-legend-item"><span class="att-legend-dot" style="background: #f97316;"></span> Late</div>
    <div class="att-legend-item"><span class="att-legend-dot" style="background: #d1d5db;"></span> Not Marked</div>
</div>

<!-- ===== DATA AREA ===== -->
<div id="data">
    <?php if ($month != NULL && $year != NULL): ?>
        <?php include 'loadTeacherAttendanceReport.php'; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
            <i class="fa fa-calendar-o" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.4;"></i>
            <p style="font-size: 15px; font-weight: 500;">Select month and year, then click <strong>"Get Report"</strong> to view attendance</p>
        </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#find').on('click', function() {
            var month = $('#month').val();
            var year  = $('#year').val();
            var staff_type = $('#staff_type_filter').val();
            
            if (month == "" || year == "") {
                $.toast({
                    text: 'Please select month and year',
                    position: 'top-right',
                    loaderBg: '#f56954',
                    icon: 'warning',
                    hideAfter: 3500,
                    stack: 6
                });
                return false;
            }

            $('#data').html('<div style="text-align:center; padding: 60px;"><i class="fa fa-spinner fa-spin fa-3x" style="color: #6366f1;"></i><p style="margin-top: 16px; color: #94a3b8; font-size: 13px;">Loading attendance data...</p></div>');

            $.ajax({
                url: '<?php echo site_url('admin/loadTeacherAttendanceReport/');?>' + month + '/' + year,
                data: { staff_type: staff_type },
                success: function(response) {
                    $('#data').html(response);
                    
                    // Apply client-side search after data loads
                    $('#att_search').on('keyup', function() {
                        var val = $(this).val().toLowerCase();
                        $('.att-employee-row').each(function() {
                            var name = $(this).find('.att-emp-name').text().toLowerCase();
                            $(this).toggle(name.indexOf(val) > -1);
                        });
                    });
                }
            });
        });
    });
</script>
