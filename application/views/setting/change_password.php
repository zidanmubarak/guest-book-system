<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Ubah Password</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('settings/profile'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-icon mb-3">
                        <i class="fas fa-key fa-3x text-primary"></i>
                    </div>
                    <h4>Ubah Password</h4>
                    <p class="text-muted">Untuk keamanan, gunakan password yang kuat dan jangan bagikan dengan orang lain.</p>
                </div>
                
                <?= form_open('settings/change_password', ['class' => 'needs-validation']); ?>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?= form_error('current_password') ? 'is-invalid' : ''; ?>" id="current_password" name="current_password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?= form_error('current_password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?= form_error('new_password') ? 'is-invalid' : ''; ?>" id="new_password" name="new_password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?= form_error('new_password', '<div class="invalid-feedback">', '</div>'); ?>
                        <div class="password-strength mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?= form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    
                    <div class="mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Ketentuan Password</h6>
                                <ul class="password-requirements mb-0">
                                    <li id="length-requirement">Minimal 6 karakter</li>
                                    <li id="uppercase-requirement">Mengandung huruf kapital</li>
                                    <li id="lowercase-requirement">Mengandung huruf kecil</li>
                                    <li id="number-requirement">Mengandung angka</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <i class="fas fa-save me-1"></i> Simpan Password Baru
                        </button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<style>
    .display-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(78, 115, 223, 0.1);
        border-radius: 50%;
    }
    
    .password-strength {
        height: 5px;
        background-color: #eee;
        border-radius: 5px;
        margin-top: 5px;
    }
    
    .password-strength::before {
        content: '';
        display: block;
        height: 100%;
        width: 0;
        border-radius: 5px;
        transition: width 0.3s;
    }
    
    .password-strength.weak::before {
        width: 25%;
        background-color: #dc3545;
    }
    
    .password-strength.medium::before {
        width: 50%;
        background-color: #ffc107;
    }
    
    .password-strength.strong::before {
        width: 75%;
        background-color: #28a745;
    }
    
    .password-strength.very-strong::before {
        width: 100%;
        background-color: #20c997;
    }
    
    .password-requirements li {
        margin-bottom: 5px;
        color: var(--text-muted);
    }
    
    .password-requirements li.valid {
        color: var(--success-color);
    }
    
    .password-requirements li.valid::before {
        content: '✓ ';
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength meter
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        const strengthMeter = document.querySelector('.password-strength');
        const lengthReq = document.getElementById('length-requirement');
        const uppercaseReq = document.getElementById('uppercase-requirement');
        const lowercaseReq = document.getElementById('lowercase-requirement');
        const numberReq = document.getElementById('number-requirement');
        const submitBtn = document.getElementById('submit-btn');
        
        newPassword.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            
            // Reset requirements
            lengthReq.classList.remove('valid');
            uppercaseReq.classList.remove('valid');
            lowercaseReq.classList.remove('valid');
            numberReq.classList.remove('valid');
            
            // Check length
            if (value.length >= 6) {
                strength += 1;
                lengthReq.classList.add('valid');
            }
            
            // Check uppercase
            if (/[A-Z]/.test(value)) {
                strength += 1;
                uppercaseReq.classList.add('valid');
            }
            
            // Check lowercase
            if (/[a-z]/.test(value)) {
                strength += 1;
                lowercaseReq.classList.add('valid');
            }
            
            // Check numbers
            if (/[0-9]/.test(value)) {
                strength += 1;
                numberReq.classList.add('valid');
            }
            
            // Update strength meter
            strengthMeter.className = 'password-strength';
            
            if (strength === 0) {
                strengthMeter.className = 'password-strength';
            } else if (strength === 1) {
                strengthMeter.className = 'password-strength weak';
            } else if (strength === 2) {
                strengthMeter.className = 'password-strength medium';
            } else if (strength === 3) {
                strengthMeter.className = 'password-strength strong';
            } else {
                strengthMeter.className = 'password-strength very-strong';
            }
            
            // Check if confirm password matches
            checkPasswordMatch();
        });
        
        confirmPassword.addEventListener('input', function() {
            checkPasswordMatch();
        });
        
        function checkPasswordMatch() {
            if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Password tidak cocok');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }
    });
</script>