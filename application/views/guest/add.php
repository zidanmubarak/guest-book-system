<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Tambah Tamu Baru</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('guests'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?= form_open_multipart('guests/add', ['class' => 'needs-validation']); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= set_value('name'); ?>" required>
                        <?= form_error('name', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="institution" class="form-label">Institusi/Perusahaan</label>
                        <input type="text" class="form-control <?= form_error('institution') ? 'is-invalid' : ''; ?>" id="institution" name="institution" value="<?= set_value('institution'); ?>">
                        <?= form_error('institution', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control <?= form_error('phone') ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?= set_value('phone'); ?>">
                                <?= form_error('phone', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="purpose" class="form-label">Tujuan Kunjungan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= form_error('purpose') ? 'is-invalid' : ''; ?>" id="purpose" name="purpose" value="<?= set_value('purpose'); ?>" required>
                        <?= form_error('purpose', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="person_to_meet" class="form-label">Bertemu Dengan</label>
                        <select class="form-select select2 <?= form_error('person_to_meet') ? 'is-invalid' : ''; ?>" id="person_to_meet" name="person_to_meet">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($departments as $dept): ?>
                                <optgroup label="<?= $dept->name; ?>">
                                    <!-- Dalam aplikasi nyata, ini bisa diisi dengan data staff per departemen -->
                                    <option value="<?= $dept->name; ?> - Staff 1" <?= set_select('person_to_meet', $dept->name . ' - Staff 1'); ?>><?= $dept->name; ?> - Staff 1</option>
                                    <option value="<?= $dept->name; ?> - Staff 2" <?= set_select('person_to_meet', $dept->name . ' - Staff 2'); ?>><?= $dept->name; ?> - Staff 2</option>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('person_to_meet', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg">
                            <label class="input-group-text" for="photo"><i class="fas fa-camera"></i></label>
                        </div>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maks 2MB</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-block">Preview</label>
                        <div class="photo-preview border rounded text-center p-3">
                            <img id="photoPreview" src="<?= base_url('assets/images/person-placeholder.jpg'); ?>" alt="Preview" class="img-fluid" style="max-height: 200px;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control <?= form_error('notes') ? 'is-invalid' : ''; ?>" id="notes" name="notes" rows="3"><?= set_value('notes'); ?></textarea>
                        <?= form_error('notes', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-outline-secondary">
                    <i class="fas fa-refresh me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Photo preview
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photoPreview');
        
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                photoPreview.src = '<?= base_url('assets/images/person-placeholder.jpg'); ?>';
            }
        });
    });
</script>