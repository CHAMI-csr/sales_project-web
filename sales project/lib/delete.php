<?php
session_start();
include '../include/connection.php';

// Auth: must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home.php");
    exit();
}

if (!isset($_GET['pid']) || !isset($_GET['user_id'])) {
    header("Location: ../pages/Supplier_Dashboard.php");
    exit();
}

$pid     = mysqli_real_escape_string($con, $_GET['pid']);
$user_id = mysqli_real_escape_string($con, $_GET['user_id']);

// Security: only the owning supplier can delete their product
if ($_SESSION['user_id'] !== $_GET['user_id']) {
    header("Location: ../pages/home.php");
    exit();
}

$query  = "SELECT image FROM production WHERE pid='$pid' AND user_id='$user_id'";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $imagename = $row['image'];
    $imagepath = "../images/items/";
    if (!empty($imagename) && file_exists($imagepath . $imagename)) {
        unlink($imagepath . $imagename);
    }
}

$query  = "DELETE FROM production WHERE pid = '$pid' AND user_id = '$user_id'";
$result = mysqli_query($con, $query);
if ($result) {
    header("Location: ../pages/Supplier_Dashboard.php?success=delete_success");
    exit();
} else {
    header("Location: ../pages/Supplier_Dashboard.php?error=delete_error");
    exit();
}
?>