<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
    if(isset($plan) && !empty($plan)){
        extract($plan);

        $startDate = new DateTime($starting_date);
        $starting_date = $startDate->format('m/d/Y');

        $endDate = new DateTime($ending_date);
        $ending_date = $endDate->format('m/d/Y');

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Car Renting</h5>
                <form name="carRenting_form" id="carRenting_form" class="needs-validation" >
                    <input type="hidden" id="id" name="id" value="<?=$id?>" />
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="2" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageCarRentingTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageCarRentingTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
                                <?php
                                    if(isset($travelers)){
                                        foreach($travelers as $traveler){
                                ?>
                                        <option value="<?=$traveler['user_id']?>"
                                            <?php
                                                foreach ($planUsers as $user) {
                                                    if ($user['user_id'] == $traveler['user_id']) {
                                                        echo "selected";
                                                    }
                                                }
                                            ?>
                                        >
                                            <?=$traveler['fname'].' '.$traveler['lname']?>
                                        </option>
                                
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingName_input" class="col-sm-2 col-form-label">Agency Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="carRentingName_input" class="form-control" value="<?=$name?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="carRentingStartingDate_input">Pickup date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="carRentingStartingDate_input" class="form-control datepicker" value="<?=$starting_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="carRentingStartingTime_input" class="form-control timepicker" placeholder="Pickup time*"  value="<?=$starting_time?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="carRentingEndingDate_input">Drop-off date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="carRentingEndingDate_input" class="form-control datepicker" value="<?=$ending_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Check-out Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="carRentingEndingTime_input" class="form-control timepicker" placeholder="Check-out time" value="<?=$ending_time?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Check-out Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingPickupAddress_input" class="col-sm-2 col-form-label">Pikcup Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="carRentingPickupAddress_input" class="form-control" value="<?=$address?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingDropoffAddress_input" class="col-sm-2 col-form-label">Drop-off Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="dropoff_address" id="carRentingDropoffAddress_input" class="form-control" value="<?=$dropoff_address?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="carRentingConfirmation_input" class="form-control" value="<?=$confirmation?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingContactName_input" class="col-sm-2 col-form-label">Contact Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="contact" id="carRentingContactName_input" class="form-control" value="<?=$contact?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="carRentingPhone_input" class="form-control " value="<?=$phone?>"> 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingEmail_input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="carRentingEmail_input" class="form-control"  value="<?=$email?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingWebsite_input" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website" id="carRentingWebsite_input" class="form-control"  value="<?=$website?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Car Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carType_input" class="col-sm-2 col-form-label">Car Type</label>
                        <div class="col-sm-2">
                            <input type="text" name="car_type" id="carType_input" class="form-control" value="<?=$car_type?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingCarDescription_input" class="col-sm-2 col-form-label">Car Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="car_description" id="carRentingCarDescription_input" class="form-control " value="<?=$car_description?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="carRentingCost_input" class="form-control cost-input" value="<?=$cost?>">
                        </div>
                    </div>
                  
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-10 d-flex justify-content-end">
                            <p class="text-danger mb-0  carRentingErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveCarRentingBtn"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    }else{
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Car Renting</h5>
                <form name="carRenting_form" id="carRenting_form"  class="needs-validation" >
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="2" />
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageCarRentingTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageCarRentingTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
                                <?php
                                    if(isset($travelers)){
                                        foreach($travelers as $traveler){
                                ?>
                                        <option value="<?=$traveler['user_id']?>">
                                            <?=$traveler['fname'].' '.$traveler['lname']?>
                                        </option>
                                
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingName_input" class="col-sm-2 col-form-label">Agency Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="carRentingName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="carRentingStartingDate_input">Pickup date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="carRentingStartingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="carRentingStartingTime_input" class="form-control timepicker" placeholder="Pickup time*">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="carRentingEndingDate_input">Drop-off date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="carRentingEndingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Drop-off Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="carRentingEndingTime_input" class="form-control timepicker" placeholder="Drop-off time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Drop-off Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingPickupAddress_input" class="col-sm-2 col-form-label">Pikcup Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="carRentingPickupAddress_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingDropoffAddress_input" class="col-sm-2 col-form-label">Drop-off Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="dropoff_address" id="carRentingDropoffAddress_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="carRentingConfirmation_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingContactName_input" class="col-sm-2 col-form-label">Contact Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="contact" id="carRentingContactName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="carRentingPhone_input" class="form-control ">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingEmail_input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="carRentingEmail_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingWebsite_input" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website" id="carRentingWebsite_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Car Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carType_input" class="col-sm-2 col-form-label">Car Type</label>
                        <div class="col-sm-2">
                            <input type="text" name="car_type" id="carType_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingCarDescription_input" class="col-sm-2 col-form-label">Car Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="car_description" id="carRentingCarDescription_input" class="form-control ">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="carRentingCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="carRentingCost_input" class="form-control cost-input">
                        </div>
                    </div>
                
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12  d-flex justify-content-end">
                            <p class="text-danger mb-0  carRentingErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" class="btn btn-primary"  id="saveCarRentingBtn"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>
<?= $this->endSection() ?>