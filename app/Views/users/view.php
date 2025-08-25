<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url() . 'users/manage' ?>"><button class="btn btn-primary" style="z-index: 999 !important; position: relative;"><i class="fa-solid fa-plus"></i> Create User</button></a>
    </div>
    <div class="col-12 pt-3">
        <table id="users_datatable" class="datatable">
            <thead>
                <tr>
                    <th style="width:10% !important;">Actions</th>
                    <th style="width:60% !important;">Full Name</th>
                    <th style="width:25% !important;">Role</th>
                    <th style="width:5% !important;"></th>
                    <!-- <th style="width:20% !important;">Account type</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user){ ?>

                <tr>
                    <td>
                        <a href="<?php echo base_url() . 'users/edit?id='.$user['id']?>"  title="Edit User" > <i class="fa-solid fa-pen-to-square editUserIcon pointer" userId="<?=$user['id']?>" title="Edit User"></i></a>
                    </td>
                    <td><a href="<?php echo base_url() . 'users/user?id='.$user['id'] ?>"><?=$user['fname'].' '.$user['lname']?></a></td>
                    <td><?=$user['access_type']==2?'Admin':'User'?></td>
                    <!-- <td><?=$user['account_type']==2?'Business':'Individual'?></td> -->
                   <td>
                     <i class="bi bi-trash3-fill text-danger deleteUserIcon pointer" user-name="<?=$user['fname'].' '.$user['lname']?>" userId="<?=$user['id']?>" title="Delete User"></i>
                   </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>