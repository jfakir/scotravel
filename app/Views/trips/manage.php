<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
    $id = isset($tripDetails[0]['id'])?$tripDetails[0]['id']:0;
    $name = isset($tripDetails[0]['name'])?$tripDetails[0]['name']:'';
    $is_round_trip = isset($tripDetails[0]['is_round_trip'])?$tripDetails[0]['is_round_trip']:0;
    $destination_id = isset($tripDetails[0]['destination_id'])?$tripDetails[0]['destination_id']:0;
    $company_id = isset($tripDetails[0]['company_id'])?$tripDetails[0]['company_id']:0;
    $image_url = isset($tripDetails[0]['image_url'])?$tripDetails[0]['image_url']:'';
    // $starting_date = isset($tripDetails[0]['starting_date'])?$tripDetails[0]['starting_date']:'';
    // $ending_date = isset($tripDetails[0]['ending_date'])?$tripDetails[0]['ending_date']:'';



    if(isset($tripDetails[0]['ending_date'])){
        $ending_date = $tripDetails[0]['ending_date'];
        $ending_date = new DateTime($ending_date);
        $ending_date = $ending_date->format('m/d/Y');
    }else{
        $ending_date = '';
    }

    if(isset($tripDetails[0]['starting_date'])){
        $starting_date = $tripDetails[0]['starting_date'];

        $starting_date = new DateTime($starting_date);

        $starting_date = $starting_date->format('m/d/Y');

    }else{
        $starting_date = '';
    }


?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Trip</h5>
                <form id="trip_form" name="trip_form" class="needs-validation" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tripId" id="tripId" value="<?=$id?>" />
                    <div class="row mb-3">
                        <label for="tripName_input" class="col-sm-2 col-form-label">Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="tripName_input" class="form-control" value="<?= $name ?>">
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tripDestination_select">Destination<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <select class="select2single destination-select selectPickerSingle form-control" name="destination" id="tripDestination_select" data-placeholder="Select Destination">
                                <option value='-1'>Select City</option>
                                <?php
                                if(isset($allCities)){
                                    foreach($allCities as $city){
                                ?>

                                    <option value="<?=$city['id']?>" city-name="<?=$city['city']?>"
                                        <?php
                                            if(isset($destination_id) && $city['id']==$destination_id){
                                                echo "selected";
                                            }
                                        ?>
                                    >
                                        <?=$city['city']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
                            </select>
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                    </div>
                    <input type="hidden" name="image_url" id="trip_form_image_url" value="<?=$image_url?>">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tripStartingDate_input">Starting Date<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="starting_date" id="tripStartingDate_input" class="form-control" value="<?=$starting_date?>">
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tripEndingDate_input">Ending Date<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="ending_date" id="tripEndingDate_input" class="form-control" value="<?=$ending_date?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tripTenantID_select2">Company<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <select class="select2single form-control" name="tenant_id" id="tripTenantID_select2" data-placeholder="Select Tenant">
                                <option value='-1'>Select Company</option>
                                <?php
                                if(isset($allCompanies)){
                                    foreach($allCompanies as $company){
                                ?>

                                    <option value="<?=$company['id']?>"
                                        <?php
                                            if(isset($company_id) && $company['id']==$company_id){
                                                echo "selected";
                                            }
                                        ?>
                                    >
                                        <?=$company['name']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
           
                            </select>
                            <p class="text-danger m-0 error-message"></p>

                        </div>
                    </div>
                    <div class="row mb-3 
                <?php  if(!isset($tripTravelers) || empty($tripTravelers)){ echo "displayNone"; } ?>
                    " id="tripFormTravelersSelectPickerRow">
                        <label class="col-sm-2 col-form-label " for="tripTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <select class="select2multiple form-control" name="travelers_id[]" id="tripTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
                                <?php
                                if(isset($tripTravelers)&&isset($companyUsers)){
                                ?>
                                <?php
                                    foreach($companyUsers as $user){
                                ?>
                                        <option value="<?=$user['user_id']?>" 
                                <?php
                                            foreach($tripTravelers as $traveler){
                                                if($traveler['id']==$user['user_id']){
                                                    echo 'selected';
                                                }
                                            }
                                ?>
                                                    
                                        >
                                            <?=$user['fname'].' '.$user['lname']?>
                                        </option>
                                <?php
                                    }
                                                
                                }
                                ?>
                            </select>
                            <p class="text-danger m-0 error-message"></p>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="is_round_tripFormInput">Round Trip<i class="text-danger"></i></label>
                        <div class="col-sm-10" style="align-content: center;">
                            <input type="checkbox" id="is_round_tripFormInput" style="width:16px; height:16px;" <?=$is_round_trip==1?"checked":""?>>
                        </div>
                    </div>
                   
                    <div class="row error-message-container">
                        <div class="col-12">
                            <p class="text-danger"></p>
                        </div>
                    </div>
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12  d-flex justify-content-end">
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                        </div>

                    </div>
              
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

