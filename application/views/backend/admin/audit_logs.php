<!-- Audit Logs Viewer -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-history"></i>&nbsp;&nbsp;Audit Logs — Activity Trail</div>
            <div class="panel-body">
                <!-- Filter Bar -->
                <form method="GET" action="<?php echo base_url(); ?>admin/audit_logs" class="form-inline" style="margin-bottom:20px;">
                    <div class="form-group" style="margin-right:10px;">
                        <label>Module:</label>
                        <select name="module" class="form-control input-sm">
                            <option value="">All</option>
                            <option value="system" <?php if(isset($filters['module']) && $filters['module']=='system') echo 'selected'; ?>>System</option>
                            <option value="finance" <?php if(isset($filters['module']) && $filters['module']=='finance') echo 'selected'; ?>>Finance</option>
                            <option value="admission" <?php if(isset($filters['module']) && $filters['module']=='admission') echo 'selected'; ?>>Admission</option>
                            <option value="general" <?php if(isset($filters['module']) && $filters['module']=='general') echo 'selected'; ?>>General</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label>From:</label>
                        <input type="date" name="date_from" class="form-control input-sm" value="<?php echo isset($filters['date_from']) ? $filters['date_from'] : ''; ?>">
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label>To:</label>
                        <input type="date" name="date_to" class="form-control input-sm" value="<?php echo isset($filters['date_to']) ? $filters['date_to'] : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-filter"></i> Filter</button>
                    <a href="<?php echo base_url(); ?>admin/audit_logs" class="btn btn-default btn-sm btn-rounded"><i class="fa fa-refresh"></i> Reset</a>
                </form>

                <div class="table-responsive">
                    <table class="display nowrap" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th width="30">#</th>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Action</th>
                                <th>Module</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><small><?php echo $log['created_at']; ?></small></td>
                                <td><?php echo $log['user_name'] ? $log['user_name'] : 'System'; ?></td>
                                <td>
                                    <span class="label label-<?php 
                                        if ($log['role'] == 'admin') echo 'danger';
                                        elseif ($log['role'] == 'accountant') echo 'info';
                                        elseif ($log['role'] == 'admission') echo 'success';
                                        else echo 'default';
                                    ?>"><?php echo ucfirst($log['role']); ?></span>
                                </td>
                                <td><?php echo $log['action']; ?></td>
                                <td><span class="label label-default"><?php echo $log['module']; ?></span></td>
                                <td><small><?php echo $log['ip_address']; ?></small></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($logs)): ?>
                            <tr><td colspan="7" class="text-center">No audit logs found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
