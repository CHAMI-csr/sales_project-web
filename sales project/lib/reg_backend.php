<?php
include '../include/connection.php';

if (isset($_POST['submit'])) {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirm_password']);
    $folder = "../images/profile_images/";
    $image_name = $_FILES['profile_image']['name'];
    $tmp_name = $_FILES['profile_image']['tmp_name'];
    $size = $_FILES['profile_image']['size'];
    $type = $_POST['account_type'];

    do {
        $user_id = 'user_' . rand(1000, 9999);
        $check_id_query = "SELECT * FROM users WHERE user_id='$user_id'";
        $check_id_result = mysqli_query($con, $check_id_query);
    } while(mysqli_num_rows($check_id_result) > 0);

    

    if ($size > 1048576 * 2) {
        header("location:../pages/home.php?error=image_size");
        exit();
    }

   if(empty($firstname)){
        header("location:../pages/home.php?error=First_Name");
        exit();
    }

   if(empty($lastname)){
       header("location:../pages/home.php?error=Last_Name");
       exit();
   }

   if(empty($username)){
       header("location:../pages/home.php?error=Username");
       exit();
   }

   if(empty($email)){
       header("location:../pages/home.php?error=Email");
       exit();
   }

   if(empty($_POST['password'])){
       header("location:../pages/home.php?error=Password");
       exit();
   }

   if(empty($_POST['confirm_password'])){
       header("location:../pages/home.php?error=Confirm_Password");
       exit();
   }
   if ($password != $confirm_password) {
        header("location:../pages/home.php?error=password_mismatch");
        exit();
    }

   if(empty($image_name)){
       header("location:../pages/home.php?error=Profile_Image");
       exit();
   }

    $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        header("location:../pages/home.php?error=User_Exist");
        exit();
    } else {
        $query = "INSERT INTO users(user_id,username, firstname, lastname, email, password, image, type) VALUES('$user_id', '$username', '$firstname', '$lastname', '$email', '$password', '$image_name', '$type')";
        $result2 = mysqli_query($con, $query);
        if ($result2) {
            move_uploaded_file($tmp_name, "{$folder}{$image_name}");
            header("location:../pages/home.php?success=register_successful");
            exit();
        } else {
            header("location:../pages/home.php?error=stmt_failed");
            exit();
        }
    }
}