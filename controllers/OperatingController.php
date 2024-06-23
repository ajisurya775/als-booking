<?php

require_once '../configs/config_url.php';
require_once '../configs/connection.php';
require_once '../service/OperatingService.php';

$operating = new OperatingService;

if (isset($_GET['action']) && $_GET['action'] == 'create') {

    $request = $_POST;

    $hour = $operating->getOperatingByHour($pdo, $request['hour']);

    if ($hour) {
        echo "<script>alert('Error: Operating hour already exist.'); window.history.back();</script>";
        exit;
    }

    $operating->insertOperating($pdo, $request);

    header('Location: ' . $config['base_url'] . 'views/admin/operating-schedules');
}

if (isset($_GET['action']) && $_GET['action'] == 'update') {

    $request = $_POST;

    $hour = $operating->getOperatingByHour($pdo, $request['hour']);

    if ($hour) {
        echo "<script>alert('Error: Operating hour already exist.'); window.history.back();</script>";
        exit;
    }

    $operating->updateOperating($pdo, $request);

    header('Location: ' . $config['base_url'] . 'views/admin/operating-schedules');
}
