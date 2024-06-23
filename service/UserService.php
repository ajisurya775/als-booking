<?php

class UserService
{
    public function createUser($pdo, $request)
    {
        $createdAt = date('Y-m-d H-i-s');
        $password = password_hash($request['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role,created_at,updated_at) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$request['name'], $request['email'], $password, $request['role'], $createdAt, $createdAt]);
    }

    public function updateStatuUser($pdo, $status, $id)
    {
        $createdAt = date('Y-m-d H-i-s');
        $stmt = $pdo->prepare('UPDATE users SET status = :status, updated_at = :updated_at where id = :id');
        $stmt->execute([':status' => $status, ':updated_at' => $createdAt, ':id' => $id]);
    }

    public function getUserById($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM users where id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    public function getUserByEmail($pdo, $email)
    {
        $stmt = $pdo->prepare("SELECT * FROM users where email = :email");
        $stmt->execute([':email' => $email]);

        return $stmt->fetch();
    }

    public function updateUser($pdo, $request)
    {
        $user = $this->getUserById($pdo, $request['user_id']);

        $password = null;
        if (isset($request['password']))
            $password = password_hash($request['password'], PASSWORD_DEFAULT);

        $updatedAt = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password, role = :role, updated_at = :updated_at WHERE id = :id");

        return $stmt->execute([
            ':name' => $request['name'] ?? $user['name'],
            ':email' => $request['email'] ?? $user['email'],
            ':password' => $password ?? $user['password'],
            ':role' => $request['role'] ?? $user['role'],
            ':updated_at' => $updatedAt,
            ':id' => $request['user_id']
        ]);
    }
}
