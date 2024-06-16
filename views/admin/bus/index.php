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
                        <h1>Data Bus</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createBus"><i class="far fa-edit"></i> Create Bus</a>
                                        <a href="#" class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#createClass"><i class="far fa-edit"></i> Create Class</a>
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
                                                        <th>Code</th>
                                                        <th>Class</th>
                                                        <th>Capacity</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    require_once "../../../configs/connection.php";

                                                    $query = "select 
                                                        b.id,
                                                        b.name,
                                                        bc.name as class,
                                                        b.capacity,
                                                        b.status,
                                                        b.code,
                                                        b.asset_url
                                                        from buses as b
                                                        join bus_classes as bc on b.bus_class_id = bc.id
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
                                                            <td class="align-middle">
                                                                <?= $value['code'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $value['class'] ?>
                                                            </td>
                                                            <td><?= $value['capacity'] ?></td>
                                                            <td>
                                                                <?= $value['status'] ?>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-secondary">Detail</button>
                                                                <a href="<?= $config['base_url'] . 'views/admin/bus/update.php?id=' . $value['id'] ?>" class="btn btn-primary">Update</a>
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

        <div class="modal fade" id="createBus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label for="name">Name</label>
                                <input id="name" type="name" class="form-control" name="name" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your name
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="code" class="control-label">Code</label>
                                </div>
                                <input id="code" placeholder="example: ALC" type="code" class="form-control" name="code" tabindex="2" required>
                                <div class="invalid-feedback">
                                    please fill in your code
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Class</label>
                                <select class="form-control" name="class" tabindex="3">
                                    <option value="1">Ekonomi</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="capacity" class="control-label">Capacity</label>
                                </div>
                                <input id="capacity" type="number" min="1" class="form-control" name="capacity" tabindex="4" required>
                                <div class="invalid-feedback">
                                    please fill in your capacity
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="image" class="control-label">Image</label>
                                </div>
                                <input id="image" type="file" class="form-control" name="image" tabindex="5" required>
                                <div class="invalid-feedback">
                                    please fill in your image
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

        <div class="modal fade" id="createClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Class</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?= $config['base_url'] . 'controllers/AuthController.php?action=login' ?>" class="needs-validation" novalidate="">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="name" class="form-control" name="name" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your name
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