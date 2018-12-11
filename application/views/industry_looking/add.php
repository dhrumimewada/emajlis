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
                    <h4 class="page-title">Goal</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'/dashboard'; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Add</li>
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
                                    <form id="addlookingfor" class="form-horizontal" role="form" name="lookingfor" method="post">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required">Goal Name</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
                                                       $field_value = NULL;
    $temp_value = set_value('name');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } ?>
                                                    <input id="name" name="name" type="text" class="form-control" placeholder="Enter goal name" autocomplete="off" value="<?php  echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('name'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="col-form-label">Description</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
                                                       $field_value = NULL;
    $temp_value = set_value('description');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } ?>
                                                    <textarea id="description" class="form-control" name="description" placeholder="Enter description" ><?php  echo $field_value; ?></textarea>
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('description'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'industry-looking-for'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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
