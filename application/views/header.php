<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Emajlis Theme">
        <meta name="author" content="ewwthemes">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
        <title>Emajlis - Admin Panel</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" /> 

        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <!-- tags input -->
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />

    </head>
    <body>
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <!-- Image Logo here -->
                        <a href="<?php echo base_url()."dashboard"; ?>" class="logo">
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="Emajlis" style="width:65px; height: auto;" />
                        </a>
                    
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">
                        <li class="list-inline-item notification-list">
                            <a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
                                <i class="dripicons-expand noti-icon"></i>
                            </a>
                        </li>



                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="<?php echo base_url().'assets/images/admin_img.jpg'; ?>" alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">

                               <!-- item-->
                                <!-- <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Welcome ! Admin</small> </h5>
                                </div> -->

                                <!-- item-->
                                <a href="<?php echo base_url()."myprofile"; ?>" class="dropdown-item notify-item">
                                    <i class="md md-account-circle"></i> <span>My Profile</span>
                                </a>

                                <!-- item-->
                                <a href="<?php echo base_url()."change-password"; ?>" class="dropdown-item notify-item">
                                    <i class=" md md-vpn-key"></i> <span>Change Password</span>
                                </a>

                                <!-- item-->
                                <a href="<?php echo base_url()."settings/appsetting"; ?>" class="dropdown-item notify-item">
                                    <i class="md md-settings"></i> <span>Settings</span>
                                </a>


                                <!-- item-->
                                <a href="<?php echo base_url()."login/logout"; ?>" class="dropdown-item notify-item">
                                    <i class="md md-settings-power"></i> <span>Logout</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="dripicons-menu"></i>
                            </button>
                        </li>
                    </ul>

                </nav>
            </div>
            <!-- Top Bar End -->