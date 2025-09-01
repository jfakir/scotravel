
<?php 

    $startDate = $planData['starting_date'];
    $endDate = $planData['ending_date'];

    $startDate = new DateTime($startDate);
    $startDate = $startDate->format('F j, Y');

    $endDate = new DateTime($endDate);
    $endDate = $endDate->format('F j, Y');

    $startTime = $planData['starting_time'];
    $endTime = $planData['ending_time'];

    $startTime = new DateTime($startTime);
    $startTime = $startTime->format('g:i A');

    $endTime = new DateTime($endTime);
    $endTime = $endTime->format('g:i A');

    $departure_airport_code = $planData['departure_airport_code'];
    $departure_airport_name = $planData['departure_airport_name'];
    $airline_name = $planData['airline_name'];
    $arrival_airport_code = $planData['arrival_airport_code'];
    $arrival_airport_name = $planData['arrival_airport_name'];

    $departure_terminal = $planData['departure_terminal'];
    if(empty($departure_terminal)){
        $departure_terminal = "Unknown";
    }

    $departure_gate = $planData['departure_gate'];
    if(empty($departure_gate)){
        $departure_gate = "Unknown";
    }

    $arrival_terminal = $planData['arrival_terminal'];
    if(empty($arrival_terminal)){
        $arrival_terminal = "Unknown";
    }

    $arrival_gate = $planData['arrival_gate'];
    if(empty($arrival_gate)){
        $arrival_gate = "Unknown";
    }

    $aircraft = $planData['aircraft'];
    if(empty($aircraft)){
        $aircraft = "Unknown";
    }

    $seat_number = $planData['seat_number'];
    if(empty($seat_number)){
        $seat_number = "Unknown";
    }
    
    $fareclass = $planData['fareclass'];
    if(empty($fareclass)){
        $fareclass = "Unknown";
    }

    $confirmation = $planData['confirmation'];
    if(empty($confirmation)){
        $confirmation = "Unknown";
    }

    $total_cost = $planData['cost'];
    if(floatval($total_cost)>0){
        $total_cost=number_format(floatval($total_cost),2);
    }

    $total_extra_cost = $planData['extra_cost'];
    if(floatval($total_extra_cost)>0){
        $total_extra_cost=number_format(floatval($total_extra_cost),2);
    }

    $total_mileage_used = $planData['mileage_used'];
    if(floatval($total_mileage_used)>0){
        $total_mileage_used=number_format(floatval($total_mileage_used),2);
    }


?>



<div class="plan flight_plan mb-2 " style="position:relative; <?php if(!$nextPlanData['is_layover']){echo"margin-bottom: 60px !important;";}?>">  

    <?php if(intval($planIndex)!==0 && !(!$planData['is_layover'] && $previousPlanData['is_layover']) && $planData['is_layover']){?>
        <div class="topPlanLine" style="height: 40%; width: 1px; background: #CCC; position: absolute; left: 24px; top: 0;"></div>
    <?php } ?>
    <?php if(($planIndex !== $plansLength-1)&& ( ($planData['is_layover']&& !$nextPlanData['is_layover']) || !$planData['is_layover'] || ($planData['is_layover']&&$nextPlanData['is_layover'])) && !($planData['plan_type']==3 && !$nextPlanData['is_layover']) ){?>

    <div class="bottomPlanLine" style="height: 40%; width: 1px; background: #CCC; position: absolute; left: 24px; bottom: 0;"></div>
    <?php } ?>


        
    <?php if(!($planData['is_layover']&& $nextPlanData['is_layover'])||$planIndex == $plansLength-1){?>

        <div class="middlePlanLine" style="height: 1px; width: 3%; background: #CCC; position: absolute; left: 55px; "></div>

    <?php }?>

    <div class="icon_container">
        <!-- <i class="fas fa-solid fa-plane-departure"></i> -->
        <i class="fa-solid fa-plane"></i>
 
    </div>
    <div class="info ms-5 card  p-3">
        <div class="d-flex align-items-cener justify-content-between">
            <div>

                        <h3 class="title"><a href="https://www.google.com/search?q=<?=$planData['flight_number']?>" target="_blank">Flight <?=$planData['flight_number']?> - Confirmation <?=$confirmation?></a></h3>

                        <?php if(intval($planData['numberOfUsers'])>0){
                        ?>
                            <div class="planTravelersDiv pointer" plan-id="<?=$planData['id']?>"> 
                                <p class="mb-0 planTravelersText mt-1"><i class="bi bi-person me-2" style="font-size: 17px"></i> <?=$planData['numberOfUsers']?></p>
                            </div>
                        <?php }
                        ?>
                </div>

                    <div class="d-flex">
                        <?php if($isAdmin){?>
                            <i class="bi bi-three-dots-vertical pointer plan3DotsIcon" style="font-size: 25px;" id="dropdownMenuButton<?=$planData['id']?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"></i>
                        <?php } ?>
                        <?php if ($planData['numberOfAttachments'] > 0): ?>
                            <div class="plan-item">
                                    <button class="btn btn-sm  view-attachments-btn" style="font-size: 20px;"
                                            data-plan-id="<?= $planData['id']; ?>">
                                        <i class="fa fa-paperclip"></i> 
                                    </button>
                            </div>
                        <?php endif; ?>    
                        <div class="dropdown-menu plan3DotsIcon<?=$planData['id']?>" aria-labelledby="dropdownMenuButton<?=$planData['id']?>">
                            <a class="dropdown-item" href="<?php echo base_url() . 'layovers/manage';?>" title="Edit">
                                <i class="bi bi-plus-circle" style="color: var(--blue) !important;"></i> Add Layover
                            </a>
                            <a title="Add Attachment">
                                <button id="addPlanAttachmentBtn" class="dropdown-item" data-plan-id="<?= $planData['id'] ?>">
                                <i class="fa-solid fa-paperclip" style="color: var(--blue) !important;"></i> Add Attachment
                                </button>
                                <input type="file" name="planAttachment" id="planAttachment" class="displayNone"/>
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url() . 'plan/edit?id=' . $planData['id']; ?>" title="Edit">
                                <i class="fa-solid fa-pen-to-square editPlanIcon" style="color: var(--blue) !important;"></i> Edit
                            </a>
                            <a class="dropdown-item deletePlanBtn" href="#" planId="<?= $planData['id']; ?>" title="Delete">
                                <i class="bi bi-trash3-fill"></i> Delete
                            </a>
                        </div>
                    </div>

            </div>
                

                

        <div class="row">

            <div class="col-3 col-xl-3 col-lg-3 col-md-3">
                <h4 style="margin: 0 !important;">Departure <i class="fa-solid fa-plane-departure" style="color:var(--blue) !important;"></i></h4>
                <p style="margin-top:20px;margin-bottom: 0 !important;"><?=$startDate?></p>
                <p style="margin: 0 !important; font-size: 18px;"><?=$startTime?></p>
                <h3 style="margin-top:20px;margin-bottom: 0 !important; font-weight: 600;"><?=$departure_airport_code?></h3>
                <p style="margin: 0 !important;"><?=$departure_airport_name?></p>
            </div>

            <div class="col-1 col-xl-1 col-lg-1 col-md-1" style="display:flex;align-items:center;">
                <i class="fa-solid fa-arrow-right" style="font-size:24px;color:var(--blue) !important;"></i>
            </div>
            <div class="col-3 col-xl-3 col-lg-3 col-md-3">
                <h4 style="margin: 0 !important;">Arrival <i class="fa-solid fa-plane-arrival" style="color:var(--blue) !important;"></i></h4>
                <p style="margin-top:20px;margin-bottom: 0 !important;"><?=$endDate?></p>
                <p style="margin: 0 !important; font-size: 18px;"><?=$endTime?></p>
                <h3 style="margin-top:20px;margin-bottom: 0 !important; font-weight: 600;"><?=$arrival_airport_code?></h3>
                <p style="margin: 0 !important;"><?=$arrival_airport_name?></p>
            </div>

            <div class="col-1 col-xl-1 col-lg-1 col-md-1" >
            </div>
            
            <div class="col-2 col-xl-2 col-lg-2 col-md-2" style="line-height:27px;">
                <h5 style="margin: 0 !important;">Flight info</h5>
                <!-- <p style="margin-top:20px;margin-bottom: 0 !important; color:gray !important; font-weight: bold;">Flight</p> -->
                <p style="margin-top:20px;margin-bottom: 0 !important; color:gray !important; font-weight: bold;">Airline</p>
                <p style="margin: 0 !important;color:gray !important; font-weight: bold;">Aircraft</p>
                <p style="margin: 0 !important;color:gray !important; font-weight: bold;">Fare Class</p>
                <p style="margin: 0 !important;color:gray !important; font-weight: bold;">Seat</p>
                <p style="margin: 0 !important;color:gray !important; font-weight: bold;">Cost</p>
                <p style="margin: 0 !important;color:gray !important; font-weight: bold;">Extra Cost</p>
                <p style="margin: 0 !important;color:gray !important; font-weight: bold;">Mileage Used</p>
            </div>
            <div class="col-2 col-xl-2 col-lg-2 col-md-2" style="line-height:27px;">
                <!-- <p style="margin-top:44px;margin-bottom: 0 !important; "></p> -->
                <p style="margin-top:44px;margin-bottom: 0 !important; "><?=$airline_name?></p>
                <p style="margin: 0 !important;"><?=$aircraft?></p>
                <p style="margin: 0 !important;"><?=$fareclass?></p>
                <p style="margin: 0 !important;"><?=$seat_number?></p>
                <p style="margin: 0 !important;">$<?=$total_cost?></p>
                <p style="margin: 0 !important;">$<?=$total_extra_cost?></p>
                <p style="margin: 0 !important;"><?=$total_mileage_used?></p>
            </div>

        </div>
           
        <!-- Attachments Modal -->
        <div class="modal fade" id="attachmentsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Plan Attachments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="attachmentsList">
                    <!-- Files will be loaded here -->
                </div>
                </div>
            </div>
        </div>

           
        

    </div>
</div>