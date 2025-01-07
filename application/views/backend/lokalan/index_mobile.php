<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-md-6 panel-action">
                <a href="<?php echo base_url('manage/lokalan/tambah'); ?>" class="btn btn-success">TAMBAH DATA</a>
            </div>
        </div>
    </div>

    <hr class="panel-divider">

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
        <table class="table table-hover table-bordered table-act" id="data-table">

            <thead>

                <tr>
                    <th>Pelanggan</th>
					<th>Area</th>
					<th>IP</th>
                    <th>Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td width="5%" align="left">
                            <?php echo $item['pelanggan']; ?>
                        </td><td>
                            <?php echo $item['area']; ?>
                        </td><td nowrap="nowrap">
                            <?php echo $item['ip']; ?> <?php if($item['status'] == "0") {echo"<span style=\"color:red; font-weight:bold\">[DOWN]</span>";} else{echo"<span style=\"color:green; font-weight:bold\">[UP]</span>";}?>
                        </td><td style="text-align:center" width="2%">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="<?php echo base_url('manage/lokalan/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a></td>
    <td><a href="<?php echo base_url('manage/lokalan/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
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
