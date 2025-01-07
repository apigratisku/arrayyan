<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			TECHNICAL - VAS - DATA
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
            echo form_open('manage/vas_data/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/vas_data/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Nama Pelanggan</label><br />
                 <select class="form-control" id="pelanggan" name="id_pelanggan" style="width:100%">								
				<?php foreach ($items_pelanggan as $pelanggan): ?>
				<?php 
							if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";$disabled="";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
							?>
				<option value="<?php echo isset($pelanggan) ? $pelanggan['id'] : ''; ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
            <div class="form-group">
                <label for="nama_keahlian">Nama Perangkat</label><br />
                 <select class="form-control" id="id_perangkat" name="id_perangkat" style="width:100%">								
				<?php foreach ($items_spec as $spec): ?>
				<option value="<?php echo isset($spec) ? $spec['id'] : ''; ?>"><?php echo $spec['nama']; ?></option>
				<?php endforeach; ?>

				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Mac Address</label>
                <input type="text" class="form-control" id="mac_address" name="mac_address" value="<?php echo isset($item) ? $item['mac_address'] : ''; ?>"  autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Serial Number</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo isset($item) ? $item['serial_number'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo isset($item) ? $item['jumlah'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Satuan</label>
                <select class="form-control" id="satuan" name="satuan" style="width:100%">								
				<option value="Pcs">Pcs</option>
				<option value="Meter">Meter</option>
				<option value="Roll">Roll</option>
				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Alokasi</label>
                <select class="form-control" id="alokasi" name="alokasi" style="width:100%">								
				<option value="Instalasi">Instalasi</option>
				<option value="Maintenance">Maintenance</option>
				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo isset($item) ? $item['keterangan'] : ''; ?>" autofocus>
            </div>
			
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/vas_data'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
