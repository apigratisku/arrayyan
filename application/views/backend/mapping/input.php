<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA ODP</div>


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
            echo form_open('manage/mapping/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/mapping/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Area</label>
                <select class="form-control" id="area" name="area" required>								
				<option value="NTB" selected>NTB</option>
				<option value="BALI">BALI</option>
				</select>
            </div>
            <div class="form-group">
                <label for="nama_keahlian">ODP</label>
                <input type="text" class="form-control" id="odp" name="odp" value="<?php echo isset($item) ? $item['odp'] : ''; ?>" required autofocus>
             </div>
			
			</div>
			
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Latitude</label>
                <input type="text" class="form-control" id="lat" name="lat" value="<?php echo isset($item) ? $item['lat'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Longtitude</label>
                <input type="text" class="form-control" id="long" name="long" value="<?php echo isset($item) ? $item['long'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Site</label>
                <select class="form-control" id="site" name="site" required>								
				<option value="Mataram" selected>Mataram</option>
				<option value="Pemenang">Pemenang</option>
				</select>
            </div>
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/mapping'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
