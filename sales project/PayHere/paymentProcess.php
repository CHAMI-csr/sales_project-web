<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// PayHere Checkout Configuration
// IMPORTANT:
// 1. $merchant_id must be your 6-7 digit numeric Merchant ID (e.g. "1231870"), NOT the App ID!
// 2. $merchant_secret is from "Domains & Credentials" in PayHere Dashboard, NOT the App Secret!
// (App ID & App Secret from the API Keys tab are for Server-to-Server OAuth REST API only).

$merchant_id = "1231870"; // Your numeric PayHere Sandbox Merchant ID
$merchant_secret = "MjczODA4NzA0MzE5Nzk2MzExNzIxOTA1NDg1MTYyNjIwNzIzMTY5"; // Your PayHere Merchant Secret

$order_id = "ORD" . date("YmdHis") . rand(100, 999);
$amount = isset($_SESSION['total_price']) ? (float)$_SESSION['total_price'] : 0.00;
$formatted_amount = number_format($amount, 2, '.', '');
$currency = "LKR";

$item_desc = "TecHub Order " . $order_id;

// PayHere Hash Generation: strtoupper(md5(merchant_id + order_id + amount + currency + strtoupper(md5(merchant_secret))))
$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        $formatted_amount .
        $currency .
        strtoupper(md5($merchant_secret))
    )
);

$valueArray = [];
$valueArray["merchant_id"] = $merchant_id;
$valueArray["order_id"] = $order_id;
$valueArray["amount"] = $formatted_amount;
$valueArray["currency"] = $currency;
$valueArray["item"] = $item_desc;
$valueArray["items"] = $item_desc;
$valueArray["hash"] = $hash;
$valueArray["first_name"] = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Customer';
$valueArray["email"] = isset($_SESSION['email']) ? $_SESSION['email'] : 'customer@techub.com';

header('Content-Type: application/json');
echo json_encode($valueArray);
?>
