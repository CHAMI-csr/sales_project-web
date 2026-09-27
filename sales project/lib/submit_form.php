<?php
session_start();
include '../include/connection.php';


if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $bname = $_POST['bname'];
    $date = $_POST['date'];
    $bregid = $_POST['bregid'];
    $bnumber = $_POST['bnumber'];
    $btype = isset($_POST['btype']) ? $_POST['btype'] : array();
    $btype_str = implode(", ", $btype); // Convert array to comma-separated string
    $bcertificate_name = $_FILES['bcertificate']['name'];
    $bcertificate_tmp = $_FILES['bcertificate']['tmp_name'];
    $bcertificate_size = $_FILES['bcertificate']['size'];
    $bcertificate_type = $_FILES['bcertificate']['type'];
    $blogo_name = $_FILES['blogo']['name'];
    $blogo_tmp = $_FILES['blogo']['tmp_name'];
    $blogo_type = $_FILES['blogo']['type'];
    $blogo_folder = "../images/logo/";
    $folder = "../files/certificate/";

    if(empty($bname)){
        header("location:../pages/Business_reg.php?error=Business_Name");
        exit();
    }
    if ($bcertificate_size > 2000000) {
        header("location:../pages/Business_reg.php?error=large_file");
        exit();
    }

    $allowed_cert_types = ["application/pdf", "image/jpeg", "image/jpg", "image/png"];
    if (!isset($_FILES['bcertificate']) || $bcertificate_name == "" || !in_array($bcertificate_type, $allowed_cert_types)) {
        header("location:../pages/Business_reg.php?error=invalid_file");
        exit();
    }

    if (!isset($_FILES['blogo']) || $blogo_name == "" || ($blogo_type != "image/jpeg" && $blogo_type != "image/png")) {
        header("location:../pages/Business_reg.php?error=invalid_image");
        exit();
    }
    if($bnumber == ""){
        header("location:../pages/Business_reg.php?error=Business_Number");
        exit();
    }
    if($bregid == ""){
        header("location:../pages/Business_reg.php?error=Business_Reg_ID");
        exit();
    }
    if($blogo_name == ""){
        header("location:../pages/Business_reg.php?error=Business_Logo");
        exit();
    }
    if(empty($btype)){
        header("location:../pages/Business_reg.php?error=Business_Type");
        exit();
    }
    if($bcertificate_name == ""){
        header("location:../pages/Business_reg.php?error=Business_Certificate");
        exit();
    }


    $query = "SELECT * FROM businessregistration WHERE user_id='$user_id'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        header("location:../pages/Business_reg.php?error=already_registered");
        exit();
    } else {
        $bname = mysqli_real_escape_string($con, $bname);
        $date = mysqli_real_escape_string($con, $date);
        $bregid = mysqli_real_escape_string($con, $bregid);
        $bnumber = mysqli_real_escape_string($con, $bnumber);
        $btype_str = mysqli_real_escape_string($con, $btype_str);
        $bcertificate_name = mysqli_real_escape_string($con, $bcertificate_name);
        $blogo_name = mysqli_real_escape_string($con, $blogo_name);
        $query = "INSERT INTO businessregistration(user_id,bname, date, bregid, bnumber, btype, bcertificate, blogo) VALUES('$user_id','$bname', '$date', '$bregid', '$bnumber', '$btype_str', '$bcertificate_name', '$blogo_name')";
        $result = mysqli_query($con, $query);

        if ($result) {
            move_uploaded_file($bcertificate_tmp, $folder . $bcertificate_name);
            move_uploaded_file($blogo_tmp, $blogo_folder . $blogo_name);
            header("location:../pages/home.php?success=registration_successful");
            exit();
        } else {
            header("location:../pages/Business_reg.php?error=register_error");
            exit();
        }

    }





}






?>