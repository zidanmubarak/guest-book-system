<header class="app-header">
    <div class="container-fluid">
        <div class="header-content">
            <div class="left-side">
                <button class="btn sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="page-title mb-0"><?= $data['title']; ?></h4>
            </div>
            
            <div class="right-side">
                <div class="theme-toggle me-3">
                    <button class="btn btn-sm theme-toggle" id="theme-toggle" title="Toggle Light/Dark Mode">
                        <?php if ($this->session->userdata('theme') === 'dark'): ?>
                            <i class="fas fa-sun"></i>
                        <?php else: ?>
                            <i class="fas fa-moon"></i>
                        <?php endif; ?>
                    </button>
                </div>
                
                <div class="dropdown">
                    <button class="btn dropdown-toggle user-dropdown" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="user-name d-none d-md-inline-block"><?= $this->session->userdata('name'); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <span class="dropdown-item-text">
                                <strong><?= $this->session->userdata('name'); ?></strong><br>
                                <small class="text-muted"><?= ucfirst($this->session->userdata('role')); ?></small>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= site_url('settings/profile'); ?>"><i class="fas fa-user-cog me-2"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('settings/appearance'); ?>"><i class="fas fa-palette me-2"></i> Tampilan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= site_url('logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>