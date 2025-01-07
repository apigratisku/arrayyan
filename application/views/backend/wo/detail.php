 <?php 
if(isset($item['router_user'])){
require APPPATH."third_party/addon.php";
$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
$router_u = $item['router_user'];
$router_user = $ar_chip->decrypt($router_u, $ar_rand); }

if(isset($item['router_pass'])){
$router_p = $item['router_pass'];
$router_pass = $ar_chip->decrypt($router_p, $ar_rand); }

if(isset($item['lastmile_user'])){
$lastmile_u = $item['lastmile_user'];
$lastmile_user = $ar_chip->decrypt($lastmile_u, $ar_rand); }

if(isset($item['lastmile_password'])){
$lastmile_p = $item['lastmile_pass'];
$lastmile_pass = $ar_chip->decrypt($lastmile_p, $ar_rand); }
?>


<!-- PANEL HEADLINE -->

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA WO (WORK ORDER)</div>
<br>


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
        if (isset($item['id'])) {
            echo form_open('manage/data_pelanggan/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/data_pelanggan/simpan');
        }
        ?>
		

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Data Admin</a></li>
            </ul>
			
            <div class="tab-content">
			<br />
              <div class="tab-pane active" id="tab_1">
               
			<?php
			date_default_timezone_set("Asia/Singapore");
			?>
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
					 <tr>
                            <td>
                               <b>Request</b>
                            </td><td>
                             <?php 
							$query_request = $this->db->get_where('blip_kpi', array('id' => $item['request']));
           					$data_request = $query_request->row_array();
							echo $data_request['kegiatan']; 
							?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                               <b>Brand</b>
                            </td><td>
                                 <?php if(isset($item['brand'])):?><?php echo isset($item['brand']) ? $item['brand'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tahun</b>
                            </td><td>
                             <?php if(isset($item['tahun'])):?><?php echo isset($item['tahun']) ? $item['tahun'] : ''; ?><?php echo isset($item['tahun']) ? $item['tahun'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Nama Pelanggan</b>
                            </td><td>
                               <?php echo isset($item['nama']) ? $item['nama'] : ''; ?> 
                            </td>
                        </tr><tr>
                            <td>
                                <b>Regional</b>
                            </td><td>
                               <?php echo isset($item) ? $item['region'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Area</b>
                            </td><td>
                               <?php echo isset($item) ? $item['area'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Level Prioritas</b>
                            </td><td>
                               <?php $levelid = $this->db->get_where('blip_level_prioritas', array('id' => $item['level']))->row_array(); ?>
				<?php if(isset($levelid['id'])):?><?php echo isset($levelid['id']) ? $levelid['level'] : ''; ?><?php else: ?>-<?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Media Access</b>
                            </td><td>
                               <?php $media_id = $this->db->get_where('blip_mediaaccess', array('id' => $item['media']))->row_array(); ?>
				<?php if(isset($media_id['id'])):?><?php echo isset($media_id['id']) ? $media_id['media'] : ''; ?><?php else: ?>-<?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Produk 1</b>
                            </td><td>
                               <?php $produk_id = $this->db->get_where('blip_produk', array('id' => $item['produk1']))->row_array(); ?>
				<?php if(isset($produk_id['produk'])):?><?php echo isset($produk_id['produk']) ? $produk_id['produk'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Produk 2</b>
                            </td><td>
                               <?php $produk_id = $this->db->get_where('blip_produk', array('id' => $item['produk2']))->row_array(); ?>
				<?php if(isset($produk_id['produk'])):?><?php echo isset($produk_id['produk']) ? $produk_id['produk'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Bandwidth Produk 1</b>
                            </td><td>
                              <?php echo isset($item['bandwidth1']) ? $item['bandwidth1']. " Mbps" : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Bandwidth Produk 2</b>
                            </td><td>
                              <?php echo isset($item['bandwidth2']) ? $item['bandwidth2']. " Mbps" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Divisi</b>
                            </td><td>
                               <?php if(isset($item['admin_divisi'])):?><?php echo isset($item['admin_divisi']) ? $item['admin_divisi'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Sales</b>
                            </td><td>
                               <?php $salesid = $this->db->get_where('blip_sales', array('id' => $item['admin_sales']))->row_array(); ?>
				<?php if(isset($salesid['id'])):?><?php echo isset($salesid) ? $salesid['nama'] : '-'; ?><?php endif; ?>
                            </td>
                        </tr>
						
                    </tbody>
                </table>
			</div>
			
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>CID</b>
                            </td><td>
                                 <?php echo isset($item['cid']) ? $item['cid'] : '-'; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>SID</b>
                            </td><td>
                             <?php echo isset($item['sid']) ? $item['sid'] : '-'; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Segment</b>
                            </td><td>
                               
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Sub Segment</b>
                            </td><td>
                               
                            </td>
                        </tr><tr>
                            <td>
                                <b>Alamat</b>
                            </td><td>
                               <?php echo isset($item['admin_alamat']) ? $item['admin_alamat'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Kordinat</b>
                            </td><td>
                             <?php echo isset($item['kordinat']) ? $item['kordinat'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Email</b>
                            </td><td>
                               <?php echo isset($item['email']) ? $item['email'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Kontak</b>
                            </td><td>
                              <?php echo isset($item['kontak']) ? $item['kontak'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>PIC</b>
                            </td><td>
                               <?php echo isset($item['pic']) ? $item['pic'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Form Langganan</b>
                            </td><td style="font-size:11px;">
                               <?php echo isset($item['admin_form_langganan']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_form_langganan'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td style="font-size:11px;">
                                <b>KTP</b>
                            </td><td>
                               <?php echo isset($item['admin_ktp_identitas']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_ktp_identitas'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td style="font-size:11px;">
                                <b>NPWP</b>
                            </td><td>
                              <?php echo isset($item['admin_npwp']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_npwp'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td style="font-size:11px;">
                                <b>Lampiran BAA</b>
                            </td><td>
                              <?php echo isset($item['admin_form_baa']) ? "<a href=".base_url('xdark/doc/attachment/'.$item['admin_form_baa'])." target=\"_blank\">[Lihat Attachment]</a>" : ''; ?>
                            </td>
                        </tr>
						
                    </tbody>
                </table>	

			
			
			
			
			
			
			</div>
			
			
			
			</div>
			<div class="col-md-6">
			<!-- PANEL HEADLINE 1 -->
			<div class="col-md-6">
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Tgl Req Sales</b>
                            </td><td>
                                 <?php echo isset($item['tgl_req_sales']) ? $item['tgl_req_sales'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tgl Req Teknis</b>
                            </td><td>
                             <?php echo isset($item['tgl_req_teknis']) ? $item['tgl_req_teknis'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tgl Pekerjaan Teknis</b>
                            </td><td>
                              <?php echo isset($item['tgl_aktivasi_teknis']) ? $item['tgl_aktivasi_teknis'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tgl Report Teknis</b>
                            </td><td>
                              <?php echo isset($item['tgl_report_teknis']) ? $item['tgl_report_teknis'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Terbit BAA</b>
                            </td><td>
                              <?php echo isset($item['tgl_terbit_baa']) ? $item['tgl_terbit_baa'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Req OB</b>
                            </td><td>
                              <?php echo isset($item['tgl_req_ob']) ? $item['tgl_req_ob'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Start OB</b>
                            </td><td>
                              <?php echo isset($item['tgl_start_ob']) ? $item['tgl_start_ob'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl Terbit Invoice</b>
                            </td><td>
                               <?php echo isset($item['tgl_terbit_inv']) ? $item['tgl_terbit_inv'] : ''; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Tgl RFS</b>
                            </td><td>
                               <?php echo isset($item['tgl_rfs']) ? $item['tgl_rfs'] : ''; ?>
                            </td>
                        </tr>
						
						
                    </tbody>
                </table>	
			

			
			</div>
			
			<!-- PANEL HEADLINE 2 -->
			<div class="col-md-6">
			<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='6' || $this->session->userdata('ses_admin')=='7' || $this->session->userdata('ses_admin')=='8'):?>
			<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Biaya OTC</b>
                            </td><td>
                               <?php echo isset($item['admin_biaya_otc']) ? number_format($item['admin_biaya_otc'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Biaya Berlangganan</b>
                            </td><td>
                            <?php echo isset($item['admin_biaya_mtc']) ? number_format($item['admin_biaya_mtc'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Biaya Partner</b>
                            </td><td>
                             <?php echo isset($item['admin_biaya_partner']) ? number_format($item['admin_biaya_partner'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Biaya CB</b>
                            </td><td>
                              <?php echo isset($item['admin_biaya_cb']) ? number_format($item['admin_biaya_cb'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Net Profit</b>
                            </td><td>
                              <?php echo isset($item['admin_biaya_netprofit']) ? number_format($item['admin_biaya_netprofit'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr>
						<?php if($data_request['id'] == "9"): ?>
						<tr>
                            <td>
                                <b>Loss</b>
                            </td><td style="font-size:14px; color:#FF0000; font-weight:bold">
                              <?php echo isset($item['admin_biaya_netprofit']) ? number_format($item['admin_biaya_netprofit'], 0, ",", ".") : ''; ?>
                            </td>
                        </tr>
						<?php endif; ?>
						
						
                    </tbody>
                </table>
				
				
				<?php  endif; ?>
				<table class="table table-striped table-bordered" style="font-size:10px">
                    <tbody>
                        <tr>
                            <td>
                               <b>Keterangan</b>
                            </td><td>
                              <?php echo isset($item['keterangan']) ? $item['keterangan'] : ''; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Klasifikasi Service</b>
                            </td><td><b>
                           <?php if(isset($item_pelanggan['klasifikasi_service'])){
						   if($item_pelanggan['klasifikasi_service'] == "0"){
						   echo "Bandwidth Only";}elseif($item['klasifikasi_service'] == "1"){
						   echo "Manage Only";}elseif($item['klasifikasi_service'] == "2"){
						   echo "Manage Service";}} 
						   ?></b>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Status Pelanggan</b>
                            </td><td><b>
                           <?php if(isset($item_pelanggan['status_pelanggan'])){
						   if($item_pelanggan['status_pelanggan'] == "0"){
						   echo "Tidak Aktif";}elseif($item['status_pelanggan'] == "1"){
						   echo "Aktif";}elseif($item['status_pelanggan'] == "2"){
						   echo "Isolir";}elseif($item['status_pelanggan'] == "3"){
						   echo "Dismantle";}} 
						   ?></b>
                            </td>
                        </tr>
						
						
						
                    </tbody>
                </table>		

			
			
			</div>
			</div>
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

<script type="text/javascript" src="<?php echo base_url().'static/assets/js/jquery.js'?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
             $('#cid').on('input',function(){
                 
                var cid=$(this).val();
                $.ajax({
                    type : "POST",
                    url  : "<?php echo base_url('manage/wo/get_pelanggan')?>",
                    dataType : "JSON",
                    data : {cid: cid},
                    cache:false,
                    success: function(data){
                        $.each(data,function(cid, nama, sid, bandwidth){
                            $('[name="nama"]').val(data.nama);
							$('[name="sid"]').val(data.sid);
                            $('[name="bandwidth"]').val(data.bandwidth);
 
                             
                        });
                         
                    }
                });
                return false;
           });
 
        });
    </script>
			   
			   
              </div>
              <!-- /.tab-pane -->
             
            </div>
            <!-- /.tab-content -->
          </div>
        <!-- /.col -->



            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="javascript:history.go(-1)" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                   
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