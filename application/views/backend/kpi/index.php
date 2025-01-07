<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			ADMIN - KPI
			</div>
			<br>

    <div class="panel-heading">

		<!-- /.box-body -->
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
              <div class="box-footer">
                <a href="<?php echo base_url('manage/kpi/tambah'); ?>" class="btn btn-primary pull-right"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
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
       <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
					<th>Klasifikasi</th>
                    <th>Kegiatan</th>
					<th style="text-align:center" width="15%">Durasi</th>
					<th style="text-align:center" width="15%">Input Pelanggan Baru ?</th>
                    <th style="text-align:center" width="15%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                       <td>
                            <?php $data_klasifikasi = $this->db->get_where('blip_kpi_induk', array('id' => $item['klasifikasi']))->row_array(); echo $data_klasifikasi['kegiatan']; ?>
                        </td> <td>
                            <?php echo $item['kegiatan']; ?>
                        </td><td style="text-align:center" width="15%">
                            <?php echo $item['durasi']; ?> Hari
                        </td><td style="text-align:center" width="15%">
                            <?php if($item['new_cust'] == "1"){echo "Ya";} else{echo "Tidak";} ?>
                        </td><td  style="text-align:center">
                            <a href="<?php echo base_url('manage/kpi/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/kpi/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
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
