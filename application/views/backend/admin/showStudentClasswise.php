<?php if (!isset($class_id) || $class_id == ''): ?>
<div class="text-center" style="padding: 30px; color: #999;">
    <i class="fa fa-info-circle fa-2x"></i>
    <p style="margin-top: 10px;">Please select a class and click <strong>Get Student</strong> to view students.</p>
</div>
<?php else: ?>
<table id="example" class="table display">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                            <th><div><?php echo get_phrase('Image');?></div></th>
                            <th><div>Admission No</div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                    		<th><div><?php echo get_phrase('class');?></div></th>
                            <th><div>Session</div></th>
                            <th><div>Status</div></th>
                    		<th><div><?php echo get_phrase('sex');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('parent');?></div></th>
                    		<th><div><?php echo get_phrase('actions');?></div></th>
				</tr>
			</thead>
                    <tbody>
    
                    <?php $counter = 1; $students =  $this->db->get_where('student', array('class_id' => $class_id))->result_array();
                    foreach($students as $key => $student):?>         
                        <tr>
                            <td><?php echo $counter++;?></td>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student', $student['student_id']);?>" class="img-circle" width="30"></td>
                            <td><strong style="color: #667eea;"><?php echo isset($student['admission_no']) && $student['admission_no'] ? $student['admission_no'] : '—';?></strong></td>
                            <td><?php echo $student['name'];?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('class', $student['class_id']);?></td>
                            <td><?php echo isset($student['session']) ? $student['session'] : '—';?></td>
                            <td>
                                <?php 
                                $status = isset($student['student_status']) ? $student['student_status'] : 'active';
                                if ($status == 'active') {
                                    echo '<span class="label label-success" style="font-size:11px;">✅ Active</span>';
                                } elseif ($status == 'left') {
                                    echo '<span class="label label-warning" style="font-size:11px;">🚪 Left</span>';
                                } elseif ($status == 'completed') {
                                    echo '<span class="label label-info" style="font-size:11px;">🎓 Completed</span>';
                                } else {
                                    echo '<span class="label label-default" style="font-size:11px;">' . ucfirst($status) . '</span>';
                                }
                                ?>
                            </td>
						<td><?php echo $student['sex'];?></td>
                            <td><?php echo $student['phone'];?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('parent', $student['parent_id']);?></td>
						<td>
						
				     <a href="<?php echo base_url();?>admin/edit_student/<?php echo $student['student_id'];?>" ><button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-pencil"></i></button></a>
				 <a href="#" onclick="confirm_modal('<?php echo base_url();?>admin/new_student/delete/<?php echo $student['student_id'];?>');"><button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-times"></i></button></a>
                     <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/resetstudentPassword/<?php echo $student['student_id'];?>')" class="btn btn-success btn-circle btn-xs"><i class="fa fa-key"></i></a>

			
                           
        					</td>
                        </tr>
    <?php endforeach;?>
                    </tbody>
                </table>
<?php endif; ?>