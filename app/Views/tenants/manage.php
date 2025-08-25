<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
    if(isset($company) && !empty($company)){
        extract($company);

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Tenant</h5>
                <form name="company_form" id="company_form" class="needs-validation">
                    <input type="hidden" id="id" name="id" value="<?=$id?>" />
                    <div class="row mb-3">
                        <label for="tenantName_input" class="col-sm-2 col-form-label">Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="tenantName_input" class="form-control" value="<?=$name?>">
                        </div>
                    </div>

                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0 "  style="margin-right:5px;align-content: center;" id="companiesFormErrorMsg"></p>
                            <button type="button" class="btn btn-primary" id="companyFormSaveBtn"><i class="bi bi-send"></i> Save</button>
                        </div>
                    </div>
                    <div class="row error-message-container">
                        <div class="col-12">
                            <p class="text-danger" id="companiesFormErrorMsg"></p>
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
                <h5 class="card-title">Manage Tenant</h5>
                <form name="company_form" id="company_form" class="needs-validation">
                    <div class="row mb-3">
                        <label for="tenantName_input" class="col-sm-2 col-form-label">Name<i class="text-danger">*</i></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="tenantName_input" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <p class="text-danger mb-0 "  style="margin-right:5px;align-content: center;" id="companiesFormErrorMsg"></p>
                            <button type="button" class="btn btn-primary" id="companyFormSaveBtn"><i class="bi bi-send"></i> Save</button>
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