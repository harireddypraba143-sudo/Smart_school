<?php if($month!=null && $year!=null):?>

<?php
    // Get staff_type filter from request
    $staff_type_filter = isset($_GET['staff_type']) ? $_GET['staff_type'] : (isset($_POST['staff_type']) ? $_POST['staff_type'] : 'all');

    // Fetch employees based on filter - NOW FROM SEPARATE TABLES
    $teaching = array();
    $non_teaching = array();
    
    if ($staff_type_filter == 'teaching' || $staff_type_filter == 'all') {
        $teaching = $this->db->get('teacher')->result_array();
    }
    
    if ($staff_type_filter == 'non_teaching' || $staff_type_filter == 'all') {
        $non_teaching = $this->db->get('staff')->result_array();
    }
    
    $all_employees = count($teaching) + count($non_teaching);
    
    $days = date("t", mktime(0,0,0,$month,1,$year));
    $full_date_display = date("F, Y", mktime(0,0,0,$month,1,$year));
    
    // Staff role labels
    $staff_roles = array(
        1 => 'Class Teacher', 2 => 'Subject Teacher',
        10 => 'Driver', 11 => 'Watchman', 12 => 'Peon',
        13 => 'Caretaker', 14 => 'Cook', 15 => 'Lab Asst.',
        16 => 'Clerk', 17 => 'Librarian', 18 => 'Sweeper',
        19 => 'Gardener', 20 => 'Helper', 99 => 'Other'
    );
    
    // Calculate summary stats
    $total_employees = $all_employees;
    $total_present = 0;
    $total_absent = 0;
    $total_late = 0;
    $total_halfday = 0;
    $total_records = 0;
    
    // Stats for teachers
    foreach($teaching as $emp) {
        for ($d=1; $d <= $days; $d++) {
            $fd = $year."-".$month."-".str_pad($d, 2, '0', STR_PAD_LEFT);
            $att = $this->db->get_where('teacher_attendance', array('teacher_id' => $emp['teacher_id'], 'date' => $fd))->row();
            if ($att) {
                $total_records++;
                if ($att->status == 1) $total_present++;
                elseif ($att->status == 2) $total_absent++;
                elseif ($att->status == 3) $total_late++;
                elseif ($att->status == 4) $total_halfday++;
            }
        }
    }
    
    // Stats for staff
    foreach($non_teaching as $emp) {
        for ($d=1; $d <= $days; $d++) {
            $fd = $year."-".$month."-".str_pad($d, 2, '0', STR_PAD_LEFT);
            $att = $this->db->get_where('staff_attendance', array('staff_id' => $emp['staff_id'], 'date' => $fd))->row();
            if ($att) {
                $total_records++;
                if ($att->status == 1) $total_present++;
                elseif ($att->status == 2) $total_absent++;
                elseif ($att->status == 3) $total_late++;
                elseif ($att->status == 4) $total_halfday++;
            }
        }
    }
?>

<!-- ===== MONTH HEADER ===== -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #0f172a;">
            <i class="fa fa-calendar" style="color: #6366f1; margin-right: 8px;"></i><?php echo $full_date_display; ?>
        </h3>
        <p style="margin: 4px 0 0; font-size: 12px; color: #94a3b8;">
            <?php echo $total_employees; ?> employees &bull; <?php echo $days; ?> working days
            <?php if($staff_type_filter != 'all'): ?>
                &bull; Filter: <strong><?php echo $staff_type_filter == 'teaching' ? 'Teachers Only' : 'Staff Only'; ?></strong>
            <?php endif; ?>
        </p>
    </div>
    <div style="display: flex; gap: 8px;">
        <button type="button" class="att-btn-outline" onclick="window.print();">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
</div>

<!-- ===== SUMMARY STATS ===== -->
<div class="att-stats-row">
    <div class="att-stat-card">
        <div class="stat-num" style="color: #0f172a;"><?php echo $total_employees; ?></div>
        <div class="stat-label">Total Staff</div>
    </div>
    <div class="att-stat-card">
        <div class="stat-num" style="color: #22c55e;"><?php echo $total_present; ?></div>
        <div class="stat-label">Present Days</div>
    </div>
    <div class="att-stat-card">
        <div class="stat-num" style="color: #ef4444;"><?php echo $total_absent; ?></div>
        <div class="stat-label">Absent Days</div>
    </div>
    <div class="att-stat-card">
        <div class="stat-num" style="color: #f97316;"><?php echo $total_late; ?></div>
        <div class="stat-label">Late Days</div>
    </div>
    <div class="att-stat-card">
        <div class="stat-num" style="color: #3b82f6;"><?php echo $total_halfday; ?></div>
        <div class="stat-label">Half Days</div>
    </div>
    <div class="att-stat-card">
        <div class="stat-num" style="color: #6366f1;">
            <?php echo $total_records > 0 ? round(($total_present / $total_records) * 100) : 0; ?>%
        </div>
        <div class="stat-label">Attendance Rate</div>
    </div>
</div>

<!-- ===== SEARCH ===== -->
<div class="att-search-box" style="max-width: 350px;">
    <i class="fa fa-search"></i>
    <input type="text" id="att_search" placeholder="Search employee by name...">
</div>

<!-- ===== ATTENDANCE TABLE ===== -->
<div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #f1f5f9;">
    <div style="overflow-x: auto;">
        <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="text-align: left; padding: 12px 14px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; min-width: 180px; border-bottom: 2px solid #e2e8f0; position: sticky; left: 0; background: #f8fafc; z-index: 1;">
                        Employee
                    </th>
                    <?php for ($i=0; $i < $days; $i++) { 
                        $day_num = $i + 1;
                        $day_date = mktime(0,0,0,$month,$day_num,$year);
                        $day_name = date('D', $day_date);
                        $is_sunday = (date('w', $day_date) == 0);
                    ?>
                        <th style="text-align: center; padding: 8px 2px; font-size: 10px; font-weight: 600; color: <?php echo $is_sunday ? '#ef4444' : '#64748b'; ?>; border-bottom: 2px solid #e2e8f0; min-width: 28px;">
                            <div><?php echo $day_name[0]; ?></div>
                            <div style="font-size: 11px; font-weight: 700; margin-top: 2px;"><?php echo str_pad($day_num, 2, '0', STR_PAD_LEFT);?></div>
                        </th>   
                    <?php } ?>
                    <th style="text-align: center; padding: 12px 8px; font-size: 10px; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.3px; border-bottom: 2px solid #e2e8f0; min-width: 36px;">P</th>
                    <th style="text-align: center; padding: 12px 8px; font-size: 10px; font-weight: 700; color: #ef4444; text-transform: uppercase; letter-spacing: 0.3px; border-bottom: 2px solid #e2e8f0; min-width: 36px;">A</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // === TEACHING STAFF SECTION ===
                if (!empty($teaching) && $staff_type_filter != 'non_teaching'):
                ?>
                <tr style="background: linear-gradient(90deg, #ecfdf5, #f0fdf4);">
                    <td colspan="<?php echo $days + 3; ?>" style="padding: 10px 14px; font-weight: 700; color: #15803d; font-size: 12px; border-bottom: 1px solid #e2e8f0;">
                        <i class="fa fa-graduation-cap" style="margin-right: 6px;"></i> Teaching Staff (<?php echo count($teaching); ?>)
                    </td>
                </tr>
                <?php foreach($teaching as $teacher): 
                    $p_count = 0; $a_count = 0;
                ?>
                    <tr class="att-employee-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                        <td style="padding: 10px 14px; position: sticky; left: 0; background: #fff; z-index: 1;">
                            <span class="att-emp-name" style="font-weight: 600; color: #1e293b; font-size: 12.5px;"><?php echo $teacher['name'];?></span>
                            <div style="font-size: 10px; color: #94a3b8; margin-top: 1px;">
                                <?php 
                                $designation = $this->db->get_where('designation', array('designation_id' => $teacher['designation_id']))->row();
                                echo $designation ? $designation->name : (isset($staff_roles[$teacher['role']]) ? $staff_roles[$teacher['role']] : 'Teacher');
                                ?>
                            </div>
                        </td>
                        
                        <?php for ($i=1; $i <= $days; $i++) {
                            $full_date = $year."-".$month."-".str_pad($i, 2, '0', STR_PAD_LEFT);
                            $attendance = $this->db->get_where('teacher_attendance', array('teacher_id' => $teacher['teacher_id'], 'date' => $full_date))->row();
                            $status = $attendance ? $attendance->status : 0;
                            if ($status == 1) $p_count++;
                            if ($status == 2) $a_count++;
                        ?>
                            <td style="text-align: center; vertical-align: middle; padding: 6px 2px;">
                                <?php if ($status == 0):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#e5e7eb;"></span>
                                <?php elseif ($status == 1):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#22c55e;"></span>
                                <?php elseif ($status == 2):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#ef4444;"></span>
                                <?php elseif ($status == 3):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#f97316;"></span>
                                <?php elseif ($status == 4):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#3b82f6;"></span>
                                <?php endif;?>
                            </td>    
                        <?php } ?>
                        <td style="text-align:center; font-weight:700; color:#22c55e; font-size:12px; padding:6px 4px;"><?php echo $p_count; ?></td>
                        <td style="text-align:center; font-weight:700; color:#ef4444; font-size:12px; padding:6px 4px;"><?php echo $a_count; ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                
                <?php 
                // === NON-TEACHING STAFF SECTION ===
                if (!empty($non_teaching) && $staff_type_filter != 'teaching'):
                ?>
                <tr style="background: linear-gradient(90deg, #fff7ed, #fffbeb);">
                    <td colspan="<?php echo $days + 3; ?>" style="padding: 10px 14px; font-weight: 700; color: #c2410c; font-size: 12px; border-bottom: 1px solid #e2e8f0;">
                        <i class="fa fa-wrench" style="margin-right: 6px;"></i> Non-Teaching Staff (<?php echo count($non_teaching); ?>)
                    </td>
                </tr>
                <?php foreach($non_teaching as $staff_member): 
                    $p_count = 0; $a_count = 0;
                ?>
                    <tr class="att-employee-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                        <td style="padding: 10px 14px; position: sticky; left: 0; background: #fff; z-index: 1;">
                            <span class="att-emp-name" style="font-weight: 600; color: #1e293b; font-size: 12.5px;"><?php echo $staff_member['name'];?></span>
                            <div style="font-size: 10px; color: #94a3b8; margin-top: 1px;">
                                <?php echo isset($staff_roles[$staff_member['role']]) ? $staff_roles[$staff_member['role']] : 'Staff'; ?>
                            </div>
                        </td>
                        
                        <?php for ($i=1; $i <= $days; $i++) {
                            $full_date = $year."-".$month."-".str_pad($i, 2, '0', STR_PAD_LEFT);
                            $attendance = $this->db->get_where('staff_attendance', array('staff_id' => $staff_member['staff_id'], 'date' => $full_date))->row();
                            $status = $attendance ? $attendance->status : 0;
                            if ($status == 1) $p_count++;
                            if ($status == 2) $a_count++;
                        ?>
                            <td style="text-align: center; vertical-align: middle; padding: 6px 2px;">
                                <?php if ($status == 0):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#e5e7eb;"></span>
                                <?php elseif ($status == 1):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#22c55e;"></span>
                                <?php elseif ($status == 2):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#ef4444;"></span>
                                <?php elseif ($status == 3):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#f97316;"></span>
                                <?php elseif ($status == 4):?>
                                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#3b82f6;"></span>
                                <?php endif;?>
                            </td>    
                        <?php } ?>
                        <td style="text-align:center; font-weight:700; color:#22c55e; font-size:12px; padding:6px 4px;"><?php echo $p_count; ?></td>
                        <td style="text-align:center; font-weight:700; color:#ef4444; font-size:12px; padding:6px 4px;"><?php echo $a_count; ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                
                <?php if(empty($all_employees)): ?>
                <tr>
                    <td colspan="<?php echo $days + 3; ?>" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="fa fa-inbox" style="font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                        No employees found for selected filter
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>
