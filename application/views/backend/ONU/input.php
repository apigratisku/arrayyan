<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">TAMBAH DATA ONU</div>

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
        if (isset($item)) {
            echo form_open('manage/onu/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/onu/simpan');
        }
        ?>
			<div class="col-md-6">
			  <div class="form-group">
                        <label for="level">OLT</label>
                        <select class="form-control" id="olt" name="olt" placeholder="Data OLT" value="<?php echo isset($item['id_olt']) ? $item['id_olt'] : ''; ?>">			<option value="">-OLT-</option>
						<?php $olt_id = $this->db->get_where('blip_olt', array('id' => $item['id_olt']))->row_array(); ?>
						<?php if(isset($olt_id['id'])):?><option value="<?php echo isset($olt_id['id']) ? $olt_id['id'] : ''; ?>" selected><?php echo isset($olt_id['id']) ? $olt_id['olt_nama'] : ''; ?></option><?php endif; ?>
						<?php foreach ($item_olt as $olt): ?>
						<option value="<?php echo $olt['id']; ?>"><?php echo $olt['olt_nama']; ?></option>
						<?php endforeach; ?>
						</select>
             </div>
			  <div class="form-group">
                        <label for="level">Pelanggan</label>
                        <select class="form-control" id="pelanggan" name="pelanggan" placeholder="Data Pelanggan" value="<?php echo isset($item) ? $item['id_pelanggan'] : ''; ?>">			<option value="">-Pelanggan-</option>

						<?php foreach ($item_pelanggan as $pelanggan): ?>
						
						<?php 
						if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";$disabled="";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
						?>
				<option value="<?php echo isset($pelanggan) ? $pelanggan['id'] : ''; ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>
						<?php endforeach; ?>
						</select>
             </div>
			 <div class="form-group">
                        <label for="level">Layanan 1</label>
                        <div class="form-group">
					   <select name="layanan1" id="layanan1" class="form-control" required>
						<option value="">-Layanan 1-</option>
					   </select>
					  </div>
             </div>
			 <div class="form-group">
                        <label for="level">Layanan 2</label>
                        <div class="form-group">
					   <select name="layanan2" id="layanan2" class="form-control">
						<option value="">-Layanan 2-</option>
					   </select>
					  </div>
             </div>
			 <div class="form-group">
                        <label for="level">Layanan 3</label>
                        <div class="form-group">
					   <select name="layanan3" id="layanan3" class="form-control">
						<option value="">-Layanan 3-</option>
					   </select>
					  </div>
             </div>
			 
			
			 <label for="nama_keahlian">SN</label>
			 <a name="snSCAN"></a>
			<div class="input-group margi">
                
				<?php /*
				require_once APPPATH."third_party/addon.php";
				$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
				$ar_str_ip = $item['olt_ip'];
				$ar_enc_ip = $ar_chip->decrypt($ar_str_ip, $ar_rand);
				$ar_str_user = $item['olt_user'];
				$ar_enc_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
				$ar_str_pass = $item['olt_pwd'];
				$ar_enc_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
				$hostname = $ar_enc_ip;
				$username = $ar_enc_user;
				$password = $ar_enc_pass;


				if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
					echo "$errstr ($errno)<br />\n";
				}else{
					$this->load->library('phptelnet');
					$telnet = new PHPTelnet();
					$result = $telnet->Connect($hostname,$username,$password);
					if ($result == 0)
					{
						$telnet->DoCommand('show system-group', $result);
						$skuList = preg_split('/\r\n|\r|\n/', $result);	
						//Cek Brand
						if($item['olt_brand'] == "ZTE")
						{
							foreach($skuList as $key => $value)
							{
							 $olt_uptime = $skuList[6];
							}
							echo substr($olt_uptime,16);
						}
					}
				} */
				?>
				<script>
				function doSCAN() {
				  window.open("<?php echo base_url('manage/onu/do_scan_sn') ?>","_blank", "toolbar=no,scrollbars=no,resizable=no,top=500,left=500,width=500,height=400");
				}
				</script>
                <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo isset($item['serial_number']) ? $item['serial_number'] : ''; ?>" required autofocus style="width:99%">
				<span class="input-group-btn">
                      
					  <a class="btn btn-info btn-flat" href="#snSCAN" onclick="javascript:doSCAN()">SCAN!</a>
                    </span>
            </div><br />
			<div class="form-group">
                <label for="nama_keahlian">QNQ Vlan</label>
                <input type="text" class="form-control" id="qnq_vlan" name="qnq_vlan" value="<?php echo isset($item['qnq_vlan']) ? $item['qnq_vlan'] : ''; ?>" required autofocus>
            </div>	
			<div class="form-group">
                <label for="nama_keahlian">ONU Index</label>
                <input type="text" class="form-control" id="onu_index" name="onu_index" value="<?php echo isset($item['onu_index']) ? $item['onu_index'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">MGMT IP</label>
                <input type="text" class="form-control" id="mgmt_ip" name="mgmt_ip" value="<?php echo isset($item['mgmt_ip']) ? $item['mgmt_ip'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">MGMT GW</label>
                <input type="text" class="form-control" id="mgmt_gw" name="mgmt_gw" value="<?php echo isset($item['mgmt_gw']) ? $item['mgmt_gw'] : ''; ?>" required autofocus>
            </div>	
			<div class="form-group">
                <label for="nama_keahlian">Status Open Port</label><br />
                <input type="checkbox" id="port1" name="port1" value="unlock" checked="checked"> Port 1 &nbsp;
				<input type="checkbox" id="port2" name="port2" value="unlock" checked="checked"> Port 2 &nbsp;
				<input type="checkbox" id="port3" name="port3" value="unlock" checked="checked"> Port 3 &nbsp;
				<input type="checkbox" id="port4" name="port4" value="unlock" checked="checked"> Port 4 &nbsp;
            </div>	
			
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
					&nbsp;
					<a href="<?php echo base_url('manage/onu'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    
                </div>
            </div>
			
			</div>
            

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
<script type="text/javascript">
$(function () {
    var today = new Date();
	var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
	var time = today.getHours() + ":" + today.getMinutes();
	var dateTime = date+' '+time;
    $("#form_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });
});
</script>

<!-- Script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type='text/javascript'>
  // baseURL variable
  var baseURL= "<?php echo base_url();?>";
 
  $(document).ready(function(){
 
    // City change
    $('#pelanggan').change(function(){
      var pelanggan = $(this).val();

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>/manage/scheduler/fetch_layanan',
        method: 'post',
        data: {pelanggan: pelanggan},
        dataType: 'json',
        success: function(response){

          // Remove options 
          $('#layanan1').find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#layanan1').append('<option value="'+data['id']+'">'+data['produk']+' '+data['id_bandwidth']+' Mbps</option>');
          });
		  
		  // Remove options 
          $('#layanan2').find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#layanan2').append('<option value="'+data['id']+'">'+data['produk']+' '+data['id_bandwidth']+' Mbps</option>');
          });
		  
		  // Remove options 
          $('#layanan3').find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#layanan3').append('<option value="'+data['id']+'">'+data['produk']+' '+data['id_bandwidth']+' Mbps</option>');
          });
        }
     });
   });
 
 });
 </script>