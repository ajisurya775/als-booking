<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>ALS&mdash; Booking</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="<?php echo $config['base_url'] ?>assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $config['base_url'] ?>assets/modules/fontawesome/css/all.min.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="<?php echo $config['base_url'] ?>assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="<?php echo $config['base_url'] ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<!-- Template CSS -->
<link rel="stylesheet" href="<?php echo $config['base_url'] ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo $config['base_url'] ?>assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
</script>

<?php

session_start();


if (!isset($_SESSION['email']) && $_SERVER['DOCUMENT_URI'] != '/auth/login.php' && $_SERVER['DOCUMENT_URI'] != '/auth/register.php')
    header('Location:' . $config['base_url'] . 'auth/login.php');

?>
<!-- /END GA -->