<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../../configs/config_url.php" ?>
    <?php include "../components/header.php" ?>
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
                <?php include "../components/navbar.php" ?>
            </nav>

            <?php include "../components/sidebar.php" ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Invoice</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="/">Pesan Tiket</a></div>
                            <div class="breadcrumb-item">Transaksi</div>
                        </div>
                    </div>

                    <?php

                    require_once "../../configs/connection.php";

                    $id = $_GET['id'];

                    $query = "select o.id, o.order_number, o.status, od.quantity, od.price, o.date_departure, od.from_province, od. to_province, o.created_at, buses.name, o.sub_total, o.grand_total, i.payment_url, s.address, s.name as station
                    from orders as o
                    join order_details as od on o.id = od.order_id
                    join bus_departures as bd on od.bus_departure_id = bd.id
                    join buses on bd.bus_id = buses.id
                    join xendit_invoice_responses as i on o.id = i.order_id
                    join stations as s on o.station_id = s.id
                    where o.id=:id";

                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['id' => $id]);

                    $transaction =  $stmt->fetch();
                    ?>

                    <div class="section-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="invoice-title">
                                            <h2>Stasiun <?= $transaction['station'] ?></h2>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong>Nomer Pesanan:</strong><br>
                                                    <?= $transaction['order_number'] ?><br><br>
                                                    <strong>Alamat :</strong><br>
                                                    <?= $transaction['address'] ?><br><br>
                                                    <strong>Pembayaran:</strong><br>
                                                    <?php
                                                    require_once "../../Traits/function.php";
                                                    $class = statusOrder($transaction['status']);
                                                    ?>
                                                    <div class="<?= $class ?>"><?= $transaction['status'] ?></div><br><br>
                                                    <strong>Tanggal Keberangkatan:</strong><br>
                                                    <?= $transaction['date_departure'] ?><br><br>
                                                    <strong>Tanggal Dibuat:</strong><br>
                                                    <?= date('Y/m/d H:i:s', strtotime($transaction['created_at'])); ?><br><br>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="section-title">Detail Pesanan</div>
                                        <p class="section-lead">Nomer Kursi anda akan muncul Ketika sudah terbayarkan .</p>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tr>
                                                    <th data-width="40">#</th>
                                                    <th class="text-center">bus</th>
                                                    <th class="text-center">Dari</th>
                                                    <th class="text-center">Tujuan</th>
                                                    <th class="text-right">Jumlah</th>
                                                    <th class="text-right">Harga</th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-center"><?= $transaction['name'] ?></td>
                                                    <td class="text-center"><?= $transaction['from_province'] ?></td>
                                                    <td class="text-center"><?= $transaction['to_province'] ?></td>
                                                    <td class="text-right"><?= $transaction['quantity'] ?></td>
                                                    <td class="text-right"><?= number_format($transaction['price'], 2, ',', '.') ?></td>
                                                </tr>


                                            </table>
                                        </div>
                                        <div class="row mt-4">

                                            <div class="col-lg-8">
                                                <?php if ($transaction['status'] == 'Paid' || $transaction['status'] == 'Finish') { ?>
                                                    <div class="section-title">Kursi</div>
                                                <?php
                                                }

                                                $query = "SELECT oc.order_chairs, b.code
                                                            FROM order_chairs AS oc
                                                            JOIN order_details AS od ON oc.order_id = od.order_id
                                                            JOIN bus_departures AS bd ON od.bus_departure_id = bd.id
                                                            JOIN buses AS b ON bd.bus_id = b.id
                                                            WHERE od.order_id = :order_id";

                                                $stmt = $pdo->prepare($query);
                                                $stmt->execute(['order_id' => $id]);

                                                $orderChairs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                $chairNumbers = array_map(function ($orderChair) {
                                                    return '<span class="chair">' . $orderChair['code'] . '-' . $orderChair['order_chairs'] . '</span>';
                                                }, $orderChairs);

                                                $chairs = implode(' ', $chairNumbers);

                                                ?>
                                                <?php if ($transaction['status'] == 'Paid' || $transaction['status'] == 'Finish') { ?>
                                                    <div class="chairs-container"><?= $chairs ?></div>
                                                <?php } ?>
                                            </div>

                                            <style>
                                                .section-title {
                                                    font-size: 24px;
                                                    font-weight: bold;
                                                    margin-bottom: 10px;
                                                }

                                                .chairs-container {
                                                    display: flex;
                                                    flex-wrap: wrap;
                                                    gap: 10px;
                                                }

                                                .chair {
                                                    background-color: #f0f0f0;
                                                    border: 1px solid #ccc;
                                                    border-radius: 5px;
                                                    padding: 5px 10px;
                                                    font-size: 16px;
                                                    font-weight: bold;
                                                }
                                            </style>


                                            <div class="col-lg-4 text-right">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name">Subtotal</div>
                                                    <div class="invoice-detail-value">Rp <?= number_format($transaction['sub_total'], 2, ',', '.') ?></div>
                                                </div>
                                                <hr class="mt-2 mb-2">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name">Grand Total</div>
                                                    <div class="invoice-detail-value invoice-detail-value-lg">Rp <?= number_format($transaction['grand_total'], 2, ',', '.') ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <?php if ($transaction['status'] == 'Pending') { ?>
                                        <a href="<?= $transaction['payment_url'] ?>" target="_blank" class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</a>
                                    <?php } ?>
                                    <?php if ($transaction['status'] == 'Pending') { ?>
                                        <a class="btn btn-danger btn-icon icon-left" href="<?= $config['base_url'] . 'controllers/InvoiceController.php?action=changeStatus&order_number=' . $transaction['order_number'] ?>"><i class="fas fa-times"></i> Cancel</a>
                                    <?php } ?>
                                </div>
                                <a class="btn btn-warning btn-icon icon-left" href="<?= $config['base_url'] . 'controllers/PdfController.php?id=' . $transaction['id'] ?>"><i class="fas fa-download"></i> Download</a>
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
    <?php include "../components/footer.php" ?>
    </div>
    </div>

    <?php include "../components/script.php" ?>

</body>

</html>