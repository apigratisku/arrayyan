<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
			  <?php if($max == 1): echo ""; else: ?>
                <a href="<?php echo base_url('manage/server/tambah'); ?>" class="btn btn-info pull-right">Tambah Data</a>
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
					<th>Router</th>
					<th style="text-align:center">Status</th>
                    <th style="text-align:center" width="3%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
						<td>
                            <?php echo $item['ip']; ?>
                        </td><td style="text-align:center">
                            <?php 
							if($item['up_down'] == "0") {echo"<span style=\"color:red; font-weight:bold\">DOWN</span>";} else{echo"<span style=\"color:green; font-weight:bold\">UP</span>";}	 
							?>
                        </td><td  style="text-align:center">
                            <a href="<?php echo base_url('manage/server/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            &nbsp;
                            <a href="<?php echo base_url('manage/server/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash-o"></i>
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
