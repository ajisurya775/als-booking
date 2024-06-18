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
                        <h1>Data Sales</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="form-group">
                                            <label for="start-date">Start Date</label>
                                            <input type="date" class="form-control" name="start-date">
                                        </div>

                                        <div class="form-group">
                                            <label for="start-date">End Date</label>
                                            <input type="date" class="form-control" name="start-date">
                                        </div><br>

                                        <button class="btn btn-info">Generated</button>
                                        <button class="btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Export Exel</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            #
                                                        </th>
                                                        <th>Name</th>
                                                        <th>Created_at</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <!-- <tbody>
                                                    <?php

                                                    require_once "../../../configs/connection.php";

                                                    $query = "SELECT * FROM departure_hours";

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
                                                            <td><?= $value['hour'] ?></td>
                                                            <td>
                                                                <div><?= $value['created_at'] ?></div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createProvinces"> Update</a>
                                                            </td>
                                                        </tr>

                                                    <?php } ?>
                                                </tbody> -->
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

</body>

</html>