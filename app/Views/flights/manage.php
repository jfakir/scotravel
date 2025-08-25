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
                <h5 class="card-title">Edit Flight</h5>
                <form name="flight_form" id="flight_form" class="needs-validation">
                    <!-- <input type="hidden" id="manageFlightFormStatus" value="0" /> -->
                    <input type="hidden" id="trip_id" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="3" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageFlightTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="flight_travelers_id" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                            <!-- <i class="fa fa-plus btn btn-primary d-flex align-items-center ms-2 quick-add-traveler" title="Quick Add Traveler"></i> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="flight_number">Flight Number<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="flight_number" id="flight_number" class="form-control" value="<?=$flight_number?>">
                                <span class="btn btn-primary input-group-text bg-dangerfw-bold" id="searchFlightApi" title="Search Flight"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="address">Destination<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="city_id" id="address"  data-placeholder="Select Destination">
                            <option value='-1'>Select Destination</option>

                            <?php
                                    if(isset($allCities)){
                                    foreach($allCities as $city){
                                ?>

                                    <option value="<?=$city['id']?>"
                                        <?php
                                            if($city['id']==$city_id){
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
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="airline_id">Airline<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="airline_id" id="airline_id" data-placeholder="Select Airline">
                            <option value='-1'>Select Airline</option>
                            <option airline_name="<?=$airline_name?>" selected >
                                    <?=$airline_name?>
                            </option>
                            <?php
                                    if(isset($airlines)){
                                    foreach($airlines as $airline){
                                ?>

                                    <option value="<?=$airline['id']?>" airline_name="<?=$airline['name']?>"
                                        <?php
                                            if($airline['id']==$airline_id){
                                                echo "selected";
                                            }
                                        ?>
                                    >
                                        <?=$airline['name']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="airline_name" id="airline_name" value="<?=$airline_name?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="confirmation" class="col-sm-2 col-form-label">Confirmation<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="confirmation" class="form-control" value="<?=$confirmation?>">
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Seat(s)</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser1_input">User 1</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser1" id="flightSeatForUser1_input" class="form-control">
                        </div>
                        <div class="col-12 mb-2"></div>
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser2_input">User 2</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser2" id="flightSeatForUser2_input" class="form-control">
                        </div>
                        <div class="col-12 mb-2"></div>
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser3_input">User 3</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser3" id="flightSeatForUser3_input" class="form-control">
                        </div>
                        <div class="col-12 mb-2"></div>
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser4_input">User 4</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser4" id="flightSeatForUser4_input" class="form-control">
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Departure Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="starting_date">Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">

                                <input type="text" name="starting_date" id="starting_date" class="form-control datepicker" value="<?=$starting_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Date"><i class="bi bi-x-lg"></i></span>

                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="starting_time" class="form-control timepicker" placeholder="Starting time" value="<?=$starting_time?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="departure_airport_id">Airport<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="departure_airport_id" id="departure_airport_id"  data-placeholder="Select Airport">
                            <option value='-1'>Select Airport</option>
                            <option departure_airport_name="<?=$departure_airport_name?>" departure_airport_code="<?=$departure_airport_code?>" selected >
                                    <?=$departure_airport_name?>
                            </option>

                            <?php
                                if(isset($airports)){
                                    foreach($airports as $airport){
                                ?>

                                    <option value="<?=$airport['id']?>" departure_airport_name="<?=$airport['name']?>" departure_airport_code="<?=$airport['iata_code']?>"
                                     
                                    >
                                        <?=$airport['name']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="departure_airport_name" id="departure_airport_name"  value="<?=$departure_airport_name?>">
                            <input type="hidden" name="departure_airport_code" id="departure_airport_code" value="<?=$departure_airport_code?>">

                            <!-- <i class="fa fa-plus btn btn-primary d-flex align-items-center ms-2 quick-add-traveler" title="Quick Add Traveler"></i> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="departure_gate">Gate and Terminal</label>
                        <div class="col-sm-5">
                            <input type="text" name="departure_gate" id="departure_gate" class="form-control" placeholder="Gate" value="<?=$departure_gate?>">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="departure_terminal" id="departure_terminal" class="form-control" placeholder="Terminal" value="<?=$departure_terminal?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Arrival Information</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="ending_date">Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">

                                <input type="text" name="ending_date" id="ending_date" class="form-control datepicker" value="<?=$ending_date?>">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Date"><i class="bi bi-x-lg"></i></span>

                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="ending_time" class="form-control timepicker" placeholder="Ending Time" value="<?=$ending_time?>" >
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="arrival_airport_id">Airport<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="arrival_airport_id" id="arrival_airport_id"  data-placeholder="Select Airport">
                            <option value='-1'>Select Airport</option>
                            <option arrival_airport_name="<?=$arrival_airport_name?>" arrival_airport_code="<?=$arrival_airport_code?>" selected >
                                    <?=$arrival_airport_name?>
                            </option>
                                <?php
                                    if(isset($airports)){
                                        foreach($airports as $airport){
                                ?>

                                        <option value="<?=$airport['id']?>" arrival_airport_name="<?=$airport['name']?>" arrival_airport_code="<?=$airport['iata_code']?>"
                                            
                                        >
                                            <?=$airport['name']?>
                                        </option>
                                    
                                <?php

                                        }
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="arrival_airport_name" id="arrival_airport_name" value="<?=$arrival_airport_name?>">
                            <input type="hidden" name="arrival_airport_code" id="arrival_airport_code" value="<?=$arrival_airport_code?>">
                            <!-- <i class="fa fa-plus btn btn-primary d-flex align-items-center ms-2 quick-add-traveler" title="Quick Add Traveler"></i> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="arrival_gate">Gate and Terminal</label>
                        <div class="col-sm-5">
                            <input type="text" name="arrival_gate" id="arrival_gate" class="form-control" placeholder="Gate" value="<?=$arrival_gate?>">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="arrival_terminal" id="arrival_terminal" class="form-control" placeholder="Terminal" value="<?=$arrival_terminal?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Aircraft</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="aircraft" class="col-sm-2 col-form-label">Aircraft</label>
                        <div class="col-sm-4">
                            <input type="text" name="aircraft" id="aircraft" class="form-control" value="<?=$aircraft?>">
                        </div>
                        <label for="fareclass" class="col-sm-2 col-form-label" style="text-align: right;">Fare Class</label>
                        <div class="col-sm-4">
                            <input type="text" name="fareclass" id="fareclass" class="form-control" value="<?=$fareclass?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="seat_number" class="col-sm-2 col-form-label">Seat number</label>
                        <div class="col-sm-4">
                            <input type="text" name="seat_number" id="seat_number" class="form-control"  value="<?=$seat_number?>">
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <label for="flightMeal_input" class="col-sm-2 col-form-label">Meal</label>
                        <div class="col-sm-4">
                            <input type="text" name="meal" id="flightMeal_input" class="form-control">
                        </div>
                        <label for="flightEntertainment_input" class="col-sm-2 col-form-label">Entertainment</label>
                        <div class="col-sm-4">
                            <input type="text" name="class" id="flightEntertainment_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="flightDistance_input" class="col-sm-2 col-form-label">Distance in KM</label>
                        <div class="col-sm-4">
                            <input type="text" name="class" id="flightDistance_input" class="form-control">
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="cost" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-4">
                            <input type="text" name="cost" id="cost" class="form-control cost-input" value="<?=$cost?>">
                        </div>
                        <label for="mileage_used" class="col-sm-2 col-form-label" style="text-align: right;">Mileages Used</label>
                        <div class="col-sm-4">
                            <input type="text" name="mileage_used" id="mileage_used" class="form-control" value="<?=$mileage_used?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="extra_cost" class="col-sm-2 col-form-label">Extra Cost ($)</label>
                        <div class="col-sm-4">
                            <input type="text" name="extra_cost" id="extra_cost" class="form-control cost-input" value="<?=$extra_cost?>">
                        </div>
                    </div>
            
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0  flightFormErrorMessage"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button"  class="btn btn-primary flightFormSubmitBtn"><i class="bi bi-send"></i> Save</button>
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
                <h5 class="card-title">Manage Flight</h5>
                <form name="flight_form" id="flight_form" class="needs-validation">
                    <!-- <input type="hidden" id="manageFlightFormStatus" value="0" /> -->
                    <input type="hidden" id="trip_id" name="trip_id" value="<?=$trip_id?>" />
                    <input type="hidden" name="plan_type" value="3" />
                    <input type="hidden" name="id" value="0" />
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="manageFlightTravelersID_select">Travelers<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2multiple form-control" name="travelers_id[]" id="flight_travelers_id" multiple="multiple" data-placeholder="Select Traveler(s)">
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
                            <!-- <i class="fa fa-plus btn btn-primary d-flex align-items-center ms-2 quick-add-traveler" title="Quick Add Traveler"></i> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="flight_number">Flight Number<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" name="flight_number" id="flight_number" class="form-control">
                                <span class="btn btn-primary input-group-text bg-dangerfw-bold" title="Search Flight" id="searchFlightApi"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="address">Destination<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="city_id" id="address"  data-placeholder="Select Destination">
                            <option value='-1'>Select Destination</option>

                            <?php
                                    if(isset($allCities)){
                                    foreach($allCities as $city){
                                ?>

                                    <option value="<?=$city['id']?>"
                                       
                                    >
                                        <?=$city['city']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="airline_id">Airline<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="airline_id" id="airline_id" data-placeholder="Select Airline">
                            <option value='-1'>Select Airline</option>

                            <?php
                                    if(isset($airlines)){
                                    foreach($airlines as $airline){
                                ?>

                                    <option value="<?=$airline['id']?>" airline_name="<?=$airline['name']?>"
                                    >
                                        <?=$airline['name']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="airline_name" id="airline_name" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="confirmation" class="col-sm-2 col-form-label">Confirmation<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="confirmation" id="confirmation" class="form-control">
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Seat(s)</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser1_input">User 1</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser1" id="flightSeatForUser1_input" class="form-control">
                        </div>
                        <div class="col-12 mb-2"></div>
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser2_input">User 2</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser2" id="flightSeatForUser2_input" class="form-control">
                        </div>
                        <div class="col-12 mb-2"></div>
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser3_input">User 3</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser3" id="flightSeatForUser3_input" class="form-control">
                        </div>
                        <div class="col-12 mb-2"></div>
                        <label class="col-sm-2 col-form-label" for="flightSeatForUser4_input">User 4</label>
                        <div class="col-sm-1">
                            <input type="text" name="seatForUser4" id="flightSeatForUser4_input" class="form-control">
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Departure Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="starting_date">Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_date" id="starting_date" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="starting_time" id="starting_time" class="form-control timepicker" placeholder="Starting time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset starting Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="departure_airport_id">Airport<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="departure_airport_id" id="departure_airport_id"  data-placeholder="Select Airport">
                            <option value='-1'>Select Airport</option>

                            <?php
                                if(isset($airports)){
                                    foreach($airports as $airport){
                                ?>

                                    <option value="<?=$airport['id']?>" departure_airport_name="<?=$airport['name']?>" departure_airport_code="<?=$airport['iata_code']?>"
                                  
                                    >
                                        <?=$airport['name']?>
                                    </option>
                                
                                <?php

                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="departure_airport_name" id="departure_airport_name" value="">
                            <input type="hidden" name="departure_airport_code" id="departure_airport_code" value="">

                            <!-- <i class="fa fa-plus btn btn-primary d-flex align-items-center ms-2 quick-add-traveler" title="Quick Add Traveler"></i> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="departure_gate">Gate and Terminal</label>
                        <div class="col-sm-5">
                            <input type="text" name="departure_gate" id="departure_gate" class="form-control" placeholder="Gate">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="departure_terminal" id="departure_terminal" class="form-control" placeholder="Terminal">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Arrival Information</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="ending_date">Date<i class="text-danger">*</i></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_date" id="ending_date" class="form-control datepicker">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Date"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="ending_time" id="ending_time" class="form-control timepicker" placeholder="Ending Time">
                                <span class="btn btn-danger input-group-text bg-dangerfw-bold resetStartingTime" title="Reset Ending Time"><i class="bi bi-x-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="arrival_airport_id">Airport<i class="text-danger">*</i></label>
                        <div class="col-sm-10 d-flex justify-content-between">
                            <select class="select2single form-control" name="arrival_airport_id" id="arrival_airport_id"  data-placeholder="Select Airport">
                            <option value='-1'>Select Airport</option>

                                <?php
                                    if(isset($airports)){
                                        foreach($airports as $airport){
                                ?>

                                        <option value="<?=$airport['id']?>" arrival_airport_name="<?=$airport['name']?>" arrival_airport_code="<?=$airport['iata_code']?>"
                                           
                                        >
                                            <?=$airport['name']?>
                                        </option>
                                    
                                <?php

                                        }
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="arrival_airport_name" id="arrival_airport_name" value="">
                            <input type="hidden" name="arrival_airport_code" id="arrival_airport_code" value="">
                            <!-- <i class="fa fa-plus btn btn-primary d-flex align-items-center ms-2 quick-add-traveler" title="Quick Add Traveler"></i> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="arrival_gate">Gate and Terminal</label>
                        <div class="col-sm-5">
                            <input type="text" name="arrival_gate" id="arrival_gate" class="form-control" placeholder="Gate">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="arrival_terminal" id="arrival_terminal" class="form-control" placeholder="Terminal">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Aircraft</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="aircraft" class="col-sm-2 col-form-label">Aircraft</label>
                        <div class="col-sm-4">
                            <input type="text" name="aircraft" id="aircraft" class="form-control">
                        </div>
                        <label for="fareclass" class="col-sm-2 col-form-label" style="text-align: right;">Fare Class</label>
                        <div class="col-sm-4">
                            <input type="text" name="fareclass" id="fareclass" class="form-control">
                        </div>
                      
                    </div>
                    <div class="row mb-3">
                        <label for="seat_number" class="col-sm-2 col-form-label">Seat number</label>
                        <div class="col-sm-4">
                            <input type="text" name="seat_number" id="seat_number" class="form-control">
                        </div>
                    </div>

                    <!-- <div class="row mb-3">
                        <label for="flightMeal_input" class="col-sm-2 col-form-label">Meal</label>
                        <div class="col-sm-4">
                            <input type="text" name="meal" id="flightMeal_input" class="form-control">
                        </div>
                        <label for="flightEntertainment_input" class="col-sm-2 col-form-label">Entertainment</label>
                        <div class="col-sm-4">
                            <input type="text" name="class" id="flightEntertainment_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="flightDistance_input" class="col-sm-2 col-form-label">Distance in KM</label>
                        <div class="col-sm-4">
                            <input type="text" name="class" id="flightDistance_input" class="form-control">
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="m-0 fw-bold">Payment Information</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="cost" class="col-sm-2 col-form-label">Cost ($)</label>
                        <div class="col-sm-4">
                            <input type="text" name="cost" id="cost" class="form-control cost-input">
                        </div>
                        <label for="mileage_used" class="col-sm-2 col-form-label" style="text-align: right;">Mileages Used</label>
                        <div class="col-sm-4">
                            <input type="text" name="mileage_used" id="mileage_used" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="extra_cost" class="col-sm-2 col-form-label">Extra Cost ($)</label>
                        <div class="col-sm-4">
                            <input type="text" name="extra_cost" id="extra_cost" class="form-control cost-input">
                        </div>
                    </div>
                  
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0  flightFormErrorMessage"  style="margin-right:5px;align-content: center;" ></p>
                            <button type="button" class="btn btn-danger formCancelBtn" style="margin-right:5px;">Cancel</button>
                            <button type="button"  class="btn btn-primary flightFormSubmitBtn"><i class="bi bi-send"></i> Save</button>
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