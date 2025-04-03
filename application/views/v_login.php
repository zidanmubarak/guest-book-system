<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Event Attendance System | Login</title>
  <meta name="description" content="Event Attendance System - Aplikasi manajemen kehadiran acara terintegrasi, mudah digunakan, akurat dan aman">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shorcut icon" type="text/css" href="<?php echo base_url().'assets/images/favicon.ico'?>">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css'?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css'?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/AdminLTE.min.css'?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/iCheck/skins/square/_all.css'?>">
  <!-- Google Fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    
    /* Background with animated shapes */
    body:before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background: linear-gradient(120deg, #e0f7fa, #f5f5f5);
      z-index: -1;
    }
    
    .shape {
      position: absolute;
      z-index: -1;
      opacity: 0.5;
    }
    
    .shape-1 {
      background: linear-gradient(45deg, #007bff, #4da3ff);
      width: 300px;
      height: 300px;
      border-radius: 50%;
      top: -150px;
      right: -100px;
      animation: float 8s ease-in-out infinite;
    }
    
    .shape-2 {
      background: linear-gradient(45deg, #ff7eb3, #ff5483);
      width: 200px;
      height: 200px;
      border-radius: 50%;
      bottom: -100px;
      left: -50px;
      animation: float 10s ease-in-out infinite 1s;
    }
    
    .shape-3 {
      background: linear-gradient(45deg, #ffc107, #ffda6a);
      width: 150px;
      height: 150px;
      border-radius: 50%;
      bottom: 50px;
      right: -50px;
      animation: float 7s ease-in-out infinite 0.5s;
    }
    
    @keyframes float {
      0% { transform: translatey(0px); }
      50% { transform: translatey(-20px); }
      100% { transform: translatey(0px); }
    }
    
    .login-box {
      width: 400px;
      margin: 0 auto;
      z-index: 10;
    }
    
    .login-box-body {
      background: #ffffff;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
    }
    
    .login-box-body:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #007bff, #ff7eb3, #007bff);
      background-size: 200% 100%;
      animation: gradient-slide 3s linear infinite;
    }
    
    @keyframes gradient-slide {
      0% { background-position: 100% 0; }
      100% { background-position: -100% 0; }
    }
    
    .login-box-msg {
      color: #333;
      font-weight: 700;
      margin-bottom: 25px;
      font-size: 26px;
      letter-spacing: -0.5px;
    }
    
    .logo-container {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    
    .logo-container img {
      max-width: 120px;
      height: auto;
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
      transition: all 0.3s;
    }
    
    .logo-container img:hover {
      transform: scale(1.05);
    }
    
    .form-group {
      margin-bottom: 20px;
      position: relative;
    }
    
    .form-control {
      background-color: #f8f9fa;
      border: 1px solid #ced4da;
      color: #333;
      border-radius: 8px;
      height: 50px;
      font-size: 14px;
      padding-left: 45px;
      box-shadow: none;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      background-color: #ffffff;
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2);
    }
    
    .form-control-feedback {
      color: #6c757d;
      line-height: 50px;
      width: 45px;
      text-align: center;
    }
    
    .form-group.focused .form-control-feedback {
      color: #007bff;
    }
    
    .btn-primary {
      background: linear-gradient(45deg, #007bff, #4da3ff);
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-weight: 500;
      letter-spacing: 0.5px;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
    }
    
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(45deg, #0069d9, #3a93ff);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
    }
    
    .btn-primary:active {
      transform: translateY(0);
      box-shadow: 0 2px 10px rgba(0, 123, 255, 0.2);
    }
    
    hr {
      border-color: #e9ecef;
      margin: 25px 0;
    }
    
    .alert {
      border-radius: 8px;
      margin-bottom: 20px;
      font-weight: 500;
    }
    
    .alert-danger {
      background-color: #fff2f2;
      border-color: #ffcdd2;
      color: #d32f2f;
    }
    
    .checkbox label {
      color: #6c757d;
      font-weight: 400;
      cursor: pointer;
    }
    
    .copyright {
      color: #6c757d;
      font-size: 13px;
      margin-top: 15px;
    }
    
    /* Custom iCheck styling */
    .icheckbox_square-blue {
      background-color: #f8f9fa;
      border: 1px solid #ced4da;
      border-radius: 4px;
    }
    
    /* System brand */
    .system-brand span {
      font-weight: 700;
      letter-spacing: -0.5px;
    }
    
    .system-brand .text-red {
      color: #D62B31;
    }
    
    .system-brand .text-yellow {
      color: #EFB53E;
    }
    
    /* Responsive adjustments */
    @media (max-width: 480px) {
      .login-box {
        width: 90%;
        margin: 0 auto;
      }
      
      .login-box-body {
        padding: 25px;
      }
    }
  </style>
</head>
<body>
  <!-- Animated background shapes -->
  <div class="shape shape-1"></div>
  <div class="shape shape-2"></div>
  <div class="shape shape-3"></div>
  
  <div class="login-box">
    <div>
     <?php if($this->session->flashdata('msg')): ?>
     <div class="alert alert-danger alert-dismissible">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <?php echo $this->session->flashdata('msg');?>
     </div>
     <?php endif; ?>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <div class="logo-container">
        <img src="<?php echo base_url().'assets/images/guest.png'?>" alt="Event Attendance System Logo">
      </div>
      <h3 class="text-center login-box-msg system-brand">
        <span class="text-red">Guest</span><span class="text-yellow">Book</span>
      </h3>
      <p class="text-center text-muted" style="margin-bottom: 25px;">Sign in to start your session</p>
     
      <form action="<?php echo site_url().'login/auth'?>" method="post">
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->
      <hr/>
      <p class="text-center copyright">Copyright &copy; <?php echo date('Y');?> All Rights Reserved</p>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url().'assets/plugins/jQuery/jquery-2.2.3.min.js'?>"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'?>"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
      
      // Add animation to form inputs
      $('.form-control').focus(function() {
        $(this).parent('.form-group').addClass('focused');
      }).blur(function() {
        if ($(this).val() === '') {
          $(this).parent('.form-group').removeClass('focused');
        }
      });
    });
  </script>
</body>
</html>