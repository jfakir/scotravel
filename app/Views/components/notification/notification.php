<div class="mb-1">

    <div class="d-flex justify-content-between">
        <p class="m-0 fw-bold" style="   word-wrap: break-word; word-break: break-all;white-space: normal; "><?=$title?></p>
        <div>
            <i class="fa-solid fa-pen-to-square  pointer editNotificationIcon" style="color: var(--blue) !important;" title="Edit Notification" notification-id="<?=$id?>"></i>
                <input type="hidden" class="notificationIdHiddenInput" value="<?=$id?>">
                <input type="hidden" class="notificationTitleHiddenInput" value="<?=$title?>">
                <input type="hidden" class="notificationDescriptionHiddenInput" value="<?=$description?>">
                <input type="hidden" class="notificationIsRedeemedHiddenInput" value="<?=$is_redeemed?>">
            <i class="bi bi-trash3-fill text-danger pointer deleteNotificationIcon" title="Delete Notification"  notification-id="<?=$id?>"></i>
        </div>
    </div>
    <!-- <p class="m-0 text-muted">Dec12,2023</p> -->
    <p class="m-0" style="   word-wrap: break-word; word-break: break-all;white-space: normal; " ><?=$description?></p>
</div>