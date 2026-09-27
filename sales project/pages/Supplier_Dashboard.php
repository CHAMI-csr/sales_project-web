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
    $_SESSION['bname'] = $row['bname'];
    $_SESSION['blogo'] = $row['blogo'];
} else {
    echo "Access Denied. Your merchant business registration is pending administrator approval.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supplier Dashboard — <?= htmlspecialchars($_SESSION['bname']) ?></title>
  
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

  <link rel="stylesheet" href="../css/alert.css">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
    }
  </style>
</head>

<body class="p-4 md:p-8 min-h-screen text-slate-800">

  <div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Business Header Section -->
    <header class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row items-center md:justify-between gap-6">
      <div class="flex items-center space-x-4">
        <!-- Business Logo -->
        <div class="w-20 h-20 rounded-2xl bg-indigo-50 border-2 border-indigo-600/30 overflow-hidden flex items-center justify-center shadow-md">
          <img src="../images/logo/<?= rawurlencode($_SESSION['blogo']) ?>"
               onerror="this.src='https://placehold.co/100x100/e2e8f0/64748b?text=LOGO';"
               class="w-full h-full object-cover" alt="Business Logo">
        </div>
        
        <!-- Business Name & Details -->
        <div>
          <div class="flex items-center gap-2">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
              <?= htmlspecialchars($_SESSION['bname']) ?>
            </h1>
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
              Verified Supplier
            </span>
          </div>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Manage products and stock levels</p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <a href="../pages/home.php"
           class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Back to Store
        </a>
        <a href="../pages/logout.php"
           class="px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl font-bold text-xs transition-colors">
          Sign Out
        </a>
      </div>
    </header>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

      <!-- Add New Item Form (5 cols) -->
      <section class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200/80">
        <div class="border-b border-slate-100 pb-4 mb-6">
          <h2 class="text-lg font-black text-slate-900 tracking-tight">Add New Product</h2>
          <p class="text-xs text-slate-500 mt-0.5">List a smartphone, audio gear, or accessory</p>
        </div>

        <form class="space-y-4" action="../lib/itemadd_backend.php" method="POST" enctype="multipart/form-data">
          <div>
            <label for="itemName" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Item Name</label>
            <input type="text" id="itemName" name="itemName" required placeholder="e.g. POCO X6 Pro 5G"
                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label for="itemCategory" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Category</label>
              <select id="itemCategory" name="itemCategory" required
                      class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                <option value="" disabled selected>Select category</option>
                <option value="Phones">Phones</option>
                <option value="Headphones">Headphones</option>
                <option value="Chargers">Chargers</option>
                <option value="Backcovers">Backcovers</option>
              </select>
            </div>

            <div>
              <label for="itemPrice" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Price (LKR)</label>
              <input type="number" id="itemPrice" name="itemPrice" required placeholder="e.g. 45000"
                     class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
            </div>
          </div>

          <div>
            <label for="itemDescription" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Specs & Description</label>
            <textarea id="itemDescription" name="itemDescription" rows="3" required placeholder="e.g. 12GB RAM, 256GB Storage, 67W Turbo Charger included..."
                      class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label for="itemQty" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Stock Qty</label>
              <input type="number" id="itemQty" name="itemQty" required min="1" placeholder="10"
                     class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
            </div>

            <div>
              <label for="itemImage" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Photo</label>
              <input type="file" id="itemImage" name="itemImage" accept="image/*" required
                     class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
          </div>

          <button type="submit" name="add"
                  class="w-full mt-2 py-3 px-6 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Publish New Item
          </button>
        </form>
      </section>

      <!-- Item List Section (7 cols) -->
      <section class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200/80">
        <?php
        $query = "SELECT * FROM production WHERE user_id='$user_id' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        $total_supplier_items = ($result) ? mysqli_num_rows($result) : 0;
        ?>
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
          <div>
            <h2 class="text-lg font-black text-slate-900 tracking-tight">Your Listed Inventory</h2>
            <p class="text-xs text-slate-500 mt-0.5">Currently active products on TecHub</p>
          </div>
          <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-full">
            <?= $total_supplier_items ?> Products
          </span>
        </div>

        <div id="itemsList" class="space-y-4">
          <?php
          if ($total_supplier_items > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $pname = $row['pname'];
              $price = (float)$row['price'];
              $discription = $row['discription'];
              $image = !empty($row['image']) ? $row['image'] : 'mobile.png';
              $pid = $row['pid'];
              $qty = (int)$row['qty'];
              $categories = $row['categories'];
              ?>
              <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-slate-200 transition-colors">
                
                <div class="flex items-center gap-3.5 min-w-0">
                  <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center p-1.5">
                    <img src="../images/items/<?= rawurlencode($image) ?>"
                         class="w-full h-full object-contain mix-blend-multiply" alt="Item photo"
                         onerror="this.src='https://placehold.co/100x100/e2e8f0/64748b?text=Item';">
                  </div>
                  <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 truncate" title="<?= htmlspecialchars($pname) ?>"><?= htmlspecialchars($pname) ?></h3>
                    <div class="flex items-center gap-2 mt-0.5">
                      <span class="text-[11px] font-semibold text-indigo-600 uppercase tracking-wider"><?= htmlspecialchars($categories) ?></span>
                      <span class="text-slate-300">•</span>
                      <span class="text-xs font-bold text-slate-800">LKR <?= number_format($price, 2) ?></span>
                      <span class="text-slate-300">•</span>
                      <span class="text-xs font-semibold text-slate-500">Qty: <?= $qty ?></span>
                    </div>
                    <p class="text-xs text-slate-400 truncate max-w-sm mt-0.5"><?= htmlspecialchars($discription) ?></p>
                  </div>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center">
                  <a href="update_item.php?pid=<?= urlencode($pid) ?>"
                     class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-indigo-600 hover:bg-indigo-50 font-bold text-xs transition-colors shadow-xs">
                    Edit
                  </a>
                  <a href="../lib/delete.php?pid=<?= urlencode($pid) ?>&user_id=<?= urlencode($user_id) ?>"
                     onclick="return confirm('Are you sure you want to permanently remove this product?')"
                     class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-rose-600 hover:bg-rose-50 font-bold text-xs transition-colors shadow-xs">
                    Delete
                  </a>
                </div>

              </div>
            <?php }
          } else { ?>
            <div class="py-12 text-center text-slate-400">
              <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
              <p class="text-sm font-semibold">No items listed yet</p>
              <p class="text-xs text-slate-400 mt-1">Use the form on the left to add your first product.</p>
            </div>
          <?php } ?>
        </div>
      </section>

    </div>

  </div>

  <!-- Toast Notification Box -->
  <div id="alert-container"></div>

  <?php
  $error_message = '';
  $alert_type = 'info';

  if (isset($_GET['error'])) {
      $alert_type = 'error';
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
  } elseif (isset($_GET['success'])) {
      $error_message = 'Product added successfully!';
      $alert_type = 'success';
  } elseif (isset($_GET['update'])) {
      $error_message = 'Product updated successfully!';
      $alert_type = 'success';
  }
  ?>

  <script src="../js/loging.js"></script>
  <script>
    <?php if (!empty($error_message)) { ?>
      showAlert('<?= $alert_type ?>', '<?= ucfirst($alert_type) ?>', '<?= addslashes($error_message) ?>');
    <?php } ?>

    window.addEventListener('load', function () {
      if (window.history.replaceState) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('error') || url.searchParams.has('success') || url.searchParams.has('update')) {
          url.searchParams.delete('error');
          url.searchParams.delete('success');
          url.searchParams.delete('update');
          window.history.replaceState({ path: url.href }, '', url.href);
        }
      }
    });
  </script>

</body>
</html>