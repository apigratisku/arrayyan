<?php
clearstatcache();
?>
<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('static/assets/'); ?>/img/logo_web.png">
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
                       <img src="<?php echo base_url('static/assets/img/logo.png'); ?>" width="300" alt="Get Biger Image">
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

                    <?php echo form_open('auth/login'); ?>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" class="form-control" id="userid" name="userid" placeholder="UserID" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>

                        <div class="spacer-1"></div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg">LOGIN</button>

                        <div class="spacer-1"></div>



                    </form>

                </div>

            </div>

        </div>
        <script src="<?php echo base_url('static/'); ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url('static/'); ?>assets/scripts/bootstrap.min.js"></script>
    </body>

</html>
