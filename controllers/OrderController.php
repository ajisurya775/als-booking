<?php

session_start();

require_once '../configs/config_url.php';
require_once "../configs/connection.php";
require_once "../service/CartService.php";
require_once "../Traits/generateOrderNumber.php";
require_once "../service/OrderService.php";
require_once "../service/DepartureService.php";
require_once "../service/XenditService.php";

if (isset($_GET['action']) && $_GET['action'] == 'create-order') {

    $departureId = $_GET['departure_id'];
    $stationId = $_GET['station_id'];
    $userId = $_SESSION['id'];
    $name = $_SESSION['name'];
    $chairs = $_POST['chairs'];
    $succesRedirectUrl = $config['base_url'] . 'views/transactions';

    $cart = getCartDepartureByUserId($pdo, $userId);

    $orderNumber = createOrderNumber($pdo);

    $xendit = getXenditCredentialKey($pdo);

    $busDeparture = getDepartureById($pdo, $departureId);

    list($amount, $orderId) = insertOrder($pdo, $orderNumber, $stationId, $userId, $name, $cart, $busDeparture, count($chairs));

    insertOrderChairssNow($pdo, $orderId, $chairs);

    $response = createInvoice($xendit['credential_key'], $orderNumber, $amount, $succesRedirectUrl);

    $responseData = json_decode($response, true);

    $data = insertXenditInvoiceResponse($pdo, $responseData, $orderId, $amount);

    deleteAllCartByUserId($pdo);

    header("Location:" . $responseData['invoice_url']);
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

if (isset($_GET['action']) && $_GET['action'] == 'verified') {

    $id = $_GET['id'];
    $status = 'Finish';

    $order = getOrderByOrderId($pdo, $id);

    if ($order) {
        updateStatusOrder($pdo, $status, $id);

        $_SESSION['validation_name'] = $order['name'];
        $_SESSION['order_number'] = $order['order_number'];

        echo "<script>alert('Success To Verified.'); window.history.back();</script>";
    } else {
        echo "<script>alert('Error:Order id not found'); window.history.back();</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'choose') {

    $departureId = $_POST['departure_id'];
    $stationId = $_POST['station_id'];
    $capacity = $_POST['capacity'];
    $code = $_POST['code'];
    $dateDeparture = $_POST['date_departure'];

    header("Location:" . "../chairs.php?departure_id=$departureId&station_id=$stationId&capacity=$capacity&code=$code&date_departure=$dateDeparture");
}
