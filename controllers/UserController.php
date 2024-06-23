<?php

require_once '../configs/config_url.php';
require_once "../configs/connection.php";
require_once "../service/UserService.php";

$userService = new UserService;


if (isset($_GET['action']) && $_GET['action'] == 'create') {

    $request = $_POST;

    $user = $userService->getUserByEmail($pdo, $request['email']);

    if ($user) {
        echo "<script>alert('Error: Email already exist.'); window.history.back();</script>";
        exit;
    }

    $userService->createUser($pdo, $request);

    header("Location: " . $config['base_url'] . 'views/admin/manage-users/');
}

if (isset($_GET['action']) && $_GET['action'] == 'changeStatus') {

    $status = $_GET['status'] == 0 ? 1 : 0;
    $id = $_GET['id'];

    $userService->updateStatuUser($pdo, $status, $id);

    header('Location: ' . $config['base_url'] . 'views/admin/manage-users');
}

if (isset($_GET['action']) && $_GET['action'] == 'update') {

    $request = $_POST;

    $currentUser = $userService->getUserById($pdo, $request['user_id']);

    $existingUserWithEmail = $userService->getUserByEmail($pdo, $request['email']);

    if (isset($existingUserWithEmail['email'])) {
        if ($existingUserWithEmail['id'] != $request['user_id']) {
            echo "<script>alert('Error: Email already exists.'); window.history.back();</script>";
            exit;
        }
    }

    $userService->updateUser($pdo, $request);

    header('Location: ' . $config['base_url'] . 'views/admin/manage-users');
}
