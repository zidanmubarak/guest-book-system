<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Daftar Tamu</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('guests/add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Tamu
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <ul class="nav nav-pills guest-status-filter">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-filter="all">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="waiting">Menunggu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="in-progress">Sedang Berlangsung</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="completed">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="canceled">Dibatalkan</a>
                </li>
            </ul>
        </div>

        <?php if (empty($guests)): ?>
            <div class="text-center py-5">
                <img src="<?= base_url('assets/images/empty.svg'); ?>" alt="No Data" class="img-fluid mb-3" style="max-height: 150px;">
                <h4>Belum ada data tamu</h4>
                <p class="text-muted">Tambahkan tamu baru untuk melihat data di sini</p>
                <a href="<?= site_url('guests/add'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Tamu
                </a>
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
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($guests as $guest): ?>
                            <tr class="guest-row" data-status="<?= $guest->status; ?>">
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
                                <td>
                                    <?= date('d/m/Y', strtotime($guest->check_in)); ?><br>
                                    <small class="text-muted"><?= date('H:i', strtotime($guest->check_in)); ?></small>
                                </td>
                                <td>
                                    <?php if (!empty($guest->check_out)): ?>
                                        <?= date('d/m/Y', strtotime($guest->check_out)); ?><br>
                                        <small class="text-muted"><?= date('H:i', strtotime($guest->check_out)); ?></small>
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
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= site_url('guests/view/' . $guest->id); ?>" class="btn btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= site_url('guests/edit/' . $guest->id); ?>" class="btn btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($guest->status != 'completed'): ?>
                                            <a href="<?= site_url('guests/checkout/' . $guest->id); ?>" class="btn btn-success" onclick="return confirm('Checkout tamu ini?')" title="Checkout">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= site_url('guests/delete/' . $guest->id); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Guest status filter
        const filterLinks = document.querySelectorAll('.guest-status-filter .nav-link');
        const guestRows = document.querySelectorAll('.guest-row');
        
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                filterLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                // Show/hide rows based on filter
                guestRows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else {
                        const status = row.getAttribute('data-status');
                        row.style.display = (status === filter) ? '' : 'none';
                    }
                });
            });
        });
    });
</script>