<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url() . 'tenants/manage' ?>"><button class="btn btn-primary" style="z-index: 999 !important; position: relative;"><i class="fa-solid fa-plus"></i> Create Tenant</button></a>
    </div>
    <div class="col-12 pt-3">
        <table id="tenants_datatable" class="datatable">
            <thead>
                <tr>
                    <th style="width:10% !important;">Actions</th>
                    <th style="width:90% !important;">Tenant Name</th>
                    <th style="width:90% !important;"></th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($companies as $company){ ?>
                <tr>
                    <td>
                        <?php if(session()->access_type==2 || $company['is_admin']==1){?>
                            <a href="<?php echo base_url() . 'tenants/edit?id='.$company['id']?>" ><i class="fa-solid fa-pen-to-square editTenantIcon pointer" title="Edit Tenant"></i></a>
                        <?php } ?>
                    </td>
                    <td><a href="<?php echo base_url() . 'tenants/tenant?id='.$company['id']?>"><?=$company['name']?></a></td>
                    <td>
                        <?php if(session()->access_type==2 || $company['is_admin']==1){?>
                            <i class="bi bi-trash3-fill text-danger deleteCompany pointer" companyId="<?=$company['id']?>" title="Delete Tenant"></i>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>