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
  
  
  
<!--<script src="<?php //echo base_url('static/')?>assets/js/Chart.js"></script>   -->

  

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-black fixed sidebar-mini">
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
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
		  <?php $tb_tiket = $this->db->get_where('blip_wo_khusus_noc', array('status' => "Open"))->num_rows(); ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $tb_tiket; ?></span>
            </a>
            <ul class="dropdown-menu">
			
              <li class="header">You have <?php echo $tb_tiket; ?> ticket <b>Open</b></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php 
				$tb_tiket = $this->db->get_where('blip_wo_khusus_noc', array('status' => "Open"))->result_array(); 
				foreach($tb_tiket as $data_tiket):
				?>
                  <li style="font-size:10px">
                    <a href="#" title="<?php 
							$data_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $data_tiket['id_pelanggan']))->row_array(); 
							if($data_tiket['id_pelanggan'] == 0){
							echo $data_tiket['id_bts']."\r\nKendala: ".$data_tiket['kendala']."\r\nKeterangan: ".$data_tiket['keterangan'];
							}else{
							echo $data_pelanggan['nama']."\r\nKendala: ".$data_tiket['kendala']."\r\nKeterangan: ".$data_tiket['keterangan']; 
							}
							?> ">
                     <b>No Tiket: <?php echo $data_tiket['tiket']; ?></b><br><span style="color:#FF0000">Kendala: <?php echo $data_tiket['kendala']; ?></span><br><span style="color:#FF0000">Start: <?php echo $data_tiket['waktu_mulai']; ?></span>
                    </a>
                  </li>
				 <?php endforeach; ?>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger"><?php echo $wo_baru; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><strong>You have <?php echo $wo_baru; ?> new tasks</strong></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php
				$tb_wo = $this->db->get_where('blip_wo', array('status' => "0"))->result_array();
				foreach($tb_wo as $data_wo):
				?>
                  <li style="font-size:10px"><!-- Task item -->
                    <a href="#">
					  <i class="fa fa-warning text-red"></i>
                        <?php echo $data_wo['nama']; ?>
						<?php
						$data_request = $this->db->get_where('blip_kpi', array('id' => $data_wo['request']))->row_array();
						$kpi_induk = $this->db->get_where('blip_kpi_induk', array('id' => $data_request['klasifikasi']))->row_array();
						?>
                        <br><span style="color:#FF0000">[<?php echo $data_request['kegiatan']; ?>]</span>
                    </a>
                  </li>
                  <!-- end task item -->
				<?php endforeach; ?>
                </ul>
              </li>
              <li class="footer">
                <a href="<?php base_url('manage/wo'); ?>">View all tasks</a>
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
                <img src="<?php echo base_url('static/photos/operator/'); ?><?php echo $this->session->userdata('ses_foto'); ?>" class="img-circle" alt="User Image">

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
          <span style="font-size:13px; color:#FFFFFF; font-weight:bold"><?php echo $this->session->userdata('ses_nama'); ?></span><br>
          <span style="font-size:10px; color:#ff4e00"><?php if ($this->session->userdata('ses_admin') == "1") { echo "Super Admin"; } elseif ($this->session->userdata('ses_admin') == "2") { echo "Manager"; }elseif ($this->session->userdata('ses_admin') == "3") { echo "Technical Leader"; }elseif ($this->session->userdata('ses_admin') == "4") { echo "Admin Operational"; }elseif ($this->session->userdata('ses_admin') == "5") { echo "Technical Staff"; }elseif ($this->session->userdata('ses_admin') == "6") { echo "Asistant Manager"; }elseif ($this->session->userdata('ses_admin') == "7") { echo "Sales CE"; }elseif ($this->session->userdata('ses_admin') == "8") { echo "Sales Staff"; }  ?></span>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
		
        <li>
          <a href="<?php echo base_url('manage'); ?>"<?php echo ($menu == 'dashboard') ? ' class="active"' : ''; ?>>
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>

          </a>
        </li>
		
		<li>
          <a href="<?php echo base_url('manage/data_pelanggan'); ?>"<?php echo ($menu == 'data_pelanggan') ? ' class="active"' : ''; ?>>
            <i class="fa fa-th"></i> <span>Data Pelanggan</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"><?php echo $jumlah_pelanggan; ?></small>
            </span>
          </a>
        </li>
		
		
		
		
		
		
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'):?>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Data Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		  
          <ul class="treeview-menu">
		  
		  	<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'):?>
            <li><a href="<?php echo base_url('manage/wo'); ?>"><i class="fa fa-circle-o"></i><span class="pull-right-container">
              <small class="label pull-right bg-blue"><?php echo $wo_all; ?></small>
			  <small class="label pull-right bg-green"><?php echo $wo_selesai; ?></small>
			  <small class="label pull-right bg-red"><?php echo $wo_baru; ?></small>
            </span> WO Reguler</a></li>
			<?php endif; ?>
			
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
			<li><a href="<?php echo base_url('manage/wo_khusus_admin'); ?>"><i class="fa fa-circle-o"></i> WO Khusus</a></li>
			<li><a href="<?php echo base_url('manage/kpi_induk'); ?>"><i class="fa fa-circle-o"></i> KPI</a></li>
            <li><a href="<?php echo base_url('manage/kpi'); ?>"><i class="fa fa-circle-o"></i> Sub KPI</a></li>
			<li><a href="<?php echo base_url('manage/produk'); ?>"><i class="fa fa-circle-o"></i> Produk</a></li>
			<li><a href="<?php echo base_url('manage/media'); ?>"><i class="fa fa-circle-o"></i> Media Access</a></li>
			<li><a href="<?php echo base_url('manage/sales'); ?>"><i class="fa fa-circle-o"></i> Sales</a></li>
			<?php endif; ?>
			
         </ul>
        </li>
		<?php endif; ?>
		
		
		
		
		
		
		
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Data Teknis</span>
			<i class="fa fa-angle-left pull-right"></i>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
		  
		 
			
			
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
			<li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>BSC / BTS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		  
		  
		  
          <ul class="treeview-menu">
		  
		  
		   <?php if($this->session->userdata('ses_admin')=='1'):?>
		    <li><a href="<?php echo base_url('manage/server'); ?>"<?php echo ($menu == 'server') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> <span>Server</span></a></li>
            <li><a href="<?php echo base_url('manage/distribusi'); ?>"<?php echo ($menu == 'distribusi') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Router Distribusi</a></li>
            <li><a href="<?php echo base_url('manage/TE'); ?>"<?php echo ($menu == 'TE') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Router TE / BTS</a></li>
			<?php endif; ?>
			
				<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
			<li class="treeview">
			  <a href="#">
				<i class="fa fa-laptop"></i>
				<span>OLT Provisioning</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
			  </a>
			  <ul class="treeview-menu">
			  <li><a href="<?php echo base_url('manage/olt/'); ?>"<?php echo ($menu == 'olt_tambah') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Data OLT</a></li>
			  <li><a href="<?php echo base_url('manage/onu'); ?>"<?php echo ($menu == 'onu_list') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Data ONU</a></li> 
			  </ul>
			</li>
			<?php endif; ?>
			
			
			
			<li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Summary Traffic <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<li><a href="<?php echo base_url('manage/firewall_filter/index_ix'); ?>"<?php echo ($menu == 'index_ix') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Traffic IX</a></li>
			<li><a href="<?php echo base_url('manage/firewall_filter/index_iix'); ?>"<?php echo ($menu == 'index_iix') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Traffic IIX</a></li>
			<li><a href="<?php echo base_url('manage/firewall_filter/index_content'); ?>"<?php echo ($menu == 'index_content') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Traffic Content</a></li>
			</ul>
			</li>
			
			
            <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> BTS &raquo; End User <i class="fa fa-angle-left pull-right"></i></a>
			
			<ul class="treeview-menu">	
			<li><a href="<?php echo base_url('manage/bts'); ?>"<?php echo ($menu == 'bts') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Radio AP BTS</a></li>
            <li><a href="<?php echo base_url('manage/station'); ?>"<?php echo ($menu == 'bts') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Radio Station</a></li><li><a href="<?php echo base_url('manage/station'); ?>"<?php echo ($menu == 'bts') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Router Pelanggan</a></li>
            <li><a href="<?php echo base_url('manage/maintenance'); ?>"<?php echo ($menu == 'maintenance') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Maintenance</a></li>
          </ul>
			</li>
			<li><a href="<?php echo base_url('manage/firewall_filter'); ?>"<?php echo ($menu == 'firewall_filter') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Firewall Filter</a></li>
        
          </ul>
		  	  
        </li>
		<?php endif; ?>
		
		
		 
		

		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Mapping</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' ||$this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
            <li><a href="<?php echo base_url('manage/mapping'); ?>"<?php echo ($menu == 'mapping') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Kordinat ODP</a></li>
			<?php  endif; ?>
			
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
            <li><a href="<?php echo base_url('manage/mapping/result'); ?>"<?php echo ($menu == 'mapping') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Hasil Mapping</a></li>
			<?php  endif; ?>
           
          </ul>
        </li>
		
		
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
		<li><a href="<?php echo base_url('manage/lastmile_mitra'); ?>"><i class="fa fa-circle-o"></i> Lastmile Mitra</a></li> 
		<?php endif;?>
		
		
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>VAS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  
		  	<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
		  	<li><a href="<?php echo base_url('manage/vas_data'); ?>"<?php echo ($menu == 'vas_data') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Data VAS</a></li>
			<?php endif; ?>
			
			
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
           <li><a href="<?php echo base_url('manage/vas_spec'); ?>"<?php echo ($menu == 'vas_spec') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Data Spesifikasi</a></li>
		   <?php endif; ?>
		   
          </ul>
        </li>
		
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
		<li><a href="<?php echo base_url('manage/spk'); ?>"><i class="fa fa-circle-o"></i> SPK</a></li> 
		<?php endif; ?>

	   <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
	   <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>[NOC] Sistem Tiket</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		    <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
		  	<li><a href="<?php echo base_url('manage/noc_tiket_list'); ?>"<?php echo ($menu == 'noc_tiket_list') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> Data Tiketing</a></li>
			<?php endif; ?>
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
		  	<li><a href="<?php echo base_url('manage/noc_tiket_case_klasifikasi'); ?>"<?php echo ($menu == 'noc_tiket_case_klasifikasi') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> [MD] Case Klasifikasi</a></li>
			<?php endif; ?>
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
		  	<li><a href="<?php echo base_url('manage/noc_tiket_case_subklasifikasi'); ?>"<?php echo ($menu == 'noc_tiket_case_subklasifikasi') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> [MD] Case Sub Klasifikasi</a></li>
			<?php endif; ?>
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
		  	<li><a href="<?php echo base_url('manage/noc_tiket_noc_ipcore'); ?>"<?php echo ($menu == 'noc_tiket_noc_ipcore') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> [MD] NOC IP Core</a></li>
			<?php endif; ?>
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
		  	<li><a href="<?php echo base_url('manage/noc_tiket_noc_hd'); ?>"<?php echo ($menu == 'noc_tiket_noc_hd') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> [MD] NOC HD</a></li>
			<?php endif; ?>
			 <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
		  	<li><a href="<?php echo base_url('manage/noc_tiket_eskalasi'); ?>"<?php echo ($menu == 'noc_tiket_eskalasi') ? ' class="active"' : ''; ?>><i class="fa fa-circle-o"></i> [MD] Eskalasi Akhir</a></li>
			<?php endif; ?>
			
		   
          </ul>
        </li>
	   <?php endif; ?>
	   
          </ul>
        </li>
		<?php endif; ?>
	<?php endif; ?>
		
		
        
		
		
		
		
		

        
		
		
		
		
		
        <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
		 <li>
          <a href="<?php echo base_url('manage/scheduler'); ?>"<?php echo ($menu == 'scheduler') ? ' class="active"' : ''; ?>>
            <i class="fa fa-calendar"></i> <span>Scheduler</span>
            <span class="pull-right-container">
			<small class="label pull-right bg-blue" title="Selesai"><?php echo $sch_total; ?></small>
			<small class="label pull-right bg-green" title="Berjalan"><?php echo $sch_run; ?></small>
			<small class="label pull-right bg-red" title="Menunggu"><?php echo $sch_wait; ?></small>
             
              
              
            </span>
          </a>
        </li>   
		<?php endif; ?>
		
		
		
		
		   
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
		
		
        <li>
          <a href="<?php echo base_url('logout'); ?>">
            <i class="fa fa-share"></i> <span>Logout</span>
          </a>
        </li>
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  
  
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">