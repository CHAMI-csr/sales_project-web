<?php
session_start();
include '../include/connection.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'items' => [], 'count' => 0]);
    exit();
}

$user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
$action  = $_POST['action'] ?? $_GET['action'] ?? 'get';

// --- DELETE action ---
if ($action === 'delete') {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id'] ?? '');
    $pid      = mysqli_real_escape_string($con, $_POST['pid']      ?? '');

    if (empty($order_id) || empty($pid)) {
        echo json_encode(['success' => false, 'error' => 'Missing params']);
        exit();
    }

    $del = mysqli_query($con, "DELETE FROM ordertable WHERE orderid='$order_id' AND pid='$pid' AND user_id='$user_id'");
    if (!$del) {
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
        exit();
    }
}

// --- GET / return updated cart ---
$result = mysqli_query($con, "SELECT * FROM ordertable WHERE user_id='$user_id' ORDER BY id DESC");
$items  = [];
$count  = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pid   = $row['pid'];
        $image = '';
        $safe_pid = mysqli_real_escape_string($con, $pid);
        $img_r = mysqli_query($con, "SELECT image FROM production WHERE pid='$safe_pid' LIMIT 1");
        if ($img_r && $img_row = mysqli_fetch_assoc($img_r)) {
            $image = $img_row['image'];
        }
        $items[] = [
            'order_id'    => $row['orderid'],
            'pid'         => $pid,
            'pname'       => $row['pname'],
            'categories'  => $row['categories'],
            'qty'         => (int)$row['qty'],
            'price'       => (float)$row['price'],
            'image'       => $image,
        ];
        $count++;
    }
}

echo json_encode(['success' => true, 'items' => $items, 'count' => $count]);
?>
