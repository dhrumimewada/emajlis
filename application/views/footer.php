<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <footer class="footer text-right">
                            &copy; 2016 - 2018. Emajlis All rights reserved.
        </footer>
</div>
        <!-- END wrapper -->
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

<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>


<script src="<?php echo base_url(); ?>assets/js/jquery.core.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.app.js"></script>

<?php $this->load->view('datatable'); ?>

<!--Start script Add user form ---->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>

<!-- tags input -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"> </script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/multiselect/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/jquery.form-advanced.init.js"></script>

<?php if($this->session->flashdata('message') != ""): ?>
 <script>
  toastr.options.timeOut = 3000;
  toastr.success('<?php echo $this->session->flashdata('message');?>');
 </script>
<?php endif; ?>
    </body>
</html>