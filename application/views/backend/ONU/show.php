<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA ONU - Detail</div>

    
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
	<table class="table table-striped table-bordered" style="font-size:10px">
	<tr>
	<td>
	
	<table class="table table-striped table-bordered" style="font-size:10px">
            
				<?php 
				$id_olt = $this->db->get_where('blip_olt', array('id' => $item['id_olt']))->row_array();
				$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array();
				$id_layanan1 = $this->db->get_where('blip_layanan', array('id' => $item['id_layanan1']))->row_array();
				$id_layanan2 = $this->db->get_where('blip_layanan', array('id' => $item['id_layanan2']))->row_array();
				$id_layanan3 = $this->db->get_where('blip_layanan', array('id' => $item['id_layanan3']))->row_array();
				$id_produk1 = $this->db->get_where('blip_produk', array('id' => $id_layanan1['id_produk']))->row_array();
				$id_produk2 = $this->db->get_where('blip_produk', array('id' => $id_layanan2['id_produk']))->row_array();
				$id_produk3 = $this->db->get_where('blip_produk', array('id' => $id_layanan3['id_produk']))->row_array();
				$odp = $this->db->get_where('gm_mapping', array('id' => $id_layanan1['odp']))->row_array();
				?>
                <tr>
					<td style="text-align:right; font-weight:bold;font-size:12px; width:20%">OLT</td>
					<td><?php echo $id_olt['olt_nama']; ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">Pelanggan</td>
					<td style="font-weight:bold"> <?php echo $id_pelanggan['nama'];  ?></td>
				</tr>
				<tr>
                   <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">Layanan</td>
					<td>
					<?php 
						  if(isset($id_layanan1['id'])){
						  echo $id_produk1['produk']." ".$id_layanan1['id_bandwidth']." Mbps";
						  }
						  if(isset($id_layanan2['id'])){
						  echo "<br>".$id_produk2['produk']." ".$id_layanan2['id_bandwidth']." Mbps<br>";
						  }
						  if(isset($id_layanan3['id'])){
						  echo $id_produk3['produk']." ".$id_layanan3['id_bandwidth']." Mbps";
						  }
						 ?> 
					</td>
				</tr>
				<tr>
                   <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">SN Perangkat</td>
					<td> <?php echo $item['serial_number'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">ODP</td>
					<td> <?php echo $odp['odp'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">QNQ Vlan</td>
					<td> <?php echo $item['qnq_vlan'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">Vlan</td>
					<td> <?php echo $id_layanan1['vlan'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">PON</td>
					<td> <?php echo $id_layanan1['pon'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">Index</td>
					<td> <?php echo $item['onu_index'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">IP Management</td>
					<td> <?php echo $item['mgmt_ip'];  ?></td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">Status</td>
					<td> 
							<?php if($item['status'] == "Running"): ?>
                           <small class="label bg-green"><?php echo $item['status']; ?></small>
						   <?php else: ?>
						   <small class="label bg-orange"><?php echo $item['status']; ?></small>
						   <?php endif; ?>
					</td>
				</tr>
				<tr>
                    <td style="text-align:right; font-weight:bold;font-size:12px; width:20%">Action</td>
					<td> 
			<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/generate'); ?>" class="btn btn-xs btn-primary" onClick="javascript:return confirm('Proses generate konfigurasi. Lanjutkan ?')" title="Upload Konfigurasi">Generate Config</a> <a href="<?php echo base_url('manage/onu/' . $item['id'] . '/unconfig'); ?>" class="btn btn-xs btn-danger" onClick="javascript:return confirm('Proses remove konfigurasi. Lanjutkan ?')" title="Remove Konfigurasi">Unconfig</a>
			<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning" title="Ubah Data Onu">
			Ubah
			</a>
			<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data? Konfigurasi ONU pada OLT akan terhapus. Lanjutkan Proses?')" class="btn btn-xs btn-danger" title="Hapus Data ONU">
			Hapus
			</a>
					</td>
				</tr>
          
        </table>
		
		<table class="table table-striped table-bordered" style="font-size:10px">
          
				
                <tr>
					<td style="text-align:center; font-weight:bold;font-size:12px; width:20%; vertical-align:middle">REDAMAN</td>
					<td>
					
					<table class="table table-striped table-bordered" style="font-size:10px">
						
							
							<tr>
								<td style="text-align:right; font-weight:bold;font-size:10px; width:20%">TX (OLT)</td>
								<td><?php echo $item['up_tx']; ?></td>
							</tr>
							<tr>
								<td style="text-align:right; font-weight:bold;font-size:10px; width:20%">RX (ONU)</td>
								<td><?php echo $item['down_rx']; ?></td>
							</tr>
							<tr>
								<td style="text-align:right; font-weight:bold;font-size:10px; width:20%">Phase State</td>
								<td>
								<?php if($item['phase_state'] == "working"): ?>
							   <small class="label bg-green"><?php echo $item['phase_state']; ?></small>
							   <?php else: ?>
							   <small class="label bg-red"><?php echo $item['phase_state']; ?></small>
							   <?php endif; ?>
								</td>
							</tr>
							<tr>
								<td style="text-align:right; font-weight:bold;font-size:11px; width:20%">Action</td>
								<td> 
								<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/redaman'); ?>" class="btn btn-xs btn-warning" title="Refresh Redaman">
			Refresh
			</a>
								</td>
							</tr>
					</table>
					</td>
					</tr>	
					</table>	
					
					<table class="table table-striped table-bordered" style="font-size:10px">
					<tr>
					<td style="text-align:center; font-weight:bold;font-size:12px; width:20%; vertical-align:middle">Ethernet Port</td>
					<td>
					
					<table class="table table-striped table-bordered" style="font-size:10px">
					<tr>
					<td style="text-align:center; font-weight:bold;font-size:12px; width:20%">Port</td>
					<td style="text-align:center; font-weight:bold;font-size:12px; width:20%">Status</td>
					<td style="text-align:center; font-weight:bold;font-size:12px; width:20%">Action</td>
					</tr>
					<tr style="text-align:center">
					<td>eth_0/1</td>
					<td><?php echo $item['port1']; ?></td>
					<td>
					<?php if($item['port1'] == "lock"): ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/1/unlock/onu_port'); ?>" class="btn btn-xs btn-primary">Enable</a>
					<?php else: ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/1/lock/onu_port'); ?>" class="btn btn-xs btn-danger">Disable</a>
					<?php endif;?>
		
					</td>
					</tr>
					<tr style="text-align:center">
					<td>eth_0/2</td>
					<td><?php echo $item['port2']; ?></td>
					<td>
					<?php if($item['port2'] == "lock"): ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/2/unlock/onu_port'); ?>" class="btn btn-xs btn-primary">Enable</a>
					<?php else: ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/2/lock/onu_port'); ?>" class="btn btn-xs btn-danger">Disable</a>
					<?php endif;?>
					</td>
					</tr>
					<tr style="text-align:center">
					<td>eth_0/3</td>
					<td><?php echo $item['port3']; ?></td>
					<td>
					<?php if($item['port3'] == "lock"): ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/3/unlock/onu_port'); ?>" class="btn btn-xs btn-primary">Enable</a>
					<?php else: ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/3/lock/onu_port'); ?>" class="btn btn-xs btn-danger">Disable</a>
					<?php endif;?>
					</td>
					</tr>
					<tr style="text-align:center">
					<td>eth_0/4</td>
					<td><?php echo $item['port4']; ?></td>
					<td>
					<?php if($item['port4'] == "lock"): ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/4/unlock/onu_port'); ?>" class="btn btn-xs btn-primary">Enable</a>
					<?php else: ?>
					<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/4/lock/onu_port'); ?>" class="btn btn-xs btn-danger">Disable</a>
					<?php endif;?>
					</td>
					</tr>
					</table>
								
					</td>
				</tr>
				
        </table>
		
		
		
	
	</td>
	<td style="text-align:center; vertical-align:top; width:40%">
	<img src="<?php echo base_url(); ?>/static/assets/img/ZTE-f609.png" alt="Get Biget Image" width="90%">
	<br>
		<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/onu_profile'); ?>" class="btn btn-sm btn-primary">Show Profile</a>
		<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/onu_pon'); ?>" class="btn btn-sm btn-primary">Show Onu Config</a>  
		<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/onu_detail_log'); ?>" class="btn btn-sm btn-primary">Show Onu Log</a> 
		<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/onu_reboot'); ?>" onClick="javascript:return confirm('ONU akan di restart. Lanjutkan proses reboot?')" class="btn btn-sm btn-danger" title="Reboot ONU">Reboot</a>
	<br /><br /><br />
	
	<?php 
	if(isset($result)):
	?>
	<table class="table table-bordered" style="font-size:10px; background-color:#FFFF99">
	<tr>
	<td><?php echo $result;  ?></td>
	</tr>
	</table>	
	<?php endif; ?>
	
	</td>
	</tr>
	</table>
</div>       


              <div class="box-footer">
			  <?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
                <a href="<?php echo base_url('manage/onu/'); ?>" class="btn btn-danger pull-right">Kembali</a>
				<?php endif; ?>
              </div>


    </div>

</div>


<!-- END PANEL HEADLINE -->
