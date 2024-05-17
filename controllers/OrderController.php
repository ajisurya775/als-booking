<?php
session_start();

require_once "../configs/error_config.php";
require_once '../configs/config_url.php';
require_once "../configs/connection.php";
require_once "../service/CartService.php";
require_once "../Traits/generateOrderNumber.php";
require_once "../service/OrderService.php";
require_once "../service/DepartureService.php";

if ($_GET['action'] == 'create-order') {

    $departureId = $_GET['departure_id'];
    $stationId = $_GET['station_id'];
    $userId = $_SESSION['id'];
    $name = $_SESSION['name'];

    $cart = getCartDepartureByUserId($pdo, $userId);

    $orderNumber = createOrderNumber($pdo);

    $busDeparture = getDepartureById($pdo, $departureId);

    $createOrder = insertOrder($pdo, $orderNumber, $stationId, $userId, $name, $cart, $busDeparture);

    header("Location:" . $config['base_url'] . 'transactions');
}
