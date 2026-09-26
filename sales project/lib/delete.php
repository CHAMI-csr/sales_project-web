<?php
include "../include/connection.php";
?>
<?php
$pid=$_GET['pid'];
$user_id=$_GET['user_id'];


$query="SELECT image from production where pid='$pid' AND user_id='$user_id'";
$result=mysqli_query($con,$query);

while ($row=mysqli_fetch_assoc($result)) {
    $imagename=$row['image'];
    $imagepath="../images/items/";
    unlink("{$imagepath}{$imagename}");
    

}
$query = "DELETE FROM production WHERE pid = '$pid' AND user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "Record deleted successfully";
        header("Location:../pages/Supplier_Dashboard.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }

?>