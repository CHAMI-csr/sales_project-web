<?php
session_start();
include '../include/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("location:../pages/home.php?error=login_error");
    exit();
}

if (isset($_POST['add'])) {
    $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $itemname        = mysqli_real_escape_string($con, $_POST['itemName']        ?? '');
    $itemprice       = mysqli_real_escape_string($con, $_POST['itemPrice']       ?? '');
    $itemdescription = mysqli_real_escape_string($con, $_POST['itemDescription'] ?? '');
    $itemqty         = mysqli_real_escape_string($con, $_POST['itemQty']         ?? '');
    $itemcategory    = mysqli_real_escape_string($con, $_POST['itemCategory']    ?? '');
    $folder    = "../images/items/";
    $itemImage = $_FILES['itemImage']['name']   ?? '';
    $tmp_name  = $_FILES['itemImage']['tmp_name'] ?? '';
    $size      = $_FILES['itemImage']['size']   ?? 0;

    if ($size > 2000000) {
        header("location:../pages/Supplier_Dashboard.php?error=large_file");
        exit();
    }
    if (empty($itemname) || empty($itemprice) || empty($itemdescription) || empty($itemImage) || empty($itemqty) || empty($itemcategory)) {
        header("location:../pages/Supplier_Dashboard.php?error=empty_fields");
        exit();
    }

    // Generate unique pid
    do {
        $item_id = 'item_' . rand(1000, 9999);
        $check   = mysqli_query($con, "SELECT pid FROM production WHERE pid='$item_id'");
    } while ($check && mysqli_num_rows($check) > 0);

    $safe_image = mysqli_real_escape_string($con, $itemImage);

    $query   = "INSERT INTO production(pid, user_id, pname, categories, discription, price, image, qty) VALUES('$item_id', '$user_id','$itemname', '$itemcategory', '$itemdescription', '$itemprice', '$safe_image', '$itemqty')";
    $result2 = mysqli_query($con, $query);
    if ($result2) {
        move_uploaded_file($tmp_name, $folder . $itemImage);
        header("location:../pages/Supplier_Dashboard.php?success=add_success");
        exit();
    } else {
        header("location:../pages/Supplier_Dashboard.php?error=add_error");
        exit();
    }
}
?>