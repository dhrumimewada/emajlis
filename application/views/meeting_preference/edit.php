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
                    <h4 class="page-title">Meeting Preference</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'/dashboard'; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                                    <form  id="preference_add_edit"  enctype="multipart/form-data"  class="form-horizontal" role="form" name="edit_industry" method="post">
                                      <input type="hidden" name="id" value="<?php echo $meeting_preference->id; ?>">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="preference_type">Meeting Preference Name</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('preference_type');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = htmlspecialchars(ucfirst($meeting_preference->preference_type));
    }
    ?>
                                                    <input id="preference_type" name="preference_type" type="text" class="form-control" placeholder="Ex: After Work" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('preference_type'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-form-label required">Meeting Preference Icon Image</label>
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
                                                <small style="display: block;">Icon image size should be 48*48 (accept: png, jpg, jpeg)</small>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 30px;">
                                              <?php if(!empty($meeting_preference->image_name)){
                                                $img_src = base_url(). $this->config->item("meeting_pref_path").$meeting_preference->image_name;
                                              }
                                              else{
                                                $img_src = base_url().'assets/images/users/member-noimg.png';
                                              } ?>
                                                <img id="preview-img" src="<?php echo $img_src; ?>" alt="member image" style="height: auto; width: 50px;" />
                                            </div>
                                            <span id="img-error" class="error" style="padding-left: 10px;display: none;"><p>Image size is too large (upload image less than 4mb).</p></span>
                                        </div>

                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'meeting_preference'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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