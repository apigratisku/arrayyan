<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
			  <a href="#<?php //echo base_url('manage/fiberstream/bcschedule');// ?>" class="btn btn-info pull-right" onClick="javascript:return confirm('Proses refresh data. Lanjutkan?')">Refresh Data</a>
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
					<th style="text-align:center"  width="8%">CID</th>
                    <th>Pelanggan</th>
					<th style="text-align:center" width="15%">Status Layanan</th>
					<th style="text-align:center" width="15%">Status Bayar</th>
                    <th style="text-align:center" width="20%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr> 

						<td style="text-align:center">
                            <?php echo $item['cid']; ?>
                        </td>
                        <td>
                            <?php echo $item['nama']; ?>
                        </td><td style="text-align:center">
                            <?php if($item['status_layanan'] == NULL) {echo"<span style=\"color:orange; font-weight:bold\">Menunggu Respon</span>";} elseif($item['status_layanan'] == "0") {echo"<span style=\"color:red; font-weight:bold\">Isolir</span>";}  else{echo"<span style=\"color:green; font-weight:bold\">Open</span>";} ?>
                        </td><td style="text-align:center">
                            <?php if($item['status_bayar'] == "0") {echo"<span style=\"color:red; font-weight:bold\">Belum Lunas</span>";}  else{echo"<span style=\"color:green; font-weight:bold\">Lunas</span>";} ?>
                        </td>
						<td style="text-align:center">
						
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<?php if($item['status_bayar'] == "0"): ?>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['cid'] . '/' . $item['id'] . '/approve'); ?>" onClick="javascript:return confirm('Proses APPROVE pembayaran. Lanjutkan?')" class="btn btn-primary">Approve
	</a>	
	<a href="<?php echo base_url('manage/fiberstream/' . $item['cid'] . '/' . $item['id'] . '/isolir'); ?>" onClick="javascript:return confirm('Proses ISOLIR pelanggan. Lanjutkan?')" class="btn btn-primary">Isolir
	</a>
	<?php else: ?>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['cid'] . '/' . $item['id'] . '/isolir'); ?>" onClick="javascript:return confirm('Proses ISOLIR pelanggan. Lanjutkan?')" class="btn btn-primary">Isolir
	</a>
	<?php endif; ?>
	</td>
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
