<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title"><?php echo $title; ?></h3>
            </div>
          	<div class="col-md-6 panel-action">
               <a href="<?php echo base_url('manage/fiberstream/bcinvoice'); ?>" class="btn btn-success" onClick="javascript:return confirm('Proses BC Invoice. Lanjutkan?')">BC INVOICE</a> &nbsp; <a href="<?php echo base_url('manage/fiberstream/tambah'); ?>" class="btn btn-success">BUAT INVOICE</a>
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
					<th width="10%">Invoice</th>
					<th style="text-align:center"  width="8%">CID</th>
                    <th>Pelanggan</th>
					<th style="text-align:center" width="7%">Resi</th>
					<th style="text-align:center" width="15%">Status Pembayaran</th>
					<th style="text-align:center" width="20%">Upload Resi</th>
                    <th style="text-align:center" width="18%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr> 
					<td>
                            <?php echo $item['invoice_bulan']; ?> <?php echo $item['invoice_tahun']; ?>
                        </td>
						<td style="text-align:center">
                            <?php echo $item['cid']; ?>
                        </td>
                        <td>
                            <?php echo $item['nama']; ?>
                        </td><td style="text-align:center">
                            <?php if(empty($item['bukti_pembayaran'])){echo"-";} else { echo "<a href=\"".base_url('static/fiberstream/')."".$item['bukti_pembayaran']."\" target=\"_blank\">Lihat Resi</a>"; } ?>
                        </td><td style="text-align:center">
                            <?php if(empty($item['bukti_pembayaran'])){echo"<span style=\"color:black\">Menunggu Pembayaran</span>";}  elseif($item['bukti_pembayaran'] != NULL && $item['status_pembayaran'] == "0") {echo"<span style=\"color:orange; font-weight:bold\">Proses Verifikasi</span>";} elseif($item['bukti_pembayaran'] != NULL && $item['status_pembayaran'] == "1"){echo"<span style=\"color:green; font-weight:bold\">Terverifikasi</span>";} else{echo"<span style=\"color:red; font-weight:bold\">Resi Invalid</span>";} ?>
                        </td>
						<td>
						<?php echo form_open_multipart('manage/fiberstream/simpan_resi');?>
      <input type="file" class="form-control" id="foto" name="foto" style="width:108px" required>
	  <input type="hidden" id="id_resi" name="id_resi" value="<?php echo $item['id']; ?>" />
	  <input type="hidden" id="cid_resi" name="cid_resi" value="<?php echo $item['cid']; ?>" />
	  <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Upload</button>
	</form>
						</td>
						<td style="text-align:center">
						
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<?php if($item['status_pembayaran'] == "1"): ?>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['id'] . '/abort'); ?>" onClick="javascript:return confirm('Proses BATAL. Lanjutkan?')" class="btn btn-primary">Batalkan
	</a>
	<?php elseif($item['status_pembayaran'] == "2"): ?>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['id'] . '/abort'); ?>" onClick="javascript:return confirm('Proses BATAL. Lanjutkan?')" class="btn btn-primary">Batalkan
	</a>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['id'] . '/approve'); ?>" onClick="javascript:return confirm('Proses APPROVE pembayaran. Lanjutkan?')" class="btn btn-primary">Approve
	</a>
	<?php elseif($item['bukti_pembayaran'] == NULL): ?>
	<?php echo""; ?>	
	<?php else: ?>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['id'] . '/approve'); ?>" onClick="javascript:return confirm('Proses APPROVE pembayaran. Lanjutkan?')" class="btn btn-primary">Approve
	</a>
	<a href="<?php echo base_url('manage/fiberstream/' . $item['id'] . '/reject'); ?>" onClick="javascript:return confirm('Proses REJECT pembayaran. Lanjutkan?')" class="btn btn-primary">Reject
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
