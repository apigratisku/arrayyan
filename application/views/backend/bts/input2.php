<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">BTS - RADIO ACCESS POINT</div>


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
            echo form_open('manage/bts/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/bts/simpan');
        }
        ?>
		
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">BSC/BTS</label>
                <input type="text" class="form-control" id="nama_bts" name="nama_bts" value="<?php echo isset($item) ? $item['nama_bts'] : ''; ?>" required autofocus>
            </div>
            <div class="form-group">
                <label for="nama_keahlian">IP Address</label>
                <input type="text" class="form-control" id="ip" name="ip" value="<?php echo isset($item) ? $item['ip'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($item) ? $this->secure->decrypt_url($item['user']) : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($item) ? $this->secure->decrypt_url($item['password']) : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Port</label>
                <input type="number" class="form-control" id="port" name="port" value="<?php echo isset($item) ? $item['port'] : ''; ?>" required autofocus>
            </div>
			</div>
			<div class="col-md-6">
			
			<div class="form-group">
                <label for="nama_keahlian">B4 Protocol</label>
                <input type="text" class="form-control" id="b4_protocol" name="b4_protocol" value="<?php echo isset($item) ? $item['b4_protocol'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">B4 Frekuensi</label>
                <input type="text" class="form-control" id="b4_frek" name="b4_frek" value="<?php echo isset($item) ? $item['b4_frek'] : ''; ?>" autofocus>
            </div>
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/bts'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
