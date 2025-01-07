<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-md-6 panel-action">
                <a href="<?php echo base_url('manage/mgmtrouter/tambah'); ?>" class="btn btn-success">Add Broadcast NewPASSWD</a>
            </div>
        </div>
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
		<div class="table-responsive">
        <table class="table table-hover table-bordered table-act" id="data-table">

            <thead>

                <tr>
                    <th>Pelanggan</th>
					<th>IP Address</th>
					<th>Identity</th>
					<th style="text-align:center" width="10%">Status API</th>
					<th style="text-align:center" width="10%">Keterangan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>
				<?php
				require_once APPPATH."third_party/addon.php";
				$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
				$ar_str_user = $item['user'];
				$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
				$ar_str_pass = $item['pass'];
				$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
				$hostname 	 = $item['ip'];
				$username 	 = $ar_dec_user;
				$password 	 = $ar_dec_pass;	
				if ($this->routerosapi->connect($hostname, $username, $password))
				{
					//GET IDENTITY
					$this->routerosapi->write('/system/identity/getall');
					$API_1 = $this->routerosapi->read();
					foreach ($API_1 as $API_IDENTITY)
					{
						$IDENTITY = $API_IDENTITY['name'];
					}
					//GET API SERVICE
					$this->routerosapi->write('/ip/service/getall');
					$API_2 = $this->routerosapi->read();
					foreach ($API_2 as $API_SERVICE)
					{
						$SERVICE = $API_SERVICE['disabled'];
					}
				?>
                    <tr>
                        <td>
                            <?php echo $item['nama']; ?>
                        </td><td>
                            <?php echo $hostname; ?>
                        </td><td>
                            <?php echo $IDENTITY; ?>
                        </td><td style="text-align:center">
                           <?php if($SERVICE == "yes") {echo"<span style=\"color:red; font-weight:bold\">Tidak Aktif</span>";} else{echo"<span style=\"color:green; font-weight:bold\">Aktif</span>";} ?>
							</td>
							<td>
                            <?php echo $hostname; ?>
                        </td>
                    </tr>
				<?php } ?>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>

    </div>

</div>

<!-- END PANEL HEADLINE -->
