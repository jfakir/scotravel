<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row mb-5">
    <div class="col-xl-12">
        <div class="card shadow">
            <div class="card-body pt-3">
                <h5 class="card-title">Tenant Detail</h5>
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>
                    <!-- <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tenant-edit">Edit Tenant</button>
                    </li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active pt-3" id="profile-overview">
                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Name</div>
                            <div class="col-sm-10 col-md-8"><?=$tenant['name']?></div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-sm-2 fw-bold">Number of users</div>
                            <div class="col-sm-10 col-md-8"><?=count($users);?></div>
                        </div>

                        <?php if($isTripAdmin){ ?>
                            <div class="row mb-1">
                                <div class="col-10">
                                    <button class="btn btn-primary py-0" data-bs-toggle="modal" data-bs-target="#add_user_to_tenant_modal"  style="z-index: 999 !important; position: relative;"><i class="fas fa-user-plus "></i> Add Users</button>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row mb-1">
                            <div class="col-12 pt-3">
                                <table id="users_datatable" class="datatable">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Type</th>
                                        <?php if($isTripAdmin){ ?>

                                            <th>Actions</th>
                                        <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($users as $user){?>
                                        <tr>
                                            <td><?=$user['fname'].' '.$user['lname']?></td>
                                            <td><?=$user['is_admin']==1 ?'Admin':'User'?></td>
                                        <?php if($isTripAdmin){ ?>

                                            <td>
                                                <?php if($user['is_admin']==1){?>
                                                    <i class="fas fa-user-times pointer tenantsDismissUserAsAdminBtn" title="Dismiss as Admin" record_id="<?=$user['id']?>" user_id="<?=$user['user_id']?>" tenant_id="<?=$tenant['id']?>"></i>
                                                <?php }else{?>
                                                    <i class="fas fa-user-shield text-primary pointer tenantsMakeUserAdminBtn" style="font-size: 17px !important;" title="Make Admin" record_id="<?=$user['id']?>" user_id="<?=$user['user_id']?>" tenant_id="<?=$tenant['id']?>"></i>
                                                <?php }?>

                                                <i class="bi bi-trash3-fill text-danger pointer tenantsRemoveUserBtn" title="Remove User" user_id="<?=$user['user_id']?>" tenant_id="<?=$tenant['id']?>"></i>
                                            
                                            </td>
                                        <?php } ?>

                                        </tr>
                                        <?php }?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade pt-3" id="tenant-edit">
                        <!-- Start Profile Edit Form -->
                        <form action="tenant/edit" id="tenant_edit_form" method="POST">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Name<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" class="form-control" id="tenant_name" value="Google SAL">
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
<div class="modal fade" id="manageTenantSelectUsers_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Travelers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="manageTenantSelectUsers_select">Tenant</label>
                    <div class="col-sm-9">
                        <select class="select2single form-control" id="manageTenantSelectUsers_select" data-dropdown-parent="#manageTenantSelectUsers_modal">
                            <option value="-1" selected> All Tenants</option>
                            <option value="1"> Google</option>
                            <option value="2"> Meta</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label m-0">Travelers</label>
                    <div class="col-sm-9" style="padding-top: 7px; padding-bottom: 7px;">
                        <p class="d-flex align-items-center m-0"><i class="bi bi-plus-circle-fill blue pointer me-2" style="font-size: 22px" title="Add Traveler"></i> User 1</p>
                        <p class="d-flex align-items-center m-0"><i class="bi bi-plus-circle-fill blue pointer me-2" style="font-size: 22px" title="Add Traveler"></i> User 2</p>
                        <p class="d-flex align-items-center m-0"><i class="bi bi-plus-circle-fill blue pointer me-2" style="font-size: 22px" title="Add Traveler"></i> User 3</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- remove user from tenant modal -->
<div class="modal fade" id="tenant_remove_user_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user-minus text-danger" title="Remove User"></i>Remove User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="notification_list">
                    <input type="hidden" id="tenant_remove_user_modal_tenant_id" />
                    <input type="hidden" id="tenant_remove_user_modal_user_id" />

                    <div class="row">
                        <p style="margin-bottom:0px !important;">Are you sure you want to remove this user?</p>
                    </div>
                    
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger " id="tenant_remove_user_modal_removeBtn" data-bs-dismiss="modal" > Remove</button>
            </div>
        </div>
    </div>
</div>

 <!-- dismiss user  as admin modal -->
<div class="modal fade" id="tenant_dismiss_admin_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-times pointer"></i> Dismiss as admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="notification_list">
                    <input type="hidden" id="tenant_dismiss_admin_modal_tenant_id" />
                    <input type="hidden" id="tenant_dismiss_admin_modal_user_id" />
                    <input type="hidden" id="tenant_dismiss_admin_modal_record_id" />
                    <div class="row">
                        <p style="margin-bottom:0px !important;">Are you sure you want to dismiss this user as admin?</p>
                    </div>
                    
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger " id="tenant_dismiss_admin_modal_dismissBtn" data-bs-dismiss="modal" >Dismiss</button>
            </div>
        </div>
    </div>
</div>

 <!-- make user admin modal -->
<div class="modal fade" id="tenant_make_admin_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-shield "></i> Make Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="notification_list">
                <input type="hidden" id="tenant_make_admin_modal_tenant_id" />
                <input type="hidden" id="tenant_make_admin_modal_user_id" />
                <input type="hidden" id="tenant_make_admin_modal_record_id" />
                <div class="row">
                    <p style="margin-bottom:0px !important;">Are you sure you want to make this user admin?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary " id="tenant_make_admin_modal_Btn" data-bs-dismiss="modal" >Yes</button>
            </div>
        </div>
    </div>
</div>

 <!-- make user admin modal -->
 <div class="modal fade" id="add_user_to_tenant_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus "></i> Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column" id="notification_list">
                <input type="hidden" id="add_user_to_tenant_modal_tenant_id" value="<?=$tenant['id']?>"/>
                <input type="hidden" id="add_user_to_tenant_modal_user_id" />
                <div class="row">
                    <label class="col-sm-2 col-form-label" for="flight_number">Email<i class="text-danger">*</i></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" id="add_user_to_tenant_modal_user_email" class="form-control" placeholder="Email">
                            <span class="btn btn-primary input-group-text bg-dangerfw-bold" id="add_user_to_tenant_modal_user_email_search" title="Search User"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12" style="padding-top: 7px; padding-bottom: 7px;">
                        <div style="flex-direction: row; display: flex; align-items: center;" id="add_user_to_tenant_modal_user_div">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <!-- <button type="button" class="btn btn-primary " id="tenant_make_admin_modal_Btn" data-bs-dismiss="modal" >Yes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<?= $this->endSection() ?>