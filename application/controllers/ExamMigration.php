<?php
class ExamMigration extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }

    public function run() {
        echo "<pre>Starting Exam Migration...\n";
        
        // 1. ADD academic_year TO exam
        if (!$this->db->field_exists('academic_year', 'exam')) {
            $fields = ['academic_year' => ['type' => 'VARCHAR', 'constraint' => '50', 'default' => '2023-2024']];
            $this->dbforge->add_column('exam', $fields);
            echo "Added academic_year to exam table.\n";
        }
        
        // Ensure default exams exist
        $defaults = ['PT-1 (Pre-Mid Term)', 'Half-Yearly (Mid-Term)', 'Annual (Final) Exam'];
        foreach($defaults as $exam_name) {
            $q = $this->db->get_where('exam', ['name' => $exam_name]);
            if ($q->num_rows() == 0) {
                $this->db->insert('exam', ['name' => $exam_name, 'comment' => 'Standard Term Exam']);
                echo "Seeded exam: $exam_name\n";
            }
        }

        // 2. CREATE exam_components table
        if (!$this->db->table_exists('exam_components')) {
            $fields = [
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'subject_id' => ['type' => 'INT', 'constraint' => 11],
                'component_name' => ['type' => 'VARCHAR', 'constraint' => '50'],
                'max_marks' => ['type' => 'INT', 'constraint' => 11, 'default' => 100]
            ];
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('exam_components', TRUE);
            echo "Created exam_components table.\n";
        }

        // 3. CREATE NEW marks table (We'll call it exam_marks to keep 'mark' data safe while remodeling, OR just rename old to mark_old and create new 'mark')
        // Let's rename old 'mark' to 'mark_old' if it hasn't been done
        if ($this->db->field_exists('class_score1', 'mark')) {
            $this->dbforge->rename_table('mark', 'mark_old');
            echo "Renamed old mark table to mark_old to preserve data.\n";
            
            // Create NEW marks table
            $fields = [
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'student_id' => ['type' => 'INT', 'constraint' => 11],
                'subject_id' => ['type' => 'INT', 'constraint' => 11],
                'exam_id' => ['type' => 'INT', 'constraint' => 11],
                'class_id' => ['type' => 'INT', 'constraint' => 11],
                'component_type' => ['type' => 'VARCHAR', 'constraint' => '50'], // PT, NOTEBOOK, ENRICHMENT, WRITTEN
                'marks_obtained' => ['type' => 'VARCHAR', 'constraint' => '10'], // varchar to support 'AB' (Absent)
                'max_marks' => ['type' => 'INT', 'constraint' => 11],
            ];
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('mark', TRUE);
            echo "Created NEW mark table.\n";
        }

        // 4. CREATE results table
        if (!$this->db->table_exists('exam_results')) {
            $fields = [
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'student_id' => ['type' => 'INT', 'constraint' => 11],
                'exam_id' => ['type' => 'INT', 'constraint' => 11],
                'class_id' => ['type' => 'INT', 'constraint' => 11],
                'total_marks' => ['type' => 'FLOAT'],
                'percentage' => ['type' => 'FLOAT'],
                'grade' => ['type' => 'VARCHAR', 'constraint' => '10'],
                'class_rank' => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],
                'section_rank' => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE]
            ];
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('exam_results', TRUE);
            echo "Created exam_results table.\n";
        }

        // 5. CREATE remarks table
        if (!$this->db->table_exists('exam_remarks')) {
            $fields = [
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'student_id' => ['type' => 'INT', 'constraint' => 11],
                'teacher_id' => ['type' => 'INT', 'constraint' => 11],
                'exam_id' => ['type' => 'INT', 'constraint' => 11],
                'text' => ['type' => 'TEXT']
            ];
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('exam_remarks', TRUE);
            echo "Created exam_remarks table.\n";
        }

        echo "Exam Migration Complete!</pre>";
    }
}
