<?php
$invoices = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
foreach ($invoices as $key => $row):
    $student = $this->db->get_where('student', array('student_id' => $row['student_id']))->row();
    $class = $this->db->get_where('class', array('class_id' => $student->class_id))->row();
    $system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
    $system_email = $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;
    $system_phone = $this->db->get_where('settings', array('type' => 'phone'))->row()->description;
    $system_address = $this->db->get_where('settings', array('type' => 'address'))->row()->description;
    $currency = $this->db->get_where('settings', array('type' => 'currency'))->row()->description;
?>

	<div style="text-align:right; margin-bottom: 10px;">
        <button onClick="PrintElem('#invoice_print')" class="btn btn-rounded btn-info" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);"><i class="fa fa-print"></i>&nbsp;Print Receipt</button>
    </div>
    
    <!-- Invoice Container -->
    <div id="invoice_print" style="background:#fff; padding: 40px; font-family: 'Inter', 'Segoe UI', sans-serif; color: #333; position:relative; overflow: hidden; max-width: 800px; margin: 0 auto; box-shadow: 0 0 20px rgba(0,0,0,0.05);">
        
        <!-- Watermark -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 120px; font-weight: 900; color: rgba(0,0,0,0.03); z-index: 0; pointer-events: none; text-transform: uppercase;">
            <?php echo ($row['status'] == 1) ? 'PAID' : 'UNPAID'; ?>
        </div>

        <div style="position:relative; z-index: 1;">
            
            <!-- Header Section -->
            <div style="display: flex; justify-content: space-between; border-bottom: 2px solid #f0f0f0; padding-bottom: 25px; margin-bottom: 30px;">
                <div style="flex: 1;">
                    <div style="display:flex; align-items:center; gap: 15px;">
                        <img src="<?php echo base_url(); ?>uploads/logo.png" style="height: 60px; max-width: 150px; object-fit: contain;" alt="Logo" onerror="this.style.display='none'">
                        <div>
                            <h2 style="margin:0; color:#2c3e50; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;"><?php echo strtoupper($system_name); ?></h2>
                            <p style="margin:4px 0 0; color:#7f8c8d; font-size: 13px;"><i class="fa fa-map-marker" style="width:16px;"></i> <?php echo $system_address; ?></p>
                            <p style="margin:2px 0 0; color:#7f8c8d; font-size: 13px;"><i class="fa fa-phone" style="width:16px;"></i> <?php echo $system_phone; ?> &nbsp;|&nbsp; <i class="fa fa-envelope" style="width:16px;"></i> <?php echo $system_email; ?></p>
                        </div>
                    </div>
                </div>
                <div style="text-align: right; width: 250px;">
                    <h1 style="margin:0 0 10px; color:#3498db; font-size: 32px; font-weight: 300; letter-spacing: 2px;">RECEIPT</h1>
                    <div style="background: <?php echo ($row['status'] == 1) ? '#e8f5e9' : '#ffebee'; ?>; padding: 8px 15px; border-radius: 6px; display: inline-block;">
                        <span style="font-size: 12px; color: <?php echo ($row['status'] == 1) ? '#2e7d32' : '#c62828'; ?>; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                            Status: <?php echo ($row['status'] == 1) ? 'PAID' : 'UNPAID'; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Receipt Info & Student Details -->
            <div style="display: flex; justify-content: space-between; margin-bottom: 35px; gap: 40px;">
                <!-- Payment Details -->
                <div style="flex: 1; min-width: 200px;">
                    <h5 style="color: #95a5a6; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; margin: 0 0 10px; font-weight: 600;">Payment Information</h5>
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <tr><td style="padding: 4px 0; color: #555; width: 40%;"><strong>Receipt No:</strong></td><td style="padding: 4px 0; color: #333;"><?php echo $row['invoice_number']; ?></td></tr>
                        <tr><td style="padding: 4px 0; color: #555;"><strong>Date Issued:</strong></td><td style="padding: 4px 0; color: #333;"><?php echo date('d M, Y', strtotime($row['creation_timestamp']));?></td></tr>
                        <tr><td style="padding: 4px 0; color: #555;"><strong>Fee Type:</strong></td><td style="padding: 4px 0; color: #333;"><strong><?php echo $row['title'];?></strong></td></tr>
                        <tr><td style="padding: 4px 0; color: #555;"><strong>Academic Year:</strong></td><td style="padding: 4px 0; color: #333;"><?php echo $row['year'];?></td></tr>
                    </table>
                </div>

                <!-- Student Details -->
                <div style="flex: 1; background: #f8f9fa; padding: 20px; border-radius: 12px; border: 1px solid #edf2f7;">
                    <h5 style="color: #95a5a6; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; margin: 0 0 10px; font-weight: 600;">Billed To</h5>
                    <h3 style="margin: 0 0 8px; color: #2c3e50; font-size: 18px; font-weight: 700;"><?php echo $student->name; ?></h3>
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <tr><td style="padding: 2px 0; color: #7f8c8d; width: 35%;">Class:</td><td style="padding: 2px 0; color: #34495e; font-weight: 500;"><?php echo $class ? $class->name : 'N/A'; ?></td></tr>
                        <tr><td style="padding: 2px 0; color: #7f8c8d;">Roll No:</td><td style="padding: 2px 0; color: #34495e; font-weight: 500;"><?php echo $student->roll; ?></td></tr>
                        <tr><td style="padding: 2px 0; color: #7f8c8d;">Gender:</td><td style="padding: 2px 0; color: #34495e; font-weight: 500; text-transform: capitalize;"><?php echo $student->sex; ?></td></tr>
                    </table>
                </div>
            </div>

            <!-- Ledger Table -->
            <h5 style="color: #95a5a6; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; margin: 0 0 10px; font-weight: 600;">Fee Breakdown</h5>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th style="padding: 12px 15px; background: #2c3e50; color: #fff; text-align: left; font-size: 13px; font-weight: 600; border-radius: 6px 0 0 0;">Description</th>
                        <th style="padding: 12px 15px; background: #2c3e50; color: #fff; text-align: center; font-size: 13px; font-weight: 600;">Base Amount</th>
                        <th style="padding: 12px 15px; background: #2c3e50; color: #fff; text-align: center; font-size: 13px; font-weight: 600;">Discount</th>
                        <th style="padding: 12px 15px; background: #2c3e50; color: #fff; text-align: right; font-size: 13px; font-weight: 600; border-radius: 0 6px 0 0;">Net Payable</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #edf2f7;">
                        <td style="padding: 15px; color: #34495e; font-size: 14px;">
                            <strong><?php echo $row['title'];?></strong>
                            <div style="font-size: 12px; color: #7f8c8d; margin-top: 4px;"><?php echo $row['description'];?></div>
                        </td>
                        <td style="padding: 15px; text-align: center; color: #34495e; font-size: 14px;"><?php echo $currency; ?><?php echo number_format($row['amount'],2,".",",");?></td>
                        <td style="padding: 15px; text-align: center; color: #27ae60; font-size: 14px;">-<?php echo $currency; ?><?php echo number_format(($row['amount'] * $row['discount']/100),2,".",",");?> (<?php echo $row['discount']; ?>%)</td>
                        <td style="padding: 15px; text-align: right; color: #2c3e50; font-weight: bold; font-size: 15px;">
                            <?php 
                                $net_payable = $row['amount'] - ($row['amount'] * $row['discount']/100);
                                echo $currency . number_format($net_payable, 2, ".", ","); 
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Totals & Payment History -->
            <div style="display: flex; justify-content: space-between; gap: 40px; margin-bottom: 40px;">
                <!-- History -->
                <div style="flex: 6;">
                    <?php
                    $payment_history = $this->db->get_where('payment', array('invoice_id' => $row['invoice_id']))->result_array();
                    if(count($payment_history) > 0): ?>
                    <h5 style="color: #95a5a6; text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; margin: 0 0 10px; font-weight: 600;">Transaction History</h5>
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px; border: 1px solid #edf2f7; border-radius: 6px; overflow: hidden;">
                        <tr style="background: #f8f9fa;"><th style="padding: 8px 10px; text-align:left; border-bottom:1px solid #edf2f7;">Date</th><th style="padding: 8px 10px; text-align:left; border-bottom:1px solid #edf2f7;">Method</th><th style="padding: 8px 10px; text-align:right; border-bottom:1px solid #edf2f7;">Amount Paid</th></tr>
                        <?php foreach ($payment_history as $row2): ?>
                        <tr>
                            <td style="padding: 8px 10px; border-bottom:1px solid #edf2f7; color: #555;"><?php echo date("d M, Y", $row2['timestamp']); ?></td>
                            <td style="padding: 8px 10px; border-bottom:1px solid #edf2f7; color: #555;">
                                <?php 
                                    if ($row2['method'] == 1) echo 'Cash';
                                    elseif ($row2['method'] == 2) echo 'Cheque';
                                    elseif ($row2['method'] == 3) echo 'Card';
                                    elseif ($row2['method'] == 4) echo 'UPI';
                                    elseif ($row2['method'] == 'paypal') echo 'PayPal';
                                    else echo 'Bank Transfer';
                                ?>
                            </td>
                            <td style="padding: 8px 10px; text-align:right; border-bottom:1px solid #edf2f7; font-weight: 600; color: #2ecc71;">+<?php echo $currency; ?><?php echo number_format($row2['amount'],2,".",",");?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                        <div style="padding: 15px; background: #fff8e1; border-left: 3px solid #ffc107; font-size: 13px; color: #555;">
                            No payment transactions recorded yet.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Totals Summary -->
                <div style="flex: 4;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <tr><td style="padding: 8px 0; color: #555;">Net Payable:</td><td style="padding: 8px 0; text-align: right; color: #333; font-weight: 500;"><?php echo $currency; ?><?php echo number_format($net_payable, 2, ".", ","); ?></td></tr>
                        <tr><td style="padding: 8px 0; color: #555; border-bottom: 2px solid #edf2f7;">Total Paid:</td><td style="padding: 8px 0; text-align: right; color: #2ecc71; font-weight: 600; border-bottom: 2px solid #edf2f7;">-<?php echo $currency; ?><?php echo number_format($row['amount_paid'], 2, ".", ","); ?></td></tr>
                        <tr><td style="padding: 12px 0; color: #2c3e50; font-size: 18px; font-weight: 800;">Balance Due:</td><td style="padding: 12px 0; text-align: right; color: #e74c3c; font-size: 18px; font-weight: 800;"><?php echo $currency; ?><?php echo number_format($row['due'], 2, ".", ","); ?></td></tr>
                    </table>
                </div>
            </div>

            <!-- Footer & Signatures -->
            <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div style="flex: 1; font-size: 11px; color: #95a5a6; line-height: 1.5;">
                    <p style="margin: 0;"><strong>Terms & Conditions:</strong><br>1. This is an authenticated receipt containing digital signatures.<br>2. Fees once paid are non-refundable.<br>3. Keep this receipt safe for future reference.</p>
                </div>
                
                <div style="text-align: center; margin-right: 30px; position: relative;">
                    <img src="<?php echo base_url('uploads/signature.png'); ?>?v=<?php echo time(); ?>" style="height: 40px; position: absolute; bottom: 25px; left: 50%; transform: translateX(-50%); -webkit-print-color-adjust: exact !important;" onerror="this.style.display='none'">
                    <div style="border-top: 1px solid #555; width: 150px; margin: 0 auto; padding-top: 5px; position: relative; z-index: 1; font-size: 12px;">
                        <strong>Authorized Signatory</strong>
                    </div>
                </div>
                <!-- Fake QR Code for aesthetics -->
                <div style="width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?php echo urlencode('INV:'.$row['invoice_number'].'|STU:'.$student->roll.'|DUE:'.$currency.$row['due']); ?>" alt="QR Code">
                </div>
            </div>

        </div> <!-- End relative z-index wrapper -->
    </div> <!-- End invoice container -->
<?php endforeach; ?>

<script type="text/javascript">
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=800,width=900');
        mywindow.document.write('<html><head><title>Receipt - <?php echo $system_name; ?></title>');
        mywindow.document.write('<style>');
        mywindow.document.write('@import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap");');
        mywindow.document.write('body { font-family: "Inter", sans-serif; padding: 0; margin: 0; background: #fff; }');
        mywindow.document.write('@media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } button { display: none; } }');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();

        // small delay to load QR code image
        setTimeout(function() {
            mywindow.focus();
            mywindow.print();
        }, 500);

        return true;
    }
</script>