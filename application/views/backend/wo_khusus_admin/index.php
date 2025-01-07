<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			ADMIN - WO KHUSUS
			</div>
			<br>

    <div class="panel-heading">

		<!-- /.box-body -->
		<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'): ?>
              <div class="box-footer">
                <a href="<?php echo base_url('manage/wo_khusus_admin/tambah'); ?>" class="btn btn-primary"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-export"><i class="fa fa-download"></i>&nbsp;Export Data</button>
              </div>
		<?php endif; ?>
    </div>

	<div class="modal fade" id="modal-export">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter Export Data</h4>
              </div>
              <div class="modal-body">
                <p>
				<?php
					echo form_open('manage/wo_khusus_admin/export');
				?>
				<div class="form-group">
                <label for="nama_keahlian">WO Khusus Data</label>
                 <select class="form-control" id="brand" name="brand" required>								
				 <option value="all">Semua</option>	
				</select>
            	</div>
				
				
				
				</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="export" value="Export">
              </div>
			  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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
                    <th>Pelanggan</th>	
					<th>Sales</th>
					<th>Kegiatan</th>
					<th>Sub Kegiatan</th>
					<th>Tgl Req Sales</th>
					<th>Dokumentasi</th>
					<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
                    <th style="text-align:center" width="15%">Tindakan</th>
					<?php endif; ?>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>
				<?php 
				$data_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array(); 
				?>
				<?php $data_sales= $this->db->get_where('blip_sales', array('id' => $item['id_sales']))->row_array(); ?>
 				
                    <tr>
                        <td>
                            <?php echo $data_pelanggan['nama']; ?> 
                        </td><td>
                            <?php echo $data_sales['nama']; ?> 
                        </td><td>
                            <?php echo $item['kegiatan']; ?> 
                        </td><td>
                            <?php echo $item['sub_kegiatan']; ?> 
                        </td><td style="text-align:center">
                            <?php echo $item['tgl_req_sales']; ?> 
                        </td><td style="text-align:left">
                            <a target="_blank" href="<?php echo $item['link_dokumentasi']; ?>"><?php echo $item['link_dokumentasi']; ?> </a>
                        </td>
						
						<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'):?>
						<td  style="text-align:center">
                            <a href="<?php echo base_url('manage/wo_khusus_admin/' . $item['id'] . '/ubah'); ?>" class="btn btn-xs btn-warning">
                                Ubah
                            </a>
                            <a href="<?php echo base_url('manage/wo_khusus_admin/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Hapus
                            </a>
                        </td>
						<?php endif; ?>
						</tr>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->
