<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">SCHEDULER</div>

<div class="panel panel-headline">

    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $title; ?></h3>
    </div>

    <hr class="panel-divider">

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
                        <select class="form-control" id="permintaan" name="permintaan" placeholder="-Pilih-" value="<?php echo isset($item) ? $item['permintaan'] : ''; ?>">
						<option value="Upgrade">Upgrade</option>
						<option value="Downgrade">Downgrade</option>
						<option value="Isolir">Isolir</option>
						<option value="Buka Isolir">Buka Isolir</option>
						</select>
             </div>
			 <div class="form-group">
                <label for="nama_keahlian">Mulai</label>
				
                <input type="text" class="form-control datetimepicker-alt" id="datepicker" name="mulai" required autofocus>
            </div>
            
			
			</div>
			
			<div class="col-md-6">
			 <div class="form-group">
                        <label for="level">Pelanggan</label>
                        <select class="form-control" id="pelanggan" name="idrouter" placeholder="Pilih Router" value="<?php echo isset($item) ? $item['idrouter'] : ''; ?>">
						<?php foreach ($item_router as $router): ?>
						
						<?php if ($router['idrouter'] == $id_scheduler['idrouter']): ?>
						<option value="<?php echo $router['id']; ?>" selected="selected"><?php echo $router['nama']; ?></option>
						<?php else: ?>
						<option value="<?php echo $router['id']; ?>"><?php echo $router['nama']; ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
						</select>
             </div>
			 <div class="form-group">
                <label for="nama_keahlian">Bandwidth</label>
                <input type="text" class="form-control" placeholder="Contoh:5M/5M NB:Kosongkan jika permintaan isolir/buka isolir" id="bw" name="bw" value="<?php echo isset($item) ? $item['bw'] : ''; ?>" autofocus>
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
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/scheduler'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
