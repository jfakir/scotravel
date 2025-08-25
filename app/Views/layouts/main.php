<?php
helper(['session']);
$session = session();
$loggedin_user_fname = $session->fname;
$loggedin_user_lname = $session->lname;
$initials = strtoupper(substr($loggedin_user_fname, 0, 1)) . '. ' . $loggedin_user_lname;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wdith:device-width, intial-scale=1.0">
    <title>ScoTravel</title>
    <!-- BS5 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/public/assets/bootstrap/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.css" integrity="sha512-ywmPbuxGS4cJ7GxwCX+bCJweeext047ZYU2HP52WWKbpJnF4/Zzfr2Bo19J4CWPXZmleVusQ9d//RB5bq0RP7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Start Select2 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <!-- Start FlatPicker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <!-- Start Intl Tel Input -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.5/build/css/intlTelInput.css" />
    <!-- Start Font Awesome -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Swipper -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/swiper@11.0.7/swiper-bundle.min.css" />
    <!-- Start FlatPicker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <!-- Data table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/public/assets/css/home.css?ran='. mt_rand(1, 10000000000))?>" />

    <link rel="icon" href="<?=base_url()?>/public/assets/images/Favicon.png" type="image/png">

</head>

<body style="overflow-y: overlay !important">
    <!-- Start header -->
    <header class="fixed-top d-flex align-items-center">
        <div class="d-flex w-100 align-items-center justify-content-between">
            <div class="logocontainer">

            </div>
                <!-- <span class="d-block">ScoTravel</span> -->
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <!-- <li class="nav-item d-block">
                        <i class="bi bi-list toggle-sidebar-btn me-3"></i>
                    </li> -->
                    <!-- Start Notification Nav -->
                    <li class="nav-item dropdown">
                        <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"> -->
                        <?php if(isset($unredeemedReminders) && isset($redeemedReminders) && isset($allReminders) && session()->access_type==2){?>
                            <a class="nav-link nav-icon" href="#"   data-bs-toggle="modal" data-bs-target="#notification_modal">
                                <i class="bi bi-bell"></i>
                                <span class="notification-animation badge bg-primary badge-number" id="notificationIconBadge"><?php if(count($unredeemedReminders)>0){ echo count($unredeemedReminders);}?></span>
                            </a>
                        <?php } ?>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <li class="dropdown-header d-flex align-items-center py-0">
                                <span>You have 10 notifications</span>
                                <i class="text-primary pointer bi bi-plus-circle fw-bold ms-2" title="Add notification" style="font-size:25px" data-bs-toggle="modal" data-bs-target="#manageNotification_modal"></i>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <?= view_cell('\App\Libraries\Notification::notificationSM') ?>
                            <li class="dropdown-footer text-center">
                                <button class="w-75 btn btn-primary" data-bs-toggle="modal" data-bs-target="#notification_modal">View All</button>
                            </li>
                        </ul>

                    </li>
                    <!-- End Notification Nav -->

                    <!-- Start Profile Nav -->
                    <li class="nav-item dropdown pe-3" id="profile_nav">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <?= $initials ?>
                            <span class="ms-2 d-none d-md-block dropdown-toggle"></span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header text-center">
                                <h6><?= $loggedin_user_fname . ' ' . $loggedin_user_lname ?></h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url() . 'users/profile' ?>">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center mb-2" href="<?= base_url() . 'logout' ?>">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul><!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Profile Nav -->
                </ul>
            </nav>
        </div>
    </header>
    <!-- End header -->

    <!-- Start Aside -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav">
            <!-- Upcoming trips button -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url() . 'trips/upcoming' ?>">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span>Upcoming Trips</span>
                </a>
            </li>
            <!-- End Upcoming trips button -->

            <!-- Start Past trips button -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url() . 'trips/past' ?>">
                    <i class="bi bi-clock-history"></i>
                    <span>Past Trips</span>
                </a>
            </li>
            <!-- End Past trips button -->

            <!-- Start configuration button -->
            <?php  if(session()->access_type==2 ||session()->account_type==2 ) { ?>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#configration_nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="configration_nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php  if(session()->access_type==2){ ?>
                    <li>
                        <a href="<?php echo base_url() . 'users/view' ?>">
                            <i class="bi bi-circle"></i><span>Manage Users</span>
                        </a>
                    </li>
                    <?php  } ?>

                    <li>
                        <a href="<?php echo base_url() . 'tenants/view' ?>">
                            <i class="bi bi-circle"></i><span>Manage Tenants</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php  } ?>

            <!-- End configuration button -->

        </ul>
        <div class="sidebar-icon-div pointer">
            <i class="fa-solid fa-arrow-left sidebar-icon"></i>
            <!-- <i class="fa-solid fa-arrows-left-right"></i> -->

        </div>
    </aside>
    <!-- End Aside -->
    <?php if(isset($unredeemedReminders) && isset($redeemedReminders) && isset($allReminders)){?>

    <!-- Start notification modal -->
    <div class="modal fade" id="notification_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-bell"></i> Notifications
                    <!-- <i class="text-primary pointer bi bi-plus-circle fw-bold ms-2 addNotificationIcon" title="Add notification" style="font-size:25px" data-bs-toggle="modal" data-bs-target="#manageNotification_modal"></i> -->
                    <i class="text-primary pointer bi bi-plus-circle fw-bold ms-2 addNotificationIcon" title="Add notification"  ></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column pt-0" id="notification_list">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#notification-all">All</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notification-redeemed">Redeemed</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notification-unredeemed">Unredeemed</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active pt-3" id="notification-all">
                            <?php
                                if(count($allReminders)==0){
                                    echo "<p class='mb-0'>No notifications Available.</p>";
                                }
                                for ($i = 0; $i < count($allReminders); $i++) {
                                    echo view_cell('\App\Libraries\Notification::notification', [
                                        'title' => $allReminders[$i]['title'],
                                        'description'=>$allReminders[$i]['description'],
                                        'id'=>$allReminders[$i]['id'],
                                        'is_redeemed'=>$allReminders[$i]['is_redeemed'],
                                    ]);
                                }
                            ?>
                        </div>
                        <div class="tab-pane fade pt-3" id="notification-redeemed">
                            <?php
                                if(count($redeemedReminders)==0){
                                    echo "<p class='mb-0'>No notifications Available.</p>";
                                }

                                for ($i = 0; $i < count($redeemedReminders); $i++) {
                                    echo view_cell('\App\Libraries\Notification::notification', [
                                        'title' => $redeemedReminders[$i]['title'],
                                        'description'=>$redeemedReminders[$i]['description'],
                                        'id'=>$redeemedReminders[$i]['id'],
                                        'is_redeemed'=>$redeemedReminders[$i]['is_redeemed'],
                                    ]);
                                }
                            ?>
                        </div>
                        <div class="tab-pane fade pt-3" id="notification-unredeemed">
                            <?php
                                if(count($unredeemedReminders)==0){
                                    echo "<p class='mb-0'>No notifications Available.</p>";
                                }
                                for ($i = 0; $i < count($unredeemedReminders); $i++) {
                                    echo view_cell('\App\Libraries\Notification::notification', [
                                        'title' => $unredeemedReminders[$i]['title'],
                                        'description'=>$unredeemedReminders[$i]['description'],
                                        'id'=>$unredeemedReminders[$i]['id'],
                                        'is_redeemed'=>$unredeemedReminders[$i]['is_redeemed'],
                                    ]);
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php }?>

    <div class="modal fade" id="manageNotification_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-bell"></i> Manage Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column" id="notification_list">
                    <form name="notification_form" id="notification_form" class="needs-validation" action="<?php echo base_url() . '/notification/manage' ?>" method="POST">
                        <input type="hidden" id="notificationFormid" name='id' value="0" />
                        <!-- <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="notificationTenantID_select">Tenant<i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <select class="select2single form-control" name="tenant_id" id="notificationTenantID_select" data-placeholder="Select Tenant" data-dropdown-parent="#manageNotification_modal">
                                    <option value="1"> Apple</option>
                                    <option value="2"> Google</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <label for="notificationTitle_input" class="col-sm-3 col-form-label">Title<i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input type="text" name="title" id="notificationTitle_input" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="notificationDescription_input" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description" id="notificationDescription_input" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="notificationDescription_input" class="col-sm-3 col-form-label">Redeemed</label>
                            <div class="col-sm-9" style="align-content: center;">
                                <!-- <input type="text" name="is_redeemed" id="notificationIsRedeemed_input" class="form-control"> -->
                                <input type="checkbox" id="notificationIsRedeemed_input" style="width:16px; height:16px;">

                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="notificationDueDate_input">Reminder<i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input type="date" name="due_date" id="notificationDueDate_input" class="form-control datepicker">
                            </div>
                        </div> -->
                        <div class="row error-message-container">
                            <div class="col-12">
                                <p class="text-danger"></p>
                            </div>
                        </div>
                        <!-- <div class="row mb-3 d-flex justify-content-end">
                            <div class="col-12  d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Save</button>
                            </div>
                        </div> -->
                    </form>
                </div>
                <div class="modal-footer">
                    <p class="text-danger mb-0  notificationErrorMsg"  style="margin-right:5px;align-content: center;" ></p>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="notificationSubmitBtn"><i class="bi bi-send"></i> Save</button>

                </div>
            </div>
        </div>
    </div>
    <!-- End notification modal -->


    
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-trash" style="color:#dc3545; margin-right:5px;"></i><span id="delete_modal_title">Delete Modal</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column" id="notification_list">
                        <input type="hidden" id="delete_modal_record_id" value="0"/>
                        <input type="hidden" id="delete_modal_record_type" value=""/>
                        <div class="row">
                            <p style="margin-bottom:0px !important;">Are you sure you want to delete this record?</p>
                        </div>
                        
             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger " id="delete_modal_deleteBtn" data-bs-dismiss="modal" >Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tripAttachmentModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attachment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column" >
                        <input type="hidden" id="tripAttachmentModal_id" /> 
                        <input type="hidden" id="tripAttachmentName_trip_id" /> 
                         <div class="row mb-1">
                            <label for="notificationTitle_input" class="col-sm-3 col-form-label">Name<i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input type="text" name="tripAttachmentName" id="tripAttachmentName" class="form-control">
                            </div>
                        </div>
             
                </div>
                <div class="modal-footer">
                    <button type="button" id="tripAttachmentSaveBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade" id="planAttachmentModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attachment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column" >
                        <input type="hidden" id="planAttachmentModal_id" /> 
                        <input type="hidden" id="planAttachmentName_plan_id" /> 
                         <div class="row mb-1">
                            <label for="notificationTitle_input" class="col-sm-3 col-form-label">Name<i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input type="text" name="planAttachmentName" id="planAttachmentName" class="form-control">
                            </div>
                        </div>
             
                </div>
                <div class="modal-footer">
                    <button type="button" id="planAttachmentSaveBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
   
        <!-- Start main -->
        <main id="main">
            <div class="container">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
        <!-- End main -->

        <!-- Start footer -->
        <footer>
            <div>
                &copy; Copyright <strong><a href="https://sconet.com">Sconet Corp</a></strong>. All Rights Reserved
            </div>
        </footer>
        <!-- End footer -->
    </div>

    <!-- Start loader-->
    <div class="loader justify-content-center align-items-center">
        <div class="spinner-border" role="status">
        </div>
    </div>
    <!-- End loader -->

    <!-- Start script -->
    <script>
        var baseURL = '<?php echo base_url(); ?>';
    </script>

    <!-- jQuery -->
    <!-- <script type="text/javascript" src=" base_url('/public/assets/jquery/jquery.js?ran='. mt_rand(1, 1000))"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- BS5 -->
    <script type="text/javascript" src="<?= base_url('/public/assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Select2 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Intel Tel -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.5/build/js/intlTelInput.min.js"></script>
    <!-- Swipper-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/swiper@11.0.7/swiper-bundle.min.js"></script>
    <!-- FlatPicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Data Table -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js "></script>
    <!-- JS -->
    <script type="text/javascript" src="<?= base_url('/public/assets/js/home.js?ran='. mt_rand(1, 10000000000))?>"></script>
    <script type="text/javascript" src="<?= base_url('/public/assets/js/commonFunctions.js?ran='. mt_rand(1, 10000000000)) ?>"></script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    
    <?php if (session()->getFlashdata('message_success')) : ?>
        <input type="hidden" id="alertSuccessMessage" value="<?= session('message_success') ?>" />
        <script>
            alertSuccess($('#alertSuccessMessage').val());
        </script>
    <?php endif ?>
    <?php if (session()->getFlashdata('message_error')) : ?>
        <input type="hidden" id="alertErrorMessage" value="<?= session('message_error') ?>" />
        <script>
            alertError($('#alertErrorMessage').val());
        </script>
    <?php endif ?>

    <body>

</html>