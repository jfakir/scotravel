<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wdith:device-width, intial-scale=1.0">
    <title>ScoTravel</title>
    <!-- Start BS5 -->
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/bootstrap/css/bootstrap.min.css') ?>" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.css" integrity="sha512-ywmPbuxGS4cJ7GxwCX+bCJweeext047ZYU2HP52WWKbpJnF4/Zzfr2Bo19J4CWPXZmleVusQ9d//RB5bq0RP7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Start FlatPicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Start Intl Tel Input -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@20.0.5/build/css/intlTelInput.css">
    <!-- Start Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/authentication.css') ?>" type="text/css" />
</head>

<body style="overflow-y: overlay !important">
    <!-- Start main -->
    <main id="main">
        <?= $this->renderSection('content') ?>
    </main>
    <!-- End main -->

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
    <script type="text/javascript" src="<?= base_url('/public/assets/jquery/jquery.js') ?>"></script>
    <!-- Intel Tel -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@20.0.5/build/js/intlTelInput.min.js"></script>
    <!-- BS5 -->
    <script src="<?= base_url('/public/assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- FlatPicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- JS -->
    <script type="text/javascript" src="<?php echo base_url('/public/assets/js/authentication.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('/public/assets/js/commonFunctions.js') ?>"></script>

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