<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA MAPPING</div>

    <div class="panel-heading">

		<?php
            echo form_open('manage/mapping/export');
        ?>	
		<table style="width:55%; text-align:left" border="0">
		<tr>
		<td style="text-align:center">
				
					<input style="width:170px" type="text" class="form-control datetimepicker-alt" id="datetime1" name="tgl_a" placeholder="Pilih Tanggal Mulai" required autofocus>
					<script type="text/javascript">
					$("#datetime1").datetimepicker({
						format: 'yyyy-mm-dd',
						autoclose: true
					});
					</script>
							
		</td>
		<td style="text-align:center">
				
					<input style="width:170px" type="text" class="form-control datetimepicker-alt" id="datetime2" name="tgl_b"  placeholder="Pilih Tanggal Akhir"  required autofocus>
					<script type="text/javascript">
					$("#datetime2").datetimepicker({
						format: 'yyyy-mm-dd',
						autoclose: true
					});
					</script>
				
		</td>
		<td style="text-align:center"><button name="export" value="export_mapping_xls" type="submit" class="btn btn-info"><i class="fa fa-download"></i>&nbsp; EXPORT EXCEL</button></td>
		<td style="text-align:center"><button name="export" value="export_mapping_pdf" type="submit" class="btn btn-info"><i class="fa fa-download"></i>&nbsp; EXPORT PDF</button></td>
		
		</tr>
		</table>
		</form>	
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
        <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
					<th style="width:3%">Area</th>
                    <th style="width:15%">Capel</th>
					<th>Klasifikasi</th>
					<th style="width:5%">Media</th>
					<th>ODP</th>
					<th>Jarak/Tinggi</th>
					<th style="width:10%">Lat</th>
					<th style="width:7%">Long</th>
					<th style="width:5%">Site</th>
					<th>Status</th>
					<th>Tanggal Survey</th>
                    <th style="text-align:center" width="8%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td style="width:10%">
                            <?php echo $item['area']; ?>
                        </td><td>
                            <?php echo $item['capel']; ?>
                        </td><td>
                            <?php echo $item['klasifikasi']; ?>
                        </td><td>
                            <?php echo $item['media']; ?>
                        </td><td>
                            <?php echo $item['odp']; ?>
                        </td><td>
                            <?php 
							if($item['media'] == "FO") {$ketLL = $item['jarak']."m";} else {if($item['jarak'] <= 5) {$ketLL = "1 Pipa";}elseif($item['jarak'] <= 10) {$ketLL = "2 Pipa";}elseif($item['jarak'] <= 15){$ketLL = "3 Pipa";}elseif($item['jarak'] <= 20){$ketLL = "4 Pipa";}elseif($item['jarak'] <= 25){$ketLL = "5 Pipa";}else{$ketLL = "Tinggi 30m+";}}
							echo $ketLL;
							?>
                        </td><td>
                            <?php echo $item['lat']; ?>
                        </td><td>
                            <?php echo $item['long']; ?>
                        </td><td>
                            <?php echo $item['site']; ?>
                        </td><td>
                            <?php echo $item['status']; ?>
                        </td><td>
                            <?php echo $item['date']; ?>
                        </td><td style="text-align:center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="<?php echo base_url('manage/mapping/' . $item['id'] . '/result_hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
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
