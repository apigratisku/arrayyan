<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA PELANGGAN</div>

<div class="panel panel-headline">


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

    <div class="panel-heading">
       <div class="box-footer">
	   		
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'): ?>
                <a href="<?php echo base_url('manage/data_pelanggan/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export"><i class="fa fa-download"></i>&nbsp;Export Data</button>
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
					echo form_open('manage/data_pelanggan/export');
				?>
				<div class="form-group">
                <label for="nama_keahlian">Brand</label>
                 <select class="form-control" id="brand" name="brand" required>								
				 <option value="all">Semua</option>	
				<option value="BLiP" <?php if(isset($item['brand'])){if($item['brand'] == "BLiP"){echo "selected";}} ?>>BLiP</option>
				<option value="GMEDIA" <?php if(isset($item['brand'])){if($item['brand'] == "GMEDIA"){echo "selected";}} ?>>GMEDIA</option>
				<option value="FIBERSTREAM" <?php if(isset($item['brand'])){if($item['brand'] == "FIBERSTREAM"){echo "selected";}} ?>>FIBERSTREAM</option>

				</select>
            	</div>
				
				<div class="form-group">
                <label for="nama_keahlian">Cabang</label>
                 <select class="form-control" id="region" name="region" required>	
				 <option value="all">Semua</option>							
				<option value="NTB" <?php if(isset($item['region'])){if($item['region'] == "NTB"){echo "selected";}} ?>>NTB</option>
				<option value="BALI" <?php if(isset($item['region'])){if($item['region'] == "BALI"){echo "selected";}} ?>>BALI</option>
				<option value="SURABAYA" <?php if(isset($item['region'])){if($item['region'] == "SURABAYA"){echo "selected";}} ?>>SURABAYA</option>
				<option value="MALANG" <?php if(isset($item['region'])){if($item['region'] == "MALANG"){echo "selected";}} ?>>MALANG</option>
				</select>
           		 </div>
				 
				 <div class="form-group">
                <label for="nama_keahlian">Area</label>
                 <select class="form-control" id="area" name="area" required>
				  <option value="all">Semua</option>									
				<option value="MATARAM">MATARAM</option>
				<option value="LOMBOK BARAT">LOMBOK BARAT</option>
				<option value="LOMBOK TENGAH">LOMBOK TENGAH</option>
				<option value="LOMBOK TIMUR">LOMBOK TIMUR</option>
				<option value="LOMBOK UTARA">LOMBOK UTARA</option>
				<option value="GILI TRAWANGAN">GILI TRAWANGAN</option>
				<option value="GILI AIR">GILI AIR</option>
				<option value="GILI MENO">GILI MENO</option>
				<option value="SUMBAWA">SUMBAWA</option>
				<option value="DOMPU">DOMPU</option>
				<option value="BALI">BALI</option>
				<option value="SURABAYA">SURABAYA</option>
				<option value="MALANG">MALANG</option>
				</select>
            	</div>
				
			
				<div class="form-group">
                <label for="nama_keahlian">Status Pelanggan</label>
                 <select class="form-control" id="status_pelanggan" name="status_pelanggan" required>	
				 <option value="all">Semua</option>				
				<option value="0" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "0"){echo "selected";}} ?>>Tidak Aktif</option>
				<option value="1" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "1"){echo "selected";}} ?>>Aktif</option>
				<option value="2" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "2"){echo "selected";}} ?>>Isolir</option>
				<option value="3" <?php if(isset($item['status_pelanggan'])){if($item['status_pelanggan'] == "3"){echo "selected";}} ?>>Dismantle</option>

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

       <div class="table-responsive">
        <table class="table table-bordered table-striped" id="example2" style="font-size:10px">

            <thead>

                <tr>
					<th style="text-align:center" width="5%">Cabang</th>
					<th style="text-align:center" width="5%">Brand</th>
					<th style="text-align:center">CID</th>
					<th style="text-align:center">SID</th>
                    <th nowrap="nowrap">Nama</th>
					<th style="text-align:center" width="15%">Area</th>
					<th style="text-align:center" width="5%">BSC</th>
					<th style="text-align:center" width="5%">Status</th>
                    <th style="text-align:center" nowrap="nowrap">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
						<td style="text-align:center">
                            <?php echo $item['region']; ?>
                        </td>
					<td style="text-align:center">
                            <?php echo $item['brand']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['cid']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['sid']; ?>
                        </td>
                        <td>
                            <?php echo $item['nama']; ?>
                        </td><td style="text-align:center">
                           <?php echo $item['area']; ?>
                        </td><td style="text-align:center">
                           <?php echo $item['pop']; ?>
                        </td><td style="text-align:center">
                            <?php 
							if($item['status_pelanggan'] == "0") {echo"<span class=\"label label-primary\">Tidak Aktif</span>";} elseif($item['status_pelanggan'] == "1"){echo"<span class=\"label label-success\">Aktif</span>";}elseif($item['status_pelanggan'] == "2"){echo"<span class=\"label label-warning\">Isolir</span>";}else{echo"<span class=\"label label-danger\">Dismantle</span>";}
							?>
                        </td><td style="text-align:center">

   <a href="<?php echo base_url('manage/data_pelanggan/' . $item['id']); ?>" class="btn btn-xs btn-primary">Detail</i></a>
   <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='5'):?>
    <a href="<?php echo base_url('manage/data_pelanggan/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">ubah</a>
	<?php endif; ?>
	<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
    <a href="<?php echo base_url('manage/data_pelanggan/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">Hapus</a>
	<?php endif; ?>

                            
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>


			<tr>
                   <tr>
					<th style="text-align:center" width="5%">Cabang</th>
					<th style="text-align:center" width="5%">Brand</th>
					<th style="text-align:center">CID</th>
					<th style="text-align:center">SID</th>
                    <th nowrap="nowrap">Nama</th>
					<th style="text-align:center" width="15%">Area</th>
					<th style="text-align:center" width="5%">BSC</th>
					<th style="text-align:center" width="5%">Status</th>
                    <th style="text-align:center" nowrap="nowrap">Tindakan</th>
                </tr>
                </tfoot> 
        </table>
		</div>

    </div>

</div>

<!-- END PANEL HEADLINE -->
<?php //if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>

<?php 
//echo number_format($total_revenue->total, 0, ",", ".");
?>
</div>
<br />
<?php //endif; ?>