<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['title']) ? $data['title'] : 'Login - Sistem Buku Tamu'; ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico'); ?>" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css'); ?>" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
    
    <style>
    /* Custom Login Styles - Inline untuk sementara */
    body {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        font-family: 'Nunito', sans-serif;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .auth-container {
        width: 100%;
        padding: 15px;
        max-width: 450px;
    }
    
    .auth-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    .auth-logo {
        margin-top: 2rem;
    }
    
    .logo-img {
        max-height: 80px;
    }
    
    .card {
        border: none;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 5px;
    }
    
    .input-group-text {
        border-radius: 5px;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        padding: 0.75rem 1rem;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    
    .text-muted {
        color: #6c757d;
    }
    </style>
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-logo text-center">
                <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo" class="img-fluid logo-img">
                <h2 class="mt-3">Sistem Informasi Buku Tamu</h2>
            </div>

            <?php $this->load->view($content, isset($data) ? $data : []); ?>
            
            <div class="text-center py-3">
                <p class="text-muted mb-0">
                    &copy; <?= date('Y'); ?> PT. Example Indonesia
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery Scripts -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- Custom Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
    </script>
</body>
</html>