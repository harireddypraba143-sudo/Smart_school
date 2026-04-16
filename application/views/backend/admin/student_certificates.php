<div class="row">
<div class="col-sm-12">
    <div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-certificate"></i>&nbsp;&nbsp;Student Certificates</div>
        <div class="panel-wrapper collapse in" aria-expanded="true">
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Select Class</label>
                            <select id="cert_class_id" class="form-control select2" style="width:100%">
                                <option value="">-- Select Class --</option>
                                <?php $classes = $this->db->get('class')->result_array();
                                foreach($classes as $cls): ?>
                                <option value="<?php echo $cls['class_id']; ?>"><?php echo $cls['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Select Student</label>
                            <select id="cert_student_id" class="form-control select2" style="width:100%">
                                <option value="">-- Select Class First --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Certificate Type</label>
                            <select id="cert_type" class="form-control">
                                <option value="">-- Select Certificate --</option>
                                <option value="transfer">Transfer Certificate (TC)</option>
                                <option value="bonafide">Bonafide Certificate</option>
                                <option value="achievement">Achievement Certificate</option>
                                <option value="study">Study Certificate</option>
                                <option value="character">Character Certificate</option>
                                <option value="migration">Migration Certificate</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="button" id="generate_cert_btn" class="btn btn-success btn-rounded" style="padding: 10px 40px; font-size: 15px;">
                            <i class="fa fa-file-pdf-o"></i>&nbsp; Generate & Download Certificate
                        </button>
                    </div>
                </div>

                <hr>

                <!-- Certificate Preview Area -->
                <div id="cert_preview_area" style="display:none;">
                    <div class="text-right" style="margin-bottom: 10px;">
                        <button onclick="printCertificate()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print / Save as PDF</button>
                    </div>
                    <div id="cert_content" style="border: 2px solid #ccc; padding: 10px; background: #fff;"></div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#cert_class_id').select2();
    $('#cert_student_id').select2();

    // Load students when class is selected
    $('#cert_class_id').on('change', function() {
        var class_id = $(this).val();
        if (class_id == '') return;
        $.ajax({
            url: '<?php echo base_url(); ?>admin/get_students_for_cert/' + class_id,
            success: function(response) {
                $('#cert_student_id').html(response);
            }
        });
    });

    // Generate certificate
    $('#generate_cert_btn').on('click', function() {
        var student_id = $('#cert_student_id').val();
        var cert_type = $('#cert_type').val();
        if (!student_id || !cert_type) {
            $.toast({ text: 'Please select class, student and certificate type', position: 'top-right', loaderBg: '#f56954', icon: 'warning', hideAfter: 3500 });
            return;
        }
        $.ajax({
            url: '<?php echo base_url(); ?>admin/generate_certificate/' + student_id + '/' + cert_type,
            success: function(response) {
                $('#cert_content').html(response);
                $('#cert_preview_area').slideDown();
                // Scroll to preview
                $('html, body').animate({ scrollTop: $('#cert_preview_area').offset().top - 100 }, 500);
            }
        });
    });
});

function printCertificate() {
    var content = document.getElementById('cert_content').innerHTML;
    var win = window.open('', '_blank');
    win.document.write('<html><head><title>Certificate</title>');
    win.document.write('<style>@media print { body { margin: 0; } } body { font-family: "Georgia", "Times New Roman", serif; }</style>');
    win.document.write('</head><body>');
    win.document.write(content);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}
</script>
