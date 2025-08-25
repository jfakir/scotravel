<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-12 plan_detail_container" id="transportation_detail_container">
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <h3 class="fw-bold m-0">Transportation Agency</h3>
            <!-- <i class="bi bi-google ms-2"></i> -->
            <img src="<?= base_url('/public/assets/images/icons/google.svg') ?>" alt="" class="ms-2 pointer" title="Google it" style="width:25px; height:auto;" />
        </div>
        <div class="d-flex align-items-center">
            <!-- <button class="btn btn-success ">
                <i class="bi bi-whatsapp"></i>
                WhatssApp
            </button>
            <button class="btn btn-dark ms-2">
                <i class="fa-brands fa-uber pointer "></i>
                Uber
            </button> -->
            <a href="<?php echo base_url() . 'transportating/edit?' ?>"><button class="btn btn-primary ms-2"><i class="bi bi-pen-fill"></i> Edit</button></a>
            <a><button class="btn btn-danger ms-2"><i class="bi bi-trash3-fill"></i> Delete</button></a>
        </div>
    </div>
    <p class="m-0">Transportation | Confirmation <span class="fw-bold">C12345</span></p>
    <ul class="userLists unstyled-list p-0 m-0">
        <li><i class="bi bi-person-fill"></i> User 1</li>
        <li><i class="bi bi-person-fill"></i> User 2</li>
        <li><i class="bi bi-person-fill"></i> User 3</li>
    </ul>
    <div class="card p-3 w-100">
        <h4 class="fw-bold">Primary Details</h4>
        <div class="d-flex">
            <div class="primary_details w-75">
                <div class="d-flex">
                    <div class="me-3">
                        <p class="m-0">Pickup Fri, Nov 1, 2024</p>
                        <h4>12:00 PM</h4>
                    </div>
                    <div>
                        <p class="m-0">Drop-off Sat, Nov 2, 2024</p>
                        <h4>12:00 PM</h4>
                    </div>
                </div>
                <ul class="list-unstyled">
                    <li>Pickup Address <span class="location" title="Google Map"><i class="bi bi-geo-alt-fill"></i> Address 123, Street 123</li></span>
                    <li>Drop-off Address <span class="location" title="Google Map"><i class="bi bi-geo-alt-fill"></i> Address 123, Street 123</li></span>
                    <li><a href=""><i class="bi bi-telephone-fill"></i> +9611122336644</a></li>
                </ul>
            </div>
            <div class="secondary_details w-25">
                <h5 class="fw-bold">Secondary Details</h5>
                <ul class="list-unstyled">
                    <li class="fw-bold">Car Description : <span class="fw-light">Toyota Rav4 White</span></li>
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