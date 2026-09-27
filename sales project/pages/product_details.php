<?php 
include '../include/header.php'; 

$pid = isset($_GET['pid']) ? mysqli_real_escape_string($con, trim($_GET['pid'])) : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = null;
if (!empty($pid)) {
    $query = "SELECT * FROM production WHERE pid='$pid' LIMIT 1";
    $res = mysqli_query($con, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        $product = mysqli_fetch_assoc($res);
    }
} elseif ($id > 0) {
    $query = "SELECT * FROM production WHERE id=$id LIMIT 1";
    $res = mysqli_query($con, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        $product = mysqli_fetch_assoc($res);
    }
}
?>

<?php if (!$product) { ?>
  <!-- Product Not Found State -->
  <div class="max-w-4xl mx-auto px-4 py-20 text-center">
    <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-5 text-slate-400">
      <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Product Not Found</h1>
    <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
      The product you are looking for may have been removed, sold out, or the link may be outdated.
    </p>
    <div class="flex items-center justify-center gap-3">
      <a href="../pages/items.php" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-xs hover:bg-indigo-700 transition-colors">
        Browse All Products
      </a>
      <a href="../pages/home.php" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-semibold text-xs hover:bg-slate-200 transition-colors">
        Back to Home
      </a>
    </div>
  </div>
<?php } else { 
  $pname = $product['pname'];
  $price = (float)$product['price'];
  $discription = $product['discription'];
  $image = !empty($product['image']) ? $product['image'] : 'mobile.png';
  $qty = (int)$product['qty'];
  $categories = $product['categories'];
  $current_pid = $product['pid'];

  // Determine category URL for breadcrumbs
  $cat_url = '../pages/items.php';
  if (stripos($categories, 'phone') !== false) {
      $cat_url = '../pages/phones.php';
  } elseif (stripos($categories, 'headphone') !== false) {
      $cat_url = '../pages/headphones.php';
  } elseif (stripos($categories, 'cover') !== false || stripos($categories, 'charger') !== false) {
      $cat_url = '../pages/backcovers.php';
  }
?>

  <!-- Breadcrumb Navigation -->
  <section class="bg-white border-b border-slate-200 py-3.5 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex items-center flex-wrap gap-2 text-xs text-slate-500">
      <a href="../pages/home.php" class="hover:text-indigo-600 transition-colors">Home</a>
      <span>/</span>
      <a href="../pages/items.php" class="hover:text-indigo-600 transition-colors">Shop</a>
      <span>/</span>
      <a href="<?= $cat_url ?>" class="hover:text-indigo-600 transition-colors"><?= htmlspecialchars($categories) ?></a>
      <span>/</span>
      <span class="text-slate-900 font-semibold truncate max-w-xs sm:max-w-md"><?= htmlspecialchars($pname) ?></span>
    </div>
  </section>

  <!-- Product Detail Showcase -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
      
      <!-- Left Column: Product Image Gallery / Showcase (6 cols) -->
      <div class="lg:col-span-6 space-y-4">
        
        <!-- Main Image Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm flex items-center justify-center relative overflow-hidden group min-h-[380px] sm:min-h-[460px]">
          
          <!-- Image -->
          <img id="mainProductImage"
               src="../images/items/<?= rawurlencode($image) ?>" 
               alt="<?= htmlspecialchars($pname) ?>"
               class="max-h-[360px] sm:max-h-[420px] max-w-full object-contain transition-transform duration-300 group-hover:scale-105"
               onerror="this.src='https://placehold.co/600x500/f8fafc/64748b?text=<?= urlencode($pname) ?>';">

          <!-- Badges -->
          <div class="absolute top-4 left-4">
            <?php if ($qty > 0) { ?>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-xs">
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                In Stock (<?= $qty ?>)
              </span>
            <?php } else { ?>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-600 text-white shadow-xs">
                Out of Stock
              </span>
            <?php } ?>
          </div>

          <span class="absolute top-4 right-4 px-3 py-1 rounded-lg text-xs font-bold bg-slate-900 text-white uppercase tracking-wider">
            <?= htmlspecialchars($categories) ?>
          </span>
        </div>

        <!-- Trust Badges Strip -->
        <div class="grid grid-cols-3 gap-3">
          <div class="p-3 bg-white rounded-2xl border border-slate-200 text-center">
            <svg class="w-5 h-5 text-indigo-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <span class="text-[11px] font-bold text-slate-800 block">100% Genuine</span>
            <span class="text-[10px] text-slate-500">Official Warranty</span>
          </div>

          <div class="p-3 bg-white rounded-2xl border border-slate-200 text-center">
            <svg class="w-5 h-5 text-emerald-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span class="text-[11px] font-bold text-slate-800 block">Fast Delivery</span>
            <span class="text-[10px] text-slate-500">Islandwide Courier</span>
          </div>

          <div class="p-3 bg-white rounded-2xl border border-slate-200 text-center">
            <svg class="w-5 h-5 text-blue-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            <span class="text-[11px] font-bold text-slate-800 block">PayHere Secure</span>
            <span class="text-[10px] text-slate-500">Card & COD</span>
          </div>
        </div>

      </div>

      <!-- Right Column: Product Info & Actions (6 cols) -->
      <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
        
        <div>
          <a href="<?= $cat_url ?>" class="inline-block text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider mb-2">
            <?= htmlspecialchars($categories) ?>
          </a>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
            <?= htmlspecialchars($pname) ?>
          </h1>
        </div>

        <!-- Price Section -->
        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-baseline justify-between">
          <div>
            <span class="text-xs text-slate-500 font-semibold block mb-0.5">Price</span>
            <div class="text-2xl sm:text-3xl font-black text-slate-900">
              LKR. <?= number_format($price, 2) ?>
            </div>
          </div>
          <div class="text-right">
            <?php if ($qty > 0) { ?>
              <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 inline-block">
                ✓ In Stock (<?= $qty ?> available)
              </span>
            <?php } else { ?>
              <span class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-200 inline-block">
                ✕ Currently Out of Stock
              </span>
            <?php } ?>
          </div>
        </div>

        <!-- Description Box -->
        <div>
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Description & Specifications</h3>
          <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-100 text-sm text-slate-600 leading-relaxed whitespace-pre-line">
            <?= htmlspecialchars($discription) ?>
          </div>
        </div>

        <!-- Order / Purchase Actions -->
        <form id="productPurchaseForm" action="../lib/cart_backend.php" method="POST" class="space-y-4 pt-2">
          <input type="hidden" name="pid" value="<?= htmlspecialchars($current_pid) ?>">
          <input type="hidden" id="redirectInput" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

          <!-- Quantity Stepper -->
          <div class="flex items-center justify-between border-t border-b border-slate-100 py-3">
            <div>
              <span class="text-xs font-bold text-slate-900 block">Quantity</span>
              <span class="text-[11px] text-slate-400">Select order amount</span>
            </div>

            <div class="flex items-center gap-3">
              <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 p-1">
                <button type="button" onclick="decrementQty()"
                        class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-100 active:scale-95 transition-all flex items-center justify-center text-sm select-none">
                  -
                </button>
                <input type="number" id="detailQtyInput" name="qty" value="1" min="1" max="<?= max(1, $qty) ?>"
                       oninput="updateSubtotal()"
                       class="w-12 text-center text-sm font-bold bg-transparent border-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                <button type="button" onclick="incrementQty()"
                        class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-100 active:scale-95 transition-all flex items-center justify-center text-sm select-none">
                  +
                </button>
              </div>

              <!-- Live Subtotal -->
              <div class="text-right min-w-[100px]">
                <span class="text-[10px] text-slate-400 block font-semibold">Subtotal</span>
                <span id="liveSubtotal" class="text-sm font-extrabold text-slate-900">
                  LKR. <?= number_format($price, 2) ?>
                </span>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
            <?php if ($qty > 0) { ?>
              <?php if (isset($_SESSION['user_id'])) { ?>
                
                <!-- Add to Bag -->
                <button type="submit" onclick="setRedirectAction('stay');"
                        class="w-full py-3.5 px-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                  Add to Cart
                </button>

                <!-- Buy Now (Direct Checkout) -->
                <button type="submit" onclick="setRedirectAction('checkout');"
                        class="w-full py-3.5 px-5 rounded-2xl bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2">
                  <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                  Buy Now
                </button>

              <?php } else { ?>
                
                <!-- Prompts Login Modal -->
                <button type="button" onclick="openLoginModalDirect('signin');"
                        class="w-full py-3.5 px-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                  Add to Cart
                </button>

                <button type="button" onclick="openLoginModalDirect('signin');"
                        class="w-full py-3.5 px-5 rounded-2xl bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2">
                  <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                  Buy Now
                </button>

              <?php } ?>
            <?php } else { ?>
              <button disabled type="button" class="col-span-2 w-full py-3.5 px-5 rounded-2xl bg-slate-100 text-slate-400 font-bold text-sm cursor-not-allowed text-center">
                Currently Out of Stock
              </button>
            <?php } ?>
          </div>
        </form>

        <!-- Store Information -->
        <div class="border-t border-slate-100 pt-4 flex items-center justify-between text-xs text-slate-500">
          <span>Seller: <strong class="text-slate-800">TecHub Store</strong></span>
          <span>Location: <strong class="text-slate-800">Wilpattuwa, Galle</strong></span>
        </div>

      </div>

    </div>
  </section>

  <!-- Related Products Section -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-slate-200">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Related Products</h2>
        <p class="text-xs text-slate-500 mt-1">Other items in <?= htmlspecialchars($categories) ?></p>
      </div>
      <a href="<?= $cat_url ?>" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
        View All in <?= htmlspecialchars($categories) ?> &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
      <?php
      $related_query = "SELECT * FROM production WHERE categories='$categories' AND pid!='$current_pid' ORDER BY id DESC LIMIT 4";
      $related_res = mysqli_query($con, $related_query);
      if ($related_res && mysqli_num_rows($related_res) > 0) {
        while ($rel = mysqli_fetch_assoc($related_res)) {
          $rel_name = $rel['pname'];
          $rel_price = (float)$rel['price'];
          $rel_img = !empty($rel['image']) ? $rel['image'] : 'mobile.png';
          $rel_qty = (int)$rel['qty'];
          $rel_pid = $rel['pid'];
          ?>
          <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between hover:shadow-lg transition-all duration-300">
            <a href="../pages/product_details.php?pid=<?= urlencode($rel_pid) ?>" class="block">
              <div class="aspect-[4/3] bg-slate-50 p-4 flex items-center justify-center border-b border-slate-100 relative">
                <img src="../images/items/<?= htmlspecialchars($rel_img) ?>" 
                     alt="<?= htmlspecialchars($rel_name) ?>"
                     class="max-h-full max-w-full object-contain"
                     onerror="this.src='https://placehold.co/400x300/f8fafc/64748b?text=Item';">
                
                <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-full text-[10px] font-bold <?= ($rel_qty > 0) ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' ?>">
                  <?= ($rel_qty > 0) ? 'Available' : 'Out of Stock' ?>
                </span>
              </div>

              <div class="p-4">
                <h3 class="text-sm font-bold text-slate-900 truncate hover:text-indigo-600 transition-colors" title="<?= htmlspecialchars($rel_name) ?>">
                  <?= htmlspecialchars($rel_name) ?>
                </h3>
                <span class="text-sm font-extrabold text-slate-900 mt-2 block">
                  LKR. <?= number_format($rel_price, 2) ?>
                </span>
              </div>
            </a>

            <div class="p-4 pt-0">
              <a href="../pages/product_details.php?pid=<?= urlencode($rel_pid) ?>"
                 class="w-full py-2 px-3 rounded-xl bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 font-semibold text-xs transition-colors block text-center">
                View Details
              </a>
            </div>
          </div>
        <?php }
      } else { ?>
        <div class="col-span-full py-8 text-center text-xs text-slate-400">
          No other products found in this category.
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Dynamic Quantity & Price Calculator Script -->
  <script>
    const unitPrice = <?= $price ?>;
    const maxQty = <?= max(1, $qty) ?>;

    function formatLKR(num) {
      return 'LKR. ' + Number(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function updateSubtotal() {
      const input = document.getElementById('detailQtyInput');
      let val = parseInt(input.value, 10);
      if (isNaN(val) || val < 1) val = 1;
      if (val > maxQty) val = maxQty;
      input.value = val;

      const subtotal = val * unitPrice;
      document.getElementById('liveSubtotal').textContent = formatLKR(subtotal);
    }

    function incrementQty() {
      const input = document.getElementById('detailQtyInput');
      let val = parseInt(input.value, 10);
      if (val < maxQty) {
        input.value = val + 1;
        updateSubtotal();
      }
    }

    function decrementQty() {
      const input = document.getElementById('detailQtyInput');
      let val = parseInt(input.value, 10);
      if (val > 1) {
        input.value = val - 1;
        updateSubtotal();
      }
    }

    function setRedirectAction(action) {
      const redirectInput = document.getElementById('redirectInput');
      if (action === 'checkout') {
        redirectInput.value = '../PayHere/';
      } else {
        redirectInput.value = window.location.href;
      }
    }
  </script>

<?php } ?>

<?php 
include '../include/footer.php'; 
?>
