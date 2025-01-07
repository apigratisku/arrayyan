 <?php 
if(isset($item['router_user'])){
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

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA PELANGGAN</div>

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

        <?php
        if (isset($item['id'])) {
            echo form_open_multipart('manage/data_pelanggan/' . $item['id'] . '/timpa');
        } else {
            echo form_open_multipart('manage/data_pelanggan/simpan');
        }
        ?>
		

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
			<?php if($this->session->userdata('ses_admin')=='1'): ?>
			  <li class="active"><a href="#tab_1" data-toggle="tab">Data Admin</a></li>
			  <li><a href="#tab_2" data-toggle="tab">Data Layanan</a></li> 
			  <li><a href="#tab_3" data-toggle="tab">Data Teknis</a></li>
			  <li><a href="#tab_6" data-toggle="tab">[Admin] WO Reguler</a></li>
			  <?php elseif($this->session->userdata('ses_admin')=='3'): ?>
			  <li class="active"><a href="#tab_2" data-toggle="tab">Data Layanan</a></li> 
			  <li><a href="#tab_3" data-toggle="tab">Data Teknis</a></li>
			  <?php elseif($this->session->userdata('ses_admin')=='4'): ?>
			  <li class="active"><a href="#tab_1" data-toggle="tab">Data Admin</a></li>
			  <li><a href="#tab_2" data-toggle="tab">Data Layanan</a></li> 
			  <li><a href="#tab_6" data-toggle="tab">[Admin] WO Reguler</a></li>
			  <?php elseif($this->session->userdata('ses_admin')=='5'): ?>
			  <li class="active"><a href="#tab_1" data-toggle="tab">Data Admin</a></li>
			  <li><a href="#tab_2" data-toggle="tab">Data Layanan</a></li> 
			  <li><a href="#tab_3" data-toggle="tab">Data Teknis</a></li>
			  <?php endif; ?>
			  
			  
            </ul>
            <div class="tab-content">
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'): ?>
              <div class="tab-pane active" id="tab_1">
             <?php else: ?>
			 <div class="tab-pane" id="tab_1">
			 <?php endif; ?>
			<?php
			date_default_timezone_set("Asia/Singapore");
			?>
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Brand</label>
                 <select class="form-control" id="brand" name="brand" required>								
				<option value="">-Brand-</option>
				<option value="BLiP" <?php if(isset($item['brand'])){if($item['brand'] == "BLiP"){echo "selected";}} ?>>BLiP</option>
				<option value="GMEDIA" <?php if(isset($item['brand'])){if($item['brand'] == "GMEDIA"){echo "selected";}} ?>>GMEDIA</option>
				<option value="FIBERSTREAM" <?php if(isset($item['brand'])){if($item['brand'] == "FIBERSTREAM"){echo "selected";}} ?>>FIBERSTREAM</option>

				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($item['nama']) ? $item['nama'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Cabang</label>
                 <select class="form-control" id="region" name="region" required>								
				<option value="NTB" <?php if(isset($item['region'])){if($item['region'] == "NTB"){echo "selected";}} ?>>NTB</option>
				<option value="BALI" <?php if(isset($item['region'])){if($item['region'] == "BALI"){echo "selected";}} ?>>BALI</option>
				<option value="SURABAYA" <?php if(isset($item['region'])){if($item['region'] == "SURABAYA"){echo "selected";}} ?>>SURABAYA</option>
				<option value="MALANG" <?php if(isset($item['region'])){if($item['region'] == "MALANG"){echo "selected";}} ?>>MALANG</option>
				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Area</label>
                 <select class="form-control" id="area" name="area">								
				<option value="">- Area -</option>
<?php if(isset($item['area'])):?><option value="<?php echo isset($item) ? $item['area'] : ''; ?>" selected><?php echo isset($item) ? $item['area'] : ''; ?></option><?php endif; ?>
				<option value="MATARAM">MATARAM</option>
				<option value="LOMBOK BARAT">LOMBOK BARAT</option>
				<option value="LOMBOK TENGAH">LOMBOK TENGAH</option>
				<option value="LOMBOK TIMUR">LOMBOK TIMUR</option>
				<option value="LOMBOK UTARA">LOMBOK UTARA</option>
				<option value="GILI TRAWANGAN">GILI TRAWANGAN</option>
				<option value="GILI AIR">GILI AIR</option>
				<option value="GILI MENO">GILI MENO</option>
				<option value="SUMBAWA">SUMBAWA</option>
				<option value="DOMPU">DOMPU</option>
				<option value="BALI">BALI</option>
				<option value="SURABAYA">SURABAYA</option>
				<option value="MALANG">MALANG</option>
				</select>
            </div>

			

			
			<div class="form-group">
                <label for="nama_keahlian">Divisi</label>
                 <select class="form-control" id="admin_divisi" name="admin_divisi" required>	
				<?php $sales_divisi = $this->db->get_where('blip_pelanggan', array('admin_divisi' => $item['admin_divisi']))->row_array(); ?>							
				<option value="CE" <?php if($sales_divisi == "CE"){echo "selected";} ?>>CE</option>
				<option value="SALES" <?php if($sales_divisi == "SALES"){echo "selected";} ?>>SALES</option>

				</select>
            </div>
			<div class="form-group">
				<label for="level">Sales</label>
				<select class="form-control" id="admin_sales" name="admin_sales">
				<?php $salesid = $this->db->get_where('blip_sales', array('id' => $item['admin_sales']))->row_array(); ?>
				<?php if(isset($salesid['id'])):?><option value="<?php echo isset($salesid['id']) ? $salesid['id'] : ''; ?>" selected><?php echo isset($salesid) ? $salesid['nama'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_admin_sales as $admin_sales): ?>
				<option value="<?php echo $admin_sales['id']; ?>"><?php echo $admin_sales['nama']; ?></option>
				
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level">Segment</label>
				<select class="form-control" id="admin_segment" name="admin_segment">
				<?php foreach ($items_admin_segment as $admin_segment): ?>
				<option value="<?php echo $admin_segment['id']; ?>"><?php echo $admin_segment['nama']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level">Sub Segment</label>
				<select class="form-control" id="admin_subsegment" name="admin_subsegment">
				<?php foreach ($items_admin_subsegment as $admin_subsegment): ?>
				<option value="<?php echo $admin_subsegment['id']; ?>"><?php echo $admin_subsegment['nama']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>	
			
			</div>
			
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			
			<div class="form-group">
                <label for="nama_keahlian">CID</label>
                <input type="text" class="form-control" id="cid" name="cid" value="<?php echo isset($item['cid']) ? $item['cid'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">SID</label>
                <input type="text" class="form-control" id="sid" name="sid" value="<?php echo isset($item['sid']) ? $item['sid'] : ''; ?>"  autofocus>
            </div>
			
			
			<div class="form-group">
                <label for="nama_keahlian">Alamat</label>
                <input type="text" class="form-control" id="admin_alamat" name="admin_alamat" value="<?php echo isset($item['admin_alamat']) ? $item['admin_alamat'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($item['email']) ? $item['email'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Kontak</label>
                <input type="number" placeholder="Contoh: 6282144619515" class="form-control" id="kontak" name="kontak" value="<?php echo isset($item['kontak']) ? $item['kontak'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">PIC</label>
                <input type="text" class="form-control" id="pic" name="pic" value="<?php echo isset($item['pic']) ? $item['pic'] : ''; ?>"  autofocus>
            </div>
			
			<div class="form-group" id="form">
                        <label for="foto">Form Langganan 
						<?php
							if(!empty($item['admin_form_langganan'])){
								echo"<span color=\"blue\" title=\"Attachment Terupload\">&#9989</span>";
							}
							?>
						</label>
                        <input type="file" class="form-control" id="admin_form_langganan" name="admin_form_langganan">			
            </div>
			<div class="form-group" id="ktp">
                        <label for="foto">KTP 
						<?php
							if(!empty($item['admin_ktp_identitas'])){
								echo"<span color=\"blue\" title=\"Attachment Terupload\">&#9989</span>";
							}
							?>
						</label>
                        <input type="file" class="form-control" id="admin_ktp_identitas" name="admin_ktp_identitas">			
            </div>
			<div class="form-group" id="npwp">
                        <label for="foto">NPWP 
						<?php
							if(!empty($item['admin_npwp'])){
								echo"<span color=\"blue\" title=\"Attachment Terupload\">&#9989</span>";
							}
							?>
						</label>
                        <input type="file" class="form-control" id="admin_npwp" name="admin_npwp">
            </div>
			
			
			<div class="form-group" id="admin_form_baa">
                        <label for="foto">Lampiran BAA 
							<?php
							if(!empty($item['admin_form_baa'])){
								echo"<span color=\"blue\" title=\"Attachment Terupload\">&#9989</span>";
							}
							?>
							</label>
                        <input type="file" class="form-control" id="admin_form_baa" name="admin_form_baa">
            </div>
			
			</div>
			
			
			
			</div>
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Tgl Req Sales</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_req_sales" name="tgl_req_sales" width="50%"  value="<?php echo isset($item['tgl_req_sales']) ? $item['tgl_req_sales'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_req_sales").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Req Teknis</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_req_teknis" name="tgl_req_teknis" width="50%"  value="<?php echo isset($item['tgl_req_teknis']) ? $item['tgl_req_teknis'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_req_teknis").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			 <div class="form-group">
                <label for="nama_keahlian">Tgl Aktivasi Teknis</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_aktivasi_teknis" name="tgl_aktivasi_teknis" width="50%"  value="<?php echo isset($item['tgl_aktivasi_teknis']) ? $item['tgl_aktivasi_teknis'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_aktivasi_teknis").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Report Teknis</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_report_teknis" name="tgl_report_teknis" width="50%"  value="<?php echo isset($item['tgl_report_teknis']) ? $item['tgl_report_teknis'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_report_teknis").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Terbit BAA</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_terbit_baa" name="tgl_terbit_baa" width="50%"  value="<?php echo isset($item['tgl_terbit_baa']) ? $item['tgl_terbit_baa'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_terbit_baa").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Req OB</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_req_ob" name="tgl_req_ob" width="50%"  value="<?php echo isset($item['tgl_req_ob']) ? $item['tgl_req_ob'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_req_ob").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Start OB</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_start_ob" name="tgl_start_ob" width="50%"  value="<?php echo isset($item['tgl_start_ob']) ? $item['tgl_start_ob'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_start_ob").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Terbit Invoice</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_terbit_inv" name="tgl_terbit_inv" width="50%"  value="<?php echo isset($item['tgl_terbit_inv']) ? $item['tgl_terbit_inv'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_terbit_inv").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl RFS</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_rfs" name="tgl_rfs" width="50%"  value="<?php echo isset($item['tgl_rfs']) ? $item['tgl_rfs'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_rfs").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			
			</div>
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'): ?>
			<div class="form-group">
                <label for="nama_keahlian">Biaya OTC</label>
                <input type="number" class="form-control" id="admin_biaya_otc" name="admin_biaya_otc" value="<?php echo isset($item['admin_biaya_otc']) ? $item['admin_biaya_otc'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Biaya Berlangganan</label>
                <input type="number"  class="form-control" id="admin_biaya_mtc" name="admin_biaya_mtc" value="<?php echo isset($item['admin_biaya_mtc']) ? $item['admin_biaya_mtc'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Biaya Partner</label>
                <input type="number"  class="form-control" id="admin_biaya_partner" name="admin_biaya_partner" value="<?php echo isset($item['admin_biaya_partner']) ? $item['admin_biaya_partner'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Biaya CB</label>
                <input type="number"  class="form-control" id="admin_biaya_cb" name="admin_biaya_cb" value="<?php echo isset($item['admin_biaya_cb']) ? $item['admin_biaya_cb'] : ''; ?>"  autofocus>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian">Net Profit</label>: Rp <?php echo isset($item['admin_biaya_netprofit']) ? number_format($item['admin_biaya_netprofit'], 0, ",", ".") : ''; ?>
                
            </div>
			<?php endif; ?>
			
			
			
			<div class="form-group">
                <label for="nama_keahlian">Kordinat</label>
                <input placeholder="Contoh: https://goo.gl/maps/9znQoeWy3dV3kW7C7" type="text" class="form-control" id="kordinat" name="kordinat" value="<?php echo isset($item['kordinat']) ? $item['kordinat'] : ''; ?>" autofocus>
            </div>
			
			
			<div class="form-group">
                <label for="nama_keahlian">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo isset($item['keterangan']) ? $item['keterangan'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tahun</label>
                 <select class="form-control" id="tahun" name="tahun">	
				 <option value="">-Tahun-</option>	
				 <?php if(isset($item['tahun'])):?><option value="<?php echo isset($item['tahun']) ? $item['tahun'] : ''; ?>" selected><?php echo isset($item['tahun']) ? $item['tahun'] : ''; ?></option><?php endif; ?>				
				 <?php for($thn = 2015; $thn<=date("Y"); $thn++): ?>
				<option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
				<?php endfor; ?>

				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian">Status Service</label>
                 <select class="form-control" id="klasifikasi_service" name="klasifikasi_service" required>					
				<option value="0" <?php if(isset($item['klasifikasi_service'])){if($item['klasifikasi_service'] == "0"){echo "selected";}} ?>>Bandwidth Only</option>
				<option value="1" <?php if(isset($item['klasifikasi_service'])){if($item['klasifikasi_service'] == "1"){echo "selected";}} ?>>Manage Only</option>
				<option value="2" <?php if(isset($item['klasifikasi_service'])){if($item['klasifikasi_service'] == "2"){echo "selected";}} ?>>Manage Service</option>
				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian">Status Pelanggan</label>
                 <select class="form-control" id="status_pelanggan" name="status_pelanggan" required>					
				<option value="0" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "0"){echo "selected";}} ?>>Tidak Aktif</option>
				<option value="1" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "1"){echo "selected";}} ?>>Aktif</option>
				<option value="2" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "2"){echo "selected";}} ?>>Isolir</option>
				<option value="3" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "3"){echo "selected";}} ?>>Dismantle</option>

				</select>
            </div>
			
			
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
			  <?php if($this->session->userdata('ses_admin')=='3'): ?>
			  <div class="tab-pane active" id="tab_2">
			  <?php else: ?>
			  <div class="tab-pane" id="tab_2">
			  <?php endif; ?>
                <div class="col-md-12">
				
				
				<div class="panel-heading">
				   <div class="box-footer">
						<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'):?>
						
							<a href="<?php echo isset($item['id']) ? base_url('manage/data_pelanggan/' . $item['id'] . '/layanan_tambah') : ''; ?>" class="btn btn-primary pull-right" <?php echo isset($item['id']) ? '' : "onclick=\"return alert('Silahkan tambah data pelanggan terlebih dahulu.')\""; ?>><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
						 <?php endif; ?>
					</div>
				</div>
					
					<div class="table-responsive">
				   <table class="table table-bordered table-hover" id="example1">
			
						<thead>
			
							<tr>
								<th>Media Access</th>
								<th>Paket</th>
								<th>Bandwidth</th>
								<th>Vlan</th>
								<th>Network</th>
								<th>IP Address</th>
								<th>PPPOE User</th>
								<th>PPPOE Password</th>
								<th>Status Role</th>
								<th>Status Layanan</th>
								<th style="text-align:center" nowrap="nowrap">Tindakan</th>
							</tr>
			
						</thead>
			
						<tbody>
							<?php if(isset($item['id'])): ?>
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
										<?php if(isset($detail_layanan['id_role'])){
									   if($detail_layanan['id_role'] == "1"){
									   echo "Link Main";}else{
									   echo "Link Backup";}} 
									   ?>
									</td><td>
										<?php if(isset($detail_layanan['id_status'])){
									   if($detail_layanan['id_status'] == "0"){
									   echo "Tidak Aktif";}else{
									   echo "Aktif";}} 
									   ?>
									  
									</td><td  style="text-align:center">
										<a href="<?php echo base_url('manage/data_pelanggan/' . $detail_layanan['id'] . '/' . $detail_layanan['id_pelanggan'] . '/layanan_ubah'); ?>" class="btn btn-xs btn-warning">
											Ubah
										</a>
										<a href="<?php echo base_url('manage/data_pelanggan/' . $detail_layanan['id'] . '/layanan_hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
											Hapus
										</a>
									</td>
								</tr>
			
							<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
			
					</table><br />
					</div>
					
				</div>
              </div>
             
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <div class="col-md-6">
					<div class="form-group">
						<label for="bts">POP</label>
						<select class="form-control" id="pop" name="pop">	
						<option value="">-POP-</option>
						<?php if(isset($item['pop'])):?>							
						<option value="<?php echo isset($item['pop']) ? $item['pop'] : ''; ?>" selected><?php $pop = $this->db->get_where('gm_pop', array('pop' => $item['pop']))->row_array(); echo $pop['pop']; ?></option>	
						<?php endif; ?>
						<?php foreach ($pop_items as $pop): ?>
						<option value="<?php echo $pop['pop'] ?>"><?php echo $pop['pop'] ?></option>	
						<?php endforeach; ?>
						</select>
					</div>
					
					<div class="form-group">
					<label for="nama_keahlian">User Router</label>
					<input type="text" class="form-control" id="router_user" name="router_user" value="<?php echo isset($router_user) ? $router_user : ''; ?>" autofocus>
					</div>
					<div class="form-group">
					<label for="nama_keahlian">Password Router</label>
					<input type="password" class="form-control" id="router_pass" name="router_pass" value="<?php echo isset($router_pass) ? $router_pass : ''; ?>" autofocus>
					</div>
				</div>
				
				<div class="col-md-6">
				
					<div class="form-group">
					<label for="nama_keahlian">MRTG User</label>
					<input type="text" class="form-control" id="teknis_mrtg_user" name="teknis_mrtg_user" value="<?php echo isset($item['teknis_mrtg_user']) ? $item['teknis_mrtg_user'] : ''; ?>" autofocus>
					</div>
					<div class="form-group">
					<label for="nama_keahlian">MRTG Password</label>
					<input type="text" class="form-control" id="teknis_mrtg_pass" name="teknis_mrtg_pass" value="<?php echo isset($item['teknis_mrtg_pass']) ? $item['teknis_mrtg_pass'] : ''; ?>" autofocus>
					</div>
			
				</div>
				
				
              </div>
             <!-- /.tab-pane -->
			   
			  
			  
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
							<a href="<?php echo base_url('manage/wo/' . $wo['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                        </td>
						
                    </tr>

                <?php endforeach; ?>

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
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

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