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
                            $date = $_GET['date_departure'];
                            $quantity = $_GET['quantity'];

                            $stmt = $pdo->prepare("
                            SELECT 
                                bd.id,
                                bd.station_id,
                                b.name,
                                b.capacity,
                                bd.price,
                                dh.hour,
                                b.asset_url,
                                COALESCE(od.amount, 0) AS amount
                            FROM 
                                bus_departures bd
                            JOIN 
                                departure_hours dh ON bd.departure_hour_id = dh.id
                            JOIN 
                                buses b ON bd.bus_id = b.id
                            LEFT JOIN 
                                (SELECT bus_departure_id, SUM(quantity) AS amount
                                FROM order_details as od
                                join orders as o on od.order_id = o.id
                                where o.date_departure = :date and 
                                o.status = 'Paid'
                                GROUP BY bus_departure_id) od ON bd.id = od.bus_departure_id
                            WHERE 
                                bd.from_province_id = :from_province_id 
                                AND bd.to_province_id = :to_province_id
                            ORDER BY 
                                amount DESC;

                             ");

                            $stmt->execute([
                                ':from_province_id' => $fromProvinceId,
                                ':to_province_id' => $toProvinceId,
                                ':date' => $date
                            ]);

                            $departures = $stmt->fetchAll();

                            // echo json_encode($departures);
                            ?>

                            <?php foreach ($departures as $key => $value) {
                                $total = $value['capacity'] - $value['amount'];

                            ?>
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
                                                <p>Harga Rp. <?= number_format($value['price'], 2, ',', '.') ?></p>
                                                <p>Sisa Kursi <?= $total ?></p>
                                                <p>Jadwal <?= $value['hour'] ?></p>
                                                <div class="article-cta">
                                                    <?php $calss =  $total < $quantity ? 'd-none' : '' ?>
                                                    <button type="submit" class="btn btn-primary <?= $calss ?>">Pesan Sekarang</button>
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
    <?php include "components/footer.php" ?>
    </div>
    </div>

    <?php include "components/script.php" ?>

</body>

</html>