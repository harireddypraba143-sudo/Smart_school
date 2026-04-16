<?php
class Dbdump extends CI_Controller {
    public function index() {
        $this->load->dbutil();

        $prefs = array(
            'format'      => 'txt',             // gzip, zip, txt
            'filename'    => 'smart_school.sql',    // File name - need only for zip download
            'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
            'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
            'newline'     => "\n"               // Newline character used in backup file
        );

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file('/Users/harinathreddy/Downloads/Smart_school/final_smart_school_db.sql', $backup);
        
        echo "DATABASE EXPORTED SUCCESSFULLY! The .sql file is saved in the root Smart_school folder.";
    }
}
