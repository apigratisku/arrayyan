 <?php 
if(isset($item['router_user'])){
require APPPATH."third_party/addon.php";
$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
$router_u = $item['router_user'];
$router_user = $this->secure->decrypt_url($router_u); }

if(isset($item['router_pass'])){
$router_p = $item['router_pass'];
$router_pass = $this->secure->decrypt_url($router_p); }

if(isset($item['lastmile_user'])){
$lastmile_u = $item['lastmile_user'];
$lastmile_user = $this->secure->decrypt_url($lastmile_u); }

if(isset($item['lastmile_password'])){
$lastmile_p = $item['lastmile_pass'];
$lastmile_pass = $this->secure->decrypt_url($lastmile_p); }
?>


<!-- PANEL HEADLINE -->

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA PELANGGAN</div>
<br>


    <div class="panel-body">

        <?php if ($this->session->flashdata('success')): ?>

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>

        <?php elseif ($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>

        <?php endif; ?>
		

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Data Admin</a></li>
			  <li><a href="#tab_2" data-toggle="tab">Data Layanan</a></li>
			  <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'): ?>
              <li><a href="#tab_3" data-toggle="tab">Data Teknis</a></li>
			  <li><a href="#tab_4" data-toggle="tab">Data Perangkat</a></li>  
			  <li><a href="#tab_6" data-toggle="tab">[Admin] WO Reguler</a></li>
			  <li><a href="#tab_7" data-toggle="tab">[Admin] WO Khusus</a></li>
			  <li><a href="#tab_8" data-toggle="tab">[NOC] History</a></li>
			  <li><a href="#tab_5" data-toggle="tab">[TS] History</a></li>
			  <li><a href="#tab_9" data-toggle="tab">History Layanan</a></li>
			  <?php else: ?>
			  <li><a href="#tab_3" data-toggle="tab">Data MRTG</a></li>
			  <li><a href="#tab_4" data-toggle="tab">Data Perangkat</a></li>
			  <li><a href="#tab_6" data-toggle="tab">[Admin] WO Reguler</a></li>
			  <li><a href="#tab_7" data-toggle="tab">[Admin] WO Khusus</a></li>
			  <li><a href="#tab_8" data-toggle="tab">[NOC] History</a></li>
			  <li><a href="#tab_5" data-toggle="tab">[TS] History</a></li>
			  <li><a href="#tab_9" data-toggle="tab">History Layanan</a></li>
			  <?php endif; ?>
			  
            </ul>
			
            <div class="tab-content">
			<br />
              <div class="tab-pane active" id="tab_1">
               
			<?php
			date_default_timezone_set("Asia/Singapore");
			?>
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Brand</b>
                            </td><td>
                                 <?php if(isset($item['brand'])):?><?php echo isset($item['brand']) ? $item['brand'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tahun</b>
                            </td><td>
                             <?php if(isset($item['tahun'])):?><?php echo isset($item['tahun']) ? $item['tahun'] : ''; ?><?php echo isset($item['tahun']) ? $item['tahun'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Nama Pelanggan</b>
                            </td><td>
                               <?php echo isset($item['nama']) ? $item['nama'] : ''; ?> 
                            </td>
                        </tr><tr>
                            <td>
                                <b>Regional</b>
                            </td><td>
                               <?php echo isset($item) ? $item['region'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Area</b>
                            </td><td>
                               <?php echo isset($item) ? $item['area'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Level Prioritas</b>
                            </td><td>
                              <?php 
							  if(isset($item['admin_biaya_netprofit'])){
							  	if($item['admin_biaya_netprofit'] == 0){
								echo "-";
								}elseif($item['admin_biaya_netprofit'] >= 2000000){
								echo "REGULER";
								}elseif($item['admin_biaya_netprofit'] >= 2000001){
								echo "GOLD";
								}elseif($item['admin_biaya_netprofit'] >= 5000001){
								echo "PLATINUM";
								}elseif($item['admin_biaya_netprofit'] >= 10000000){
								echo "PRIORITAS";
								}
							  }else{
							  echo"-";
							  }
							  
							  ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Media Access</b>
                            </td><td>
                               <?php $media_id = $this->db->get_where('blip_mediaaccess', array('id' => $item['media']))->row_array(); ?>
				<?php if(isset($media_id['id'])):?><?php echo isset($media_id['id']) ? $media_id['media'] : ''; ?><?php else: ?>-<?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Produk</b>
                            </td><td>
                               <?php $produk_id = $this->db->get_where('blip_produk', array('id' => $item['produk']))->row_array(); ?>
				<?php if(isset($produk_id['produk'])):?><?php echo isset($produk_id['produk']) ? $produk_id['produk'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Divisi</b>
                            </td><td>
                               <?php if(isset($item['admin_divisi'])):?><?php echo isset($item['admin_divisi']) ? $item['admin_divisi'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Sales</b>
                            </td><td>
                               <?php $salesid = $this->db->get_where('blip_sales', array('id' => $item['admin_sales']))->row_array(); ?>
				<?php if(isset($salesid['id'])):?><?php echo isset($salesid) ? $salesid['nama'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Segment</b>
                            </td><td>
                               
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Sub Segment</b>
                            </td><td>
                               
                            </td>
                        </tr>
                    </tbody>
                </table>
			</div>
			
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>CID</b>
                            </td><td>
                                 <?php echo isset($item['cid']) ? $item['cid'] : '-'; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>SID</b>
                            </td><td>
                             <?php echo isset($item['sid']) ? $item['sid'] : '-'; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Alamat</b>
                            </td><td>
                               <?php echo isset($item['admin_alamat']) ? $item['admin_alamat'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Kordinat</b>
                            </td><td>
                             <?php echo isset($item['kordinat']) ? $item['kordinat'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Email</b>
                            </td><td>
                               <?php echo isset($item['email']) ? $item['email'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Kontak</b>
                            </td><td>
                              <?php echo isset($item['kontak']) ? $item['kontak'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>PIC</b>
                            </td><td>
                               <?php echo isset($item['pic']) ? $item['pic'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Form Langganan</b>
                            </td><td style="font-size:11px;">
                               <?php echo isset($item['admin_form_langganan']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_form_langganan'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td style="font-size:11px;">
                                <b>KTP</b>
                            </td><td>
                               <?php echo isset($item['admin_ktp_identitas']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_ktp_identitas'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td style="font-size:11px;">
                                <b>NPWP</b>
                            </td><td>
                              <?php echo isset($item['admin_npwp']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_npwp'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td style="font-size:11px;">
                                <b>Lampiran BAA</b>
                            </td><td>
                              <?php echo isset($item['admin_form_baa']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_form_baa'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						
                    </tbody>
                </table>	

			
			
			
			
			
			
			</div>
			
			
			
			</div>
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Tgl Req Sales</b>
                            </td><td>
                                 <?php echo isset($item['tgl_req_sales']) ? $item['tgl_req_sales'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tgl Req Teknis</b>
                            </td><td>
                             <?php echo isset($item['tgl_req_teknis']) ? $item['tgl_req_teknis'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tgl Pekerjaan Teknis</b>
                            </td><td>
                              <?php echo isset($item['tgl_aktivasi_teknis']) ? $item['tgl_aktivasi_teknis'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tgl Report Teknis</b>
                            </td><td>
                              <?php echo isset($item['tgl_report_teknis']) ? $item['tgl_report_teknis'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Terbit BAA</b>
                            </td><td>
                              <?php echo isset($item['tgl_terbit_baa']) ? $item['tgl_terbit_baa'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Req OB</b>
                            </td><td>
                              <?php echo isset($item['tgl_req_ob']) ? $item['tgl_req_ob'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Start OB</b>
                            </td><td>
                              <?php echo isset($item['tgl_start_ob']) ? $item['tgl_start_ob'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Terbit Invoice</b>
                            </td><td>
                               <?php echo isset($item['tgl_terbit_inv']) ? $item['tgl_terbit_inv'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl RFS</b>
                            </td><td>
                               <?php echo isset($item['tgl_rfs']) ? $item['tgl_rfs'] : ''; ?>
                            </td>
                        </tr>
						
						
                    </tbody>
                </table>	
			

			
			</div>
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'): ?>
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Biaya OTC</b>
                            </td><td>
                               <?php echo isset($item['admin_biaya_otc']) ? number_format($item['admin_biaya_otc'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Biaya Berlangganan</b>
                            </td><td>
                            <?php echo isset($item['admin_biaya_mtc']) ? number_format($item['admin_biaya_mtc'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Biaya Partner</b>
                            </td><td>
                             <?php echo isset($item['admin_biaya_partner']) ? number_format($item['admin_biaya_partner'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Biaya CB</b>
                            </td><td>
                              <?php echo isset($item['admin_biaya_cb']) ? number_format($item['admin_biaya_cb'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Net Profit</b>
                            </td><td>
                              <?php echo isset($item['admin_biaya_netprofit']) ? number_format($item['admin_biaya_netprofit'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr>
						
						
						
                    </tbody>
                </table>
				<br /><br />
				
				<?php  endif; ?>
				<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Keterangan</b>
                            </td><td>
                              <?php echo isset($item['keterangan']) ? $item['keterangan'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Klasifikasi Service</b>
                            </td><td><b>
                           <?php if(isset($item['klasifikasi_service'])){
						   if($item['klasifikasi_service'] == "0"){
						   echo "Bandwidth Only";}elseif($item['klasifikasi_service'] == "1"){
						   echo "Manage Only";}elseif($item['klasifikasi_service'] == "2"){
						   echo "Manage Service";}} 
						   ?></b>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Status Pelanggan</b>
                            </td><td><b>
                           <?php if(isset($item['status_pelanggan'])){
						   if($item['status_pelanggan'] == "0"){
						   echo "Tidak Aktif";}elseif($item['status_pelanggan'] == "1"){
						   echo "Aktif";}elseif($item['status_pelanggan'] == "2"){
						   echo "Isolir";}elseif($item['status_pelanggan'] == "3"){
						   echo "Dismantle";}} 
						   ?></b>
                            </td>
                        </tr>
						
						
						
                    </tbody>
                </table>		

			
			
			</div>
			</div>
<script type="text/javascript">
$(function () {
    var today = new Date();
	var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
	var time = today.getHours() + ":" + today.getMinutes();
	var dateTime = date+' '+time;
    $("#form_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });
});
</script>

<script type="text/javascript" src="<?php echo base_url().'static/assets/js/jquery.js'?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
             $('#cid').on('input',function(){
                 
                var cid=$(this).val();
                $.ajax({
                    type : "POST",
                    url  : "<?php echo base_url('manage/wo/get_pelanggan')?>",
                    dataType : "JSON",
                    data : {cid: cid},
                    cache:false,
                    success: function(data){
                        $.each(data,function(cid, nama, sid, bandwidth){
                            $('[name="nama"]').val(data.nama);
							$('[name="sid"]').val(data.sid);
                            $('[name="bandwidth"]').val(data.bandwidth);
 
                             
                        });
                         
                    }
                });
                return false;
           });
 
        });
    </script>
			   
			   
              </div>
			  <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <div class="col-md-12">
					<div class="table-responsive">
				   <table class="table table-bordered table-hover" id="example1">
			
						<thead>
			
							<tr>
								<th>Media</th>
								<th>Paket</th>
								<th>BW</th>
								<th>Vlan</th>
								<th>Network</th>
								<th>IP Addr</th>
								<th>PPPOE User</th>
								<th>PPPOE Passwd</th>
								<th>Ket.</th>
								<th>Role</th>
								<th>Layanan</th>
							</tr>
			
						</thead>
			
						<tbody>
			
							<?php foreach ($items_layanan as $detail_layanan): ?>
			
								<tr>
									<td>
										<?php $media_layanan = $this->db->get_where('blip_mediaaccess', array('id' => $detail_layanan['id_media']))->row_array(); ?>
										<?php if(isset($media_layanan['id'])):?><?php echo isset($media_layanan['id']) ? $media_layanan['media'] : ''; ?><?php else: ?>-<?php endif; ?>
									</td><td>
										<?php $produk_layanan = $this->db->get_where('blip_produk', array('id' => $detail_layanan['id_produk']))->row_array(); ?>
										<?php if(isset($produk_layanan['id'])):?><?php echo isset($produk_layanan['id']) ? $produk_layanan['produk'] : ''; ?><?php else: ?>-<?php endif; ?>
									</td><td>
									 <?php echo isset($detail_layanan['id_bandwidth']) ? $detail_layanan['id_bandwidth'] : ''; ?> Mbps
									</td><td>
										<?php echo isset($detail_layanan['vlan']) ? $detail_layanan['vlan'] : ''; ?>
									</td><td>
										<?php echo isset($detail_layanan['router_network']) ? $detail_layanan['router_network'] : ''; ?>
									</td><td>
										<?php echo isset($detail_layanan['router_ip']) ? $detail_layanan['router_ip'] : ''; ?>
									</td><td>
										<?php echo isset($detail_layanan['pppoe_user']) ? $detail_layanan['pppoe_user'] : ''; ?>
									</td><td>
										<?php echo isset($detail_layanan['pppoe_pass']) ? $detail_layanan['pppoe_pass'] : ''; ?>
									</td><td>
										<?php echo isset($detail_layanan['keterangan']) ? $detail_layanan['keterangan'] : ''; ?>
									</td><td>
										<?php if(isset($detail_layanan['id_role'])){
									   if($detail_layanan['id_role'] == "1"){
									   echo "Link Main";}else{
									   echo "Link Backup";}} 
									   ?>
									</td><td style="text-align:center">
										<?php if(isset($detail_layanan['id_status'])){
									   if($detail_layanan['id_status'] == "0"){
									   echo "<span class=\"label label-primary\">Tidak Aktif</span>";}else{
									   echo "<span class=\"label label-success\">Aktif</span>";}} 
									   ?>
									  <a href="<?php echo base_url('manage/data_pelanggan/'.$detail_layanan['id'].'/'.$item['id'].'/whatsapp'); ?>"><img src="<?php echo base_url('static/assets/img/wa.png'); ?>" width="25px" alt="Get Biger Image" title="Kirim ke Whatsapp Group" onclick="return confirm('Lanjutkan kirim ke Whatsapp Group?')"></a> <a href="<?php echo base_url('manage/data_pelanggan/'.$detail_layanan['id'].'/'.$item['id'].'/telegram'); ?>"><img src="<?php echo base_url('static/assets/img/tg.png'); ?>" width="25px" alt="Get Biger Image" title="Kirim ke Telegram Group" onclick="return confirm('Lanjutkan kirim ke Telegram Group?')"></a>
									</td>
								</tr>
			
							<?php endforeach; ?>
			
						</tbody>
			
					</table><br />
					</div>
				</div>
              </div>
			  
			  
			  <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                <div class="col-md-12">
					<div class="table-responsive">
				   <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
                    <th>Nama Pelanggan</th>	
					<th>Nama Perangkat</th>
					<th style="text-align:center" width="15%">Merk</th>
					<th style="text-align:center">Mac Address</th>
					<th style="text-align:center">Serial Number</th>
					<th style="text-align:center">Jumlah</th>
					<th style="text-align:center">Satuan</th>
					<th style="text-align:center">Alokasi</th>
                </tr>

            </thead>

            <tbody>

                
				<?php $data_perangkat = $this->db->get_where('blip_vas_data', array('id_pelanggan' => $item['id']))->result_array(); ?>	
 				<?php foreach ($data_perangkat as $perangkat): ?>
				<?php $data_merk = $this->db->get_where('blip_vas_spesifikasi', array('id' => $perangkat['id_perangkat']))->row_array(); ?>
                    <tr>
                        <td>
                            <?php echo $item['nama']; ?> 
                        </td><td>
                            <?php echo $data_merk['nama']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $data_merk['merk']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $perangkat['mac_address']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $perangkat['serial_number']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $perangkat['jumlah']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $perangkat['satuan']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $perangkat['alokasi']; ?> 
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table><br />
					</div>
				</div>
              </div>
			  
			   <!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_6">
                <div class="col-md-12">
				
				
				<table class="table table-bordered table-hover" id="example1" style="font-size:10px">

            <thead>

                <tr valign="middle">
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">CID</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">SID</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">Pelanggan</th>
					<th style="text-align:center; vertical-align:middle" width="15%">Request</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">KPI</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Pekerjaan <br />Teknis</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Report <br />Teknis</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Status</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">Tindakan</th>
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
                <?php foreach ($items_wo as $wo): ?>
                    <tr>
                         <td>
                            <?php echo $wo['cid']; ?>
                        </td> <td>
                            <?php echo $wo['sid']; ?>
                        </td><td>
                            <?php echo $wo['nama']; ?>
                        </td><td>
							<?php 
							$query_request = $this->db->get_where('blip_kpi', array('id' => $wo['request']));
           					$data_request = $query_request->row_array();
							echo $data_request['kegiatan']; 
							?>
                        </td> 
						<td style="text-align:center; font-weight:bold" width="8%">
                            <?php
							if($wo['tgl_report_teknis'] != NULL){
								$diff = selisih_waktu($item['tgl_req_teknis'], $wo['tgl_report_teknis']);
								if($diff['d'] <= $data_request['durasi']){
								echo "<span style=\"color:green\">&#9989; Tercapai</span>";
								}else {
								echo "<span style=\"color:red\">&#9745 Tidak Tercapai</span>";
								}
							}else{
								$dt = $wo['tgl_req_teknis'];
								$nyawa_tanggal =  date( "Y-M-d", strtotime("$dt +".$data_request['durasi']." day" ));
								$sisanyawa = date( "Y-M-d", strtotime("$nyawa_tanggal -".$data_request['durasi']." day" ));
								$diff = selisih_waktu(date("Y-m-d"),$nyawa_tanggal);
								echo $diff['d']." Hari";
							}
							 
							 ?>
                        </td><td>
                            <?php echo $wo['tgl_aktivasi_teknis']; ?>
                        </td><td>
                            <?php echo $wo['tgl_report_teknis']; ?>
                        </td>
						<td style="text-align:center" width="8%">
                                <span style="font-weight:bold">
								<?php 
								if($wo['status'] == "0"){echo "<span style=\"color: red\">&#9745 Baru</span>";}else{echo "<span style=\"color: green\">&#9989; Selesai</span>";} 
								?>
								</span>
                            </td>
						
						<td  style="text-align:center">
						
                            <a href="<?php echo base_url('manage/wo/' . $wo['id']); ?>" class="btn btn-xs btn-primary">
                                Detail
                            </a>
							<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'): ?>
							<a href="<?php echo base_url('manage/wo/' . $wo['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
							<?php endif; ?>
                        </td>
						
						
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
					
				</div>
              </div>
              <!-- /.tab-pane -->
			  
		<!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_7">
                <div class="col-md-12">
				
				
				<table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
                    <th>Pelanggan</th>	
					<th>Sales</th>
					<th>Kegiatan</th>
					<th>Sub Kegiatan</th>
					<th>Tgl Req Sales</th>
					<th>Dokumentasi</th>
					
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items_wo_khusus_admin as $wo_khusus): ?>
				<?php 
				$data_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $wo_khusus['id_pelanggan']))->row_array(); 
				?>
				<?php $data_sales= $this->db->get_where('blip_sales', array('id' => $wo_khusus['id_sales']))->row_array(); ?>
 				
                    <tr>
                        <td>
                            <?php echo $data_pelanggan['nama']; ?> 
                        </td><td>
                            <?php echo $data_sales['nama']; ?> 
                        </td><td>
                            <?php echo $wo_khusus['kegiatan']; ?> 
                        </td><td>
                            <?php echo $wo_khusus['sub_kegiatan']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $wo_khusus['tgl_req_sales']; ?> 
                        </td><td style="text-align:center">
                            <?php
							if(!empty($wo_khusus['link_dokumentasi'])){
								echo"<span color=\"blue\" title=\"Dokumentasi Terupload\">&#9989</span> <a target=\"_blank\" href=\" ".$wo_khusus['link_dokumentasi']."\">Link</a>";
								}
							?>
                        </td>
						</tr>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
					
				</div>
              </div>
              <!-- /.tab-pane -->	
			  
		<!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_8">
                <div class="col-md-12">
				
				
			 <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
					<th>Tiket</th>
                    <th>Lokasi</th>	
					<th>Kendala</th>
					<th>Ket.</th>
					<th>Action</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Status</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items_noc as $noc): ?>
				<?php 
				$data_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $noc['id_pelanggan']))->row_array(); 
				?>
 				
                    <tr>
                        <td>
                            <?php echo $noc['tiket']; ?> 
                        </td><td>
                            <?php 
							if($noc['id_pelanggan'] == 0){
							echo $noc['id_bts'];
							}else{
							echo $data_pelanggan['nama']; 
							}
							?> 
                        </td><td>
                            <?php echo $noc['kendala']; ?> 
                        </td><td>
                            <?php echo $noc['keterangan']; ?> 
                        </td><td>
                            <?php echo $noc['action']; ?> 
                        </td><td>
                            <?php echo $noc['waktu_mulai']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $noc['waktu_selesai']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $noc['status']; ?>  
                        </td>
						
						
						</tr>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
					
				</div>
              </div>
              <!-- /.tab-pane -->
		  
			  
		<!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_5">
                <div class="col-md-12">
				
				
			<table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
                    <th>Pelanggan</th>	
					<th>Nama Petugas</th>
					<th>Kegiatan</th>
					<th>Sub Kegiatan</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Status</th>
					<th>Ket.</th>
					<th>Dokumentasi</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items_spk as $spk): ?>
				<?php 
				$data_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $spk['id_pelanggan']))->row_array(); 
				?>
				<?php $data_petugas= $this->db->get_where('gm_operator', array('id' => $spk['id_petugas']))->row_array(); ?>
 				
                    <tr>
                        <td>
                            <?php echo $data_pelanggan['nama']; ?> 
                        </td><td>
                            <?php echo $data_petugas['nama']; ?> 
                        </td><td>
                            <?php echo $spk['kegiatan']; ?> 
                        </td><td>
                            <?php echo $spk['sub_kegiatan']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $spk['waktu_mulai']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $spk['waktu_selesai']; ?>  
                        </td><td style="text-align:center">
                            <?php echo $spk['status']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $spk['keterangan']; ?> 
                        </td><td style="text-align:center">
						<?php
						if(!empty($spk['link_dokumentasi'])){
								echo"<span color=\"blue\" title=\"Dokumentasi Terupload\">&#9989</span> <a target=\"_blank\" href=\" ".$spk['link_dokumentasi']."\">Link</a>";
							}
						?>
                            
                        </td>
						
						
						</tr>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
					
				</div>
              </div>
              <!-- /.tab-pane -->		
			  
			  
		<!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_9">
                <div class="col-md-12">
				
				
			<table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
					<th>Permintaan</th>
					<th>Pelanggan</th>
					<th>Layanan</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Bandwidth</th>
					<th style="text-align:center" width="10%">Status</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items_sch as $sch): ?>

                    <tr>
                        <td>
                            <?php if($sch['permintaan'] == "Free BOD +50%") { echo "Free BOD +50%"; } elseif($sch['permintaan'] == "Free BOD +100%") { echo "Free BOD +100%"; } elseif($sch['permintaan'] == "BOD Berbayar") { echo "BOD Berbayar"; } else {echo $sch['permintaan'];}?>
                        </td><td>
                            <?php $pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $sch['id_pelanggan']))->row_array(); echo $pelanggan['nama']; ?>
                        </td><td>
                            <?php $layanan = $this->db->get_where('blip_layanan', array('id' => $sch['id_layanan']))->row_array(); ?>
							<?php $produk = $this->db->get_where('blip_produk', array('id' => $layanan['id_produk']))->row_array(); echo $produk['produk']; ?>
                        </td><td>
                            <?php echo $sch['mulai']; ?>
                        </td><td align="center">
                            <?php if($sch['selesai'] != NULL) {echo $sch['selesai'];}else{echo "-";} ?>
                        </td><td align="center">
                            <?php if($sch['bw'] != NULL) {echo $sch['bw'];}else{echo "-";} ?>
                        </td><td style="text-align:center">
                            <?php 
							if($sch['status'] == "0") {echo"<span style=\"color:orange; font-weight:bold\">Menunggu</span>";} elseif($sch['status'] == "2") {echo"<span style=\"color:blue; font-weight:bold\">Berlangsung</span>";}else{echo"<span style=\"color:green; font-weight:bold\">Selesai</span>";}
							?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
					
				</div>
              </div>
              <!-- /.tab-pane -->	  
             
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3'): ?>
                <div class="col-md-6">
				<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>POP</b>
                            </td><td>
                               <?php if(isset($item['pop'])):?>
							   <?php $pop = $this->db->get_where('gm_pop', array('pop' => $item['pop']))->row_array(); echo $pop['pop']; ?>	
								<?php endif; ?>
							   
                            </td>
                        </tr>
						
						
						<tr>
                            <td>
                                <b>User Router</b>
                            </td><td>
                             <?php echo isset($router_user) ? $router_user : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Password Router</b>
                            </td><td>
                          <?php echo isset($router_pass) ? $router_pass : ''; ?>
                            </td>
                        </tr>
						
                    </tbody>
                </table>
	

			</div>
<?php endif; ?>
				
				<div class="col-md-6">
				<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
						<tr>
                            <td>
                                <b>IP Address</b>
                            </td><td>
                       <?php $ipaddr = $this->db->get_where('blip_layanan', array('id_pelanggan' => $item['id']))->row_array(); echo $ipaddr['router_network']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>MRTG User</b>
                            </td><td>
                         <?php echo isset($item['teknis_mrtg_user']) ? $item['teknis_mrtg_user'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>MRTG Password</b>
                            </td><td>
                         <?php echo isset($item['teknis_mrtg_pass']) ? $item['teknis_mrtg_pass'] : ''; ?>
                            </td>
                        </tr>	
						
                    </tbody>
                </table>
				
				</div>
				
				
				
              </div>
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        <!-- /.col -->



            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="javascript:history.go(-1)" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                   
                </div>
            </div>


    </div>

</div>

<!-- END PANEL HEADLINE -->


<script type="text/javascript">
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));


// Install input filters.
$("#intTextBox").inputFilter(function(value) {
  return /^-?\d*$/.test(value); });
$("#uintTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$("#intLimitTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
$("#floatTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d*$/.test(value); });
$("#currencyTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });
$("#latinTextBox").inputFilter(function(value) {
  return /^[a-z]*$/i.test(value); });
$("#hexTextBox").inputFilter(function(value) {
  return /^[0-9a-f]*$/i.test(value); });
</script>
<!-- END PANEL HEADLINE -->