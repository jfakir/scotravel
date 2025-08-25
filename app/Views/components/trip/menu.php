<?php
    if(isset($filterFromDate) && $filterFromDate != -1){

        $filterFromDate = new DateTime($filterFromDate);
        $filterFromDate = $filterFromDate->format('m/d/Y');

    }

    if(isset($filterToDate) && $filterToDate != -1){

        $filterToDate = new DateTime($filterToDate);
        $filterToDate = $filterToDate->format('m/d/Y');

    }



?>

<!-- Start menu bar buttons -->
<div class="col-12 carousel slide">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('/public/assets/images/carousels/carousel1.jpg') ?>" alt="" class="rounded d-block w-100">
            <div class="overlay rounded">
                <div class="carousel-content">
                    <h3>Welcome To ScoTravel</h3>
                    <p>Where you can safely manage your trip !</p>
                    <a href="<?php echo site_url() . 'trips/manage' ?>"><button class="btn btn-primary" style="font-size: 18px;"><i class="fa-solid fa-plus"></i> Create Trip</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-8 m-auto rounded shadow" id="filter_wraper" >
    <div class="d-flex justify-content-between align-items center">
        <h3 class="fw-bold w-100 m-0" style="font-size: 22px !important;align-items: center; display: flex;"><?= $page_title ?></h3>
        <div class="filter d-flex align-items-center">
            <a id="tripFilter_button" class="icon pointer" data-bs-toggle="collapse" data-bs-target="#tripFilter_section" aria-expanded="false" aria-controls="tripFilter_section" title="Open filter">
                <span class="bi bi-sort-down"></span>
            </a>
            <!-- <a href="<?php echo site_url() . 'trips/upcoming' ?>" id="tripClearFilter_button" class="icon text-danger ms-2" title="Clear filters"><i class="bi bi-x-octagon"></i></a> -->
            <!-- <i class="bi bi-x-octagon icon text-danger ms-2" id="tripClearFilter_button" title="Clear filters"></i> -->
        </div>
    </div>
    <div class="collapse rounded" id="tripFilter_section">
        <div class="d-flex flex-column justify-content-center">
            
            <div class="row">
                <div class="col-md-6 mb-1">
                    <label for="filterTrips_FromDate">From date</label>
                    <input type="text" id="filterTrips_FromDate" class="form-control datepicker" placeholder="Select from date"
                        value="<?php if($filterFromDate  != -1 ){echo($filterFromDate);}?>">
                </div>
                <div class="col-md-6 mb-1">
                    <label for="filterTrips_ToDate">To date</label>
                    <input type="text" id="filterTrips_ToDate" class="form-control datepicker" placeholder="Select to date"
                        value="<?php if($filterToDate  != -1 ){echo($filterToDate);}?>">
                </div>
            </div>

            <div class="mb-1">
                <label for="filterTrips_ByTenants">By Tenants</label>
                <select class="select2 select2multiple form-control" id="filterTrips_ByTenants" multiple="multiple" data-placeholder="All Tenants">
                    <?php
                    if(isset($allCompanies)){
                        foreach($allCompanies as $company){
                    ?>

                        <option value="<?=$company['id']?>"
                            <?php
                                if( $filterbyTenants != -1){
                                    foreach ($filterbyTenants as $tenantId) {
                                        if($company['id']==$tenantId){
                                            echo "selected";
                                        }
                                    }
                                }
                            ?>
                        >
                            <?=$company['name']?>
                        </option>
                     
                    <?php

                        }
                    }
                    ?>
                </select>
            </div>
            <?php if($businessAndNotAdmin){ ?>
                <div id="filterTrips_ByTravelersDiv" class="mb-1">
                    <label for="filterTrips_ByTravelers">By Travelers</label>
                    <select class="select2 select2multiple form-control"  id="filterTrips_ByTravelers" multiple="multiple" data-placeholder="All Travelers">
                        <?php
                            if(isset($allUsers)){
                                foreach($allUsers as $user){
                        ?>

                            <option value="<?=$user['user_id']?>" 
                                <?php
                                    if( $filterbyTravelers != -1){
                                        foreach ($filterbyTravelers as $travelerId) {
                                            if($user['user_id']==$travelerId){
                                                echo "selected";
                                            }
                                        }
                                    }
                                ?>
                            >
                                <?=$user['fname'].' '.$user['lname']?>
                            </option>
                        
                        <?php

                            }
                        }
                        ?>
                    </select>
                </div>
            <?php }else{ ?>
                <div id="filterTrips_ByTravelersDiv" class="mb-1">
                    <label for="filterTrips_ByTravelers">By Travelers</label>
                    <select class="select2 select2multiple form-control"  id="filterTrips_ByTravelers" multiple="multiple" data-placeholder="All Travelers">
                        <?php
                            if(isset($allUsers)){
                                foreach($allUsers as $user){
                        ?>

                            <option value="<?=$user['id']?>" 
                                <?php
                                    if( $filterbyTravelers != -1){
                                        foreach ($filterbyTravelers as $travelerId) {
                                            if($user['id']==$travelerId){
                                                echo "selected";
                                            }
                                        }
                                    }
                                ?>
                            >
                                <?=$user['fname'].' '.$user['lname']?>
                            </option>
                        
                        <?php

                            }
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>

            
     
            <div class="mb-1  justify-content-end" style="display:flex;" >
                 <button type="button" class="btn btn-danger "  id="filterTrips_clearBtn" style="margin-right:5px !important;"> Clear</button>

                <button type="button" class="btn btn-primary" id="filterTrips_submitBtn"> Filter</button>
            </div>

            
        </div>
    </div>
</div>

<!-- End menu bar buttons -->