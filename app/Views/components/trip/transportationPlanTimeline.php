<?php 
    $startDate = $planData['starting_date'];
    $endDate = $planData['ending_date'];

    if(empty($startDate)){
        $startDate = "";
    }else{
        $startDate = new DateTime($startDate);
        $startDate = $startDate->format('F j, Y');
    }

    
    if(empty($endDate)){
        $endDate = "";
    }else{
        $endDate = new DateTime($endDate);
        $endDate = $endDate->format('F j, Y');
    }

    $startTime = $planData['starting_time'];
    $endTime = $planData['ending_time'];

    if(empty($startTime)){
        $startTime = "";
    }else{
        $startTime = new DateTime($startTime);
        $startTime = $startTime->format('g:i A');
    }
    

    if(empty($endTime)){
        $endTime = "";
    }else{
        $endTime = new DateTime($endTime);
        $endTime = $endTime->format('g:i A');
    }
  

    $address = $planData['address'];
    $dropoff_address = $planData['dropoff_address'];
   
    $phone = $planData['phone'];
    if(empty($phone)){
        $phone = "Unknown";
    }
    $website = $planData['website'];
    if(empty($website)){
        $website = "Unknown";
    }
    $email = $planData['email'];
    if(empty($email)){
        $email = "Unknown";
    }

    $confirmation = $planData['confirmation'];
    $room_description = $planData['room_description'];


    $total_cost = $planData['cost'];
    if(floatval($total_cost)>0){
        $total_cost=number_format(floatval($total_cost),2);
    }

    $car_type = $planData['car_type'];
    
    
    $car_description = $planData['car_description'];
?>

<div class="plan transportation_plan mb-4" style="margin-bottom: 60px !important;">
    <div class="icon_container">
        <i class="bi bi-taxi-front-fill"></i>
    </div>
    <div class="info ms-5 card p-3">
        <div class="d-flex align-items-cener justify-content-between">
            <div>
                <h3 class="title"><?=$planData['name']?></h3>
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

                <i class="bi bi-three-dots-vertical pointer" style="font-size: 25px;" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"></i>
            <?php } ?>
               
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?php echo base_url() . 'plan/edit?id=' . $planData['id']; ?>" title="Edit">
                        <i class="fa-solid fa-pen-to-square editPlanIcon" style="color: var(--blue) !important;"></i> Edit
                    </a>
                    <a class="dropdown-item deletePlanBtn" planId="<?= $planData['id']; ?>" title="Delete">
                        <i class="bi bi-trash3-fill"></i> Delete
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-12 col-lg-12 col-md-12">
            <div class="d-flex align-items-cener justify-content-between mt-2">
                <h4 style="margin: 0 !important;">Pick up</h4>
                <div class="d-flex">
                    <h4 style="margin: 0 !important;"><?=empty($endTime)&&empty($endDate)?'':'Drop off'?></h4>
                </div>
            </div>
            <div class="d-flex align-items-cener justify-content-between ">
                <div>
                    <p style="margin: 0 !important; font-size: 18px;"><?=$startTime?></p>
                    <p style="margin: 0 !important;"><?=$startDate?></p>
                    <?php 
                            if(!empty($address)){
                        ?>
                    <p style="margin: 0 !important; "><i class="bi bi-geo-alt-fill"> </i><?=$address?></p>

                    <?php
                        }
                    ?>
                </div>

                <div class="d-flex">
                    <div style="text-align: right;">
                        <p style="margin: 0 !important; font-size: 18px;"><?=$endTime?></p>
                        <p style="margin: 0 !important; "><?=$endDate?></p>
                        <?php 
                            if(!empty($dropoff_address)){
                        ?>
                        <p style="margin: 0 !important; "><i class="bi bi-geo-alt-fill"> </i><?=$dropoff_address?></p>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
         
            <hr >

            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div>
                    <ul class="userLists unstyled-list p-0 m-0">
                        <li><i class="fa-solid fa-phone"></i> <?=$phone?></li>
                        
                        <?php if(!empty($car_description)){ ?>
                            <li>Description: <?=$car_description?></li>
                        <?php } ?>

                 
                    </ul>
                </div>
                <div class="d-flex">
                    <ul class="userLists unstyled-list p-0 m-0" style="text-align: right;">
                 
                       
                        <?php 
                            if(!empty($confirmation)){
                        ?>
                                <li>Car details: <?=$confirmation?></li>
                        <?php
                            }else{
                                echo'<li></li>';
                            }
                        ?>
                         <?php 
                            if(floatval($total_cost)>0){
                        ?>
                                <li>Cost: $<?=$total_cost?></li>
                        <?php
                            }else{
                                echo'<li></li>';
                            }
                        ?>
                      
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>