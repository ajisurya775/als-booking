<?php

require_once('../vendor/autoload.php');
require_once('../configs/config_url.php');

use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

function createInvoice($XenditCredential, $orderNumber, $amount, $succesRedirectUrl)
{
    Configuration::setXenditKey($XenditCredential);

    $apiInstance = new InvoiceApi();
    $data = [
        'external_id' => $orderNumber,
        'amount' => $amount,
        'invoice_duration' => 180, // payment duration 3 minutes on the value of seconds
        'payment_methods' => ["CREDIT_CARD", "BCA", "BNI", "BSI", "BRI", "MANDIRI", "PERMATA", "SAHABAT_SAMPOERNA", "BNC", "OVO", "DANA", "SHOPEEPAY", "LINKAJA", "JENIUSPAY", "DD_BRI", "DD_BCA_KLIKPAY", "KREDIVO", "AKULAKU", "UANGME", "ATOME", "QRIS"],
        'success_redirect_url' => $succesRedirectUrl
    ];
    try {
        $result = $apiInstance->createInvoice($data);
        return $result;
    } catch (\Xendit\XenditSdkException $e) {
        echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
        echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
    }
}

function getXenditCredentialKey($pdo)
{
    $stmt = $pdo->prepare("select * from xendit_credentials");
    $stmt->execute();

    return $stmt->fetch();
}

function insertXenditInvoiceResponse($pdo, $xenditResponse, $orderId, $amount)
{
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO xendit_invoice_responses (order_id, amount, payment_url, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$orderId, $amount, $xenditResponse['invoice_url'], $now, $now]);
}

function insertXenditRequestAndResponseLog($pdo)
{
}
