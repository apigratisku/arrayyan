<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			NOC - SISTEM TIKET - LIST
			</div>
			<br>

	
	<div class="panel-heading">
       <div class="box-footer">

		<!-- /.box-body -->
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'): ?>
              <div class="box-footer">
		<a href="<?php echo base_url('manage/noc_tiket_list/'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Data Tiket</a>
        <a href="<?php echo base_url('manage/noc_tiket_list/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export1" onclick="$('form').attr('target', '_blank');"><i class="fa fa-download"></i>&nbsp;Export PDF</button>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export2" onclick="$('form').attr('target', '_blank');"><i class="fa fa-download"></i>&nbsp;Export Excel</button>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-database"></i>&nbsp;Filter Data</button>
		
              </div>
		<?php endif; ?>
    	</div>
	</div>
	
    <div class="modal fade" id="modal-export1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter Export PDF</h4>
              </div>
              <div class="modal-body">
                <p>
				<?php
					echo form_open('manage/noc_tiket_list/export_pdf');
				?>
				<div class="form-group">
                <label for="nama_keahlian">Tanggal Start</label>
                <input style="width:170px" type="text" class="form-control datetimepicker-alt" id="datetime1" name="tgl_a" placeholder="Pilih Tanggal Mulai" required autofocus>
					<script type="text/javascript">
					$("#datetime1").datetimepicker({
						format: 'yyyy-mm-dd',
						autoclose: true
					});
					</script>
            	</div>
				
				<div class="form-group">
                <label for="nama_keahlian">Tanggal End</label>
                 <input style="width:170px" type="text" class="form-control datetimepicker-alt" id="datetime2" name="tgl_b"  placeholder="Pilih Tanggal Akhir"  required autofocus>
					<script type="text/javascript">
					$("#datetime2").datetimepicker({
						format: 'yyyy-mm-dd',
						autoclose: true
					});
					</script>
           		 </div>

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
		
	
	<div class="modal fade" id="modal-export2">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter Export Excel</h4>
              </div>
              <div class="modal-body">
                <p>
				<?php
					echo form_open('manage/noc_tiket_list/export_xls');
				?>
				<div class="form-group">
                <label for="nama_keahlian">Tanggal Start</label>
                <input style="width:170px" type="text" class="form-control datetimepicker-alt" id="datetime3" name="tgl_a" placeholder="Pilih Tanggal Mulai" required autofocus>
					<script type="text/javascript">
					$("#datetime3").datetimepicker({
						format: 'yyyy-mm-dd',
						autoclose: true
					});
					</script>
            	</div>
				
				<div class="form-group">
                <label for="nama_keahlian">Tanggal End</label>
                 <input style="width:170px" type="text" class="form-control datetimepicker-alt" id="datetime4" name="tgl_b"  placeholder="Pilih Tanggal Akhir"  required autofocus>
					<script type="text/javascript">
					$("#datetime4").datetimepicker({
						format: 'yyyy-mm-dd',
						autoclose: true
					});
					</script>
           		 </div>

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
	
	
	<div class="modal fade" id="modal-filter">
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
					echo form_open('manage/noc_tiket_list/do_filter');
				?>
				<div class="form-group">
                        <label for="level">Pelanggan</label>
                        <select style="width:60%" class="form-control" id="pelanggan" name="pelanggan" placeholder="Data Pelanggan" value="">					
						<option value="">-List Pelanggan-</option>
						<?php foreach ($item_pelanggan as $pelanggan): ?>
						<?php 
						if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";$disabled="";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
						?>
						<option value="<?php echo $pelanggan['id']; ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
						<?php endforeach; ?>
						</select>
             	</div>
				
				<div class="form-group">
                <label for="nama_keahlian">Tanggal Start</label>
                <input type="text" class="form-control" id="datetime5" name="tgl_a" value="<?php echo isset($item['tgl_open']) ? $item['tgl_open']." ".$item['jam_open'] : ''; ?>" autofocus required>
            </div>
			<script type="text/javascript">
			$("#datetime5").datetimepicker({
				format: 'yyyy-mm-dd',
				autoclose: true
			});
			</script>
			<div class="form-group">
                <label for="nama_keahlian">Tanggal End</label>
                <input type="text" class="form-control" id="datetime6" name="tgl_b" value="<?php echo isset($item['tgl_close_sla']) ? $item['tgl_close_sla']." ".$item['jam_close_sla'] : ''; ?>" autofocus>
            </div>
			<script type="text/javascript">
			$("#datetime6").datetimepicker({
				format: 'yyyy-mm-dd',
				autoclose: true
			});
			</script>
				
				
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
       <table class="table table-bordered table-hover" id="example1" style="font-size:10px">

            <thead>

                <tr>
					<th style="width:2%">No.</th>
                    <th>Customers</th>	
					<th>Case</th>
					<th>Case Klasifikasi</th>
					<th>Case Sub Klasifikasi</th>
					<th>Waktu Open</th>
					<th>Waktu Close</th>
					<th>Close SLA</th>
					<th style="text-align:center; vertical-align:middle" width="4%">Status</th>
					<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
                    <th style="text-align:center; vertical-align:middle" nowrap="nowrap">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php $no=1; foreach ($items as $item): ?>
				
								<?php 
								/*
								//Hitung Durasi 
								$awal  = strtotime($item['tgl_open']." ".$item['jam_open']);
								$akhir = strtotime($item['tgl_close']." ".$item['jam_close']);
								//$awal  = strtotime('2017-08-10 10:05:25');
								//$akhir = strtotime('2017-08-11 11:07:33');
								$diff  = $akhir - $awal;
								
								$jam   = floor($diff / (60 * 60));
								$menit = $diff - ( $jam * (60 * 60) );
								$detik = $diff % 60;
								$str_jam = $jam * 60;
								$str_menit = floor( $menit / 60 );
								$str_durasi = $str_jam+$str_menit;
								echo $str_durasi." menit";
								//echo $item['durasi']; 
								
								$data = array(
								'durasi' => $str_durasi,
								);					
								$this->db->where('id', $item['id']);
								$update_db = $this->db->update('blip_tiket_list', $data);	
								*/
								
								//Hitung Durasi 
								/*
								$open = $item['tgl_open']." ".$item['jam_open'];
								$close = $item['tgl_close']." ".$item['jam_close'];
								$awal  = strtotime($open);
								$akhir = strtotime($close);
								//$awal  = strtotime('2017-08-10 10:05:25');
								//$akhir = strtotime('2017-08-11 11:07:33');
								$diff  = $akhir - $awal;
								
								$jam   = floor($diff / (60 * 60));
								$menit = $diff - ( $jam * (60 * 60) );
								$detik = $diff % 60;
								$str_jam = $jam * 60;
								$str_menit = floor( $menit / 60 );
								$str_durasi = $str_jam+$str_menit;
								
								$data = array(
								'tgl_close_sla' => $item['tgl_open'],
								'jam_close_sla' => $item['jam_close'],
								'durasi_sla' => $str_durasi,
						
								);					
								$this->db->where('id', $item['id']);
								$update_db = $this->db->update('blip_tiket_list', $data);
									*/					
								
								?>
 				
                    <tr>
                        <td>
                            <?php echo $no; ?> 
                        </td><td>
                       <?php $pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['customers']))->row_array(); echo $pelanggan['nama']; ?> 
                        </td><td>
                       <?php echo $item['case_gangguan']; ?> 
                        </td><td>
                        <?php $case_klasifikasi = $this->db->get_where('blip_tiket_case_klasifikasi', array('id' => $item['case_klasifikasi']))->row_array(); echo $case_klasifikasi['nama']; ?>  
                        </td><td>
                        <?php $case_subklasifikasi = $this->db->get_where('blip_tiket_case_subklasifikasi', array('id' => $item['case_subklasifikasi']))->row_array(); echo $case_subklasifikasi['nama']; ?>  
                        </td><td>
                       <?php echo $item['tgl_open']." ".$item['jam_open']; ?> 
                        </td><td>
                      <?php echo $item['tgl_close']." ".$item['jam_close']; ?>  
                        </td><td>
                      <?php 
					  echo $item['tgl_close_sla']." ".$item['jam_close_sla']; ?>  
                        </td><td style="text-align:center">
					   <?php 
							if($item['status'] == "Pending") {echo"<span class=\"label label-danger\">Pending</span>";} elseif($item['status'] == "Solved"){echo"<span class=\"label label-success\">Solved</span>";}elseif($item['status'] == "Progress"){echo"<span class=\"label label-primary\">Progress</span>";}elseif($item['status'] == "Monitoring"){echo"<span class=\"label label-warning\">Monitoring</span>";}else{echo"<span class=\"label label-info\">Scheduled</span>";}
							?>
                        </td>
						<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
						<td  style="text-align:center; font-size:10px" nowrap="nowrap">
						<a href="<?php echo base_url('manage/noc_tiket_list/' . $item['id'] . '/detil'); ?>" class="btn btn-xs btn-primary">
                                Detail
                            </a>
                            <a href="<?php echo base_url('manage/noc_tiket_list/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/noc_tiket_list/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
                            </a>
                        </td>
						<?php endif; ?>
						</tr>
                    </tr>
	
                <?php $no++; endforeach; ?>

            </tbody>

        </table>
		
		<?php //echo $_SERVER['DOCUMENT_ROOT']; ?>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->



