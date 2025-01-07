 <?php 
 if(isset($item['ip'])){
$ar_dec_ip = $this->secure->decrypt_url($item['ip']); }
if(isset($item['user'])){
$ar_dec_user = $this->secure->decrypt_url($item['user']); }
if(isset($item['pass'])){
$ar_dec_pass = $this->secure->decrypt_url($item['pass']); }
?>
<!-- PANEL HEADLINE -->

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">ROUTER DISTRIBUSI</div>

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
            echo form_open('manage/distribusi/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/distribusi/simpan');
        }
        ?>
			<div class="col-md-6">
            <div class="form-group">
                <label for="nama_keahlian">Nama Router</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($item) ? $item['nama'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">IP Router</label>
                <input type="text" class="form-control" id="ip" name="ip" value="<?php echo isset($item) ?$ar_dec_ip  : ''; ?>" required autofocus>
            </div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">User</label>
                <input type="text" class="form-control" id="user" name="user" value="<?php echo isset($item) ? $ar_dec_user : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Pass</label>
                <input type="password" class="form-control" id="pass" name="pass" value="<?php echo isset($item) ? $ar_dec_pass : ''; ?>" required autofocus>
            </div>
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/distribusi'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
