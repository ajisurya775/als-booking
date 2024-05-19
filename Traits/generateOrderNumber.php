<?php

function createOrderNumber($pdo)
{
    $month = date('m');
    $year = date('y');

    $order = getLastOrder($pdo);
    $order = $order['order_number'] ?? null;

    $counter = 1;
    if ($order) {
        $counter = intval(substr($order, -7)) + 1;
    }

    $formattedCounter = sprintf('%07d', $counter);

    return 'ORD-' . $month . $year . '-' . $formattedCounter;
}

function getLastOrder($pdo)
{
    $stmt = $pdo->prepare("select * 
    from orders 
    where month(created_at)=month(current_date) and year(created_at) = year(current_date) order by created_at desc");
    $stmt->execute();

    $order = $stmt->fetch();

    return $order;
}
