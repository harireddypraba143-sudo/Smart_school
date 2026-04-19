<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-id-badge"></i>&nbsp;&nbsp;ID Card Generator (CR80 PVC)</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <?php echo form_open(base_url() . 'admin/print_id_card', array('class' => 'form-horizontal', 'target' => '_blank')); ?>
                    
                    <div class="row">
                        <!-- Role Selector -->
                        <div class="col-md-3">
                            <div class="form-group" style="padding: 0 15px;">
                                <label class="control-label" style="display:block; text-align:left; margin-bottom:5px;">Target Role <span class="text-danger">*</span></label>
                                <select name="user_type" class="form-control select2" id="user_type" required onchange="toggle_class_selection(this.value)">
                                    <option value="">Select Role</option>
                                    <option value="student">Student (Blue Theme)</option>
                                    <option value="teacher">Teacher (Green Theme)</option>
                                    <option value="staff">Staff (Orange Theme)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Class Selector (Only for Students) -->
                        <div class="col-md-3" id="class_selector_div" style="display: none;">
                            <div class="form-group" style="padding: 0 15px;">
                                <label class="control-label" style="display:block; text-align:left; margin-bottom:5px;">Class <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control select2" id="class_id" onchange="get_class_sections(this.value)">
                                    <option value="">Select Class</option>
                                    <?php 
                                    $classes = $this->db->get('class')->result_array();
                                    foreach($classes as $row):
                                    ?>
                                        <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <!-- Section Selector -->
                        <div class="col-md-3" id="section_selector_div" style="display: none;">
                            <div class="form-group" style="padding: 0 15px;">
                                <label class="control-label" style="display:block; text-align:left; margin-bottom:5px;">Section</label>
                                <select name="section_id" class="form-control select2" id="section_selector_holder">
                                    <option value="">All Sections</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Auto-Generation Options -->
                        <div class="col-md-3">
                            <div class="form-group" style="padding: 0 15px;">
                                <label class="control-label" style="display:block; text-align:left; margin-bottom:5px;">Validity Session</label>
                                <input type="text" name="session_validity" class="form-control" value="<?php echo date('Y') . '-' . (date('Y') + 1); ?>" placeholder="e.g. 2026-2027" required>
                                <small class="text-muted">Printed on card</small>
                            </div>
                        </div>

                    </div>
                    
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning" style="border-left: 5px solid #f59e0b; background-color: #fffbeb;">
                                <strong><i class="fa fa-info-circle"></i> Print Instructions:</strong><br>
                                This tool generates <strong>CR80 physical ID cards</strong>. It relies on a dedicated PVC Card Printer. <br>
                                The server will process a maximum of <strong>100 cards per request</strong> to prevent crashing. If a class has more than 100 students, you should generate them by specific section.
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-info btn-rounded btn-block" style="max-width: 300px; margin: 0 auto; padding: 12px 0; font-size: 16px;">
                                    <i class="fa fa-print"></i> Generate Printable ID Cards
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

<script type="text/javascript">
    function toggle_class_selection(user_type) {
        if(user_type === 'student') {
            document.getElementById('class_selector_div').style.display = 'block';
            document.getElementById('section_selector_div').style.display = 'block';
            document.getElementById('class_id').setAttribute('required', 'required');
        } else {
            document.getElementById('class_selector_div').style.display = 'none';
            document.getElementById('section_selector_div').style.display = 'none';
            document.getElementById('class_id').removeAttribute('required');
            document.getElementById('class_id').value = ''; 
        }
    }

    function get_class_sections(class_id) {
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
                success: function(response) {
                    jQuery('#section_selector_holder').html(response);
                }
            });
        }
    }
</script>
