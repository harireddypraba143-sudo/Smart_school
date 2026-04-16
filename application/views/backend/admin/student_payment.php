<div class="row">
    <div class="col-sm-6">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('Create Single Invoice');?></div>
                    <div class="panel-body table-responsive">
			
    <!----CREATION FORM STARTS---->

    <?php echo form_open(base_url() . 'admin/student_payment/single_invoice' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                
            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Invoice Number');?></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="invoice_number" value="<?php echo rand(10000, 1000000). 'INV'. date('Y');?>" / required>
                </div>
            </div>


            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Title');?></label>
                <div class="col-sm-12">
                    <select name="title" class="form-control select2" required>
                        <option value=""><?php echo get_phrase('select_fee_type');?></option>
                        <option value="Tuition Fee">Tuition Fee</option>
                        <option value="Hostel Fee">Hostel Fee</option>
                        <option value="Transport Fee">Transport Fee</option>
                        <option value="Examination Fee">Examination Fee</option>
                        <option value="Library Fee">Library Fee</option>
                        <option value="Admission Fee">Admission Fee</option>
                        <option value="Miscellaneous Fee">Miscellaneous Fee</option>
                    </select>
                </div>
            </div>



            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                <div class="col-sm-12">
                    <select name="class_id" id="class_id" class="form-control select2" onchange="return get_class_student(this.value)">
                    <option value=""><?php echo get_phrase('select_class');?></option>

                    <?php $class =  $this->db->get('class')->result_array();
                    foreach($class as $key => $class):?>
                    <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                    <?php endforeach;?>
                   </select>

                </div>
            </div>

								
			<div class="form-group">
                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Student');?></label>
                <div class="col-sm-12">
                    <select name="student_id" class="form-control" id="student_selector_holder">
                    <option value=""><?php echo get_phrase('select_student');?></option>
                    </select>
                    <div id="student_balance_info" style="display:none;"></div>
                </div>
            </div>


			<div class="form-group">
                <label class="col-md-12" for="example-text"><?php echo get_phrase('select_date');?></label>
                <div class="col-sm-12">
                 	<input type="date" name="creation_timestamp" value="<?php echo date('Y-m-d');?>" class="form-control datepicker" id="example-date-input" required>
                </div>
            </div>

            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Amount');?></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="amount" / required>
                </div>
            </div>

            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Discount');?> %</label>
                <div class="col-sm-12">
                    <input type="number" class="form-control" name="discount" value="0">
                </div>
            </div>


            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Amount Paid');?></label>
                <div class="col-sm-12">
                    <input type="number" class="form-control" name="amount_paid" value="0">
                </div>
            </div>

								
			<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Status');?></label>
                <div class="col-sm-12">
                    <select name="status" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('payment_status');?></option>
                    <option value="1">Paid</option>
                    <option value="2">Unpaid</option>
                   </select>

                </div>
            </div>

            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Method');?></label>
                <div class="col-sm-12">
                    <select name="payment_method" class="form-control select2 payment-method-selector" required onchange="toggleUPI(this, 'single')">
                    <option value=""><?php echo get_phrase('payment_method');?></option>
                    <option value="1">Cash</option>
                    <option value="4">UPI (Scan QR Code)</option>
                   </select>

                   <div id="upi-qr-container-single" style="display:none; text-align:center; padding: 20px; border: 1px dashed #ccc; margin-top: 15px; border-radius: 8px;">
                        <h4 style="color:#2ecc71; margin-top:0;">Scan & Pay via UPI</h4>
                        <img src="<?php echo base_url();?>uploads/upi_qr.png" alt="UPI QR Code" style="max-width: 200px; border-radius: 10px;" onerror="this.onerror=null; this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=example@upi';">
                        <p style="font-size:12px; color:#888; margin-bottom:0;">After payment, click Create to save.</p>
                   </div>
                </div>
            </div>


            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Description');?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" name="description"></textarea>
                </div>
            </div>
            
            <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('create');?></button>
			</div>
							
    </form>                
		</div>
	</div>
</div>
			<!----CREATION FORM ENDS-->

<div class="col-sm-6">
	<div class="panel panel-info">
        <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('Create Mass Invoice');?></div>
            <div class="panel-body table-responsive">
				
        <?php echo form_open(base_url() . 'admin/student_payment/mass_invoice' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
        <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Invoice Number');?></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="invoice_number" value="<?php echo rand(10000, 1000000). 'INV'. date('Y');?>" / required>
                </div>
            </div>


            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Title');?></label>
                <div class="col-sm-12">
                    <select name="title" class="form-control select2" required>
                        <option value=""><?php echo get_phrase('select_fee_type');?></option>
                        <option value="Tuition Fee">Tuition Fee</option>
                        <option value="Hostel Fee">Hostel Fee</option>
                        <option value="Transport Fee">Transport Fee</option>
                        <option value="Examination Fee">Examination Fee</option>
                        <option value="Library Fee">Library Fee</option>
                        <option value="Admission Fee">Admission Fee</option>
                        <option value="Miscellaneous Fee">Miscellaneous Fee</option>
                    </select>
                </div>
            </div>



            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                <div class="col-sm-12">
                    <select name="class_id" id="class_id" class="form-control select2" onchange="return get_class_mass_student(this.value)">
                    <option value=""><?php echo get_phrase('select_class');?></option>

                    <?php $class =  $this->db->get('class')->result_array();
                    foreach($class as $key => $class):?>
                    <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                    <?php endforeach;?>
                   </select>

                </div>
            </div>

								
			<div class="form-group">
                    <label class="col-md-12" for="example-text"><?php echo get_phrase('Student');?></label>
                <div class="col-sm-12">
                   <div id="mass_student_selector_holder"></div>
                </div>
            </div>


			<div class="form-group">
                <label class="col-md-12" for="example-text"><?php echo get_phrase('select_date');?></label>
                <div class="col-sm-12">
                 	<input type="date" name="creation_timestamp" value="<?php echo date('Y-m-d');?>" class="form-control datepicker" id="example-date-input" required>
                </div>
            </div>

            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Amount');?></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="amount" / required>
                </div>
            </div>

            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Discount');?> %</label>
                <div class="col-sm-12">
                    <input type="number" class="form-control" name="discount" value="0">
                </div>
            </div>


            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Amount Paid');?></label>
                <div class="col-sm-12">
                    <input type="number" class="form-control" name="amount_paid" value="0">
                </div>
            </div>

								
			<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Status');?></label>
                <div class="col-sm-12">
                    <select name="status" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('payment_status');?></option>
                    <option value="1">Paid</option>
                    <option value="2">Unpaid</option>
                   </select>

                </div>
            </div>

            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Payment Method');?></label>
                <div class="col-sm-12">
                    <select name="payment_method" class="form-control select2 payment-method-selector" required onchange="toggleUPI(this, 'mass')">
                    <option value=""><?php echo get_phrase('payment_method');?></option>
                    <option value="1">Cash</option>
                    <option value="4">UPI (Scan QR Code)</option>
                   </select>

                   <div id="upi-qr-container-mass" style="display:none; text-align:center; padding: 20px; border: 1px dashed #ccc; margin-top: 15px; border-radius: 8px;">
                        <h4 style="color:#2ecc71; margin-top:0;">Scan & Pay via UPI</h4>
                        <img src="<?php echo base_url();?>uploads/upi_qr.png" alt="UPI QR Code" style="max-width: 200px; border-radius: 10px;" onerror="this.onerror=null; this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=example@upi';">
                        <p style="font-size:12px; color:#888; margin-bottom:0;">After payment, click Create to save.</p>
                   </div>
                </div>
            </div>


            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('Description');?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" name="description"></textarea>
                </div>
            </div>
            
            <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('create');?></button>
			</div>
							
    </form>                                  
			</div>
		</div>
	</div>
</div>
			
            <!----TABLE LISTING ENDS--->

<script type="text/javascript">
function toggleUPI(selectObj, formType) {
    var selectedValue = selectObj.value;
    var qrContainer = document.getElementById('upi-qr-container-' + formType);
    if(selectedValue == '4') {
        qrContainer.style.display = 'block';
    } else {
        qrContainer.style.display = 'none';
    }
}

$(document).ready(function() {
    // Auto-calculate amount paid for single invoice
    $('form').on('keyup change', 'input[name="amount"], input[name="discount"]', function() {
        var form = $(this).closest('form');
        var amount = parseFloat(form.find('input[name="amount"]').val()) || 0;
        var discount = parseFloat(form.find('input[name="discount"]').val()) || 0;
        
        var amount_paid = amount - (amount * (discount / 100));
        form.find('input[name="amount_paid"]').val(amount_paid.toFixed(2));
    });
});
</script>

<script type="text/javascript">
function select(){
    var chk = $('.check');
    for(i = 0; i < chk.length; i++){
        chk[i].checked = true;
    }
}

function unselect(){
    var chk = $('.check');
    for(i = 0; i < chk.length; i++){
        chk[i].checked = false;
    }
}


function get_class_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_class_student/' + class_id,
        success:    function(response){
            jQuery('#student_selector_holder').html(response);
            // Reset balance info when class changes
            jQuery('#student_balance_info').hide();
            // Bind change event to check balance when student is selected
            jQuery('#student_selector_holder').off('change').on('change', function(){
                var student_id = jQuery(this).val();
                if(student_id && student_id != ''){
                    check_student_balance(student_id);
                } else {
                    jQuery('#student_balance_info').hide();
                }
            });
        } 

    });
}

function check_student_balance(student_id){
    $.ajax({
        url: '<?php echo base_url();?>admin/get_student_balance/' + student_id,
        dataType: 'json',
        success: function(data){
            var balanceDiv = jQuery('#student_balance_info');
            if(data.balance <= 0){
                // Show zero balance - fees completed
                balanceDiv.html(
                    '<div style="background: linear-gradient(135deg, #48bb78, #38a169); color: #fff; padding: 12px 16px; border-radius: 10px; margin-top: 10px; display: flex; align-items: center; gap: 10px;">' +
                    '<i class="fa fa-check-circle" style="font-size: 22px;"></i>' +
                    '<div><strong>' + data.student_name + '</strong><br><small>Balance: ₹0 — All fees paid for ' + data.academic_year + '</small></div>' +
                    '</div>'
                ).show();

                // Show modal popup
                $('#feeCompletedModal').remove();
                var modalHtml = 
                    '<div class="modal fade" id="feeCompletedModal" tabindex="-1" role="dialog">' +
                    '  <div class="modal-dialog modal-sm" role="document">' +
                    '    <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">' +
                    '      <div class="modal-header" style="background: linear-gradient(135deg, #48bb78, #38a169); border: none; text-align: center; padding: 25px 20px 15px;">' +
                    '        <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.25); border-radius: 50%; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">' +
                    '          <i class="fa fa-check" style="font-size: 28px; color: #fff;"></i>' +
                    '        </div>' +
                    '        <h4 class="modal-title" style="color: #fff; font-weight: 700; width: 100%; font-size: 18px;">Fees Completed!</h4>' +
                    '      </div>' +
                    '      <div class="modal-body" style="text-align: center; padding: 25px 20px;">' +
                    '        <p style="margin: 0; font-size: 15px; color: #4a5568; line-height: 1.6;">' +
                    '          <strong style="color: #2d3748;">' + data.student_name + '</strong> has no outstanding balance.<br>' +
                    '          All fees for academic year <strong style="color: #38a169;">' + data.academic_year + '</strong> are fully paid.' +
                    '        </p>' +
                    '      </div>' +
                    '      <div class="modal-footer" style="border: none; text-align: center; padding: 0 20px 20px; display: flex; justify-content: center;">' +
                    '        <button type="button" class="btn btn-success btn-rounded" data-dismiss="modal" style="padding: 8px 30px; background: linear-gradient(135deg, #48bb78, #38a169); border: none;">OK, Got it</button>' +
                    '      </div>' +
                    '    </div>' +
                    '  </div>' +
                    '</div>';
                $('body').append(modalHtml);
                $('#feeCompletedModal').modal('show');
            } else {
                // Show pending balance
                var formattedBalance = parseFloat(data.balance).toLocaleString('en-IN');
                balanceDiv.html(
                    '<div style="background: linear-gradient(135deg, #fc5c7d22, #e53e3e11); border: 1px solid #fc8181; color: #c53030; padding: 12px 16px; border-radius: 10px; margin-top: 10px; display: flex; align-items: center; gap: 10px;">' +
                    '<i class="fa fa-exclamation-circle" style="font-size: 22px; color: #e53e3e;"></i>' +
                    '<div><strong>' + data.student_name + '</strong><br><small>Outstanding Balance: <strong style="font-size: 16px;">₹' + formattedBalance + '</strong> for ' + data.academic_year + '</small></div>' +
                    '</div>'
                ).show();
            }
        }
    });
}
</script>

<script type="text/javascript">
function get_class_mass_student(class_id){
    $.ajax({
        url:        '<?php echo base_url();?>admin/get_class_mass_student/' + class_id,
        success:    function(response){
            jQuery('#mass_student_selector_holder').html(response);
        } 

    });
}
</script>