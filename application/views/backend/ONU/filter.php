<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA ONU</div>

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
			  <?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'): ?>
			  <a href="<?php echo base_url('manage/onu'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Data ONU</a>
			  <a href="<?php echo base_url('manage/onu/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
                <a href="<?php echo base_url('manage/onu/export'); ?>" class="btn btn-warning"><i class="fa fa-download"></i>&nbsp;Export Data</a>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-export"><i class="fa fa-database"></i>&nbsp;Filter Data</button>
				<?php endif; ?>
              </div>
			  <div class="box-footer">
	   		

	  
        </div>
    </div>
	
	<div class="modal fade" id="modal-export">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter Data</h4>
              </div>
              <div class="modal-body">
                <p>
				<?php
					echo form_open('manage/onu/do_filter');
				?>
				<div class="form-group">
                        <label for="level">OLT</label>
                        <select class="form-control" id="olt" name="olt" placeholder="Data OLT" value="">					
						<option value="">-OLT-</option>
						<?php foreach ($item_olt as $olt): ?>
						<option value="<?php echo $olt['id']; ?>"><?php echo $olt['olt_nama']; ?></option>
						<?php endforeach; ?>
						</select>
             	</div>
				
				<div class="form-group">
                        <label for="level">QNQ Vlan</label>
                        <select class="form-control" id="qnq_vlan" name="qnq_vlan" placeholder="Data QNQ" value="">					
						<option value="">-QNQ Vlan-</option>
						<option value="2201">2201</option>
						<option value="2202">2202</option>
						<option value="2203">2203</option>
						<option value="2204">2204</option>
						<option value="2205">2205</option>
						<option value="2206">2206</option>
						<option value="2207">2207</option>
						<option value="2208">2208</option>
						<option value="2209">2209</option>
						<option value="2210">2210</option>
						<option value="2211">2211</option>
						<option value="2212">2212</option>
						<option value="2213">2213</option>
						<option value="2214">2214</option>
						<option value="2215">2215</option>
						<option value="2216">2216</option>
						<option value="2217">2217</option>
						<option value="2218">2218</option>
						<option value="2219">2219</option>
						<option value="2220">2220</option>
						</select>
             	</div>
				
				
				</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="tampilkan" value="Tampilkan">
              </div>
			  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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
       <table class="table table-bordered table-hover" id="example2" style="font-size:10px">

            <thead>

                <tr>
					<th>OLT</th>
                    <th>Pelanggan</th>
					<th style="text-align:center">SN Perangkat</th>
					<th style="text-align:center">ODP</th>
					<th style="text-align:center">QNQ</th>
					<th style="text-align:center">PON</th>
					
					<th style="text-align:center">Vlan</th>
					<th style="text-align:center">Index</th>
					<th style="text-align:center">MGMT</th>
					<th style="text-align:center">TX</th>
					<th style="text-align:center">RX</th>
					<th style="text-align:center">Phase</th>
					<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'): ?>
                    <th style="text-align:center">Tindakan</th>
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
                           <?php echo $item['up_tx']; ?>
                        </td><td align="center">
                           <?php echo $item['down_rx']; ?>
                        </td><td align="center">
                            <?php if($item['phase_state'] == "working"): ?>
							   <small class="label bg-green"><?php echo $item['phase_state']; ?></small>
							   <?php else: ?>
							   <small class="label bg-red"><?php echo $item['phase_state']; ?></small>
							   <?php endif; ?>
                        </td>
						
						
						<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'): ?>
						<td  style="text-align:center">
						<a href="<?php echo base_url('manage/onu/' . $item['id'] . '/detail'); ?>" class="btn btn-xs btn-primary" title="Detail Onu">Detail</a>
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
