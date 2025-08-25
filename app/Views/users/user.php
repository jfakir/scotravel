<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row mb-5">
    <div class="col-2"></div>

    <div class="col-8">
        <div class="card shadow">
            <div class="card-body pt-3">
                <h5 class="card-title">User Detail</h5>
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>
                    <!-- <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active pt-3" id="profile-overview" style="line-height: 40px;">
                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Full Name</div>
                            <div class="col-sm-10 col-md-8"><?=$user['fname'].' '.$user['lname']?></div>
                        </div>

                        <!-- <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Tenant(s)</div>
                            <div class="col-sm-10 col-md-8">Sconet</div>
                        </div> -->

                   

                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Email</div>
                            <div class="col-sm-10 col-md-8"><?=$user['email']?></div>
                        </div>

    

                        <div class="row mb-1">
                            <div class="col-2 fw-bold">Mileage Account(s)</div>
                            <div class="col-10">
                                <button class="btn btn-primary py-0" id="userAddMileageAccountBtn">Add Account</button>
                            </div>
                            <div class="col-12">
                                <div class="col-12 swiper quickReport_swiper">
                                    <div class="swiper-wrapper">
                                        <?php
                                            foreach($mileageAccounts as $account){
                                               echo view_cell(
                                                    '\App\Libraries\User::mileageAccountSwiperCard',
                                                    [
                                                        'accountName' => $account['name'],
                                                        'mileages' => 14000,
                                                        'airline' => $account['airline_name'],
                                                        'account_id' => $account['id'],
                                                        'airline_id' => $account['airline_id'],
                                                    ]
                                                );
                                            };
                                        ?>
                                       
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade pt-3" id="profile-edit">
                        <!-- Start Profile Edit Form -->
                        <form action="users/updateProfile" id="profile_form" method="POST">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">First Name<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input name="fname" type="text" class="form-control" id="fname_profile" value="Jean-Pierre">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lname" class="col-sm-2 col-form-label">Last Name<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input name="lname" type="text" class="form-control" id="lname_profile" value="Chreim">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Phone" class="col-sm-2 col-form-label">Phone<i class="text-danger">*</i></label>
                                <!-- <div class="col-sm-1">
                                    <input name="countryCode" type="text" class="form-control phone-input" id="countryCode_profile" placeholder="Code" value="961">
                                </div> -->
                                <div class="col-sm-10">
                                    <input name="phone" type="tel" class="form-control phone-input" id="user_phone_input" value="71463399">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dateOfBirth_profile" class="col-sm-2 col-form-label">Date Of Birth</label>
                                <div class="col-sm-10">
                                    <input name="date_of_birth" type="text" class="form-control" id="dateOfBirth_profile" value="07/18/1998">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <p class="errorMessage"></p>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="updateProfile_submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- End Profile Edit Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Modal -->
<div class="modal fade" id="manageMileageAccount_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Mileage Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <form name="mileageAccount_form" id="mileageAccount_form" class="needs-validation" >
                    <input type="hidden" name="user_id" value="<?=$user['id']?>" />
                    <input type="hidden" name="id" id="manageMileageAccount_accountId" value="0" />
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="mileageAccountAirlineID_select">Airline<i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <select class="select2single form-control" name="airline_id" id="mileageAccountAirlineID_select" data-dropdown-parent="#manageMileageAccount_modal">
                                <option value="-1" airline_name="" selected>Select Airline</option>
                                <?php
                                    foreach($airlines as $airline){
                                ?>
                                    <option value="<?=$airline['id']?>" airline_name="<?=$airline['name']?>"                                    >
                                        <?=$airline['name']?>
                                    </option>
                                <?php
                                     }
                                ?>
                            </select>
                            <input type="hidden" name="airline_name" id="manageMileageAccount_airlineName" />

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="mileageAccountNumber_input" class="col-sm-3 col-form-label">Account<i class="text-danger">*</i></label>
                        <div class="col-sm-9" >
                            <input type="text" name="name" id="mileageAccountNumber_input" class="form-control">
                        </div>
                    </div>
             
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-9" style="display: flex; justify-content: flex-end;">
                            <button type="button" class="btn btn-primary" id="manageMileageAccount_modalSaveBtn"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                    <div class="row error-message-container">
                        <div class="col-12">
                            <p class="text-danger manageMileageAccount_modalErrorMsg"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"  data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<?= $this->endSection() ?>