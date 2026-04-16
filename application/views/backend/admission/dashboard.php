<!-- Admission Dashboard -->
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title"><i class="fa fa-dashboard"></i> <?php echo get_phrase('dashboard'); ?> — Admissions</h3>
    </div>
</div>

<div class="row">
    <!-- Total Students -->
    <div class="col-lg-4 col-sm-6">
        <div class="panel panel-info">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <h3><?php echo $this->db->count_all('student'); ?></h3>
                <p><i class="fa fa-graduation-cap"></i> <?php echo get_phrase('total_students'); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Classes -->
    <div class="col-lg-4 col-sm-6">
        <div class="panel panel-success">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <h3><?php echo $this->db->count_all('class'); ?></h3>
                <p><i class="fa fa-book"></i> <?php echo get_phrase('total_classes'); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Enquiries -->
    <div class="col-lg-4 col-sm-6">
        <div class="panel panel-warning">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <h3><?php echo $this->db->count_all('enquiry'); ?></h3>
                <p><i class="fa fa-question-circle"></i> <?php echo get_phrase('enquiry'); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Students -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-list"></i>&nbsp;&nbsp;Recently Added Students</div>
            <div class="panel-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('email'); ?></th>
                            <th><?php echo get_phrase('class'); ?></th>
                            <th><?php echo get_phrase('roll'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $this->db->order_by('student_id', 'desc');
                        $this->db->limit(10);
                        $students = $this->db->get('student')->result_array();
                        $count = 1;
                        foreach ($students as $s):
                            $class_name = $this->db->get_where('class', array('class_id' => $s['class_id']))->row();
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $s['name']; ?></td>
                            <td><?php echo $s['email']; ?></td>
                            <td><?php echo $class_name ? $class_name->name : '-'; ?></td>
                            <td><?php echo $s['roll']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
