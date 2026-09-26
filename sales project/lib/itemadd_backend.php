<?php
session_start();
include '../include/connection.php';

if (isset($_POST['add'])) {
    $user_id = $_SESSION['user_id'];
    $itemname = $_POST['itemName'];
    $itemprice = $_POST['itemPrice'];
    $itemdescription = $_POST['itemDescription'];
    $folder = "../images/items/";
    $itemImage = $_FILES['itemImage']['name'];
    $tmp_name = $_FILES['itemImage']['tmp_name'];
    $size = $_FILES['itemImage']['size'];
    $itemqty = $_POST['itemQty'];
    $item_id = 'item_' . rand(1000, 9999);
    $itemcategory = $_POST['itemCategory'];

    if ($size > 2000000) {
        header("location:../pages/Supplier_Dashboard.php?error=large_file");
        exit();
    }
    if (empty($itemname) || empty($itemprice) || empty($itemdescription) || empty($itemImage) || empty($itemqty) || empty($itemcategory)) {
        header("location:../pages/Supplier_Dashboard.php?error=empty_fields");
        exit();
    }
    



    $query = "INSERT INTO production(pid, user_id, pname, categories, discription, price, image, qty) VALUES('$item_id', '$user_id','$itemname', '$itemcategory', '$itemdescription', '$itemprice', '$itemImage', '$itemqty')";
    $result2 = mysqli_query($con, $query);
    if ($result2) {
        move_uploaded_file($tmp_name, $folder . $itemImage);
        header("location:../pages/Supplier_Dashboard.php?success=add_success");
        exit();
    } else {
        header("location:../pages/Supplier_Dashboard.php?error=add_error");
        exit();
    }

} ?>