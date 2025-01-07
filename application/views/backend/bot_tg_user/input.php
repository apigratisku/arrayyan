<!-- PANEL HEADLINE -->

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
            echo form_open('gmediabot/' . $items['id_user'] . '/gmakses_web');

        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">ID User</label>
                <input type="text" class="form-control" id="id_user" name="id_user" value="<?php echo isset($items) ? $items['id_user'] : ''; ?>" required autofocus disabled="disabled">
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Area</label>
                <select class="form-control" id="area" name="area" required>
				<option <?php if($items['id_area'] == NULL) {echo"value=\"\"";} ?>>Pilih Area</option>								
				<option value="NTB" <?php if(isset($items)) {if($items['id_area'] == "NTB") {echo "selected";}} ?>>NTB</option>
				<option value="BALI" <?php if(isset($items)) {if($items['id_area'] == "BALI") {echo "selected";}} ?>>BALI</option>
				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Status</label>
                <select class="form-control" id="status" name="status" required>								
				<option value="0" selected>Menunggu Respond</option>
				<option value="1">Aktif</option>
				<option value="2">Tidak Aktif</option>
				</select>
            </div>
			
			</div>
            <hr>
            <div class="row">
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/bot_tg_user'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; KEMBALI</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
