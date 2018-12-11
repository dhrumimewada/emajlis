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
                    <h4 class="page-title">Advertisement</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()."dashboard"; ?>">Emajlis</a></li>
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
                                    <form enctype="multipart/form-data" id="add_edit_advertise" class="form-horizontal" role="form" name="addadvertise" method="post">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="title">Title</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('title');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="title" name="title" type="text" class="form-control" placeholder="Ex: Upwork - Tell Users Why You Rock" autocomplete="off" value="<?php  echo $field_value;  ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('title'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="url">Advertise URL</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('url');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="url" name="url" type="text" class="form-control" placeholder="Ex: www.upwork.com/about" autocomplete="off" value="<?php  echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('url'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="form-group row">
                                            
                                            <div class="col-md-12">
                                                <label class="col-form-label " for="description">Description</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('description');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <textarea id="description" class="form-control" name="description" placeholder="Enter description"><?php echo $field_value; ?></textarea>
                                                </div>
                                            </div>

                                        </div>                                   

                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="control-label" for="filestyle-6">Image</label>
                                                <input accept="image/*" name="image" type="file" class="filestyle" data-iconname="fa fa-cloud-upload" id="filestyle-6" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">
                                                <div class="bootstrap-filestyle input-group">
                                                    <input type="text" class="form-control " placeholder="" disabled=""> 
                                                        <span class="group-span-filestyle input-group-btn" tabindex="0">
                                                            <label for="filestyle-6" class="btn btn-default ">
                                                                <span class="icon-span-filestyle fa fa-cloud-upload"></span>
                                                                <span class="buttonText">Choose file</span>
                                                            </label>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 30px;">
                                                <img id="preview-img" src="<?php echo base_url().'assets/images/advertisements/member-noimg.png'; ?>" alt="member image" style="height: auto; width: 50px;" />
                                            </div>
                                            <span id="img-error" class="error" style="padding-left: 10px;display: none;"><p>Image size is too large (upload image less than 4mb).</p></span>
                                        </div>
                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'advertisements'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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
