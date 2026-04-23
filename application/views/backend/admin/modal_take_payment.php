<?php $invoices = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
        foreach ($invoices as $key => $row):?>
<div class="row">
    <div class="col-sm-12">
        <!-- Payment Summary Card -->
        <div style="background:linear-gradient(135deg,#667eea,#764ba2); border-radius:16px; padding:20px; color:#fff; margin-bottom:16px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:100px; height:100px; background:rgba(255,255,255,0.08); border-radius:50%;"></div>
            <h4 style="margin:0 0 4px; font-weight:800; font-size:16px;">💳 Fee Payment</h4>
            <div style="display:flex; justify-content:space-between; margin-top:14px;">
                <div>
                    <div style="font-size:11px; opacity:0.7;">Total Amount</div>
                    <div style="font-size:22px; font-weight:800;">₹<?php echo number_format($row['amount']);?></div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:11px; opacity:0.7;">Paid</div>
                    <div style="font-size:22px; font-weight:800; color:#4ade80;">₹<?php echo number_format($row['amount_paid']);?></div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:11px; opacity:0.7;">Due</div>
                    <div style="font-size:22px; font-weight:800; color:#fbbf24;">₹<?php echo number_format($row['due']);?></div>
                </div>
            </div>
            <div style="background:rgba(255,255,255,0.15); border-radius:8px; height:8px; margin-top:14px; overflow:hidden;">
                <?php $pct = $row['amount'] > 0 ? round(($row['amount_paid'] / $row['amount']) * 100) : 0; ?>
                <div style="background:#4ade80; height:100%; width:<?php echo $pct;?>%; border-radius:8px; transition:width 0.5s;"></div>
            </div>
            <div style="font-size:10px; margin-top:4px; opacity:0.6; text-align:right;"><?php echo $pct;?>% paid</div>
        </div>

        <!-- Payment History -->
        <?php $payments = $this->db->get_where('payment', array('invoice_id' => $row['invoice_id']))->result_array(); ?>
        <?php if (!empty($payments)): ?>
        <div style="background:#f8fafc; border-radius:12px; padding:14px; margin-bottom:16px;">
            <h5 style="margin:0 0 10px; font-weight:700; font-size:13px; color:#64748b;">📜 Payment History</h5>
            <table class="table table-bordered" style="margin:0; font-size:12px;">
                <thead style="background:#e2e8f0;"><tr><th>#</th><th>Amount</th><th>Method</th><th>Date</th></tr></thead>
                <tbody>
                <?php $counter = 1; foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo $counter++;?></td>
                    <td><strong style="color:#16a34a;">₹<?php echo number_format($payment['amount']);?></strong></td>
                    <td>
                        <span style="padding:2px 8px; border-radius:12px; font-size:10px; font-weight:600;
                            <?php if($payment['method']=='1'): ?>background:#dbeafe; color:#2563eb;
                            <?php elseif($payment['method']=='2'): ?>background:#dcfce7; color:#16a34a;
                            <?php elseif($payment['method']=='3'): ?>background:#fef3c7; color:#d97706;
                            <?php elseif($payment['method']=='4'): ?>background:#f3e8ff; color:#7c3aed;
                            <?php elseif($payment['method']=='5'): ?>background:#fce7f3; color:#db2777;
                            <?php else: ?>background:#f1f5f9; color:#64748b;
                            <?php endif; ?>">
                            <?php 
                            $methods = ['1'=>'💳 Card','2'=>'💵 Cash','3'=>'📝 Cheque','4'=>'📱 UPI','5'=>'🏦 Bank Transfer'];
                            echo $methods[$payment['method']] ?? 'Other';
                            ?>
                        </span>
                    </td>
                    <td><?php echo date('d M Y', $payment['timestamp']);?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Accept Payment Form -->
        <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0;">
            <h5 style="margin:0 0 14px; font-weight:700; font-size:14px; color:#1a1a2e;">
                <i class="fa fa-plus-circle" style="color:#16a34a;"></i> Accept New Payment
            </h5>
            <?php echo form_open(base_url() . 'admin/student_payment/take_payment/'.$row['invoice_id'], array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

            <div class="row">
                <div class="form-group col-md-6">
                    <label style="font-weight:600; font-size:12px;">Amount to Pay *</label>
                    <div class="input-group">
                        <span class="input-group-addon" style="font-weight:700;">₹</span>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount" style="font-size:18px; font-weight:700; height:48px;" required>
                    </div>
                    <!-- Quick amount buttons -->
                    <div style="margin-top:6px; display:flex; gap:4px; flex-wrap:wrap;">
                        <?php if($row['due'] > 0): ?>
                        <button type="button" class="btn btn-xs btn-success" onclick="this.form.amount.value='<?php echo $row['due'];?>'">Full Due (₹<?php echo number_format($row['due']);?>)</button>
                        <?php endif; ?>
                        <?php if($row['due'] >= $row['amount']/2): ?>
                        <button type="button" class="btn btn-xs btn-info" onclick="this.form.amount.value='<?php echo round($row['amount']/2);?>'">Half (₹<?php echo number_format(round($row['amount']/2));?>)</button>
                        <?php endif; ?>
                        <?php if($row['due'] >= $row['amount']/4): ?>
                        <button type="button" class="btn btn-xs btn-warning" onclick="this.form.amount.value='<?php echo round($row['amount']/4);?>'">Quarter (₹<?php echo number_format(round($row['amount']/4));?>)</button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label style="font-weight:600; font-size:12px;">Payment Date *</label>
                    <input class="form-control" name="timestamp" type="date" value="<?php echo date('Y-m-d')?>" style="height:48px;" required>
                </div>
            </div>

            <div class="form-group">
                <label style="font-weight:600; font-size:12px;">Payment Method *</label>
                <div class="row" style="margin:0;">
                    <label class="btn btn-default" style="margin:3px; border-radius:10px; padding:10px 16px; font-size:12px; cursor:pointer;" id="method_cash">
                        <input type="radio" name="method" value="2" style="display:none;" checked onchange="showPaymentUI('cash')"> 💵 Cash
                    </label>
                    <label class="btn btn-default" style="margin:3px; border-radius:10px; padding:10px 16px; font-size:12px; cursor:pointer;" id="method_upi">
                        <input type="radio" name="method" value="4" style="display:none;" onchange="showPaymentUI('upi')"> 📱 UPI
                    </label>
                    <label class="btn btn-default" style="margin:3px; border-radius:10px; padding:10px 16px; font-size:12px; cursor:pointer;" id="method_card">
                        <input type="radio" name="method" value="1" style="display:none;" onchange="showPaymentUI('card')"> 💳 Card
                    </label>
                    <label class="btn btn-default" style="margin:3px; border-radius:10px; padding:10px 16px; font-size:12px; cursor:pointer;" id="method_cheque">
                        <input type="radio" name="method" value="3" style="display:none;" onchange="showPaymentUI('cheque')"> 📝 Cheque
                    </label>
                    <label class="btn btn-default" style="margin:3px; border-radius:10px; padding:10px 16px; font-size:12px; cursor:pointer;" id="method_bank">
                        <input type="radio" name="method" value="5" style="display:none;" onchange="showPaymentUI('bank')"> 🏦 Bank Transfer
                    </label>
                </div>
            </div>

            <!-- UPI Section -->
            <div id="ui_upi" style="display:none; text-align:center; padding:16px; border:2px dashed #7c3aed; border-radius:12px; background:#faf5ff; margin-bottom:12px;">
                <h4 style="color:#7c3aed; margin:0 0 10px; font-weight:700; font-size:14px;">📱 Scan & Pay via UPI</h4>
                <img src="<?php echo base_url();?>uploads/upi_qr.png" alt="UPI QR" style="max-width:180px; border-radius:12px; border:3px solid #e9d5ff;" 
                    onerror="this.onerror=null; this.src='https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=example@upi';">
                <p style="font-size:11px; color:#7c3aed; margin:8px 0 0;">After payment, enter reference number below</p>
                <input type="text" class="form-control" name="upi_ref" placeholder="UPI Transaction ID" style="margin-top:8px; text-align:center; max-width:260px; display:inline-block;">
            </div>

            <!-- Cheque Section -->
            <div id="ui_cheque" style="display:none; padding:12px; border:1px solid #fbbf24; border-radius:12px; background:#fffbeb; margin-bottom:12px;">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size:12px;">Cheque Number</label>
                        <input type="text" class="form-control" name="cheque_no" placeholder="Enter cheque number">
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size:12px;">Bank Name</label>
                        <input type="text" class="form-control" name="cheque_bank" placeholder="Bank name">
                    </div>
                </div>
            </div>

            <!-- Bank Transfer Section -->
            <div id="ui_bank" style="display:none; padding:12px; border:1px solid #2563eb; border-radius:12px; background:#eff6ff; margin-bottom:12px;">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label style="font-size:12px;">Transaction/Reference ID</label>
                        <input type="text" class="form-control" name="bank_ref" placeholder="NEFT/RTGS/IMPS Ref">
                    </div>
                    <div class="form-group col-md-6">
                        <label style="font-size:12px;">Transfer Date</label>
                        <input type="date" class="form-control" name="bank_date" value="<?php echo date('Y-m-d');?>">
                    </div>
                </div>
            </div>

            <!-- Remark -->
            <div class="form-group">
                <label style="font-weight:600; font-size:12px;">Remark (Optional)</label>
                <input type="text" class="form-control" name="remark" placeholder="e.g., Term 1 fees, Transport fees">
            </div>

            <input type="hidden" name="invoice_id" value="<?php echo $row['invoice_id'];?>">
            <input type="hidden" name="student_id" value="<?php echo $row['student_id'];?>">
            <input type="hidden" name="title" value="<?php echo $row['title'];?>">
            <input type="hidden" name="description" value="<?php echo $row['description'];?>">

            <button type="submit" class="btn btn-block btn-lg" style="background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; font-weight:800; border:none; border-radius:12px; padding:14px; font-size:15px;">
                <i class="fa fa-check-circle"></i> &nbsp;Accept Payment
            </button>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<?php endforeach;?>

<script>
function showPaymentUI(type) {
    ['upi','cheque','bank'].forEach(function(t) {
        document.getElementById('ui_'+t).style.display = 'none';
    });
    ['cash','upi','card','cheque','bank'].forEach(function(t) {
        document.getElementById('method_'+t).className = 'btn btn-default';
    });
    document.getElementById('method_'+type).className = 'btn btn-info active';
    if (type === 'upi' || type === 'cheque' || type === 'bank') {
        document.getElementById('ui_'+type).style.display = 'block';
    }
}
// Set initial active
document.getElementById('method_cash').className = 'btn btn-info active';
</script>