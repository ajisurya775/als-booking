<?php
session_start();

require_once "../configs/error_config.php";
require_once '../configs/config_url.php';
require_once "../configs/connection.php";
require_once "../service/CartService.php";
require_once "../Traits/generateOrderNumber.php";
require_once "../service/OrderService.php";
require_once "../service/DepartureService.php";
require_once "../service/XenditService.php";

if (isset($_GET['action']) == 'create-order') {

    $departureId = $_GET['departure_id'];
    $stationId = $_GET['station_id'];
    $userId = $_SESSION['id'];
    $name = $_SESSION['name'];

    $cart = getCartDepartureByUserId($pdo, $userId);

    $orderNumber = createOrderNumber($pdo);

    $xendit = getXenditCredentialKey($pdo);

    $busDeparture = getDepartureById($pdo, $departureId);

    list($amount, $orderId) = insertOrder($pdo, $orderNumber, $stationId, $userId, $name, $cart, $busDeparture);

    $response = createInvoice($xendit['credential_key'], $orderNumber, $amount);

    $responseData = json_decode($response, true);

    $data = insertXenditInvoiceResponse($pdo, $responseData, $orderId, $amount);

    header("Location:" . $responseData['invoice_url']);
}

function getAllOrderByUserId($pdo, $query)
{
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $_SESSION['id']]);

    return $stmt->fetchAll();
}

function getOrderById($pdo, $query, $id)
{
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    return $stmt->fetch();
}

function getOrderChairNumberByOrderId($pdo, $query, $id)
{
    $stmt = $pdo->prepare($query);
    $stmt->execute(['order_id' => $id]);

    return $stmt->fetchAll();
}

function statusOrder($status)
{
    $class = '';
    if ($status == 'Pending')
        $class = 'badge badge-warning';
    else if ($status == 'Paid')
        $class = 'badge badge-primary';
    else if ($status == 'Finish')
        $class = 'badge badge-success';
    else
        $class = 'badge badge-danger';

    return $class;
}
