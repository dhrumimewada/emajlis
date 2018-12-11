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
                    <h4 class="page-title">Vendor Partners</h4>
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
                                    <form id="add_edit_vendorpartners" class="form-horizontal" role="form" name="addvendorpartners" method="post">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="name">Name</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('name');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="name" name="name" type="text" class="form-control" placeholder="Enter name" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('name'); ?>
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
                                                    <input autocomplete="off" type="email" name="email" class="form-control" placeholder="Enter email" autocomplete="off" value="<?php echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('email'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required" for="mobile">Contact number</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('mobile');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
    ?>
                                                    <input id="mobile" name="mobile" type="text" class="form-control" placeholder="Enter contact number" autocomplete="off" value="<?php  echo set_value('mobile'); ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('mobile'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Category</label>
                                                <div class="col-md-12 user-add">
                                                    <select name="category" class="select2" data-placeholder="Select category" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select Category">
                                                          <option selected disabled></option>
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('category');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } 
                                                         foreach($vendor_category as $key => $value){  ?>
                                                          <option value="<?php echo $value['id']; ?>" <?php if($field_value == $value['id']){ echo 'selected'; } ?> >
                                                            <?php echo $value['name']; ?>
                                                          </option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('category'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                   

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="autocomplete">Address</label>
                                                <div class="col-md-12 user-add">
                                                    <input onchange="initialize()" id="autocomplete" type="text" class="form-control" name="address" placeholder="Enter address" autocomplete="off">
                                                    <span style='color: red;' id="address_error"></span>
                                                    <input type="hidden" id="Latitude" name="lat" />
                                                    <input type="hidden" id="Longitude" name="lang" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'vendor-partners'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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
        document.getElementById('Latitude').value = "";
        document.getElementById('Longitude').value = "";
        var input = document.getElementById('autocomplete');
        
        var autocomplete = new google.maps.places.Autocomplete(input);
        
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
           //console.log(place); 
           if(place != "")
           {
              // for (var i = 0; i < place.address_components.length; i++) 
              // {
              //   for (var j = 0; j < place.address_components[i].types.length; j++) 
              //   {
              //     if (place.address_components[i].types[j] == "postal_code") 
              //     {
              //       document.getElementById('ZipCode').value = place.address_components[i].long_name;
              //     }
              //     if (place.address_components[i].types[j] == "administrative_area_level_1") 
              //     {
              //       document.getElementById('State').value = place.address_components[i].short_name;
              //     }
              //     if (place.address_components[i].types[j] == "sublocality_level_1") 
              //     {
              //       document.getElementById('City').value = place.address_components[i].short_name;
              //     }
              //   }
              // }
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