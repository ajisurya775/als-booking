<?php

class BusService
{
    public function insertBus($pdo, $request, $path)
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO buses (company_id,code,bus_class_id,name,asset_url,status,capacity, created_at,updated_at) values (?,?,?,?,?,?,?,?,?)");

        $stmt->execute(['1', $request['code'], $request['class'], $request['name'], $path, 0, $request['capacity'], $created_at, $updated_at]);
    }

    public function getBusById($pdo, $id)
    {
        $stmt = $pdo->prepare("
        select 
            b.id,
            bc.id as class_id,
            b.name,
            bc.name as class,
            b.capacity,
            b.status,
            b.code,
            b.asset_url
            from buses as b
        join bus_classes as bc on b.bus_class_id = bc.id
        where b.id=:id
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function updateBus($pdo, $request, $path, $id)
    {
        $bus = $this->getBusById($pdo, $id);

        $updated_at = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("UPDATE buses 
                           SET company_id = ?, 
                               code = ?, 
                               bus_class_id = ?, 
                               name = ?, 
                               asset_url = ?, 
                               capacity = ?, 
                               updated_at = ?
                           WHERE id = ?");

        return  $stmt->execute([
            1,
            $request['code'] ?? $bus['code'],
            $request['class'] ?? $bus['class_id'],
            $request['name'] ?? $bus['name'],
            $path ?? $bus['asset_url'],
            $request['capacity'] ?? $bus['capacity'],
            $updated_at,
            $id
        ]);
    }

    public function changeStatus($pdo, $id, $status)
    {
        $updated_at = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("UPDATE buses SET status = :status, updated_at = :updated_at WHERE id = :id");

        return $stmt->execute([':status' => $status, ':id' => $id, ':updated_at' => $updated_at]);
    }
}
