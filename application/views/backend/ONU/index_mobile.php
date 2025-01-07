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
                    <th>Pelanggan</th>
					<th style="text-align:center">TX</th>
					<th style="text-align:center">RX</th>
					<th style="text-align:center">Phase</th>
					<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
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
                            <?php echo $id_pelanggan['nama'];  ?>
                        </td>
						<td align="center">
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
						
						
						<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'): ?>
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
