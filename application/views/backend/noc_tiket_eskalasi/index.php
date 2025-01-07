<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			NOC - SISTEM TIKET - ESKALASI
			</div>
			<br>

	
	<div class="panel-heading">
       <div class="box-footer">

		<!-- /.box-body -->
		<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'): ?>
              <div class="box-footer">
                <a href="<?php echo base_url('manage/noc_tiket_eskalasi/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
              </div>
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
       <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
					<th style="width:5%">No.</th>
                    <th>Eskalasi</th>	
					<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
                    <th style="text-align:center" width="15%">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php $no=1; foreach ($items as $item): ?>
 				
                    <tr>
                        <td>
                            <?php echo $no; ?> 
                        </td><td>
                            <?php echo $item['nama']; ?> 
                        </td>
						<?php if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'):?>
						<td  style="text-align:center">
                            <a href="<?php echo base_url('manage/noc_tiket_eskalasi/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/noc_tiket_eskalasi/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
                            </a>
                        </td>
						<?php endif; ?>
						</tr>
                    </tr>
	
                <?php $no++; endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->



