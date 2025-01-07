<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
				<?php if($this->session->userdata('ses_admin')=='1'):?>
                <a href="<?php echo base_url('manage/router'); ?>" class="btn btn-info pull-right">KEMBALI</a>
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

        <div class="row">

            <div class="col-md-3">
                <a href="" class="thumbnail">
                    <?php if (empty($item['foto'])): ?>
                        <img src="<?php echo base_url('static/photos/router.jfif'); ?>">
                    <?php endif; ?>
					
                </a>
				<h3 style="color:#000000; font-size:20px; font-weight:bold; text-align:center">::: <?php echo $item['nama']; ?> :::</h3>
            </div>

            <div class="col-md-4">
				<div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
					<tr>
                            <td>
                                <b>Status</b>
                            </td><td>
                               <?php if($item['status'] == "0") {echo"<span style=\"color:red; font-weight:bold\">OFFLINE</span>";} else{echo"<span style=\"color:green; font-weight:bold\">ONLINE</span>";} ?>
                            </td>
                        </tr>
						
						<tr>
                            <td>
                                <b>Media</b>
                            </td><td>
                                <?php echo $item['media']; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>POP</b>
                            </td><td>
                                <?php echo $item['pop']; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>DR</b>
                            </td><td>
                                <?php 
								$query_dr = $this->db->get_where('gm_dr', array('id' =>$item['DR']))->row_array();	
								echo $query_dr['nama'];
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>TE</b>
                            </td><td>
                               <?php 
								$query_te = $this->db->get_where('gm_te', array('id' =>$item['TE']))->row_array();	
								echo $query_te['nama'];
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>ODP</b>
                            </td><td>
                               <?php 
								$query_odp = $this->db->get_where('gm_mapping', array('id' =>$item['odp']))->row_array();	
								if(isset($query_odp['id'])):
								echo "<b>".$query_odp['odp']."<b>&nbsp;";
								?>
								<a href="<?php echo "https://www.google.com/maps/place/".$query_odp['lat']."+".$query_odp['long']; ?>" target="_blank">Maps Link</a>
								<?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Interface</b>
                            </td><td>
                                <?php echo $item['interface']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>IP Address</b>
                            </td><td>
                                <?php echo $item['router_ip']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Network</b>
                            </td><td>
                                <?php echo $item['router_network']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Routerboard</b> 
                            </td><td>
                               <?php 
								if(isset($routerboard))
								{
									foreach ($routerboard as $data_routerboard)
									{ 
									echo "Model <b>".$data_routerboard['model']."</b><br>"; 
									echo "Firmware <b>".$data_routerboard['upgrade-firmware']."</b>"; 
									 
									}	
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Memory</b> 
                            </td><td>
                               <?php 
								if(isset($resource))
								{
									foreach ($resource as $data_resource)
									{ 
									$mem_free = $data_resource['free-memory']/1000000;
									$mem_tot = $data_resource['total-memory']/1000000;
									echo "Free <b>".floor($mem_free)."%</b><br>"; 
									echo "Total <b>".floor($mem_tot)."%</b>"; 
									}	
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>CPU Load</b>
                            </td><td>
                                <?php 
								if(isset($resource))
								{
									foreach ($resource as $data_resource)
									{ 
									echo $data_resource['cpu-load']." %"; 
									}	
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Uptime</b>
                            </td><td>
                                <?php 
								if(isset($resource))
								{
									foreach ($resource as $data_resource)
									{ 
									echo $data_resource['uptime']; 
									}	
								}
								else
								{
									echo"-";
								}			
								?>
								
                            </td>
                        </tr><tr>
                            <td>
                                <b>Hotspot</b>
                            </td><td>
                                <?php 
								if(isset($hs_info))
								{
									echo $hs_info;
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Traffic</b>
                            </td><td>
                                <?php 
								if(isset($bwinfo))
								{
									echo $bwinfo;
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
            </div>
			
			<div class="col-md-5">
				<div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
					<tr>
                            <td>
                                <b>SID</b>
                            </td><td>
							<?php 
								if(isset($item['cid']))
								{
									echo $item['cid'];
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Kontak</b>
                            </td><td>
								<?php 
								if(isset($item['kontak']))
								{
									echo "<a href=\"$item[kontak]\" target=\"_blank\">$item[kontak]</a>";
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>PIC</b>
                            </td><td>
                                <?php 
								if(isset($item['pic']))
								{
									echo $item['pic'];
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Bandwidth</b>
                            </td><td>
                               <?php 
								if(isset($item['bandwidth']))
								{
									echo $item['bandwidth']. " Mbps";
								}
								else
								{
									echo"-";
								}	
								?>
							   
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tahun</b>
                            </td><td>
                                 <?php 
								if(isset($item['tahun']))
								{
									echo $item['tahun'];
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Kordinat</b>
                            </td><td>
								 <?php 
								if(isset($item['kordinat']))
								{
									echo "<a href=\"$item[kordinat]\" target=\"_blank\">$item[kordinat]</a>";
								}
								else
								{
									echo"-";
								}	
								?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>IP Service Port</b>
                            </td><td>
								 <?php 
								if(isset($ipservice))
								{
									foreach ($ipservice as $data_port)
									{ 
									echo $data_port['name']." | ".$data_port['port']."<br>"; 
									}	
								}
								else
								{
									echo"-";
								}			
								?>
                            </td>
                        </tr>
						<tr><td colspan="2">
								<?php if($this->session->userdata('ses_admin')=='1'):?>
                <a href="<?php echo base_url('manage/router/'.$item['id'].'/restart'); ?>" class="btn btn-info pull-left">Restart Router</a>
			<?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
            </div>
			
			
        </div>
		
		
<!-- START MENU ROUTER -->	
	<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<li class="active"><a href="#tab-bottom-left5" role="tab" data-toggle="tab">Access Point</a></li>
					<li><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Hotspot</a></li>
					
					<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Log</a></li>
				</ul>
			</div>

    </div>
	
	<div class="tab-content">

				<div class="tab-pane fade in active" id="tab-bottom-left5">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
			<div class="table-responsive">
			<table class="table table-hover table-bordered table-act" id="data-table1">

            <thead>

                <tr>
					<th>Area</th>
					<th>IP Address</th>
					<th style="text-align:center" width="10%">Status</th>
                </tr>

            </thead>

            <tbody>

                <?php 
				if(isset($data_lokalan))
				{
				foreach ($data_lokalan as $lokalan): 
				?>

                    <tr>
                        <td>
                            <?php echo $lokalan['area']; ?>
                        </td><td>
                            <?php echo $lokalan['ip']; ?>
                        </td><td style="text-align:center">
                            <?php 
							if($lokalan['status'] == "0") {echo"<span style=\"color:red; font-weight:bold\">DOWN</span>";} else{echo"<span style=\"color:green; font-weight:bold\">UP</span>";}
							?>
                        </td>
                    </tr>

                <?php endforeach; ?>
				<?php
				}
				else
				{
				echo "";
				}
				?>

            </tbody>

        </table>
		</div>						
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane fade" id="tab-bottom-left1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="tipe">Session Hotspot</label>
								<div class="table-responsive">
								<table class="table table-hover table-bordered table-act" id="data-table2" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>IP Address</th>
										<th>User</th>
										<th>Session Uptime</th>
										<th style="text-align:center">Tindakan</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(isset($hslogin))
									{
									foreach ($hslogin as $datahs): 
									?>
										<tr>
											<td>
												<?php echo $datahs['.id']; ?>
											</td><td>
												<?php echo $datahs['address']; ?>
											</td><td>
												<?php echo $datahs['user']; ?>
											</td><td>
												<?php echo $datahs['uptime']; ?>
											</td><td  style="text-align:center">
												<a href="<?php echo base_url('manage/router/'.$item['id'].'/hotspot/'.$datahs['.id'].''); ?>" onClick="javascript:return confirm('Session login user ini akan di hapus. Lanjutkan?')" class="btn btn-xs btn-danger">
													<i class="fa fa-trash-o"></i>
												</a>
											</td>
										</tr>
					
									<?php endforeach; ?>
									<?php
									}
									else
									{
									echo "";
									}
									?>				
								</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="tab-bottom-left2">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="table-responsive">
								<table class="table table-hover table-bordered table-act" id="data-table3" width="100%">
								<thead>
									<tr>
										<th width="15%">Waktu</th>
										<th>Informasi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data_log as $log): ?>
									<tr>
										<td><?php echo $log['tanggal']." - ".$log['jam']; ?></td>
										<td>
										<?php 
										echo $log['perangkat']." (".$log['perangkat_detail'].") dengan IP Address ".$log['ip']." termonitor ".$log['status']; 
										?>
										</td>
									</tr>
									<?php endforeach; ?>		
								</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
</div>
<!-- END PANEL HEADLINE -->

</div>

<!-- END PANEL HEADLINE -->
