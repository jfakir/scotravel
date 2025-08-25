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
                <h5 class="card-title">Edit Restaurant</h5>
                <form name="restaurant_form" id="restaurant_form" class="needs-validation" >
                    <input type="hidden" id="id" name="id" value="<?=$id?>" />
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="5" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageRestaurantTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageRestaurantTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                        <label for="restaurantName_input" class="col-sm-2 col-form-label">Restaurant Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="restaurantName_input" class="form-control" value="<?=$name?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="restaurantStartingDate_input">Reservation Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="restaurantStartingDate_input" class="form-control datepicker" value="<?=$starting_date?>" >
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Reservation Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="restaurantStartingTime_input" class="form-control timepicker" value="<?=$starting_time?>" placeholder="Reservation time*">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Reservation Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="restaurantConfirmation_input" class="form-control" value="<?=$confirmation?>"> 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantAddress_input" class="col-sm-2 col-form-label">Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="restaurantAddress_input" class="form-control"  value="<?=$address?>" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="restaurantPhone_input" class="form-control"   value="<?=$phone?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">More Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantCuisine_input" class="col-sm-2 col-form-label">Cuisine</label>
                        <div class="col-sm-2">
                            <input type="text" name="cuisine" id="restaurantCuisine_input" class="form-control" value="<?=$cuisine?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantDressCode_input" class="col-sm-2 col-form-label">Dress Code</label>
                        <div class="col-sm-10">
                            <input type="text" name="dress_code" id="restaurantDressCode_input" class="form-control "  value="<?=$dress_code?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="restaurantCost_input" class="form-control cost-input" value="<?=$cost?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12  d-flex justify-content-end">
                            <p class="text-danger mb-0  restaurantErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" id="restaurantFormSaveBtn" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php }else{ ?>
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Restaurant</h5>
                <form name="restaurant_form" id="restaurant_form" class="needs-validation" >
                    <input type="hidden" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="5" />

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageRestaurantTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="manageRestaurantTravelersID_select" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                        <label for="restaurantName_input" class="col-sm-2 col-form-label">Restaurant Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="restaurantName_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="restaurantStartingDate_input">Reservation Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="restaurantStartingDate_input" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Reservation Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="restaurantStartingTime_input" class="form-control timepicker" placeholder="Reservation time*">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Reservation Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantConfirmation_input" class="col-sm-2 col-form-label">Confirmation<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="restaurantConfirmation_input" class="form-control"> 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantAddress_input" class="col-sm-2 col-form-label">Address<i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <input type="text" name="address" id="restaurantAddress_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Contact Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantPhone_input" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-5">
                            <input type="text" name="phone" id="restaurantPhone_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">More Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantCuisine_input" class="col-sm-2 col-form-label">Cuisine</label>
                        <div class="col-sm-2">
                            <input type="text" name="cuisine" id="restaurantCuisine_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantDressCode_input" class="col-sm-2 col-form-label">Dress Code</label>
                        <div class="col-sm-10">
                            <input type="text" name="dress_code" id="restaurantDressCode_input" class="form-control ">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="restaurantCost_input" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-10">
                            <input type="text" name="cost" id="restaurantCost_input" class="form-control cost-input">
                        </div>
                    </div>
               
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12  d-flex justify-content-end">
                            <p class="text-danger mb-0  restaurantErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button" id="restaurantFormSaveBtn" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>

                 

                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?= $this->endSection() ?>