<?php
session_start();
include "../include/connection.php";


if (isset($_SESSION['user_id']) && isset($_POST['orderId'])) {
    $user_id = $_SESSION['user_id'];
    $new_orderId = $_POST['orderId'];

    $query = "SELECT * FROM ordertable WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $original_order_id = null;
        while ($row = mysqli_fetch_assoc($result)) {
            $pid = $row['pid'];
            $pname = $row['pname'];
            $qty = $row['qty'];
            $price = $row['price'];
            $original_order_id = $row['orderid'];


            $insert_query = "INSERT INTO orderhistory (user_id, pid, orderid, pnames, qty, totalprice, date) 
                             VALUES ('$user_id', '$pid', '$new_orderId', '$pname', '$qty', '$price', NOW())";
            mysqli_query($con, $insert_query);
        }


        $delete_query = "DELETE FROM ordertable WHERE user_id = '$user_id' AND orderid = '$original_order_id'";
        mysqli_query($con, $delete_query);

        echo "success";

    } else {
        echo "error: No order found";
    }
} else {
    echo "error: Invalid request";
}
?>