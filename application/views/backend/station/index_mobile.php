<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">BTS - RADIO STATION / CLIENT</div>

   <div class="panel-heading">
             <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
            <div class="box-footer">
			<a href="<?php echo base_url('manage/station/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;TAMBAH</a>
			<a href="<?php echo base_url('manage/station/reloadall'); ?>" class="btn btn-danger" onclick="return confirm('Refresh Seluruh Data Wireless? Lanjutkan?');">RELOAD ALL</a>					
			<a href="<?php echo base_url('manage/station/backup'); ?>" class="btn btn-success">BACKUP RSC</a>
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export1" onclick="$('form').attr('target', '_blank');"><i class="fa fa-download"></i>&nbsp;Export PDF</button>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export2" onclick="$('form').attr('target', '_blank');"><i class="fa fa-download"></i>&nbsp;Export Excel</button>
        	</div>
			<?php endif; ?>
		
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
					echo form_open('manage/station/export_pdf');
				?>
				<div class="form-group">
				<label for="bts">Kualitas Signal</label>
				<select class="form-control" id="" name="kualitas">	
				<option value="">-Filter-</option>
				<option value="Buruk">Buruk</option>	
				<option value="Diperlukan Optimasi">Diperlukan Optimasi</option>
				<option value="Baik">Baik</option>	
				<option value="all">Semua Data</option>
				</select>
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
					echo form_open('manage/station/export_xls');
				?>
				<div class="form-group">
				<label for="bts">Kualitas Signal</label>
				<select class="form-control" id="" name="kualitas">	
				<option value="">-Filter-</option>
				<option value="Buruk">Buruk</option>	
				<option value="Diperlukan Optimasi">Diperlukan Optimasi</option>
				<option value="Baik">Baik</option>
				<option value="all">Semua Data</option>	
				</select>
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
        <table class="table table-bordered table-striped" id="example2" style="font-size:10px">

            <thead>

                <tr>
					<th style="text-align:left">Identity</th>
					<th style="text-align:center">IP Address</th>
					<th style="text-align:center">Model</th>
					<th style="text-align:center">SN</th>
					<th style="text-align:center">Signal</th>
					<th style="text-align:center">CCQ</th>
					<th style="text-align:center">Port</th>
					<th style="text-align:center">Waktu</th>
					<th style="text-align:center">Kualitas</th>	
                    <th style="text-align:center" nowrap="nowrap">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
						<td style="text-align:left">
                            <?php echo $item['identity']; ?>
                        </td>
						
                        <td style="text-align:center">
                            <?php echo $item['ipaddr']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['model']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['serial_number']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['sinyal']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['ccq']; ?>
                        </td>
						
						<td style="text-align:center">
                            <?php echo $item['port']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['waktu']; ?>
                        </td>
						<td style="text-align:center">
                            <?php 
							if($item['kualitas'] == "Baik"){
							echo "<span class=\"btn btn-xs btn-success\">Baik</span>";
							}elseif($item['kualitas'] == "Buruk"){
							echo "<span class=\"btn btn-xs btn-danger\">Buruk</span>";
							}elseif($item['kualitas'] == "Diperlukan Optimasi"){
							echo "<span class=\"btn btn-xs btn-warning\">Diperlukan Optimasi</span>";
							}else{
							echo "";
							}
							
							?>
                        </td>
						<td style="text-align:center" nowrap="nowrap">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
  	 <td><a href="<?php echo base_url('manage/station/' . $item['id'] . '/refresh'); ?>" class="btn btn-xs btn-primary" title="Reload Data"><i class="fa fa-refresh"></i></a></td>
	 <td><a href="<?php echo base_url('manage/station/' . $item['id'] . '/backup'); ?>" class="btn btn-xs btn-success" title="Backup RSC"><i class="fa fa-database"></i></a></td>
    <td><a href="<?php echo base_url('manage/station/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning" title="Ubah Data"><i class="fa fa-pencil"></i></a></td>
    <td><a href="<?php echo base_url('manage/station/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger" title="Hapus Data"><i class="fa fa-trash-o"></i></a></td>
  <?php endif;?>
  </tr>
</table>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>

    </div>

</div>

<!-- END PANEL HEADLINE -->
