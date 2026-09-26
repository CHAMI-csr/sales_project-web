<?php
$servername = "localhost";
$username = "root"; 
$password = "6969"; 
$dbname = "tech_hub"; 

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>