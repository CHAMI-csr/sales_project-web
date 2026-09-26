<?php
session_start();

include "../include/connection.php";

if (isset($_POST['login'])) {
    $email_or_username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? md5($_POST['password']) : '';

    if ($email_or_username == "") {
        header("location:../pages/loging.php?error=User_Name");
        exit();
    }
    if ($password == "") {
        header("location:../pages/loging.php?error=Password");
        exit();
    }

    $query = "SELECT * FROM users WHERE password='$password' AND (username='$email_or_username' OR email='$email_or_username')";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['type'] == 'admin') {
            $_SESSION['type'] = $row['type'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['image'] = $row['image'];
            header("location:../pages/manage.php");
            exit();
        } else {
            header("location:../pages/loging.php?error=account_error");
            exit();
        }
    } else {
        header("location:../pages/loging.php?error=login_error");
        exit();
    }
}


?>