<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">ADMIN  - WO (WORK ORDER)</div>
<br>


	
	<div class="panel-heading">
       <div class="box-footer">
	   		
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'): ?>
                <a href="<?php echo base_url('manage/wo/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>			
					<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export"><i class="fa fa-download"></i>&nbsp;Export Data</button>
					<a href="<?php echo base_url('manage/wo/wo_reminder'); ?>" class="btn btn-danger"><i class="fa fa-envelope"></i>&nbsp; Push Notifikasi</a>
			 <?php endif; ?>
			 
        </div>
    </div>
	
	<div class="modal fade" id="modal-export">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter Export Data</h4>
              </div>
              <div class="modal-body">
                <p>
				<?php
					echo form_open('manage/wo/export');
				?>
				<div class="form-group">
                <label for="nama_keahlian">WO Data</label>
                 <select class="form-control" id="wo" name="wo" required>								
				 <option value="all">Semua</option>	
				</select>
            	</div>
				
				
				
				</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="export" value="Export">
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

            <div class="alert alert-warning">
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

                <tr valign="middle">
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">CID</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">SID</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">Pelanggan</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">Request</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">Sub Request</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Pekerjaan <br />Teknis</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Report <br />Teknis</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Status</th>
                    <th style="text-align:center; vertical-align:middle" nowrap="nowrap">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>
				<?php
				if($item['tgl_report_teknis'] != NULL && $item['tgl_report_teknis'] != NULL){
					$update_status = array(
					'status' => "1",
					'status_pelanggan' => "1",
					);				
					$this->db->where('id', $item['id']);
					$update_wo = $this->db->update('blip_wo', $update_status);	
					if($update_wo){		
					$update_pelanggan = array(
					'status_pelanggan' => "1",
					'history_waktu' => date("Y-m-d H:i"),
					'history_iduser' => $this->session->userdata('ses_id'),
					);	
					$this->db->where('id_wo', $item['id']);
					$this->db->update('blip_pelanggan', $update_pelanggan);
					}
				}else{
					$update_status = array(
					'status' => "0",
					);				
					$this->db->where('id', $item['id']);
					$this->db->update('blip_wo', $update_status);
				}
				?>
                    <tr>
                         <td style="text-align:center;">
                            <?php echo $item['cid']; ?>
                        </td> <td style="text-align:center;">
                            <?php echo $item['sid']; ?>
                        </td><td>
                            <?php echo $item['nama']; ?>
                        </td><td style="text-align:center;">
							<?php 
							$data_request = $this->db->get_where('blip_kpi', array('id' => $item['request']))->row_array();
							$kpi_induk = $this->db->get_where('blip_kpi_induk', array('id' => $data_request['klasifikasi']))->row_array();
							echo $kpi_induk['kegiatan']; 
							?>
                        </td> 
						<td style="text-align:center;">
                           <?php 
							echo $data_request['kegiatan']; 
							?>
                        </td><td style="text-align:center;">
                            <?php echo $item['tgl_aktivasi_teknis']; ?>
                        </td><td style="text-align:center;">
                            <?php echo $item['tgl_report_teknis']; ?>
                        </td>
						<td style="text-align:center" width="8%">
                                <span style="font-weight:bold">
								<?php 
								if($item['status'] == "0"){echo "<span class=\"label label-danger\">Baru</span>";}else{echo "<span class=\"label label-success\">Selesai</span>";} 
								?>
								</span>
                            </td><td  style="text-align:center">
							<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
							<?php if($item['status'] == "0"): ?>
							<a href="<?php echo base_url('manage/wo/' . $item['id'] . '/batalkan'); ?>" class="btn btn-xs btn-danger" onClick="javascript:return confirm('WO akan dibatalkan. Lanjutkan?')" class="btn btn-xs btn-danger">
                                Batalkan
                            </a>
							<?php endif;?>
							<?php endif; ?>
                            <a href="<?php echo base_url('manage/wo/' . $item['id']); ?>" class="btn btn-xs btn-primary">
                                Detail
                            </a>
							<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
							<a href="<?php echo base_url('manage/wo/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/wo/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
                            </a>
							<?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->
