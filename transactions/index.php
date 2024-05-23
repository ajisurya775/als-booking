<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../configs/config_url.php" ?>
    <?php include "../components/header.php" ?>
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
                <?php include "../components/navbar.php" ?>
            </nav>

            <?php include "../components/sidebar.php" ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Selamat Datang Di ALS</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Transaksi Anda</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            #
                                                        </th>
                                                        <th>Order Number</th>
                                                        <th>Jumlah Tiket</th>
                                                        <th>Rute</th>
                                                        <th>Keberangkatan</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    require_once "../configs/connection.php";

                                                    $query = "select o.id, o.order_number, o.status, od.quantity, o.date_departure, od.from_province, od. to_province
                                                    from orders as o
                                                    join order_details as od on o.id = od.order_id
                                                    where user_id=:user_id 
                                                    order by o.created_at desc";

                                                    $stmt = $pdo->prepare($query);
                                                    $stmt->execute(['user_id' => $_SESSION['id']]);
     
                                                    $transactions = $stmt->fetchAll();

                                                    foreach ($transactions as $key => $value) {
                                                        $no = $key + 1;
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?= $no ?>
                                                            </td>
                                                            <td><?= $value['order_number'] ?></td>
                                                            <td class="align-middle">
                                                                <?= $value['quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $value['from_province'] . ' -> ' . $value['to_province'] ?>
                                                            </td>
                                                            <td><?= $value['date_departure'] ?></td>
                                                            <td>
                                                                <?php
                                                                require_once "../Traits/function.php";
                                                                $class = statusOrder($value['status']);
                                                                ?>
                                                                <div class="<?= $class ?>"><?= $value['status'] ?></div>
                                                            </td>
                                                            <td><a href="<?= $config['base_url'] . 'transactions/detail.php?id=' . $value['id'] ?>" class="btn btn-secondary">Detail</a></td>
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
    <?php include "../components/footer.php" ?>
    </div>
    </div>

    <?php include "../components/script.php" ?>

</body>

</html>