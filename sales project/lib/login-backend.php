<?php 
session_start();
include("../include/connection.php");

if (isset($_POST['login'])) {
    $redirect = !empty($_POST['redirect_url']) ? $_POST['redirect_url'] : '../pages/home.php';
    // Clean existing query params from redirect
    $parts = parse_url($redirect);
    $clean_redirect = $parts['path'] ?? '../pages/home.php';
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $q);
        unset($q['error'], $q['success']);
        if (!empty($q)) {
            $clean_redirect .= '?' . http_build_query($q);
        }
    }
    $sep = (strpos($clean_redirect, '?') !== false) ? '&' : '?';

    $email_or_username = isset($_POST['email']) ? mysqli_real_escape_string($con, trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? md5($_POST['password']) : '';

    if ($email_or_username == "") {
        header("location:" . $clean_redirect . $sep . "error=User_Name");
        exit();
    }
    if ($password == "") {
        header("location:" . $clean_redirect . $sep . "error=Password");
        exit();
    }

    $query = "SELECT * FROM users WHERE password='$password' AND (username='$email_or_username' OR email='$email_or_username')";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['type'] = $row['type'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['image'] = $row['image'];
        $_SESSION['first_name'] = $row['firstname'];
        $_SESSION['approve'] = $row['approve'] ?? 0;

        // If supplier, load business registration info
        if ($row['type'] === 'supplier') {
            $uid = $row['user_id'];
            $b_query = "SELECT * FROM businessregistration WHERE user_id='$uid' LIMIT 1";
            $b_res = mysqli_query($con, $b_query);
            if ($b_res && mysqli_num_rows($b_res) > 0) {
                $b_row = mysqli_fetch_assoc($b_res);
                $_SESSION['approve'] = $b_row['approve'];
                $_SESSION['bname'] = $b_row['bname'];
                $_SESSION['blogo'] = $b_row['blogo'];
            }
        }

        header("location:" . $clean_redirect);
        exit();
    } else {
        header("location:" . $clean_redirect . $sep . "error=login_error");
        exit();
    }
} else {
    header("location:../pages/home.php?error=invalid_request");
    exit();
}
?>