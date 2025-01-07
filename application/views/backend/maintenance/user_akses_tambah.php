<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">MAINTENANCE PREVENTIVE</div>

 
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
        if (isset($items_akses['id'])) {
            echo form_open('manage/maintenance/' . $items_akses['id'] . '/user_akses_timpa');
			//Decrypt Password
			require_once APPPATH."third_party/addon.php";
			$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
			//Akses Existing
			$username = $ar_chip->decrypt($items_akses['user'], $ar_rand);
			$password = $ar_chip->decrypt($items_akses['password'], $ar_rand);
        } else {
            echo form_open('manage/maintenance/user_akses_simpan');
        }
		
		
		
        ?>
			<div class="col-md-6">
			<?php if(!isset($items_akses['id'])): ?>
            <div class="form-group">
                        <label for="level">Role</label>
                        <select class="form-control" id="role" name="role" value="<?php echo isset($items_akses) ? $items_akses['role'] : ''; ?>">
						<option value=""></option>
						<option value="Router" selected="selected">Router</option>
						<option value="Radio AP BTS">Radio AP BTS</option>
						<option value="Radio AP Client">Radio AP Client</option>
						<option value="Radio AP Lokal">Radio AP Lokal</option>
						</select>
             </div>
			 <?php else: ?>
			 <input type="hidden" class="form-control" id="role" name="role" value="<?php echo isset($items_akses['role']) ? $items_akses['role'] : ''; ?>">	 
			 <?php endif; ?>
			<div class="form-group">
                <label for="nama_keahlian">User</label>
                <input type="text" class="form-control" id="user" name="user" value="<?php echo isset($items_akses['user']) ? $username : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Password</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo isset($items_akses['password']) ? $password : ''; ?>" required autofocus>
            </div>
			
			<div class="row">
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/maintenance'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; KEMBALI</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>
			
			</div>
			
            <hr>

            

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
