<!-- RFID Card Assignment -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-credit-card"></i>&nbsp;&nbsp;Assign RFID Card
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'systemsetting/rfid_cards/assign', array('class' => 'form-horizontal')); ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Card Number / UID *</label>
                                <input type="text" class="form-control" name="card_number" placeholder="e.g. A1B2C3D4" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>User Type *</label>
                                <select class="form-control" name="user_type" id="rfid_user_type" onchange="rfid_load_users(this.value)" required>
                                    <option value="">Select Type</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher / Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Select User *</label>
                                <select class="form-control select2" name="user_id" id="rfid_user_select" required>
                                    <option value="">Select user type first</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm">
                                    <i class="fa fa-link"></i>&nbsp;Assign Card
                                </button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Cards List -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-list"></i>&nbsp;&nbsp;Assigned Cards 
                <span class="label label-info pull-right"><?php echo count($cards); ?> Card(s)</span>
            </div>
            <div class="panel-body table-responsive">
                <?php if (count($cards) > 0): ?>
                <table id="rfid_cards_table" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Card Number</th>
                            <th>User Type</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Assigned Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($cards as $card): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><code style="font-size:13px;"><?php echo $card['card_number']; ?></code></td>
                            <td>
                                <?php if ($card['user_type'] == 'student'): ?>
                                    <span class="label label-primary"><i class="fa fa-graduation-cap"></i> Student</span>
                                <?php else: ?>
                                    <span class="label label-success"><i class="fa fa-user"></i> Teacher</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo $this->crud_model->get_rfid_user_name($card['user_type'], $card['user_id']); ?></strong>
                            </td>
                            <td>
                                <?php if ($card['status'] == 1): ?>
                                    <span class="label label-success">Active</span>
                                <?php else: ?>
                                    <span class="label label-danger">Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d M Y', strtotime($card['assigned_at'])); ?></td>
                            <td>
                                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#editCard<?php echo $card['card_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <a href="<?php echo base_url(); ?>systemsetting/rfid_cards/delete/<?php echo $card['card_id']; ?>"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Remove this card assignment?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Card Modal -->
                        <div class="modal fade" id="editCard<?php echo $card['card_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        <h4 class="modal-title">Edit Card: <?php echo $card['card_number']; ?></h4>
                                    </div>
                                    <?php echo form_open(base_url() . 'systemsetting/rfid_cards/update/' . $card['card_id']); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Card Number</label>
                                            <input type="text" class="form-control" name="card_number" value="<?php echo $card['card_number']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select class="form-control" name="user_type">
                                                <option value="student" <?php if ($card['user_type'] == 'student') echo 'selected'; ?>>Student</option>
                                                <option value="teacher" <?php if ($card['user_type'] == 'teacher') echo 'selected'; ?>>Teacher</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>User ID</label>
                                            <input type="number" class="form-control" name="user_id" value="<?php echo $card['user_id']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="card_status">
                                                <option value="1" <?php if ($card['status'] == 1) echo 'selected'; ?>>Active</option>
                                                <option value="0" <?php if ($card['status'] == 0) echo 'selected'; ?>>Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-info">Update Card</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>&nbsp;No RFID cards assigned yet. Use the form above to assign a card to a student or teacher.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function rfid_load_users(user_type) {
    var select = document.getElementById('rfid_user_select');
    select.innerHTML = '<option value="">Loading...</option>';

    if (user_type === 'student') {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_rfid_students',
            success: function(response) {
                select.innerHTML = '<option value="">Select Student</option>' + response;
            }
        });
    } else if (user_type === 'teacher') {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_rfid_teachers',
            success: function(response) {
                select.innerHTML = '<option value="">Select Teacher</option>' + response;
            }
        });
    } else {
        select.innerHTML = '<option value="">Select user type first</option>';
    }
}
</script>
