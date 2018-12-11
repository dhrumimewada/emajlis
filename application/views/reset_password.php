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
        <title>Emajlis</title>
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
                <div class="panel-heading">
                    <h4 class="text-center"> Sign In to <strong class="text-custom">Emajlis</strong></h4>
                </div>
                <div class="p-20">
                    <form class="form-horizontal m-t-20" method="post" id="reset_password">
                        <input type="hidden" name="remember_token" value="<?php echo $remember_token; ?>">
                        <div class="validation-error-label">
                            <?php echo form_error('remember_token'); ?>
                        </div>
                        <div class="form-group row">

                                <div class="col-md-12 m-b-10">
                                  <?php
$field_value = NULL;
$temp_value = set_value('password');
if (isset($temp_value) && !empty($temp_value)) {
$field_value = $temp_value;
} 
?>
                                    <input name="password" id="password" type="password" class="form-control" placeholder="Enter new password" autocomplete="off" value="<?php  echo $field_value; ?>">
                                    <div class="validation-error-label">
                                        <?php echo form_error('password'); ?>
                                    </div>
                                </div>


                                <div class="col-md-12 ">
                                <?php
$field_value = NULL;
$temp_value = set_value('c_password');
if (isset($temp_value) && !empty($temp_value)) {
$field_value = $temp_value;
} 
?>
                                    <input autocomplete="off" type="password"  name="c_password" class="form-control" placeholder="Enter confirm password" autocomplete="off" value="<?php  echo $field_value; ?>">
                                    <div class="validation-error-label">
                                        <?php echo form_error('c_password'); ?>
                                        
                                    </div>
                                </div>

                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light"
                                        type="submit">Reset Password
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
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        console.log("load");

        $( "#reset_password" ).validate({
           ignore: [],
           rules: {
              password: {
                required:true
              },
              c_password: {
                required:true,
                equalTo: "#password"
              }
          },
          messages: {
              password: {
                required: "The new password field is required."
              },
              c_password: {
                required: "The confirm password field is required.",
                equalTo: "Please enter the same password as above."
              }

          }
         });
    

    });
</script>