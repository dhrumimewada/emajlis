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
                    <h4 class="page-title">Vouchers</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()."dashboard"; ?>">Emajlis</a></li>
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
                                    <form id="add_edit_vouchers" class="form-horizontal" role="form" name="editvouchers" method="post">
                                        <div class="form-group row">
                                            <input type="hidden" name="id" value="<?php echo $voucher->id; ?>">
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Vender Partner</label>
                                                <div class="col-md-12 user-add">
                                                    <select name="vender" class="select2" data-placeholder="Select vender partner" tabindex="-1" aria-hidden="true">
                                                      <optgroup label="Select Vender Partner">
                                                          <option selected disabled></option>
                                                         <?php 
    $field_value = NULL;
    $temp_value = set_value('vender');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    } else{
        $field_value = $voucher->vendor_id;
    }
                                                         foreach($vendor_partners as $key => $value){  ?>
                                                          <option value="<?php echo $value['id']; ?>" <?php if($field_value == $value['id']){ echo 'selected'; } ?> >
                                                            <?php echo $value['name']; ?>
                                                          </option>
                                                         <?php }?> 
                                                      </optgroup>
                                                    </select>
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('vender'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-form-label required">Voucher Code</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('voucher_code');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }  else{
        $field_value = $voucher->voucher_code;
    }
    ?>
                                                    <input id="voucher_code" name="voucher_code" type="text" class="form-control" placeholder="Ex: SPECIAL20" autocomplete="off" value="<?php  echo $field_value; ?>" style="text-transform: uppercase">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('voucher_code'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Voucher Type</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('voucher_type');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $voucher->voucher_type;
    } 
    ?>
                                                    <select name="voucher_type" class="select2" data-placeholder="Select voucher type" tabindex="-1" aria-hidden="true">
                                                          <option selected disabled></option>
                                                          <option value="0" <?php echo ($field_value == "0")?'selected':''; ?> >Fixed (&#x62f;&#x2e;&#x625;)</option>
                                                          <option value="1" <?php echo ($field_value == "1")?'selected':''; ?> >Percentage (%)</option>
                                                    </select>
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('voucher_type'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="col-form-label required">Voucher Rate</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('voucher_amount');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $voucher->voucher_amount;
    }  
    ?>
                                                    <input name="voucher_amount" type="number" class="form-control" placeholder="Ex: 20" autocomplete="off" value="<?php  echo $field_value; ?>">
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('voucher_amount'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="col-form-label" for="voucher_description">Voucher Desription</label>
                                                <div class="col-md-12 user-add">
                                                    <?php
    $field_value = NULL;
    $temp_value = set_value('voucher_description');
    if (isset($temp_value) && !empty($temp_value)) {
        $field_value = $temp_value;
    }else{
        $field_value = $voucher->voucher_description;
    }   
    ?>
                                                    <textarea name="voucher_description" id="voucher_description"  class="form-control" placeholder="Enter voucher desription" autocomplete="off"><?php  echo $field_value; ?></textarea>
                                                    <div class="validation-error-label">
                                                        <?php echo form_error('voucher_description'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                               

                                        <div class="form-group text-center m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <a href="<?php echo base_url().'vouchers'; ?>" class="btn btn-secondary waves-effect m-l-5">Cancel</a>
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
