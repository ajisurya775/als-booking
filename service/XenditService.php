<?php

function createInvoice($XenditCredential, $orderNumber, $amount)
{
    $url = 'https://api.xendit.co/v2/invoices';
    $data = [
        'external_id' => $orderNumber,
        'amount' => $amount,
        'invoice_duration' => 180,
        'success_redirect_url' => 'https://haha.com'
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic ' . base64_encode($XenditCredential . ':')
    ]);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function getXenditCredentialKey($pdo)
{
    $stmt = $pdo->prepare("select credential_key from xendit_credentials");
    $stmt->execute();

    return $stmt->fetch();
}

function insertXenditInvoiceResponse($pdo, $xenditResponse, $orderId, $amount)
{
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO xendit_invoice_responses (order_id, amount, payment_url, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$orderId, $amount, $xenditResponse['invoice_url'], $now, $now]);
}
