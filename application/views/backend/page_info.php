<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $__login_type = $this->session->userdata('login_type'); ?>
                <?php if ($__login_type != 'admission' && $__login_type != 'accountant'): ?>
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?php echo $page_title;?></h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                        <ol class="breadcrumb">
                            <li><a href=""><?php echo $system_name;?></a></li>
                            <li class="active"><?php echo date('d M,Y');?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?php endif; ?>