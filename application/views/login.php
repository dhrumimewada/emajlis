<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Emajlis Theme">
        <meta name="author" content="ewwthemes">

        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <title>Emajlis - Admin Panel</title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>    
    </head>
    <body>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class="card-box">

            	<?php if($this->session->flashdata('message') != "") { ?>
            	<div class="alert alert-danger" style="text-align: center;">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>		            
		        <?php } ?>
                <div class="panel-heading text-center">
                    <!-- <h4 class="text-center"> Sign In to <strong class="text-custom">Emajlis</strong></h4> -->
                    <img src="<?php echo base_url().'assets/images/logo/logo.png'; ?>" alt="Logo" title="Logo" width="60%" height="60" data-max-width="100">
                </div>
                <div class="p-20">
                    <form class="form-horizontal m-t-20" method="post">
                        <div class="form-group ">
                            <div class="col-12">
                                <input class="form-control" type="text"  placeholder="Username" name="email" autocomplete="off">
                                <div class="validation-error-label">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="password"  placeholder="Password" name="password" autocomplete="off">
                                <div class="validation-error-label">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-block text-uppercase waves-effect waves-light login-btn" type="submit">login
                                </button>
                            </div>
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>
        <script>
            var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.app.js"></script>
	</body>
</html>