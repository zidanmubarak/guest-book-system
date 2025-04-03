<?php
    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();
?>
<!--Counter Inbox-->
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url()?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><i class="fa fa-calendar-check-o"></i></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Guest</b>Book</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success"><?php echo "0";?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Anda memiliki <?php echo "0";?> pesan</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="<?php echo base_url().'inbox'?>">
                                        <div class="pull-left">
                                            <img src="<?php echo base_url()?>assets/images/user_blank.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>nama inbox
                                            <small><i class="fa fa-clock-o"></i> <?php echo "tgl_inbox";?></small>
                                        </h4>
                                        <p><?php echo "pesan inbox";?></p>
                                    </a>
                                </li>
                                <!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="<?php echo base_url().'inbox'?>">Lihat Semua Pesan</a></li>
                    </ul>
                </li>
                
                <!-- Notifications -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Anda memiliki 10 notifikasi</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 peserta baru mendaftar
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-calendar text-yellow"></i> Acara "Seminar Digital Marketing" dimulai besok
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-check-circle text-green"></i> 15 peserta telah check-in
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">Lihat Semua</a></li>
                    </ul>
                </li>
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                            if (!empty($this->session->userdata('foto'))){ 
                              echo "<img src=".base_url()."assets/images/".$this->session->userdata('foto')." class='user-image' alt=''>";
                            } else {
                              echo "<img src='".base_url()."assets/images/user_blank.png' class='user-image' alt=''>";
                            }
                        ?>
                        <span class="hidden-xs"><?php echo $this->session->userdata('nama');?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                                if(!empty($this->session->userdata('foto'))){ 
                                    echo "<img src=".base_url()."assets/images/".$this->session->userdata('foto')." onclick='modalimage(this.src)' class='img-circle' alt=''>";
                                } else {
                                    echo "<img src='".base_url()."assets/images/user_blank.png' class='img-circle' alt=''>";
                                }
                            ?>
                            <p>
                                <?php echo $this->session->userdata('nama');?>
                                <?php if($this->session->userdata('level')=='1'):?>
                                <small>Administrator</small>
                                <?php else:?>
                                <small>Petugas</small>
                                <?php endif;?>
                            </p>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url().'login/logout'?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="<?php echo base_url().''?>" target="_blank" title="Lihat Website"><i class="fa fa-globe"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
/* Modern styling for header */
.main-header {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.main-header .logo {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 0.5px;
}

.main-header .logo-lg b {
    font-weight: 600;
    color: #fff;
    letter-spacing: 0.5px;
}

.navbar-custom-menu .dropdown-menu {
    border-radius: 8px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.navbar-custom-menu .dropdown-menu .header {
    padding: 12px 15px;
    font-weight: 600;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.navbar-custom-menu .dropdown-menu .footer {
    padding: 10px 15px;
    text-align: center;
    border-top: 1px solid rgba(0,0,0,0.05);
}

.navbar-custom-menu .dropdown-menu .footer a {
    color: #007bff;
    font-weight: 500;
}

.navbar-custom-menu .dropdown-menu .menu {
    max-height: 250px;
}

.navbar-custom-menu .menu > li > a {
    padding: 12px 15px;
    display: flex;
    align-items: center;
}

.navbar-custom-menu .menu > li > a:hover {
    background-color: #f8f9fa;
}

.navbar-nav > .user-menu > .dropdown-menu > .user-header {
    height: auto;
    padding: 20px;
    background: linear-gradient(45deg, #007bff, #4da3ff);
}

.navbar-nav > .user-menu > .dropdown-menu > .user-header img {
    height: 70px;
    width: 70px;
    border: 3px solid rgba(255,255,255,0.2);
    margin-bottom: 10px;
}

.navbar-nav > .user-menu > .dropdown-menu > .user-header p {
    font-size: 16px;
    margin-top: 5px;
}

.navbar-nav > .user-menu > .dropdown-menu > .user-footer {
    padding: 15px;
    background-color: #f8f9fa;
}

.navbar-nav > .user-menu > .dropdown-menu > .user-footer .btn {
    border-radius: 5px;
    padding: 8px 15px;
    transition: all 0.3s;
}

.navbar-nav > .user-menu > .dropdown-menu > .user-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.navbar-nav > .messages-menu > .dropdown-menu > li .menu > li > a > h4 {
    margin: 0;
    padding: 0;
    font-weight: 600;
    font-size: 14px;
}

.navbar-nav > .notifications-menu > .dropdown-menu > li.header,
.navbar-nav > .messages-menu > .dropdown-menu > li.header {
    background-color: white;
    color: #333;
}

.navbar-nav > .notifications-menu > .dropdown-menu > li .menu > li > a {
    color: #444;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 10px;
}

.navbar-nav > .notifications-menu > .dropdown-menu > li .menu > li > a:hover {
    background-color: #f8f9fa;
}

.navbar-nav > .notifications-menu > .dropdown-menu > li .menu > li > a > .fa {
    width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    border-radius: 50%;
    font-size: 12px;
}

/* Label enhancements */
.label {
    border-radius: 4px;
    font-weight: 500;
    padding: 3px 6px;
    font-size: 10px;
}

/* Make dropdown toggles more interactive */
.navbar-nav > .dropdown > a:hover,
.navbar-nav > .dropdown.open > a {
    background-color: rgba(0,0,0,0.1) !important;
}
</style>