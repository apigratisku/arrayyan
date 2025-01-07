<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title"><?php echo $item['nama']; ?></h3>
            </div>
            <div class="col-md-6 panel-action">
			<?php if($this->session->userdata('ses_admin')=='1'):?>
                <a href="<?php echo base_url('manage/router'); ?>" class="btn btn-warning">KEMBALI</a>
			<?php endif; ?>
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

        <div class="row">

            <div class="col-md-3">
                <a href="" class="thumbnail">
                    <?php if (empty($item['foto'])): ?>
                        <img src="<?php echo base_url('static/photos/router.jfif'); ?>">
                    <?php endif; ?>
                </a>
            </div>

            <div class="col-md-9">
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
                                <b>Lastmile (Antena)</b> 
                            </td><td>
                                <?php echo $item['lastmile']; ?> &nbsp;&raquo;&nbsp; <?php if($item['lastmile'] == "0") {echo"<span style=\"color:red; font-weight:bold\">DOWN</span>";} else{echo"<span style=\"color:green; font-weight:bold\">UP</span>";} ?>
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
									echo $data_resource['uptime']." %"; 
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
					<?php if($this->session->userdata('ses_admin')=='1'):?> 
					<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Layanan</a></li> 
					<?php endif; ?>
					<li><a href="#tab-bottom-left3" role="tab" data-toggle="tab">Sistem</a></li>
					<li><a href="#tab-bottom-left4" role="tab" data-toggle="tab">Log</a></li>
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
					<th>IP</th>
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
										<th>IP</th>
										<th>User</th>
										<th>Uptime</th>
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
						<div class="col-md-6">
							<div class="form-group">
								<a href="<?php echo base_url('manage/router/' . $item['id'] . '/blokir'); ?>" class="btn btn-danger">Isolir</a>
								<a href="<?php echo base_url('manage/router/' . $item['id'] . '/unblokir'); ?>" class="btn btn-success">Buka Isolir</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane fade" id="tab-bottom-left3">
					<div class="row">
						<div class="col-md-6">
							 <div class="form-group">
                                <?php if($this->session->userdata('ses_admin') == "1"): ?><a href="<?php echo base_url('manage/router/' . $item['id'] . '/backup'); ?>" class="btn btn-info" <?php if($item['up_down'] == "0"){echo "onclick=\"return alert('Maaf router dalam status offline.')\"";} ?>>Backup Rsc</a> <?php endif; ?>
								<a href="<?php echo base_url('manage/router/' . $item['id'] . '/restart'); ?>" class="btn btn-danger" <?php if($item['up_down'] == "0"){echo "onclick=\"return alert('Maaf router dalam status offline.')\"";} else { echo"onClick=\"javascript:return confirm('Router akan di reboot. Lanjutkan?')\""; } ?>>Restart</a>
                            </div>	 	 
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="tab-bottom-left4">
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
				

<div align="center">
			<?php if($this->session->userdata('ses_admin')=='1'):?>
                <a href="<?php echo base_url('manage/router'); ?>" class="btn btn-warning">KEMBALI</a>
			<?php endif; ?>
</div>			
<br />
</div>
<!-- END PANEL HEADLINE -->
</div>

<!-- END PANEL HEADLINE -->
