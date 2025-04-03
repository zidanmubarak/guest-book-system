<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Detail Tamu</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('guests'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="<?= site_url('guests/edit/' . $guest->id); ?>" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <?php if ($guest->status != 'completed'): ?>
            <a href="<?= site_url('guests/checkout/' . $guest->id); ?>" class="btn btn-success" onclick="return confirm('Checkout tamu ini?')">
                <i class="fas fa-sign-out-alt me-1"></i> Checkout
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <?php if (!empty($guest->photo) && file_exists('./uploads/guests/' . $guest->photo)): ?>
                    <img src="<?= base_url('uploads/guests/' . $guest->photo); ?>" alt="<?= $guest->name; ?>" class="img-fluid rounded mb-3" style="max-height: 250px;">
                <?php else: ?>
                    <div class="guest-avatar mb-3">
                        <span><?= substr($guest->name, 0, 1); ?></span>
                    </div>
                <?php endif; ?>
                
                <h4><?= $guest->name; ?></h4>
                <p class="text-muted"><?= $guest->institution ?: '-'; ?></p>
                
                <div class="guest-status-badge mt-3">
                    <?php if ($guest->status == 'waiting'): ?>
                        <span class="badge bg-info px-3 py-2">Menunggu</span>
                    <?php elseif ($guest->status == 'in-progress'): ?>
                        <span class="badge bg-primary px-3 py-2">Sedang Berlangsung</span>
                    <?php elseif ($guest->status == 'completed'): ?>
                        <span class="badge bg-success px-3 py-2">Selesai</span>
                    <?php elseif ($guest->status == 'canceled'): ?>
                        <span class="badge bg-danger px-3 py-2">Dibatalkan</span>
                    <?php endif; ?>
                </div>
                
                <div class="guest-contact-info mt-4">
                    <?php if (!empty($guest->phone)): ?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box me-2">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span><?= $guest->phone; ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($guest->email)): ?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box me-2">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span><?= $guest->email; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kunjungan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Tujuan Kunjungan</h6>
                            <p class="mb-0"><?= $guest->purpose; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Bertemu Dengan</h6>
                            <p class="mb-0"><?= $guest->person_to_meet ?: 'Tidak ditentukan'; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Waktu Check In</h6>
                            <p class="mb-0">
                                <?= date('d/m/Y H:i', strtotime($guest->check_in)); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Waktu Check Out</h6>
                            <p class="mb-0">
                                <?php if (!empty($guest->check_out)): ?>
                                    <?= date('d/m/Y H:i', strtotime($guest->check_out)); ?>
                                <?php else: ?>
                                    Belum checkout
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($guest->notes)): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Catatan</h6>
                                <p class="mb-0"><?= nl2br($guest->notes); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Timeline</h5>
                <small class="text-muted">Waktu Server: <?= date('d/m/Y H:i:s'); ?></small>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Check In</h6>
                            <p class="text-muted mb-0"><?= date('d/m/Y H:i', strtotime($guest->check_in)); ?></p>
                        </div>
                    </div>
                    
                    <?php if ($guest->status == 'in-progress'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Sedang Berlangsung</h6>
                                <p class="text-muted mb-0">Bertemu dengan <?= $guest->person_to_meet ?: 'staff'; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($guest->check_out)): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Check Out</h6>
                                <p class="text-muted mb-0"><?= date('d/m/Y H:i', strtotime($guest->check_out)); ?></p>
                            </div>
                        </div>
                    <?php elseif ($guest->status == 'canceled'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Dibatalkan</h6>
                                <p class="text-muted mb-0">Kunjungan dibatalkan</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-secondary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Belum Check Out</h6>
                                <p class="text-muted mb-0">Menunggu pengunjung selesai</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>