<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo base_url('manage/distribusi/tambah'); ?>" class="btn btn-info pull-right">Tambah Data</a>
              </div>
    </div>

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
        <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
                    <th>Router</th>
					<th>IP Router</th>
					<th>User</th>
					<th>Password</th>
                    <th style="text-align:center" width="8%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php echo $item['nama']; ?>
                        </td><td>
                           <?php 
							//ENKRIPSI PASSWORD ROUTER
							require_once APPPATH."third_party/addon.php";
							$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
							$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
							$ar_str_ip = $item['ip'];
							$ar_dec_ip = $ar_chip->decrypt($ar_str_ip, $ar_rand);
							echo $ar_dec_ip;
							?>
                        </td><td>
                            <?php 
							//ENKRIPSI PASSWORD ROUTER
							require_once APPPATH."third_party/addon.php";
							$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
							$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
							$ar_str_user = $item['user'];
							$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
							echo $ar_dec_user;
							?>
                        </td><td>
                            <?php 
							$count = strlen($item['pass']);
							for($c=0; $c<$count; $c++)
							{ echo "*"; }
							?>
                        </td><td  style="text-align:center">
                            <a href="<?php echo base_url('manage/distribusi/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            &nbsp;
                            <a href="<?php echo base_url('manage/distribusi/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->
