<!-- RFID / Card Machine Setup -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-id-card"></i>&nbsp;&nbsp;RFID / Card Machine Setup
                <span class="pull-right">
                    <span class="label label-info"><?php echo count($devices); ?> Device(s)</span>
                </span>
            </div>
            <div class="panel-body">

                <!-- Global RFID Settings -->
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-sm-12">
                        <h4><i class="fa fa-cog"></i> Global RFID Settings</h4>
                        <hr style="margin-top:5px;">
                        <?php echo form_open(base_url() . 'systemsetting/rfid_settings/update_rfid_settings', array('class' => 'form-inline')); ?>
                            <div class="form-group" style="margin-right:20px;">
                                <label>Scan Cooldown (seconds): &nbsp;</label>
                                <input type="number" class="form-control" name="rfid_scan_cooldown" 
                                    value="<?php echo $this->db->get_where('settings', array('type' => 'rfid_scan_cooldown'))->row()->description; ?>" 
                                    min="10" max="300" style="width:100px;">
                            </div>
                            <div class="form-group" style="margin-right:20px;">
                                <label>Late Threshold Time: &nbsp;</label>
                                <input type="time" class="form-control" name="rfid_late_threshold" 
                                    value="<?php echo $this->db->get_where('settings', array('type' => 'rfid_late_threshold'))->row()->description; ?>" 
                                    style="width:150px;">
                            </div>
                            <button type="submit" class="btn btn-success btn-sm btn-rounded">
                                <i class="fa fa-save"></i>&nbsp;Save Settings
                            </button>
                        <?php echo form_close(); ?>
                    </div>
                </div>

                <!-- Add Device Form -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4><i class="fa fa-plus-circle"></i> Add New Device</h4>
                        <hr style="margin-top:5px;">
                        <?php echo form_open(base_url() . 'systemsetting/rfid_settings/create_device', array('class' => 'form-horizontal')); ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Device Name *</label>
                                        <input type="text" class="form-control" name="device_name" placeholder="e.g. Main Gate ZKTeco" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Brand *</label>
                                        <select class="form-control" name="device_brand" required>
                                            <option value="">Select Brand</option>
                                            <option value="zkteco">ZKTeco</option>
                                            <option value="essl">eSSL</option>
                                            <option value="hikvision">Hikvision</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Device Type *</label>
                                        <select class="form-control" name="device_type" required>
                                            <option value="school">School Campus</option>
                                            <option value="hostel">Hostel Building</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Device IP Address *</label>
                                        <input type="text" class="form-control" name="device_ip" placeholder="192.168.1.100" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Serial Number *</label>
                                        <input type="text" class="form-control" name="device_serial" placeholder="Device serial number" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" placeholder="e.g. Main Entrance">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm">
                                            <i class="fa fa-plus"></i>&nbsp;Add Device
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Registered Devices List -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-list"></i>&nbsp;&nbsp;Registered Devices</div>
            <div class="panel-body table-responsive">
                <?php if (count($devices) > 0): ?>
                <table id="rfid_devices_table" class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Device Name</th>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>IP Address</th>
                            <th>Serial</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Last Heartbeat</th>
                            <th>API Key</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($devices as $device): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><strong><?php echo $device['device_name']; ?></strong></td>
                            <td>
                                <?php 
                                $brand_colors = array('zkteco' => 'success', 'essl' => 'info', 'hikvision' => 'warning');
                                $color = isset($brand_colors[$device['device_brand']]) ? $brand_colors[$device['device_brand']] : 'default';
                                ?>
                                <span class="label label-<?php echo $color; ?>"><?php echo strtoupper($device['device_brand']); ?></span>
                            </td>
                            <td>
                                <?php if ($device['device_type'] == 'hostel'): ?>
                                    <span class="label label-info"><i class="fa fa-bed"></i> Hostel</span>
                                <?php else: ?>
                                    <span class="label label-primary"><i class="fa fa-building"></i> School</span>
                                <?php endif; ?>
                            </td>
                            <td><code><?php echo $device['device_ip']; ?></code></td>
                            <td><code><?php echo $device['device_serial']; ?></code></td>
                            <td><?php echo $device['location']; ?></td>
                            <td>
                                <?php if ($device['status'] == 1): ?>
                                    <span class="label label-success"><i class="fa fa-check"></i> Active</span>
                                <?php else: ?>
                                    <span class="label label-danger"><i class="fa fa-times"></i> Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($device['last_heartbeat']): ?>
                                    <small><?php echo date('d M Y H:i', strtotime($device['last_heartbeat'])); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">Never</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <code style="font-size:10px;" title="<?php echo $device['api_key']; ?>">
                                    <?php echo substr($device['api_key'], 0, 12); ?>...
                                </code>
                                <a href="<?php echo base_url(); ?>systemsetting/rfid_settings/regenerate_key/<?php echo $device['device_id']; ?>"
                                   class="btn btn-xs btn-warning" title="Regenerate API Key"
                                   onclick="return confirm('Regenerate API key? The device will need to be reconfigured.');">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#editDevice<?php echo $device['device_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <a href="<?php echo base_url(); ?>systemsetting/rfid_settings/delete_device/<?php echo $device['device_id']; ?>"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Delete this device?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editDevice<?php echo $device['device_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        <h4 class="modal-title">Edit Device: <?php echo $device['device_name']; ?></h4>
                                    </div>
                                    <?php echo form_open(base_url() . 'systemsetting/rfid_settings/update_device/' . $device['device_id']); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Device Name</label>
                                            <input type="text" class="form-control" name="device_name" value="<?php echo $device['device_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <select class="form-control" name="device_brand">
                                                <option value="zkteco" <?php if ($device['device_brand'] == 'zkteco') echo 'selected'; ?>>ZKTeco</option>
                                                <option value="essl" <?php if ($device['device_brand'] == 'essl') echo 'selected'; ?>>eSSL</option>
                                                <option value="hikvision" <?php if ($device['device_brand'] == 'hikvision') echo 'selected'; ?>>Hikvision</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Device Type</label>
                                            <select class="form-control" name="device_type">
                                                <option value="school" <?php if ($device['device_type'] == 'school') echo 'selected'; ?>>School Campus</option>
                                                <option value="hostel" <?php if ($device['device_type'] == 'hostel') echo 'selected'; ?>>Hostel Building</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>IP Address</label>
                                            <input type="text" class="form-control" name="device_ip" value="<?php echo $device['device_ip']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Serial Number</label>
                                            <input type="text" class="form-control" name="device_serial" value="<?php echo $device['device_serial']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" class="form-control" name="location" value="<?php echo $device['location']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1" <?php if ($device['status'] == 1) echo 'selected'; ?>>Active</option>
                                                <option value="0" <?php if ($device['status'] == 0) echo 'selected'; ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-info">Update Device</button>
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
                        <i class="fa fa-info-circle"></i>&nbsp;No RFID devices registered yet. Use the form above to add your first device.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- API Integration Guide -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-code"></i>&nbsp;&nbsp;API Integration Guide</div>
            <div class="panel-body">
                <h5><strong>Push Endpoint:</strong></h5>
                <pre style="background:#f5f5f5; padding:10px; border-radius:5px;">POST <?php echo base_url(); ?>rfidapi/push

Content-Type: application/json

{
    "device_serial": "YOUR_SERIAL",
    "api_key": "YOUR_API_KEY",
    "card_number": "CARD_UID",
    "scan_time": "2026-04-14 09:00:00",
    "direction": "in"
}</pre>
                <h5><strong>Heartbeat Endpoint:</strong></h5>
                <pre style="background:#f5f5f5; padding:10px; border-radius:5px;">GET <?php echo base_url(); ?>rfidapi/heartbeat/YOUR_SERIAL</pre>
                <div class="alert alert-warning" style="margin-top:10px;">
                    <i class="fa fa-shield"></i>&nbsp;<strong>Security:</strong> Each device has a unique API key. The <code>device_serial</code> and <code>api_key</code> must match for the request to be accepted.
                    Duplicate scans within the cooldown window are automatically rejected.
                </div>
            </div>
        </div>
    </div>
</div>
