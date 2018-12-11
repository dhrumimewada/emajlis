
var protocol = window.location.protocol;
var host = window.location.host;
var base_url = protocol+'//'+host+'/emajlis/';
//var base_url = protocol+'//'+host+'/';

function validate_prev_organization(){
    console.log("validate_prev_organization");
    var flag = true;
    $('[name*="organization[]"]').each(function (){
        if($(this).val().trim() == ''){
            $(this).after('<label class="validation-error-label">The organization field is required.</label>');
            flag = false;
        }
    });
    $('[name*="position[]"]').each(function (){
        if($(this).val().trim() == ''){
            $(this).after('<label class="validation-error-label">The occupation field is required.</label>');
            flag = false;
        }
    });
    return flag;
}

function validate_education(){
    console.log("validate_education");
    var flag = true;
    $('[name*="degree[]"]').each(function (){
        if($(this).val().trim() == ''){
            $(this).after('<label class="validation-error-label">The degree field is required.</label>');
            flag = false;
        }
    });
    $('[name*="school[]"]').each(function (){
        if($(this).val().trim() == ''){
            $(this).after('<label class="validation-error-label">The school field is required.</label>');
            flag = false;
        }
    });
    return flag;
}

$(document).ready(function() {
    var user_url = base_url+ 'ajax/users_list/';
    $('#users_table').DataTable( {
        "ajax": {
            url : user_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    } );



    var hashtag_url = base_url+ 'ajax/hashtags_list/';
    var table = $('#hashtags_tbl').DataTable( {
        "ajax": {
            url : hashtag_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });


    var looking_for_url = base_url+ 'ajax/industry_list/';
    $('#looking_for_tbl').DataTable( {
        "ajax": {
            url : looking_for_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    var meeting_preference_url = base_url+ 'ajax/meeting_preference_list/';
    $('#meeting_preference_tbl').DataTable( {
        "ajax": {
            url : meeting_preference_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });


    var industry_url = base_url+ 'ajax/industry/';
    $('#industry_tbl').DataTable( {
        "ajax": {
            url : industry_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    var vendor_partner_url = base_url+ 'ajax/vendor_partner_list/';
    $('#vendorpartners').DataTable( {
        "ajax": {
            url : vendor_partner_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    var voucher_url = base_url+ 'ajax/voucher_list/';
    $('#vouchers').DataTable( {
        "ajax": {
            url : voucher_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    var advertise_url = base_url+ 'ajax/advertisement_list/';
    $('#advertisements').DataTable( {
        "ajax": {
            url : advertise_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    var dashboard_hashtag_url = base_url+ 'ajax/recent_hashtags/';
    $('#recenthashtags').DataTable( {
        "ajax": {
            url : dashboard_hashtag_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
              searching: false, paging: false, info: false
    });

    var admin_url = base_url+ 'ajax/admins_list/';
    $('#admin_tbl').DataTable( {
        "ajax": {
            url : admin_url,
            type : 'GET'
        },
        createdRow: function(row, data, dataIndex ) {
                   $(row).attr("id", "row_id_"+data[0]);
              },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    $(document).on('click','.remove-btn',function(){
        $(this).closest(".row").remove();
    });

    $(document).on('click','#add_organization',function(){
      console.log("add_education");
      var variant_row = 
                '<div class="form-group row">'+
                    '<div class="col-md-5">'+
                        '<input  name="organization[]" type="text" class="form-control" placeholder="Enter organization" autocomplete="off" value="">'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<input  name="position[]" type="text" class="form-control" placeholder="Enter occupation" autocomplete="off" value="">'+
                    '</div>'+
                    '<div class="col-md-2">'+
                     '<label class="btn btn-danger waves-effect waves-light remove-btn remove"><i class="ion-close-round"></i></label>'+
                    '</div>'+
                '</div>';
      $('#organizations').append(variant_row);
  });

  $(document).on('click','#add_education',function(){
      console.log("add_education");
      var variant_row = 
                '<div class="form-group row">'+
                    '<div class="col-md-5">'+
                        '<input  name="degree[]" type="text" class="form-control" placeholder="Enter degree" autocomplete="off" value="">'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<input  name="school[]" type="text" class="form-control" placeholder="Enter school" autocomplete="off" value="">'+
                    '</div>'+
                    '<div class="col-md-2">'+
                     '<label class="btn btn-danger waves-effect waves-light remove-btn remove"><i class="ion-close-round"></i></label>'+
                    '</div>'+
                '</div>';
      $('#educations').append(variant_row);
  });



});


var imagesPreview = function(input, placeToInsertImagePreview) {
    if (input.files) {
      var FileSize = input.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 4) 
        {
            $('span#img-error').css("display","block");
        } 
        else 
        {
          $('span#img-error').css("display","none");
          var filesAmount = input.files.length;
          var preview;
          $('#preview-img').html('');
          for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();
              reader.onload = function(event) {
              $('#preview-img').attr("src",event.target.result);       
              }
              reader.readAsDataURL(input.files[i]);
          }
        }
    }
};
$('.filestyle').on('change', function(e) {
    imagesPreview(this, '#preview-img');
});
$.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[\'a-zA-Z][\sa-zA-Z\'\-]*/);
});

 var validator = $( "#member_add_edit" ).validate({
    ignore: [],
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    errorPlacement: function(error, element) {
                error.insertAfter(element);
              },
   rules: {
      fullname: {
        required:true,
        alpha:true,
        minlength:3,
        maxlength:30,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      email: {
        required:true,
        email: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      password:{
        required:true,
        minlength: 6  
      },
      confirmpassword: {
          required:true,
          equalTo: "#password"
      },
      lat: 'required',
      linkedin_link:{
        valid_url: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      twitter_link:{
        valid_url: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      instagram_link:{
        valid_url: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      website_link:{
        valid_url: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      }

  },
  messages: {
            fullname: {
              required: "The full name field is required.",
              alpha: "The full name field is not in the correct format.",
              minlength: jQuery.validator.format("At least {0} characters required."),
              maxlength: jQuery.validator.format("Maximum {0} characters allowed.")    
            },
            email:{
              required: "The email field is required.",
              email: "Please enter valid email."       
            },
            password: {
              required: "The password field is required.",
              minlength: jQuery.validator.format("At least {0} characters required.")
            },
            confirmpassword: {
              required: "The confirm password field is required.",
              equalTo: "The confirm password field does not match the password field."
            },
            lat: "Please select address from google suggestion.",
            linkedin_link:{
              valid_url:"The linkedin url field is invalid."
            },
            twitter_link:{
              valid_url:"The twitter url field is invalid."
            },
            instagram_link:{
              valid_url:"The instagram url field is invalid."
            },
            website_link:{
              valid_url:"The website url field is invalid."
            }
        },
        submitHandler: function(form) {
           //form.submit();
          var education = validate_education();
          organization = validate_prev_organization();
          if(organization == true && education == true){
              console.log(organization);
              console.log(education);
                form.submit();
          }else{
                console.log('form false');
          }   
        }
 });

 var validator = $( "#hashtag_add_edit" ).validate({
   ignore: [],
   rules: {
      tag_name: {
        required:true,
        minlength:2,
        maxlength:30,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      newsfeed_url: 
      {
        required: true,
        valid_url: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      }
  },
  messages: {
            tag_name: {
              required: "The hashtag name field is required.",
              minlength: jQuery.validator.format("At least {0} characters required."),
              maxlength: jQuery.validator.format("Maximum {0} characters allowed.")
            },
            newsfeed_url:{
              required: "The newsfeed url field is required.",
              valid_url: "The newsfeed url field is invalid."
            }  
        }
 });

$.validator.addMethod("valid_url", function(value, element) {
        return this.optional(element) || /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/.test(value);
    });


$( "#addlookingfor" ).validate({
   ignore: [],
   rules: {
      name: {
        required:true,
        minlength:2,
        maxlength:30,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      description:{
         normalizer: function (value) {
                    return $.trim(value);
                }
      }
  },
  messages: {
            name: {
              required: "The goal name field is required.",
              minlength: jQuery.validator.format("At least {0} characters required."),
              maxlength: jQuery.validator.format("Maximum {0} characters allowed.")
            }

        }
 });


var validator =$( "#add_edit_vendorpartners" ).validate({
   ignore: [],
   errorPlacement: function(error, element) {
      if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible') || element.hasClass('filestyle')) {
                error.appendTo(element.parent());
            }else{
              error.insertAfter(element);
            }
                
              },
   rules: {
      name: {
        required:true,
        alpha:true,
        minlength:3,
        maxlength:30,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      email:{
        required:true,
        email: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      mobile:{
        required: true,
        digits: true,
        minlength: 10,
        maxlength: 15,
        normalizer: function (value) {
            return $.trim(value);
        }
      },
      lat: 'required',
      category:{
        required:true
      }

  },
  messages: {
            name: {
              required: "The name field is required.",
              alpha: "The name field is not in the correct format.",
              minlength: jQuery.validator.format("At least {0} characters required."),
              maxlength: jQuery.validator.format("Maximum {0} characters allowed.")
            },
            email:{
              required: "The email field is required.",
              email: "The email field is invalid."       
            },
            lat: "Please select address from google suggestion",
            mobile:{
              required: "The contact number field is required.",
              digits: "Enter only numeric value",
              greaterThanZero: "The contact number field is invalid.",
              minlength: jQuery.validator.format("At least {0} digit required"),
              maxlength: jQuery.validator.format("Maximum {0} digit allowed.")
            },
            category:{
              required: "The category field is required."
            }  
        }
 });

$( "#add_edit_vouchers" ).validate({
   ignore: [],
   errorPlacement: function(error, element) {
      if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible') || element.hasClass('filestyle')) {
                error.appendTo(element.parent());
            }else{
              error.insertAfter(element);
            }
                
              },
   rules: {
      vender:{
        required:true
      },
      voucher_code: {
        required:true,
        minlength:3,
        maxlength:50,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      voucher_type:{
        required:true
      },
      voucher_amount:{
        required:true,
        number:true,
        min: 1
      }

  },
  messages: {
        vender:{
          required: "The vender partner field is required."
        },
        voucher_code: {
          required: "The voucher code field is required.",
          minlength: jQuery.validator.format("At least {0} characters required."),
          maxlength: jQuery.validator.format("Maximum {0} characters allowed.")
        },
        voucher_type:{
          required: "The vender type field is required."
        },
        voucher_amount:{
          required: "The voucher rate field is required.",
          number:"The voucher rate field is invalid.",
          min: jQuery.validator.format("The voucher rate should be more than 0.")
        }
    }
 });

$( "#add_edit_advertise" ).validate({
   ignore: [],
   rules: {
      title: {
        required:true,
        minlength:3,
        maxlength:50,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      url: {
        required:true,
        url:true,
        normalizer: function (value) {
            return $.trim(value);
        }
      },
      description:{
        normalizer: function (value) {
            return $.trim(value);
        }
      }
  },
  messages: {
      title: {
        required: "The advertis title field is required.",
        minlength: jQuery.validator.format("At least {0} characters required."),
        maxlength: jQuery.validator.format("Maximum {0} characters allowed.")
      },
      url: {
        required:"The url field is required.",
        url:"The url field is invalid."
      } 
  }
 });

$( "#industry_add_edit" ).validate({
   ignore: [],
   rules: {
      name:{
        required: true,
        minlength:3,
        maxlength:50,
        normalizer: function (value) {
                    return $.trim(value);
                }
      }
  },
  messages: {
        name: {
          required: "The industry name field is required.",
          minlength: jQuery.validator.format("At least {0} characters required."),
          maxlength: jQuery.validator.format("Maximum {0} characters allowed.")    
        }
    }
 });

$( "#preference_add_edit" ).validate({
  ignore: [],
  errorPlacement: function(error, element) {
      if (element.hasClass('filestyle')) {
                error.appendTo(element.parent());
            }else{
              error.insertAfter(element);
            }
                
              },
   rules: {
      preference_type:{
        required: true,
        minlength:3,
        maxlength:50,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      image:{
        required: true
      }
  },
  messages: {
        preference_type: {
          required: "The meeting preference name field is required.",
          minlength: jQuery.validator.format("At least {0} characters required."),
          maxlength: jQuery.validator.format("Maximum {0} characters allowed.")    
        },
        image: {
          required: "The meeting preference icon image field is required."
        }
    }
 });


$( "#admin_profile" ).validate({
   ignore: [],
   rules: {
      username: {
        required:true,
        minlength:3,
        maxlength:30,
        normalizer: function (value) {
                    return $.trim(value);
                }
      }
  },
  messages: {
            username: {
              required: "The full name field is required.",
              minlength: jQuery.validator.format("At least {0} characters required."),
              maxlength: jQuery.validator.format("Maximum {0} characters allowed.")
            }

        }
 });


$( "#admin_change_pw" ).validate({
   ignore: [],
   rules: {
      password: {
        required:true
      },
      new_password: {
        required:true,
        minlength: 6,
        maxlength:50
      },
      c_password: {
        required:true,
        equalTo: "#new_password"
      }
  },
  messages: {
      password: {
        required: "The current password field is required."
      },
      new_password: {
        required: "The new password field is required.",
        minlength: jQuery.validator.format("At least {0} characters required"),
        maxlength: jQuery.validator.format("Maximum {0} characters allowed")
      },
      c_password: {
        required: "The confirm new password field is required.",
        equalTo: "Please enter the same password as above."
      }

  }
 });

$( "#reset_password" ).validate({
   ignore: [],
   rules: {
      password: {
        required:true
      },
      c_password: {
        required:true,
        equalTo: "#password"
      }
  },
  messages: {
      password: {
        required: "The new password field is required."
      },
      c_password: {
        required: "The confirm password field is required.",
        equalTo: "Please enter the same password as above."
      }

  }
 });

 var validator = $( "#admin_add_edit" ).validate({
    ignore: [],
    errorPlacement: function(error, element) {
                error.insertAfter(element);
              },
   rules: {
      username: {
        required:true,
        alpha:true,
        minlength:3,
        maxlength:30,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      email: {
        required:true,
        email: true,
        normalizer: function (value) {
                    return $.trim(value);
                }
      },
      password: {
        required:true,
        minlength: 6  
      },
      c_password: {
          required:true,
          equalTo: "#password"
      }
  },
  messages: {
            username: {
              required: "The full name field is required.",
              alpha: "The full name field is not in the correct format.",
              minlength: jQuery.validator.format("At least {0} characters required."),
              maxlength: jQuery.validator.format("Maximum {0} characters allowed.")    
            },
            email:{
              required: "The email field is required.",
              email: "The email field is invalid."       
            },
            password: {
              required: "The password field is required.",
              minlength: jQuery.validator.format("At least {0} characters required.")
            },
            c_password: {
              required: "The confirm password field is required.",
              equalTo: "The confirm password field does not match the password field."
            }
        }
 });

function delete_single_record(id,table,name) {
            swal({
                title: "Are you sure?",
                text: "you want to delete this "+name,
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect member-cancel',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light member-delete',
                confirmButtonText: 'Delete!'
            },
            function(isConfirm) 
            {
              if (isConfirm) 
              {
                  if (window.XMLHttpRequest) 
                  {
                    xmlhttp = new XMLHttpRequest();
                  } else 
                  {
                      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                  }
                  xmlhttp.onreadystatechange = function() 
                  {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                    {
                      //alert( xmlhttp.responseText);
                      console.log( "row_id_"+id);
                      if(xmlhttp.responseText)
                      {
                        document.getElementById("row_id_"+id).innerHTML = '';
                        var capital = capitalizeFirstLetter(name);
                        toastr.success(capital+' deleted successfully.');
                      }
                      else
                      {
                        toastr.error('Something went wrong.');
                      }             
                    }
                  };
                  xmlhttp.open("GET",base_url+"ajax/delete/"+table+'/'+id,true);
                  xmlhttp.send();
              } 
            });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}