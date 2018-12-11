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
                                    <form id="addlookingfor" class="form-horizontal" role="form" name="editlookingfor" method="post">
                                      <input type="hidden" name="id" value="<?php echo $industry_looking->id; ?>">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label required" for="name">Goal Name</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('name');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = htmlspecialchars(ucfirst($industry_looking->name));
    }
    ?>
                                                    <input id="name" name="name" type="text" class="form-control" placeholder="Enter goal name" autocomplete="off" value="<?php echo $field_value; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="col-form-label" for="description">Description</label>
                                                <div class="col-md-12 user-add">
                                                  <?php
    $field_value = NULL;
    $temp_value = set_value('description');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $industry_looking->description;
    }
    ?>
                                                    <textarea id="description" class="form-control" name="description" placeholder="Enter description" ><?php echo $field_value; ?></textarea>
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