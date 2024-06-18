<?php

class OperatingService
{
    public function insertOperating($pdo, $request)
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO departure_hours (hour,created_at,updated_at) VALUES (?,?,?)");
        $stmt->execute([$request['hour'], $created_at, $updated_at]);
    }

    public function updateOperating($pdo, $request)
    {
        $updated_at = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("update departure_hours set hour = :hour, updated_at = :updated_at where id = :id");
        $stmt->execute([':hour' => $request['hour'], ':updated_at' => $updated_at, ':id' => $request['id']]);
    }

    public function getOperatingByHour($pdo, $hour)
    {
        $stmt = $pdo->prepare("select * from departure_hours where hour = :hour");
        $stmt->execute(['hour' => $hour]);

        return $stmt->fetch();
    }
}
