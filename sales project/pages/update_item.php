<?php
session_start();
include '../include/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM businessregistration WHERE user_id='$user_id' AND approve='1'";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if ($row['approve'] == '1') {
        
        if (!isset($_GET['pid']) || empty($_GET['pid'])) {
            echo "Product ID is missing.";
            exit();
        }

        $pid = mysqli_real_escape_string($con, $_GET['pid']);
        $query = "SELECT * FROM production WHERE pid='$pid' AND user_id='$user_id'";
        $result = mysqli_query($con, $query);

        if (!$result || mysqli_num_rows($result) === 0) {
            echo "Item not found or you don't have permission to edit it.";
            exit();
        }

        $item = mysqli_fetch_assoc($result);

    } else {
        echo "Access Denied";
        exit();
    }
} else {
    echo "Access Denied";
    exit();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="p-4 md:p-8">

    <div class="max-w-xl mx-auto space-y-8 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Update Item: <?= ($item['pname']) ?></h2>

        <form class="space-y-4" action="../lib/item_update_backend.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= ($item['pid']) ?>">
            <input type="hidden" name="old_image" value="<?= ($item['image']) ?>">

            <div>
                <label for="itemName" class="block text-sm font-medium text-gray-700">Item Name</label>
                <input type="text" id="itemName" name="itemName" value="<?= ($item['pname']) ?>" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
            </div>
            <div>
                <label for="itemCategory" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="itemCategory" name="itemCategory" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    <option value="Phones" <?= ($item['categories'] == 'Phones') ? 'selected' : '' ?>>Phones</option>
                    <option value="Chargers" <?= ($item['categories'] == 'Chargers') ? 'selected' : '' ?>>Chargers &
                        Backcovers</option>
                    <option value="Headphones" <?= ($item['categories'] == 'Headphones') ? 'selected' : '' ?>>Headphones
                    </option>
                </select>
            </div>
            <div>
                <label for="itemPrice" class="block text-sm font-medium text-gray-700">Price (LKR)</label>
                <input type="number" id="itemPrice" name="itemPrice" value="<?= ($item['price']) ?>" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
            </div>
            <div>
                <label for="itemDescription" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="itemDescription" name="itemDescription" rows="3"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"><?= ($item['discription']) ?></textarea>
            </div>
            <div>
                <label for="itemImage" class="block text-sm font-medium text-gray-700">Image (Leave blank to keep
                    current image)</label>
                <input type="file" id="itemImage" name="itemImage"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <div class="mt-2">
                    <p class="text-xs text-gray-500">Current Image:</p>
                    <img src="../images/items/<?= ($item['image']) ?>" alt="Current Item Image"
                        class="w-32 h-32 object-cover rounded-lg mt-1">
                </div>
            </div>
            <div>
                <label for="itemQty" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" id="itemQty" name="itemQty" value="<?= ($item['qty']) ?>" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
            </div>

            <button type="submit" name="update"
                class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-full shadow-lg transition-colors hover:bg-green-700">
                Update Item
            </button>
        </form>
    </div>
</body>

</html>