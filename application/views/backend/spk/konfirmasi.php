<?php
clearstatcache();
?>
<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('static/assets/'); ?>/img/blip.png">
        <title>PT. BLiP Integrator Provider - BLiP Digital Center NTB</title>

        <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('static/'); ?>assets/css/bootstrap-login.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    </head>

    <body>

        <div class="container">

            <div class="row">

                <div class="col-md-offset-4 col-md-4 col-md-offset-4 login-form">

                    <center>
                       <img src="<?php echo base_url('static/assets/img/blip.png'); ?>" width="200" alt="Get Biger Image">
                    </center>

                    <div class="spacer-3"></div>

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

                    <?php echo form_open('manage/spk/konfirmasi_simpan'); ?>

<div class="form-group">
<div class="input-group">
<?php
$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array();
$petugas = $this->db->get_where('gm_operator', array('id' => $item['id_petugas']))->row_array();
if($item['id_pelanggan'] != NULL){$lokasi_pekerjaan = $pelanggan['nama'];}elseif($item['id_bts'] != NULL){$lokasi_pekerjaan = $item['id_bts'];}elseif($item['id_survey'] != NULL){$lokasi_pekerjaan = $item['id_survey'];}
?>
<div align="center">
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
  <tr>
    <td valign="top" nowrap="nowrap" width="35%">Lokasi Kegiatan</td>
    <td width="100%">: <b>
	<?php 
	if($item['id_pelanggan'] == 0 && empty($item['id_survey'])){
	echo $item['id_bts'];
	}elseif($item['id_pelanggan'] == 0 && empty($item['id_bts'])){
	echo $item['id_survey'];
	}else{
	echo $pelanggan['nama']; 
	}
	?> 
	</b></td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap">Kegiatan</td>
    <td>: <?php echo $item['kegiatan']; ?></td>
  </tr>
  <tr>
    <td  valign="top" nowrap="nowrap">Detail Kegiatan</td>
    <td>: <?php echo $item['sub_kegiatan']; ?></td>
  </tr>
  <tr>
    <td  valign="top" nowrap="nowrap">Waktu Mulai</td>
    <td>: <?php echo $item['waktu_mulai']; ?></td>
  </tr>
  <tr>
    <td  valign="top" nowrap="nowrap">Petugas</td>
   <td>: <b><?php echo $petugas['nama']; ?></b></td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap">Status Kegiatan</td>
    <td>:
	  <input type="radio" name="status" class="minimal-red" value="Selesai" checked="checked"> Selesai &nbsp;&nbsp;
	  <input type="radio" name="status" class="minimal-red" value="Pending"> Pending
	</td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap" colspan="2">Alasan (Jika pending)
	  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="" autofocus>
	</td>
  </tr>
</table>
<input type="hidden" class="form-control" id="id_konfirmasi" name="id_konfirmasi" value="<?php echo $item['id']; ?>" required>
</div>
</div>
</div>

                        <div class="spacer-1"></div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg" onClick="return confirm('Lanjutkan konfirmasi?')">KONFIRMASI</button>

                        <div class="spacer-1"></div>



                    </form>

                </div>

            </div>

        </div>
        <script src="<?php echo base_url('static/'); ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url('static/'); ?>assets/scripts/bootstrap.min.js"></script>
    </body>

</html>
