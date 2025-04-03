<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Laporan Harian</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('reports/monthly'); ?>" class="btn btn-primary">
            <i class="fas fa-calendar-alt me-1"></i> Laporan Bulanan
        </a>
        <a href="<?= site_url('reports/export'); ?>" class="btn btn-success">
            <i class="fas fa-file-export me-1"></i> Ekspor Data
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?= site_url('reports/daily'); ?>" method="get" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="date" class="form-label">Pilih Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?= $date; ?>" max="<?= date('Y-m-d'); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Tampilkan
                    </button>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mt-3 mt-md-0">
                        <a href="<?= site_url('reports/daily?date=' . date('Y-m-d', strtotime('-1 day', strtotime($date)))); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-chevron-left"></i> Hari Sebelumnya
                        </a>
                        <a href="<?= site_url('reports/daily?date=' . date('Y-m-d')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-calendar-day"></i> Hari Ini
                        </a>
                        <?php if (strtotime($date) < strtotime(date('Y-m-d'))): ?>
                            <a href="<?= site_url('reports/daily?date=' . date('Y-m-d', strtotime('+1 day', strtotime($date)))); ?>" class="btn btn-outline-secondary">
                                Hari Berikutnya <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>

        <div class="date-info text-center mb-4">
            <h3><?= date('d F Y', strtotime($date)); ?></h3>
            <?php if ($date == date('Y-m-d')): ?>
                <span class="badge bg-primary">Hari Ini</span>
            <?php endif; ?>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-primary text-white rounded-circle">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Tamu</h5>
                                <span class="h2 font-weight-bold mb-0"><?= $total; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-success text-white rounded-circle">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-uppercase text-muted mb-0">Selesai</h5>
                                <span class="h2 font-weight-bold mb-0"><?= $completed; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-info text-white rounded-circle">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-uppercase text-muted mb-0">Dalam Proses</h5>
                                <span class="h2 font-weight-bold mb-0"><?= $in_progress + $waiting; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-gradient-danger text-white rounded-circle">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-uppercase text-muted mb-0">Dibatalkan</h5>
                                <span class="h2 font-weight-bold mb-0"><?= $canceled; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($guests)): ?>
            <div class="text-center py-5">
                <img src="<?= base_url('assets/images/empty.svg'); ?>" alt="No Data" class="img-fluid mb-3" style="max-height: 150px;">
                <h4>Tidak ada data tamu</h4>
                <p class="text-muted">Tidak ada kunjungan tamu pada tanggal ini</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Institusi</th>
                            <th>Tujuan</th>
                            <th>Bertemu Dengan</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($guests as $guest): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($guest->photo) && file_exists('./uploads/guests/' . $guest->photo)): ?>
                                            <div class="avatar me-2">
                                                <img src="<?= base_url('uploads/guests/' . $guest->photo); ?>" alt="<?= $guest->name; ?>" class="avatar-img rounded-circle">
                                            </div>
                                        <?php else: ?>
                                            <div class="avatar me-2">
                                                <span class="avatar-text rounded-circle"><?= substr($guest->name, 0, 1); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h6 class="mb-0"><?= $guest->name; ?></h6>
                                            <?php if (!empty($guest->phone)): ?>
                                                <small class="text-muted"><?= $guest->phone; ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?= $guest->institution ?: '-'; ?></td>
                                <td><?= $guest->purpose; ?></td>
                                <td><?= $guest->person_to_meet ?: '-'; ?></td>
                                <td><?= date('H:i', strtotime($guest->check_in)); ?></td>
                                <td>
                                    <?php if (!empty($guest->check_out)): ?>
                                        <?= date('H:i', strtotime($guest->check_out)); ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($guest->check_out)): ?>
                                        <?php
                                            $check_in = new DateTime($guest->check_in);
                                            $check_out = new DateTime($guest->check_out);
                                            $diff = $check_in->diff($check_out);
                                            
                                            $hours = $diff->h;
                                            $hours = $hours + ($diff->days * 24);
                                            $minutes = $diff->i;
                                            
                                            echo $hours . ' jam ' . $minutes . ' menit';
                                        ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
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
                                    <a href="<?= site_url('guests/view/' . $guest->id); ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="<?= site_url('reports/export?start_date=' . $date . '&end_date=' . $date); ?>" class="btn btn-success">
                    <i class="fas fa-file-export me-1"></i> Ekspor Data Harian
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>