<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../configs/config_url.php';
require_once '../configs/connection.php';
require_once '../service/AuthService.php';

if ($_GET['action'] == 'register') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if ($password != $passwordConfirm) {
        $_SESSION['register_form'] = $_POST;
        $_SESSION['error'] = 'Password not match';
        header('Location:' . $config['base_url'] . 'auth/register.php');
        exit();
    }

    $isEmail = isEmailAlreadyRegister($pdo, $email);

    if ($isEmail) {
        $_SESSION['register_form'] = $_POST;
        $_SESSION['error'] = 'Email already register';
        header('Location:' . $config['base_url'] . 'auth/register.php');
        exit();
    }

    unset($_SESSION['register_form']);

    register($pdo, $config, $name, $email, $password);
}


if ($_GET['action'] == 'login') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = isEmailAlreadyRegister($pdo, $email);

    if ($user['password'] && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        header("Location: " . $config['base_url']);
        exit();
    }

    $_SESSION['login_form'] = $_POST;
    $_SESSION['error'] = 'email or password is incorrect';
    header('Location:' . $config['base_url'] . 'auth/login.php');
}

if ($_GET['action'] == 'logout') {
    session_destroy();
    header('Location:' . $config['base_url'] . 'auth/login.php');
}
