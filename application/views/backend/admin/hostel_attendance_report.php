<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-bed"></i>&nbsp;&nbsp;Hostel Attendance Report</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body table-responsive">
                    <div align="center">
                        KEYS: 
                        Checked In&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #00a651;"></i>&nbsp;&nbsp;
                        Checked Out&nbsp;-&nbsp;<i class="fa fa-circle" style="color: #EE4749;"></i>&nbsp;&nbsp;
                        Late&nbsp;-&nbsp; <i class="fa fa-circle" style="color: #FF6600;"></i>&nbsp;&nbsp;
                        No Scan&nbsp;-&nbsp;<i class="fa fa-circle" style="color:#e5e5e5;"></i>
                    </div>
                                
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('month');?></label>
                        <div class="col-sm-12">
                            <select class="form-control" id="month">
                                <?php $current_month = date('m'); ?>
                                <?php
                                for ($i = 1; $i <= 12; $i++):
                                    if ($i == 1)      $m = get_phrase('January');
                                    else if ($i == 2) $m = get_phrase('February');
                                    else if ($i == 3) $m = get_phrase('March');
                                    else if ($i == 4) $m = get_phrase('April');
                                    else if ($i == 5) $m = get_phrase('May');
                                    else if ($i == 6) $m = get_phrase('June');
                                    else if ($i == 7) $m = get_phrase('July');
                                    else if ($i == 8) $m = get_phrase('August');
                                    else if ($i == 9) $m = get_phrase('September');
                                    else if ($i == 10)$m = get_phrase('October');
                                    else if ($i == 11)$m = get_phrase('November');
                                    else if ($i == 12)$m = get_phrase('December');
                                ?>
                                    <option value="<?php echo $i; ?>"<?php if($current_month == $i) echo 'selected'; ?>><?php echo $m; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo get_phrase('year');?></label>
                        <div class="col-sm-12">
                            <select id="year" class="form-control">
                                <?php $current_year = date('Y');
                                $list_year = array("2024", "2025", "2026", "2027", "2028");
                                foreach($list_year as $row){
                                ?>
                                    <option value="<?php echo $row;?>"<?php if($row == $current_year) echo 'selected';?>><?php echo $row;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-rounded btn-block btn-sm" id="find"><i class="fa fa-search"></i>&nbsp;Get Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<!-- The AJAX content drops here -->
<div id="data">
    <?php if ($month != NULL && $year != NULL): ?>
        <?php include 'loadHostelAttendanceReport.php'; ?>
    <?php endif; ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#find').on('click', function() {
            var month = $('#month').val();
            var year  = $('#year').val();
            
            if (month == "" || year == "") {
                $.toast({
                    text: 'Please select month and year',
                    position: 'top-right',
                    loaderBg: '#f56954',
                    icon: 'warning',
                    hideAfter: 3500,
                    stack: 6
                });
                return false;
            }

            $('#data').html('<div align="center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

            $.ajax({
                url: '<?php echo site_url('admin/loadHostelAttendanceReport/');?>' + month + '/' + year
            }).done(function(response) {
                $('#data').html(response);
            });
        });
    });
</script>
