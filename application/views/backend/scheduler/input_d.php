<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">SCHEDULER</div>

<div class="panel panel-headline">


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
            echo form_open('manage/scheduler/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/scheduler/simpan');
        }
        ?>
			<div class="col-md-6">
			
			 <div class="form-group">
                        <label for="level">Permintaan</label>
                        <select class="form-control" id="permintaan" name="req" placeholder="-Pilih-" value="<?php echo isset($item) ? $item['permintaan'] : ''; ?>" onChange="top.location.href = this.form.req.options[this.form.req.selectedIndex].value;
return false;">
						<option value="<?php echo base_url('manage/scheduler/tambah_a'); ?>">Upgrade</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_b'); ?>">Downgrade</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_c'); ?>">Isolir</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_d'); ?>" selected="selected">Buka Isolir</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_e'); ?>">Free BOD +50%</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_f'); ?>">Free BOD +100%</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_g'); ?>">BOD Berbayar (Non Pelanggan)</option>
						<option value="<?php echo base_url('manage/scheduler/tambah_h'); ?>">Dismantle (Close Port)</option>
						</select>
						<input type="hidden" name="permintaan" value="Buka Isolir" />
						
             </div>
			 <div class="form-group">
                        <label for="level">Relasi WO (Work Order)</label>
                        <select class="form-control" id="id_wo" name="id_wo" placeholder="Data WO" required>			
						<option value="">-Data WO-</option>
						<?php foreach ($wo_data as $list_wo): ?>
						<?php 
						$data_request = $this->db->get_where('blip_kpi', array('id' => $list_wo['request']))->row_array();
						$req = $data_request['kegiatan'];
						?>
						<option value="<?php echo $list_wo['id']; ?>"><?php echo "[".$req."] - [".$list_wo['nama']."]"; ?></option>
						<?php endforeach; ?>
						<option value="Request by Finance">Request by Finance</option>
						</select>
             </div>
			 <div class="form-group">
                <label for="nama_keahlian">Mulai</label>
				<div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                <input type="text" class="form-control datetimepicker-alt" id="datetime2" name="mulai" required autofocus>
<script type="text/javascript">
$("#datetime2").datetimepicker({
	format: 'yyyy-mm-dd hh:ii',
	autoclose: true
});
</script>
</div>
            </div>
            
			
			</div>
			
			<div class="col-md-6">
			  <div class="form-group">
                        <label for="level">Pelanggan</label>
                        <select class="form-control" id="pelanggan" name="pelanggan" placeholder="Data Pelanggan" value="<?php echo isset($item) ? $item['id_pelanggan'] : ''; ?>">			<option value="">-Pelanggan-</option>
						<?php foreach ($item_pelanggan as $pelanggan): ?>
						<?php 
							if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";$disabled="";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
							?>
						<option value="<?php echo $pelanggan['id']; ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
						<?php endforeach; ?>
						</select>
             </div>
			 <div class="form-group">
                        <label for="level">Layanan</label>
                        <div class="form-group">
					   <select name="layanan" id="layanan" class="form-control" required>
						<option value="">-Layanan-</option>
					   </select>
					  </div>
             </div>
			 
			<div class="form-group">
                        <label for="level">Waktu Eksekusi</label>
                        <select class="form-control" id="eksekusi" name="eksekusi" placeholder="Waktu Eksekusi" required>
						<option value="terjadwal">Terjadwal</option>
						<option value="sekarang">Sekarang</option>
						</select>
             </div>
			 <div class="form-group">
                <label for="nama_keahlian">Notifikasi Telegram</label>
                <input type="checkbox" id="notif_tg" name="notif_tg" value="notif_tg" checked="checked">
            </div>
			
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/scheduler'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
<!-- Script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type='text/javascript'>
  // baseURL variable
  var baseURL= "<?php echo base_url();?>";
 
  $(document).ready(function(){
 
    // City change
    $('#pelanggan').change(function(){
      var pelanggan = $(this).val();

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>/manage/scheduler/fetch_layanan',
        method: 'post',
        data: {pelanggan: pelanggan},
        dataType: 'json',
        success: function(response){

          // Remove options 
          $('#layanan').find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#layanan').append('<option value="'+data['id']+'">'+data['produk']+' '+data['id_bandwidth']+' Mbps</option>');
          });
        }
     });
   });
 
 });
 </script>