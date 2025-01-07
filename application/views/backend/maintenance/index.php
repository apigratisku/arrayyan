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
				 
				  <div class="panel-heading">

						<!-- /.box-body -->
						<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3'): ?>
							  <div class="box-footer">	
							  <table id="example1" width="14%" align="right">
									<tr>
										<th><a href="<?php echo base_url('manage/maintenance/user_akses_tambah'); ?>" class="btn btn-primary pull-right">Tambah Data</a></th>
										<th><a href="<?php echo base_url('manage/maintenance/user_akses_history'); ?>" class="btn btn-warning pull-right">Log History</a></th>
									</tr>
								</table>
								 
								 
							  </div>
						<?php endif; ?>
					</div>
				 
				 
					<div class="table-responsive">
				   <table class="table table-bordered table-hover" id="example1">
			
						<thead>
			
							<tr>
								<th>Role</th>
								<th>User</th>
								<th>Password</th>
								<th style="text-align:center">Tindakan</th>
							</tr>
			
						</thead>
			
						<tbody>
			
							<?php foreach ($items_akses as $akses): ?>
							<?php
							$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
							$router_u = $akses['user'];
							$user = $ar_chip->decrypt($router_u, $ar_rand);
							
							$router_p = $akses['password'];
							$pass = $ar_chip->decrypt($router_p, $ar_rand); 
							?>
								<tr>
									<td>
									<?php echo isset($akses['role']) ? $akses['role'] : ''; ?>
									</td><td>
										<?php echo isset($akses['user']) ? $user : ''; ?>
									</td><td>
									 <?php echo isset($akses['password']) ? $pass : ''; ?>
									</td><td style="text-align:center"><a href="<?php echo base_url('manage/maintenance/' . $akses['id'] . '/user_akses_sync'); ?>" class="btn btn-xs btn-primary" onClick="javascript:return confirm('Proses syncronize konfigurasi. Lanjutkan ?')" title="Upload Konfigurasi">Syncronize</a>
<a href="<?php echo base_url('manage/maintenance/' . $akses['id'] . '/user_akses_ubah'); ?>" class="btn btn-xs btn-warning">Ubah</a>
<a href="<?php echo base_url('manage/maintenance/' . $akses['id'] . '/user_akses_hapus'); ?>" class="btn btn-xs btn-danger" onClick="javascript:return confirm('Yakin ingin menghapus data?')">Hapus</a>
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