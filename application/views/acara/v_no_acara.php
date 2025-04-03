<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan Kehadiran
            <small>Tidak Ada Acara</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().'data_acara'; ?>">Acara</a></li>
            <li class="active">Laporan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="alert alert-warning">
            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
            <p>Belum ada acara yang tersedia. Silakan membuat acara baru terlebih dahulu.</p>
        </div>
        
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Tindakan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo base_url('data_acara/add_acara'); ?>" class="btn btn-success btn-block btn-flat">
                            <i class="fa fa-plus"></i> Buat Acara Baru
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo base_url('data_acara'); ?>" class="btn btn-primary btn-block btn-flat">
                            <i class="fa fa-list"></i> Daftar Acara
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->