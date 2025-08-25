<div class="swiper-slide card <?= $cardFormat ?>">
    <div class="card-body">
        <h5 class="card-title"><?= $title ?></h5>
        
        <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <?= $icon ?>
            </div>
            <div class="ps-3">
                <div style="display:flex;">
                <h6 style="margin-right:10px;"><?= $ammount ?></h6>
                <?php
                    if($title=='Travelers'){
                        echo '
                            <button type="button" class="btn btn-primary" id="viewAllTripTravelersBtn">View all</button>
                        ';
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>