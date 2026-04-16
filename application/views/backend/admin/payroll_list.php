<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-money"></i>&nbsp;&nbsp;<?php echo get_phrase('Payroll_Dashboard'); ?>
            </div>
            <div class="panel-body">
                <!-- Advanced Filters -->
                <?php echo form_open(base_url() . 'admin/payroll', array('class' => 'form-inline', 'style' => 'margin-bottom: 20px;')); ?>
                    <div class="form-group" style="padding-right: 15px;">
                        <label for="month" class="m-r-10"><?php echo get_phrase('month'); ?></label>
                        <select name="month" class="form-control" required>
                            <?php 
                            for($i = 1; $i <= 12; $i++) {
                                $selected = ($i == $selected_month) ? 'selected' : '';
                                echo "<option value='$i' $selected>".date('F', mktime(0, 0, 0, $i, 1))."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="padding-right: 15px;">
                        <label for="year" class="m-r-10"><?php echo get_phrase('year'); ?></label>
                        <select name="year" class="form-control" required>
                            <?php 
                            $current_year = date('Y');
                            for($i = $current_year - 2; $i <= $current_year + 1; $i++) {
                                $selected = ($i == $selected_year) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-filter"></i> Filter</button>
                    
                <?php echo form_close(); ?>

                <hr/>

                <!-- KPI Widgets -->
                <?php
                // Calculate KPIs for selected month
                $payrolls = $this->db->get_where('payroll', array('month' => $selected_month, 'year' => $selected_year))->result_array();
                
                $total_salary = 0;
                $paid_salary = 0;
                $pending_salary = 0;
                $paid_count = 0;

                foreach($payrolls as $row) {
                    $total_salary += $row['net_salary'];
                    if($row['status'] == 2) {
                        $paid_salary += $row['net_salary'];
                        $paid_count++;
                    } else {
                        $pending_salary += $row['net_salary'];
                    }
                }
                
                $total_employees = count($payrolls);
                $paid_percent = ($total_employees > 0) ? round(($paid_count / $total_employees) * 100) : 0;
                $system_currency = $this->db->get_where('settings', array('type'=>'currency'))->row()->description;
                ?>

                <div class="row m-t-20 m-b-20">
                    <div class="col-md-3">
                        <div class="white-box text-center" style="background:#f4f8fa; border:1px solid #e1e7ec;">
                            <h3 class="box-title m-b-0">Total Expected</h3>
                            <h2 class="text-info m-t-10 m-b-0"><?php echo $system_currency.$total_salary; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="white-box text-center" style="background:#eafcf1; border:1px solid #c8ecd5;">
                            <h3 class="box-title m-b-0">Paid Amount</h3>
                            <h2 class="text-success m-t-10 m-b-0"><?php echo $system_currency.$paid_salary; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="white-box text-center" style="background:#fff6f5; border:1px solid #ecc9c9;">
                            <h3 class="box-title m-b-0">Pending Amount</h3>
                            <h2 class="text-danger m-t-10 m-b-0"><?php echo $system_currency.$pending_salary; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="white-box text-center" style="background:#f4f8fa; border:1px solid #e1e7ec;">
                            <h3 class="box-title m-b-0">Employees Paid</h3>
                            <h2 class="text-warning m-t-10 m-b-0"><?php echo $paid_percent; ?>%</h2>
                        </div>
                    </div>
                </div>

                <hr/>

                <!-- Action Bar -->
                <div class="row m-b-20">
                    <div class="col-sm-12 text-right">
                        <?php echo form_open(base_url() . 'admin/payroll_bulk_generate', array('style'=>'display:inline-block;')); ?>
                            <input type="hidden" name="month" value="<?php echo $selected_month; ?>">
                            <input type="hidden" name="year" value="<?php echo $selected_year; ?>">
                            <button type="submit" class="btn btn-success btn-sm btn-rounded"><i class="fa fa-gears"></i> Bulk Generate Payslips (<?php echo date('F', mktime(0, 0, 0, $selected_month, 1)).' '.$selected_year; ?>)</button>
                        <?php echo form_close(); ?>
                    </div>
                </div>

                <!-- Ledger Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable" id="table_export">
                        <thead>
                            <tr>
                                <th>Payslip No</th>
                                <th>Employee</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($payrolls as $row): 
                                $teacher = $this->db->get_where('teacher', array('teacher_id' => $row['employee_id']))->row();
                                if(!$teacher) continue;
                            ?>
                            <tr>
                                <td><span class="label label-info"><?php echo $row['payslip_no']; ?></span></td>
                                <td>
                                    <img src="<?php echo $this->crud_model->get_image_url('teacher', $teacher->teacher_id); ?>" class="img-circle" width="30px" style="margin-right:10px;">
                                    <?php echo $teacher->name; ?>
                                </td>
                                <td><b><?php echo $system_currency.$row['net_salary']; ?></b></td>
                                <td>
                                    <?php if($row['status'] == 1): ?>
                                        <span class="label label-warning">Generated (Unpaid)</span>
                                    <?php elseif($row['status'] == 2): ?>
                                        <span class="label label-success">Paid</span>
                                    <?php elseif($row['status'] == 3): ?>
                                        <span class="label label-danger">Failed</span>
                                    <?php else: ?>
                                        <span class="label label-default">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $row['payment_method'] ? $row['payment_method'] : 'N/A'; ?></td>
                                <td>
                                    <?php if($row['status'] == 1 || $row['status'] == 3): ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_pay_salary/<?php echo $row['payroll_id'];?>');" class="btn btn-success btn-xs btn-rounded"><i class="fa fa-money"></i> Pay Now</a>
                                    <?php endif; ?>
                                    
                                    <?php if($row['status'] == 2): ?>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_view_payslip/<?php echo $row['payroll_id'];?>');" class="btn btn-primary btn-xs btn-rounded"><i class="fa fa-print"></i> Payslip</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
