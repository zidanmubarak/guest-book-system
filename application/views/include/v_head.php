<?php
    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Event Attendance System | <?php echo ucfirst($controller)?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Event Attendance System - Aplikasi manajemen kehadiran acara terintegrasi">
    <meta name="keywords" content="event, attendance, system, acara, kehadiran">
    <meta name="author" content="Your Team">
    <!-- App favicon -->
    <link rel="shorcut icon" type="text/css" href="<?php echo base_url().'assets/images/favicon.ico'?>">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css'?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css'?>">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.css'?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/AdminLTE.min.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/tooltips.css'?>">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/skins/_all-skins.min.css'?>">
    <!-- Toast Notifications -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/toast/jquery.toast.min.css'?>"/>
    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/select2/select2.css'?>">
    
    <style>
        /* Modern Theme Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Preloader */
        #preloader {
            position: fixed;
            z-index: 99999999999;
            top: 0;
            left: 0;
            overflow: visible;
            width: 100%;
            height: 100%;
            background-color: #f4f6f9;
        }
        
        #preloader:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            margin-top: -20px;
            margin-left: -20px;
            border-radius: 50%;
            border: 3px solid #f8f9fa;
            border-top-color: #007bff;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Text selection */
        ::selection {
            background: #007bff;
            color: #fff;
        }
        
        /* Select2 styles */
        .select2 {
            width: 100% !important;
        }
        
        .select2-container--default .select2-selection--single {
            border-color: #ced4da;
            border-radius: 4px;
            height: 34px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            padding-left: 12px;
            color: #333;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }
        
        .select2-dropdown {
            border-color: #ced4da;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
        }
        
        /* Enhanced button styles */
        .btn {
            border-radius: 4px;
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 6px 14px;
            transition: all 0.3s;
        }
        
        .btn:active, .btn:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #4da3ff);
            border: none;
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(45deg, #0069d9, #3a93ff);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(45deg, #28a745, #34ce57);
            border: none;
            box-shadow: 0 2px 6px rgba(40, 167, 69, 0.3);
        }
        
        .btn-success:hover, .btn-success:focus {
            background: linear-gradient(45deg, #218838, #2eba4e);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #f55a6a);
            border: none;
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);
        }
        
        .btn-danger:hover, .btn-danger:focus {
            background: linear-gradient(45deg, #c82333, #e74c5b);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        
        .btn-info {
            background: linear-gradient(45deg, #17a2b8, #30cce0);
            border: none;
            box-shadow: 0 2px 6px rgba(23, 162, 184, 0.3);
        }
        
        .btn-info:hover, .btn-info:focus {
            background: linear-gradient(45deg, #138496, #27b2c7);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
        }
        
        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #ffda6a);
            border: none;
            color: #212529;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);
        }
        
        .btn-warning:hover, .btn-warning:focus {
            background: linear-gradient(45deg, #e0a800, #ffc721);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
            color: #212529;
        }
        
        .btn-default {
            background: #f8f9fa;
            border-color: #ced4da;
            color: #495057;
        }
        
        .btn-default:hover {
            background: #e9ecef;
            border-color: #ced4da;
            color: #212529;
        }
        
        /* Button with icon */
        .btn > i {
            margin-right: 5px;
        }
        
        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            line-height: 36px;
            text-align: center;
            border-radius: 50%;
        }
        
        /* Button groups */
        .btn-group .btn {
            margin: 0;
        }
        
        /* Form controls styling */
        .form-control {
            border-radius: 4px;
            border-color: #ced4da;
            padding: 6px 12px;
            height: 34px;
            box-shadow: none;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2);
            background-color: #fff;
        }
        
        .form-control::placeholder {
            color: #adb5bd;
            opacity: 0.8;
        }
        
        textarea.form-control {
            min-height: 60px;
        }
        
        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 5px;
        }
        
        .form-control-feedback {
            color: #007bff;
        }
        
        /* Box enhancements */
        .box {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 20px;
            position: relative;
            background-color: #fff;
            transition: all 0.3s;
        }
        
        .box:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        }
        
        .box-header {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .box-header > .box-title {
            font-size: 16px;
            font-weight: 600;
            color: #212529;
        }
        
        .box-body {
            padding: 15px;
        }
        
        .box-footer {
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        
        /* Box with variants */
        .box-primary > .box-header {
            background-color: #007bff;
            color: #fff;
        }
        
        .box-success > .box-header {
            background-color: #28a745;
            color: #fff;
        }
        
        .box-info > .box-header {
            background-color: #17a2b8;
            color: #fff;
        }
        
        .box-warning > .box-header {
            background-color: #ffc107;
            color: #212529;
        }
        
        .box-danger > .box-header {
            background-color: #dc3545;
            color: #fff;
        }
        
        /* Enhanced table styling */
        .table {
            margin-bottom: 0;
        }
        
        .table-bordered {
            border: 1px solid #e9ecef;
        }
        
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #e9ecef;
            vertical-align: middle;
        }
        
        .table > thead > tr > th {
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
            padding: 10px 8px;
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }
        
        .table-hover > tbody > tr:hover {
            background-color: #f1f3f5;
        }
        
        .table-responsive {
            border: none;
        }
        
        /* DataTables styling */
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 15px;
        }
        
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 5px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #007bff;
            border-color: #007bff;
            color: #fff !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e9ecef;
            border-color: #dee2e6;
        }
        
        /* Modal styling */
        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            background-color: #f8f9fa;
        }
        
        .modal-header .close {
            opacity: 0.6;
            transition: opacity 0.3s;
        }
        
        .modal-header .close:hover {
            opacity: 1;
        }
        
        .modal-title {
            font-weight: 600;
            color: #212529;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 20px;
            background-color: #f8f9fa;
        }
        
        /* AdminLTE skin enhancements */
        .skin-purple .main-header .navbar {
            background: linear-gradient(45deg, #007bff, #4da3ff);
        }
        
        .skin-purple .main-header .logo {
            background-color: #0066cc;
            color: #fff;
        }
        
        .skin-purple .main-header .logo:hover {
            background-color: #0058b3;
        }
        
        .skin-purple .main-header .navbar .sidebar-toggle:hover {
            background-color: #0066cc;
        }
        
        .skin-purple .content-wrapper,
        .skin-purple .main-footer {
            background-color: #f4f6f9;
        }
        
        .skin-purple .content-header {
            background: transparent;
            /* padding: 15px 0; */
        }
        
        .skin-purple .content-header h1 {
            font-size: 20px;
            font-weight: 600;
            color: #212529;
        }
        
        .skin-purple .content-header h1 small {
            font-size: 14px;
            color: #6c757d;
        }
        
        .content-header .breadcrumb {
            background: transparent;
            padding: 0;
            margin-top: 5px;
        }
        
        .content-header .breadcrumb > li > a {
            color: #007bff;
        }
        
        .content-header .breadcrumb > .active {
            color: #6c757d;
        }
        
        /* Card styling */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border: none;
            transition: all 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        }
        
        .card-header {
            padding: 15px;
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .card-footer {
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        
        /* Small box styling (for dashboard stats) */
        .small-box {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
            transition: all 0.3s;
        }
        
        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .small-box > .inner {
            padding: 20px;
        }
        
        .small-box h3 {
            font-size: 32px;
            font-weight: 600;
            margin: 0 0 5px 0;
            white-space: nowrap;
            color: #fff;
        }
        
        .small-box p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .small-box .icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 60px;
            color: rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }
        
        .small-box:hover .icon {
            font-size: 65px;
        }
        
        .small-box .small-box-footer {
            position: relative;
            text-align: center;
            padding: 8px 0;
            color: rgba(255, 255, 255, 0.8);
            display: block;
            z-index: 10;
            background: rgba(0, 0, 0, 0.1);
            text-decoration: none;
            border-radius: 0 0 8px 8px;
        }
        
        .small-box .small-box-footer:hover {
            color: #fff;
            background: rgba(0, 0, 0, 0.15);
        }
        
        .bg-aqua {
            background: linear-gradient(45deg, #17a2b8, #30cce0) !important;
        }
        
        .bg-green {
            background: linear-gradient(45deg, #28a745, #34ce57) !important;
        }
        
        .bg-yellow {
            background: linear-gradient(45deg, #ffc107, #ffda6a) !important;
        }
        
        .bg-red {
            background: linear-gradient(45deg, #dc3545, #f55a6a) !important;
        }
        
        /* Enhanced info-box for dashboard */
        .info-box {
            display: block;
            min-height: 90px;
            background: #fff;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .info-box-icon {
            display: block;
            float: left;
            height: 90px;
            width: 90px;
            text-align: center;
            font-size: 45px;
            line-height: 90px;
            border-radius: 8px 0 0 8px;
            color: #fff;
        }
        
        .info-box-content {
            padding: 15px 10px;
            margin-left: 90px;
        }
        
        .info-box-text {
            display: block;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .info-box-number {
            display: block;
            font-weight: 600;
            font-size: 24px;
            color: #212529;
        }
        
        .bg-info {
            background-color: #17a2b8 !important;
        }
        
        .bg-success {
            background-color: #28a745 !important;
        }
        
        .bg-warning {
            background-color: #ffc107 !important;
        }
        
        .bg-danger {
            background-color: #dc3545 !important;
        }
        
        .bg-primary {
            background-color: #007bff !important;
        }
        
        /* Chart and stats container */
        .chart-container {
            position: relative;
            margin: 20px 0;
            height: 300px;
        }
        
        /* Alert styling */
        .alert {
            border-radius: 6px;
            border: none;
            padding: 15px;
            position: relative;
        }
        
        .alert-dismissible .close {
            position: absolute;
            right: 15px;
            top: 15px;
            color: inherit;
            opacity: 0.6;
        }
        
        .alert-dismissible .close:hover {
            opacity: 1;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        /* Badge and label styling */
        .badge, .label {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 4px;
        }
        
        .label-success, .badge-success {
            background-color: #28a745;
            color: #fff;
        }
        
        .label-info, .badge-info {
            background-color: #17a2b8;
            color: #fff;
        }
        
        .label-warning, .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .label-danger, .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }
        
        .label-primary, .badge-primary {
            background-color: #007bff;
            color: #fff;
        }
        
        .label-default, .badge-default {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition skin-purple sidebar-mini">
    <div id="preloader"></div>
    <div class="wrapper">