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
       <table class="table table-bordered table-hover" id="example1" style="font-size:8px">

            <thead>

                <tr>
					<th style="width:5%">No.</th>
                    <th>Customers</th>	
					<th>Case</th>
					<th style="text-align:center; vertical-align:middle" width="8%">Status</th>
					<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
                    <th style="text-align:center; vertical-align:middle" nowrap="nowrap">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php $no=1; foreach ($items as $item): ?>
 				
                    <tr>
                        <td>
                            <?php echo $no; ?> 
                        </td><td>
                       <?php $pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['customers']))->row_array(); echo $pelanggan['nama']; ?> 
                        </td><td>
                       <?php echo $item['case_gangguan']; ?> 
                        </td><td style="text-align:center">
					   <?php 
							if($item['status'] == "Pending") {echo"<span class=\"label label-danger\">Pending</span>";} elseif($item['status'] == "Solved"){echo"<span class=\"label label-success\">Solved</span>";}elseif($item['status'] == "Progress"){echo"<span class=\"label label-primary\">Progress</span>";}elseif($item['status'] == "Monitoring"){echo"<span class=\"label label-warning\">Monitoring</span>";}else{echo"<span class=\"label label-info\">Scheduled</span>";}
							?>
                        </td>
						<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
						<td  style="text-align:center; font-size:9px" nowrap="nowrap">
						<form action="" name="act">
						<select class="form-control" id="permintaan" name="req" placeholder="-Action-" value="" onChange="top.location.href = this.form.req.options[this.form.req.selectedIndex].value;
return false;" style="font-size:7px; height:40%">			<option value="" selected="selected">-Action-</option>
						<option value="<?php echo base_url('manage/noc_tiket_list/'.$item['id'].'/detil'); ?>">Detil</option>
						<option value="<?php echo base_url('manage/noc_tiket_list/'.$item['id'].'/ubah'); ?>">Ubah</option>
						<option value="<?php echo base_url('manage/noc_tiket_list/'.$item['id'].'/detil'); ?>">Hapus</option>
						</select>
						</form>

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



