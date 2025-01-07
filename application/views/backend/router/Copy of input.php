 <?php 
if(isset($item['router_user'])){
require APPPATH."third_party/addon.php";
$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
$router_u = $item['router_user'];
$router_user = $ar_chip->decrypt($router_u, $ar_rand); }

if(isset($item['router_password'])){
$router_p = $item['router_password'];
$router_pass = $ar_chip->decrypt($router_p, $ar_rand); }

if(isset($item['lastmile_user'])){
$lastmile_u = $item['lastmile_user'];
$lastmile_user = $ar_chip->decrypt($lastmile_u, $ar_rand); }

if(isset($item['lastmile_password'])){
$lastmile_p = $item['lastmile_password'];
$lastmile_password = $ar_chip->decrypt($lastmile_p, $ar_rand); }
?>

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
        if (isset($item)) {
            echo form_open('manage/router/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/router/simpan');
        }
        ?>
			<div class="col-md-6">
            <div class="form-group">
                <label for="nama_keahlian">Nama Router</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($item) ? $item['nama'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">IP Lastmile</label>
                <input type="text" class="form-control" id="lastmile" name="lastmile_ip" value="<?php echo isset($item) ? $item['lastmile'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">User Lastmile</label>
                <input type="text" class="form-control" id="lastmile_user" name="lastmile_user" value="<?php echo isset($item) ? $lastmile_user : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Password Lastmile</label>
                <input type="password" class="form-control" id="lastmile_pass" name="lastmile_pass" value="<?php echo isset($item) ? $lastmile_password : ''; ?>" required autofocus>
            </div>
			
			
			
			</div>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">IP Router</label>
                <input type="text" class="form-control" id="router_ip" name="router_ip" value="<?php echo isset($item) ? $item['ip'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">User Router</label>
                <input type="text" class="form-control" id="router_user" name="router_user" value="<?php echo isset($item) ? $router_user : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Password Router</label>
                <input type="password" class="form-control" id="router_pass" name="router_pass" value="<?php echo isset($item) ? $router_pass : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Network</label>
                <input placeholder="Contoh: x.x.x.x/x" type="text" class="form-control" id="network" name="network" value="<?php echo isset($item) ? $item['network'] : ''; ?>" required autofocus>
            </div>
			
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/router'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; KEMBALI</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
