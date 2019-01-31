<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css" media="screen">
.ion-close-round{
    color: #FFFFFC;
}
</style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Members</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()."dashboard"; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>

                </div>
            </div>
            <!-- Page-Title -->
            <div class="row justify-content-md-center">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="p-20">
                                    <form enctype="multipart/form-data" id="member_add_edit" class="form-horizontal" role="form" name="addmember" method="post">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="fullname">Full Name</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('fullname');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="fullname" name="fullname" type="text" class="form-control" placeholder="Enter full name" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('fullname'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="email">Email</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('email');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input autocomplete="off" type="email" id="email" name="email" class="form-control" placeholder="Enter email" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('email'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="password">Password</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('password');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="password" type="password" class="form-control" name="password" placeholder="Enter password" value="<?php echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('password'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="confirmpassword">Confirm Password</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('confirmpassword');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="confirmpassword" name="confirmpassword" type="password" class="form-control" placeholder="Enter confirm password" value="<?php echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('confirmpassword'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="address">Address</label>
                                                <div class="col-md-12 user-add">
                                                    <input onchange="initialize()" id="autocomplete" type="text" class="form-control" name="address" placeholder="Enter address" autocomplete="off">
                                                    <span style='color: red;' id="address_error"></span>
                                                    <input type="hidden" id="Latitude" name="lat" />
                                                    <input type="hidden" id="Longitude" name="lang" />
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('address'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Location Preference</label>
                                                <div class="col-md-12 user-add">
                                                    <select id="location_preference" name="meeting_preference[]" class="select2-limiting-4 select2-multiple" multiple="" data-placeholder="Select location preference" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select location preference">
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('meeting_preference[]');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
                                                         foreach($meeting_preference as $key => $value){  ?>
                                                          <option value="<?php echo $value['id']; ?>" <?php if(isset($field_value)){ echo (in_array($value['id'], $field_value))?'selected':''; } ?> >
                                                            <?php echo $value['preference_type']; ?>
                                                              
                                                            </option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Goal</label>
                                                <div class="col-md-12 user-add">
                                                    <select id="lookingfor" name="lookingfor[]" multiple data-placeholder="Select goal" tabindex="-1" aria-hidden="true" data-role="tagsinput">
                                                      <optgroup label="Select goal">
                                                         <?php 
    // $field_value = NULL;
    // $temp_value = set_value('lookingfor[]');
    // if (isset($temp_value) && !empty($temp_value)) {
    //     $field_value = $temp_value;
    // } 
                                                         //foreach($looking_for as $key => $value){  ?>
                                                          <!-- <option value="<?php echo $value['name']; ?>" <?php if(isset($field_value)){ echo (in_array($value['id'], $field_value))?'selected':''; } ?> ><?php echo $value['name']; ?></option> -->
                                                         <?php //}?> 
                                                      </optgroup>
                                                    </select>
     
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Hashtags</label>
                                                <div class="col-md-12 user-add">
                                                    <select id="interests" name="interests[]" class="select2 select2-multiple" multiple="" data-placeholder="Select hashtag" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select hashtag">
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('interests[]');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
                                                         foreach($hashtag as $key => $value){ ?>
                                                          <option value="<?php echo $value['id']; ?>" <?php if(isset($field_value)){ echo (in_array($value['id'], $field_value))?'selected':''; } ?> ><?php echo $value['tag_name']; ?></option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label" for="goal_description">Goal Description</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('goal_description');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <textarea id="goal_description" class="form-control" name="goal_description" placeholder="Enter goal description" ><?php  echo $field_value; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Industry</label>
                                                <div class="col-md-12 user-add">
                                                    <select id="industry" name="industry[]" class="select2" data-placeholder="Select industry" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select industry">
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('industry[]');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
                                                         foreach($industry as $key => $value){ ?>
                                                          <option value="<?php echo $value['id']; ?>" <?php if(isset($field_value)){ echo (in_array($value['id'], $field_value))?'selected':''; } ?> ><?php echo $value['name']; ?></option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
     
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Gender</label>
                                                <div class="col-md-12 user-add custom-radio">
                                                  <label class="radio-inline">
                                                    <?php
    $field_value = 0;
    $temp_value = set_value('gender');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input type="radio" name="gender" value="0" <?php echo ($field_value == '0')?'checked':''; ?> >Male
                                                  </label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="gender" value="1" <?php echo ($field_value == '1')?'checked':''; ?> >Female
                                                  </label>

                                                </div>
                                                <div class="validation-error-label">
                                                    <?php echo form_error('gender'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="occupation">Occupation</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('occupation');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="occupation" name="occupation" type="text" class="form-control" placeholder="Enter occupation" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('occupation'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="current_organization">Organization</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('current_organization');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input autocomplete="off" type="text" id="current_organization" name="current_organization" class="form-control" placeholder="Enter organization" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('current_organization'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- dddd -->

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="linkedin_link">Linkedin Link</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('linkedin_link');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="linkedin_link" name="linkedin_link" type="text" class="form-control" placeholder="Enter linkedin link" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('linkedin_link'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="twitter_link">Twitter Link</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('twitter_link');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input autocomplete="off" type="text" id="twitter_link" name="twitter_link" class="form-control" placeholder="Enter twitter link" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('twitter_link'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="instagram_link">Instagram Link</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('instagram_link');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="instagram_link" name="instagram_link" type="text" class="form-control" placeholder="Enter instagram link" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('instagram_link'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="website_link">Website Link</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('website_link');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input autocomplete="off" type="text" id="website_link" name="website_link" class="form-control" placeholder="Enter website link" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('website_link'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 mt-2 mb-1">
                                                <label class="col-form-label pb-0">Educations</label>
                                                <hr class="mt-1 mb-3">
                                            </div>
                                        </div>
                                        <div id="educations">
                                            <!-- Dynmaic  -->
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <button type="button" name="add_variant" class="btn btn-primary waves-effect waves-light" id="add_education">
                                                    Add Education
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 mt-2 mb-1">
                                                <label class="col-form-label pb-0">Previous Organization</label>
                                                <hr class="mt-1 mb-3">
                                            </div>
                                        </div>
                                        <div id="organizations">
                                            <!-- Dynmaic  -->
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <button type="button" name="add_variant" class="btn btn-primary waves-effect waves-light" id="add_organization">
                                                    Add Previous Organization
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="control-label">Image</label>
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
                                                <img id="preview-img" src="<?php echo base_url().$this->config->item("profile_path").'member-noimg.png'; ?>" alt="member image" style="height: auto; width: 50px;" />
                                            </div>
                                            <span id="img-error" class="error" style="padding-left: 10px;display: none;"><p>Image size is too large (upload image less than 4mb).</p></span>
                                        </div>
                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'members'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyC_bE8OB_Zd-ik5uPQ9ZVgeBLM3cSTei5Y" type="text/javascript"></script>
<script>

function validate_address() {
      var lat = document.getElementById('Latitude').value;
      var long = document.getElementById('Longitude').value;

      if(lat == '' || long == '')
      {
        
        document.getElementById('autocomplete').value = '';
        document.getElementById('address_error').innerHTML = 'Please select proper address.';
        return false;
      }
      else
      {
        return true;
      }

} 

function initialize() {
        document.getElementById('Latitude').value = "";
        document.getElementById('Longitude').value = "";
        var input = document.getElementById('autocomplete');
        
        var autocomplete = new google.maps.places.Autocomplete(input);
        
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
           if(place != "")
           {
              document.getElementById('Latitude').value = place.geometry.location.lat();
              document.getElementById('Longitude').value = place.geometry.location.lng();
              document.getElementById('address_error').innerHTML = '';
           }
           else
           {
              document.getElementById('Latitude').value = '';
              document.getElementById('Longitude').value = '';
              document.getElementById('autocomplete').value = '';
              document.getElementById('address_error').innerHTML = 'Please select proper address.';
           }
           

        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>