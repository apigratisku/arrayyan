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


<!-- START MENU ROUTER -->	
	<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<li class="active"><a href="#tab-bottom-left5" role="tab" data-toggle="tab">Radio BTS</a></li>
					<li><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Radio Client</a></li>
					<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Router Client</a></li> 

				</ul>
			</div>

    </div>
	
	<div class="tab-content">

			<div class="tab-pane fade in active" id="tab-bottom-left5">
			<label for="tipe">Broadcast Penggantian User & Password BTS</label><br />
			<hr class="panel-divider">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
			<?php echo form_open('manage/maintenance/maintenance_radio_bts'); ?>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama_keahlian">User Baru</label>
					<input type="text" class="form-control" id="user1" name="user1" value="" required autofocus>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama_keahlian">Password Baru</label>
					<input type="text" class="form-control" id="pass1" name="pass1" value="" required autofocus>
				</div>
				<div class="form-group">
					<label for="nama_keahlian">Password Baru (Konfirmasi)</label>
					<input type="text" class="form-control" id="pass2" name="pass2" value="" required autofocus>
				</div>
			</div>
			
			 <div class="row">
                <div class="col-md-12 form-buttons">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>
			</form>	
		
			<label for="tipe">Preventive Maintenance Radio BTS. <a href="<?php echo base_url(); ?>manage/bts/maintenance" target="_blank">&laquo; Mulai Proses &raquo;</a></label> 
			<br />
			<label for="tipe">Pengecekan Hasil Preventive <a href="<?php echo base_url(); ?>manage/bts/maintenance_result" target="_blank">&laquo; Lihat Hasil &raquo;</a></label> 
			<br />
			<hr class="panel-divider">				
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane fade" id="tab-bottom-left1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<?php echo form_open('manage/maintenance/maintenance_radio_client'); ?>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama_keahlian">User Lama</label>
										<input type="text" class="form-control" id="user0" name="user0" value="" required autofocus>
									</div>
									<div class="form-group">
										<label for="nama_keahlian">User Baru</label>
										<input type="text" class="form-control" id="user1" name="user1" value="" required autofocus>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama_keahlian">Password Lama</label>
										<input type="text" class="form-control" id="pass0" name="pass0" value="" required autofocus>
									</div>
									<div class="form-group">
										<label for="nama_keahlian">Password Baru</label>
										<input type="text" class="form-control" id="pass1" name="pass1" value="" required autofocus>
									</div>
									<div class="form-group">
										<label for="nama_keahlian">Password Baru (Konfirmasi)</label>
										<input type="text" class="form-control" id="pass2" name="pass2" value="" required autofocus>
									</div>
								</div>
								
								 <div class="row">
									<div class="col-md-12 form-buttons">
										<button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
									</div>
								</div>
								</form>	
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="tab-bottom-left2">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<?php echo form_open('manage/maintenance/maintenance_router_client'); ?>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama_keahlian">User Baru</label>
										<input type="text" class="form-control" id="user1" name="user1" value="" required autofocus>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama_keahlian">Password Baru</label>
										<input type="text" class="form-control" id="pass1" name="pass1" value="" required autofocus>
									</div>
									<div class="form-group">
										<label for="nama_keahlian">Password Baru (Konfirmasi)</label>
										<input type="text" class="form-control" id="pass2" name="pass2" value="" required autofocus>
									</div>
								</div>
								
								 <div class="row">
									<div class="col-md-12 form-buttons">
										<button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
			
				
</div>
<!-- END PANEL HEADLINE -->

</div>

<!-- END PANEL HEADLINE -->
