<div class="swiper-slide card blue-card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="card-title"><?= $accountName ?></h5>
            <div>
                <i class="bi bi-pen-fill lime pointer mileageAccountEditIcon" account_id="<?=$account_id?>" airline_id="<?=$airline_id?>" airline_name="<?=$airline?>" account-name="<?=$accountName?>" title="Edit Mileage Account"></i>
                <i class="bi bi-trash3-fill text-danger pointer mileageAccountDeleteIcon"  account_id="<?=$account_id?>"  title="Delete Mileage Account" data-bs-toggle="modal" data-bs-target="#delete_modal"></i>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-airplane-fill"></i>
            </div>
            <div class="ps-3">
                <!-- <h6>$mileage Points</h6>   -->
                <span><?= $airline ?></span>
            </div>
        </div>
    </div>
</div>