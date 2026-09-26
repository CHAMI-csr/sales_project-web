<?php
session_start();
include "../include/connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE businessregistration SET approve='0' WHERE id='$id'";
    if (mysqli_query($con, $query)) {
        header("location:../pages/manage.php");
        exit();
    }
}
?>