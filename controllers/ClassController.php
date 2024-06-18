<?php

require_once '../configs/config_url.php';
require_once '../configs/connection.php';
require_once '../service/ClassService.php';

if (isset($_GET['action']) && $_GET['action'] == 'create') {

    $name = $_POST['name'];

    $fungtion = new ClassService;
    $fungtion->insertClass($pdo, $name);

    header('Location:' . $config['base_url'] . 'views/admin/bus');
}
