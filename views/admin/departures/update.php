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

                                    <?php

                                    require_once '../../../configs/connection.php';
                                    require_once '../../../service/DepartureService.php';

                                    $departureId = $_GET['id'];
                                    $departure = getDepartureById($pdo, $departureId);


                                    ?>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 offset-lg-3">
                                                <form action="<?= $config['base_url'] . 'controllers/DepartureController.php?action=update' ?>" method="post" class="needs-validation" novalidate="" id="priceForm">

                                                    <input type="text" hidden name="id" value="<?= $departure['id'] ?>">

                                                    <div class="form-group">
                                                        <label for="name">Bus</label>
                                                        <select name="bus_id" id="" class="form-control">
                                                            <option value="<?= $departure['bus_id'] ?>"><?= $departure['bus'] ?></option>
                                                            <?php

                                                            $stmt = $pdo->prepare('select * from buses where status = 1');
                                                            $stmt->execute();

                                                            $buses = $stmt->fetchAll();

                                                            foreach ($buses as $key => $value) {
                                                                if ($value['id'] != $departure['bus_id']) {
                                                            ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Departure From</label>
                                                        <select name="from_province_id" id="" class="form-control">
                                                            <option value="1">Medan</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Departure to</label>
                                                        <select name="to_province_id" id="" class="form-control">
                                                            <option value="<?= $departure['to_province_id'] ?>"><?= $departure['to_province'] ?></option>
                                                            <?php

                                                            $stmt = $pdo->prepare('select * from provinces where not id = 1');
                                                            $stmt->execute();

                                                            $provinces = $stmt->fetchAll();
                                                            foreach ($provinces as $key => $value) {
                                                                if ($value['id'] != $departure['to_province_id']) {
                                                            ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Operating Schdules</label>
                                                        <select name="departure_hour_id" id="" class="form-control">
                                                            <option value="<?= $departure['departure_hour_id'] ?>"><?= $departure['hour'] ?></option>
                                                            <?php
                                                            $stmt = $pdo->prepare('select * from departure_hours');
                                                            $stmt->execute();

                                                            $hours = $stmt->fetchAll();
                                                            foreach ($hours as $key => $value) {
                                                                if ($value['id'] != $departure['departure_hour_id']) {
                                                            ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['hour'] ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="text" id="price" class="form-control" name="price" tabindex="1" value="<?= (float)$departure['price'] ?>" required autofocus>
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

    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function cleanRupiah(rupiah) {
            return rupiah.replace(/[^,\d]/g, '').toString();
        }

        document.getElementById('price').addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value, 'Rp. ');
        });

        document.addEventListener('DOMContentLoaded', function() {
            var priceInput = document.getElementById('price');
            if (priceInput.value) {
                priceInput.value = formatRupiah(priceInput.value, 'Rp. ');
            }
        });

        document.getElementById('price').addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value, 'Rp. ');
        });

        document.getElementById('priceForm').addEventListener('submit', function(e) {
            var priceInput = document.getElementById('price');
            priceInput.value = cleanRupiah(priceInput.value);
        });
    </script>

</body>

</html>