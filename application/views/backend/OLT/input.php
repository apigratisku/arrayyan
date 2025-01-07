<?php
if(isset($item['id'])){
//ENKRIPSI PASSWORD
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_ip = $item['olt_ip'];
		$ar_enc_ip = $ar_chip->decrypt($ar_str_ip, $ar_rand);
		$ar_str_user = $item['olt_user'];
		$ar_enc_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $item['olt_pwd'];
		$ar_enc_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		$hostname = $ar_enc_ip;
		$username = $ar_enc_user;
		$password = $ar_enc_pass;	
}
?>
<!-- PANEL HEADLINE -->

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
            echo form_open('manage/olt/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/olt/simpan');
        }
        ?>
			<div class="col-md-6">
            <div class="form-group">
                <label for="nama_keahlian">Nama OLT</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($item) ? $item['olt_nama'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo isset($item) ? $item['olt_brand'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">IP Address</label>
                <input type="text" class="form-control" id="ip" name="ip" value="<?php echo isset($hostname) ? $hostname : ''; ?>" required autofocus>
            </div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">User</label>
                <input type="text" class="form-control" id="user" name="user" value="<?php echo isset($username) ? $username : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required autofocus>
            </div>
			</div>

            <hr>
			<p style="font-size:10px; color:#FF0000">*** Pastikan port 22 SSH aktif ***</p>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/olt'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
