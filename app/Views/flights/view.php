<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-12 plan_detail_container" id="flight_detail_container">
    <div class="d-flex justify-content-between">
        <h3 class="fw-bold m-0">From BEY TO DXB</h3>
        <div class="d-flex align-items-center">
            <a href="<?php echo base_url() . 'flights/edit?planID=1' ?>"><button class="btn btn-primary ms-2"><i class="bi bi-pen-fill"></i> Edit</button></a>
            <a><button class="btn btn-danger ms-2"><i class="bi bi-trash3-fill"></i> Delete</button></a>
        </div>
    </div>
    <p class="m-0">Confirmation <span class="fw-bold">C12345</span> | Flight Number <span class="fw-bold">MEA123</span></p>
    <ul class="userLists unstyled-list p-0 m-0">
        <li class="d-flex align-items-center"><i class="bi bi-person-fill"></i> User 2 | <img src="<?= base_url('/public/assets/images/icons/seat.png') ?>" class="mx-1" title="User 1's Seat" style="width:15px; height:auto;" /> B1</li>
        <li class="d-flex align-items-center"><i class="bi bi-person-fill"></i> User 2 | <img src="<?= base_url('/public/assets/images/icons/seat.png') ?>" class="mx-1" title="User 2's Seat" style="width:15px; height:auto;" /> B6</li>
        <li class="d-flex align-items-center"><i class="bi bi-person-fill"></i> User 3 | <img src="<?= base_url('/public/assets/images/icons/seat.png') ?>" class="mx-1" title="User 3's Seat" style="width:15px; height:auto;" /> A6</li>
    </ul>
    <div class="card p-3 w-100">
        <h4 class="fw-bold">Primary Details</h4>
        <div class="d-flex details_container">
            <div class="primary_details d-flex flex-column w-75">
                <div class="departure-circle-icon"></div>
                <div class="deparuter_details">
                    <p class="m-0">Depart Fri, Nov 1, 2024</p>
                    <h4>12:00 PM</h4>
                    <ul class="list-unstyled">
                        <li><span class="location" title="Google Map"><i class="bi bi-geo-alt-fill"></i> Address 123, Street 123</li></span>
                        <li><a href=""><i class="fa-solid fa-person-walking-luggage"></i> Terminal E | Gate 12</a></li>
                    </ul>
                </div>
                <i class="bi bi-geo-alt-fill arrival-circle-icon"></i>
                <div class="arrival_details">
                    <p class="m-0">Arrival Sat, Nov 2, 2024</p>
                    <h4>12:00 PM</h4>
                    <ul class="list-unstyled">
                        <li><span class="location" title="Google Map"><i class="bi bi-geo-alt-fill"></i> Address 123, Street 123</li></span>
                        <li><a href=""><i class="fa-solid fa-person-walking-luggage"></i> Terminal F | Gate 10</a></li>
                    </ul>
                </div>
            </div>
            <div class="secondary_details w-25">
                <h5 class="fw-bold">Secondary Details</h5>
                <ul class="list-unstyled">
                    <li class="fw-bold">Airline : <span class="fw-light">EV</span></li>
                    <li class="fw-bold">Air Craft : <span class="fw-light">Toyota Rav4 White</span></li>
                    <li class="fw-bold">Fare Class : <span class="fw-light">Toyota Rav4 White</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-12 my-5">
    <table class="datatable" id="tripFiles_datatable">
        <thead>
            <tr>
                <th>Actions</th>
                <th>Attachment Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <i title="Edit File Name" class="bi bi-pen-fill tripAttachment_editIcon lime" attachmentID="" fileID="">
                    </i>
                    <i title="Delete File" href="javascript:void(0);" attachmentID="" class="bi bi-trash3-fill text-danger tripAttachment_deletedIcon" data-bs-toggle="modal" data-bs-target="#tripAttachmentDeleteModal">
                    </i>
                </td>
                <td class="pointer tdFileName" fileID="">
                    <a title="Download File" class="tripAttachment_downloadIcon " download="" href="">
                        File 123
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>