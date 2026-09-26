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
        $_SESSION['bname'] = $row['bname'];
        $_SESSION['blogo'] = $row['blogo'];
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
    <title>Supplier Dashboard</title>
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

    <div class="max-w-4x3 mx-auto space-y-8">
        <!-- Business Header Section -->
        <header class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row items-center md:justify-between">
            <div class="flex items-center space-x-4 mb-4 md:mb-0">
                <!-- Business Logo -->
                <img src="../images/logo/<?php echo $_SESSION['blogo']; ?>"
                    onerror="this.src='https://placehold.co/80x80?text=LOGO';"
                    class="w-20 h-20 rounded-full border-2 border-indigo-500 shadow-lg" alt="Business Logo">
                <!-- Business Name -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?= $_SESSION['bname'] ?></h1>
                    <p class="text-gray-500">Supplier Dashboard</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="#"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full font-medium shadow-lg hover:bg-gray-300 transition-colors">Your
                    Details</a>
                <a href="../pages/home.php"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-full font-medium shadow-lg hover:bg-indigo-700 transition-colors">Home
                    Page</a>
            </div>
        </header>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Add/Update Item -->
            <section class="md:col-span-1 bg-white p-6 rounded-xl shadow-md h-fit">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Add New Item</h2>
                <form class="space-y-4" action="../lib/itemadd_backend.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="itemName" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" id="itemName" name="itemName" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="itemCategory" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="itemCategory" name="itemCategory" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                            <option value="" disabled selected>Select a category</option>
                            <option value="Phones">Phones</option>
                            <option value="Chargers">Chargers</option>
                            <option value="Backcovers">Backcovers</option>
                            <option value="Headphones">Headphones</option>
                        </select>
                    </div>
                    <div>
                        <label for="itemPrice" class="block text-sm font-medium text-gray-700">Price (LKR)</label>
                        <input type="number" id="itemPrice" name="itemPrice" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="itemDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="itemDescription" name="itemDescription" rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                    </div>
                    <div>
                        <label for="itemImage" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" id="itemImage" name="itemImage"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div>
                        <label for="itemQty" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" id="itemQty" name="itemQty" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <button type="submit" name="add"
                        class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow-lg transition-colors">
                        Add Item
                    </button>
                </form>
            </section>

            <!-- Item List Section (Static) -->
            <section class="md:col-span-2 bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">My Items</h2>
                <div id="itemsList" class="space-y-4">
                    <?php
                    $query = "SELECT * FROM production WHERE user_id='$user_id'";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pname = $row['pname'];
                        $price = $row['price'];
                        $discription = $row['discription'];
                        $image = $row['image'];
                        $pid = $row['pid'];
                        $qty = $row['qty'];
                        $categories = $row['categories'];
                        ?>
                        <!-- Hardcoded items -->
                        <div
                            class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-4">
                                <img src="../images/items/<?= $image ?>"
                                    class="w-24 h-24 object-cover rounded-lg border border-gray-300" alt="Item image">
                            </div>
                            <div class="flex-1 space-y-1">
                                <h3 class="text-lg font-bold text-gray-800"><?= $pname ?></h3>
                                <p class="text-gray-600 font-medium">Category: <?= $categories ?></p>
                                <p class="text-gray-600 font-medium">Price: LKR.<?= $price ?></p>
                                <p class="text-gray-600 font-medium">Quantity:<?= $qty ?> </p>
                                <p class="text-sm text-gray-500"><?= $discription ?></p>
                            </div>
                            <div class="flex-shrink-0 flex space-x-2 mt-4 md:mt-0">
                                <a href="update_item.php?pid=<?= $pid ?>">
                                    <button
                                        class="px-4 py-2 text-sm bg-blue-500 text-white rounded-full font-semibold shadow-md">
                                        Update
                                    </button>
                                </a>
                                <a href="../lib/delete.php?pid=<?= $pid ?>&user_id=<?= $user_id ?>"><button
                                        class="px-4 py-2 text-sm bg-red-500 text-white rounded-full font-semibold shadow-md"
                                        onclick="return confirm('Are you sure Remove this Product?')">
                                        Remove
                                    </button> </a>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</body>
<?php


if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'empty_fields':
            $error_message = 'All fields are required!';
            break;
        case 'large_file':
            $error_message = 'Image is too large! Maximum size allowed is 2MB.';
            break;
        case 'add_error':
            $error_message = 'Failed to add item. Please try again.';
            break;


    }
    $alert_type = 'error';
} elseif (isset($_GET['success'])) {
    $error_message = 'ADD successful!';
    $alert_type = 'success';
} elseif (isset($_GET['update'])) {
    $error_message = 'Update successful!';
    $alert_type = 'update';
}
?>
<div id="alert-container"></div>
<link rel="stylesheet" href="../css/alert.css">

<script>
    function showAlert(type, title, message) {
        const alertContainer = document.getElementById('alert-container');
        const alertElement = document.createElement('div');
        alertElement.className = `alert alert-${type}`;

        let iconSvg;
        switch (type) {
            case 'error':
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>`;
                break;
            case 'success':
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>`;
                break;
            case 'info':
            default:
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z"/></svg>`;
                break;
            case 'update':
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z"/></svg>`;
                break;
        }

        alertElement.innerHTML = `
            ${iconSvg}
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <div class="alert-message">${message}</div>
            </div>
        `;
        alertContainer.appendChild(alertElement);

        setTimeout(() => {
            alertElement.classList.add('show');
        }, 10);

        setTimeout(() => {
            alertElement.classList.remove('show');
            setTimeout(() => {
                alertElement.remove();
            }, 500);
        }, 5000);
    }

    <?php if ($error_message): ?>
        showAlert('<?php echo $alert_type; ?>', '<?php echo ucfirst($alert_type); ?>', '<?php echo $error_message; ?>');
    <?php endif; ?>
</script>
<script>
    window.onload = function () {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        url.searchParams.delete('success');
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('error');
            url.searchParams.delete('success');
            window.history.replaceState({ path: url.href }, '', url.href);
        }
    };
</script>

</html>