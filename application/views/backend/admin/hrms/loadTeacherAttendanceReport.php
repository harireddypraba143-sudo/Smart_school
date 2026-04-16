<?php if($month!=null && $year!=null):?>

<div class="row" align="center">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <h3 style="color: #696969;">Teacher Attendance Sheet</h3>
                    <?php
                        $full_date = "1"."-".$month."-".$year;
                        $full_date = date_create($full_date);
                        $full_date = date_format($full_date,"F, Y");
                    ?>
                    <h4 style="color: #696969;"><?php echo $full_date; ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>

<div class="row" align="center">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body table-responsive">
                    <div align="center">
                        KEYS: 
                        Present&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #00a651;"></i>&nbsp;&nbsp;
                        Absent&nbsp;-&nbsp;<i class="fa fa-circle" style="color: #EE4749;"></i>&nbsp;&nbsp;
                        Half Day&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #0000FF;"></i>&nbsp;&nbsp;
                        Late&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #FF6600;"></i>&nbsp;&nbsp;
                        Undefine&nbsp;-&nbsp;<i class="fa fa-circle" style="color: black;"></i>
                    </div>
                                
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="margin-top:20px;">
                        <thead>
                            <tr>
                                <th style="text-align: left; min-width: 150px;">Teacher | Date:</th>
                                <?php
                                $days = date("t", mktime(0,0,0,$month,1,$year)); 
                                for ($i=0; $i < $days; $i++) { 
                                ?>
                                    <th style="text-align: center; padding: 5px;"><?php echo str_pad(($i+1), 2, '0', STR_PAD_LEFT);?></th>   
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Fetch all active teachers
                            $teachers = $this->db->get('teacher')->result_array();
                            
                            foreach($teachers as $teacher) {
                            ?>
                                <tr class="gradeA">
                                    <td align="left">
                                        <strong><?php echo $teacher['name'];?></strong>
                                        <div style="font-size:10px; color:#999;">
                                            <?php 
                                            // Get designation if exists
                                            $designation = $this->db->get_where('designation', array('designation_id' => $teacher['designation_id']))->row();
                                            echo $designation ? $designation->name : 'Staff';
                                            ?>
                                        </div>
                                    </td>
                                    
                                    <?php 
                                    for ($i=1; $i <= $days; $i++) {
                                        $full_date = $year."-".$month."-".str_pad($i, 2, '0', STR_PAD_LEFT);
                                        $verify_data = array('teacher_id' => $teacher['teacher_id'], 'date' => $full_date);
                                        $attendance = $this->db->get_where('teacher_attendance', $verify_data)->row();
                                        
                                        $status = $attendance ? $attendance->status : 0;
                                    ?>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <?php if ($status == 0):?>
                                                <i class="fa fa-circle" style="color: #e5e5e5;" title="Undefined"></i>
                                            <?php elseif ($status == 1):?>
                                                <i class="fa fa-circle" style="color: #00a651;" title="Present"></i>
                                            <?php elseif ($status == 2):?>
                                                <i class="fa fa-circle" style="color: #EE4749;" title="Absent"></i>
                                            <?php elseif ($status == 3):?>
                                                <i class="fa fa-circle" style="color: #FF6600;" title="Late"></i>
                                            <?php elseif ($status == 4):?>
                                                <i class="fa fa-circle" style="color: #0000FF;" title="Half Day"></i>
                                            <?php endif;?>
                                        </td>    
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
