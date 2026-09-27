<?php
session_start();
include '../include/connection.php';

if (isset($_POST['pid']) && isset($_POST['qty'])) {
    if (!isset($_SESSION['user_id'])) {
        $redirect = !empty($_POST['redirect_url']) ? $_POST['redirect_url'] : (!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/home.php');
        $sep = (strpos($redirect, '?') !== false) ? '&' : '?';
        header("location:" . $redirect . $sep . "error=login_error");
        exit();
    }

    $pid = mysqli_real_escape_string($con, $_POST['pid']);
    $qty_selected = max(1, intval($_POST['qty']));
    $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $redirect_target = !empty($_POST['redirect_url']) ? $_POST['redirect_url'] : (!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/items.php');

    // Clean existing query params on target if error was present
    $parsed_url = parse_url($redirect_target);
    $clean_redirect = $parsed_url['path'] ?? '../pages/items.php';
    if (!empty($parsed_url['query'])) {
        parse_str($parsed_url['query'], $qparams);
        unset($qparams['error'], $qparams['success']);
        if (!empty($qparams)) {
            $clean_redirect .= '?' . http_build_query($qparams);
        }
    }

    $query = "SELECT * FROM ordertable WHERE user_id='$user_id'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $order_id = $row['orderid'];
    } else {
        do {
            $order_id = 'Order_' . rand(10000, 99999);
            $check_query = "SELECT orderid FROM ordertable WHERE orderid='$order_id'";
            $check_result = mysqli_query($con, $check_query);
        } while ($check_result && mysqli_num_rows($check_result) > 0);
    }

    $query = "SELECT * FROM production WHERE pid='$pid'";
    $result1 = mysqli_query($con, $query);
    if ($result1 && mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $pname = mysqli_real_escape_string($con, $row['pname']);
        $price = (float)$row['price'];
        $categories = mysqli_real_escape_string($con, $row['categories']);
        $discription = mysqli_real_escape_string($con, $row['discription']);
        
        $update_production_query = "UPDATE production SET qty = GREATEST(0, qty - $qty_selected) WHERE pid='$pid'";
        mysqli_query($con, $update_production_query);

        $query = "SELECT * FROM ordertable WHERE user_id='$user_id' AND pid='$pid'";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $current_qty = (int)$row['qty'];
            $new_qty = $current_qty + $qty_selected;
            $new_price = $price * $new_qty;
            $update_query = "UPDATE ordertable SET qty='$new_qty', price='$new_price' WHERE user_id='$user_id' AND pid='$pid'";
            $update_result = mysqli_query($con, $update_query);
            if ($update_result) {
                header("location:" . $clean_redirect);
                exit();
            } else {
                $sep = (strpos($clean_redirect, '?') !== false) ? '&' : '?';
                header("location:" . $clean_redirect . $sep . "error=add_error");
                exit();
            }
        } else {
            $initial_price = $price * $qty_selected;
            $query2 = "INSERT INTO ordertable(orderid, user_id, pid, pname, categories, discription, price, qty) VALUES('$order_id', '$user_id', '$pid', '$pname', '$categories', '$discription', '$initial_price', '$qty_selected')";
            $result2 = mysqli_query($con, $query2);
            if ($result2) {
                header("location:" . $clean_redirect);
                exit();
            } else {
                $sep = (strpos($clean_redirect, '?') !== false) ? '&' : '?';
                header("location:" . $clean_redirect . $sep . "error=add_error");
                exit();
            }
        }
    } else {
        $sep = (strpos($clean_redirect, '?') !== false) ? '&' : '?';
        header("location:" . $clean_redirect . $sep . "error=not_found");
        exit();
    }
}
?>