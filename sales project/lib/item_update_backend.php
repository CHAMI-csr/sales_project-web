<?php
session_start();
include '../include/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {

    $pid = $_POST['pid'];
    $itemName = $_POST['itemName'];
    $itemCategory =  $_POST['itemCategory'];
    $itemPrice =$_POST['itemPrice'];
    $itemDescription = $_POST['itemDescription'];
    $itemQty =  $_POST['itemQty'];
    $old_image =  $_POST['old_image'];
    $new_image_name = $old_image; // Default to old image name

    // Check if a new image was uploaded
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $img_name = $_FILES['itemImage']['name'];
        $tmp_name = $_FILES['itemImage']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png", "gif");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_image_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $image_upload_path = '../images/items/' . $new_image_name;

            if (move_uploaded_file($tmp_name, $image_upload_path)) {
                if (!empty($old_image) && file_exists('../images/items/' . $old_image) && $old_image !== 'default_item_image.png') {
                    unlink('../images/items/' . $old_image);
                }
            } else {
                echo "Error uploading the new image.";
                exit();
            }
        } else {
            echo "You can't upload files of this type.";
            exit();
        }
    }

    $query = "UPDATE production SET 
                pname = '$itemName', 
                categories = '$itemCategory', 
                price = '$itemPrice', 
                discription = '$itemDescription', 
                qty = '$itemQty', 
                image = '$new_image_name' 
              WHERE pid = '$pid' AND user_id = '$user_id'";

    if (mysqli_query($con, $query)) {
        header("Location: ../pages/Supplier_Dashboard.php?update=success");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>