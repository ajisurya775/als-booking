<?php

function getDepartureById($pdo, $departureId)
{
    $stmt = $pdo->prepare("
    select bd.id, bd.price, b.bus_class_id, p1.name as from_province, p2.name as to_province
    from bus_departures as bd 
    join buses as b on bd.bus_id = b.id 
    join provinces as p1 on bd.from_province_id = p1.id
    join provinces as p2 on bd.to_province_id = p2.id
    where bd.id=:id
    ");
    $stmt->execute(['id' => $departureId]);

    return $stmt->fetch();
}
