<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Ekspor Data</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('reports/daily'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('reports/export'); ?>" method="get" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date; ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date; ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Tampilkan Data
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        <?php if (isset($guests) && !empty($guests)): ?>
            <div class="alert alert-info">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-info-circle fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">Informasi Data</h5>
                        <p class="mb-0">Menampilkan data dari <strong><?= date('d/m/Y', strtotime($start_date)); ?></strong> sampai <strong><?= date('d/m/Y', strtotime($end_date)); ?></strong>. Total <strong><?= count($guests); ?></strong> data.</p>
                    </div>
                </div>
            </div>
            
            <div class="mb-4 text-center">
                <a href="<?= site_url('reports/export_pdf?start_date=' . $start_date . '&end_date=' . $end_date); ?>" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Ekspor ke PDF
                </a>
                <a href="<?= site_url('reports/export_excel?start_date=' . $start_date . '&end_date=' . $end_date); ?>" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Ekspor ke Excel
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Institusi</th>
                            <th>Tujuan</th>
                            <th>Bertemu Dengan</th>
                            <th>Durasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($guests as $guest): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?= date('d/m/Y', strtotime($guest->check_in)); ?><br>
                                    <small class="text-muted"><?= date('H:i', strtotime($guest->check_in)); ?> WIB</small>
                                </td>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <img src="<?= base_url('assets/images/empty.svg'); ?>" alt="No Data" class="img-fluid mb-3" style="max-height: 150px;">
                <h4>Tidak ada data untuk ditampilkan</h4>
                <p class="text-muted">Pilih rentang tanggal untuk melihat dan mengekspor data</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi tanggal
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(this.value);
                
                if (endDate < startDate) {
                    alert('Tanggal akhir tidak boleh lebih kecil dari tanggal awal');
                    this.value = startDateInput.value;
                }
            }
        });
        
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && this.value) {
                const startDate = new Date(this.value);
                const endDate = new Date(endDateInput.value);
                
                if (endDate < startDate) {
                    endDateInput.value = this.value;
                }
            }
        });
    });
</script>