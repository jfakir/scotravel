<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <!-- Start trip banner -->
    <!-- End trip banner -->
    <!-- Start quick report -->
    <div class="col-12 swiper quickReport_swiper" id="tripDashboard_swiper">
        <div class="swiper-wrapper">
            <?= view_cell(
                '\App\Libraries\Trip::dashboardSwiperCard',
                [
                    'cardFormat' => 'blue-card',
                    'title' => 'Travelers',
                    'ammount' => count($users),
                    'icon' => '<i class="bi bi-person"></i>'
                ]
            ) ?>

            <?= view_cell(
                '\App\Libraries\Trip::dashboardSwiperCard',
                [
                    'cardFormat' => 'red-card',
                    'title' => 'Total Cost',
                    'ammount' => '$'.number_format($costs[0]['total_cost'],2),
                    'icon' => '<i class="bi bi-currency-dollar"></i>'
                ]
            ) ?>
            <?= view_cell(
                '\App\Libraries\Trip::dashboardSwiperCard',
                [
                    'cardFormat' => 'purple-card',
                    'title' => 'Total Extra Cost',
                    'ammount' => '$'.number_format($costs[0]['total_extra_cost'],2),
                    'icon' => '<i class="bi bi-suitcase-fill"></i>'
                ]
            ) ?>
            <?= view_cell(
                '\App\Libraries\Trip::dashboardSwiperCard',
                [
                    'cardFormat' => 'green-card',
                    'title' => 'Total Mileages Used',
                    'ammount' => number_format($costs[0]['total_mileage_used'],2),
                    'icon' => '<i class="bi bi-airplane"></i>'
                ]
            ) ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- End quick report -->

    <!-- Start menu buttons -->
    <div class="col-12 mb-3 d-flex align-items-center">
        <?php if($isTripAdmin){?>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectPlans_modal"><i class="fa-solid fa-plus"></i> Add Plan</button>
        <?php }?>

        <div class="modal fade" id="selectPlans_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select a plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <a href="<?php echo base_url() . 'flights/manage' ?>" class="plan flight_plan rounded"><i class="fas fa-solid fa-plane-departure"></i> Flight</a>
                        <a href="<?php echo base_url() . 'lodgings/manage' ?>" class="plan lodging_plan rounded"><i class="bi bi-house-fill"></i> Lodging</a>
                        <a href="<?php echo base_url() . 'carrentings/manage' ?>" class="plan carRenting_plan rounded"><i class="bi bi-car-front"></i> Car Renting</a>
                        <a href="<?php echo base_url() . 'restaurants/manage' ?>" class="plan restaurant_plan rounded"><i class="fas fa-solid fa-utensils"></i> Restaurant</a>
                        <a href="<?php echo base_url() . 'activities/manage' ?>" class="plan activity_plan rounded"><i class="bi bi-brightness-high-fill"></i> Activity</a>
                        <a href="<?php echo base_url() . 'transportations/manage' ?>" class="plan transportation_plan rounded"><i class="fa fa-taxi"></i> Transportation</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <button class="btn btn-primary ms-2"><i class="bi bi-filetype-pdf"></i> PDF</button> -->
    </div>
    <!-- End menu buttons -->

    <!-- Start timeline -->
    <div class="col-12 col-xl-12 col-lg-12 col-md-12 mb-5" id="timeline_container">
        <div class="plans">

        <?php 
            for ($i = 0; $i < count($plans); $i++) {
                if (intval($plans[$i]['plan_type']) == 3) {
                    if($plans[$i]['is_layover'] && !empty($plans[$i]['starting_date']) && !empty($plans[$i]['starting_time']) && !empty($plans[$i-1]['ending_date']) && !empty($plans[$i-1]['ending_time']) ){
                        echo view_cell('\App\Libraries\Trip::layoverSeparator', [
                            'planData' => $plans[$i],
                            'previousPlanData' => $plans[$i-1],
                            'isAdmin'=>$isTripAdmin

                        ]);
                    }
                    
                    if($i !== count($plans)-1){
                        $nextPlan = $plans[$i+1];
                    }else{
                        $nextPlan['is_layover']=false;
                    }
                    if($i !== 0){
                        $previousPlan = $plans[$i-1];
                    }else{
                        $previousPlan['is_layover']=false;
                    }

                    echo view_cell('\App\Libraries\Trip::flightPlanTimeline', [
                        'planData' => $plans[$i],
                        'planIndex' => $i,
                        'plansLength'=> count($plans),
                        'nextPlanData'=> $nextPlan,
                        'previousPlanData'=> $previousPlan,
                        'isAdmin'=> $isTripAdmin,
                    ]);
                }
                
                else if(intval($plans[$i]['plan_type']) == 1){
                    echo view_cell('\App\Libraries\Trip::activityPlanTimeline', [
                        'planData' => $plans[$i],
                        'isAdmin'=>$isTripAdmin

                    ]);
                }

                else if(intval($plans[$i]['plan_type']) == 2){
                    echo view_cell('\App\Libraries\Trip::carRentingPlanTimeline', [
                        'planData' => $plans[$i],
                        'isAdmin'=>$isTripAdmin

                    ]);
                }

                else if(intval($plans[$i]['plan_type']) == 4){
                    echo view_cell('\App\Libraries\Trip::lodgingPlanTimeline', [
                        'planData' => $plans[$i],
                        'isAdmin'=>$isTripAdmin

                    ]);
                }

                else if(intval($plans[$i]['plan_type']) == 5){
                    echo view_cell('\App\Libraries\Trip::restaurantPlanTimeline', [
                        'planData' => $plans[$i],
                        'isAdmin'=>$isTripAdmin

                    ]);
                }

                else if(intval($plans[$i]['plan_type']) == 6){
                    echo view_cell('\App\Libraries\Trip::transportationPlanTimeline', [
                        'planData' => $plans[$i],
                        'isAdmin'=>$isTripAdmin

                    ]);
                }
            }
        ?>



 
        </div>
      
        <!-- Sart plans summary -->
        <!-- <div class="date_separator rounded p-2">
            <p class="m-0">Plans Summary</p>
        </div>
        <div class="mt-2" id="timeline_summary">
            <ul class="list-unstyled">
                <li>Number of travelers : <span class="fw-bold">3</span></li>
                <li>Total days : <span class="fw-bold">24</span></li>
                <li>Number of flights : <span class="fw-bold">3</span></li>
                <li>Car renting : <span class="fw-bold">Yes</span></li>
                <li>Number of stays : <span class="fw-bold">1</span></li>
            </ul>
        </div> -->
        <!-- End plans summary -->
    </div>
    <!-- End timeline -->

    <!-- Start notes -->
    <!-- <div class="col-12 col-xl-4 col-lg-4 col-md-4 mb-5 card" id="tripNotes_container">
        <h5 class="mt-2">Notes : </h5>
        <form action="" id="tripNotes_form">
            <textarea class="form-control" name="manageTripNote" id="manageTripNote" rows="5"></textarea>
            <button class="my-2 btn btn-primary"><i class="bi bi-send-fill"></i> Save</button>
        </form>
        <div class="d-flex flex-column">

        </div>
    </div> -->
    <!-- End notes -->

    <!-- Start attachments -->
    <div class="col-12 mb-5">
        <div class="d-flex" style="flex-direction:row;align-items:center;">
        <?php if($isTripAdmin){ ?>

            <button class="btn btn-primary mb-2" style="z-index: 999;" id="addTripAttachmentBtn"><i class="fa-solid fa-paperclip"></i> Add Attachment</button>
        <?php }?>
          
            <p class="text-danger mb-2" style="margin-left:5px;" id="addTripAttachmentBtn_errorMsg"></p>
        </div>
        <input type="file" name="tripAttachment" id="tripAttachment" class="displayNone"/>

        <table class="datatable" id="tripFiles_datatable">
            <thead>
                <tr>
        <?php if($isTripAdmin){?>
                    
                    <th>Actions</th>
        <?php }?>

                    <th>Attachment Name</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                          if(isset($attachments)){
                            foreach($attachments as $attachment){
                        ?>
                <tr>
        <?php if($isTripAdmin){?>

                    <td>
                        <i title="Edit File Name" class="fa-solid fa-pen-to-square tripAttachment_editIcon pointer" style="color: var(--blue) !important;font-size: 18px;" attach-trip-id="<?=$attachment['trip_id']?>" attach-name="<?=$attachment['name']?>" attach-id="<?=$attachment['id']?>">
                        </i>
                        <i title="Delete File" href="javascript:void(0);" attachmentID="" class="bi bi-trash3-fill text-danger tripAttachment_deleteIcon pointer"attach-name="<?=$attachment['name']?>" attach-id="<?=$attachment['id']?>">
                        </i>
                    </td>
        <?php }?>

                    <td class="pointer tdFileName" fileID="">
                        
                        <a title="Download File" class="tripAttachment_downloadIcon" href="<?php echo base_url('trips/downloadAttachment?id='.$attachment['id'].'&extension='.$attachment['extension'].'&name='.$attachment['name']); ?>">

                           <?=$attachment['name']?>
                        </a>
                      
                    </td>
                </tr>
                <?php 
                            }
                        }
                        ?>
            </tbody>
        </table>
    </div>
    <!-- End attachments -->

    <!-- Start users Modal -->
<div class="modal fade" id="tripTravelersModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Travelers Roles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <div class="row">
                    <!-- <label class="col-sm-3 col-form-label m-0">Travelers</label> -->
                    <?php
                            if(isset($users)){
                                foreach($users as $user){
                                
                        ?>
                    <div class="col-sm-9" style="padding-top: 7px; padding-bottom: 7px;">
                            <div style="flex-direction: row; display: flex; align-items: center;">
                                <div class="tripTravlersModalIconDiv<?=$user['id']?>">
                                <?php
                                    if($user['is_admin']==1){
                                ?>
                                <?php if($isTripAdmin){ ?>

                                    <i class="bi bi-three-dots-vertical pointer" style="font-size: 22px" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"></i>
                                <?php } ?>
                                   
                                    <div class="dropdown-menu pointer tripTravelersDismissAsOrganizerIcon" trip-user-id="<?=$user['id']?>" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" >
                                            <i class="fas fa-user-times pointer " style="color: var(--blue) !important;"></i> Dismiss as organizer
                                        </a>
                                    </div>
                                <?php   
                                    }else{
                                ?>
                                     <i class="bi bi-three-dots-vertical pointer" style="font-size: 22px" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"></i>
                                    <div class="dropdown-menu pointer tripTravelersMakeOrganizerIcon" trip-user-id="<?=$user['id']?>"  aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" >
                                            <i class="fas fa-user-shield pointer "  style="color: var(--blue) !important;"></i> Make organizer
                                        </a>
                                    </div>
                                <?php
                                    }
                                ?>
                                </div>
                                <p class="d-flex align-items-center m-0"><?=$user['fname'].' '.$user['lname']?></p>
                            </div>

                       
                    </div>
                    <div class="col-sm-3 <?="tripTravelerAccess".$user['id']?>" style="padding-top: 7px; padding-bottom: 7px; display:flex; align-items:center; " >
                        <?php
                       
                            if($user['is_admin']==1){
                        ?>
                                <p class="d-flex align-items-center m-0 text-primary">Organizer</p>
                        <?php
                            }
                        ?>
                                   
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

 <!-- Start users Modal -->
<div class="modal fade" id="planTravelersModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Travelers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <div class="row">
                    <!-- <label class="col-sm-3 col-form-label m-0">Travelers</label> -->
                    <div class="col-sm-9" id="planTravelersModal_travelersContainer" style="padding-top: 7px; padding-bottom: 7px;">
                    

                        
                    </div>

           

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- trip traveler dismiss organizer -->
<div class="modal fade" id="trip_traveler_dismiss_organizer_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-times pointer"></i> Dismiss as organiezer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="notification_list">
                    <input type="hidden" id="trip_traveler_dismiss_organizer_modal_trip_user_id" />
                    <div class="row">
                        <p style="margin-bottom:0px !important;">Are you sure you want to dismiss this user as organizer?</p>
                    </div>
                    
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger " id="trip_traveler_dismiss_organizer_modal_dismissBtn" data-bs-dismiss="modal" >Dismiss</button>
            </div>
        </div>
    </div>
</div>

 <!-- make trip traveler organizer modal -->
<div class="modal fade" id="trip_traveler_make_organizer_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-shield "></i> Make Organizer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="notification_list">
                    <input type="hidden" id="trip_traveler_make_organizer_modal_trip_user_id" />
                    <div class="row">
                        <p style="margin-bottom:0px !important;">Are you sure you want to make this user organizer?</p>
                    </div>
                    
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary " id="trip_traveler_make_organizer_modal_Btn" data-bs-dismiss="modal" >Yes</button>
            </div>
        </div>
    </div>
</div>
    
</div>

<?= $this->endSection() ?>