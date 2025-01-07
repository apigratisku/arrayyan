
<!-- PANEL HEADLINE -->

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			USER MANAGER
			</div>
			<br>
    <div class="panel-heading">
       <div class="box-footer">
			<?php if($this->session->userdata('ses_admin')=='1'):?>
                <a href="<?php echo base_url('manage/operator/tambah'); ?>" class="btn btn-primary pull-right"><i class="fa fa-database"></i>&nbsp;TAMBAH DATA</a>
			 <?php endif; ?>
        </div>
    </div>
<!-- PANEL HEADLINE -->


    <div class="panel-body">

        <?php if ($this->session->flashdata('message') == 'success'): ?>

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Berhasil menghapus data.
            </div>

        <?php elseif ($this->session->flashdata('message') == 'failed'): ?>

            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Gagal menghapus data.
            </div>

        <?php endif; ?>

        <div class="table-responsive">

          <table class="table table-bordered table-hover" id="example1">

                <thead>

                    <tr>
                        <th>Nama</th>
                        <th>UserID</th>
                        <th>Level</th>
						<th>No.WA</th>
						<th>ID Telegram</th>
						<th>Tindakan</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($items as $item): ?>

                        <tr>
                            <td nowrap>
                                <?php echo $item['nama']; ?>
                            </td>
                            <td nowrap>
                                <?php echo $item['email']; ?>
                            </td><td>
                                <?php if ($item['admin'] == "1") { echo "Super Admin"; } elseif ($item['admin'] == "2") { echo "Manager"; }elseif ($item['admin'] == "3") { echo "Technical Leader"; }elseif ($item['admin'] == "4") { echo "Admin Operational"; }elseif ($item['admin'] == "5") { echo "Technical Staff"; }elseif ($item['admin'] == "6") { echo "Asistant Manager"; }elseif ($item['admin'] == "7") { echo "Sales CE"; }elseif ($item['admin'] == "8") { echo "Sales Staff"; }  ?>
                            </td>
							<td nowrap>
                                <?php echo $item['no_wa']; ?>
                            </td>
							<td nowrap>
                                <?php echo $item['telegram']; ?>
                            </td>
                            <td nowrap>
                                <a href="<?php echo base_url('manage/operator/' . $item['id']); ?>" class="btn btn-xs btn-primary">
                                    <i class="fa fa-search-plus"></i>
                                </a>
                                &nbsp;
                                <a href="<?php echo base_url('manage/operator/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                &nbsp;
                                <a href="<?php echo base_url('manage/operator/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
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
