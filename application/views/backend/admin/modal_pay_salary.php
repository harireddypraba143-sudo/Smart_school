<?php 
$payroll = $this->db->get_where('payroll', array('payroll_id' => $param2))->row();
$teacher = $this->db->get_where('teacher', array('teacher_id' => $payroll->employee_id))->row();
$system_currency = $this->db->get_where('settings', array('type'=>'currency'))->row()->description;
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-money"></i>&nbsp;&nbsp;Pay Salary - <?php echo $teacher->name; ?></div>
            <div class="panel-body table-responsive">
                
                <?php echo form_open(base_url() . 'admin/pay_salary_single', array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <input type="hidden" name="payroll_id" value="<?php echo $payroll->payroll_id; ?>">

                <div class="form-group"> 
                    <label class="col-sm-12">Net Salary Applicable</label>        
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="amount" value="<?php echo $payroll->net_salary;?>" readonly/>
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-12">Payment Method*</label>        
                    <div class="col-sm-12">
                        <select name="method" class="form-control select2" style="width:100%" onchange="toggleModalUPISalary(this)" required>
                            <option value="">Select Method</option>
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="UPI">UPI (Scan QR Code)</option>
                        </select>
                        
                        <div id="modal-upi-qr-salary" style="display:none; text-align:center; padding: 20px; border: 1px dashed #ccc; margin-top: 15px; border-radius: 8px;">
                            <h4 style="color:#2ecc71; margin-top:0;">Scan & Pay via UPI</h4>
                            <img src="<?php echo base_url();?>uploads/upi_qr.png" alt="UPI QR Code" style="max-width: 200px; border-radius: 10px;" onerror="this.onerror=null; this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=example@upi';">
                            <p style="font-size:12px; color:#888; margin-bottom:0;">After payment, enter Reference No. and Save.</p>
                        </div>
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-12">Transaction Reference</label>        
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="transaction_ref" value="" placeholder="e.g. UTR Number, Cheque No..."/>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block btn-rounded btn-sm"><i class="fa fa-check"></i>&nbsp;Confirm Payment</button>
                </div>

                <?php echo form_close();?>

                <script type="text/javascript">
                function toggleModalUPISalary(selectObj) {
                    var qrContainer = document.getElementById('modal-upi-qr-salary');
                    if(selectObj.value == 'UPI') {
                        qrContainer.style.display = 'block';
                    } else {
                        qrContainer.style.display = 'none';
                    }
                }
                </script>
            </div>
        </div>
    </div>
</div>
