<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="card-title">Pengaturan Tampilan</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="<?= site_url('settings/profile'); ?>" class="btn btn-secondary">
            <i class="fas fa-user-cog me-1"></i> Profil
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-icon mb-3">
                        <i class="fas fa-palette fa-4x text-primary"></i>
                    </div>
                    <h4>Preferensi Tema</h4>
                    <p class="text-muted">Pilih tema yang sesuai dengan preferensi Anda</p>
                </div>
                
                <?= form_open('settings/appearance', ['class' => 'needs-validation']); ?>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card theme-card <?= $current_theme == 'light' ? 'active' : ''; ?>">
                                <div class="card-body text-center">
                                    <div class="theme-preview light-theme mb-3">
                                        <div class="theme-preview-header"></div>
                                        <div class="theme-preview-sidebar"></div>
                                        <div class="theme-preview-content"></div>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="theme" id="themeLight" value="light" <?= $current_theme == 'light' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="themeLight">
                                            Light Mode
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card theme-card <?= $current_theme == 'dark' ? 'active' : ''; ?>">
                                <div class="card-body text-center">
                                    <div class="theme-preview dark-theme mb-3">
                                        <div class="theme-preview-header"></div>
                                        <div class="theme-preview-sidebar"></div>
                                        <div class="theme-preview-content"></div>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="theme" id="themeDark" value="dark" <?= $current_theme == 'dark' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="themeDark">
                                            Dark Mode
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="theme-benefits">
                                <div class="card">
                                    <div class="card-body">
                                        <h5><i class="fas fa-lightbulb"></i> Manfaat Light Mode</h5>
                                        <ul>
                                            <li>Lebih baik untuk ruangan terang</li>
                                            <li>Kontras tinggi, lebih mudah dibaca</li>
                                            <li>Tampilan lebih familiar dan standar</li>
                                        </ul>
                                        
                                        <h5 class="mt-3"><i class="fas fa-moon"></i> Manfaat Dark Mode</h5>
                                        <ul>
                                            <li>Mengurangi kelelahan mata di ruangan gelap</li>
                                            <li>Hemat daya baterai pada perangkat OLED</li>
                                            <li>Tampilan lebih modern dan elegan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Preferensi
                        </button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<style>
    .theme-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .theme-card:hover {
        transform: translateY(-5px);
    }
    
    .theme-card.active {
        border-color: var(--primary-color);
    }
    
    .theme-preview {
        width: 100%;
        height: 150px;
        border-radius: 5px;
        overflow: hidden;
        position: relative;
    }
    
    .theme-preview-header {
        height: 20%;
        width: 100%;
    }
    
    .theme-preview-sidebar {
        position: absolute;
        top: 20%;
        left: 0;
        width: 25%;
        height: 80%;
    }
    
    .theme-preview-content {
        position: absolute;
        top: 20%;
        left: 25%;
        width: 75%;
        height: 80%;
    }
    
    /* Light Theme Preview */
    .light-theme .theme-preview-header {
        background-color: #fff;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .light-theme .theme-preview-sidebar {
        background-color: #4e73df;
    }
    
    .light-theme .theme-preview-content {
        background-color: #f8f9fc;
    }
    
    /* Dark Theme Preview */
    .dark-theme .theme-preview-header {
        background-color: #282d3f;
        border-bottom: 1px solid #3d4255;
    }
    
    .dark-theme .theme-preview-sidebar {
        background-color: #3a3f51;
    }
    
    .dark-theme .theme-preview-content {
        background-color: #1a1d29;
    }
    
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Theme card selection
        const themeCards = document.querySelectorAll('.theme-card');
        const themeRadios = document.querySelectorAll('input[name="theme"]');
        
        themeCards.forEach(card => {
            card.addEventListener('click', function() {
                // Find the radio inside this card
                const radio = this.querySelector('input[type="radio"]');
                
                // Check the radio
                radio.checked = true;
                
                // Update active class
                themeCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>