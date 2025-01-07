<?php
date_default_timezone_set("Asia/Singapore");
?>
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			ADMIN - WO KHUSUS
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
            echo form_open('manage/wo_khusus_admin/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/wo_khusus_admin/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian" id="label_pelanggan">Data Pelanggan</label><br />
                 <select class="form-control" id="lokasi_pelanggan" name="id_pelanggan" style="width:100%">	
				 <option value="">--- Pelanggan Existing ---</option>
				<?php $data_pelanggan= $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array(); ?>
				<?php if(isset($data_pelanggan['id'])):?><option value="<?php echo isset($data_pelanggan['id']) ? $data_pelanggan['id'] : ''; ?>" selected><?php echo isset($data_pelanggan['id']) ? $data_pelanggan['nama'] : ''; ?></option><?php endif; ?>							
				<?php foreach ($items_pelanggan as $pelanggan): ?>
				<option value="<?php echo isset($pelanggan) ? $pelanggan['id'] : ''; ?>"><?php echo $pelanggan['nama']; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian" id="label_pelanggan">Sales</label><br />
                 <select class="form-control" id="lokasi_pelanggan" name="id_sales" style="width:100%">	
				 <option value="">--- Nama Sales ---</option>	
				<?php $data_sales= $this->db->get_where('blip_sales', array('id' => $item['id_sales']))->row_array(); ?>
				<?php if(isset($data_sales['id'])):?><option value="<?php echo isset($data_sales['id']) ? $data_sales['id'] : ''; ?>" selected><?php echo isset($data_sales['id']) ? $data_sales['nama'] : ''; ?></option><?php endif; ?> 						
				<?php foreach ($items_sales as $sales): ?>
				<option value="<?php echo isset($sales) ? $sales['id'] : ''; ?>"><?php echo $sales['nama']; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			
			
			<div class="form-group">
                <label for="nama_keahlian">Kegiatan</label>
                <select class="form-control" id="kegiatan" name="kegiatan" style="width:100%">								
				<option value="Instalasi">Instalasi</option>
				<option value="Konfigurasi">Konfigurasi</option>
				<option value="Visit">Visit</option>
				<option value="Relokasi">Relokasi</option>
				<option value="BOD">BOD</option>
				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Sub kegiatan</label>
                <input type="text" class="form-control" id="sub_kegiatan" name="sub_kegiatan" value="<?php echo isset($item['sub_kegiatan']) ? $item['sub_kegiatan'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Tgl Req Sales</label>
                <input type="text" class="form-control" id="datetime2" name="tgl_req_sales" value="<?php echo isset($item['tgl_req_sales']) ? $item['tgl_req_sales'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Link Dokumentasi</label>
                <input type="text" class="form-control" id="link_dokumentasi" name="link_dokumentasi" value="<?php echo isset($item['link_dokumentasi']) ? $item['link_dokumentasi'] : ''; ?>" autofocus>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian">Notifikasi Whatsapp</label>
                <input type="checkbox" id="notif_wa" name="notif_wa" value="notif_wa" checked="checked">
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
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/wo_khusus_admin'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->

