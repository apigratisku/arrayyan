<?php
/*header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");*/
clearstatcache();
?>

<!doctype html>
<html lang="en">

<head>

	<title>
		<?php echo isset($title) ? "BLIP.NET.ID :: " . $title : "Dashboard"; ?>
	</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('static/assets/'); ?>/img/logo_web.png">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/timepicker/bootstrap-timepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/skins/_all-skins.min.css">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  
<!-- DATETIME PICKER -->
<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap-datetimepicker.min.css">
<link href="<?php echo base_url('static/'); ?>assets/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/datepicker/js/bootstrap-datetimepicker.min.js"></script>
  
  
  
  
  
  

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-purple fixed sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BLIP</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BLIP.NET.ID</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('static/'); ?>assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('static/'); ?>assets/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('static/'); ?>assets/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('static/'); ?>assets/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('static/'); ?>assets/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php 
			if ($this->session->userdata('ses_foto') != NULL)
			{ 
			?>
			<img src="<?php echo base_url('static/photos/operator/'); ?><?php echo $this->session->userdata('ses_foto'); ?>" class="user-image" alt="User Image">
			<?php 
			} 
			else 
			{
			?>
			<img src="<?php echo base_url('static/'); ?>photos/default-user.png" class="user-image" alt="User Image">
			<?php
			} 
			?>
              
              <span class="hidden-xs"><?php echo $this->session->userdata('ses_nama'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('static/'); ?>assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('ses_nama'); ?> - <?php if($this->session->userdata('ses_admin') == 1) {echo "Super Admin";} else {echo"Operator";} ?>

                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('manage/operator/gantipwd'); ?>" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
		<?php 
			if ($this->session->userdata('ses_foto') != NULL)
			{ 
			?>
			<img src="<?php echo base_url('static/photos/operator/'); ?><?php echo $this->session->userdata('ses_foto'); ?>" class="img-circle" alt="User Image">
			<?php 
			} 
			else 
			{
			?>
			<img src="<?php echo base_url('static/'); ?>assets/img/default-user.png" class="img-circle" alt="Avatar">
			<?php
			} 
			?>
		
		
          
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('ses_nama'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a><br>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2'):?>
        <li>
          <a href="<?php echo base_url('manage'); ?>"<?php echo ($menu == 'dashboard') ? ' class="active"' : ''; ?>>
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>

          </a>
        </li>
		<?php endif; ?>
		
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Core Configuration</span>
			<i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
		    <li><a href="<?php echo base_url('manage/server'); ?>"<?php echo ($menu == 'server') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> <span> Server</span></a></li>
            <li><a href="<?php echo base_url('manage/distribusi'); ?>"<?php echo ($menu == 'distribusi') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Router DR</a></li>
            <li><a href="<?php echo base_url('manage/TE'); ?>"<?php echo ($menu == 'TE') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Router TE</a></li>
			<li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>BTS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		  
          <ul class="treeview-menu">
            <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Wireless <i class="fa fa-angle-left pull-right"></i></a>
			
			<ul class="treeview-menu">	
			<li><a href="<?php echo base_url('manage/bts'); ?>"<?php echo ($menu == 'bts') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Radio AP</a></li>
            <li><a href="<?php echo base_url('manage/station'); ?>"<?php echo ($menu == 'bts') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Radio Station</a></li>
            <li><a href="<?php echo base_url('manage/maintenance'); ?>"<?php echo ($menu == 'maintenance') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Maintenance</a></li>
          </ul>
		  
			</li>
            <li><a href="<?php echo base_url('manage/olt/'); ?>"<?php echo ($menu == 'olt_list') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> OLT</a></li>
          </ul>
        </li>
          </ul>
        </li>
        <li>
          <a href="<?php echo base_url('manage/router'); ?>"<?php echo ($menu == 'router') ? ' class="active"' : ''; ?>>
            <i class="fa fa-th"></i> <span>Pelanggan</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"><?php echo $jumlah_router; ?></small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>MRTG</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> ICT</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> INNER</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>SmartOLT</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  <li><a href="<?php echo base_url('manage/olt/statistik'); ?>"<?php echo ($menu == 'olt_statistik') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Statistik</a></li>
            <li><a href="<?php echo base_url('manage/onu'); ?>"<?php echo ($menu == 'onu_list') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> ONU</a></li>  
			<li><a href="<?php echo base_url('manage/fiberstream'); ?>"<?php echo ($menu == 'fiberstream_index') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Layanan</a></li>
			<li><a href="<?php echo base_url('manage/fiberstream/pon'); ?>"<?php echo ($menu == 'fiberstream_pon') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Diagnosa</a></li>
          </ul>
        </li>

		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Mapping</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('manage/mapping'); ?>"<?php echo ($menu == 'mapping') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Kordinat ODP</a></li>
            <li><a href="<?php echo base_url('manage/mapping/result'); ?>"<?php echo ($menu == 'mapping') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Hasil Mapping</a></li>
           
          </ul>
        </li>
		
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
          </a>
        </li>
		 <li>
          <a href="<?php echo base_url('manage/scheduler'); ?>"<?php echo ($menu == 'scheduler') ? ' class="active"' : ''; ?>>
            <i class="fa fa-calendar"></i> <span>Scheduler</span>
            <span class="pull-right-container">
			<small class="label pull-right bg-green" title="Selesai"><?php echo $sch_total; ?></small>
			<small class="label pull-right bg-blue" title="Berjalan"><?php echo $sch_run; ?></small>
			<small class="label pull-right bg-red" title="Menunggu"><?php echo $sch_wait; ?></small>
             
              
              
            </span>
          </a>
        </li>      
		<?php if($this->session->userdata('ses_admin')=='1'):?>
        <li>
          <a href="<?php echo base_url('manage/operator'); ?>"<?php echo ($menu == 'operator') ? ' class="active"' : ''; ?>>
            <i class="fa fa-share"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
		<?php endif;?>
        <li><a href="#"><i class="fa fa-book"></i> <span>Log Dude</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  
  
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo strtoupper($menu); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('manage'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo base_url('manage/'.$menu); ?>"><?php echo $menu; ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">