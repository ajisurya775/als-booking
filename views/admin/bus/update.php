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

                                    <?php
                                    require_once '../../../service/BusService.php';
                                    require_once '../../../configs/connection.php';

                                    $bus = new BusService;
                                    $data = $bus->getBusById($pdo, $_GET['id']);
                                    ?>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 offset-lg-3">
                                                <form action="<?= $config['base_url'] . 'controllers/BusController.php?action=update' ?>" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                    <input type="text" hidden class="form-control" name="id" value="<?= $data['id'] ?>" tabindex="1" required autofocus>

                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" name="name" value="<?= $data['name'] ?>" tabindex="1" required autofocus>
                                                        <div class="invalid-feedback">
                                                            Please fill in your name
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="code">Code</label>
                                                        <input type="text" class="form-control" name="code" value="<?= $data['code'] ?>" tabindex="1" required autofocus readonly>
                                                        <div class="invalid-feedback">
                                                            Please fill in your Code
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="class">class</label>
                                                        <select name="class" class="form-control" id="">
                                                            <option value="<?= $data['class_id'] ?>"><?= $data['class'] ?></option>
                                                            <?php
                                                            $stmt = $pdo->prepare('SELECT * FROM bus_classes');
                                                            $stmt->execute();
                                                            $clases = $stmt->fetchAll();

                                                            foreach ($clases as $key => $value) {
                                                                if ($data['class_id'] != $value['id']) {
                                                            ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please fill in your Code
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="capacity">Capacity</label>
                                                        <input type="text" class="form-control" name="capacity" value="<?= $data['capacity'] ?>" tabindex="1" required autofocus>
                                                        <div class="invalid-feedback">
                                                            Please fill in your Capacity
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <input type="file" class="form-control" name="image" tabindex="1">

                                                        <br>
                                                        <img src="<?= $config['base_url'] . $data['asset_url'] ?>" width="50%" alt="" srcset="">
                                                    </div>
                                                    <hr>
                                                    <a href="<?= $config['base_url'] . 'views/admin/bus' ?>" class="btn btn-secondary" tabindex="6">Back</a>
                                                    <button type="submit" class="btn btn-info" tabindex="6">Save changes</button>
                                                </form>
                                            </div>
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