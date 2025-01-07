<div class="panel panel-headline">
<div style="background-color:#902e2e; font-weight:bold; color:#FFFFFF; font-size:20px; padding:10px 0px 10px 10px">
			ADMIN - LEVEL PRIORITAS PELANGGAN
			</div>
			<br>

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo base_url('manage/level_prioritas/tambah'); ?>" class="btn btn-info pull-right">Tambah Data</a>
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
                    <th>Level Prioritas</th>
                    <th style="text-align:center" width="15%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td>
                            <?php echo $item['level']; ?>
                        </td><td  style="text-align:center">
                            <a href="<?php echo base_url('manage/level_prioritas/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/level_prioritas/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->
