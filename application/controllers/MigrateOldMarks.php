<?php
class MigrateOldMarks extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function run() {
        echo "<pre>Starting Data Migration...\n";
        
        $old_marks = $this->db->get('mark_old')->result_array();
        $count = 0;
        
        foreach($old_marks as $old) {
            $base = [
                'student_id' => $old['student_id'],
                'subject_id' => $old['subject_id'],
                'exam_id' => $old['exam_id'],
                'class_id' => $old['class_id']
            ];
            
            // Map components
            $components = [
                'PT' => ['score' => $old['class_score1'], 'max' => 10],
                'NOTEBOOK' => ['score' => $old['class_score2'], 'max' => 5],
                'ENRICHMENT' => ['score' => $old['class_score3'], 'max' => 5],
                'WRITTEN' => ['score' => $old['exam_score'], 'max' => 80]
            ];
            
            foreach($components as $type => $data) {
                // Check if already migrated
                $chk = array_merge($base, ['component_type' => $type]);
                $q = $this->db->get_where('mark', $chk);
                if ($q->num_rows() == 0 && ($data['score'] > 0 || $data['score'] === '0')) {
                    $insert_data = array_merge($chk, [
                        'marks_obtained' => $data['score'],
                        'max_marks' => $data['max']
                    ]);
                    $this->db->insert('mark', $insert_data);
                    $count++;
                }
            }
            
            // Migrate comment to remarks if exists
            if (!empty($old['comment'])) {
                $rem_q = $this->db->get_where('exam_remarks', ['student_id' => $old['student_id'], 'exam_id' => $old['exam_id']]);
                if ($rem_q->num_rows() == 0) {
                    $this->db->insert('exam_remarks', [
                        'student_id' => $old['student_id'],
                        'exam_id' => $old['exam_id'],
                        'teacher_id' => 1,
                        'text' => $old['comment']
                    ]);
                }
            }
        }
            
        echo "Successfully migrated $count component records from old marks table!\n";
        echo "Done.</pre>";
    }
}
