<?php

require_once "../Traits/generateUUid.php";

function insertOrder($pdo, $orderNumber, $stationId, $userId, $name, $cart, $busDeparture)
{
    $id = generateUUID();
    $now = date('Y-m-d H:i:s');
    $subTotal = $cart['quantity'] * $busDeparture['price'];

    //penambahan nilai jika ada
    $grandTotal = $subTotal;

    $stmt = $pdo->prepare("insert into orders (id, order_number, station_id, user_id, name, status, sub_total, grand_total, date_departure, created_at, updated_at) values (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$id, $orderNumber, $stationId, $userId, $name, 'pending', $subTotal, $grandTotal, $cart['date_departure'], $now, $now]);

    insertOrderDetail($pdo, $id, $busDeparture, $cart);

    return array($grandTotal, $id);
}

function insertOrderDetail($pdo, $id, $busDeparture, $cart)
{
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("insert into order_details (order_id,bus_departure_id,from_province,to_province,bus_class_id, price, quantity, created_at, updated_at) values (?,?,?,?,?,?,?,?,?)");

    $stmt->execute([$id, $busDeparture['id'], $busDeparture['from_province'], $busDeparture['to_province'], $busDeparture['bus_class_id'], $busDeparture['price'], $cart['quantity'], $now, $now]);
}

//generate tiket ketika udh di bayar
function insertOrderChairs($pdo, $orderId, $order)
{
    $now = date('Y-m-d H:i:s');
    $startChair = getLastOrderChairs($pdo);

    $stmt = $pdo->prepare("INSERT INTO order_chairs (order_id, order_chairs, created_at, updated_at) VALUES (:order_id, :order_chairs, :created_at, :updated_at)");
    for ($i = 1; $i <= $order['quantity']; $i++) {
        $params = [
            'order_id' => $orderId,
            'order_chairs' => isset($startChair['order_chairs']) ? $startChair['order_chairs'] + $i : $i,
            'created_at' => $now,
            'updated_at' => $now
        ];

        $stmt->execute($params);
    }
}

function getLastOrderChairs($pdo)
{
    $stmt = $pdo->prepare("
    select MAX(oc.order_chairs) as order_chairs
    from order_chairs as oc
    join orders as o on oc.order_id = o.id
    where o.status=:status
    order by o.created_at desc
    ");

    $stmt->execute(['status' => 'Paid']);

    return $stmt->fetch();
}

function getOrderByOrderNumber($pdo, $orderNumber)
{
    $stmt = $pdo->prepare("select o.id, od.quantity
    from orders as o
    join order_details as od on o.id = od.order_id
    where order_number=:order_number");
    $stmt->execute([':order_number' => $orderNumber]);

    return $stmt->fetch();
}
