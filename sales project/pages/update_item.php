<?php
session_start();
include '../include/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home.php?error=login_error");
    exit();
}
$user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);

$query = "SELECT * FROM businessregistration WHERE user_id='$user_id' AND approve='1'";
$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if ($row['approve'] == '1') {
        if (!isset($_GET['pid']) || empty($_GET['pid'])) {
            header("Location: Supplier_Dashboard.php");
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
  <title>Edit Item: <?= htmlspecialchars($item['pname']) ?> — TecHub</title>
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
    }
  </style>
</head>

<body class="p-4 md:p-8 min-h-screen text-slate-800 flex items-center justify-center">

  <div class="max-w-2xl w-full mx-auto bg-white p-6 sm:p-10 rounded-3xl shadow-xl border border-slate-200/80">
    
    <div class="flex items-center justify-between border-b border-slate-100 pb-5 mb-6">
      <div>
        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Edit Product Details</h1>
        <p class="text-xs text-slate-500 mt-0.5">Product ID: <?= htmlspecialchars($item['pid']) ?></p>
      </div>
      <a href="Supplier_Dashboard.php" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
        &larr; Cancel & Return
      </a>
    </div>

    <form class="space-y-4" action="../lib/item_update_backend.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= htmlspecialchars($item['pid']) ?>">
      <input type="hidden" name="old_image" value="<?= htmlspecialchars($item['image']) ?>">

      <div>
        <label for="itemName" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Item Name</label>
        <input type="text" id="itemName" name="itemName" value="<?= htmlspecialchars($item['pname']) ?>" required
               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="itemCategory" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Category</label>
          <select id="itemCategory" name="itemCategory" required
                  class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
            <option value="Phones" <?= ($item['categories'] === 'Phones') ? 'selected' : '' ?>>Phones</option>
            <option value="Headphones" <?= ($item['categories'] === 'Headphones') ? 'selected' : '' ?>>Headphones</option>
            <option value="Chargers" <?= ($item['categories'] === 'Chargers') ? 'selected' : '' ?>>Chargers</option>
            <option value="Backcovers" <?= ($item['categories'] === 'Backcovers') ? 'selected' : '' ?>>Backcovers</option>
          </select>
        </div>

        <div>
          <label for="itemPrice" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Price (LKR)</label>
          <input type="number" id="itemPrice" name="itemPrice" value="<?= htmlspecialchars($item['price']) ?>" required
                 class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
        </div>
      </div>

      <div>
        <label for="itemDescription" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Description</label>
        <textarea id="itemDescription" name="itemDescription" rows="3" required
                  class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all"><?= htmlspecialchars($item['discription']) ?></textarea>
      </div>

      <div>
        <label for="itemQty" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Available Stock Quantity</label>
        <input type="number" id="itemQty" name="itemQty" value="<?= (int)$item['qty'] ?>" required min="0"
               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Product Photo</label>
        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 bg-slate-50">
          <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
            <img src="../images/items/<?= htmlspecialchars($item['image']) ?>" alt="Current Photo" class="w-full h-full object-contain">
          </div>
          <div class="flex-1">
            <p class="text-xs text-slate-600 font-semibold">Change photo (optional):</p>
            <input type="file" id="itemImage" name="itemImage" accept="image/*"
                   class="mt-1 text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
          </div>
        </div>
      </div>

      <div class="pt-4 flex items-center gap-3">
        <button type="submit" name="update"
                class="flex-1 py-3.5 px-6 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/30 transition-all">
          Save Changes
        </button>
        <a href="Supplier_Dashboard.php" class="px-5 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
          Cancel
        </a>
      </div>
    </form>

  </div>

</body>
</html>