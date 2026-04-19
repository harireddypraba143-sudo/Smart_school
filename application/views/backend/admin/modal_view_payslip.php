<?php 
$payroll = $this->db->get_where('payroll', array('payroll_id' => $param2))->row();
$teacher = $this->db->get_where('teacher', array('teacher_id' => $payroll->employee_id))->row();
$system_currency = $this->db->get_where('settings', array('type'=>'currency'))->row()->description;
$system_name = $this->db->get_where('settings', array('type'=>'system_title'))->row()->description;
$system_email = $this->db->get_where('settings', array('type'=>'system_email'))->row()->description;
$system_phone = $this->db->get_where('settings', array('type'=>'phone'))->row()->description;
$system_address = $this->db->get_where('settings', array('type'=>'address'))->row()->description;

$dept = $this->db->get_where('department', array('department_id'=>$teacher->department_id))->row();
$dept_name = $dept ? $dept->name : 'N/A';

$designation = $this->db->get_where('designation', array('designation_id'=>$teacher->designation_id))->row();
$designation_name = $designation ? $designation->name : 'Staff';

$allowances = $this->db->get_where('payroll_items', array('payroll_id' => $payroll->payroll_id, 'type' => 'allowance'))->result_array();
$deductions = $this->db->get_where('payroll_items', array('payroll_id' => $payroll->payroll_id, 'type' => 'deduction'))->result_array();

// Get Bank Details (assuming stored in teacher table or defaults)
$bank_name = isset($teacher->bank_name) ? $teacher->bank_name : 'N/A';
$account_no = isset($teacher->account_no) ? $teacher->account_no : 'N/A';

// Gross Calculations
$gross_earnings = $payroll->basic_salary + $payroll->allowances;
$gross_deductions = $payroll->deductions;

// Number to words function
if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        if (($number < 0) || ($number > 999999999)) { return "$number"; }
        $Gn = floor($number / 100000);  /* Lakhs */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000);     /* Thousands */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);      /* Hundreds */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens */
        $n = $number % 10;               /* Ones */

        $res = "";
        if ($Gn) { $res .= numberToWords($Gn) . " Lakh "; }
        if ($kn) { $res .= (empty($res) ? "" : " ") . numberToWords($kn) . " Thousand "; }
        if ($Hn) { $res .= (empty($res) ? "" : " ") . numberToWords($Hn) . " Hundred "; }

        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");

        if ($Dn || $n) {
            if (!empty($res)) { $res .= " and "; }
            if ($Dn < 2) { $res .= $ones[$Dn * 10 + $n]; }
            else {
                $res .= $tens[$Dn];
                if ($n) { $res .= "-" . $ones[$n]; }
            }
        }
        if (empty($res)) { $res = "Zero"; }
        return trim($res);
    }
}
$amount_in_words = numberToWords(floor($payroll->net_salary));
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-body" id="printable_payslip" style="background: white; padding: 20px;">
                
                <style type="text/css">
                    /* Screen Styles - matching the print styles */
                    .ps-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif; font-size: 11px; }
                    .ps-table th, .ps-table td { border: 1px solid #333; padding: 6px 10px; }
                    .ps-label { background-color: #badba7; font-weight: bold; width: 20%; color: #000; }
                    .ps-value { background-color: #fff; width: 30%; color: #000;}
                    .ps-header { background-color: #0b4a0b; height: 30px; }
                    .ps-title { text-align: center; font-weight: bold; font-size: 14px; background: #fff; color: #000;}
                    .ps-gross { font-weight: bold; background-color: #fff; color: #000; }
                    
                    /* School Header Grid */
                    .sch-header { display: flex; flex-wrap: wrap; margin-bottom: 10px; width: 100%; border-bottom: 2px solid #0b4a0b; padding-bottom: 15px;}
                    .sch-left { width: 60%; }
                    .sch-right { width: 40%; text-align: right; }
                </style>

                <!-- School Header Section -->
                <div class="sch-header">
                    <div class="sch-left">
                        <h3 style="margin: 0; font-weight: bold; color: #0b4a0b; text-transform: uppercase;;"><?php echo $system_name; ?></h3>
                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #333;">
                            <?php echo $system_address; ?><br>
                            Ph: <?php echo $system_phone; ?> | Email: <?php echo $system_email; ?><br>
                            <strong>PAN/GST:</strong> <span style="color:#777">[Update in Settings]</span>
                        </p>
                    </div>
                    <div class="sch-right">
                        <img src="<?php echo base_url();?>uploads/logo.png" alt="School Logo" style="max-height: 60px;">
                    </div>
                </div>

                <!-- Employee Details Table -->
                <table class="ps-table">
                    <tr>
                        <td colspan="4" class="ps-header"></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="ps-title">PAY SLIP FOR <?php echo strtoupper(date('M Y', mktime(0, 0, 0, $payroll->month, 1, $payroll->year))); ?></td>
                    </tr>
                    <tr>
                        <td class="ps-label">Employee ID</td>
                        <td class="ps-value"><?php echo $teacher->teacher_number; ?></td>
                        <td class="ps-label">Full Name</td>
                        <td class="ps-value" style="font-weight: bold;"><?php echo $teacher->name; ?></td>
                    </tr>
                    <tr>
                        <td class="ps-label">Bank Name</td>
                        <td class="ps-value"><?php echo $bank_name; ?></td>
                        <td class="ps-label">Bank A/c No.</td>
                        <td class="ps-value"><?php echo $account_no; ?></td>
                    </tr>
                    <tr>
                        <td class="ps-label">PF UAN No.</td>
                        <td class="ps-value">N/A</td>
                        <td class="ps-label">Date of Joining</td>
                        <td class="ps-value"><?php echo $teacher->date_of_joining ? date('d-M-Y', strtotime($teacher->date_of_joining)) : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td class="ps-label">Department</td>
                        <td class="ps-value"><?php echo strtoupper($dept_name); ?></td>
                        <td class="ps-label">Designation</td>
                        <td class="ps-value"><?php echo strtoupper($designation_name); ?></td>
                    </tr>
                    
                    <!-- Attendance Row -->
                    <?php $total_days = cal_days_in_month(CAL_GREGORIAN, $payroll->month, $payroll->year); ?>
                    <tr>
                        <td class="ps-label" style="background:#e8f4e2 !important; border-top: 2px solid #000;">Total Working Days</td>
                        <td class="ps-value" style="border-top: 2px solid #000;"><?php echo $total_days; ?></td>
                        <td class="ps-label" style="background:#e8f4e2 !important; border-top: 2px solid #000;">Leaves Taken (LOP)</td>
                        <td class="ps-value" style="border-top: 2px solid #000;">0</td>
                    </tr>
                    <tr>
                        <td class="ps-label" style="background:#e8f4e2 !important;">Days Present</td>
                        <td class="ps-value" style="color:#0b4a0b; font-weight:bold;"><?php echo $total_days; ?></td>
                        <td class="ps-label" style="background:#e8f4e2 !important;"></td>
                        <td class="ps-value"></td>
                    </tr>
                </table>

                <!-- Earnings & Deductions Table -->
                <table class="ps-table">
                    <tr>
                        <td class="ps-label" style="text-align: center; width: 35%;">Earnings</td>
                        <td class="ps-label" style="text-align: right; width: 15%;">Amount in <?php echo $system_currency; ?></td>
                        <td class="ps-label" style="text-align: center; width: 35%;">Deductions</td>
                        <td class="ps-label" style="text-align: right; width: 15%;">Amount in <?php echo $system_currency; ?></td>
                    </tr>
                    <tr>
                        <!-- EARNINGS COLUMN -->
                        <td colspan="2" style="padding:0; vertical-align:top; border-right: 1px solid #333; border-bottom: 1px solid #333;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; padding: 6px 10px;">BASIC</td>
                                    <td style="border-bottom: 1px solid #ccc; text-align: right; padding: 6px 10px;"><?php echo number_format($payroll->basic_salary, 2); ?></td>
                                </tr>
                                <?php foreach($allowances as $al): ?>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; padding: 6px 10px;"><?php echo strtoupper($al['name']); ?></td>
                                    <td style="border-bottom: 1px solid #ccc; text-align: right; padding: 6px 10px;"><?php echo number_format($al['amount'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <!-- Fill empty space if needed -->
                                <?php 
                                $diff = count($deductions) - count($allowances);
                                for($i=0; $i<$diff; $i++) {
                                    echo '<tr><td style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; padding: 6px 10px;">&nbsp;</td><td style="border-bottom: 1px solid #ccc; padding: 6px 10px;">&nbsp;</td></tr>';
                                }
                                ?>
                            </table>
                        </td>

                        <!-- DEDUCTIONS COLUMN -->
                        <td colspan="2" style="padding:0; vertical-align:top; border-bottom: 1px solid #333;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <?php foreach($deductions as $de): ?>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; padding: 6px 10px;"><?php echo strtoupper($de['name']); ?></td>
                                    <td style="border-bottom: 1px solid #ccc; text-align: right; padding: 6px 10px;"><?php echo number_format($de['amount'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <!-- Fill empty space if needed -->
                                <?php 
                                $diff = count($allowances) - count($deductions) + 1; // +1 for BASIC
                                for($i=0; $i<$diff; $i++) {
                                    echo '<tr><td style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; padding: 6px 10px;">&nbsp;</td><td style="border-bottom: 1px solid #ccc; padding: 6px 10px;">&nbsp;</td></tr>';
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- GROSS TOTALS -->
                    <tr class="ps-gross">
                        <td style="padding: 6px 10px;">GROSS EARNING</td>
                        <td style="text-align: right; padding: 6px 10px;"><?php echo number_format($gross_earnings, 2); ?></td>
                        <td style="padding: 6px 10px;">GROSS DEDUCTIONS</td>
                        <td style="text-align: right; padding: 6px 10px;"><?php echo number_format($gross_deductions, 2); ?></td>
                    </tr>
                    
                    <!-- NET PAY -->
                    <tr class="ps-gross">
                        <td colspan="2" style="text-align: center; border-right: none; padding: 10px;"></td>
                        <td style="padding: 10px; border-left: none; text-align: right;">NET PAY</td>
                        <td style="text-align: right; padding: 10px; border-left: 1px solid #333; font-size: 14px;"><?php echo number_format($payroll->net_salary, 2); ?></td>
                    </tr>
                    
                    <!-- AMOUNT IN WORDS -->
                    <tr>
                        <td colspan="4" style="padding: 10px; background: whitesmoke; border-top: 2px solid #000; font-style: italic; font-size: 12px;">
                            <strong>Amount in words:</strong> Rupees <?php echo $amount_in_words; ?> Only
                        </td>
                    </tr>
                </table>

                <div style="text-align: center; margin-top: 20px; font-size: 11px; color: #555; position: relative;">
                    <img src="<?php echo base_url('uploads/signature.png'); ?>" style="height: 45px; display: block; margin: 0 auto 5px auto; -webkit-print-color-adjust: exact !important;" onerror="this.style.display='none'">
                    <hr style="border: 0; border-top: 1px dashed #ccc; margin-bottom: 10px;">
                    <p style="margin: 0; font-family: monospace;">This is an officially authenticated payslip containing digital signatures.</p>
                </div>

            </div>
        </div>
        
        <div class="text-right">
            <button class="btn btn-primary btn-rounded" onclick="PrintFormat('#printable_payslip')"><i class="fa fa-print"></i> Print Payslip</button>
        </div>

    </div>
</div>

<script type="text/javascript">
    function PrintFormat(elem) {
        var mywindow = window.open('', 'PRINT', 'height=800,width=900');
        
        mywindow.document.write('<html><head><title>Payslip - <?php echo $teacher->name; ?></title>');
        // Print Styles
        mywindow.document.write('<style>');
        mywindow.document.write('body { font-family: Arial, sans-serif; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; background: #fff; margin: 0; padding: 20px; font-size: 11px;}');
        mywindow.document.write('.ps-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }');
        mywindow.document.write('.ps-table th, .ps-table td { border: 1px solid #000; padding: 6px 10px; }');
        mywindow.document.write('.ps-label { background-color: #badba7 !important; font-weight: bold; width: 20%; color:#000 !important;}');
        mywindow.document.write('.ps-value { background-color: #fff !important; width: 30%; color:#000 !important;}');
        mywindow.document.write('.ps-header { background-color: #0b4a0b !important; height: 30px; }');
        mywindow.document.write('.ps-title { text-align: center; font-weight: bold; font-size: 14px; background: #fff !important; }');
        mywindow.document.write('.ps-gross { font-weight: bold; background-color: #fff !important; color:#000 !important; }');
        
        mywindow.document.write('.sch-header { display: flex; flex-wrap: wrap; margin-bottom: 20px; width: 100%; border-bottom: 2px solid #0b4a0b; padding-bottom: 15px;}');
        mywindow.document.write('.sch-left { width: 60%; }');
        mywindow.document.write('.sch-right { width: 40%; text-align: right; }');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(document.querySelector(elem).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); 
        mywindow.focus(); 

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 800);

        return true;
    }
</script>
