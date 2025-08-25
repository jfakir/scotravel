<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
    if(isset($user) && !empty($user)){
        extract($user);


?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit User</h5>
                <form name="user_form"  id="user_form" class="needs-validation"  method="POST">
                    <input type="hidden" name='id' id="id" value="<?=$id?>" />
               

                    <div class="row mb-3">
                        <label for="userFirstName_input" class="col-sm-2 col-form-label">First Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="fname" id="userFirstName_input" class="form-control" value="<?=$fname?>" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="userLastName_input" class="col-sm-2 col-form-label">Last Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="lname" id="userLastName_input" class="form-control" value="<?=$lname?>" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="userEmail_input" class="col-sm-2 col-form-label">Email<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="mail" name="email" id="userEmail_input" class="form-control"  value="<?=$email?>" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="userAdmin_input">Admin<i class="text-danger"></i></label>
                        <div class="col-sm-10" style="align-content: center;">
                            <input type="checkbox" id="userAdmin_input" <?=$access_type==2?"checked":""?> style="width:16px; height:16px;">
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0 "  style="margin-right:5px;align-content: center;" id="userFormErrorMessage"></p>
                            <button type="button" id="user_form_saveBtn" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }else{

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage User</h5>
                <form name="user_form"  id="user_form" class="needs-validation"  method="POST">
                    <input type="hidden" name="account_type" value="2" />
                    <input type="hidden" name="is_verified" value="1" />
               

                    <div class="row mb-3">
                        <label for="userFirstName_input" class="col-sm-2 col-form-label">First Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="fname" id="userFirstName_input" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="userLastName_input" class="col-sm-2 col-form-label">Last Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="lname" id="userLastName_input" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="userEmail_input" class="col-sm-2 col-form-label">Email<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="mail" name="email" id="userEmail_input" class="form-control" placeholder="email@domain.com">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="userAdmin_input">Admin<i class="text-danger"></i></label>
                        <div class="col-sm-10" style="align-content: center;">
                            <input type="checkbox" id="userAdmin_input" style="width:16px; height:16px;">
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0 "  style="margin-right:5px;align-content: center;" id="userFormErrorMessage"></p>
                            <button type="button" id="user_form_saveBtn" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>
<?= $this->endSection() ?>