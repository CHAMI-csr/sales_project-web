<?php
session_start();


$merchant_id = "1231870";
$order_id = uniqid();
$amount = $_SESSION['total_price'] ;
$currency = "LKR";
$merchant_secret = "MjQ1NDY4ODgyOTE5MzI2ODQzMDk1NDMyMzEyNzAzMTcxNDA4NjQy";
$item=array('jjjjj','kkjkkk');
$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        number_format($amount, 2, '.', '') .
        $currency .
        strtoupper(md5($merchant_secret))
    )
);

$valueArray = [];
$valueArray["merchant_id"] = $merchant_id;
$valueArray["order_id"] = $order_id;
$valueArray["amount"] = $amount;
$valueArray["currency"] = $currency;
$valueArray["item"] = $item;
$valueArray["hash"] = $hash;

$jsonObj = json_encode($valueArray);

echo $jsonObj;
