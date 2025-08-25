<?= $this->extend('layouts/authentication') ?>
<?= $this->section('content') ?>
<div class="container" style="position:absolute; top:20%">
    <div class="row d-flex justify-content-center w-100">
        <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex justify-content-center pb-3">
                <a href="<?= base_url() ?>"><img src="<?= base_url('/public/assets/images/logo.png') ?>" class="logo"></a>
            </div>
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                    <form  id="reset_password_form" method="POST">
                        <?= csrf_field() ?>
                        <div class="w-100 mb-2">
                            <label for="password_reset_password_input" class="form-label">Password<i class="text-danger">*</i></label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control" id="password_reset_password_input" placeholder="Enter password" />
                                <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                            </div>
                            <p class="text-danger m-0 error-message"></p>
                        </div>

                        <div class="w-100 mb-3">
                            <label for="confirm_password_reset_password_input" class="form-label">Confirm Password<i class="text-danger">*</i></label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control" id="confirm_password_reset_password_input" placeholder="Enter password" />
                                <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                            </div>
                            <p class="text-danger m-0 error-message"></p>
                        </div>

                        <div class="w-10">
                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>