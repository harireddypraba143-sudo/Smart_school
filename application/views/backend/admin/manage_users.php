<!-- Manage Users — Enterprise RBAC -->
<div class="row">
    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;Create New Staff User</div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'admin/manage_users/create', array('class' => 'form-horizontal validate', 'target' => '_top')); ?>
                
                <div class="form-group">
                    <label class="col-sm-12">Full Name *</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="name" required placeholder="Enter full name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-12">Email *</label>
                    <div class="col-sm-12">
                        <input type="email" class="form-control" name="email" required placeholder="Enter email address">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-12">Phone</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="phone" placeholder="Enter phone number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-12">Password *</label>
                    <div class="col-sm-12">
                        <input type="password" class="form-control" name="password" required minlength="6" placeholder="Min 6 characters">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-12">Role *</label>
                    <div class="col-sm-12">
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['role_id']; ?>"><?php echo ucfirst($role['name']); ?> — <?php echo $role['description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-info btn-rounded btn-block"><i class="fa fa-plus"></i>&nbsp;Create User</button>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-users"></i>&nbsp;&nbsp;All Staff Users</div>
            <div class="panel-body table-responsive">
                <table class="display nowrap" cellspacing="0" width="100%" id="example23">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td>
                                <span class="label label-<?php 
                                    if ($user['role_name'] == 'admin') echo 'danger';
                                    elseif ($user['role_name'] == 'accountant') echo 'info';
                                    elseif ($user['role_name'] == 'admission') echo 'success';
                                    else echo 'default';
                                ?>"><?php echo ucfirst($user['role_name']); ?></span>
                            </td>
                            <td>
                                <?php if ($user['is_locked']): ?>
                                    <span class="label label-danger"><i class="fa fa-lock"></i> Locked</span>
                                    <a href="<?php echo base_url(); ?>admin/manage_users/unlock/<?php echo $user['user_id']; ?>" class="btn btn-warning btn-xs btn-rounded">Unlock</a>
                                <?php elseif ($user['login_status']): ?>
                                    <span class="label label-success"><i class="fa fa-circle"></i> Online</span>
                                <?php else: ?>
                                    <span class="label label-default"><i class="fa fa-circle-o"></i> Offline</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-info btn-circle btn-xs" data-toggle="modal" data-target="#editModal<?php echo $user['user_id']; ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <!-- Password Button -->
                                <button type="button" class="btn btn-warning btn-circle btn-xs" data-toggle="modal" data-target="#passModal<?php echo $user['user_id']; ?>">
                                    <i class="fa fa-key"></i>
                                </button>
                                <!-- Delete Button -->
                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>admin/manage_users/delete/<?php echo $user['user_id']; ?>');">
                                    <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-times"></i></button>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $user['user_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit User: <?php echo $user['name']; ?></h4>
                                    </div>
                                    <?php echo form_open(base_url() . 'admin/manage_users/update/' . $user['user_id'], array('target' => '_top')); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $user['phone']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role_id" class="form-control" required>
                                                <?php foreach ($roles as $role): ?>
                                                <option value="<?php echo $role['role_id']; ?>" <?php if ($role['role_id'] == $user['role_id']) echo 'selected'; ?>><?php echo ucfirst($role['name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-check"></i> Update</button>
                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Modal -->
                        <div class="modal fade" id="passModal<?php echo $user['user_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Change Password: <?php echo $user['name']; ?></h4>
                                    </div>
                                    <?php echo form_open(base_url() . 'admin/manage_users/change_password/' . $user['user_id'], array('target' => '_top')); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" name="password" required minlength="6" placeholder="Enter new password (min 6 chars)">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning btn-sm btn-rounded"><i class="fa fa-key"></i> Change Password</button>
                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
