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
                        <h1>Data Departures</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">


                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 offset-lg-3">
                                                <form action="" method="post" class="needs-validation" novalidate="">

                                                    <div class="form-group">
                                                        <label for="name">Bus</label>
                                                        <select name="bus" id="" class="form-control">
                                                            <option value="">Als Ekonomi</option>
                                                            <option value="">Als Ekonomi</option>
                                                            <option value="">Als Ekonomi</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Departure From</label>
                                                        <select name="bus" id="" class="form-control">
                                                            <option value="">Medan</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Departure to</label>
                                                        <select name="bus" id="" class="form-control">
                                                            <option value="">Medan</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Operating Schdules</label>
                                                        <select name="bus" id="" class="form-control">
                                                            <option value="">08:00</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="number" class="form-control" name="price" tabindex="1" required autofocus>
                                                        <div class="invalid-feedback">
                                                            Please fill in your price
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <a href="<?= $config['base_url'] . 'views/admin/departures' ?>" class="btn btn-secondary" tabindex="6">Back</a>
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