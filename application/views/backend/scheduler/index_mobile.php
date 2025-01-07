<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo base_url('manage/scheduler/tambah_a'); ?>" class="btn btn-info pull-right">Tambah Data</a>
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
					<th>Permintaan</th>
					<th>Pelanggan</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Bandwidth</th>
					<th style="text-align:center" width="10%">Status</th>
                    <th style="text-align:center" width="8%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php if($item['permintaan'] == "Free BOD +50%") { echo "Free BOD +50%"; } elseif($item['permintaan'] == "Free BOD +100%") { echo "Free BOD +100%"; } elseif($item['permintaan'] == "BOD Berbayar") { echo "BOD Berbayar"; } else {echo $item['permintaan'];}?>
                        </td><td>
                            <?php echo $item['pelanggan']; ?>
                        </td><td>
                            <?php echo $item['mulai']; ?>
                        </td><td align="center">
                            <?php if($item['selesai'] != NULL) {echo $item['selesai'];}else{echo "-";} ?>
                        </td><td align="center">
                            <?php if($item['bw'] != NULL) {echo $item['bw'];}else{echo "-";} ?>
                        </td><td style="text-align:center">
                            <?php 
							if($item['status'] == "0") {echo"<span style=\"color:orange; font-weight:bold\">Menunggu</span>";} elseif($item['status'] == "2") {echo"<span style=\"color:blue; font-weight:bold\">Berlangsung</span>";}else{echo"<span style=\"color:green; font-weight:bold\">Selesai</span>";}
							?>
                        </td><td style="text-align:center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td><a href="<?php echo base_url('manage/scheduler/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
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
