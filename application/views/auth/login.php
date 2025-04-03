<div class="card">
    <div class="card-body">
        <h4 class="text-center mb-4">Login</h4>
        
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        
        <?= form_open('login', ['class' => 'needs-validation']); ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username'); ?>" required autofocus>
                </div>
                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>