<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../../../configs/config_url.php" ?>
    <?php include "../../components/header.php" ?>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
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
                        <h1>Data Sales</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="form-group">
                                            <form action="<?= $config['base_url'] . 'views/admin/sales' ?>" method="GET">
                                                <label for="start-date">Start Date</label>
                                                <?php
                                                $defaultStartDate = date('Y-m-d', strtotime('-7 days'));
                                                ?>
                                                <input type="date" class="form-control" name="start-date" value="<?php echo $defaultStartDate; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="end-date">End Date</label>
                                            <?php
                                            $defaultEndDate = date('Y-m-d');
                                            ?>
                                            <input type="date" class="form-control" name="end-date" value="<?php echo $defaultEndDate; ?>">
                                        </div>

                                        <button class="btn btn-info" type="submit">Generated</button>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            #
                                                        </th>
                                                        <th>Name</th>
                                                        <th>Order Number</th>
                                                        <th>bus</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Status</th>
                                                        <th>Grand Total</th>
                                                        <th>Transaction Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    require_once "../../../configs/connection.php";

                                                    $startDate = $_GET['start-date'] ?? null;
                                                    $endDate = $_GET['end-date'] ?? null;

                                                    $query = "SELECT
                                                    o.name,
                                                    o.order_number,
                                                    b.name as bus,
                                                    od.from_province,
                                                    od.to_province,
                                                    od.price,
                                                    od.quantity,
                                                    o.status,
                                                    o.grand_total,
                                                    o.created_at
                                                    FROM orders as o
                                                    join order_details as od on o.id = od.order_id
                                                    join bus_departures as bd on od.bus_departure_id = bd.id
                                                    join buses as b on bd.bus_id = b.id
                                                    where date(o.created_at) >= :start_date 
                                                    and date(o.created_at) <= :end_date 
                                                    and o.status in  ('Paid', 'Finish')";

                                                    $stmt = $pdo->prepare($query);
                                                    $stmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);

                                                    $transactions = $stmt->fetchAll();

                                                    foreach ($transactions as $key => $value) {
                                                        $no = $key + 1;

                                                        require_once "../../../Traits/function.php";
                                                        $class = statusOrder($value['status']);
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?= $no ?>
                                                            </td>
                                                            <td><?= $value['name'] ?></td>
                                                            <td><?= $value['order_number'] ?></td>
                                                            <td><?= $value['bus'] ?></td>
                                                            <td><?= $value['from_province'] ?></td>
                                                            <td><?= $value['to_province'] ?></td>
                                                            <td><?= $value['price'] ?></td>
                                                            <td><?= $value['quantity'] ?></td>
                                                            <td>
                                                                <div class="<?= $class ?>"><?= $value['status'] ?></div>
                                                            </td>
                                                            <td>
                                                                <div><?= (float)$value['grand_total'] ?></div>
                                                            </td>

                                                            <td>
                                                                <?= $value['created_at'] ?>
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

        <div class="modal fade" id="createProvinces" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Bus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?= $config['base_url'] . 'controllers/AuthController.php?action=login' ?>" class="needs-validation" novalidate="">

                            <div class="form-group">
                                <label for="name">Name Provinces</label>
                                <input id="name" type="name" class="form-control" name="name" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your name provinces
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" tabindex="6">Save changes</button>
                    </div>
                    </form>

                </div>
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

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#table-1')) {
                $('#table-1').DataTable().destroy();
            }

            $('#table-1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>


</body>

</html>