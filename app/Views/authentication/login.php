<?= $this->extend('layouts/authentication') ?>
<?= $this->section('content') ?>
<div class="container" style="position:absolute; top:20%">
    <div class="row justify-content-center align-item-center">
        <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex justify-content-center pb-3">
                <a href="<?= base_url() ?>"><img src="<?= base_url('/public/assets/images/logo.png') ?>" class="logo"></a>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="">
                        <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                        <!-- <p class="text-center small">Enter your email &amp; password to login</p> -->
                    </div>
                    <form class="row g-3" id="login_form" method="POST">
                        <?= csrf_field() ?>
                        <div class="col-12">
                            <label for="email_login_input" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="email_login_input" placeholder="example@email.com">
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <label for="password_login_input" class="form-label">Password</label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control" id="password_login_input" placeholder="Enter your password">
                                <span class="bi bi-eye-slash input-group-text passwordToggle"></span>
                            </div>
                            <p class="text-danger m-0 error-message"></p>
                        </div>
                        <div class="col-12">
                            <a class="small mb-0 pointer" id="forgot_password_button">Forgot my password</a>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0">Don't have an account? <a class="fw-bold" href="<?= base_url() . 'signup' ?>">Sign up</a></p>
                        </div>
                        <div class="col-12">
                            <span class="error-message text-danger mb-0"></span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>