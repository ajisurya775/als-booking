<?php

require_once '../configs/config_url.php';
require_once '../configs/connection.php';
require_once '../service/BusService.php';
require_once '../service/ImageService.php';

if (isset($_GET['action']) && $_GET['action'] == 'create') {

    $request = $_POST;

    $busService = new BusService;

    $imageService = new ImageService;

    $path = $imageService->uploadImage($_FILES['image'], 'buses');

    $busService->insertBus($pdo, $request, $path);

    header('Location:' . $config['base_url'] . 'views/admin/bus');
}

if (isset($_GET['action']) && $_GET['action'] == 'update') {

    $request = $_POST;

    $id = $_POST['id'];

    $busService = new BusService;

    $imageService = new ImageService;

    $path = null;
    if (isset($_FILES['image']))
        $path = $imageService->uploadImage($_FILES['image'], 'buses');

    $bus = $busService->updateBus($pdo, $request, $path, $id);

    header('Location:' . $config['base_url'] . 'views/admin/bus');
}

if (isset($_GET['action']) && $_GET['action'] == 'status') {

    $id = $_GET['id'];
    $status = $_GET['isactive'];
    $newStatus = $status == 1 ? 0 : 1;

    $busService = new BusService();
    $bus = $busService->changeStatus($pdo, $id, $newStatus);

    header('Location: ' . $config['base_url'] . 'views/admin/bus');
}
