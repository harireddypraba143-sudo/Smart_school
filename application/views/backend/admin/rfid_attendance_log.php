<!-- RFID Attendance Log -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter Scan Logs
            </div>
            <div class="panel-body">
                <form method="GET" action="<?php echo base_url(); ?>systemsetting/rfid_attendance_log" class="form-inline">
                    <div class="form-group" style="margin-right:10px;">
                        <label>From: &nbsp;</label>
                        <input type="date" class="form-control" name="date_from" 
                            value="<?php echo isset($filters['date_from']) ? $filters['date_from'] : date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label>To: &nbsp;</label>
                        <input type="date" class="form-control" name="date_to" 
                            value="<?php echo isset($filters['date_to']) ? $filters['date_to'] : date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label>Device: &nbsp;</label>
                        <select class="form-control" name="device_id">
                            <option value="">All Devices</option>
                            <?php foreach ($devices as $device): ?>
                                <option value="<?php echo $device['device_id']; ?>" 
                                    <?php if (isset($filters['device_id']) && $filters['device_id'] == $device['device_id']) echo 'selected'; ?>>
                                    <?php echo $device['device_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label>Type: &nbsp;</label>
                        <select class="form-control" name="user_type">
                            <option value="all">All</option>
                            <option value="student" <?php if (isset($filters['user_type']) && $filters['user_type'] == 'student') echo 'selected'; ?>>Students</option>
                            <option value="teacher" <?php if (isset($filters['user_type']) && $filters['user_type'] == 'teacher') echo 'selected'; ?>>Teachers</option>
                            <option value="unknown" <?php if (isset($filters['user_type']) && $filters['user_type'] == 'unknown') echo 'selected'; ?>>Unknown</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm btn-rounded">
                        <i class="fa fa-search"></i>&nbsp;Filter
                    </button>
                    <a href="<?php echo base_url(); ?>systemsetting/rfid_attendance_log" class="btn btn-default btn-sm btn-rounded">
                        <i class="fa fa-refresh"></i>&nbsp;Reset
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scan Log Table -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-list-alt"></i>&nbsp;&nbsp;Scan Log
                <span class="pull-right">
                    <span class="label label-info"><?php echo count($logs); ?> Record(s)</span>
                    <button class="btn btn-xs btn-success" onclick="location.reload();" title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </button>
                </span>
            </div>
            <div class="panel-body table-responsive">
                <?php if (count($logs) > 0): ?>
                
                <!-- Summary Stats -->
                <div class="row" style="margin-bottom:15px;">
                    <?php
                    $total_scans = count($logs);
                    $synced_count = 0;
                    $student_count = 0;
                    $teacher_count = 0;
                    $unknown_count = 0;
                    foreach ($logs as $l) {
                        if ($l['synced'] == 1) $synced_count++;
                        if ($l['user_type'] == 'student') $student_count++;
                        elseif ($l['user_type'] == 'teacher') $teacher_count++;
                        else $unknown_count++;
                    }
                    ?>
                    <div class="col-sm-3">
                        <div class="white-box text-center" style="padding:10px;">
                            <h3 class="text-info" style="margin-bottom:0;"><?php echo $total_scans; ?></h3>
                            <small>Total Scans</small>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="white-box text-center" style="padding:10px;">
                            <h3 class="text-success" style="margin-bottom:0;"><?php echo $synced_count; ?></h3>
                            <small>Synced to Attendance</small>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="white-box text-center" style="padding:10px;">
                            <h3 class="text-primary" style="margin-bottom:0;"><?php echo $student_count; ?> / <?php echo $teacher_count; ?></h3>
                            <small>Students / Teachers</small>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="white-box text-center" style="padding:10px;">
                            <h3 class="text-warning" style="margin-bottom:0;"><?php echo $unknown_count; ?></h3>
                            <small>Unassigned Cards</small>
                        </div>
                    </div>
                </div>

                <table id="rfid_log_table" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Scan Time</th>
                            <th>Card Number</th>
                            <th>User Type</th>
                            <th>User Name</th>
                            <th>Device</th>
                            <th>Direction</th>
                            <th>Synced</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
                                <strong><?php echo date('d M Y', strtotime($log['scan_time'])); ?></strong><br>
                                <small class="text-muted"><?php echo date('H:i:s', strtotime($log['scan_time'])); ?></small>
                            </td>
                            <td><code><?php echo $log['card_number']; ?></code></td>
                            <td>
                                <?php if ($log['user_type'] == 'student'): ?>
                                    <span class="label label-primary"><i class="fa fa-graduation-cap"></i> Student</span>
                                <?php elseif ($log['user_type'] == 'teacher'): ?>
                                    <span class="label label-success"><i class="fa fa-user"></i> Teacher</span>
                                <?php else: ?>
                                    <span class="label label-warning"><i class="fa fa-question"></i> Unknown</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                if ($log['user_id'] > 0) {
                                    echo $this->crud_model->get_rfid_user_name($log['user_type'], $log['user_id']);
                                } else {
                                    echo '<span class="text-muted">—</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <small><?php echo isset($log['device_name']) ? $log['device_name'] : 'Unknown'; ?></small>
                            </td>
                            <td>
                                <?php if ($log['direction'] == 'in'): ?>
                                    <span class="label label-success"><i class="fa fa-sign-in"></i> IN</span>
                                <?php else: ?>
                                    <span class="label label-danger"><i class="fa fa-sign-out"></i> OUT</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($log['synced'] == 1): ?>
                                    <span class="label label-success"><i class="fa fa-check"></i></span>
                                <?php else: ?>
                                    <span class="label label-default"><i class="fa fa-clock-o"></i></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>&nbsp;No scan records found for the selected filters. 
                        RFID devices will push scan data here in real-time.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh every 30 seconds -->
<script type="text/javascript">
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
