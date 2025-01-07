
<div class="panel panel-headline">

   <div class="panel-heading">
                
            <div class="box-footer">
			<a href="<?php echo base_url('manage/bts/'); ?>" class="btn btn-primary">DATA RADIO BTS</a>
			<?php if($this->session->userdata('ses_admin')=='1'):?><a href="<?php echo base_url('manage/bts/tambah'); ?>" class="btn btn-success">TAMBAH DATA</a><?php endif;?>
			<a href="<?php echo base_url('manage/bts/export'); ?>" class="btn btn-success" target="_blank">EXPORT DATA</a>
			<?php if($this->session->userdata('ses_admin')=='1'):?><a href="<?php echo base_url(); ?>manage/bts/" class="btn btn-danger" target="_blank">PROSES FREK AWAL</a><?php endif;?>
			<?php if($this->session->userdata('ses_admin')=='1'):?><a href="<?php echo base_url(); ?>manage/bts/" class="btn btn-primary" target="_blank">PROSES FREK REGULER</a><?php endif;?>
			<a href="<?php echo base_url(); ?>manage/bts/maintenance" class="btn btn-success" target="_blank">RELOAD DATA</a>
			<a href="<?php echo base_url(); ?>manage/bts/backup" class="btn btn-success">BACKUP RSC</a>
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
       <table class="table table-bordered table-hover" id="example2">

            <thead>

                <tr>
                    <th>BTS</th>
					<th>Sektor</th>
					<th>IP Address</th>
					<th style="text-align:center" width="15%">SSID</th>
					<th style="text-align:center" width="6%">Band</th>
					<th style="text-align:center" width="6%">Frek<br />Awal</th>
					<th style="text-align:center" width="6%">Protocol<br />Awal</th>
					<th style="text-align:center" width="6">Frek<br />Normal</th>
					<th style="text-align:center" width="6%">Protocol<br />Normal</th>
					<th style="text-align:center" width="4%">WE Status</th>
                    <th style="text-align:center" width="8%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php echo $item['nama_bts']; ?>
                        </td><td>
                            <?php echo $item['sektor_bts']; ?>
                        </td><td>
                            <?php echo $item['ip']; ?>
                        </td><td style="text-align:center" width="6%">
                            <?php echo $item['ssid']; ?>
                        </td><td style="text-align:center" width="6%">
                            <?php echo $item['band']; ?>
                        </td><td style="text-align:center" width="6%">
                            <?php echo $item['b4_frek']; ?>
                        </td><td style="text-align:center" width="6%">
                            <?php echo $item['b4_protocol']; ?>
                        </td><td style="text-align:center" width="6%">
                            <?php echo $item['frek']; ?>
                        </td><td style="text-align:center" width="6%">
                            <?php echo $item['protocol']; ?>
                        </td><td style="text-align:center" width="4%">
                            <?php 
							if($item['we_status'] == "true") {echo "<font color=red>Disable</font>"; } else {echo "<font color=green>Enable</font>";}
							?>
                        </td><td style="text-align:center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php if($this->session->userdata('ses_admin')=='1'):?>
    <td><a href="<?php echo base_url('manage/bts/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a></td>
    <td><a href="<?php echo base_url('manage/bts/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
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
