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
                    <h4 class="page-title">Profile</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'/dashboard'; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">profile</li>
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
                                    <form id="admin_profile" class="form-horizontal" role="form" name="admin_profile" method="post">
                                        <input type="hidden" name="id" value="<?php echo $profile->id; ?>">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label">Email</label>
                                                <div class="col-md-12 user-add">
                                                    <input id="email" name="email" type="text" class="form-control" placeholder="Enter email" disabled value="<?php  echo $profile->email; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required">Full Name</label>
                                                <div class="col-md-12 user-add">
                                                                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('username');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = htmlspecialchars(ucfirst($profile->username));
    }
    ?>
                                                    <input id="username" name="username" type="text" class="form-control" placeholder="Enter full name" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('username'); ?>
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
