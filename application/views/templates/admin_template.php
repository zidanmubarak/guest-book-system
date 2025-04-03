<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?> - <?= $this->setting_model->get_setting('site_name', 'Sistem Buku Tamu'); ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico'); ?>" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css'); ?>" rel="stylesheet">
    
    <!-- DataTables -->
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/datatables/buttons.bootstrap5.min.css'); ?>" rel="stylesheet">
    
    <!-- Select2 -->
    <link href="<?= base_url('assets/vendor/select2/css/select2.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css'); ?>" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
    
    <!-- Set tema berdasarkan preferensi user -->
    <?php 
    $theme = $this->session->userdata('theme') ?: 'light';
    if ($theme === 'dark'): 
    ?>
        <link href="<?= base_url('assets/css/dark-mode.css'); ?>" rel="stylesheet" id="dark-mode-css">
    <?php endif; ?>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <?php $this->load->view('templates/sidebar'); ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <?php $this->load->view('templates/header'); ?>
            
            <!-- Content -->
            <div class="content-area">
                <div class="container-fluid py-3">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php $this->load->view($content, isset($data) ? $data : []); ?>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="app-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p>&copy; <?= date('Y'); ?> <?= $this->setting_model->get_setting('company_name', 'PT Example Indonesia'); ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p>Versi 1.0.0</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap & jQuery Scripts -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- DataTables -->
    <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/buttons.bootstrap5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/jszip.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/pdfmake.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/vfs_fonts.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/buttons.html5.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/buttons.print.min.js'); ?>"></script>
    
    <!-- Chart.js -->
    <script src="<?= base_url('assets/vendor/chart.js/chart.min.js'); ?>"></script>
    
    <!-- Select2 -->
    <script src="<?= base_url('assets/vendor/select2/js/select2.min.js'); ?>"></script>
    
    <!-- Theme Switcher Script -->
    <script src="<?= base_url('assets/js/theme-switcher.js'); ?>"></script>
    
    <!-- Custom Script -->
    <script src="<?= base_url('assets/js/script.js'); ?>"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Initialize DataTables
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: '<?= base_url("assets/vendor/datatables/indonesian.json"); ?>'
                }
            });
            
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            
            // Toggle sidebar on mobile
            $('#sidebarToggle').on('click', function() {
                $('.app-container').toggleClass('sidebar-collapsed');
            });
        });
    </script>
</body>
</html>