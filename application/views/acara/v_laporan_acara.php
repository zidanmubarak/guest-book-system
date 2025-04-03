<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan Acara
            <small><?php echo isset($acara['nama_acara']) ? $acara['nama_acara'] : 'Pilih Acara'; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('data_acara'); ?>">Data Acara</a></li>
            <li class="active">Laporan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Event Selector -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pilih Acara</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <select id="event-selector" class="form-control" onchange="loadEventReport(this.value)">
                                <option value="">-- Pilih Acara --</option>
                                <!-- Options will be loaded via AJAX -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($acara) && !empty($acara)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Statistik Kehadiran</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3><?php echo $total_peserta; ?></h3>
                                        <p>Total Tamu</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3><?php echo $peserta_hadir; ?></h3>
                                        <p>Tamu Hadir</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3><?php echo $total_peserta - $peserta_hadir; ?></h3>
                                        <p>Belum Hadir</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3><?php echo $total_peserta > 0 ? round(($peserta_hadir / $total_peserta) * 100) : 0; ?>%</h3>
                                        <p>Tingkat Kehadiran</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-pie-chart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Statistik per Kategori</h3>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Kategori</th>
                                                    <th>Jumlah</th>
                                                    <th>Hadir</th>
                                                    <th>Belum Hadir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (is_array($statistik_kategori) && !empty($statistik_kategori)) {
                                                    foreach($statistik_kategori as $kategori_key => $jumlah) {
                                                        $hadir = isset($kategori_hadir[$kategori_key]) ? $kategori_hadir[$kategori_key] : 0;
                                                        $belum_hadir = $jumlah - $hadir;
                                                        $nama_kategori = ucfirst($kategori_key);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $nama_kategori; ?></td>
                                                            <td><?php echo $jumlah; ?></td>
                                                            <td><?php echo $hadir; ?></td>
                                                            <td><?php echo $belum_hadir; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="4" class="text-center">Tidak ada data kategori</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Aksi</h3>
                                    </div>
                                    <div class="box-body">
                                        <a href="<?php echo base_url('data_acara/export_peserta/'.$acara['id']); ?>" class="btn btn-warning">
                                            <i class="fa fa-file-excel-o"></i> Export Excel
                                        </a>
                                        <a href="<?php echo base_url('data_acara/peserta/'.$acara['id']); ?>" class="btn btn-info">
                                            <i class="fa fa-list"></i> Lihat Detail Tamu
                                        </a>
                                        <a href="<?php echo base_url('data_acara/scan_qr'); ?>" class="btn btn-success">
                                            <i class="fa fa-qrcode"></i> Scan QR Code
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Informasi Acara</h3>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="200">Nama Acara</th>
                                                <td><?php echo $acara['nama_acara']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <td><?php echo date('d/m/Y', strtotime($acara['tanggal'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Lokasi</th>
                                                <td><?php echo $acara['lokasi']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Penyelenggara</th>
                                                <td><?php echo $acara['penyelenggara']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kapasitas</th>
                                                <td><?php echo $acara['kapasitas']; ?> orang</td>
                                            </tr>
                                            <tr>
                                                <th>Deskripsi</th>
                                                <td><?php echo $acara['deskripsi']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4><i class="icon fa fa-info"></i> Informasi</h4>
                    Silakan pilih acara untuk melihat laporan kehadiran.
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>

<!-- Load Chart.js library if not already loaded -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded! Please check your page includes.');
        return;
    }
    
    jQuery(function($) {
        // Load event list for dropdown
        $.ajax({
            url: '<?php echo base_url(); ?>data_acara/get_all_acara_list',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#event-selector');
                if (select.length) {
                    select.empty();
                    select.append($('<option></option>').attr('value', '').text('-- Pilih Acara --'));
                    
                    $.each(data, function(index, event) {
                        var date = new Date(event.tanggal);
                        var formattedDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
                        var option = $('<option></option>').attr('value', event.id).text(event.nama_acara + ' (' + formattedDate + ')');
                        
                        if (event.id == '<?php echo isset($acara) ? $acara['id'] : ''; ?>') {
                            option.attr('selected', 'selected');
                        }
                        
                        select.append(option);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading event list:", error);
            }
        });
    });
});

function loadEventReport(eventId) {
    if (eventId) {
        window.location.href = '<?php echo base_url(); ?>data_acara/laporan/' + eventId;
    }
}
</script>