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
                        <h5 class="card-title text-center pb-0 fs-4">Verify Account</h5>
                        <!-- <p class="text-center small">Enter your email &amp; password to login</p> -->
                    </div>
                    <form class="row g-3" id="verify_account" method="POST">
                        <?= csrf_field() ?>
                        <div class="col-12">
                            <button class="btn btn-success w-100" type="submit">Verify My Account</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>