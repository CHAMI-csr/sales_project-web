<?php
session_start();
include "../include/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home.php?error=login_error");
    exit();
}

$user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
$query = "SELECT o.*, p.image FROM ordertable o LEFT JOIN production p ON o.pid = p.pid WHERE o.user_id='$user_id'";
$result = mysqli_query($con, $query);

$totalPrice = 0;
$items = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
        $totalPrice += (float)$row['price'];
    }
}
$cartCount = count($items);
$_SESSION['cart_count'] = $cartCount;

$freeShippingThreshold = 15000;
$shippingFee = ($totalPrice >= $freeShippingThreshold || $totalPrice == 0) ? 0 : 500;
$grandTotal = $totalPrice + $shippingFee;
$_SESSION['total_price'] = $grandTotal;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout — TecHub Secure Payment</title>
  
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

<body class="min-h-screen text-slate-800 flex flex-col justify-between antialiased">
  
  <!-- Top Checkout Header -->
  <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      <a href="../pages/home.php" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-blue-500 flex items-center justify-center text-white shadow-md">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <span class="text-2xl font-black tracking-tight text-slate-900">
          Tec<span class="text-indigo-600">Hub</span>
        </span>
      </a>

      <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200/60">
        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <span>256-Bit SSL Encrypted Checkout</span>
      </div>

      <a href="../pages/items.php" class="text-xs font-bold text-slate-600 hover:text-indigo-600 flex items-center gap-1.5 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Store
      </a>
    </div>
  </header>

  <!-- Main Checkout Container -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-grow">
    
    <div class="mb-8">
      <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Review Your Order & Checkout</h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">Verify your cart items and complete payment securely via PayHere.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- Left Panel: Products in Cart (7 cols) -->
      <div class="lg:col-span-7 bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
          <h2 class="text-base font-bold text-slate-900">
            Shopping Bag (<?= $cartCount ?> <?= ($cartCount === 1) ? 'item' : 'items' ?>)
          </h2>
          <span class="text-xs text-slate-500">Delivering to Sri Lanka</span>
        </div>

        <?php if ($cartCount > 0) { ?>
          <div class="divide-y divide-slate-100">
            <?php foreach ($items as $item) { 
              $img = !empty($item['image']) ? $item['image'] : 'mobile.png';
              ?>
              <div class="py-4 flex gap-4 items-center">
                <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center p-2">
                  <img src="../images/items/<?= htmlspecialchars($img) ?>" 
                       alt="<?= htmlspecialchars($item['pname']) ?>" 
                       class="w-full h-full object-contain mix-blend-multiply"
                       onerror="this.src='https://placehold.co/100x100/f8fafc/64748b?text=Item';">
                </div>

                <div class="flex-1 min-w-0">
                  <h3 class="text-sm font-bold text-slate-900 truncate"><?= htmlspecialchars($item['pname']) ?></h3>
                  <span class="inline-block text-[11px] font-semibold text-indigo-600 uppercase tracking-wider"><?= htmlspecialchars($item['categories']) ?></span>
                  <p class="text-xs text-slate-500 truncate"><?= htmlspecialchars($item['discription']) ?></p>
                  
                  <div class="flex items-center justify-between mt-2">
                    <span class="text-xs text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md font-semibold">
                      Qty: <?= (int)$item['qty'] ?>
                    </span>
                    <span class="text-sm font-extrabold text-slate-900">
                      LKR <?= number_format($item['price'], 2) ?>
                    </span>
                  </div>
                </div>

                <div>
                  <a href="../lib/cart_delete.php?order_id=<?= urlencode($item['orderid']) ?>&pid=<?= urlencode($item['pid']) ?>"
                     class="p-2 text-slate-400 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition-colors inline-block"
                     title="Remove item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </a>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } else { ?>
          <div class="py-16 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-1">Your Bag is Empty</h3>
            <p class="text-xs text-slate-500 mb-6">You don't have any items pending for checkout.</p>
            <a href="../pages/items.php" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 transition-colors">
              Return to Catalog
            </a>
          </div>
        <?php } ?>
      </div>

      <!-- Right Panel: Order Summary & PayHere (5 cols) -->
      <div class="lg:col-span-5 space-y-6">
        
        <!-- Summary Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-8 space-y-4">
          <h2 class="text-base font-black text-slate-900">Order Summary</h2>

          <div class="space-y-3 text-xs text-slate-600 pt-2 border-t border-slate-100">
            <div class="flex justify-between items-center">
              <span>Items Subtotal (<?= $cartCount ?> items)</span>
              <span class="font-bold text-slate-900">LKR <?= number_format($totalPrice, 2) ?></span>
            </div>

            <div class="flex justify-between items-center">
              <span>Estimated Shipping</span>
              <?php if ($shippingFee === 0) { ?>
                <span class="font-bold text-emerald-600">FREE</span>
              <?php } else { ?>
                <span class="font-bold text-slate-900">LKR <?= number_format($shippingFee, 2) ?></span>
              <?php } ?>
            </div>

            <?php if ($shippingFee > 0) { ?>
              <p class="text-[11px] text-indigo-600">
                Tip: Add LKR <?= number_format($freeShippingThreshold - $totalPrice, 2) ?> more to get FREE delivery!
              </p>
            <?php } ?>
          </div>

          <!-- Voucher Input -->
          <div class="flex items-center gap-2 pt-2">
            <input type="text" placeholder="Promo / Voucher Code"
                   class="flex-1 px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:outline-none focus:border-indigo-500 uppercase font-semibold">
            <button type="button" onclick="alert('Promo code applied successfully!');"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
              Apply
            </button>
          </div>

          <!-- Total Calculation -->
          <div class="border-t border-slate-100 pt-4 flex justify-between items-baseline">
            <div>
              <span class="text-xs text-slate-400 uppercase font-bold">Total Amount</span>
              <div class="text-2xl font-black text-slate-900">
                LKR <?= number_format($grandTotal, 2) ?>
              </div>
            </div>
            <span class="text-[11px] text-slate-400">All taxes included</span>
          </div>

          <!-- PayHere Checkout CTA -->
          <?php if ($cartCount > 0) { ?>
            <button type="button" onclick="paymentGateway()" id="checkoutButton"
                    class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-extrabold text-sm shadow-lg shadow-indigo-600/30 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
              Pay with PayHere (LKR <?= number_format($grandTotal, 2) ?>)
            </button>
          <?php } else { ?>
            <button disabled class="w-full py-4 px-6 rounded-2xl bg-slate-200 text-slate-400 font-bold text-sm cursor-not-allowed">
              Shopping Bag is Empty
            </button>
          <?php } ?>

        </div>

        <!-- Accepted Payment Methods Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 text-center space-y-3">
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Guaranteed Safe & Secure Checkout</span>
          
          <div class="flex items-center justify-center gap-4 py-2">
            <a href="https://www.payhere.lk" target="_blank" class="inline-block">
              <img src="https://www.payhere.lk/downloads/images/payhere_short_banner_dark.png" alt="PayHere Payment Gateway" class="h-8 object-contain">
            </a>
          </div>

          <div class="flex flex-wrap items-center justify-center gap-2 text-[11px] font-bold text-slate-600">
            <span class="px-2.5 py-1 bg-slate-100 rounded-lg">VISA</span>
            <span class="px-2.5 py-1 bg-slate-100 rounded-lg">Mastercard</span>
            <span class="px-2.5 py-1 bg-slate-100 rounded-lg">Amex</span>
            <span class="px-2.5 py-1 bg-slate-100 rounded-lg">Genie</span>
            <span class="px-2.5 py-1 bg-slate-100 rounded-lg">FriMi</span>
          </div>
        </div>

      </div>

    </div>

  </main>

  <!-- Checkout Footer -->
  <footer class="bg-white border-t border-slate-200/80 py-6 text-center text-xs text-slate-400">
    <p>&copy; <?= date('Y') ?> TecHub Mobile Phone Shop. All transactions processed securely.</p>
  </footer>

  <!-- PayHere Scripts -->
  <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
  <script src="paymentGateway.js"></script>

</body>
</html>