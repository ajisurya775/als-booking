<?php

require_once '../configs/config_url.php';
require_once "../configs/connection.php";
require_once "../service/XenditService.php";
require_once "../service/OrderService.php";

if (isset($_GET['action']) && $_GET['action'] == 'callback') {

    $xenditCredential = getXenditCredentialKey($pdo);

    $headers = getallheaders();

    $xenditXCallbackToken = null;
    if (isset($headers['X-Callback-Token']))
        $xenditXCallbackToken = $headers['X-Callback-Token'];

    $rawData = file_get_contents("php://input");

    $data = json_decode($rawData, true);

    $orderNumber = $data['external_id'];
    $status = $data['status'];
    $order = getOrderByOrderNumber($pdo, $orderNumber);


    if ($xenditXCallbackToken == $xenditCredential['x_callback_token'] && $status == 'PAID') {
        updateStatusOrderByOrderNumber($pdo, $orderNumber, 'Paid');
        insertOrderChairs($pdo, $order['id'], $order);
    } else if ($xenditXCallbackToken == $xenditCredential['x_callback_token'] && $status == 'EXPIRED') {
        updateStatusOrderByOrderNumber($pdo, $orderNumber, 'Expired');
    } else {
        updateStatusOrderByOrderNumber($pdo, $orderNumber, 'Failed');
    }

    http_response_code(200);
    echo json_encode(['message' => 'Record updated successfully.']);
}

function updateStatusOrderByOrderNumber($pdo, $orderNumber, $status)
{
    $stmt = $pdo->prepare("update orders set status=:status where order_number=:order_number");
    $stmt->execute([
        'order_number' => $orderNumber,
        'status' => $status
    ]);

    return $stmt->fetch();
}

if (isset($_GET['action']) && $_GET['action'] == 'changeStatus') {
    $orderNumber = $_GET['order_number'];

    updateStatusOrderByOrderNumber($pdo, $orderNumber, 'Cancle');

    header("Location:" . '../views/transactions');
}
