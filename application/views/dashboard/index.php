<div class="row">
    <div class="col-md-12 mb-4">
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Selamat Datang, <?= $this->session->userdata('name'); ?>!</h2>
                    <p>Selamat datang di Sistem Informasi Manajemen Buku Tamu. Pantau kunjungan tamu dan kelola data dengan mudah.</p>
                </div>
                <div class="col-md-4 text-end">
                    <img src="<?= base_url('assets/images/welcome.svg'); ?>" alt="Welcome" class="img-fluid welcome-img" style="max-height: 150px;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="icon-shape bg-gradient-primary text-white rounded-circle shadow">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Tamu</h5>
                        <span class="h2 font-weight-bold mb-0"><?= $total_guests; ?></span>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="<?= site_url('guests'); ?>" class="text-nowrap">
                        Lihat semua tamu <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Menunggu</h5>
                        <span class="h2 font-weight-bold mb-0"><?= $stats['waiting']; ?></span>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap">
                        <?= $percentages['waiting']; ?>% dari total tamu
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="icon-shape bg-gradient-success text-white rounded-circle shadow">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Sedang Berlangsung</h5>
                        <span class="h2 font-weight-bold mb-0"><?= $stats['in-progress']; ?></span>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap">
                        <?= $percentages['in-progress']; ?>% dari total tamu
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="icon-shape bg-gradient-warning text-white rounded-circle shadow">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Selesai</h5>
                        <span class="h2 font-weight-bold mb-0"><?= $stats['completed']; ?></span>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap">
                        <?= $percentages['completed']; ?>% dari total tamu
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tamu Hari Ini</h5>
            </div>
            <div class="card-body">
                <?php if (empty($today_guests)): ?>
                    <div class="text-center py-5">
                        <img src="<?= base_url('assets/images/empty.svg'); ?>" alt="No Data" class="img-fluid mb-3" style="max-height: 120px;">
                        <h4>Belum ada tamu hari ini</h4>
                        <p class="text-muted">Tambahkan tamu baru untuk melihat data di sini</p>
                        <a href="<?= site_url('guests/add'); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Tamu
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tujuan</th>
                                    <th>Check In</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($today_guests as $guest): ?>
                                    <tr>
                                        <td><?= $guest->name; ?></td>
                                        <td><?= $guest->purpose; ?></td>
                                        <td><?= date('H:i', strtotime($guest->check_in)); ?></td>
                                        <td>
                                            <?php if ($guest->status == 'waiting'): ?>
                                                <span class="badge bg-info">Menunggu</span>
                                            <?php elseif ($guest->status == 'in-progress'): ?>
                                                <span class="badge bg-primary">Sedang Berlangsung</span>
                                            <?php elseif ($guest->status == 'completed'): ?>
                                                <span class="badge bg-success">Selesai</span>
                                            <?php elseif ($guest->status == 'canceled'): ?>
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('guests/view/' . $guest->id); ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($guest->status != 'completed'): ?>
                                                <a href="<?= site_url('guests/checkout/' . $guest->id); ?>" class="btn btn-sm btn-success" onclick="return confirm('Checkout tamu ini?')">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik Tamu</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
                <hr>
                <div class="d-flex justify-content-center mt-3">
                    <a href="<?= site_url('dashboard/stats'); ?>" class="btn btn-sm btn-primary">
                        Lihat Statistik Lengkap <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Chart
        var statusCtx = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Sedang Berlangsung', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    data: [
                        <?= $stats['waiting']; ?>, 
                        <?= $stats['in-progress']; ?>, 
                        <?= $stats['completed']; ?>, 
                        <?= $stats['canceled']; ?>
                    ],
                    backgroundColor: [
                        '#36a2eb',
                        '#4c75e6',
                        '#4cd964',
                        '#ff3b30'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 12
                    }
                },
                cutoutPercentage: 70,
                tooltips: {
                    enabled: true
                },
                plugins: {
                    datalabels: {
                        display: false
                    }
                }
            }
        });
    });
</script>