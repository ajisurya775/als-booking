<?php

function register($pdo, $config, $name, $email, $password)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");

    try {
        $stmt->execute([$name, $email, $hashedPassword, $created_at, $updated_at]);

        $user_id = $pdo->lastInsertId();

        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        header("Location:" . $config['base_url']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function isEmailAlreadyRegister($pdo, $email)
{
    $stmt = $pdo->prepare("select * from users where email=:email");
    $stmt->execute(['email' => $email]);

    return $stmt = $stmt->fetch();
}
