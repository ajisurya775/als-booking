<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../../../configs/config_url.php" ?>
    <?php include "../../components/header.php" ?>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <?php include "../../components/navbar.php" ?>
            </nav>

            <?php include "../../components/sidebar.php" ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Data Stations</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="<?= $config['base_url'] . 'views/admin/departures/add.php' ?>" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Create Departure</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            #
                                                        </th>
                                                        <th>Bus</th>
                                                        <th>Class</th>
                                                        <th>Departure Hour</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    require_once "../../../configs/connection.php";

                                                    $query = "SELECT 
                                                    bd.id,
                                                    b.name,
                                                    bc.name AS class,
                                                    from_prov.name AS from_province,
                                                    to_prov.name AS to_province,
                                                    bd.price,
                                                    bd.status,
                                                    dh.hour
                                                FROM bus_departures AS bd
                                                JOIN buses AS b ON bd.bus_id = b.id
                                                JOIN provinces AS from_prov ON bd.from_province_id = from_prov.id
                                                JOIN provinces AS to_prov ON bd.to_province_id = to_prov.id
                                                JOIN bus_classes AS bc ON b.bus_class_id = bc.id
                                                join departure_hours as dh on bd.departure_hour_id = dh.id
                                                order by bd.created_at desc
                                                ";

                                                    $stmt = $pdo->prepare($query);
                                                    $stmt->execute();

                                                    $transactions = $stmt->fetchAll();

                                                    foreach ($transactions as $key => $value) {
                                                        $no = $key + 1;
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?= $no ?>
                                                            </td>
                                                            <td><?= $value['name'] ?></td>
                                                            <td><?= $value['class'] ?></td>
                                                            <td class="align-middle">
                                                                <?= $value['hour'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $value['from_province'] ?>
                                                            </td>
                                                            <td><?= $value['to_province'] ?></td>
                                                            <td>Rp. <?= number_format($value['price'], 0, ',', '.') ?></td>
                                                            <td>
                                                                <?php
                                                                require '../../../Traits/function.php';
                                                                $class = status($value['status']);
                                                                $statuName = '';
                                                                if ($value['status'] == 1)
                                                                    $statuName = 'Active';
                                                                else
                                                                    $statuName = 'InActive';
                                                                ?>
                                                                <a href="<?= $config['base_url'] . 'controllers/DepartureController.php?action=changeStatus&id=' . $value['id'] . '&status=' . $value['status'] ?>" class="<?= $class ?>"><?= $statuName ?></a>
                                                            </td>
                                                            <td>
                                                                <a href="<?= $config['base_url'] . 'views/admin/departures/update.php?id=' . $value['id'] ?>" class="btn btn-primary">Update</a>
                                                            </td>
                                                        </tr>

                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="section-body">
        </div>
        </section>
    </div>
    <?php include "../../components/footer.php" ?>
    </div>
    </div>

    <?php include "../../components/script.php" ?>

</body>

</html>