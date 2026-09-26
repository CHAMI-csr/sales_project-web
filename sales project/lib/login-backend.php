<?php 
session_start();

include("../include/connection.php");

if (isset($_POST['login'])) {
    $email_or_username = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? md5($_POST['password']) : '';

    if ($email_or_username == "") {
        header("location:../pages/home.php?error=User_Name");
        exit();
    }
    if ($password == "") {
        header("location:../pages/home.php?error=Password");
        exit();
    }

    $query = "SELECT * FROM users WHERE password='$password' AND (username='$email_or_username' OR email='$email_or_username')";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['type'] = $row['type'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['image'] = $row['image'];
        $_SESSION['first_name'] = $row['firstname'];
        header("location:../pages/home.php");
        exit();
    } else {
        header("location:../pages/home.php?error=login_error");
        exit();
    }
} else {
    header("location:../pages/home.php?error=invalid_request");
    exit();
}

?>