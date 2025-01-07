<?php
require APPPATH."third_party/addon.php";
$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
?>

<!-- PANEL HEADLINE -->

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">MAINTENANCE PREVENTIVE</div>

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
		

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">User Akses</a></li>		  
			  <li><a href="#tab_2" data-toggle="tab">Rule Filter</a></li>		  
            </ul>
			
            <div class="tab-content">    
             
			  <!-- /.tab-pane -->
               <div class="tab-pane active" id="tab_1">
				 <div class="col-md-12">
				 
				
				 
					<div class="table-responsive">
			<table class="table table-bordered table-hover" id="example2">

            <thead>

                <tr>
                    <th>BTS</th>
					<th>Sektor</th>
					<th>IP Address</th>
					<th style="text-align:center" width="10%">Status</th>
                </tr>

            </thead>

            <tbody>
				<?php $datahistory = $this->db->get('blip_maintenance_akses_history')->result_array(); ?>
                <?php foreach ($datahistory as $data): ?>
				<?php 
				if($data['role'] == "Radio AP BTS"){
				$data_perangkat = $this->db->get_where('gm_bts', array('id' => $data['id_ap']))->row_array();
				} 
				?>
                    <tr>
                        <td>
                            <?php echo $data_perangkat['nama_bts']; ?>
                        </td><td>
                            <?php echo $data_perangkat['sektor_bts']; ?>
                        </td><td>
                            <?php echo $data_perangkat['ip']; ?>
                        </td><td style="text-align:center" width="10%">
							<?php 
							if($data['status'] == "1"){
							echo "<dkv style=\"color:#008000\"><i class=\"fa fa-check\"></i>&nbsp; Syncronized</div>";
							}else{
							echo "<i class=\"fa fa-arrow-circle-left\"></i>Failed";
							}
							?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table><br />
					</div>
				</div>
				
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