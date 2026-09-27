<?php
session_start();
include "../include/connection.php";

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    echo "Access Denied";
    exit();
}

if (!isset($_GET['pid']) || !isset($_GET['user_id'])) {
    header("Location: ../pages/prodouct.php");
    exit();
}

$pid     = mysqli_real_escape_string($con, $_GET['pid']);
$user_id = mysqli_real_escape_string($con, $_GET['user_id']);

$query  = "SELECT image FROM production WHERE pid='$pid' AND user_id='$user_id'";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $imagename = $row['image'];
    $imagepath = "../../images/items/";
    if (!empty($imagename) && file_exists($imagepath . $imagename)) {
        unlink($imagepath . $imagename);
    }
}

$query  = "DELETE FROM production WHERE pid = '$pid' AND user_id = '$user_id'";
$result = mysqli_query($con, $query);
if ($result) {
    header("Location: ../pages/prodouct.php");
    exit();
} else {
    header("Location: ../pages/prodouct.php?error=delete_error");
    exit();
}
?>