<?php
session_start();
include '../include/connection.php';

if (isset($_POST['pid']) && isset($_POST['qty'])) {
    $pid = $_POST['pid'];
    $qty_selected = intval($_POST['qty']);
    $user_id = $_SESSION['user_id'];

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
        $pname = $row['pname'];
        $price = $row['price'];
        $categories = $row['categories'];
        $discription = $row['discription'];
        
        $update_production_query = "UPDATE production SET qty = qty - '$qty_selected' WHERE pid='$pid'";
        mysqli_query($con, $update_production_query);



        $query = "SELECT * FROM ordertable WHERE user_id='$user_id' AND pid='$pid'";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $current_qty = $row['qty'];
            $new_qty = $current_qty + $qty_selected;
            $new_price = $price * $new_qty;
            $update_query = "UPDATE ordertable SET qty='$new_qty', price='$new_price' WHERE user_id='$user_id' AND pid='$pid'";
            $update_result = mysqli_query($con, $update_query);
            if ($update_result) {
            header("location:../pages/items.php");
            exit();
            } else {
            header("location:../pages/items.php?error=add_error");
            exit();
            }
        } else {
            $query2 = "INSERT INTO ordertable(orderid, user_id, pid, pname, categories, discription, price, qty) VALUES('$order_id', '$user_id', '$pid', '$pname', '$categories', '$discription', '$price', '$qty_selected')";
            $result2 = mysqli_query($con, $query2);
            if ($result2) {
                header("location:../pages/items.php");
                exit();
            } else {
                header("location:../pages/items.php?error=add_error");
                exit();
            }
        }


    } else {
        header("location:../pages/items.php?error=not_found");
        exit();
    }
}
?>