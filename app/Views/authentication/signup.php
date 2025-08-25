<?= $this->extend('layouts/authentication') ?>
<?= $this->section('content') ?>
<div class="container" style="position:absolute; top:5%;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex justify-content-center pb-3">
                <a href="<?= base_url() ?>"><img src="<?= base_url('/public/assets/images/logo.png') ?>" class="logo"></a>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center pb-0 fs-4">Sign-up Now !</h5>
                    <form class="row g-2" id="signup_form" method="POST">
                        <?= csrf_field() ?>
                        <div class="col-12">
                            <label for="fname_signup_input" class="form-label">First Name<i class="text-danger">*</i></label>
                            <input type="text" name="fname" class="form-control" id="fname_signup_input" />
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <label for="lname_signup_input" class="form-label">Last Name<i class="text-danger">*</i></label>
                            <input type="text" name="lname" class="form-control" id="lname_signup_input" />
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <label for="email_signup_input" class="form-label">Email<i class="text-danger">*</i></label>
                            <input type="text" name="email" class="form-control" id="email_signup_input" placeholder="example@mail.com" />
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <label for="phone_signup_input" class="form-label">Phone<i class="text-danger">*</i></label>
                            <input type="phone" name="phone" class="form-control phone-input" id="phone_signup_input" />
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <label for="password_signup_input" class="form-label">Password<i class="text-danger">*</i></label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control" id="password_signup_input" placeholder="Enter password" />
                                <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                            </div>
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <label for="confirm_password_signup_input" class="form-label">Confirm Password<i class="text-danger">*</i></label>
                            <div class="input-group">
                                <input name="confirm_password" type="password" class="form-control" id="confirm_password_signup_input" placeholder="Re-type password" />
                                <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                            </div>
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12 py-1">
                            <label for="">Account Type<i class="text-danger">*</i></label>
                            <div class="form-check">
                                <input class="form-check-input pointer" type="radio" name="account_type" value="1" id="individual_option_input" checked />
                                <label class="form-check-label" for="individual_option_input">
                                    Individual
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input pointer" type="radio" name="account_type" value="2" id="business_option_input" />
                                <label class="form-check-label" for="business_option_input">
                                    Business
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="hidden" name="is_subscribed" value="0">
                                <input class="form-check-input pointer" type="checkbox" value="1" name="is_subscribed" id="is_subscribed_input" />
                                <label class="form-check-label" for="is_subscribed_input">
                                    Subscribe For Our Newsletter
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input pointer" type="checkbox" name="is_agree_to_terms_and_conditions" value="1" id="is_agree_to_terms_and_conditions" />
                                <label class="form-check-label" for="is_agree_to_terms_and_conditions">
                                    I agree to <a download="<?= base_url() . 'Terms And Conditions.pdf' ?>" href="<?php echo base_url() . 'public/assets/documents/Terms and Conditions.pdf' ?>">Terms and Conditions</a><i class="text-danger">*</i>
                                </label>
                                <p class="text-danger m-0 error-message"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Sign-up</button>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0">Already have an account? <a class="fw-bold" href="<?= base_url() ?>">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>