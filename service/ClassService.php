<?php

class ClassService
{
    public function insertClass($pdo, $name)
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO bus_classes (name, created_at, updated_at) values (?,?,?)");
        $stmt->execute([$name, $created_at, $updated_at]);
    }
}
