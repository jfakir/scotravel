<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
    if(isset($plan) && !empty($plan)){
        extract($plan);

        $startDate = new DateTime($starting_date);
        $starting_date = $startDate->format('m/d/Y');

        // $endDate = new DateTime($ending_date);
        // $ending_date = $endDate->format('m/d/Y');
        if(empty($endDate)){
            $ending_date = "";
        }else{
            $endDate = new DateTime($endDate);
            $ending_date = $endDate->format('m/d/Y');

        }

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Activity</h5>
                <form name="activity_form" id="activity_form" class="needs-validation" >
                    <!-- <input type="hidden" id="manageActivityFormStatus" value="0" /> -->
                    <input type="hidden" id="trip_id" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="id"  value="0<?=$id?>" />
                    <input type="hidden" name="plan_type" value="1" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageActivityTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageActivityTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                        <label for="activityName_input" class="col-sm-2 col-form-label" >Activity Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="activityName_input" class="form-control" value="<?=$name?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="activityStartingDate_input">Starting Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="activityStartingDate_input" class="form-control datepicker" value="<?=$starting_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="activityStartingTime_input" class="form-control timepicker" placeholder="Starting time"  value="<?=$starting_time?>"> 
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="activityEndingDate_input">Ending Date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="activityEndingDate_input" class="form-control datepicker" value="<?=$ending_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="activityEndingTime_input" class="form-control timepicker" placeholder="Ending time" value="<?=$ending_time?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityAddress_input" class="col-sm-2 col-form-label">Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="activityAddress_input" class="form-control" value="<?=$address?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="activityConfirmation_input" class="form-control" value="<?=$confirmation?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="activityPhone_input" class="form-control" value="<?=$phone?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityEmail_input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="activityEmail_input" class="form-control" value="<?=$email?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityWebsite_input" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website" id="activityWebsite_input" class="form-control" value="<?=$website?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="activityCost_input" class="form-control cost-input" value="<?=$cost?>">
                        </div>
                    </div>
               
                    <div class="col-sm-12 d-flex justify-content-end">
                        <p class="text-danger mb-0  activityErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                        <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>

                        <button  type="button" class="btn btn-primary activitySubmitBtn"><i class="bi bi-send"></i> Save</button>
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
                <h5 class="card-title">Manage Activity</h5>
                <form name="activity_form" id="activity_form" class="needs-validation" >
                    <!-- <input type="hidden" id="manageActivityFormStatus" value="0" /> -->
                    <input type="hidden" name="plan_type" value="1" />
                    <input type="hidden" id="trip_id" name="trip_id" value="<?=$trip_id?>" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageActivityTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageActivityTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                        <label for="activityName_input" class="col-sm-2 col-form-label">Activity Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="activityName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="activityStartingDate_input">Starting Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="activityStartingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="activityStartingTime_input" class="form-control timepicker" placeholder="Starting time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="activityEndingDate_input">Ending Date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="activityEndingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="activityEndingTime_input" class="form-control timepicker" placeholder="Ending time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityAddress_input" class="col-sm-2 col-form-label">Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="activityAddress_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="activityConfirmation_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="activityPhone_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityEmail_input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="activityEmail_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityWebsite_input" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website" id="activityWebsite_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="activityCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="activityCost_input" class="form-control cost-input">
                        </div>
                    </div>
                  
                    <div class="row mb-3 ">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0  activityErrorMsg"  style="margin-right:5px;align-content: center;" ></p>

                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button  type="button" class="btn btn-primary activitySubmitBtn"><i class="bi bi-send"></i> Save</button>
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