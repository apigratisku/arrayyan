<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
			  <?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
                <a href="<?php echo base_url('manage/olt/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
				<?php endif; ?>
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
                    <th>OLT</th>
					<th>IP Address</th>
					<th>Uptime</th>
					<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
                    <th style="text-align:center" width="8%">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php echo $item['olt_nama']; ?>
                        </td><td>
                            <?php 
							$hostname = $this->secure->decrypt_url($item['olt_ip']);
							$username = $this->secure->decrypt_url($item['olt_user']);
							$password = $this->secure->decrypt_url($item['olt_pwd']);
							
							echo $hostname;
							?>
                        </td><td valign="top">
                            <?php 
							/*
							$pingresult = exec("/bin/ping -c2 -w2 $hostname", $outcome, $status);
							if (0 == $status) {
								$status = "alive";
							} else {
								$status = "dead";
							}
							if($status == "alive"){
							if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
								echo "$errstr ($errno)<br />\n";
							}else{
								$this->load->library('phptelnet');
								$telnet = new PHPTelnet();
								$result = $telnet->Connect($hostname,$username,$password);
								if ($result == 0)
								{
									$telnet->DoCommand('show system-group', $result);
									$skuList = preg_split('/\r\n|\r|\n/', $result);	
									//Cek Brand
									if($item['olt_brand'] == "ZTE")
									{
										foreach($skuList as $key => $value)
										{
										 $olt_uptime = $skuList[6];
										}
										echo substr($olt_uptime,16);
									}
								}
							}
							}else{
							echo "No route to host";
							}*/
							
							if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
								echo "$errstr ($errno)<br />\n";
							}else{
								$this->load->library('phptelnet');
								$telnet = new PHPTelnet();
								$result = $telnet->Connect($hostname,$username,$password);
									if ($result == 0)
									{
										$telnet->DoCommand('show system-group', $result);
										$skuList = preg_split('/\r\n|\r|\n/', $result);	
										//Cek Brand
										if($item['olt_brand'] == "ZTE")
										{
											foreach($skuList as $key => $value)
											{
											 $olt_uptime = $skuList[6];
											}
											echo substr($olt_uptime,16);
										}
									}else{
										echo "No route to host";
									} 
								}
							?>
                        </td>
						<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
						<td  style="text-align:center">
                            <a href="<?php echo base_url('manage/olt/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            &nbsp;
                            <a href="<?php echo base_url('manage/olt/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
						<?php endif; ?>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->
