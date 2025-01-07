<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title"><?php echo "<span style=\"font-weight:bold; text-decoration:underline;\">$title</span>"; ?></h3>
            </div>
			<div class="col-md-6">
                <h4 class="panel-title"> <?php if(!empty($this->session->userdata('ses_cid'))){echo $this->session->userdata('ses_userid'); } ?></h4>
            </div>
			<div class="col-md-6">
                <h4 class="panel-title"> <?php if(!empty($this->session->userdata('ses_cid'))){echo "[".$this->session->userdata('ses_cid')."]"; } ?></h4>
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
                    <th width="10%">Tanggal Invoice</th>
					<th style="text-align:center" width="6%">CID</th>
					<th style="text-align:center" width="10%">Bukti Pembayaran</th>
					<th style="text-align:center" width="10%">Status Pembayaran</th>
                    <th style="text-align:center" width="15%">Upload Resi</th>
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
						<td style="text-align:center">
                            <?php if(empty($item['bukti_pembayaran'])){echo"-";} else { echo "<a href=\"".base_url('static/fiberstream/')."".$item['bukti_pembayaran']."\" target=\"_blank\">Lihat Resi</a>"; } ?>
                        </td><td style="text-align:center">
                          <?php if(empty($item['bukti_pembayaran'])){echo"<span style=\"color:black\">Menunggu Pembayaran</span>";}  elseif($item['bukti_pembayaran'] != NULL && $item['status_pembayaran'] == "0") {echo"<span style=\"color:orange; font-weight:bold\">Proses Verifikasi</span>";} elseif($item['bukti_pembayaran'] != NULL && $item['status_pembayaran'] == "1"){echo"<span style=\"color:green; font-weight:bold\">Terverifikasi</span>";} else{echo"<span style=\"color:red; font-weight:bold\">Resi Invalid</span>";} ?>
                        </td><td style="text-align:center">
						
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<?php echo form_open_multipart('manage/fiberstream/simpan_resi');?>
	<div class="form-group">
      <input type="file" class="form-control" id="foto" name="foto" required><button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Upload</button>
    </div>
	</form>
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
