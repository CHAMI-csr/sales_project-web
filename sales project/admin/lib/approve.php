<?php
session_start();
include "../include/connection.php";

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    echo "Access Denied";
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $query = "UPDATE businessregistration SET approve='1' WHERE id='$id'";
    if (mysqli_query($con, $query)) {
        header("location:../pages/manage.php");
        exit();
    }
}
?>