
<?php 

    $startDate = $planData['starting_date'];
    $previousEndDate = $previousPlanData['ending_date'];
    $startTime = $planData['starting_time'];
    $previousEndTime = $previousPlanData['ending_time'];

    // Combine date and time for accurate calculation
    $startDateTime = new DateTime("$startDate $startTime");
    $previousEndDateTime = new DateTime("$previousEndDate $previousEndTime");




     // Calculate the difference
    $interval = $startDateTime->diff($previousEndDateTime);

    // Calculate the total hours and minutes
    $totalHours = $interval->h + ($interval->days * 24);
    $totalMinutes = $interval->i;

    // Format the difference
    $formattedTimeDifference = $totalHours . ':' . str_pad($totalMinutes, 2, '0', STR_PAD_LEFT) . 'h';
    

?>


<div class="plan flight_plan mb-2">
    <div class="icon_container" style="color:#5d8ee6 !important;">
        <!-- <i class="fas fa-solid fa-plane-departure"></i> -->
        <i class="fas fa-clock"></i>

    </div>
    <div class="info ms-5 " style="justify-content:center;display:flex;">
        <div class="d-flex align-items-cener justify-content-between">
                <div>
                    <h3 class="title" style="color:#5d8ee6 !important;">Layover: <?=$formattedTimeDifference?></h3>
                </div>
        </div>
    </div>
</div>