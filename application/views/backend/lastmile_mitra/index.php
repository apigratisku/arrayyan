<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			TECHNICAL - LASTMILE MITRA
			</div>
			<br>

    <div class="panel-heading">

		<!-- /.box-body -->
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
              <div class="box-footer">
                <a href="<?php echo base_url('manage/lastmile_mitra/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
              </div>
		<?php endif; ?>
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
       <table class="table table-bordered table-hover" id="example1" style="font-size:9px">

            <thead>

                <tr>
                    <th>Mitra</th>
					<th>Pelanggan</th>
					<th>CID</th>
					<th>Alamat</th>
					<th>Latitude</th>
					<th>Longtitude</th>
					<th>Status</th>
					<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
                    <th style="text-align:center" width="15%">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php echo $item['mitra']; ?>
                        </td> <td>
                            <?php 
							$query = $this->db->get_where('blip_pelanggan', array('id' => $item['pelanggan']));
           					$get_data = $query->row_array();
							echo $get_data['nama']; 
							?>
                        </td> <td>
                            <?php echo $item['cid']; ?>
                        </td><td>
                            <?php echo $item['alamat']; ?>
                        </td><td>
                            <?php echo $item['latitude']; ?>
                        </td><td>
                            <?php echo $item['longtitude']; ?>
                        </td> <td nowrap>
                                <span style="font-weight:bold"><?php if($item['status'] == "0"){echo "<span style=\"color: red\">&#9745 Nonactive</span>";}else{echo "<span style=\"color: green\">&#9989; Active</span>";} ?></span>
                            </td>
							<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
							<td  style="text-align:center">
                            <a href="<?php echo base_url('manage/lastmile_mitra/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/lastmile_mitra/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
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
