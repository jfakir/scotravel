<?= $this->extend('layouts/authentication') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
        <div class="d-flex justify-content-center py-4">
            <a href="http://localhost/scoTravelCI4/"><img src="http://localhost/scoTravelCI4/public/assets/images/logo.png" class="logo"></a>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Update Password</h5>
                </div>
                <form class="row g-3" id="login_form" method="POST">
                    <div class="col-12">
                        <label for="password_update_input" class="form-label">Password</label>
                        <input type="text" name="email" class="form-control" id="password_update_input" placeholder="Enter new password">
                        <p class="text-danger m-0 error-message"></p>
                    </div>
                    <div class="col-12">
                        <label for="confirm_password_update_input" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input name="confirm_password" type="password" class="form-control" id="confirm_password_update_input" placeholder="Confirm new password">
                            <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                        </div>
                        <p class="text-danger m-0 error-message"></p>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Update</button>
                    </div>
                    <div class="col-12">
                        <p class="small mb-0">Back to <a class="fw-bold" href="<?= base_url()?>">Login</a></p>
                    </div>
                    <div class="col-12">
                        <span class="error-message text-danger mb-0"></span>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>