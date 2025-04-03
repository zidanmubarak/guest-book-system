<?php
    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?php 
                    $foto_user = $this->session->userdata('foto');
                    if(empty($foto_user) || $foto_user == "") {
                ?>
                        <img src="<?php echo base_url()?>assets/images/user_blank.png" class="img-circle" alt="User Image">
                <?php 
                    }else {
                ?>
                        <img src="<?php echo base_url()?>assets/images/<?php echo $foto_user?>" onclick="modalimage(this.src)" class="img-circle" alt="User Image">
                <?php 
                    }
                ?>
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('nama');?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.User panel -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari menu...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU UTAMA</li>
            
            <li class="<?php if($controller == 'dashboard') { echo 'active'; } ?>">
                <a href="<?php echo base_url().'dashboard'?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            
            <li class="header">MANAJEMEN ACARA</li>
            
            <!-- New Event Management menus -->
            <li class="<?php if($controller == 'data_acara' && $method == 'index') { echo 'active'; } ?>">
                <a href="<?php echo base_url().'data_acara'?>">
                    <i class="fa fa-calendar"></i> <span>Daftar Acara</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-blue">4</small>
                    </span>
                </a>
            </li>
            
            <li class="<?php if($controller == 'data_acara' && $method == 'scan_qr') { echo 'active'; } ?>">
                <a href="<?php echo base_url().'data_acara/scan_qr'?>">
                    <i class="fa fa-qrcode"></i> <span>Check-in Tamu</span>
                </a>
            </li>
            
            <li class="<?php if($controller == 'data_acara' && $method == 'laporan') { echo 'active'; } ?>">
                <a href="<?php echo base_url().'data_acara/laporan'?>">
                    <i class="fa fa-bar-chart"></i> <span>Laporan Kehadiran</span>
                </a>
            </li>
            
            <li class="header">DATA MANAGEMENT</li>
            
            <!-- Original Data Tamu menu -->
            <li class="<?php if($controller == 'data_buku_tamu') { echo 'active'; } ?>">
                <a href="<?php echo base_url().'data_buku_tamu'?>">
                    <i class="fa fa-users"></i> <span>Data Tamu</span>
                </a>
            </li>
            
            <!-- Master Data Management -->
            <li class="treeview <?php if($controller == 'user' || $controller == 'pegawai' || $controller == 'bagian' || $controller == 'jabatan') { echo 'active'; } ?>">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>Data Master</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if($controller == 'user' ) { echo 'active'; } ?>">
                        <a href="<?php echo base_url().'user'?>">
                            <i class="fa fa-user"></i> <span>User</span>
                        </a>
                    </li>
                    <li class="<?php if($controller == 'bagian' ) { echo 'active'; } ?>">
                        <a href="<?php echo base_url().'bagian'?>">
                            <i class="fa fa-building-o"></i> <span>Bagian/Department</span>
                        </a>
                    </li>
                    <li class="<?php if($controller == 'jabatan' ) { echo 'active'; } ?>">
                        <a href="<?php echo base_url().'jabatan'?>">
                            <i class="fa fa-briefcase"></i> <span>Master Jabatan</span>
                        </a>
                    </li>
                    <li class="<?php if($controller == 'pegawai' ) { echo 'active'; } ?>">
                        <a href="<?php echo base_url().'pegawai'?>">
                            <i class="fa fa-users"></i> <span>Pegawai</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="header">SISTEM</li>

			<li>
                <a href="<?php echo base_url().'login/logout'?>">
                    <i class="fa fa-sign-out"></i> <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </section>
<!-- /.sidebar -->
</aside>

<!-- Add the necessary CSS to style the sidebar for light theme -->
<style>
    /* Enhanced Light Theme Sidebar Styles */
    .main-sidebar {
        background-color: #f8f9fa !important;
        box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1) !important;
    }
    
    .sidebar-menu {
        padding-bottom: 20px;
    }
    
    .sidebar-menu li {
        margin: 2px 0;
    }
    
    /* Make all menu items have the same left margin */
    .sidebar-menu > li > a {
        padding: 12px 12px 12px 15px;
        color: #333 !important;
        border-radius: 5px;
        margin: 0 5px;
        transition: all 0.2s;
    }
    
    .sidebar-menu > li.active > a {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
        border-left-color: #007bff !important;
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.1);
    }
    
    .sidebar-menu > li > a:hover {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.05) !important;
        transform: translateX(3px);
    }
    
    .sidebar-menu > li.header {
        background-color: transparent !important;
        color: #6c757d !important;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 15px 15px 5px 15px;
    }
    
    /* Treeview menu styling */
    .sidebar-menu .treeview-menu {
        background-color: transparent !important;
        margin: 0 5px 0 20px !important;
        padding: 0 0 0 15px !important;
        border-left: 1px dashed rgba(0, 123, 255, 0.2);
    }
    
    .sidebar-menu .treeview-menu > li {
        margin: 0;
    }
    
    .sidebar-menu .treeview-menu > li > a {
        color: #555 !important;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.2s;
    }
    
    .sidebar-menu .treeview-menu > li.active > a,
    .sidebar-menu .treeview-menu > li > a:hover {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.05) !important;
    }
    
    /* Enhanced user panel */
    .user-panel {
        background-color: transparent !important;
        padding: 20px 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 10px;
    }
    
    .user-panel > .image > img {
        border: 2px solid rgba(0, 123, 255, 0.2);
        width: 45px;
        height: 45px;
        object-fit: cover;
    }
    
    .user-panel > .info {
        left: 65px;
        padding: 5px 0;
    }
    
    .user-panel > .info > p {
        font-size: 14px;
        font-weight: 600;
        color: #333 !important;
        margin-bottom: 3px;
    }
    
    .user-panel > .info > a {
        color: #4CAF50 !important;
        font-size: 12px;
    }
    
    .user-panel > .info > a > .fa-circle {
        font-size: 10px;
    }
    
    /* Search form styling */
    .sidebar-form {
        border: none !important;
        background-color: transparent !important;
        margin: 10px;
    }
    
    .sidebar-form .input-group {
        border-radius: 30px;
        background-color: #ffffff !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .sidebar-form input[type="text"] {
        background-color: transparent !important;
        color: #333 !important;
        border: none !important;
        height: 35px;
        font-size: 13px;
        padding-left: 15px;
    }
    
    .sidebar-form .btn {
        background-color: transparent !important;
        color: #666 !important;
        height: 35px;
        padding-right: 15px;
    }
    
    /* Enhance the angle left/right icons */
    .sidebar-menu li > a > .fa-angle-left {
        transition: all 0.3s ease;
    }
    
    .sidebar-menu li.active > a > .fa-angle-left {
        transform: rotate(-90deg);
    }
    
    /* Icon styles for menu items */
    .sidebar-menu li > a > .fa,
    .sidebar-menu li > a > .glyphicon,
    .sidebar-menu li > a > .ion {
        width: 20px;
        margin-right: 10px;
        font-size: 16px;
        text-align: center;
    }
    
    /* Colorful icons for better visual hierarchy */
    .sidebar-menu li > a > .fa-dashboard {
        color: #007bff !important;
    }
    
    .sidebar-menu li > a > .fa-users {
        color: #28a745 !important;
    }
    
    .sidebar-menu li > a > .fa-calendar {
        color: #17a2b8 !important;
    }
    
    .sidebar-menu li > a > .fa-qrcode {
        color: #6610f2 !important;
    }
    
    .sidebar-menu li > a > .fa-bar-chart {
        color: #fd7e14 !important;
    }
    
    .sidebar-menu li > a > .fa-cogs {
        color: #6c757d !important;
    }
    
    .sidebar-menu li > a > .fa-sign-out {
        color: #dc3545 !important;
    }
    
    .sidebar-menu li > a > .fa-user {
        color: #007bff !important;
    }
    
    .sidebar-menu li > a > .fa-building-o {
        color: #6f42c1 !important;
    }
    
    .sidebar-menu li > a > .fa-briefcase {
        color: #20c997 !important;
    }
    
    /* Label styling */
    .sidebar-menu .pull-right-container {
        margin-right: 0;
    }
    
    .sidebar-menu .label {
        padding: 3px 6px;
        font-size: 10px;
        font-weight: 500;
        border-radius: 10px;
    }
</style>