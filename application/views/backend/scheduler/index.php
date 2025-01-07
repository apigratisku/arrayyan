<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">SCHEDULER</div>

<div class="panel panel-headline">

    <div class="panel-heading">

		<!-- /.box-body -->
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'):?>
              <div class="box-footer">
                <a href="<?php echo base_url('manage/scheduler/tambah_a'); ?>" class="btn btn-primary pull-right"><i class="fa fa-database"></i>&nbsp;Tambah Data</a>
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
					<th>Permintaan</th>
					<th>Pelanggan</th>
					<th>Layanan</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Bandwidth</th>
					<th>Eksekutor</th>
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
                            <?php $pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array(); echo $pelanggan['nama']; ?>
                        </td><td>
                            <?php $layanan = $this->db->get_where('blip_layanan', array('id' => $item['id_layanan']))->row_array(); ?>
							<?php $produk = $this->db->get_where('blip_produk', array('id' => $layanan['id_produk']))->row_array(); echo $produk['produk']; ?>
                        </td><td>
                            <?php echo $item['mulai']; ?>
                        </td><td align="center">
                            <?php if($item['selesai'] != NULL) {echo $item['selesai'];}else{echo "-";} ?>
                        </td><td align="center">
                            <?php if($item['bw'] != NULL) {echo $item['bw'];}else{echo "-";} ?>
                        </td><td align="center">
                            <?php 
							if($item['history_iduser'] != NULL) {
							$eksekutor = $this->db->get_where('gm_operator', array('id' => $item['history_iduser']))->row_array();
							echo $eksekutor['email'];}else{echo "-";
							} 
							?>
                        </td><td style="text-align:center">
                            <?php 
							if($item['status'] == "0") {echo"<span style=\"color:orange; font-weight:bold\">Menunggu</span>";} elseif($item['status'] == "2") {echo"<span style=\"color:blue; font-weight:bold\">Berlangsung</span>";}else{echo"<span style=\"color:green; font-weight:bold\">Selesai</span>";}
							?>
                        </td><td style="text-align:center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td>
	<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'): ?>
	<a href="<?php echo base_url('manage/scheduler/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
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
		<?php 
		//Enkripsi index ID
		/*
		$DR = "BLiPNTB*22022022*";
		$PELANGGAN = "RFd3d76890";
		$RADIO = "mtr2021";
		$enc1 = "103.255.242.247";
		$enc2 = "103.255.242.251";
		$enc3 = "103.255.242.249";
		$enc4 = "103.255.242.250";
		$enc5 = "103.255.242.253";
		$enc6 = "103.255.242.248";
		$enc7 = "10.247.0.51";
		$enc8 = "noc-mtr";
		$enc9 = "MtrMasuk*123#";
		$enc10 = "adhit";
		$enc11 = "43.252.157.114";
		$enc12 = "103.255.242.246";
		
		$dec = "WTN1QWZXbldobXRUNGRKQ21tb05pZz09";
		echo "DR ". $this->secure->encrypt_url($DR)."<br>";
		echo "RADIO ". $this->secure->encrypt_url($RADIO)."<br>";
		echo "PELANGGAN ". $this->secure->encrypt_url($PELANGGAN)."<br>";
		echo "TE NUTANA CORP ". $this->secure->encrypt_url($enc1)."<br>";
		echo "TE-QOMARUL ". $this->secure->encrypt_url($enc2)."<br>";
		echo "TE-PMG CORP ". $this->secure->encrypt_url($enc3)."<br>";
		echo "TE TRW ". $this->secure->encrypt_url($enc4)."<br>";
		echo "TE NUTANA BROAD ". $this->secure->encrypt_url($enc5)."<br>";
		echo "TE PMG BROAD ". $this->secure->encrypt_url($enc6)."<br><br>";
		
		echo "OLT IP ". $this->secure->encrypt_url($enc7)."<br>";
		echo "OLT USER ". $this->secure->encrypt_url($enc8)."<br>";
		echo "OLT PASS ". $this->secure->encrypt_url($enc9)."<br>";
		echo "BR ". $this->secure->encrypt_url($enc10)."<br>";
		echo "BR_IP ". $this->secure->encrypt_url($enc11)."<br>";
		echo "TE NTN 02 ". $this->secure->encrypt_url($enc12)."<br>";
		//echo $this->secure->decrypt_url($dec);
		
		//$dec = "N01HRDM3bkJ1ZHVES1AveFhBR1RQZz09";
		//echo $this->secure->decrypt_url($dec);
		*/
		?>