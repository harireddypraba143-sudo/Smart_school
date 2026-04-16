
<div class="row">
    <div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('Enter Student Score');?></div>
                <div class="panel-body table-responsive">
			
                    <!----CREATION FORM STARTS---->

                	<?php echo form_open(base_url() . 'admin/marks' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                    
                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Exam');?></label>
                                <div class="col-sm-12">
                                    <select name="exam_id" class="form-control select2">
                                        <option value=""><?php echo get_phrase('select_class');?></option>

                                        <?php $exams =  $this->db->get('exam')->result_array();
                                        foreach($exams as $key => $exam):?>
                                        <option value="<?php echo $exam['exam_id'];?>"<?php if($exam_id == $exam['exam_id']) echo 'selected="selected"' ;?>><?php echo $exam['name'];?></option>
                                        <?php endforeach;?>
                                </select>

                                </div>
                            </div>


                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-12">
                                    <select name="class_id"  class="form-control select2" onchange="show_students(this.value)">
                                        <option value=""><?php echo get_phrase('select_class');?></option>

                                        <?php $classes =  $this->db->get('class')->result_array();
                                        foreach($classes as $key => $class):?>
                                        <option value="<?php echo $class['class_id'];?>"<?php if($class_id == $class['class_id']) echo 'selected="selected"' ;?>>Class: <?php echo $class['name'];?></option>
                                        <?php endforeach;?>
                                </select>

                                </div>
                            </div>

								
                            <div class="form-group">
                                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Student');?></label>
                                <div class="col-sm-12">

                                <?php $classes = $this->crud_model->get_classes();
                                        foreach ($classes as $key => $row): ?>

                                    <select name="<?php if($class_id == $row['class_id']) echo 'student_id'; else echo 'temp';?>" id="student_id_<?php echo $row['class_id'];?>" style="display:<?php if($class_id == $row['class_id']) echo 'block'; else echo 'none';?>"  class="form-control">
                                        <option value="">Student of: <?php echo $row['name'] ;?></option>

                                        <?php $students = $this->crud_model->get_students($row['class_id']);
                                        foreach ($students as $key => $student): ?>
                                        <option value="<?php echo $student['student_id'];?>"<?php if(isset($student_id) && $student_id == $student['student_id']) echo 'selected="selected"';?>><?php echo $student['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endforeach;?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="" id="student_id_0" style="display:<?php if(isset($student_id) && $student_id > 0) echo 'none'; else echo 'block';?>"  class="form-control">
                                        <option value=""><?php echo get_phrase('Select Class First');?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <input class="" type="hidden" value="selection" name="operation">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('Get Details');?></button>
                        </div>
		
                    </form>                
            </div>                
		</div>
	</div>
</div>


<?php if($class_id > 0 && $student_id > 0 && $exam_id > 0):?>	

    <?php $select_sunject_with_class_id  =   $this->crud_model->get_subjects_by_class($class_id);
            foreach ($select_sunject_with_class_id as $key => $class_subject_exam_student): 

                $verify_data = array('exam_id' => $exam_id, 'class_id' => $class_id, 'student_id' => $student_id, 'subject_id' => $class_subject_exam_student['subject_id']);
                $query = $this->db->get_where('mark', $verify_data);

                if($query->num_rows() < 1)
                    $this->db->insert('mark', $verify_data);
            endforeach;?>


					
    <div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('enter_student_score'); ?></div>
                <div class="panel-body table-responsive">
							   
                                 <?php 
                                    // Get components
                                    // Admin/Class teacher marks view gets subject list, we assume standard components or fetch for the first subject.
                                    // For safety, we define fallback.
                                    $components = [
                                        ['component_name' => 'PT', 'max_marks' => 10],
                                        ['component_name' => 'NOTEBOOK', 'max_marks' => 5],
                                        ['component_name' => 'ENRICHMENT', 'max_marks' => 5],
                                        ['component_name' => 'WRITTEN', 'max_marks' => 80],
                                    ];
                                ?>
    					<table cellpadding="0" cellspacing="0" border="0" class="table">
								<thead>
									<tr>
										<td><?php echo get_phrase('subject');?></td>
                                        <?php foreach ($components as $comp): ?>
										<td><?php echo $comp['component_name']; ?> (<?php echo $comp['max_marks']; ?>)</td>
                                        <?php endforeach; ?>
										<td><?php echo get_phrase('comment');?></td>
									</tr>
								</thead>
                    				<tbody>

        <?php $select_subject_with_class_id  =   $this->crud_model->get_subjects_by_class($class_id);
            foreach ($select_subject_with_class_id as $key => $class_subject_exam_student): 
                $subject_id = $class_subject_exam_student['subject_id'];
           ?>
                    	
										
			<?php echo form_open(base_url() . 'admin/marks/'. $exam_id . '/' . $class_id . '/' . $student_id);?>
						<tr>
											<td>
												<?php echo $class_subject_exam_student['name'];?>
											</td>
                                            
                                            <?php foreach ($components as $comp): 
                                                $comp_name = $comp['component_name'];
                                                $where = ['student_id' => $student_id, 'subject_id' => $subject_id, 'exam_id' => $exam_id, 'component_type' => $comp_name];
                                                $q = $this->db->get_where('mark', $where);
                                                $val = ($q->num_rows() > 0) ? $q->row()->marks_obtained : '';
                                            ?>
											<td>
												<input type="text" class="score_input form-control" data-max="<?php echo $comp['max_marks'];?>" value="<?php echo $val;?>" name="mark_<?php echo $subject_id;?>_<?php echo $comp_name;?>" onchange="validate_score(this)">
											</td>
                                            <?php endforeach; ?>
			
                                            <?php 
                                                $cq = $this->db->get_where('exam_remarks', ['student_id' => $student_id, 'exam_id' => $exam_id]);
                                                $comment = ($cq->num_rows() > 0) ? $cq->row()->text : '';
                                            ?>
											<td>
												<textarea name="comment_<?php echo $subject_id;?>" class="form-control"><?php echo $comment;?></textarea>
											</td>
												
												<input type="hidden" name="exam_id" value="<?php echo $exam_id;?>" />
												<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
												<input type="hidden" name="student_id" value="<?php echo $student_id;?>" />
												
												<input type="hidden" name="operation" value="update_student_subject_score" />
						</tr>

        <?php 
            endforeach;
        ?>

                            
                         	
                    </tbody>
               </table>
              <h5 id="error_message" class="alert alert-warning" style="display:none">Score exceeds maximum allowed marks for this component</h5>
                      <button type="submit" class="btn btn-sm btn-rounded btn-block  btn-info"><i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('update_marks');?></button>
                 
                   <!-- Optional Print Report button in Class Teacher View -->
                   <a href="<?= base_url() ?>admin/print_report_card/<?= $student_id ?>/<?= $exam_id ?>" target="_blank" class="btn btn-primary btn-block btn-rounded btn-sm" style="margin-top:10px;"><i class="fa fa-print"></i> Print Report Card</a>

                  <?php echo form_close();?>
            
			</div>
        </div>
	</div>
 </div>

<?php endif;?>



<script type="text/javascript">
    function show_students(class_id){
            for(i=0;i<=50;i++){
                try{
                    document.getElementById('student_id_'+i).style.display = 'none' ;
                    document.getElementById('student_id_'+i).setAttribute("name" , "temp");
                }
                catch(err){}
            }
            if (class_id == "") {
                class_id = "0";
        }
        document.getElementById('student_id_'+class_id).style.display = 'block' ;
        document.getElementById('student_id_'+class_id).setAttribute("name" , "student_id");
        var student_id = $(".student_id");
        for(var i = 0; i < student_id.length; i++)
            student_id[i].selected = "";
    }


function validate_score(element) {
    var value = parseFloat(element.value);
    var max = parseFloat(element.getAttribute('data-max'));
    
    if (isNaN(value)) return;
    
    if (value > max) {
        element.value = '';
        $('#error_message').text('Score cannot exceed ' + max + ' for this component.').slideDown().delay(3000).slideUp();
    }
}
</script>