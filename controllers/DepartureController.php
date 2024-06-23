<?php

session_start();

require_once "../configs/config_url.php";
require_once "../service/CartService.php";
require_once "../configs/connection.php";
require_once "../service/DepartureService.php";

if (isset($_GET['action']) && $_GET['action'] == 'search') {

    $formProvinceId = $_POST['from_province_id'];
    $toProvinceId = $_POST['to_province_id'];
    $dateDeparture = $_POST['date_departure'];
    $quantity = $_POST['quantity'];

    $userId = $_SESSION['id'];

    $cartUser = getCartDepartureByUserId($pdo, $userId);

    if (!$cartUser)
        createCartDeparture($pdo, $userId, $formProvinceId, $toProvinceId, $dateDeparture, $quantity);
    else
        updateCartDeparture($pdo, $userId, $formProvinceId, $toProvinceId, $dateDeparture, $quantity);


    header('Location: ' . $config['base_url'] . 'result.php' . '?from_province_id=' . urlencode($formProvinceId) . '&to_province_id=' . urlencode($toProvinceId) . '&date_departure=' .  urlencode($dateDeparture) .  '&quantity=' . $quantity);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'create') {

    $request = $_POST;

    $departure = insertBusDeparture($pdo, $request);

    header("location: " . $config['base_url'] . 'views/admin/departures');
}

if (isset($_GET['action']) && $_GET['action'] == 'changeStatus') {

    $id = $_GET['id'];
    $status = $_GET['status'] == 1 ? 0 : 1;

    updateStatus($pdo, $status, $id);

    header("location: " . $config['base_url'] . 'views/admin/departures');
}

if (isset($_GET['action']) && $_GET['action'] == 'update') {

    $request = $_POST;

    // echo json_encode($request);

    updateDeparture($pdo, $request);

    header("location: " . $config['base_url'] . 'views/admin/departures');
}
