

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
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>	
		<script>
		$(document).ready(function(){
		 
		  // Initialize select2
		  $("#selUser").select2();
		
		  // Read selected option
		  $('#but_read').click(function(){
			var username = $('#selUser option:selected').text();
		  });
		});
		</script>
    </head>

    <body>
		<div id='result'></div>
        <div class="container">

            <div class="row">

                <div class="col-md-offset-4 col-md-4 col-md-offset-4 login-form">

                    <center>
                       <img src="<?php echo base_url('static/assets/img/blip.png'); ?>" width="200" alt="Get Biger Image">
					   
					   <br>
					   
					   <div style="font-weight:bold; font-size:16px"><?php echo $title; ?></div>
					   
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

                    <?php echo form_open('specialtools/simpan_bypass'); ?>

                        <div class="form-group">
					
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
								<select class="form-control" name="ip_public" id="selUser" placeholder="IP Public Pelanggan" required autofocus>
								<?php foreach ($item_router as $router): ?>
								<option value="<?php echo $router['id']; ?>"><?php echo $router['nama']; ?></option>
								<?php endforeach; ?>
								</select
                            ></div>
                        </div>
						<br>
						<div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" class="form-control" id="ip_device" name="ip_device" placeholder="IP Device Bypass" required autofocus>
                            </div>
                        </div>

                        <div class="spacer-1"></div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg">S I M P A N</button>

                        <div class="spacer-1"></div>
                    </form>

                </div>

            </div>

        </div>

    </body>

</html>
