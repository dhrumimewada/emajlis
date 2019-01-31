<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">

                                <h4 class="page-title">Dashboard</h4>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url()."dashboard"; ?>">Emajlis</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-account-child text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">
                                            <?php $date = date('Y-m-d H:i:s');
                                            $member_query = $this->db->query('SELECT * FROM member WHERE deleted_at IS NULL');
                                            $total_members = $member_query->num_rows();  echo $total_members; ?>
                                        </b></h3>
                                        <p class="text-muted mb-0">Total Members</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-pink pull-left">
                                        <i class="md md-add-shopping-cart text-pink"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">
                                            <?php $vendor_partner_query = $this->db->query('SELECT * FROM vendor_partners');
                                            $total_vendor_partners = $vendor_partner_query->num_rows();  echo $total_vendor_partners; ?>
                                        </b></h3>
                                        <p class="text-muted mb-0">Total Vender Partners</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-wallet-giftcard text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">
                                            <?php $voucher_query = $this->db->query('SELECT * FROM vendor_partner_vouchers');
                                            $total_vouchers = $voucher_query->num_rows();  echo $total_vouchers; ?>
                                        </b></h3>
                                        <p class="text-muted mb-0">Total Vouchers</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="md md-remove-red-eye text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">
                                            <?php $advertise_query = $this->db->query('SELECT * FROM advertise');
                                            $total_advertise = $advertise_query->num_rows();  echo $total_advertise; ?>
                                                
                                            </b></h3>
                                        <p class="text-muted mb-0">Total Advertisements</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>


                        </div>

                        <!-- end row -->

                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="portlet"><!-- /primary heading -->
                                    <div class="portlet-heading">
                                        <h3 class="portlet-title text-dark text-uppercase">
                                            Recent hashtags
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="<?php echo base_url().'hashtags/add'; ?>" class="btn btn-default waves-effect waves-light"><i class="md md-add-circle-outline"></i> Hashtag</a>
                                            <span class="divider"></span>
                                        </div>
                                    </div>
                                    <div id="portlet2" class="panel-collapse collapse show">
                                        <div class="portlet-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="recenthashtags">
                                                    <thead>
                                                    <tr>
                                                        <th>Hashtag</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="portlet"><!-- /primary heading -->
                                    <div class="portlet-heading">
                                        <h3 class="portlet-title text-dark text-uppercase">
                                            Recent Members
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="<?php echo base_url().'members/add'; ?>" class="btn btn-default waves-effect waves-light"><i class="md md-add-circle-outline"></i> Member</a>
                                            <span class="divider"></span>
                                        </div>
                                    </div>
                                    <div  class="panel-collapse collapse show">
                                        <div class="portlet-body">
                                            <div class="table-responsive table-striped">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    foreach ($recent_member_list as $key => $value) {
                                                        echo "<tr>";
                                                        echo "<td class='nowrap'>".$value['fullname']."</td>";
                                                        echo "<td class='nowrap'>".$value['email']."</td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

<script src="<?php echo base_url(); ?>assets/plugins/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/counterup/jquery.counterup.min.js"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    $('.counter').counterUp({
        delay: 100,
        time: 1500
    });
});
</script>