<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA ODP</div>
    <div class="panel-heading">

		<!-- /.box-body -->
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
              <div class="box-footer">
			  <div align="right">
			  <a href="<?php echo base_url('manage/mapping/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
			  <a href="<?php echo base_url('manage/mapping/import'); ?>" class="btn btn-info"><i class="fa fa-upload"></i>&nbsp;Import Data</a>
				
				<a href="<?php echo base_url('manage/mapping/refresh_pelanggan'); ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Refresh</a>	
				</div>
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
        <table class="table table-bordered table-striped" id="example2">

            <thead>

                <tr>
					<th style="width:10%">Area</th>
                    <th>ODP</th>
					<th style="text-align:center">Latitude</th>
					<th style="text-align:center">Longtitude</th>
					<th style="text-align:center">Site</th>
					<th style="text-align:center">Terinstall</th>
					<th style="text-align:center">Idle</th>
					<th style="text-align:center">Link</th>
					<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
                    <th style="text-align:center" width="8%">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td style="width:10%">
                            <?php echo $item['area']; ?>
                        </td><td>
                            <?php echo $item['odp']; ?>
                        </td><td style="text-align:center">
                            <?php echo $item['lat']; ?>
                        </td><td style="text-align:center">
                            <?php echo $item['long']; ?>
                        </td><td style="text-align:center">
                            <?php echo $item['site']; ?>
                        </td><td style="text-align:center">
                            <?php echo $item['pelanggan']; ?>
                        </td><td style="text-align:center">
                            <?php $idle=16-$item['pelanggan']; echo $idle; ?>
                        </td><td style="text-align:center">
                            <a href="<?php echo "https://www.google.com/maps/place/".$item['lat']."+".$item['long']; ?>" target="_blank">Maps Link</a>
                        </td>
						<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
						<td style="text-align:center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="<?php echo base_url('manage/mapping/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a></td>
    <td><a href="<?php echo base_url('manage/mapping/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
  </tr>
</table>
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
