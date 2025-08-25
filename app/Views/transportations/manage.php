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
                <h5 class="card-title">Edit Transportation</h5>
                <form id="transportation_form" class="needs-validation" >
                    <input type="hidden" id="id" name="id" value="<?=$id?>" />
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="6" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageTransportationTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageTransportationTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
                                <?php
                                    if(isset($travelers)){
                                        foreach($travelers as $traveler){
                                ?>
                                    <option value="<?=$traveler['user_id']?>"
                                        <?php
                                            foreach ($planUsers as $user) {
                                                if ($user->user_id == $traveler['user_id']) {
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
                        <label for="transportationName_input" class="col-sm-2 col-form-label">Agency Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="transportationName_input" class="form-control" value="<?=$name?>" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="transportationStartingDate_input">Pickup date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="transportationStartingDate_input" class="form-control datepicker"  value="<?=$starting_date?>" >
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="transportationStartingTime_input" class="form-control timepicker" placeholder="Pickup time*" value="<?=$starting_time?>" >
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="transportationEndingDate_input">Drop-off date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="transportationEndingDate_input" class="form-control datepicker" value="<?=$ending_date?>" >
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Drop-off Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="transportationEndingTime_input" class="form-control timepicker" placeholder="Drop-off time" value="<?=$ending_time?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Drop-off Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationPickupAddress_input" class="col-sm-2 col-form-label">Pikcup Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="transportationPickupAddress_input" class="form-control" value="<?=$address?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationDropoffAddress_input" class="col-sm-2 col-form-label">Drop-off Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="dropoff_address" id="transportationDropoffAddress_input" class="form-control" value="<?=$dropoff_address?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="transportationConfirmation_input" class="form-control"  >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="transportationPhone_input" class="form-control " value="<?=$phone?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="transportationCost_input" class="form-control cost-input" value="<?=$cost?>">
                        </div>
                    </div>
                 
                
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end" >
                            <p class="text-danger mb-0  transportationErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" class="btn btn-primary"  id="saveTransportaionBtn"><i class="bi bi-send"></i> Save</button>
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
                <h5 class="card-title">Manage Transportation</h5>
                <form id="transportation_form" class="needs-validation" >
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="6" />
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageTransportationTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageTransportationTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                        <label for="transportationName_input" class="col-sm-2 col-form-label">Agency Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="transportationName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="transportationStartingDate_input">Pickup date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="transportationStartingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="transportationStartingTime_input" class="form-control timepicker" placeholder="Pickup time*">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Pickup Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="transportationEndingDate_input">Drop-off date<i class="text-danger"></i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="transportationEndingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Drop-off Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="transportationEndingTime_input" class="form-control timepicker" placeholder="Drop-off time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Drop-off Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationPickupAddress_input" class="col-sm-2 col-form-label">Pikcup Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="transportationPickupAddress_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationDropoffAddress_input" class="col-sm-2 col-form-label">Drop-off Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="dropoff_address" id="transportationDropoffAddress_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="transportationConfirmation_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="transportationPhone_input" class="form-control ">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="transportationCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="transportationCost_input" class="form-control cost-input">
                        </div>
                    </div>
                
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end" >
                            <p class="text-danger mb-0  transportationErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" class="btn btn-primary"  id="saveTransportaionBtn"><i class="bi bi-send"></i> Save</button>
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