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
                    <h4 class="page-title">Admin</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'/dashboard'; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Edit Admin</li>
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
                                    <form  id="industry_add_edit" class="form-horizontal" role="form" name="edit_industry" method="post">
                                      <input type="hidden" name="id" value="<?php echo $admin->id; ?>">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="username">Full Name</label>
                                                <div class="col-md-12 user-add">
                                                                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('username');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = htmlspecialchars(ucfirst($admin->username));
    }
    ?>
                                                    <input id="username" name="username" type="text" class="form-control" placeholder="Enter full name" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('username'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="username">Email</label>
                                                <div class="col-md-12 user-add">
                                                    <input type="text" class="form-control" placeholder="Enter email" value="<?php echo $admin->email; ?>" disabled>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'admins'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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