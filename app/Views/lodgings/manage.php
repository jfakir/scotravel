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
                <h5 class="card-title">Edit Lodging</h5>
                <form name="lodging_form" id="lodging_form" class="needs-validation">
                    <input type="hidden" id="id" name="id" value="<?=$id?>" />
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="4" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageLodgingTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageLodgingTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                        <label for="lodgingName_input" class="col-sm-2 col-form-label">Lodging Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="lodgingName_input" class="form-control" value="<?=$name?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="lodgingStartingDate_input">Check in Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="lodgingStartingDate_input" class="form-control datepicker" value="<?=$starting_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Checkin Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="lodgingStartingTime_input" class="form-control timepicker" value="<?=$starting_time?>" placeholder="Check in time*">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Checkin Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="lodgingEndingDate_input">Check out Date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="lodgingEndingDate_input" class="form-control datepicker" value="<?=$ending_date?>"> 
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Check-out Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="lodgingEndingTime_input" class="form-control timepicker" value="<?=$ending_time?>" placeholder="Check out time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Check-out Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="lodgingConfirmation_input" class="form-control" value="<?=$confirmation?>"> 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingAddress_input" class="col-sm-2 col-form-label">Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="lodgingAddress_input" class="form-control" value="<?=$address?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
               
                    <div class="row mb-3">
                        <label for="lodgingPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="lodgingPhone_input" class="form-control" value="<?=$phone?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingContactName_input" class="col-sm-2 col-form-label">Contact Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="contact" id="lodgingContactName_input" class="form-control" value="<?=$contact?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingEmail_input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="lodgingEmail_input" class="form-control" value="<?=$email?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingWebsite_input" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website" id="lodgingWebsite_input" class="form-control" value="<?=$website?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Room Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingNumberOfRooms_input" class="col-sm-2 col-form-label">Number Of Rooms</label>
                        <div class="col-sm-2">
                            <input type="number" name="rooms_number" id="lodgingNumberOfRooms_input" class="form-control"  value="<?=$rooms_number?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingRoomsDescription_input" class="col-sm-2 col-form-label">Rooms Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="room_description" id="lodgingRoomsDescription_input" class="form-control" value="<?=$room_description?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="lodgingCost_input" class="form-control cost-input" value="<?=$cost?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingMileagePointsUsed_input" class="col-sm-2 col-form-label">Mileage Redeemed</label>
                        <div class="col-sm-10">
                            <input type="text" name="mileage_used" id="lodgingMileagePointsUsed_input" class="form-control" value="<?=$mileage_used?>">
                        </div>
                    </div>
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0  lodgingErrorMessage"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" class="btn btn-primary" id='lodgingFormSaveBtn'><i class="bi bi-send"></i> Save</button>
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
                <h5 class="card-title">Manage Lodging</h5>
                <form name="lodging_form" id="lodging_form" class="needs-validation" >
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="4" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageLodgingTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageLodgingTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
                                <?php
                                    if(isset($travelers)){
                                        foreach($travelers as $traveler){
                                ?>
                                    <option value="<?=$traveler['user_id']?>"
                         
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
                        <label for="lodgingName_input" class="col-sm-2 col-form-label">Lodging Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="lodgingName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="lodgingStartingDate_input">Check in Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="lodgingStartingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Checkin Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="lodgingStartingTime_input" class="form-control timepicker" placeholder="Check in time*">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Checkin Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="lodgingEndingDate_input">Check out Date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="lodgingEndingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Check-out Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="lodgingEndingTime_input" class="form-control timepicker" placeholder="Check out time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Check-out Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="lodgingConfirmation_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingAddress_input" class="col-sm-2 col-form-label">Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="lodgingAddress_input" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
               
                    <div class="row mb-3">
                        <label for="lodgingPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="lodgingPhone_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingContactName_input" class="col-sm-2 col-form-label">Contact Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="contact" id="lodgingContactName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingEmail_input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="lodgingEmail_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingWebsite_input" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website" id="lodgingWebsite_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Room Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingNumberOfRooms_input" class="col-sm-2 col-form-label">Number Of Rooms</label>
                        <div class="col-sm-2">
                            <input type="number" min="1" name="rooms_number" id="lodgingNumberOfRooms_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingRoomsDescription_input" class="col-sm-2 col-form-label">Rooms Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="room_description" id="lodgingRoomsDescription_input" class="form-control ">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="lodgingCost_input" class="form-control cost-input">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lodgingMileagePointsUsed_input" class="col-sm-2 col-form-label">Mileage Redeemed</label>
                        <div class="col-sm-10">
                            <input type="text" name="mileage_used" id="lodgingMileagePointsUsed_input" class="form-control">
                        </div>
                    </div>
            
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0  lodgingErrorMessage"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" class="btn btn-primary" id='lodgingFormSaveBtn'><i class="bi bi-send"></i> Save</button>
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