<?php

function getCartDepartureByUserId($pdo, $userId)
{
    $stmt = $pdo->prepare("select * from cart_departures where user_id=:user_id");
    $stmt->execute(['user_id' => $userId]);

    return $stmt->fetch();
}

function createCartDeparture($pdo, $userId, $fromProvinceId, $toProvinceId, $dateDeparture, $quantity)
{
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("insert into cart_departures (user_id, from_province_id, to_province_id, date_departure, quantity, created_at,updated_at) values (?,?,?,?,?,?,?)");

    return $stmt->execute([$userId, $fromProvinceId, $toProvinceId, $dateDeparture, $quantity, $created_at, $updated_at]);
}

function updateCartDeparture($pdo, $userId, $fromProvinceId, $toProvinceId, $dateDeparture, $quantity)
{
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("UPDATE cart_departures SET user_id=:user_id, from_province_id=:from_province_id, to_province_id=:to_province_id, date_departure=:date_departure, quantity=:quantity, updated_at=:updated_at WHERE user_id = :user_id");

    return $stmt->execute([
        ':user_id' => $userId,
        ':from_province_id' => $fromProvinceId,
        ':to_province_id' => $toProvinceId,
        ':date_departure' => $dateDeparture,
        ':quantity' => $quantity,
        ':updated_at' => $updated_at
    ]);
}
