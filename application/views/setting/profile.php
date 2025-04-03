<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Pengaturan Profil</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('settings/appearance'); ?>" class="btn btn-primary">
            <i class="fas fa-palette me-1"></i> Tampilan
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-avatar mb-3">
                    <span><?= substr($user->name, 0, 1); ?></span>
                </div>
                
                <h4><?= $user->name; ?></h4>
                <p class="text-muted"><?= ucfirst($user->role); ?></p>
                
                <hr>
                
                <div class="profile-info">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box me-2">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span><?= $user->email; ?></span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box me-2">
                            <i class="fas fa-user"></i>
                        </div>
                        <span><?= $user->username; ?></span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box me-2">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>Login terakhir: <?= $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : 'Belum pernah'; ?></span>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-3">
                    <a href="<?= site_url('settings/change_password'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-key me-1"></i> Ubah Password
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Profil</h5>
            </div>
            <div class="card-body">
                <?= form_open('settings/profile', ['class' => 'needs-validation']); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= set_value('name', $user->name); ?>" required>
                        <?= form_error('name', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= set_value('email', $user->email); ?>" required>
                        <?= form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="<?= $user->username; ?>" readonly>
                        <small class="text-muted">Username tidak dapat diubah</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" value="<?= ucfirst($user->role); ?>" readonly>
                        <small class="text-muted">Role tidak dapat diubah</small>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Login Terakhir</h6>
                            <p class="text-muted mb-0"><?= $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : 'Belum pernah'; ?></p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Akun Dibuat</h6>
                            <p class="text-muted mb-0"><?= date('d/m/Y H:i', strtotime($user->created_at)); ?></p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Update Profil Terakhir</h6>
                            <p class="text-muted mb-0"><?= $user->updated_at ? date('d/m/Y H:i', strtotime($user->updated_at)) : 'Belum pernah diupdate'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 600;
        margin: 0 auto 20px;
    }
    
    .activity-timeline {
        position: relative;
        padding: 0;
        list-style: none;
    }
    
    .activity-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 20px;
        width: 2px;
        background-color: var(--border-color);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 45px;
    }
    
    .timeline-marker {
        position: absolute;
        top: 0;
        left: 15px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        z-index: 10;
    }
    
    .timeline-content {
        padding: 10px 15px;
        background-color: rgba(0, 0, 0, 0.03);
        border-radius: var(--border-radius);
    }
</style>