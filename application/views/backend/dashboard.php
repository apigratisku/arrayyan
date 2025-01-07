<!-- PANEL HEADLINE -->
<?php
$dismantle = $this->db->query("Select SUM(admin_biaya_mtc) as total from blip_wo where request='9'")->row();
$otc = $this->db->query("Select SUM(admin_biaya_otc) as total from blip_wo where request='22'")->row();
$berlangganan = $this->db->query("Select SUM(admin_biaya_mtc) as total from blip_wo where request !='9'")->row();
/*$end_date = date("Y-m")."-31";
function get_best_week_in_range($end_date) {
     $this->db->select_sum('admin_biaya_mtc')
              ->from('blip_wo')
              ->where('request !=', "9")
             // ->where('date >=', $start_date)
              ->where('tgl_req_sales <=', $end_date);
              //->group_by('WEEK(date)')
              //->order_by('weekly_total', 'DESC')
             // ->limit(1);
    $query = $this->db->get();
    return $query->row('admin_biaya_mtc');
}
get_best_week_in_range($end_date);
*/
?>
<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
			<h3><?php echo $count_gmedia; ?></h3>

              <strong><p>Pelanggan GMEDIA</p></strong>
			
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
			<h3><?php echo $count_blip; ?></h3>

              <strong><p>Pelanggan BLiP</p></strong>
			
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
			<h3><?php echo $count_fs; ?></h3>

              <strong><p>Pelanggan FIBERSTREAM</p></strong>
			
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		
       
	   <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-black">
            <div class="inner">
			<h3><?php echo $count_aktif; ?></h3>

             <strong> <p>Pelanggan AKTIF</p></strong>
			
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
			<h3><?php echo $count_isolir; ?></h3>

              <strong><p>Pelanggan ISOLIR</p></strong>
			
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
			<h3><?php echo $count_dismantle; ?></h3>

              <strong><p>Pelanggan DISMANTLE</p></strong>
			
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
	   
	   
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
			<h3><?php echo $wo_selesai; ?></h3>

              <strong><p>WO Selesai</p></strong>
            </div>
            <div class="icon">
              <i class="ion ion-android-alarm-clock"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
			<h3><?php echo $wo_baru; ?></h3>

              <strong><p>WO Pending</p></strong>
            </div>
            <div class="icon">
              <i class="ion ion-android-alarm-clock"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
	  


      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
         

          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Work Order (Pending List)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Pelanggan</th>
                    <th>Kegiatan</th>
					<th style="text-align:center">KPI</th>
                    <th>Status</th>
                  </tr>
                  </thead>
				  
                  <tbody>
				  
				<?php  
				function selisih_waktu($date1, $date2, $format = false) 
							{
								$diff = date_diff( date_create($date1), date_create($date2) );
								if ($format)
									return $diff->format($format);
								
								return array('y' => $diff->y,
											'm' => $diff->m,
											'd' => $diff->d,
											'h' => $diff->h,
											'i' => $diff->i,
											's' => $diff->s
										);
							}
				?>  
				<?php 
				$tb_tiket = $this->db->order_by("id","desc")->get_where('blip_wo', array('status' => "0"))->result_array(); 
				foreach($tb_tiket as $data_tiket):
				$tb_kegiatan = $this->db->get_where('blip_kpi', array('id' => $data_tiket['request']))->row_array(); 

				?>
                  <tr>
                    <td><?php echo $data_tiket['nama']; ?></td>
					<td><?php echo $tb_kegiatan['kegiatan']; ?></td>
					<td style="text-align:center; font-weight:bold" width="8%">
                            <?php
							if($data_tiket['tgl_report_teknis'] != NULL){
								$diff = selisih_waktu($data_tiket['tgl_req_teknis'], $data_tiket['tgl_report_teknis']);
								if($diff['d'] <= $tb_kegiatan['durasi']){
								echo "<span style=\"color:green\">&#9989; Tercapai</span>";
								}else {
								echo "<span style=\"color:red\">&#9745 Tidak Tercapai</span>";
								}
							}else{
								$dt = $data_tiket['tgl_req_teknis'];
								$nyawa_tanggal =  date( "Y-M-d", strtotime("$dt +".$tb_kegiatan['durasi']." day" ));
								$sisanyawa = date( "Y-M-d", strtotime("$nyawa_tanggal -".$tb_kegiatan['durasi']." day" ));
								$diff = selisih_waktu(date("Y-m-d"),$nyawa_tanggal);
								echo $diff['d']." Hari";
							}
							 
							 ?>
                     </td>
                    
					<?php  
							if($data_tiket['status'] == "1"){
							$status =  "<span class=\"label label-success\">Done</span>";
							}else{
							$status =  "<span class=\"label label-danger\">Waiting</span>";
							}
					?>
                    <td><?php echo $status; ?></td>
                  </tr>
				 <?php endforeach; ?>
                  

                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-white">
            <span class="info-box-icon"> <i class="ion ion-person-add"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">NTB</span>
              <span class="info-box-number">Aktif: <?php echo $ntb_count_aktif; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                    Isolir: <?php echo $ntb_count_isolir; ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-white">
            <span class="info-box-icon"> <i class="ion ion-person-add"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">BALI</span>
              <span class="info-box-number">Aktif: <?php echo $bali_count_aktif; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                     Isolir: <?php echo $bali_count_isolir; ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-white">
            <span class="info-box-icon"> <i class="ion ion-person-add"></i></span>

            <div class="info-box-content">
			<span class="info-box-text">SURABAYA</span>
              <span class="info-box-number">Aktif: <?php echo $sby_count_aktif; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                     Isolir: <?php echo $sby_count_isolir; ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
		  
		  
		  <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'): ?>
		  
		  <div class="info-box bg-red">
            <span class="info-box-icon"> <i class="ion ion-pie-graph"></i></span>

            <div class="info-box-content">
			<span class="info-box-text">REVENUE OTC</span>
			
              <span class="info-box-number">Rp <?php echo number_format($otc->total, 0, ",", "."); ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
             asdasd
			 
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-green">
            <span class="info-box-icon"> <i class="ion ion-pie-graph"></i></span>

            <div class="info-box-content">
			<span class="info-box-text">REVENUE BERLANGGANAN</span>
            <span class="info-box-number">Rp <?php echo number_format($berlangganan->total, 0, ",", "."); ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
			  
<?php
$date = DateTime::createFromFormat('Y-m-d', "2023-08-15");
echo $date->format('m');
?>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
		<?php endif; ?>
        
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


   
