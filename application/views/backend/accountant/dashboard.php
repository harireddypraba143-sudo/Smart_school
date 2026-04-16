<!-- Accountant Dashboard -->
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title"><i class="fa fa-dashboard"></i> <?php echo get_phrase('dashboard'); ?> — Accountant</h3>
    </div>
</div>

<div class="row">
    <!-- Total Invoices -->
    <div class="col-lg-3 col-sm-6">
        <div class="panel panel-info">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <h3>
                    <?php echo $this->db->where('status', '2')->count_all_results('invoice'); ?>
                </h3>
                <p><i class="fa fa-file-text"></i> <?php echo get_phrase('unpaid_invoices'); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Paid -->
    <div class="col-lg-3 col-sm-6">
        <div class="panel panel-success">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <h3>
                    <?php echo $this->db->where('status', '1')->count_all_results('invoice'); ?>
                </h3>
                <p><i class="fa fa-check-circle"></i> <?php echo get_phrase('paid_invoices'); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Income -->
    <div class="col-lg-3 col-sm-6">
        <div class="panel panel-warning">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <?php
                    $currency = $this->db->get_where('settings', array('type' => 'currency'))->row()->description;
                    $this->db->select_sum('amount');
                    $this->db->where('payment_type', 'income');
                    $total_income = $this->db->get('payment')->row()->amount;
                ?>
                <h3><?php echo $currency . number_format($total_income ? $total_income : 0, 2); ?></h3>
                <p><i class="fa fa-arrow-up"></i> <?php echo get_phrase('total_income'); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Expenses -->
    <div class="col-lg-3 col-sm-6">
        <div class="panel panel-danger">
            <div class="panel-body" style="padding:20px; text-align:center;">
                <?php
                    $this->db->select_sum('amount');
                    $this->db->where('payment_type', 'expense');
                    $total_expense = $this->db->get('payment')->row()->amount;
                ?>
                <h3><?php echo $currency . number_format($total_expense ? $total_expense : 0, 2); ?></h3>
                <p><i class="fa fa-arrow-down"></i> <?php echo get_phrase('total_expense'); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Unpaid Invoices -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-list"></i>&nbsp;&nbsp;Recent Unpaid Invoices</div>
            <div class="panel-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('student'); ?></th>
                            <th><?php echo get_phrase('title'); ?></th>
                            <th><?php echo get_phrase('total'); ?></th>
                            <th><?php echo get_phrase('due'); ?></th>
                            <th><?php echo get_phrase('date'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $this->db->where('status', '2');
                        $this->db->order_by('invoice_id', 'desc');
                        $this->db->limit(10);
                        $invoices = $this->db->get('invoice')->result_array();
                        $count = 1;
                        foreach ($invoices as $inv):
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('student', $inv['student_id']); ?></td>
                            <td><?php echo $inv['title']; ?></td>
                            <td><?php echo $currency . number_format($inv['amount'], 2); ?></td>
                            <td><span class="label label-danger"><?php echo $currency . number_format($inv['due'], 2); ?></span></td>
                            <td><?php echo $inv['creation_timestamp']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
