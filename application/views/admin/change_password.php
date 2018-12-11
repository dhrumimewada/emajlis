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
                    <h4 class="page-title">Change Password</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'/dashboard'; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>

                </div>
            </div>
            <!-- Page-Title -->
            <div class="row justify-content-md-center">
                <div class="col-9">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="p-20">
                                    <form id="admin_change_pw" class="form-horizontal" role="form" name="admin_profile" method="post">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="password">Current Password</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('password');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }
    ?>
                                                    <input id="password" name="password" type="password" class="form-control" placeholder="Enter current password" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('password'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="new_password">New Password</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('new_password');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }
    ?>
                                                    <input id="new_password" name="new_password" type="password" class="form-control" placeholder="Enter new password" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('new_password'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="c_password">Confirm New Password</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('c_password');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }
    ?>
                                                    <input id="c_password" name="c_password" type="password" class="form-control" placeholder="Enter confirm password" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('c_password'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'dashboard'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!-- end row -->

                    </div> <!-- end card-box -->
                </div><!-- end col -->
            </div>

        </div> <!-- container -->

    </div> <!-- content -->
