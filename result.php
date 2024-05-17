<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "configs/config_url.php" ?>
    <?php include "configs/connection.php" ?>
    <?php include "components/header.php" ?>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
                    </ul>
                </form>
                <?php include "components/navbar.php" ?>
            </nav>

            <?php include "components/sidebar.php" ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Selamat Datang Di ALS</h1>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Hasil Pencarian</h2>
                        <p class="section-lead">Silahkan Pilih tujuan keberangkatan anda!</p>

                        <div class="row">
                            <?php

                            $fromProvinceId = $_GET['from_province_id'];
                            $toProvinceId = $_GET['to_province_id'];

                            $stmt = $pdo->prepare("
                            select bus_departures.id,bus_departures.station_id, buses.name, buses.capacity, bus_departures.price, departure_hours.hour, buses.asset_url
                            from bus_departures
                            join departure_hours on bus_departures.departure_hour_id = departure_hours.id
                            join buses on bus_departures.bus_id = buses.id
                            where from_province_id=:from_province_id 
                            and to_province_id=:to_province_id
                             ");

                            $stmt->execute([
                                ':from_province_id' => $fromProvinceId,
                                ':to_province_id' => $toProvinceId
                            ]);

                            $departures = $stmt->fetchAll();
                            ?>

                            <?php foreach ($departures as $key => $value) { ?>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                    <article class="article">
                                        <div class="article-header">
                                            <div class="article-image" data-background="<?= $value['asset_url'] ?>">
                                            </div>
                                            <div class="article-title">
                                                <h2><a href="#"><?= $value['name'] ?></a></h2>
                                            </div>
                                        </div>
                                        <div class="article-details">
                                            <form action="<?= $config['base_url'] . 'controllers/OrderController.php?action=create-order&departure_id=' . $value['id'] . '&station_id=' . $value['station_id'] ?>" method="post">
                                                <p>Harga Rp. <?= (int)$value['price'] ?></p>
                                                <p>Sisa Kursi <?= $value['capacity'] ?></p>
                                                <p>Jadwal <?= $value['hour'] ?></p>
                                                <div class="article-cta">
                                                    <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                                                </div>
                                            </form>

                                        </div>
                                    </article>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="section-body">
        </div>
        </section>
    </div>
    <?php include "components/" ?>
    </div>
    </div>

    <?php include "components/script.php" ?>

</body>

</html>