<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			ADMIN - KPI
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
            echo form_open('manage/kpi/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/kpi/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
			<label for="dr">Grup KPI</label>
			<select class="form-control" id="klasifikasi" name="klasifikasi" required>
			<?php if(isset($item['klasifikasi'])):?>
			<option value="<?php echo isset($item['klasifikasi']) ? $item['klasifikasi'] : ''; ?>" selected><?php $klasifikasi = $this->db->get_where('blip_kpi_induk', array('id' => $item['klasifikasi']))->row_array(); echo $klasifikasi['kegiatan']; ?></option>	
			<?php endif; ?>	
			<?php foreach ($items_kpi_induk as $kpi_induk): ?>							
			<option value="<?php echo $kpi_induk['id']; ?>"><?php echo $kpi_induk['kegiatan']; ?></option>
			<?php endforeach; ?>
			</select>
			</div>
            <div class="form-group">
                <label for="nama_keahlian">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?php echo isset($item) ? $item['kegiatan'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Durasi</label>
                <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo isset($item) ? $item['durasi'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Masukan ke Data Pelanggan Baru ?</label>
                 <select class="form-control" id="new_cust" name="new_cust" required>		
				 <option value="1" <?php if(isset($item['new_cust'])){if($item['new_cust'] == "1"){echo "selected";}} ?>>Ya</option>
				<option value="0" <?php if(isset($item['new_cust'])){if($item['new_cust'] == "0"){echo "selected";}} ?>>Tidak</option>						


				</select>
            </div>
			
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/kpi'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
