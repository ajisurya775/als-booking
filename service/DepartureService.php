<?php

function getDepartureById($pdo, $departureId)
{
    $stmt = $pdo->prepare("
    select 
    bd.id,b.id as bus_id, 
    b.name as bus, 
    bd.price, 
    b.bus_class_id, 
    bd.from_province_id,
    bd.to_province_id,
    p1.name as from_province, 
    p2.name as to_province,
    dh.hour,
    bd.departure_hour_id
    from bus_departures as bd 
    join buses as b on bd.bus_id = b.id 
    join provinces as p1 on bd.from_province_id = p1.id
    join provinces as p2 on bd.to_province_id = p2.id
    join departure_hours as dh on bd.departure_hour_id = dh.id
    where bd.id=:id
    ");
    $stmt->execute(['id' => $departureId]);

    return $stmt->fetch();
}

function insertBusDeparture($pdo, $request)
{
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO bus_departures (station_id,bus_id,from_province_id,to_province_id,departure_hour_id,status,price, created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->execute([1, $request['bus_id'], $request['from_province_id'], $request['to_province_id'], $request['departure_hour_id'], 0, $request['price'], $created_at, $updated_at]);
}

function updateStatus($pdo, $status, $id)
{
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('update bus_departures set status = :status, updated_at=:updated_at where id= :id');
    $stmt->execute([':status' => $status, ':updated_at' => $updated_at, 'id' => $id]);
}

function updateDeparture($pdo, $request)
{
    $departure = getDepartureById($pdo, $request['bus_id']);

    $updated_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("update bus_departures 
    set bus_id = :bus_id, 
    to_province_id = :to_province_id,
    departure_hour_id = :departure_hour_id,
    price = :price,
    updated_at = :updated_at
    where id = :id");

    $stmt->execute([
        ':bus_id' => $request['bus_id'] ?? $departure['bus_id'],
        ':to_province_id' => $request['to_province_id'] ?? $departure['to_province_id'],
        ':departure_hour_id' => $request['departure_hour_id'] ?? $departure['departure_hour_id'],
        ':price' => $request['price'] ?? $departure['price'],
        ':updated_at' => $updated_at,
        ':id' => $request['id'],
    ]);
}
