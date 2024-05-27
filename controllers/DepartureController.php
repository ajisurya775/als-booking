<?php

session_start();

require_once "../configs/config_url.php";
require_once "../service/CartService.php";
require_once "../configs/connection.php";

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
    exit(); // Ensure script execution stops after redirection
}
