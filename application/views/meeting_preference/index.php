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
                    <h4 class="page-title">Meeting Preferences</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'/dashboard'; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Meeting Preferences</li>
                    </ol>

                </div>
            </div>
            <!-- Page-Title -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="card-box">
                        <div class="row">
 
                                <div class="m-b-30">
                                    <a href="<?php echo base_url()."meeting-preference/add"; ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light"><i class="md md-add-circle-outline"></i> Add</button></a>
                                </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped add-edit-table" id="meeting_preference_tbl">
                                <thead>
                                <tr>
                                    <th>ID</th>

                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: page -->

            </div>

            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
