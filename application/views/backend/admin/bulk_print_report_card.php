<style>
    @media print {
        .no-print { display: none !important; }
        .page-break { page-break-after: always; }
    }
    .btn-print-all { background: #1e3a8a; color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: 700; font-size: 15px; margin-bottom: 20px; }
    .btn-print-all:hover { background: #172554; color: white; }
</style>

<div class="no-print" style="padding: 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; margin-bottom: 20px;">
    <h3 style="margin:0 0 10px 0; font-family: 'Inter', sans-serif; font-weight: 700; color: #1e293b;">
        <i class="fa fa-print" style="color:#667eea;"></i> 
        Bulk Report Cards — <?php echo isset($class['name']) ? $class['name'] : ''; ?> | <?php echo isset($exam['name']) ? $exam['name'] : ''; ?>
    </h3>
    <p style="margin:0 0 15px 0; font-size:13px; color:#64748b;">
        <?php echo count($students); ?> student report cards will be generated below. Each card will print on a separate A4 page.
    </p>
    <button class="btn-print-all" onclick="window.print();"><i class="fa fa-print"></i> Print All Report Cards</button>
    <a href="<?php echo base_url(); ?>admin/marksheet_view" class="btn-print-all" style="background:#6b7280; margin-left:10px; text-decoration:none;">
        <i class="fa fa-arrow-left"></i> Back to Marksheet
    </a>
</div>

<?php 
$total_students = count($students);
$counter = 0;
foreach ($students as $student):
    $counter++;
    $student_id = $student['student_id'];
    
    // Get marks for this student
    $marks = $this->db->get_where('mark', ['student_id' => $student_id, 'exam_id' => $exam_id])->result_array();
    $subjects = $this->db->get_where('subject', ['class_id' => $class_id])->result_array();
    
    $grand_total = 0; $grand_max = 0;
?>

<div style="padding: 30px; border: 1px solid #e2e8f0; margin: 0 15px 20px 15px; border-radius: 8px; background: white; font-family: 'Inter', sans-serif;">
    <!-- Header -->
    <div style="text-align: center; border-bottom: 2px solid #1e293b; padding-bottom: 15px; margin-bottom: 15px;">
        <?php $school_name = $this->db->get_where('settings', ['type' => 'system_name'])->row()->description; ?>
        <h2 style="margin: 0; font-size: 20px; font-weight: 800; color: #1e293b;"><?php echo $school_name; ?></h2>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #64748b;">REPORT CARD — <?php echo isset($exam['name']) ? strtoupper($exam['name']) : ''; ?></p>
    </div>

    <!-- Student Info -->
    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #334155; margin-bottom: 15px;">
        <div><strong>Name:</strong> <?php echo $student['name']; ?></div>
        <div><strong>Roll:</strong> <?php echo $student['roll']; ?></div>
        <div><strong>Class:</strong> <?php echo isset($class['name']) ? $class['name'] : ''; ?></div>
    </div>

    <!-- Marks Table -->
    <table style="width:100%; border-collapse:collapse; font-size:12px;">
        <thead>
            <tr style="background:#f1f5f9;">
                <th style="border:1px solid #cbd5e1; padding:8px; text-align:left;">Subject</th>
                <th style="border:1px solid #cbd5e1; padding:8px; text-align:center;">Marks</th>
                <th style="border:1px solid #cbd5e1; padding:8px; text-align:center;">Max</th>
                <th style="border:1px solid #cbd5e1; padding:8px; text-align:center;">Grade</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($subjects as $subj):
            $mark_row = null;
            foreach ($marks as $m) {
                if ($m['subject_id'] == $subj['subject_id']) { $mark_row = $m; break; }
            }
            $obtained = $mark_row ? (float)$mark_row['marks_obtained'] : 0;
            $max = 100;
            $grand_total += $obtained; $grand_max += $max;
            $pct = $max > 0 ? ($obtained / $max) * 100 : 0;
            
            if ($pct >= 91) $g = 'A1';
            elseif ($pct >= 81) $g = 'A2';
            elseif ($pct >= 71) $g = 'B1';
            elseif ($pct >= 61) $g = 'B2';
            elseif ($pct >= 51) $g = 'C1';
            elseif ($pct >= 41) $g = 'C2';
            elseif ($pct >= 33) $g = 'D';
            else $g = 'E';
        ?>
            <tr>
                <td style="border:1px solid #cbd5e1; padding:8px; font-weight:600;"><?php echo $subj['name']; ?></td>
                <td style="border:1px solid #cbd5e1; padding:8px; text-align:center; font-weight:700;"><?php echo $obtained; ?></td>
                <td style="border:1px solid #cbd5e1; padding:8px; text-align:center;"><?php echo $max; ?></td>
                <td style="border:1px solid #cbd5e1; padding:8px; text-align:center;"><strong><?php echo $g; ?></strong></td>
            </tr>
        <?php endforeach; ?>
            <tr style="background:#f1f5f9; font-weight:700;">
                <td style="border:1px solid #cbd5e1; padding:8px;">TOTAL</td>
                <td style="border:1px solid #cbd5e1; padding:8px; text-align:center;"><?php echo $grand_total; ?></td>
                <td style="border:1px solid #cbd5e1; padding:8px; text-align:center;"><?php echo $grand_max; ?></td>
                <td style="border:1px solid #cbd5e1; padding:8px; text-align:center;">
                    <?php echo $grand_max > 0 ? number_format(($grand_total/$grand_max)*100, 1) . '%' : '-'; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Signatures -->
    <div style="display: flex; justify-content: space-between; margin-top: 50px; font-size: 12px; color: #334155; position: relative;">
        <div style="text-align:center; width: 30%;"><div style="border-top: 1px solid #94a3b8; padding-top: 5px;">Class Teacher</div></div>
        <div style="text-align:center; width: 30%;"><div style="border-top: 1px solid #94a3b8; padding-top: 5px;">Parent Signature</div></div>
        <div style="text-align:center; width: 30%; position: relative;">
            <img src="<?php echo base_url('uploads/signature.png'); ?>?v=<?php echo time(); ?>" style="height: 35px; position: absolute; bottom: 25px; left: 50%; transform: translateX(-50%); z-index: 2; object-fit: contain; -webkit-print-color-adjust: exact !important;" onerror="this.style.display='none'">
            <div style="border-top: 1px solid #94a3b8; padding-top: 5px; position: relative; z-index: 1;">Principal</div>
        </div>
    </div>
</div>

<?php if ($counter < $total_students): ?>
<div class="page-break"></div>
<?php endif; ?>

<?php endforeach; ?>
