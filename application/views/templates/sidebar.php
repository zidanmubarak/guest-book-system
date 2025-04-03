<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <a href="<?= site_url('dashboard'); ?>">
                <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo" class="img-fluid logo-img">
                <span class="logo-text"><?= $this->setting_model->get_setting('site_name', 'Sistem Buku Tamu'); ?></span>
            </a>
        </div>
    </div>
    
    <div class="sidebar-content">
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' && !$this->uri->segment(2) ? 'active' : ''; ?>" href="<?= site_url('dashboard'); ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'stats' ? 'active' : ''; ?>" href="<?= site_url('dashboard/stats'); ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Statistik</span>
                    </a>
                </li>

                <li class="nav-header">MANAJEMEN TAMU</li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'guests' && !$this->uri->segment(2) ? 'active' : ''; ?>" href="<?= site_url('guests'); ?>">
                        <i class="fas fa-users"></i>
                        <span>Daftar Tamu</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'guests' && $this->uri->segment(2) == 'add' ? 'active' : ''; ?>" href="<?= site_url('guests/add'); ?>">
                        <i class="fas fa-user-plus"></i>
                        <span>Tambah Tamu</span>
                    </a>
                </li>

                <li class="nav-header">LAPORAN</li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'reports' && $this->uri->segment(2) == 'daily' ? 'active' : ''; ?>" href="<?= site_url('reports/daily'); ?>">
                        <i class="fas fa-calendar-day"></i>
                        <span>Laporan Harian</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'reports' && $this->uri->segment(2) == 'monthly' ? 'active' : ''; ?>" href="<?= site_url('reports/monthly'); ?>">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Laporan Bulanan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'reports' && $this->uri->segment(2) == 'export' ? 'active' : ''; ?>" href="<?= site_url('reports/export'); ?>">
                        <i class="fas fa-file-export"></i>
                        <span>Ekspor Data</span>
                    </a>
                </li>
                
                <?php if ($this->session->userdata('role') === 'admin'): ?>
                <li class="nav-header">PENGATURAN</li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'settings' && $this->uri->segment(2) == 'profile' ? 'active' : ''; ?>" href="<?= site_url('settings/profile'); ?>">
                        <i class="fas fa-user-cog"></i>
                        <span>Profil</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'settings' && $this->uri->segment(2) == 'appearance' ? 'active' : ''; ?>" href="<?= site_url('settings/appearance'); ?>">
                        <i class="fas fa-palette"></i>
                        <span>Tampilan</span>
                    </a>
                </li>
                <?php endif; ?>
                
                <li class="nav-item mt-4">
                    <a class="nav-link" href="<?= site_url('logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>