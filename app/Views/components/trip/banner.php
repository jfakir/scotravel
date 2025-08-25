<?php 
    $months = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    // Convert date strings to date objects
    $startDate = new DateTime($tripData->starting_date);

    // Extract components
    $startDay = $startDate->format('j'); // Day without leading zeros
    $startMonth = $startDate->format('n'); // Month number without leading zeros
    $startYear = $startDate->format('Y'); // Year

    if($tripData->ending_date=='0000-00-00'){
        $formattedStartDate = $startDay . ' ' . $months[$startMonth - 1];
        $formattedDate =  "$formattedStartDate $startYear";
    }else{
        $endDate = new DateTime($tripData->ending_date);

        $endDay = $endDate->format('j'); // Day without leading zeros
        $endMonth = $endDate->format('n'); // Month number without leading zeros
        $endYear = $endDate->format('Y'); // Year

        // Format dates
        $formattedStartDate = $startDay . ' ' . $months[$startMonth - 1];
        $formattedEndDate = $endDay . ' ' . $months[$endMonth - 1];

        if ($startYear === $endYear) {
            $formattedDate =  "$formattedStartDate - $formattedEndDate $startYear";
        } else {
            $formattedDate =  "$formattedStartDate $startYear - $formattedEndDate $endYear";
        }

    }

    

    $userArray = explode(',', $tripData->trip_users);
    $adminsArray = explode(',', $tripData->trip_admins);

    // print_r($adminsArray);exit();
    // print_r(session()->user_id);exit();
    if (in_array(session()->user_id, $adminsArray)||session()->access_type==2) {
        $isTripAdmin = true ;
    } else {
        $isTripAdmin = false ;
    }

    $is_round_trip = $tripData->is_round_trip;
?>
<div class="col-12 mb-2">
    <div class="card ps-3" style="flex-direction: row;justify-content: space-between; align-items: center;">
        <div style="padding-top: 10px; padding-bottom: 10px; line-height: 30px;">
            <div >
                <h3 class="card-title pointer" title="Click for more info"><a href="<?php echo base_url() . 'trips/trip?id='.base64_encode($tripData->id)?>"><?=$tripData->name?></a></h3>
                <!-- <p class="my-0" title="Tenant Name"><i class="bi bi-buildings-fill"></i> Sconet SAL</p> -->
                <p class="my-0" title="Destination"><i class="bi bi-geo-alt-fill"></i> <?=$tripData->destination_city?></a></p>
                <p class="my-0" title="Date and duration"><i class="bi bi-calendar-event-fill"></i> <?=$formattedDate?> <?=$is_round_trip==1?"<i class='bi bi-arrow-repeat' title='Round trip'></i>":"<i class='fa-solid fa-turn-up' title='One way trip' style='font-size: 14px;'></i>"?></p>
                <ul class="userLists unstyled-list p-0 m-0">
                    <?php if(count($userArray)<=3){
                            for($i=0;$i < count($userArray); $i++){
                    ?>
                                <li><i class="bi bi-person-fill"></i><?= $userArray[$i]?></li>
                    <?php   }
                        }else{
                            for($i=0;$i < 3; $i++){
                    ?>
                
                                <li><i class="bi bi-person-fill"></i><?= $userArray[$i]?></li>
                    <?php
                            }
                    ?>

                        <ul class="unstyled-list p-0 m-0 additional-users" style="display: none;">
                            <?php   
                                for($i=3;$i < count($userArray); $i++){
                            ?>
                        
                                <li><i class="bi bi-person-fill"></i><?= $userArray[$i]?></li>
                            <?php
                                }
                            ?>
                        </ul>
                        <li><a class="showHideAllUsersLists pointer" style="display: none;">Show All Users</a></li>


                    <?php
                        }
                    ?>
                </ul>
            </div>
            <?php if($isTripAdmin){ ?>
                <div class="" style="margin-top: 10px;">
                    <a href="<?php echo base_url() . 'trips/editTrip?id='.base64_encode($tripData->id) ?>"><button class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Edit</button></a>
                    <button class="btn btn-danger ms-2 deleteTripBtn" tripId="<?=$tripData->id?>"><i class="bi bi-trash3-fill"></i> Delete</button>
                </div>
            <?php } ?>


         
   

        </div>
        <img style="width: 350px; height: auto;max-height:223px; object-fit: cover; border-radius: 5px;" src="<?php if(isset($tripData->image_url)&&!empty($tripData->image_url)){echo($tripData->image_url);}else{echo"https://images.unsplash.com/photo-1510623425998-4894a2ad0da9?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NDg2NzF8MHwxfHNlYXJjaHwxfHxIb3VzdG9ufGVufDB8fHx8MTcxNjU3MjI1MHww&ixlib=rb-4.0.3&q=80&w=1080";}?>" alt="Trip name">
    </div>
</div>
