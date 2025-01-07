<?php
date_default_timezone_set("Asia/Singapore");
?>
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			NOC - SISTEM TIKET
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
            echo form_open('manage/wo_khusus_noc/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/wo_khusus_noc/simpan');
			
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">No Tiket</label>
                <input type="text" class="form-control" id="tiket" name="" value="<?php date_default_timezone_set("Asia/Singapore"); if(!empty($item['tiket'])){echo $item['tiket'];}else{echo "#".date("YmdHi");}?>
				" autofocus required disabled="disabled">
            </div>
			<div class="form-group">
                <label for="nama_keahlian" id="label_pelanggan">Data Pelanggan (Bisa dikosongkan)</label><br />
                 <select class="form-control" id="lokasi_pelanggan" name="id_pelanggan" style="width:100%">	
				 <option value="">--- Pelanggan Existing ---</option>
				<?php $data_pelanggan= $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array(); ?>
				<?php if(isset($data_pelanggan['id'])):?><option value="<?php echo isset($data_pelanggan['id']) ? $data_pelanggan['id'] : ''; ?>" selected><?php echo isset($data_pelanggan['id']) ? $data_pelanggan['nama'] : ''; ?></option><?php endif; ?>							
				<?php foreach ($items_pelanggan as $pelanggan): ?>
				<?php 
				if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";}else{$status_pelanggan = "Dismantle";}
				?>
				<option value="<?php echo isset($pelanggan) ? $pelanggan['id'] : ''; ?>"><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			
			<div class="form-group">
                <label for="nama_keahlian" id="label_non_pelanggan">Lokasi BTS (Bisa dikosongkan)</label>
                <select class="form-control" id="lokasi_bts" name="id_bts" style="width:100%">
				<option value="">--- BTS ---</option>								
				<option value="BTS Nutana">BTS Nutana</option>
				<option value="BTS Qomarul">BTS Qomarul</option>
				<option value="BTS Brembeng">BTS Brembeng</option>
				<option value="BTS Pemenang">BTS Pemenang</option>
				<option value="BTS Trawangan">BTS Trawangan</option>
				</select>
            </div>
			
			
			<div class="form-group">
                <label for="nama_keahlian">Kendala</label>
                <input type="text" class="form-control" id="kendala" name="kendala" value="<?php echo isset($item['kendala']) ? $item['kendala'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo isset($item['keterangan']) ? $item['keterangan'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Action</label>
                <input type="text" class="form-control" id="action" name="action" value="<?php echo isset($item['action']) ? $item['action'] : ''; ?>" autofocus>
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
				<label for="level">Status</label>
				<select class="form-control" id="status" name="status" placeholder="" required>
				<?php $data_status= $this->db->get_where('blip_wo_khusus_noc', array('id' => $item['id']))->row_array(); ?>
				<?php if(isset($data_status['status'])):?><option value="<?php echo isset($data_status['status']) ? $data_status['status'] : ''; ?>" selected><?php echo isset($data_status['status']) ? $data_status['status'] : ''; ?></option><?php endif; ?>
				<option value="Open">Open</option>
				<option value="Closed">Closed</option>

				</select>
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
			<input type="hidden" class="form-control" id="tiket" name="tiket" value="<?php echo "#".date("YmdHi"); ?>" required>
			<input type="hidden" class="form-control" id="mail_token" name="mail_token" value="<?php echo "BLiP*123#"; ?>" required>
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
                    <a href="<?php echo base_url('manage/wo_khusus_noc'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->

