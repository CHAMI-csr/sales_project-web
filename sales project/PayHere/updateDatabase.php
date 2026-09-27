<?php
session_start();
include "../include/connection.php";


if (isset($_SESSION['user_id']) && isset($_POST['orderId'])) {
    $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $new_orderId = mysqli_real_escape_string($con, $_POST['orderId']);

    $query = "SELECT * FROM ordertable WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pid = mysqli_real_escape_string($con, $row['pid']);
            $pname = mysqli_real_escape_string($con, $row['pname']);
            $qty = (int)$row['qty'];
            $price = (float)$row['price'];

            $insert_query = "INSERT INTO orderhistory (user_id, pid, orderid, pnames, qty, totalprice, date) 
                             VALUES ('$user_id', '$pid', '$new_orderId', '$pname', '$qty', '$price', NOW())";
            mysqli_query($con, $insert_query);
        }

        $delete_query = "DELETE FROM ordertable WHERE user_id = '$user_id'";
        mysqli_query($con, $delete_query);

        echo "success";
    } else {
        echo "error: No order found";
    }
} else {
    echo "error: Invalid request";
}
?>