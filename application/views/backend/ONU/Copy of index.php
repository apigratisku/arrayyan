<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA ONU</div>

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
			  <?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
                <a href="<?php echo base_url('manage/onu/tambah'); ?>" class="btn btn-info pull-right">Tambah Data</a>
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
       <table class="table table-bordered table-hover" id="example1" style="font-size:10px">

            <thead>

                <tr>
					<th>OLT</th>
                    <th>Pelanggan</th>
					<th style="text-align:center">Layanan</th>
					<th style="text-align:center">SN Perangkat</th>
					<th style="text-align:center">ODP</th>
					<th style="text-align:center">QNQ</th>
					<th style="text-align:center">PON</th>
					
					<th style="text-align:center">Vlan</th>
					<th style="text-align:center">Index</th>
					<th style="text-align:center">MGMT</th>
					<th style="text-align:center">Status</th>
					<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
                    <th style="text-align:center" width="23%">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>
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
                        <td>
                            <?php echo $id_olt['olt_nama']; ?>
                        </td><td>
                            <?php echo $id_pelanggan['nama'];  ?>
                        </td>
						<td valign="top" align="center">
                          <?php 
						  if(isset($id_layanan1['id'])){
						  echo $id_produk1['produk'];
						  }
						  if(isset($id_layanan2['id'])){
						  echo "<br>".$id_produk2['produk']."<br>";
						  }
						  if(isset($id_layanan3['id'])){
						  echo $id_produk3['produk'];
						  }
						  
						  ?>  
                        </td>
						<td align="center">
                           <?php echo $item['serial_number']; ?>
                        </td><td align="center">
                           <?php 
						   if(isset($odp['id'])){
						  echo $odp['odp'];
						  } ?>
                        </td><td align="center">
                           <?php echo $item['qnq_vlan']; ?>
                        </td><td align="center">
                           <?php 
						  if(isset($id_layanan1['id'])){
						  echo $id_layanan1['pon'];
						  }
						  if(isset($id_layanan2['id'])){
						  echo "<br>".$id_layanan2['pon']."<br>";
						  }
						  if(isset($id_layanan3['id'])){
						  echo $id_layanan3['pon'];
						  }
						  
						  ?>
                        </td><td align="center">
                           <?php 
						  if(isset($id_layanan1['id'])){
						  echo $id_layanan1['vlan'];
						  }
						  if(isset($id_layanan2['id'])){
						  echo "<br>".$id_layanan2['vlan']."<br>";
						  }
						  if(isset($id_layanan3['id'])){
						  echo $id_layanan3['vlan'];
						  }
						  ?>
                        </td><td align="center">
                           <?php echo $item['onu_index']; ?>
                        </td><td align="center">
                           <?php echo $item['mgmt_ip']; ?>
                        </td><td align="center">
						<?php if($item['status'] == "Running"): ?>
                           <small class="label bg-green"><?php echo $item['status']; ?></small>
						   <?php else: ?>
						   <small class="label bg-orange"><?php echo $item['status']; ?></small>
						   <?php endif; ?>
                        </td>
						
						
						<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
						<td  style="text-align:center">
						<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/generate'); ?>" class="btn btn-xs btn-primary" onClick="javascript:return confirm('Proses generate konfigurasi. Lanjutkan ?')" title="Upload Konfigurasi">Generate</a> <a href="<?php echo base_url('manage/onu/' . $item['id'] . '/unconfig'); ?>" class="btn btn-xs btn-danger" onClick="javascript:return confirm('Proses remove konfigurasi. Lanjutkan ?')" title="Remove Konfigurasi">Unconfig</a>
                            <a href="<?php echo base_url('manage/onu/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/onu/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
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
