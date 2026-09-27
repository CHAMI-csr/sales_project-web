<?php
session_start();
include '../include/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home.php");
    exit();
}

$user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);

if (isset($_POST['update'])) {

    $pid             = mysqli_real_escape_string($con, $_POST['pid']             ?? '');
    $itemName        = mysqli_real_escape_string($con, $_POST['itemName']        ?? '');
    $itemCategory    = mysqli_real_escape_string($con, $_POST['itemCategory']    ?? '');
    $itemPrice       = mysqli_real_escape_string($con, $_POST['itemPrice']       ?? '');
    $itemDescription = mysqli_real_escape_string($con, $_POST['itemDescription'] ?? '');
    $itemQty         = mysqli_real_escape_string($con, $_POST['itemQty']         ?? '');
    $old_image       = mysqli_real_escape_string($con, $_POST['old_image']       ?? '');
    $new_image_name  = $old_image; // Default to old image

    // Check if a new image was uploaded
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $img_name  = $_FILES['itemImage']['name'];
        $tmp_name  = $_FILES['itemImage']['tmp_name'];
        $img_ex    = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = ["jpg", "jpeg", "png", "gif"];

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_image_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $image_upload_path = '../images/items/' . $new_image_name;

            if (move_uploaded_file($tmp_name, $image_upload_path)) {
                $raw_old = $_POST['old_image'] ?? '';
                if (!empty($raw_old) && file_exists('../images/items/' . $raw_old) && $raw_old !== 'default_item_image.png') {
                    unlink('../images/items/' . $raw_old);
                }
            } else {
                header("Location: ../pages/Supplier_Dashboard.php?error=upload_error");
                exit();
            }
        } else {
            header("Location: ../pages/Supplier_Dashboard.php?error=invalid_image_type");
            exit();
        }
    }

    $new_image_escaped = mysqli_real_escape_string($con, $new_image_name);

    $query = "UPDATE production SET 
                pname = '$itemName', 
                categories = '$itemCategory', 
                price = '$itemPrice', 
                discription = '$itemDescription', 
                qty = '$itemQty', 
                image = '$new_image_escaped' 
              WHERE pid = '$pid' AND user_id = '$user_id'";

    if (mysqli_query($con, $query)) {
        header("Location: ../pages/Supplier_Dashboard.php?update=success");
        exit();
    } else {
        header("Location: ../pages/Supplier_Dashboard.php?error=update_error");
        exit();
    }
} else {
    header("Location: ../pages/Supplier_Dashboard.php");
    exit();
}
?>