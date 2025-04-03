<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Event Attendance System</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">TOTAL ACARA</span>
            <span class="info-box-number"><?php echo isset($total_events) ? $total_events : 0; ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">TOTAL TAMU</span>
            <span class="info-box-number"><?php echo isset($total_participants) ? $total_participants : 0; ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">CHECK-IN HARI INI</span>
            <span class="info-box-number"><?php echo isset($today_checkins) ? $today_checkins : 0; ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">ACARA MENDATANG</span>
            <span class="info-box-number"><?php echo isset($upcoming_events) ? $upcoming_events : 0; ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Upcoming Events and Recent Check-ins -->
    <div class="row">
      <div class="col-md-8">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Acara Mendatang</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>Nama Acara</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Terdaftar</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($events) && !empty($events)): ?>
                    <?php foreach($events as $event): ?>
                    <tr>
                      <td><a href="<?php echo base_url('data_acara/peserta/'.$event['id']); ?>"><?php echo $event['nama_acara']; ?></a></td>
                      <td><?php echo date('d M Y H:i', strtotime($event['tanggal'])); ?></td>
                      <td><?php echo $event['lokasi']; ?></td>
                      <td><?php echo isset($event['registered']) ? $event['registered'] : 0; ?>/<?php echo $event['kapasitas']; ?></td>
                      <td>
                        <?php if(strtotime($event['tanggal']) > time()): ?>
                          <span class="label label-success">Akan Datang</span>
                        <?php else: ?>
                          <span class="label label-default">Selesai</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center">Tidak ada acara mendatang</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="<?php echo base_url('data_acara/add_acara'); ?>" class="btn btn-sm btn-primary pull-left">Buat Acara Baru</a>
            <a href="<?php echo base_url('data_acara'); ?>" class="btn btn-sm btn-default pull-right">Lihat Semua Acara</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->

      <div class="col-md-4">
        <!-- Recent Check-ins -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Check-in Terbaru</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Acara</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($recent_checkins) && !empty($recent_checkins)): ?>
                    <?php foreach($recent_checkins as $checkin): ?>
                    <tr>
                      <td><?php echo $checkin['nama']; ?></td>
                      <td><?php echo $checkin['nama_acara']; ?></td>
                      <td><?php echo date('H:i', strtotime($checkin['waktu_checkin'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center">Tidak ada check-in terbaru</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="<?php echo base_url('data_acara/scan_qr'); ?>" class="btn btn-sm btn-success pull-right">Check-in Tamu</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->

        <!-- Quick Links Box -->
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Aksi Cepat</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body text-center">
            <div class="row">
              <div class="col-xs-4 col-md-4" style="margin-bottom: 15px;">
                <a href="<?php echo base_url('data_acara/add_acara'); ?>" class="btn btn-app">
                  <i class="fa fa-calendar-plus-o"></i> Acara Baru
                </a>
              </div>
              <div class="col-xs-4 col-md-4" style="margin-bottom: 15px;">
                <a href="<?php echo base_url('data_acara/scan_qr'); ?>" class="btn btn-app">
                  <i class="fa fa-qrcode"></i> Scan QR
                </a>
              </div>
              <div class="col-xs-4 col-md-4" style="margin-bottom: 15px;">
                <a href="<?php echo base_url('data_acara'); ?>" class="btn btn-app">
                  <i class="fa fa-list"></i> Daftar Acara
                </a>
              </div>
              <div class="col-xs-4 col-md-4" style="margin-bottom: 15px;">
                <a href="<?php echo base_url('data_acara/laporan'); ?>" class="btn btn-app">
                  <i class="fa fa-bar-chart"></i> Laporan
                </a>
              </div>
              <div class="col-xs-4 col-md-4" style="margin-bottom: 15px;">
                <a href="<?php echo base_url('data_buku_tamu'); ?>" class="btn btn-app">
                  <i class="fa fa-users"></i> Data Tamu
                </a>
              </div>
              <div class="col-xs-4 col-md-4" style="margin-bottom: 15px;">
                <a href="<?php echo base_url('pegawai'); ?>" class="btn btn-app">
                  <i class="fa fa-user"></i> Pegawai
                </a>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
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

<style>
  /* Custom styles for light theme */
  .btn-app {
    min-width: 80px;
    height: 80px;
    margin: 0 auto;
    padding-top: 20px;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  
  .btn-app:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  
  .info-box {
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }
  
  .info-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
  }
  
  .info-box-number {
    font-size: 24px;
    font-weight: 600;
  }
  
  .box {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  
  .label-success {
    background-color: #28a745;
  }
  
  .bg-aqua {
    background-color: #00c0ef !important;
  }
</style>