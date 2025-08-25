<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row mb-5">
    <div class="col-2"></div>
    <div class="col-8">
        <div class="card shadow">
            <div class="card-body pt-3">
                <h5 class="card-title">Profile
                </h5>
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-delete-account">Delete Account</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active pt-3" id="profile-overview" style="line-height: 40px;">
                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Full Name</div>
                            <div class="col-sm-10 col-md-8" id="profile_full_name"><?= $user_data['fname'] . ' ' . $user_data['lname'] ?></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Account Type</div>
                            <div class="col-sm-10 col-md-8" id="profile_account_type">
                                <?php if ($user_data['account_type'] == 1) {
                                    echo "Individual";
                                } else {
                                    echo "Business";
                                } ?>
                            </div>
                        </div>
                        <?php if ($user_data['account_type'] >= 2) { ?>
                            <!-- <div class="row mb-1">
                                <div class="col-sm-2 fw-bold">Company(ies)</div>
                                <div class="col-sm-10 col-md-8" id="profile_companies">Sconet</div>
                            </div> -->
                        <?php } ?>
                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Email</div>
                            <div class="col-sm-10 col-md-8" id="profile_email"><?= $user_data['email'] ?></div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Phone</div>
                            <div class="col-sm-10 col-md-8" id="profile_phone"><?= $user_data['phone_code'] . $user_data['phone'] ?></div>
                        </div>
                        <!-- <div class="row mb-1">
                            <div class="col-2 fw-bold">Mileage Account(s)</div>
                            <div class="col-10">
                                <button class="btn btn-primary py-0" data-bs-toggle="modal" data-bs-target="#manageMileageAccount_modal">Add Account</button>
                            </div>
                            <div class="col-12">
                                <div class="col-12 swiper quickReport_swiper">
                                    <div class="swiper-wrapper">
                                        <?php
                                        //view_cell(
                                        //'\App\Libraries\User::mileageAccountSwiperCard',
                                        //[
                                        //'accountName' => 'Account 1',
                                        //'mileages' => 14000,
                                        //'airline' => 'Middle East'
                                        //]
                                        //)
                                        ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="tab-pane fade pt-3" id="profile-edit">
                        <!-- Start Profile Edit Form -->
                        <form action="users/updateProfile" id="profile_form" method="POST" >
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">First Name<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input name="fname" type="text" class="form-control" id="fname_profile_input" value="<?= $user_data['fname'] ?>">
                                    <p class="text-danger m-0 error-message"></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lname" class="col-sm-2 col-form-label">Last Name<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input name="lname" type="text" class="form-control" id="lname_profile_input" value="<?= $user_data['lname'] ?>">
                                    <p class="text-danger m-0 error-message"></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Phone" class="col-sm-2 col-form-label">Phone<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input name="phone" type="tel" class="form-control phone-input" id="phone_profile_input" value="<?= $user_data['phone_code'] . $user_data['phone'] ?>">
                                    <p class="text-danger m-0 error-message"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12  d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- End Profile Edit Form -->
                    </div>
                    <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form id="password_form" method="POST">
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="password_current_profile_input" >Current Password<i class="text-danger">*</i></label>
                                </div>
                                
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input name="current_password" type="password" class="form-control" id="password_current_profile_input">
                                        <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                                    </div>
                                    <p class="text-danger m-0 error-message"></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="password_profile_input" >New Password<i class="text-danger">*</i></label>
                                </div>

                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control" id="password_profile_input">
                                        <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                                    </div>
                                    <p class="text-danger m-0 error-message"></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="password_confirm_profile_input" >Re-enter New Password<i class="text-danger">*</i></label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input name="confirm_password" type="password" class="form-control" id="password_confirm_profile_input">
                                        <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                                    </div>
                                    <p class="text-danger m-0 error-message"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <p class="errorMessage"></p>
                                </div>
                                <div class="col-12  d-flex justify-content-end" >
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- End Change Password Form -->
                    </div>
                    <div class="tab-pane fade pt-3" id="profile-delete-account">
                        <form action="delete_profile_form" method="POST">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-lg-5 col-sm-12">
                                    <button class="btn btn-danger" type="button"><i class="bi bi-trash3-fill"></i> Delete My Account</button>
                                </div>
                            </div>
                        </form>
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
                <form name="mileageAccount_form" class="needs-validation" action="<?php echo base_url() . '/mileageAccount/manage' ?>" method="POST">
                    <input type="hidden" id="mileageAccountFormStatus" value="0" />
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="mileageAccountAirlineID_select">Airline<i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <select class="select2single form-control" name="airline_id" id="mileageAccountAirlineID_select" data-dropdown-parent="#manageMileageAccount_modal">
                                <option value="1"> Middle East Airline</option>
                                <option value="2"> Air France</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="mileageAccountNumber_input" class="col-sm-3 col-form-label">Account<i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input type="text" name="account_number" id="mileageAccountNumber_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="mileageAccountPoints_input" class="col-sm-3 col-form-label">Account<i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <input type="text" name="points" id="mileageAccountPoints_input" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12  d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                    <div class="row error-message-container">
                        <div class="col-12">
                            <p class="text-danger"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<?= $this->endSection() ?>