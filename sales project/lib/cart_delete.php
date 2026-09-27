<?php
session_start();
include '../include/connection.php';

if (isset($_GET['order_id']) && isset($_GET['pid']) && isset($_SESSION['user_id'])) {
    $pid = mysqli_real_escape_string($con, $_GET['pid']);
    $order_id = mysqli_real_escape_string($con, $_GET['order_id']);
    $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);

    $redirect = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/items.php';

    $query = "SELECT qty FROM ordertable WHERE orderid = '$order_id' AND user_id = '$user_id' AND pid = '$pid'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $qty = (int)$row['qty'];

        $update_production_query = "UPDATE production SET qty = qty + $qty WHERE pid = '$pid'";
        mysqli_query($con, $update_production_query);

        $delete_query = "DELETE FROM ordertable WHERE orderid = '$order_id' AND pid = '$pid' AND user_id = '$user_id'";
        $result = mysqli_query($con, $delete_query);

        if ($result) {
            header("Location: " . $redirect);
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($con);
        }
    } else {
        header("Location: " . $redirect);
        exit();
    }
} else {
    header("Location: ../pages/home.php");
    exit();
}
?>