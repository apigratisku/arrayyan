<?php
date_default_timezone_set("Asia/Singapore");
?>
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			TECHNICAL - SPK - DATA
			</div>
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
        if (isset($item)) {
            echo form_open('manage/spk/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/spk/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian" id="label_pelanggan">Lokasi Pelanggan Existing (Bisa dikosongkan)</label><br />
                 <select class="form-control" id="lokasi_pelanggan" name="id_pelanggan" style="width:100%">	
				 <option value="">--- Pelanggan Existing ---</option>	
				 <?php $p_exist = $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array(); ?>
				<?php if(!empty($p_exist['id'])):?><option value="<?php echo isset($p_exist['id']) ? $p_exist['id'] : ''; ?>" selected><?php echo isset($p_exist['id']) ? $p_exist['nama'] : ''; ?></option><?php endif; ?>						
				<?php foreach ($items_pelanggan as $pelanggan): ?>
				<?php 
				if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";$disabled="";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
				?>
				<option value="<?php echo isset($pelanggan) ? $pelanggan['id'] : ''; ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian" id="label_pelanggan">Lokasi Capel Survey (Bisa dikosongkan)</label><br />
                 <select class="form-control" id="lokasi_pelanggan" name="id_survey" style="width:100%">	
				 <option value="">--- Capel Survey ---</option>	
				 <?php $p_survey = $this->db->get_where('blip_spk', array('id_survey' => $item['id_survey']))->row_array(); ?>
				<?php if(!empty($p_survey['id_survey'])):?><option value="<?php echo isset($p_survey['id_survey']) ? $p_survey['id_survey'] : ''; ?>" selected><?php echo isset($p_survey['id_survey']) ? $p_survey['id_survey'] : ''; ?></option><?php endif; ?>							
				<?php foreach ($items_survey as $survey): ?>
				<option value="<?php echo isset($survey) ? $survey['nama'] : ''; ?>"><?php echo $survey['nama']; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian" id="label_non_pelanggan">Lokasi BTS (Bisa dikosongkan)</label>
                <select class="form-control" id="lokasi_bts" name="id_bts" style="width:100%">
				<option value="">--- BTS ---</option>		
				<?php $p_bts = $this->db->get_where('blip_spk', array('id_bts' => $item['id_bts']))->row_array(); ?>
				<?php if(!empty($p_bts['id_bts'])):?><option value="<?php echo isset($p_bts['id_bts']) ? $p_bts['id_bts'] : ''; ?>" selected><?php echo isset($p_bts['id_bts']) ? $p_bts['id_bts'] : ''; ?></option><?php endif; ?>						
				<option value="BTS Nutana">BTS Nutana</option>
				<option value="BTS Qomarul">BTS Qomarul</option>
				<option value="BTS Brembeng">BTS Brembeng</option>
				<option value="BTS Pemenang">BTS Pemenang</option>
				<option value="BTS Trawangan">BTS Trawangan</option>
				</select>
            </div>
			
			
			
            <div class="form-group">
                <label for="nama_keahlian">Petugas</label><br />
                 <select class="form-control" id="id_petugas" name="id_petugas" style="width:100%">	
				 <?php $p_petugas = $this->db->get_where('gm_operator', array('id' => $item['id_petugas']))->row_array(); ?>
				<?php if(!empty($p_petugas['id'])):?><option value="<?php echo isset($p_petugas['id']) ? $p_petugas['id'] : ''; ?>" selected><?php echo isset($p_petugas['id']) ? $p_petugas['nama'] : ''; ?></option><?php endif; ?>								
				<?php foreach ($items_petugas as $petugas): ?>
				<option value="<?php echo isset($petugas['id']) ? $petugas['id'] : ''; ?>"><?php echo $petugas['nama']; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Kegiatan</label>
                <select class="form-control" id="kegiatan" name="kegiatan" style="width:100%">
				<?php $p_kegiatan = $this->db->get_where('blip_spk', array('id_bts' => $item['id_bts']))->row_array(); ?>
				<?php if(!empty($p_kegiatan['kegiatan'])):?><option value="<?php echo isset($p_kegiatan['kegiatan']) ? $p_kegiatan['kegiatan'] : ''; ?>" selected><?php echo isset($p_kegiatan['kegiatan']) ? $p_kegiatan['kegiatan'] : ''; ?></option><?php endif; ?>									
				<option value="Instalasi">Instalasi</option>
				<option value="Maintenance">Maintenance</option>
				<option value="Survey">Survey</option>
				<option value="Visit">Visit</option>
				<option value="Preventive">Preventive</option>
				<option value="Konfigurasi">Konfigurasi</option>
				<option value="Aktivasi">Aktivasi</option>
				<option value="Dismantle">Dismantle</option>
				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Sub kegiatan</label>
                <input type="text" class="form-control" id="sub_kegiatan" name="sub_kegiatan" value="<?php echo isset($item['sub_kegiatan']) ? $item['sub_kegiatan'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Waktu Mulai</label>
                <input type="text" class="form-control" id="datetime2" name="waktu_mulai" value="<?php echo isset($item['waktu_mulai']) ? $item['waktu_mulai'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Waktu Selesai</label>
                <input type="text" class="form-control" id="datetime3" name="waktu_selesai" value="<?php echo isset($item['waktu_selesai']) ? $item['waktu_selesai'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Link Dokumentasi</label>
                <input type="text" class="form-control" id="link_dokumentasi" name="link_dokumentasi" value="<?php echo isset($item['link_dokumentasi']) ? $item['link_dokumentasi'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian" id="status">Status</label>
                <select class="form-control" id="status" name="status" style="width:100%">
				<option value="">--- Status ---</option>	
				<?php $p_spk = $this->db->get_where('blip_spk', array('id' => $item['id']))->row_array(); ?>
				<?php if(!empty($p_spk['id'])):?><option value="<?php echo isset($p_spk['status']) ? $p_spk['status'] : ''; ?>" selected><?php echo isset($p_spk['status']) ? $p_spk['status'] : ''; ?></option><?php endif; ?>						
				<option value="Open">Open</option>
				<option value="Selesai">Selesai</option>
				</select>
            </div>

			<div class="form-group">
                <label for="nama_keahlian">Notifikasi Telegram</label>
                <input type="checkbox" id="notif_tg" name="notif_tg" value="notif_tg" checked="checked">
            </div>
			<input type="hidden" class="form-control" id="token" name="token" value="<?php $token = md5(getrandmax()."".date('H:i')); echo $token; ?>" required>
<script type="text/javascript">
$("#datetime2").datetimepicker({
	format: 'yyyy-mm-dd hh:ii',
	autoclose: true
});
</script>
<script type="text/javascript">
$("#datetime3").datetimepicker({
	format: 'yyyy-mm-dd hh:ii',
	autoclose: true
});
</script>
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/spk'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->

