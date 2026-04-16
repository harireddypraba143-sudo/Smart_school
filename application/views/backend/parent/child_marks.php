<style>
    .premium-wrapper { font-family: 'Inter', sans-serif; }
    .premium-card { background: #fff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 5px; margin-top: 0; }
    .breadcrumb-text { font-size: 13px; color: #64748b; margin-bottom: 20px; }
    .filter-select { border-radius: 6px; border: 1px solid #cbd5e1; height: 42px; width: 100%; padding: 0 12px; font-size: 14px; color: #334155; }
    .marks-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .marks-table th, .marks-table td { border: 1px solid #e2e8f0; padding: 10px; font-size: 13px; text-align: center; }
    .marks-table th { background: #f8fafc; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; }
    .marks-table td { color: #334155; }
    .grade-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; }
    .grade-A1, .grade-A2 { background: #dcfce7; color: #166534; }
    .grade-B1, .grade-B2 { background: #fef9c3; color: #854d0e; }
    .grade-C1, .grade-C2 { background: #fed7aa; color: #c2410c; }
    .grade-D { background: #e0e7ff; color: #4338ca; }
    .grade-E { background: #fee2e2; color: #b91c1c; }
    .total-bar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; padding: 15px 25px; color: white; display: flex; justify-content: space-around; margin-top: 15px; }
    .total-bar .item { text-align: center; }
    .total-bar .val { font-size: 22px; font-weight: 800; }
    .total-bar .lab { font-size: 11px; opacity: 0.85; }
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; font-size: 14px; }
</style>

<div class="premium-wrapper">
<div class="row">
    <div class="col-md-12">
        <div class="premium-card">
            <h2 class="page-title"><i class="fa fa-clipboard" style="color:#667eea;"></i> Child's Report Card</h2>
            <div class="breadcrumb-text">Dashboard &rsaquo; Child's Report Card</div>

            <div class="row">
                <div class="col-md-4">
                    <label style="font-size:12px; font-weight:600; color:#64748b;">Select Examination</label>
                    <select class="filter-select" onchange="if(this.value) location.href='<?php echo base_url(); ?>parents/child_marks/' + this.value;">
                        <option value="">Choose Exam...</option>
                        <?php $exams = $this->db->get('exam')->result_array();
                        foreach ($exams as $e): ?>
                            <option value="<?php echo $e['exam_id']; ?>" <?php if($exam_id == $e['exam_id']) echo 'selected'; ?>><?php echo $e['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if ($exam_id > 0 && $student_id > 0):
                $marks = $this->db->get_where('mark', ['student_id' => $student_id, 'exam_id' => $exam_id])->result_array();
                $grand_total = 0; $grand_max = 0;
            ?>
                <?php if (!empty($marks)): ?>
                <table class="marks-table">
                    <thead>
                        <tr><th style="text-align:left; padding-left:15px;">Subject</th><th>Marks Obtained</th><th>Max Marks</th><th>Percentage</th><th>Grade</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($marks as $m):
                            $subj = $this->db->get_where('subject', ['subject_id' => $m['subject_id']])->row();
                            $subj_name = $subj ? $subj->name : 'N/A';
                            $obtained = (float)$m['marks_obtained'];
                            $max = isset($m['mark_total']) ? (float)$m['mark_total'] : 100;
                            $pct = $max > 0 ? ($obtained / $max) * 100 : 0;
                            $grand_total += $obtained; $grand_max += $max;
                            
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
                            <td style="text-align:left; padding-left:15px; font-weight:600;"><?php echo $subj_name; ?></td>
                            <td style="font-weight:700;"><?php echo $obtained; ?></td>
                            <td><?php echo $max; ?></td>
                            <td><?php echo number_format($pct, 1); ?>%</td>
                            <td><span class="grade-badge grade-<?php echo $g; ?>"><?php echo $g; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php
                    $overall_pct = $grand_max > 0 ? ($grand_total / $grand_max) * 100 : 0;
                    if ($overall_pct >= 91) $og = 'A1';
                    elseif ($overall_pct >= 81) $og = 'A2';
                    elseif ($overall_pct >= 71) $og = 'B1';
                    elseif ($overall_pct >= 61) $og = 'B2';
                    elseif ($overall_pct >= 51) $og = 'C1';
                    elseif ($overall_pct >= 41) $og = 'C2';
                    elseif ($overall_pct >= 33) $og = 'D';
                    else $og = 'E';
                ?>
                <div class="total-bar">
                    <div class="item"><div class="val"><?php echo $grand_total; ?> / <?php echo $grand_max; ?></div><div class="lab">Grand Total</div></div>
                    <div class="item"><div class="val"><?php echo number_format($overall_pct, 1); ?>%</div><div class="lab">Percentage</div></div>
                    <div class="item"><div class="val"><?php echo $og; ?></div><div class="lab">Overall Grade</div></div>
                </div>
                <?php else: ?>
                    <div class="empty-state"><i class="fa fa-info-circle" style="font-size:30px; margin-bottom:10px; display:block;"></i>No marks have been entered for this exam yet.</div>
                <?php endif; ?>
            <?php elseif ($exam_id == ''): ?>
                <div class="empty-state" style="margin-top:30px;"><i class="fa fa-hand-pointer-o" style="font-size:30px; margin-bottom:10px; display:block;"></i>Please select an exam to view your results.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
