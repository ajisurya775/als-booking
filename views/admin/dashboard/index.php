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

            <?php

            require_once "../../../configs/connection.php";

            $stmt = $pdo->prepare("
            SELECT
        SUM(CASE WHEN DATE(created_at) = CURDATE() THEN grand_total ELSE 0 END) as today_revenue,
        SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN grand_total ELSE 0 END) as this_month_revenue,
        SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) THEN grand_total ELSE 0 END) as last_month_revenue,
        SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN grand_total ELSE 0 END) as this_year_revenue
    FROM orders
            ");
            $stmt->execute();

            $revenue = $stmt->fetch();

            ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Today's Revenue</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= number_format($revenue['today_revenue'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-newspaper"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>This Month</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= number_format($revenue['this_month_revenue'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="far fa-file"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Last Month</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= number_format($revenue['last_month_revenue'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="far fa-file"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>This Year</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= number_format($revenue['this_year_revenue'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Sales Performance</h4>

                                    <div class="form-group">
                                        <form action="<?= $config['base_url'] . 'views/admin/dashboard' ?>" method="GET">
                                            <label for="start-date"></label>
                                            <?php
                                            $defaultStartDate = date('Y-m-d', strtotime('-7 days'));
                                            ?>
                                            <input type="date" class="form-control" name="start-date" value="<?php echo $defaultStartDate; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="end-date"></label>
                                        <?php
                                        $defaultEndDate = date('Y-m-d');
                                        ?>
                                        <input type="date" class="form-control" name="end-date" value="<?php echo $defaultEndDate; ?>">
                                    </div>

                                    <button class="btn btn-info" type="submit">Generated</button>
                                    </form>
                                </div>

                                <?php

                                require_once '../../../Traits/function.php';

                                $startDate = $_GET['start-date'] ?? date('Y-m-d', strtotime('-7 days'));
                                $endDate = $_GET['end-date'] ?? date('Y-m-d');

                                $stmt = $pdo->prepare("
                                SELECT  SUM(CAST(grand_total AS DECIMAL(10, 2))) as amount,
                                date(created_at) as date, 
                                month(created_at) as month, 
                                year(created_at) as year 
                                from orders
                                where date(created_at) >= :start_date
                                and date(created_at) <= :end_date 
                                and status in ('Finish', 'Paid')
                                group by date, month, year
                                ");

                                $stmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);

                                $sales = $stmt->fetchAll();

                                $dateTemplate = generateStartEndDateTemplateGraph($startDate, $endDate);

                                foreach ($sales as $sale) {
                                    $dateTemplate[$sale['date']] = (float)$sale['amount'];
                                }

                                $labels = array_keys($dateTemplate);
                                $data = array_values($dateTemplate);

                                ?>

                                <div class="card-body">
                                    <canvas id="myChart2"></canvas>
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

    <!-- JS Libraies -->
    <script src="<?= $config['base_url'] ?>assets/modules/chart.min.js"></script>

    <!-- Page Specific JS File -->
    <script>
        var ctx = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode($data) ?>,
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderColor: '#6777ef',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: "200000",
                            callback: function(value, index, values) {
                                if (value >= 1000000) {
                                    return (value / 1000000) + ' M';
                                } else if (value >= 1000) {
                                    return (value / 1000) + ' k';
                                } else {
                                    return value;
                                }
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            display: false
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
            }
        });
    </script>


</body>

</html>