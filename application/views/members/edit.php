<style type="text/css" media="screen">
.ion-close-round{
    color: #FFFFFC;
}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$meeting_preferences = array();
foreach ($member_meeting_preference as $key => $value) {
  $meeting_preferences[] = $value['meeting_preference_id'];
}
$goals = array();
foreach ($member_goal as $key => $value) {
  $goals[] = $value['lookingfor_id'];
}
$hashtags = array();
foreach ($member_hashtag as $key => $value) {
  $hashtags[] = $value['hashtag_id'];
}
$industries = array();
foreach ($member_industry as $key => $value) {
  $industries[] = $value['industry_id'];
}
// echo "<pre>";
// print_r($member_education);
// exit;
?>
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
                        <li class="breadcrumb-item active">Edit</li>
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
                                      <input type="hidden" name="id" value="<?php echo $member->id; ?>">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Full Name <?php //echo "<pre>"; print_r($member_industry); ?></label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('fullname');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $member->fullname;
    }
    ?>
                                                    <input id="fullname" name="fullname" type="text" class="form-control" placeholder="Enter full name" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('fullname'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Address</label>
                                                <div class="col-md-12 user-add">
                                                    <input onchange="initialize()" id="autocomplete" type="text" class="form-control" name="address" placeholder="Enter address" autocomplete="off" value="<?php echo $member->address; ?>">
                                                    <span style='color: red;' id="address_error"></span>
                                                    <input type="hidden" id="Latitude" name="lat" value="<?php echo $member->lat; ?>" />
                                                    <input type="hidden" id="Longitude" name="lang" value="<?php echo $member->lang; ?>" />
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('address'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Location Preference</label>
                                                <div class="col-md-12 user-add">
                                                    <select id="meeting_preference" name="meeting_preference[]" class="select2 select2-multiple" multiple="" data-placeholder="Select location preference" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select location preference">
                                                         <?php 
    $field_value = NULL;
    $select = '';
    $temp_value = set_value('meeting_preference[]');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $meeting_preferences;
    }
                                                         foreach($meeting_preference as $key => $value){
                                                          if(isset($field_value)){

                                                            if(in_array($value['id'], $field_value)){
                                                              $select = 'selected';
                                                              }else{
                                                                $select = '';
                                                              } 
                                                          }?>
                                                          <option value="<?php echo $value['id']; ?>" <?php echo $select; ?>><?php echo $value['preference_type']; ?></option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Goal</label>
                                                <div class="col-md-12 user-add">
                                                    <select id="lookingfor" name="lookingfor[]" class="select2 select2-multiple" multiple="" data-placeholder="Select goal" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select goal">
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('lookingfor[]');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $goals;
    }
                                                         foreach($looking_for as $key => $value){
                                                          if(isset($field_value)){
                                                            if(in_array($value['id'], $field_value)){
                                                              $select = 'selected';
                                                              }else{
                                                                $select = '';
                                                              } 
                                                            }?>
                                                          <option value="<?php echo $value['id']; ?>" <?php echo $select; ?>><?php echo $value['name']; ?></option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row"> 
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
    }else{
        $field_value = $hashtags;
    }
                                                         foreach($hashtag as $key => $value){
                                                          if(isset($field_value)){
                                                            if(in_array($value['id'], $field_value)){
                                                              $select = 'selected';
                                                              }else{
                                                                $select = '';
                                                              }
                                                            }?>
                                                          <option value="<?php echo $value['id']; ?>" <?php echo $select; ?>><?php echo $value['tag_name']; ?></option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Gender</label>
                                                <div class="col-md-12 user-add custom-radio">
                                                  <label class="radio-inline">
                                                    <input type="radio" name="gender" value="0" <?php echo ($member->gender == '0')?'checked':''; ?>>Male
                                                  </label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="gender" value="1" <?php echo ($member->gender == '1')?'checked':''; ?>>Female
                                                  </label>
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
    }else{
        $field_value =  $member->goal_description;
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
                                                    <select id="industry" name="industry[]" class="select2 select2-multiple" multiple="" data-placeholder="Select industry" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select industry">
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('industry[]');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $industries;
    }
                                                         foreach($industry as $key => $value){
                                                          if(isset($field_value)){
                                                            if(in_array($value['id'], $industries)){
                                                              $select = 'selected';
                                                              }else{
                                                                $select = '';
                                                              } 
                                                            }?>
                                                          <option value="<?php echo $value['id']; ?>" <?php echo $select; ?>><?php echo $value['name']; ?></option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
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
    }else{
        $field_value =  $member->jobtitle;
    }
    ?>
                                                    <input id="occupation" name="occupation" type="text" class="form-control" placeholder="Enter occupation" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('occupation'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="organization">Organization</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('organization');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } else{
        $field_value =  $member->current_organization;
    }
    ?>
                                                    <input autocomplete="off" type="text" id="organization" name="organization" class="form-control" placeholder="Enter organization" autocomplete="off" value="<?php  echo $field_value ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('organization'); ?>
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
    }else{
        $field_value =  $member_info->linkedin_link;
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
    }else{
        $field_value =  $member_info->twitter_link;
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
    }else{
        $field_value =  $member_info->instagram_link;
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
    }else{
        $field_value =  $member_info->website_link;
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
                                            <?php
                                            if(!empty($member_education)){
                                              foreach ($member_education as $key => $value) { ?>

                                              <div class="form-group row">
                                                  <div class="col-md-5">
                                                      <input  name="degree[]" type="text" class="form-control" placeholder="Enter degree" autocomplete="off" value="<?php echo $value['degree']; ?>">
                                                  </div>
                                                  <div class="col-md-5">
                                                      <input  name="school[]" type="text" class="form-control" placeholder="Enter school" autocomplete="off" value="<?php echo $value['school']; ?>">
                                                  </div>
                                                  <div class="col-md-2">
                                                   <label class="btn btn-danger waves-effect waves-light remove-btn remove"><i class="ion-close-round"></i></label>
                                                  </div>
                                              </div>

                                              <?php 
                                              }
                                            }?>
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
                                            <?php
                                            if(!empty($member_previous_organization)){
                                              foreach ($member_previous_organization as $key => $value) { ?>

                                              <div class="form-group row">
                                                  <div class="col-md-5">
                                                      <input  name="organization[]" type="text" class="form-control" placeholder="Enter organization" autocomplete="off" value="<?php echo $value['organization_name']; ?>">
                                                  </div>
                                                  <div class="col-md-5">
                                                      <input  name="position[]" type="text" class="form-control" placeholder="Enter occupation" autocomplete="off" value="<?php echo $value['designation']; ?>">
                                                  </div>
                                                  <div class="col-md-2">
                                                   <label class="btn btn-danger waves-effect waves-light remove-btn remove"><i class="ion-close-round"></i></label>
                                                  </div>
                                              </div>

                                              <?php 
                                              }
                                            }?>
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
                                              <?php if(!empty($member->image)){
                                                $img_src = base_url(). $this->config->item("profile_path").$member->image;
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
function validate_address() 
{
      var lat = document.getElementById('Latitude').value;
      var long = document.getElementById('Longitude').value;

      if(lat == '' || long == '')
      {
        
        document.getElementById('autocomplete').value = '';
        document.getElementById('address_error').innerHTML = 'Please select proper address';
        return false;
      }
      else
      {
        return true;
      }

} 

function initialize() {
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
              document.getElementById('address_error').innerHTML = 'Please select proper address';
           }         
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>