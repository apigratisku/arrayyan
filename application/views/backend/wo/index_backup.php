<div class="panel panel-headline">
<div style="background-color:#902e2e; font-weight:bold; color:#FFFFFF; font-size:20px; padding:10px 0px 10px 10px">ADMIN  - WO (WORK ORDER)</div>
<br>

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo base_url('manage/wo/tambah'); ?>" class="btn btn-info pull-right">Tambah Data</a>
              </div>
    </div>



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
       <table class="table table-bordered table-hover" id="example1" style="font-size:10px">

            <thead>

                <tr valign="middle">
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">CID</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">SID</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">Pelanggan</th>
					<th style="text-align:center; vertical-align:middle" width="15%">Request</th>
					<th style="text-align:center; vertical-align:middle" nowrap="nowrap">KPI</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Pekerjaan <br />Teknis</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Report <br />Teknis</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Status</th>
                    <th style="text-align:center; vertical-align:middle" nowrap="nowrap">Tindakan</th>
                </tr>

            </thead>

            <tbody>
				<?php  
				function selisih_waktu($date1, $date2, $format = false) 
							{
								$diff = date_diff( date_create($date1), date_create($date2) );
								if ($format)
									return $diff->format($format);
								
								return array('y' => $diff->y,
											'm' => $diff->m,
											'd' => $diff->d,
											'h' => $diff->h,
											'i' => $diff->i,
											's' => $diff->s
										);
							}
				?>
                <?php foreach ($items as $item): ?>
				<?php
				if($item['tgl_report_teknis'] != NULL && $item['tgl_report_teknis'] != NULL){
					$update_status = array(
					'status' => "1",
					);				
					$this->db->where('id', $item['id']);
					$this->db->update('blip_wo', $update_status);			
				}else{
					$update_status = array(
					'status' => "0",
					);				
					$this->db->where('id', $item['id']);
					$this->db->update('blip_wo', $update_status);
				}
				?>
                    <tr>
                         <td>
                            <?php echo $item['cid']; ?>
                        </td> <td>
                            <?php echo $item['sid']; ?>
                        </td><td>
                            <?php echo $item['nama']; ?>
                        </td><td>
							<?php 
							$query_request = $this->db->get_where('blip_kpi', array('id' => $item['request']));
           					$data_request = $query_request->row_array();
							echo $data_request['kegiatan']; 
							?>
                        </td> 
						<td style="text-align:center; font-weight:bold" width="8%">
                            <?php
							
							
							if($item['tgl_report_teknis'] != NULL){
								$diff = selisih_waktu($item['tgl_req_teknis'], $item['tgl_report_teknis']);
								if($diff['d'] <= $data_request['durasi']){
								echo "<span style=\"color:green\">&#9989; Tercapai</span>";
								}else {
								echo "<span style=\"color:red\">&#9745 Tidak Tercapai</span>";
								}
							}else{
								$dt = $item['tgl_req_teknis'];
								$nyawa_tanggal =  date( "Y-M-d", strtotime("$dt +".$data_request['durasi']." day" ));
								$sisanyawa = date( "Y-M-d", strtotime("$nyawa_tanggal -".$data_request['durasi']." day" ));
								$diff = selisih_waktu(date("Y-m-d"),$nyawa_tanggal);
								echo $diff['d']." Hari";
							}
							 
							 ?>
                        </td><td>
                            <?php echo $item['tgl_aktivasi_teknis']; ?>
                        </td><td>
                            <?php echo $item['tgl_report_teknis']; ?>
                        </td>
						<td style="text-align:center" width="8%">
                                <span style="font-weight:bold">
								<?php 
								if($item['status'] == "0"){echo "<span style=\"color: red\">&#9745 Baru</span>";}else{echo "<span style=\"color: green\">&#9989; Selesai</span>";} 
								?>
								</span>
                            </td><td  style="text-align:center">
							<?php if($item['status'] == "0"): ?>
							<a href="<?php echo base_url('manage/wo/' . $item['id'] . '/batalkan'); ?>" class="btn btn-xs btn-danger" onClick="javascript:return confirm('WO akan dibatalkan. Lanjutkan?')" class="btn btn-xs btn-danger">
                                Batalkan
                            </a>
							<?php endif;?>
                            <a href="<?php echo base_url('manage/wo/' . $item['id']); ?>" class="btn btn-xs btn-primary">
                                Detail
                            </a>
							<a href="<?php echo base_url('manage/wo/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/wo/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
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
