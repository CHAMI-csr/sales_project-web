<?php
session_start();
include '../include/connection.php';

if (isset($_GET['order_id']) && isset($_GET['pid']) && isset($_SESSION['user_id'])) {

    $pid = $_GET['pid'];
    $order_id = $_GET['order_id'];
    $user_id = $_SESSION['user_id'];

    $query = "SELECT qty FROM ordertable WHERE orderid = '$order_id' AND user_id = '$user_id' AND pid = '$pid'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $qty = $row['qty'];

        
        $update_production_query = "UPDATE production SET qty = qty + '$qty' WHERE pid = '$pid'";
        mysqli_query($con, $update_production_query);

        $delete_query = "DELETE FROM ordertable WHERE orderid = '$order_id' AND pid = '$pid' AND user_id = '$user_id'";
        $result = mysqli_query($con, $delete_query);
     
        if ($result) {
            header("Location: ../pages/items.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($con);
        }
    } else {
        echo "Order item not found or you don't have permission to delete it.";
    }
} else {
    echo "Invalid request.";
}
?>