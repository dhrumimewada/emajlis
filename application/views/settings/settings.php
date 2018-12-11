<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    .error{
        color: red;
        font-size: 16px;
        margin-top: 10px;
    }    
    table {  
        border-collapse: collapse;
        width: 100%;   
        border-color: black;
    }
    .tablem {  
        border-collapse: collapse;
        width: 60%;   
        border-color: black;
    }

    td, th {
        border: 1px solid black;
        text-align: left;
        padding: 8px !important;
    }

    tr:nth-child(even) {
        background-color: #8a768a33;
    }

</style>

<?php if($this->session->flashdata('message') == "App Setting updated successfully") { ?>
    <script>
        toastr.success('<?php echo $this->session->flashdata('message'); ?>');
    </script>
<?php } else if($this->session->flashdata('message') == "Authontication Password Incorrect") { ?>
    <script>
        toastr.error('<?php echo $this->session->flashdata('message'); ?>');
    </script>
<?php } ?>
<div class="content-page">
                <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- <div class="btn-group pull-right m-t-15">
                        <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings</button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">Dropdown One</a>
                            <a class="dropdown-item" href="#">Dropdown Two</a>
                            <a class="dropdown-item" href="#">Dropdown Three</a>
                            <a class="dropdown-item" href="#">Dropdown Four</a>
                        </div>
                    </div> -->

                    <h4 class="page-title">Settings</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()."dashboard"; ?>">Emajlis</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                                    <form role="form" method="post" action="<?php echo BASE_URL();?>settings/appsetting" >
                                        <div id="app_setting" class="modal fade modal-scroll" tabindex="-1" data-replace="true">
                                            <div class="modal-dialog">      
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title" style="float: right;">Authentication password</h4>
                                                    </div>
                                                    <div class="modal-body">                                            
                                                        <div class="form-group">
                                                            <label>Password</label><br/>                       
                                                            <input type="password" class="form-control" value="" name="password" placeholder="Password" required>                                               
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn dark btn-outline">Update</button>
                                                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                                                    </div>
                                                </div>      
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <table style="margin-bottom: 20px;" id="mainTable">                               
                                                <tr>                                    
                                                    <th>&nbsp;App name</th>
                                                    <th>&nbsp;App version</th>
                                                    <th>&nbsp;Compulsory update</th>
                                                </tr>
                                                               
                                                <?php foreach ($appsetting as $rows) { ?>                               
                                                    <tr>                                    
                                                        <td>&nbsp;<?php   if($rows->name == 'Android'){echo 'Android';}
                                                                    else if($rows->name == 'IOS'){echo 'IOS';} ?>            
                                                        </td>
                                                        <td><input type="text" name="<?php echo $rows->name;?>" value="<?php echo $rows->version;?>" class="form-control" > </td>
                                                        <td style="text-align: center;">                                                   
                                                        <input type="checkbox" <?php if($rows->updated_status == 1){echo "checked";} ?>  value="1" name="<?php echo $rows->name;?>Checkbox" >
                                                        </td>
                                                    </tr>                                                           
                                                <?php } ?>                                
                                            </table>
                                        </div>
                                        <div class="form-group row">
                                            <table id="mainTable">
                                                <tr>
                                                    <th style="width: 69.7%;">&nbsp;Maintenance mode</th>                                    
                                                    <th>&nbsp;Maintenance mode enable ?</th>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;Maintenance mode</td>
                                                  
                                                    <td style="text-align: center;">
                                                        

                                                         <input type="checkbox" <?php if($maintenancemode->updated_status == 1){echo "checked";} ?>  value="1" name="maintenancemodecheckbox" >
                                                    </td> 
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="form-group text-center m-b-0">
                                            <!--  <button type="submit" class="btn blue">Save</button> -->
                                            <a data-toggle="modal" href="#app_setting" class="btn btn-primary waves-effect waves-light">Update</a>
                                            <!-- <button type="button" class="btn default">Cancel</button> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- end card-box -->
                </div><!-- end col -->
            </div>

                        <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
