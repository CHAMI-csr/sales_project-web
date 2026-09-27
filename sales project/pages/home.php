<?php
include '../include/header.php';
?>

<!-- Carousel Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-4">
  <div id="carouselExampleIndicators" class="carousel slide carousel-fade rounded-2xl overflow-hidden shadow-sm border border-slate-200" data-bs-ride="carousel" data-bs-interval="4000">
    <!-- Indicators -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner max-h-[480px] bg-slate-900">
      <div class="carousel-item active">
        <img src="../images/carousel/carousel-1.jpg" class="d-block w-100 object-cover max-h-[480px]" alt="Smartphones Banner">
      </div>

      <div class="carousel-item">
        <img src="../images/carousel/carousel-2.svg" class="d-block w-100 object-cover max-h-[480px]" alt="Headphones Banner">
      </div>

      <div class="carousel-item">
        <img src="../images/carousel/carousel-4.png" class="d-block w-100 object-cover max-h-[480px]" alt="Accessories Banner">
      </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

<!-- Store Trust Bar -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
    
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      </div>
      <div>
        <h4 class="text-xs font-bold text-slate-900 leading-tight">100% Genuine Devices</h4>
        <p class="text-[11px] text-slate-500 mt-0.5">TRCSL approved & warranty</p>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
      </div>
      <div>
        <h4 class="text-xs font-bold text-slate-900 leading-tight">Islandwide Delivery</h4>
        <p class="text-[11px] text-slate-500 mt-0.5">Safe door-to-door shipping</p>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
      </div>
      <div>
        <h4 class="text-xs font-bold text-slate-900 leading-tight">Secure PayHere</h4>
        <p class="text-[11px] text-slate-500 mt-0.5">Cards, Genie & FriMi</p>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
      </div>
      <div>
        <h4 class="text-xs font-bold text-slate-900 leading-tight">Galle Store & Care</h4>
        <p class="text-[11px] text-slate-500 mt-0.5">In-store support & warranty</p>
      </div>
    </div>

  </div>
</section>

<!-- Featured Categories Section -->
<section class="py-12 bg-white border-y border-slate-200/80">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-2">
      <div>
        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Browse Catalog</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Shop by Category</h2>
      </div>
      <p class="text-xs text-slate-500 max-w-sm">Original smartphones, high-fidelity audio equipment, and authentic accessories</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Mobile Phones -->
      <a href="../pages/phones.php" class="group block">
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition-all duration-300 h-64 bg-slate-900">
          <img src="../images/Category/mobile.png" alt="Mobile Phones"
            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 opacity-80 group-hover:opacity-90">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
          <div class="absolute bottom-5 left-5 right-5 text-white">
            <span class="inline-block px-2.5 py-0.5 rounded-md bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider mb-2">Smartphones</span>
            <h3 class="text-xl font-bold leading-tight">Mobile Phones</h3>
            <p class="text-xs text-slate-300 mt-1">Apple, Samsung, Xiaomi, POCO & ZTE</p>
          </div>
          <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white group-hover:bg-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </div>
        </div>
      </a>

      <!-- Headphones -->
      <a href="../pages/headphones.php" class="group block">
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition-all duration-300 h-64 bg-slate-900">
          <img src="../images/Category/headphone.png" alt="Headphones"
            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 opacity-80 group-hover:opacity-90">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
          <div class="absolute bottom-5 left-5 right-5 text-white">
            <span class="inline-block px-2.5 py-0.5 rounded-md bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider mb-2">Audio & Sound</span>
            <h3 class="text-xl font-bold leading-tight">Headphones & Earbuds</h3>
            <p class="text-xs text-slate-300 mt-1">Wireless earbuds, headsets & sound gear</p>
          </div>
          <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white group-hover:bg-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </div>
        </div>
      </a>

      <!-- Back Covers & Accessories -->
      <a href="../pages/backcovers.php" class="group block">
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition-all duration-300 h-64 bg-slate-900">
          <img src="../images/Category/backcover.jpg" alt="Accessories"
            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 opacity-80 group-hover:opacity-90">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
          <div class="absolute bottom-5 left-5 right-5 text-white">
            <span class="inline-block px-2.5 py-0.5 rounded-md bg-emerald-600 text-white text-[10px] font-bold uppercase tracking-wider mb-2">Protection & Power</span>
            <h3 class="text-xl font-bold leading-tight">Covers, Chargers & Cables</h3>
            <p class="text-xs text-slate-300 mt-1">Armor cases, fast chargers & tempered glass</p>
          </div>
          <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white group-hover:bg-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </div>
        </div>
      </a>

  </div>
</section>

<!-- Latest Products Section -->
<section class="py-12 bg-slate-50/60">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-3">
      <div>
        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">New in Stock</span>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Latest Products</h3>
        <p class="text-xs text-slate-500 mt-1">Recently added smartphones, audio gear and authentic accessories</p>
      </div>
      <a href="../pages/items.php" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
        <span>View Full Catalog</span>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
      <?php
      $home_p_query = "SELECT * FROM production ORDER BY id DESC LIMIT 10";
      $home_p_res = mysqli_query($con, $home_p_query);
      if ($home_p_res && mysqli_num_rows($home_p_res) > 0) {
        while ($row = mysqli_fetch_assoc($home_p_res)) {
          $pname = $row['pname'];
          $price = (float)$row['price'];
          $discription = $row['discription'];
          $image = $row['image'];
          $qty = (int)$row['qty'];
          $categories = $row['categories'];
          $pid = $row['pid'];
          ?>
          <div class="product-card bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-blue-400 transition-all duration-200 flex flex-col justify-between overflow-hidden group">
            
            <a href="../pages/product_details.php?pid=<?= urlencode($pid) ?>" class="block">
              <div class="relative bg-slate-50/80 p-4 flex items-center justify-center h-44 overflow-hidden border-b border-slate-100">
                <img class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300" 
                     src="../images/items/<?= rawurlencode($image) ?>" 
                     alt="<?= htmlspecialchars($pname) ?>"
                     onerror="this.onerror=null;this.src='https://placehold.co/400x300/f8fafc/64748b?text=<?= urlencode($pname) ?>';">
                
                <?php if ($qty == 0) { ?>
                  <span class="absolute top-2.5 left-2.5 bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-bold px-2 py-0.5 rounded-md">Out of Stock</span>
                <?php } else { ?>
                  <span class="absolute top-2.5 left-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-md">In Stock</span>
                <?php } ?>
              </div>

              <div class="p-3.5 pb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 block mb-1"><?= htmlspecialchars($categories) ?></span>
                <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1" title="<?= htmlspecialchars($pname) ?>">
                  <?= htmlspecialchars($pname) ?>
                </h4>
                <p class="text-slate-500 text-[11px] line-clamp-1 mt-1"><?= htmlspecialchars($discription) ?></p>
              </div>
            </a>

            <div class="p-3.5 pt-2">
              <div class="mb-2.5">
                <span class="text-sm font-extrabold text-slate-900">LKR <?= number_format($price, 2) ?></span>
              </div>

              <form action="../lib/cart_backend.php" method="post">
                <input type="hidden" name="pid" value="<?= htmlspecialchars($pid) ?>">
                <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <input type="hidden" name="qty" value="1">
                
                <?php if ($qty > 0) { ?>
                  <?php if (isset($_SESSION['user_id'])) { ?>
                    <button class="w-full bg-slate-900 hover:bg-blue-600 text-white font-semibold py-2 px-3 rounded-xl text-xs shadow-xs transition-colors flex items-center justify-center gap-1.5" type="submit">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                      Add to Cart
                    </button>
                  <?php } else { ?>
                    <button onclick="openLoginModalDirect('signin')"
                            class="w-full bg-slate-900 hover:bg-blue-600 text-white font-semibold py-2 px-3 rounded-xl text-xs shadow-xs transition-colors flex items-center justify-center gap-1.5" type="button">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                      Add to Cart
                    </button>
                  <?php } ?>
                <?php } else { ?>
                  <button disabled class="w-full bg-slate-100 text-slate-400 font-semibold py-2 px-3 rounded-xl text-xs cursor-not-allowed" type="button">
                    Out of Stock
                  </button>
                <?php } ?>
              </form>
            </div>

          </div>
        <?php }
      } ?>
    </div>
  </div>
</section>

<!-- Why Choose TecHub Section -->
<section class="py-16 bg-white border-t border-slate-200/80">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-xl mx-auto mb-12">
      <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Quality Assurance</span>
      <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
        Why Shop at TecHub Galle?
      </h3>
      <p class="text-xs text-slate-500 mt-2">
        We are committed to delivering authentic devices, honest pricing, and trustworthy local warranty services.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 text-center">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl mx-auto mb-4 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h4 class="font-bold text-base text-slate-900 mb-1.5">
          TRCSL Approved & Guaranteed Genuine
        </h4>
        <p class="text-slate-600 text-xs leading-relaxed">
          100% brand new original smartphones and gear backed with official company warranty.
        </p>
      </div>

      <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 text-center">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl mx-auto mb-4 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
        </div>
        <h4 class="font-bold text-base text-slate-900 mb-1.5">
          Fast Islandwide Courier
        </h4>
        <p class="text-slate-600 text-xs leading-relaxed">
          Reliable door-to-door delivery across Sri Lanka with secure bubble packaging and tracking.
        </p>
      </div>

      <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 text-center">
        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl mx-auto mb-4 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <h4 class="font-bold text-base text-slate-900 mb-1.5">
          Local Warranty & After-Sales
        </h4>
        <p class="text-slate-600 text-xs leading-relaxed">
          Walk into our Galle store or contact our technical team for repairs, software help, and warranty claims.
        </p>
      </div>

    </div>
  </div>
</section>

<?php
include '../include/footer.php';
?>