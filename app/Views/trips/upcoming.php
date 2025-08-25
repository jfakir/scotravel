<div id="upcomingTripsDiv">
    <?= $this->extend('layouts/main') ?>
    <?= $this->section('content') ?>
    <div class="row">
        <?= view_cell('\App\Libraries\Trip::menuBar',[
                        'allUsers' => $allUsers,
                        'allCompanies' => $allCompanies,
        ]) ?>
    </div>
    <div class="row">
        <!-- Start populating trips -->

        <?php
        if(count($trips)==0){
        ?>
        <div style="display:flex;justify-content:center;"><h2>No Trips Available.</h2></div>
        <?php 
        }else{
           
         for ($i = 0; $i < count($trips); $i++) : ?>
            <?= view_cell('\App\Libraries\Trip::banner',[
                        'tripData' => $trips[$i],
                    ]) ?>
        <?php endfor;} ?>
        <!-- End populating trips -->
    </div>
    <?= $this->endSection() ?>
</div>
