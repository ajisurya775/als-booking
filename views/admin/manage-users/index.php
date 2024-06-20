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
                        <h1>Data Users</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#createProvinces"><i class="far fa-edit"></i> Create User</a>

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
                                                        <th>Email</th>
                                                        <th>status</th>
                                                        <th>Role</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    require_once "../../../configs/connection.php";

                                                    $query = "SELECT * FROM users where not role='user'";

                                                    $stmt = $pdo->prepare($query);
                                                    $stmt->execute();

                                                    $users = $stmt->fetchAll();

                                                    foreach ($users as $key => $value) {
                                                        $no = $key + 1;
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?= $no ?>
                                                            </td>
                                                            <td><?= $value['name'] ?></td>
                                                            <td><?= $value['email'] ?></td>
                                                            <td>
                                                                <div><?= $value['role'] ?></div>
                                                            </td>
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
                                                                <a href="<?= $config['base_url'] . 'controllers/UserController.php?action=changeStatus&id=' . $value['id'] . '&status=' . $value['status'] ?>" class="<?= $class ?>"><?= $statuName ?></a>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#detail<?= $value['id'] ?>"> Update</a>
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
                        <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?= $config['base_url'] . 'controllers/UserController.php?action=create' ?>" class="needs-validation" novalidate="">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your Name
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input id="name" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your Email
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Roles</label><br>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="admin" tabindex="1" required autofocus>
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="bus conductor" tabindex="1" required autofocus>
                                        <label class="form-check-label" for="inlineRadio2">Bus Conductor</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Password</label>
                                <input id="name" type="password" class="form-control" name="password" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your Password
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
        <?php
        foreach ($users as $key => $value) {
        ?>
            <div class="modal fade" id="detail<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?= $config['base_url'] . 'controllers/UserController.php?action=update' ?>" class="needs-validation" novalidate="">
                                <input type="text" name="user_id" hidden value="<?= $value['id'] ?>">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" value="<?= $value['name'] ?>" class="form-control" name="name" tabindex="1">
                                    <div class="invalid-feedback">
                                        Please fill in your Hour
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input id="name" type="text" value="<?= $value['email'] ?>" class="form-control" name="email" tabindex="1">
                                    <div class="invalid-feedback">
                                        Please fill in your Hour
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name">Roles</label><br>
                                    <?php

                                    $adminChecked = '';
                                    $conductorChecked = '';
                                    if ($value['role'] == 'admin')
                                        $adminChecked = 'checked';
                                    elseif ($value['role'] == 'bus conductor')
                                        $conductorChecked = 'checked'

                                    ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" <?= $adminChecked ?> name="role" id="inlineRadio1" value="admin">
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" <?= $conductorChecked ?> name="role" id="inlineRadio2" value="bus conductor">
                                        <label class="form-check-label" for="inlineRadio2">Bus Conductor</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name">Password</label>
                                    <input id="name" type="password" class="form-control" name="password" tabindex="1">
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
        <?php } ?>

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