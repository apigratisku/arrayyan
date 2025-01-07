 <?php 
if(isset($get_item['router_user'])){
require APPPATH."third_party/addon.php";
$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
$router_u = $get_item['router_user'];
$router_user = $ar_chip->decrypt($router_u, $ar_rand); }

if(isset($get_item['router_pass'])){
$router_p = $get_item['router_pass'];
$router_pass = $ar_chip->decrypt($router_p, $ar_rand); }

if(isset($get_item['lastmile_user'])){
$lastmile_u = $get_item['lastmile_user'];
$lastmile_user = $ar_chip->decrypt($lastmile_u, $ar_rand); }

if(isset($get_item['lastmile_password'])){
$lastmile_p = $get_item['lastmile_pass'];
$lastmile_pass = $ar_chip->decrypt($lastmile_p, $ar_rand); }
?>


<!-- PANEL HEADLINE -->

<div class="panel panel-headline">


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

        <?php
        if (isset($get_item)) {
            echo form_open('manage/router/' . $get_item['id'] . '/timpa');
        } else {
            echo form_open('manage/router/simpan');
        }
        ?>
		

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Data Admin</a></li>
              <li><a href="#tab_2" data-toggle="tab">Data Teknis</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
               
				   <div class="form-group">
					<label for="nama_keahlian">Media</label>
					<select class="form-control" id="akses" name="akses"  onChange="top.location.href = this.form.akses.options[this.form.akses.selectedIndex].value;
	return false;" required>								
					<option value="<?php echo base_url('manage/router/tambah_fo_onnet'); ?>">Fiber Optic (Onnet)</option>
					<option value="<?php echo base_url('manage/router/tambah_fo_cgs'); ?>">Fiber Optic (CGS)</option>
					<option value="<?php echo base_url('manage/router/tambah_fo_telkom'); ?>">Fiber Optic (TELKOM)</option>
					<option value="<?php echo base_url('manage/router/tambah_fo_icon'); ?>">Fiber Optic (ICON)</option>
					<option value="<?php echo base_url('manage/router/tambah_fo_mitra'); ?>">Fiber Optic (MITRA LAIN)</option>
					<option value="<?php echo base_url('manage/router/tambah_we'); ?>" selected>Wireless</option>
					</select>
					<input type="hidden" name="media" value="WE" />
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Regional</label>
					<select class="form-control" id="regional" name="regional" required>	
	<?php if(isset($get_item['regional'])):?><option value="<?php echo isset($get_item) ? $get_item['regional'] : ''; ?>" selected><?php echo isset($get_item) ? $get_item['regional'] : ''; ?></option>	<?php endif; ?>						
					<option value="NTB">NTB</option>
					<option value="BALI">BALI</option>
					</select>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">CID</label>
					<input type="text" class="form-control" id="cid" name="cid" value="<?php echo isset($get_item) ? $get_item['cid'] : ''; ?>" required autofocus>
				</div>
				 <div class="form-group">
					<label for="nama_keahlian">SID</label>
					<input type="text" class="form-control" id="sid" name="sid" value="<?php echo isset($get_item) ? $get_item['sid'] : ''; ?>" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Klasifikasi Layanan</label>
					<select class="form-control" id="klasifikasi_layanan" name="klasifikasi_layanan" required>	
	<?php if(isset($get_item['klasifikasi_layanan'])):?><option value="<?php echo isset($get_item) ? $get_item['klasifikasi_layanan'] : ''; ?>" selected><?php echo isset($get_item) ? $get_item['klasifikasi_layanan'] : ''; ?></option>	<?php endif; ?>						
					<option value="REGULER">REGULER</option>
					<option value="GOLD">GOLD</option>
					<option value="PLATINUM">PLATINUM</option>
					<option value="PRIORITAS">PRIORITAS</option>
					<option value="NON PRIORITAS">NON PRIORITAS</option>
					</select>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Nama Pelanggan</label>
					<input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($get_item) ? $get_item['nama'] : ''; ?>" required autofocus>
				</div>
				
				<div class="form-group">
					<label for="nama_keahlian">Produk</label>
					<select class="form-control" id="produk" name="produk" required>	
	<?php if(isset($get_item['produk'])):?><option value="<?php echo isset($get_item) ? $get_item['produk'] : ''; ?>" selected><?php echo isset($get_item) ? $get_item['produk'] : ''; ?></option>	<?php endif; ?>						
					<option value="MAXI">MAXI</option>
					<option value="GFORCE">GFORCE</option>
					<option value="FIBERSTREAM">FIBERSTREAM</option>
					<option value="IPVPN">IPVPN</option>
					<option value="BLiP Busol Access">BLiP Busol Access</option>
					<option value="BLiP Busol Starter">BLiP Busol Starter</option>
					<option value="BLiP Busol Business">BLiP Busol Business</option>
					<option value="BLiP Busol Dedicated">BLiP Busol Dedicated</option>
					<option value="BLiP Broadband Business">BLiP Broadband Business</option>
					<option value="BLiP Ultra">BLiP Ultra</option>
					<option value="BLiP Starter">BLiP Starter</option>
					</select>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Area</label>
					 <select class="form-control" id="area" name="area" required>								
					<option value="">- Area -</option>
	<?php if(isset($get_item['area'])):?><option value="<?php echo isset($get_item) ? $get_item['area'] : ''; ?>" selected><?php echo isset($get_item) ? $get_item['area'] : ''; ?></option><?php endif; ?>
					<option value="MATARAM">MATARAM</option>
					<option value="LOMBOK BARAT">LOMBOK BARAT</option>
					<option value="LOMBOK TENGAH">LOMBOK TENGAH</option>
					<option value="LOMBOK TIMUR">LOMBOK TIMUR</option>
					<option value="LOMBOK UTARA">LOMBOK UTARA</option>
					<option value="GILI TRAWANGAN">GILI TRAWANGAN</option>
					<option value="GILI AIR">GILI AIR</option>
					<option value="GILI MENO">GILI MENO</option>
					<option value="SUMBAWA">SUMBAWA</option>
					<option value="DOMPU">DOMPU</option>
					<option value="BIMA">BIMA</option>
					</select>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Email</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo isset($get_item) ? $get_item['email'] : ''; ?>" autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Kontak</label>
					<input placeholder="Contoh: https://wa.me/6282144619515" type="text" class="form-control" id="kontak" name="kontak" value="<?php echo isset($get_item) ? $get_item['kontak'] : ''; ?>" autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">PIC</label>
					<input type="text" class="form-control" id="pic" name="pic" value="<?php echo isset($get_item) ? $get_item['pic'] : ''; ?>" autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Kordinat</label>
					<input placeholder="Contoh: https://goo.gl/maps/9znQoeWy3dV3kW7C7" type="text" class="form-control" id="kordinat" name="kordinat" value="<?php echo isset($get_item) ? $get_item['kordinat'] : ''; ?>" autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Status Layanan</label>
					<select class="form-control" id="status_layanan" name="status_layanan" required>	
	<?php if(isset($get_item['status_layanan'])):?><option value="<?php echo isset($get_item) ? $get_item['status_layanan'] : ''; ?>" selected><?php echo isset($get_item) ? $get_item['status_layanan'] : ''; ?></option>	<?php endif; ?>						
					<option value="AKTIF">AKTIF</option>
					<option value="ISOLIR">ISOLIR</option>
					<option value="DISMANTLE">DISMANTLE</option>
					</select>
				</div>
			   
			   
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <div class="col-md-6">
					<div class="form-group">
					<label for="bts">POP</label>
					<select class="form-control" id="pop" name="pop" required>	
					<?php if(isset($get_item)):?>							
					<option value="<?php echo isset($get_item) ? $get_item['pop'] : ''; ?>" selected><?php $pop = $this->db->get_where('gm_pop', array('pop' => $get_item['pop']))->row_array(); echo $pop['pop']; ?></option>	
					<?php endif; ?>
					<?php foreach ($get_pop as $pop): ?>
					<option value="<?php echo $pop['pop'] ?>"><?php echo $pop['pop'] ?></option>	
					<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="bts">BTS/TE</label>
					<select class="form-control" id="te" name="te" required>	
					<?php if(isset($get_item)):?>			
					<option value="<?php echo isset($get_item) ? $get_item['TE'] : ''; ?>" selected><?php $te = $this->db->get_where('gm_te', array('id' => $get_item['TE']))->row_array(); echo $te['nama']; ?></option>	
					<?php endif; ?>
					
					<?php foreach ($te_items as $te_item): ?>							
					<option value="<?php echo $te_item['id']; ?>"><?php echo $te_item['nama']; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
				 <div class="form-group">
					<label for="bts">Sektor BTS</label>
					<select class="form-control" id="bts" name="bts" required>
					<?php if(isset($get_item)):?>
					<option value="<?php echo isset($get_item) ? $get_item['bts'] : ''; ?>" selected><?php $bts = $this->db->get_where('gm_bts', array('id' => $get_item['bts']))->row_array(); echo $bts['sektor_bts']; ?></option>		
					<?php endif; ?>
					<?php foreach ($bts_items as $bts_item): ?>							
					<option value="<?php echo $bts_item['id']; ?>"><?php echo $bts_item['sektor_bts']; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="dr">Router Distribusi</label>
					<select class="form-control" id="dr" name="dr" required>
					<?php if(isset($get_item)):?>
					<option value="<?php echo isset($get_item) ? $get_item['DR'] : ''; ?>" selected><?php $dr = $this->db->get_where('gm_dr', array('id' => $get_item['DR']))->row_array(); echo $dr['nama']; ?></option>	
					<?php endif; ?>	
					<?php foreach ($dr_items as $dr_item): ?>							
					<option value="<?php echo $dr_item['id']; ?>"><?php echo $dr_item['nama']; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">IP Lastmile</label>
					<input type="text" class="form-control" id="lastmile" name="lastmile_ip" value="<?php echo isset($get_item) ? $get_item['lastmile'] : ''; ?>" required autofocus>
				</div>
				
				<div class="form-group">
					<label for="nama_keahlian">IP Router</label>
					<input type="text" class="form-control" id="router_ip" name="router_ip" value="<?php echo isset($get_item) ? $get_item['router_ip'] : ''; ?>" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Network Router</label>
					<input placeholder="Contoh: x.x.x.x/x" type="text" class="form-control" id="router_network" name="router_network" value="<?php echo isset($get_item) ? $get_item['router_network'] : ''; ?>" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">User Router</label>
					<input type="text" class="form-control" id="router_user" name="router_user" value="<?php echo isset($get_item) ? $router_user : ''; ?>" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Password Router</label>
					<input type="password" class="form-control" id="router_pass" name="router_pass" value="<?php echo isset($get_item) ? $router_pass : ''; ?>" required autofocus>
				</div>
			</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="nama_keahlian">BW Interface Monitoring</label>
					<input placeholder="Contoh: ether1/ether2/ether3,dst. . ." type="text" class="form-control" id="interface" name="interface" value="<?php echo isset($get_item) ? $get_item['interface'] : ''; ?>" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Bandwidth</label>
					<input placeholder="Contoh: 5,10,15,20,dst. . ." type="text" class="form-control" id="intTextBox" name="bandwidth" value="<?php echo isset($get_item) ? $get_item['bandwidth'] : ''; ?>" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">PPPOE User</label>
					<input type="text" class="form-control" id="pppoe_user" name="pppoe_user" value="<?php echo isset($get_item) ? $get_item['pppoe_user'] : ''; ?>" autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">PPPOE Password</label>
					<input type="text" class="form-control" id="pppoe_pass" name="pppoe_pass" value="<?php echo isset($get_item) ? $get_item['pppoe_pass'] : ''; ?>" autofocus>
				</div>
			
				</div>
				
				
				
              </div>
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        <!-- /.col -->
		
			<div class="col-md-6">
			
			
			
			
			</div>


            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/router'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->


<script type="text/javascript">
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));


// Install input filters.
$("#intTextBox").inputFilter(function(value) {
  return /^-?\d*$/.test(value); });
$("#uintTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$("#intLimitTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
$("#floatTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d*$/.test(value); });
$("#currencyTextBox").inputFilter(function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });
$("#latinTextBox").inputFilter(function(value) {
  return /^[a-z]*$/i.test(value); });
$("#hexTextBox").inputFilter(function(value) {
  return /^[0-9a-f]*$/i.test(value); });
</script>
<!-- END PANEL HEADLINE -->