<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo base_url('manage/olt/tambah'); ?>" class="btn btn-info pull-right">Tambah Data</a>
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
                    <th style="text-align:center" width="8%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php echo $item['olt_nama']; ?>
                        </td><td>
                            <?php 
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
							
							echo $ar_enc_ip;
							?>
                        </td><td valign="top">
                            <?php 
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
									foreach($skuList as $k => $value)
									{
									
									if(strpos($value, "system-group") !== false)
									{ echo""; }
									elseif($value == "System Description: C320 Version V2.1.0 Software, Copyright (c) by ZTE Corporati")
									{ echo""; }
									elseif($value == "on Compiled")
									{ echo""; }
									elseif($value == "System ObjectId: .1.3.6.1.4.1.3902.1082.1001.320.2.1")
									{ echo""; }
									elseif($value == "Contact with: +86-21-68895000")
									{ echo""; }
									//elseif($value == "System name: OLT-ZTE-GMEDIA-PMG")
									//{ echo""; }
									elseif($value == "Location: No.889 BiBo Rd.PuDong District, Shanghai, China")
									{ echo""; }
									elseif($value == "System Info: 6313 5be467ff")
									{ echo""; }
									elseif($value == "This system primarily offers a set of 78 services")
									{ echo""; }
									elseif($value == "OLT-ZTE-GMEDIA-PMG#")
									{ echo""; }
									else
									{
									$items_olt[] = $value;
									}
									
									
									//$items_olt[] = $value;
									}
										//DC Telnet
										$telnet->Disconnect();
										$output="";
										foreach($items_olt as $olt )
										{
											array_push($olt, $k);
											
										}
										$output = $olt[5];
								}
							}
							echo $output;
							//print_r(trim($output)); 
							?>
                        </td><td  style="text-align:center">
                            <a href="<?php echo base_url('manage/olt/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            &nbsp;
                            <a href="<?php echo base_url('manage/olt/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
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
