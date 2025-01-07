<?php
date_default_timezone_set("Asia/Singapore");
?>
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">ADMIN  - WO (WORK ORDER)</div>
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

        <?php
        if (isset($item['id'])) {
            echo form_open_multipart('manage/wo/' . $item['id'] . '/timpa');
        } else {
            echo form_open_multipart('manage/wo/simpan');
        }
        ?>
			
			
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			
			<?php if($title != "Ubah Data"): ?>
			
			<?php if (!isset($item['id'])): ?>
			<div class="form-group">
				<input class="form-check-input" id="check_pel" type="checkbox" name="check_pel" value="existing">
				<label class="form-check-label" for="flexCheckDefault">
					Pelanggan Existing.
				</label>
			</div>
			<?php else: ?>
				<input class="form-check-input" id="check_pel" type="checkbox" name="check_pel" value="">
			<?php endif; ?>
			
			<div class="form-group">
				<input class="form-check-input" id="check_data_survey" type="checkbox" name="check_data_survey" value="">
				<label class="form-check-label" for="flexCheckDefault">
					Ambil data survey.
				</label>
			</div>	
			<?php endif; ?>
					
			<div class="form-group" id="nama_new">
                <label for="nama_keahlian">Nama Pelanggan</label>
                <input type="text" class="form-control" id="input_nama_new" name="input_nama_new" value="<?php echo isset($item) ? $item['nama'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group" id="nama_exist">
                <label for="nama_keahlian">Nama Pelanggan</label><br />
                 <select class="form-control" id="input_nama_exist" name="input_nama_exist" style="width:100%" onChange="top.location.href = this.form.input_nama_exist.options[this.form.input_nama_exist.selectedIndex].value;
return false;">								
				<?php foreach ($items_pelanggan as $pelanggan): ?>
				<?php 
					if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";$disabled="";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
				?>
				<option value="<?php echo base_url('manage/wo/'.$pelanggan['id'].'/existing'); ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			<div class="form-group" id="nama_survey">
                <label for="nama_keahlian">Nama Pelanggan</label><br />
                 <select class="form-control" id="input_nama_survey" name="input_nama_survey" style="width:100%" onChange="top.location.href = this.form.input_nama_survey.options[this.form.input_nama_survey.selectedIndex].value;
return false;">					
				<option value="">--- Pilih Data ---</option>			
				<?php foreach ($items_survey as $survey): ?>
				
				<option value="<?php echo base_url('manage/wo/'.$survey['id'].'/survey'); ?>"><?php echo $survey['nama']; ?></option>
				<?php endforeach; ?>

				</select>
            </div>

			<div class="form-group" id="brand">
                <label  id="label_brand">Brand</label>
                 <select class="form-control" id="brand" name="brand" required>								
				<option value="">-Brand-</option>
				<option value="BLiP" <?php if(isset($item['brand'])){if($item['brand'] == "BLiP"){echo "selected";}} ?>>BLiP</option>
				<option value="GMEDIA" <?php if(isset($item['brand'])){if($item['brand'] == "GMEDIA"){echo "selected";}} ?>>GMEDIA</option>
				<option value="FIBERSTREAM" <?php if(isset($item['brand'])){if($item['brand'] == "FIBERSTREAM"){echo "selected";}} ?>>FIBERSTREAM</option>

				</select>
            </div>
			<div class="form-group" id="cabang">
                <label  id="label_cabang">Cabang</label>
                 <select class="form-control" id="region" name="region" required>								
				<option value="NTB" <?php if(isset($item['region'])){if($item['region'] == "NTB"){echo "selected";}} ?>>NTB</option>
				<option value="BALI" <?php if(isset($item['region'])){if($item['region'] == "BALI"){echo "selected";}} ?>>BALI</option>
				<option value="SURABAYA" <?php if(isset($item['region'])){if($item['region'] == "SURABAYA"){echo "selected";}} ?>>SURABAYA</option>
				<option value="MALANG" <?php if(isset($item['region'])){if($item['region'] == "MALANG"){echo "selected";}} ?>>MALANG</option>
				</select>

				</select>
            </div>
			<div class="form-group" id="area">
                <label id="label_area">Area</label>
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
				<option value="BIMA">BIMA</option>
				<option value="BALI">BALI</option>
				<option value="SURABAYA">SURABAYA</option>
				<option value="MALANG">MALANG</option>
				<option value="SEMARANG">SEMARANG</option>
				</select>
            </div>
			
			<div class="form-group">
				<label for="level">Request</label>
				<select class="form-control" id="request" name="request">
				<?php $sreq_id = $this->db->get_where('blip_kpi', array('id' => $item['request']))->row_array(); ?>
				<?php $req_id = $this->db->get_where('blip_kpi_induk', array('id' => $sreq_id['klasifikasi']))->row_array(); ?>
				<?php if(isset($req_id['id'])):?><option value="<?php echo isset($req_id['id']) ? $req_id['id'] : ''; ?>" selected><?php echo isset($req_id['id']) ? $req_id['kegiatan'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_kpi_induk as $kpi_induk): ?>
				<option value="<?php echo $kpi_induk['id']; ?>"><?php echo $kpi_induk['kegiatan']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>	

			<div class="form-group">
				<label for="level">Sub Request</label>
				<select class="form-control" id="sub_request" name="sub_request">
				<?php $subreq_id = $this->db->get_where('blip_kpi', array('id' => $item['request']))->row_array(); ?>
				<?php if(isset($subreq_id['id'])):?><option value="<?php echo isset($subreq_id['id']) ? $subreq_id['id'] : ''; ?>" selected><?php echo isset($subreq_id['id']) ? $subreq_id['kegiatan'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_kpi as $kpi): ?>
				<option value="<?php echo $kpi['id']; ?>"><?php echo $kpi['kegiatan']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>	
			<div class="form-group">
				<label for="level" id="label_media">Media Access</label>
				<select class="form-control" id="media" name="media">
				<option value="">- Media Access -</option>
				<?php $media_id = $this->db->get_where('blip_mediaaccess', array('id' => $item['media']))->row_array(); ?>
				<?php if(isset($media_id['id'])):?><option value="<?php echo isset($media_id['id']) ? $media_id['id'] : ''; ?>" selected><?php echo isset($media_id['id']) ? $media_id['media'] : ''; ?></option><?php endif; ?>

				<?php foreach ($items_media as $media): ?>
				<option value="<?php echo $media['id']; ?>"><?php echo $media['media']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level">Produk 1</label>
				<select class="form-control" id="produk1" name="produk1">
				<option value="">- Produk 2-</option>
				<?php $produk_id = $this->db->get_where('blip_produk', array('id' => $item['produk1']))->row_array(); ?>
				<?php if(isset($produk_id['produk'])):?><option value="<?php echo isset($produk_id['id']) ? $produk_id['id'] : ''; ?>" selected><?php echo isset($produk_id['produk']) ? $produk_id['produk'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_admin_produk as $produk): ?>
				<option value="<?php echo $produk['id']; ?>"><?php echo $produk['produk']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level">Produk 2</label>
				<select class="form-control" id="produk2" name="produk2">
				<option value="">- Produk 2-</option>
				<?php $produk_id = $this->db->get_where('blip_produk', array('id' => $item['produk2']))->row_array(); ?>
				<?php if(isset($produk_id['produk'])):?><option value="<?php echo isset($produk_id['id']) ? $produk_id['id'] : ''; ?>" selected><?php echo isset($produk_id['produk']) ? $produk_id['produk'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_admin_produk as $produk): ?>
				<option value="<?php echo $produk['id']; ?>"><?php echo $produk['produk']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
                <label for="nama_keahlian">Bandwidth Produk 1</label>
                <input type="number" class="form-control" id="bandwidth1" name="bandwidth1" value="<?php echo isset($item) ? $item['bandwidth1'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Bandwidth Produk 2</label>
                <input type="number" class="form-control" id="bandwidth2" name="bandwidth2" value="<?php echo isset($item) ? $item['bandwidth2'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label  id="label_divisi">Divisi</label>
                 <select class="form-control" id="admin_divisi" name="admin_divisi" required>	
				<?php $sales_divisi = $this->db->get_where('blip_pelanggan', array('admin_divisi' => $item['admin_divisi']))->row_array(); ?>							
				<option value="CE" <?php if($sales_divisi == "CE"){echo "selected";} ?>>CE</option>
				<option value="SALES" <?php if($sales_divisi == "SALES"){echo "selected";} ?>>SALES</option>

				</select>
            </div>
			
			
			
			</div>
			
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			<div class="form-group">
				<label  id="label_sales">Sales</label>
				<select class="form-control" id="admin_sales" name="admin_sales">
				<?php $salesid = $this->db->get_where('blip_sales', array('id' => $item['admin_sales']))->row_array(); ?>
				<?php if(isset($salesid['id'])):?><option value="<?php echo isset($salesid['id']) ? $salesid['id'] : ''; ?>" selected><?php echo isset($salesid) ? $salesid['nama'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_admin_sales as $admin_sales): ?>
				<option value="<?php echo $admin_sales['id']; ?>"><?php echo $admin_sales['nama']; ?></option>
				
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level" id="label_segment">Segment</label>
				<select class="form-control" id="admin_segment" name="admin_segment">
				<?php foreach ($items_admin_segment as $admin_segment): ?>
				<option value="<?php echo $admin_segment['id']; ?>"><?php echo $admin_segment['nama']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level" id="label_subsegment">Sub Segment</label>
				<select class="form-control" id="admin_subsegment" name="admin_subsegment">
				<?php foreach ($items_admin_subsegment as $admin_subsegment): ?>
				<option value="<?php echo $admin_subsegment['id']; ?>"><?php echo $admin_subsegment['nama']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>	
			<div class="form-group" id="cid">
                <label for="nama_keahlian">CID</label>
                <input type="text" class="form-control" id="cid" name="cid" value="<?php echo isset($item) ? $item['cid'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group" id="sid">
                <label for="nama_keahlian">SID</label>
                <input type="text" class="form-control" id="sid" name="sid" value="<?php echo isset($item) ? $item['sid'] : ''; ?>"  autofocus>
            </div>
			
			
			<div class="form-group" id="alamat">
                <label for="nama_keahlian">Alamat</label>
                <input type="text" class="form-control" id="admin_alamat" name="admin_alamat" value="<?php echo isset($item['admin_alamat']) ? $item['admin_alamat'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group" id="email">
                <label for="nama_keahlian">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($item) ? $item['email'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group" id="kontak">
                <label for="nama_keahlian">Kontak</label>
                <input type="number" placeholder="Contoh: 6282144619515" class="form-control" id="kontak" name="kontak" value="<?php echo isset($item) ? $item['kontak'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group" id="pic">
                <label for="nama_keahlian">PIC</label>
                <input type="text" class="form-control" id="pic" name="pic" value="<?php echo isset($item) ? $item['pic'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_req_sales" name="tgl_req_sales" width="50%"  value="<?php echo isset($item) ? $item['tgl_req_sales'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_req_teknis" name="tgl_req_teknis" width="50%"  value="<?php echo isset($item) ? $item['tgl_req_teknis'] : ''; ?>"  autofocus>
				<script type="text/javascript">
				$("#tgl_req_teknis").datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true
				});
				</script>
                </div>
            </div>
			 <div class="form-group">
                <label for="nama_keahlian">Tgl Pekerjaan Teknis</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_aktivasi_teknis" name="tgl_aktivasi_teknis" width="50%"  value="<?php echo isset($item) ? $item['tgl_aktivasi_teknis'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_report_teknis" name="tgl_report_teknis" width="50%"  value="<?php echo isset($item) ? $item['tgl_report_teknis'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_terbit_baa" name="tgl_terbit_baa" width="50%"  value="<?php echo isset($item) ? $item['tgl_terbit_baa'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_req_ob" name="tgl_req_ob" width="50%"  value="<?php echo isset($item) ? $item['tgl_req_ob'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_start_ob" name="tgl_start_ob" width="50%"  value="<?php echo isset($item) ? $item['tgl_start_ob'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_terbit_inv" name="tgl_terbit_inv" width="50%"  value="<?php echo isset($item) ? $item['tgl_terbit_inv'] : ''; ?>"  autofocus>
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
                  <input type="text"  class="form-control datetimepicker-alt" id="tgl_rfs" name="tgl_rfs" width="50%"  value="<?php echo isset($item) ? $item['tgl_rfs'] : ''; ?>"  autofocus>
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
			<div class="form-group">
                <label for="nama_keahlian">Biaya OTC</label>
                <input type="number" class="form-control" id="admin_biaya_otc" name="admin_biaya_otc" value="<?php echo isset($item) ? $item['admin_biaya_otc'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Biaya Berlangganan</label>
                <input type="number"  class="form-control" id="admin_biaya_mtc" name="admin_biaya_mtc" value="<?php echo isset($item) ? $item['admin_biaya_mtc'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Biaya Partner</label>
                <input type="number"  class="form-control" id="admin_biaya_partner" name="admin_biaya_partner" value="<?php echo isset($item) ? $item['admin_biaya_partner'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Biaya CB</label>
                <input type="number"  class="form-control" id="admin_biaya_cb" name="admin_biaya_cb" value="<?php echo isset($item) ? $item['admin_biaya_cb'] : ''; ?>"  autofocus>
            </div>

			<div class="form-group">
                <label for="nama_keahlian">Kordinat</label>
                <input placeholder="Contoh: https://goo.gl/maps/9znQoeWy3dV3kW7C7" type="text" class="form-control" id="kordinat" name="kordinat" value="<?php echo isset($get_item) ? $get_item['kordinat'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo isset($item) ? $item['keterangan'] : ''; ?>"  autofocus>
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
                <label for="nama_keahlian">Status</label>
                 <select class="form-control" id="status" name="status" required>		
				 <option value="0" <?php if(isset($item['status'])){if($item['status'] == "0"){echo "selected";}} ?>>Baru</option>
				<option value="1" <?php if(isset($item['status'])){if($item['status'] == "1"){echo "selected";}} ?>>Selesai</option>						


				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Notifikasi Telegram</label>
                <input type="checkbox" id="notif_tg" name="notif_tg" value="notif_tg" checked="checked">
            </div>
			
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="javascript:history.go(-1);" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>	
			</div>
			</div>
			

        </form>

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
<script type="text/javascript">document.getElementById("nama_exist").style.display = 'none';</script>
<script type="text/javascript">document.getElementById("nama_survey").style.display = 'none';</script>
<script>
        $("#check_pel").change(function() {
            if (this.checked == true) {
                $("#nama_new").hide()
				$("#nama_exist").show()
				$("#nama_survey").hide()
				$("#brand").hide()
				$("#cabang").hide()
				$("#area").hide()
				$("#level").hide()
				$("#media").hide()
				$("#admin_divisi").hide()
				$("#admin_sales").hide()
				$("#admin_segment").hide()
				$("#admin_subsegment").hide()
				$("#cid").hide()
				$("#sid").hide()
				$("#alamat").hide()
				$("#kontak").hide()
				$("#email").hide()
				$("#pic").hide()
				$("#form").hide()
				$("#npwp").hide()
				$("#ktp").hide()
				$("#label_brand").hide()
				$("#label_area").hide()
				$("#label_cabang").hide()
				$("#label_level").hide()
				$("#label_media").hide()
				$("#label_divisi").hide()
				$("#label_sales").hide()
				$("#label_segment").hide()
				$("#label_subsegment").hide()
                $("#input_nama_exist").attr('required', false)
            } else {        
				$("#nama_new").show()
				$("#nama_exist").hide() 
				$("#nama_survey").hide()
				$("#brand").show()
				$("#cabang").show()
				$("#area").show()
				$("#level").show()
				$("#media").show()
				$("#admin_divisi").show()
				$("#admin_sales").show()
				$("#admin_segment").show()
				$("#admin_subsegment").show()
				$("#cid").show()
				$("#sid").show()
				$("#alamat").show()
				$("#kontak").show()
				$("#email").show()
				$("#pic").show()
				$("#form").show()
				$("#npwp").show()
				$("#ktp").show()
				$("#label_brand").show()
				$("#label_area").show()
				$("#label_cabang").show()
				$("#label_level").show()
				$("#label_media").show()
				$("#label_divisi").show()
				$("#label_sales").show()
				$("#label_segment").show()
				$("#label_subsegment").show()
				$("#input_nama_new").attr('required', true)
            }	
        })
    </script>

<script>
        $("#check_data_survey").change(function() {
            if (this.checked == true) {
                $("#nama_new").hide()
				$("#nama_exist").hide()
				$("#nama_survey").show()
                $("#input_nama_survey").attr('required', false)
            } else {        
				$("#nama_new").show()
				$("#nama_exist").hide() 
				$("#nama_survey").hide()
				$("#brand").show()
				$("#cabang").show()
				$("#area").show()
				$("#level").show()
				$("#media").show()
				$("#admin_divisi").show()
				$("#admin_sales").show()
				$("#admin_segment").show()
				$("#admin_subsegment").show()
				$("#cid").show()
				$("#sid").show()
				$("#alamat").show()
				$("#kontak").show()
				$("#email").show()
				$("#pic").show()
				$("#form").show()
				$("#npwp").show()
				$("#ktp").show()
				$("#label_brand").show()
				$("#label_area").show()
				$("#label_cabang").show()
				$("#label_level").show()
				$("#label_media").show()
				$("#label_divisi").show()
				$("#label_sales").show()
				$("#label_segment").show()
				$("#label_subsegment").show()
				$("#input_nama_survey").attr('required', true)
            }	
        })
    </script>