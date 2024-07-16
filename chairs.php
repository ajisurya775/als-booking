<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "configs/config_url.php" ?>
    <?php include "configs/connection.php" ?>
    <?php include "views/components/header.php" ?>

    <style>
        .bus-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            max-width: 600px;
            margin: auto;
        }

        .seat {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-check-input {
            margin-right: 5px;
        }

        .form-check-label {
            font-weight: bold;
        }

        .submit-button {
            text-align: center;
        }
    </style>
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
                <?php include "views/components/navbar.php" ?>
            </nav>

            <?php include "views/components/sidebar.php" ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Selamat Datang Di ALS</h1>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Pilih Kursi Anda</h2>
                        <div class="card-body">
                            <div class="form-group">
                                <form action="<?= $config['base_url'] . 'controllers/OrderController.php?action=create-order&departure_id=' . $_GET['departure_id'] . '&station_id=' . $_GET['station_id'] ?>" method="post" id="checkChair">
                                    <div class="bus-container">
                                        <?php

                                        require_once 'configs/connection.php';

                                        $userId = $_SESSION['id'];
                                        $capacity = $_GET['capacity'];
                                        $code = $_GET['code'];
                                        $date = $_GET['date_departure'];

                                        $stmt = $pdo->prepare("
                                            select 
                                            oc.order_chairs,
                                            o.date_departure,
                                            o.status
                                            from order_chairs as oc
                                            join orders as o on oc.order_id = o.id
                                            join order_details as od on o.id = od.order_id
                                            where o.date_departure = :date and o.status = :status
                                    ");


                                        $stmt->execute([':date' => $date, ':status' => 'Paid']);
                                        $orders = $stmt->fetchAll();

                                        $occupiedChairs = [];
                                        foreach ($orders as $order) {
                                            $occupiedChairs[] = $order['order_chairs'];
                                        }

                                        for ($i = 1; $i <= $capacity; $i++) {
                                            $chairName = $i < 10 ? "$code-0$i" : "$code-$i";

                                            $disable = in_array($i, $occupiedChairs) ? 'disabled' : '';
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="chairs[]" <?= $disable ?> id="inlineCheckbox1" value="<?= $i ?>">
                                                <label class="form-check-label" for="inlineCheckbox1"><?= $chairName ?></label>
                                            </div>

                                        <?php } ?>
                                    </div><br>
                                    <div class="submit-button">
                                        <button type="submit" id="checkBtn" class="btn btn-primary">Pesan Sekarang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </section>
            </div>
        </div>

        <div class="section-body">
        </div>
        </section>
    </div>
    <?php include "views/components/footer.php" ?>
    </div>
    </div>

    <?php include "views/components/script.php" ?>

</body>

<script>
    $(document).ready(function() {
        $('#checkBtn').click(function() {
            checked = $("input[type=checkbox]:checked").length;

            if (!checked) {
                alert("You must check at least one checkbox.");
                return false;
            }
        });
    });
</script>

</html>