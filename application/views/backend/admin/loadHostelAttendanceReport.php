<?php if($month!=null && $year!=null):?>

<div class="row" align="center">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <h3 style="color: #696969;">Hostel Attendance Sheet</h3>
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
                        Checked In&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #00a651;"></i>&nbsp;&nbsp;
                        Checked Out&nbsp;-&nbsp;<i class="fa fa-circle" style="color: #EE4749;"></i>&nbsp;&nbsp;
                        Late&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #FF6600;"></i>&nbsp;&nbsp;
                        No Scan&nbsp;-&nbsp;<i class="fa fa-circle" style="color:#e5e5e5;"></i>
                    </div>
                                
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="margin-top:20px;">
                        <thead>
                            <tr>
                                <th style="text-align: left; min-width: 150px;">Student | Dorm | Date:</th>
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
                            // Fetch all students who are assigned to a dormitory
                            $this->db->where('dormitory_id !=', '');
                            $this->db->where('dormitory_id !=', '0');
                            $students = $this->db->get('student')->result_array();
                            
                            foreach($students as $student) {
                                // Get dorm info
                                $dorm = $this->db->get_where('dormitory', array('dormitory_id' => $student['dormitory_id']))->row();
                            ?>
                                <tr class="gradeA">
                                    <td align="left">
                                        <strong><?php echo $student['name'];?></strong>
                                        <div style="font-size:10px; color:#666;">
                                            <i class="fa fa-bed"></i> <?php echo $dorm ? $dorm->name : 'Unknown Dorm'; ?> 
                                            (Room: <?php echo $student['dormitory_room_number']; ?>)
                                        </div>
                                    </td>
                                    
                                    <?php 
                                    for ($i=1; $i <= $days; $i++) {
                                        $full_date = $year."-".$month."-".str_pad($i, 2, '0', STR_PAD_LEFT);
                                        $verify_data = array('student_id' => $student['student_id'], 'date' => $full_date);
                                        $attendance = $this->db->get_where('hostel_attendance', $verify_data)->row();
                                        
                                        $status = $attendance ? $attendance->status : 0;
                                    ?>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <?php if ($status == 0):?>
                                                <i class="fa fa-circle" style="color: #e5e5e5;" title="No Scan"></i>
                                            <?php elseif ($status == 1):?>
                                                <i class="fa fa-circle" style="color: #00a651;" title="Checked In"></i>
                                            <?php elseif ($status == 2):?>
                                                <i class="fa fa-circle" style="color: #EE4749;" title="Checked Out"></i>
                                            <?php elseif ($status == 3):?>
                                                <i class="fa fa-circle" style="color: #FF6600;" title="Late Check-In"></i>
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
