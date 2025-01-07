<!doctype html>
<html lang="en">

<head>

	<title>
		<?php echo isset($title) ? "GMEDIA.NET.ID :: " . $title : "Dashboard"; ?>
	</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('static/assets/'); ?>/img/logo.png">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap-datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/summernote.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/select2-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/chartist.min.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap-dashboard.css">

	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

</head>

<body>

	<!-- WRAPPER -->
	<div id="wrapper">

		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand" style="margin-right: 50px;">
				<a href="index.html" style="font-size: 18px; font-weight: bold; color: #555;">GMEDIA.NET.ID</a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-menu"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php 
							if ($this->session->userdata('ses_foto') != NULL)
							{ 
							?>
							<img src="<?php echo base_url('static/photos/operator/'); ?><?php echo $this->session->userdata('ses_foto'); ?>" class="img-circle" width="700" alt="Get Biger Image">
							<?php 
							} 
							else 
							{
							?>
							<img src="<?php echo base_url('static/'); ?>assets/img/default-user.png" class="img-circle" alt="Avatar">
							<?php
							} 
							?>
							
							
							 <span><?php echo $this->session->userdata('ses_userid'); ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('manage/profil'); ?>"><i class="lnr lnr-user"></i> <span>Profil</span></a></li>
								<li><a href="<?php echo base_url('manage/operator/gantipwd'); ?>"><i class="lnr lnr-cog"></i> <span>Ganti Password</span></a></li>
								<li><a href="<?php echo base_url('logout'); ?>"><i class="lnr lnr-exit"></i> <span>Keluar</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->

		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li>
							<a href="<?php echo base_url('manage'); ?>"<?php echo ($menu == 'dashboard') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-home"></i> <span>Dashboard</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('manage/server'); ?>"<?php echo ($menu == 'server') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-printer"></i> <span>Server</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('manage/router'); ?>"<?php echo ($menu == 'router') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-printer"></i> <span>Router</span>
							</a>
						</li>
<li>
							<a href="<?php echo base_url('manage/radio'); ?>"<?php echo ($menu == 'radio') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-printer"></i> <span>Radio</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('manage/traffic'); ?>"<?php echo ($menu == 'traffic') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-printer"></i> <span>Traffic Control</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('manage/wireless'); ?>"<?php echo ($menu == 'wireless') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-printer"></i> <span>Wireless</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('manage/netwatch'); ?>"<?php echo ($menu == 'netwatch') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-users"></i> <span>Netwatch</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('manage/hs'); ?>"<?php echo ($menu == 'hs') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-graduation-hat"></i> <span>Manage Hotspot</span>
							</a>
						</li>

						<li>
							<a href="<?php echo base_url('manage/operator'); ?>"<?php echo ($menu == 'operator') ? ' class="active"' : ''; ?>>
								<i class="lnr lnr-star"></i> <span>Manage Users</span>
							</a>
						</li>


					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->

		<!-- MAIN -->
		<div class="main">

			<!-- MAIN CONTENT -->
			<div class="main-content">

				<div class="container-fluid">
