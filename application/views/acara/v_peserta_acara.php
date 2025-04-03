<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Daftar Tamu Acara
            <small><?php echo $acara['nama_acara']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().'data_acara'; ?>">Acara</a></li>
            <li class="active">Tamu</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="box-title">Informasi Acara</h3>
                                <br>
                                <br>
                                <!-- Added bg-primary class for blue background and white text -->
                                <table class="table table-bordered bg-dark">
                                    <tr>
                                        <th width: 30%;">Nama Acara</th>
                                        <td><?php echo $acara['nama_acara']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td><?php echo date('d/m/Y H:i', strtotime($acara['tanggal'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td><?php echo $acara['lokasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kapasitas</th>
                                        <td><?php echo $acara['kapasitas']; ?> orang</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center" style="margin-top: 20px;">
                                    <?php if(!empty($acara['poster'])): ?>
                                        <!-- Set a fixed height and width with responsive styling -->
                                        <img src="<?php echo base_url().'assets/images/poster_acara/'.$acara['poster']; ?>" 
                                             class="img-responsive center-block" 
                                             style="max-height: 250px; max-width: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <img src="<?php echo base_url().'assets/images/no-image.jpg'; ?>" 
                                             class="img-responsive center-block" 
                                             style="max-height: 250px; max-width: 100%;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-6">
                                <a class="btn btn-success" href="<?php echo base_url().'data_acara/add_peserta/'.$acara['id']; ?>">
                                    <span class="fa fa-plus"></span> Tambah Tamu Baru
                                </a>
                                <a class="btn btn-warning" href="<?php echo base_url().'data_acara/scan_qr'; ?>">
                                    <span class="fa fa-qrcode"></span> Scan QR Code
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="search-box" class="form-control" placeholder="Cari peserta...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tabel-peserta">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Institusi</th>
                                        <th>Kategori</th>
                                        <th>Kode Undangan</th>
                                        <th>Status</th>
                                        <th style="text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=0;
                                    foreach ($peserta as $p): 
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td>
                                            <?php if(!empty($p['foto'])): ?>
                                                <img src="<?php echo base_url().'assets/images/foto_peserta/'.$p['foto']; ?>" style="width:50px;">
                                            <?php else: ?>
                                                <img src="<?php echo base_url().'assets/images/user_blank.png'; ?>" style="width:50px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $p['nama']; ?></td>
                                        <td><?php echo $p['email']; ?></td>
                                        <td><?php echo $p['no_hp']; ?></td>
                                        <td><?php echo $p['institusi']; ?></td>
                                        <td>
                                            <?php 
                                            switch($p['kategori']) {
                                                case 'umum':
                                                    echo '<span class="label label-default">Umum</span>';
                                                    break;
                                                case 'vip':
                                                    echo '<span class="label label-primary">VIP</span>';
                                                    break;
                                                case 'pembicara':
                                                    echo '<span class="label label-success">Pembicara</span>';
                                                    break;
                                                case 'panitia':
                                                    echo '<span class="label label-info">Panitia</span>';
                                                    break;
                                                case 'media':
                                                    echo '<span class="label label-warning">Media</span>';
                                                    break;
                                                case 'sponsor':
                                                    echo '<span class="label label-danger">Sponsor</span>';
                                                    break;
                                                default:
                                                    echo $p['kategori'];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="qr-code" data-qr="<?php echo $p['kode_undangan']; ?>">
                                                <?php echo $p['kode_undangan']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($p['status_hadir'] == 1): ?>
                                                <span class="label label-success">Hadir</span>
                                                <br>
                                                <small><?php echo date('d/m/Y H:i', strtotime($p['waktu_checkin'])); ?></small>
                                            <?php else: ?>
                                                <span class="label label-danger">Belum Hadir</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Fixed action buttons -->
                                        <td style="text-align:center;">
                                            <div class="btn-group">
                                                <a href="<?php echo base_url().'data_acara/cetak_id_card/'.$p['id']; ?>" target="_blank" class="btn btn-xs btn-info">
                                                    <i class="fa fa-id-card"></i> ID Card
                                                </a>
                                                <?php if($p['status_hadir'] == 0): ?>
                                                <a href="javascript:void(0);" class="btn btn-xs btn-success check-in" data-kode="<?php echo $p['kode_undangan']; ?>">
                                                    <i class="fa fa-check"></i> Check In
                                                </a>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="btn btn-xs btn-danger hapus-peserta" data-id="<?php echo $p['id']; ?>" data-nama="<?php echo $p['nama']; ?>">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="<?php echo base_url().'data_acara/export_peserta/'.$acara['id']; ?>" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i> Export ke Excel
                        </a>
                        <a href="<?php echo base_url().'data_acara/laporan/'.$acara['id']; ?>" class="btn btn-info">
                            <i class="fa fa-bar-chart"></i> Lihat Laporan
                        </a>
                        <a href="<?php echo base_url().'data_acara'; ?>" class="btn btn-default pull-right">
                            <i class="fa fa-reply"></i> Kembali
                        </a>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Hapus -->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Tamu</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus tamu ini?</p></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger btn-flat" id="btn_hapus">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fixed jQuery script for event participant page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded! Please check your page includes.');
        return;
    }
    
    jQuery(function($){
        // Generate QR Code untuk setiap kode undangan
        if ($.fn.qrcode) {
            $('.qr-code').each(function(){
                var qrCode = $(this).data('qr');
                $(this).qrcode({
                    text: qrCode,
                    width: 64,
                    height: 64
                });
            });
        } else {
            console.error('QR Code plugin not loaded');
        }
        
        // DataTable untuk fitur pencarian dan pengurutan
        if ($.fn.DataTable) {
            $('#tabel-peserta').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        } else {
            // Handle search manually if DataTable is not available
            $("#search-box").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tabel-peserta tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        }
        
        // Check-in manual
        $('.check-in').on('click', function(e){
            e.preventDefault();
            var kode = $(this).data('kode');
            
            $.ajax({
                url: '<?php echo base_url(); ?>data_acara/check_in',
                type: 'POST',
                data: {kode_undangan: kode},
                dataType: 'json',
                success: function(response){
                    if(response.status === 'success'){
                        alert('Check-in berhasil!');
                        location.reload();
                    } else {
                        alert('Check-in gagal: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert('Terjadi kesalahan saat melakukan check-in. Silakan coba lagi.');
                }
            });
        });
        
        // Tombol hapus peserta
        $('.hapus-peserta').on('click', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            
            $('#textkode').val(id);
            $('.alert-warning p').html('Apakah Anda yakin ingin menghapus tamu <strong>' + nama + '</strong>?');
            $('#ModalHapus').modal('show');
        });
        
        // Aksi hapus peserta
        $('#btn_hapus').on('click', function(){
            var id = $('#textkode').val();
            
            $.ajax({
                url: '<?php echo base_url(); ?>data_acara/hapus_peserta',
                type: 'POST',
                data: {id: id},
                success: function(response){
                    $('#ModalHapus').modal('hide');
                    if(response === 'success'){
                        alert('Tamu berhasil dihapus');
                        location.reload();
                    } else {
                        alert('Gagal menghapus tamu');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert('Terjadi kesalahan saat menghapus tamu. Silakan coba lagi.');
                }
            });
        });
        
        console.log("Participant page initialized");
    });
});
</script>