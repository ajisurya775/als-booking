<?php
require '../vendor/autoload.php';
require '../configs/connection.php';

use Dompdf\Dompdf;
use Dompdf\Options;

try {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);


    $query = "SELECT 
                o.id, o.order_number,
                o.name AS name_user, 
                o.status, 
                od.quantity, 
                od.price, 
                o.date_departure, 
                od.from_province, od.to_province, 
                o.created_at, 
                buses.name AS bus_name, 
                o.sub_total, 
                o.grand_total, 
                i.payment_url, 
                s.address, 
                s.name AS station
              FROM orders AS o
              JOIN order_details AS od ON o.id = od.order_id
              JOIN bus_departures AS bd ON od.bus_departure_id = bd.id
              JOIN buses ON bd.bus_id = buses.id
              JOIN xendit_invoice_responses AS i ON o.id = i.order_id
              JOIN stations AS s ON o.station_id = s.id
              WHERE o.id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    // Fetch the main data
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        throw new Exception('No data found for the provided order number.');
    }

    $query = "SELECT oc.order_chairs, b.code
              FROM order_chairs AS oc
              JOIN order_details AS od ON oc.order_id = od.order_id
              JOIN bus_departures AS bd ON od.bus_departure_id = bd.id
              JOIN buses AS b ON bd.bus_id = b.id
              WHERE od.order_id = :order_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['order_id' => $data['id']]);

    $orderChairs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $chairNumbers = array_map(function ($chair) {
        return $chair['order_chairs'];
    }, $orderChairs);

    $busCode = !empty($orderChairs) ? $orderChairs[0]['code'] : '';

    $html = '
    <!DOCTYPE html>
    <html>

    <head>
        <title>Ticket</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                color: #000;
                background: #fff;
            }

            .ticket-box {
                width: 100%;
                max-width: 800px;
                margin: auto;
                padding: 20px;
                position: relative;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .header h1 {
                margin: 0;
                font-size: 24px;
                text-transform: uppercase;
            }

            .header .sub-title {
                font-size: 18px;
            }

            .details {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .details td,
            .details th {
                border: 1px solid #000;
                padding: 8px;
            }

            .details th {
                background: #eee;
                text-align: left;
            }

            .footer {
                position: absolute;
                bottom: 10px;
                width: 100%;
                text-align: left;
            }

            .stamp {
                position: absolute;
                left: 20px;
                top: 180px;
                transform: rotate(-20deg);
                font-size: 24px;
                color: blue;
                border: 2px solid blue;
                padding: 5px 10px;
                border-radius: 5px;
            }

            .seat-number {
                text-align: center;
                font-size: 18px;
                margin-top: 10px;
            }

            .bus-code {
                text-align: center;
                font-size: 18px;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="ticket-box">
            <div class="header">
                <h1>Super Executive</h1>
                <div class="sub-title">ALS</div>
                <div>Jl. Sisingamangaraja Km. 6,5</div>
                <div>Medan - Indonesia</div>
                <div>Tel: (061) 7866685 | Fax: (061) 7866744</div>
            </div>

            <table class="details">
                <tr>
                    <th>Tanggal</th>
                    <th>Dari</th>
                    <th>Ke</th>
                    <th>Nama</th>
                    <th>Jml PNP</th>
                    <th>Subtotal</th>
                    <th>Grand Total</th>
                </tr>
                <tr>
                    <td>' . htmlspecialchars($data['date_departure']) . '</td>
                    <td>' . htmlspecialchars($data['from_province']) . '</td>
                    <td>' . htmlspecialchars($data['to_province']) . '</td>
                    <td>' . htmlspecialchars($data['name_user']) . '</td>
                    <td>' . htmlspecialchars($data['quantity']) . '</td>
                    <td>Rp ' . number_format($data['sub_total'], 2, ',', '.') . '</td>
                    <td>Rp ' . number_format($data['grand_total'], 2, ',', '.') . '</td>
                </tr>
            </table>

            <div class="stamp">Lunas</div>

            <div class="seat-number">
                <strong>No. Tempat Duduk</strong><br>' . implode(', ', $chairNumbers) . '
            </div>

            <div class="bus-code">
                <strong>Kode Bus</strong><br>' . htmlspecialchars($busCode) . '
            </div>

            <div class="footer">
                <div>Medan, ' . date('d-m-Y', strtotime($data['created_at'])) . '</div>
                <div>Petugas</div>
            </div>
        </div>
    </body>

    </html>
    ';

    // Load the HTML content
    $dompdf->loadHtml($html);

    // Set the paper size and orientation to landscape
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF (1 = download and 0 = preview)
    $dompdf->stream("ticket.pdf", ["Attachment" => 1]);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
