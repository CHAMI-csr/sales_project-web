<?php 
include '../include/header.php'; 
?>

<!-- Category Hero Banner -->
<section class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
      <!-- Breadcrumbs -->
      <nav class="flex items-center gap-2 text-xs text-slate-400 mb-3">
        <a href="../pages/home.php" class="hover:text-white transition-colors">Home</a>
        <span>/</span>
        <span class="text-indigo-400 font-semibold">All Products</span>
      </nav>
      <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">All Products</h1>
      <p class="text-slate-300 text-sm mt-2 max-w-xl">
        Browse our complete collection of smartphones, audio devices, chargers, and cases.
      </p>
    </div>

    <!-- Quick Navigation Pills -->
    <div class="flex flex-wrap gap-2">
      <a href="../pages/items.php" class="px-4 py-2 rounded-full text-xs font-bold bg-indigo-600 text-white shadow transition-all">All Items</a>
      <a href="../pages/phones.php" class="px-4 py-2 rounded-full text-xs font-semibold bg-white/10 hover:bg-white/20 text-white transition-all">Phones</a>
      <a href="../pages/headphones.php" class="px-4 py-2 rounded-full text-xs font-semibold bg-white/10 hover:bg-white/20 text-white transition-all">Headphones</a>
      <a href="../pages/backcovers.php" class="px-4 py-2 rounded-full text-xs font-semibold bg-white/10 hover:bg-white/20 text-white transition-all">Accessories</a>
    </div>
  </div>
</section>

<!-- Filter & Search Toolbar -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col lg:flex-row items-center justify-between gap-4">
    
    <!-- Live Search Input -->
    <div class="relative w-full lg:w-96">
      <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
      <input type="text" id="productSearchInput" placeholder="Search across all products, brands & specs..."
             class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:bg-white transition-colors">
    </div>

    <!-- Category Tabs & Controls -->
    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-end">
      
      <!-- Category Pills -->
      <div class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-semibold overflow-x-auto max-w-full">
        <button type="button" onclick="filterCategoryTab('all', this)" class="cattab-btn px-3 py-1.5 rounded-lg bg-white text-indigo-600 shadow-xs font-bold transition-all">
          All
        </button>
        <button type="button" onclick="filterCategoryTab('phones', this)" class="cattab-btn px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-all">
          Phones
        </button>
        <button type="button" onclick="filterCategoryTab('headphones', this)" class="cattab-btn px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-all">
          Headphones
        </button>
        <button type="button" onclick="filterCategoryTab('chargers', this)" class="cattab-btn px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-all">
          Chargers
        </button>
        <button type="button" onclick="filterCategoryTab('backcovers', this)" class="cattab-btn px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-all">
          Cases
        </button>
      </div>

      <!-- In Stock Filter Toggle -->
      <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 px-3.5 py-2 rounded-xl transition-colors">
        <input type="checkbox" id="inStockFilter" class="rounded text-indigo-600 focus:ring-indigo-500">
        <span>In Stock Only</span>
      </label>

      <!-- Sort Dropdown -->
      <select id="sortSelect" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-indigo-600 transition-colors">
        <option value="default">Sort: Default</option>
        <option value="price-asc">Price: Low to High</option>
        <option value="price-desc">Price: High to Low</option>
        <option value="name-asc">Name: A to Z</option>
      </select>
    </div>

  </div>
</section>

<!-- Products Catalog Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  
  <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php
    $query = "SELECT * FROM production ORDER BY id DESC";
    $result = mysqli_query($con, $query);
    $total_items = ($result) ? mysqli_num_rows($result) : 0;

    if ($total_items > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $pname = $row['pname'];
        $price = (float)$row['price'];
        $discription = $row['discription'];
        $image = !empty($row['image']) ? $row['image'] : 'mobile.png';
        $qty = (int)$row['qty'];
        $categories = $row['categories'];
        $pid = $row['pid'];
        ?>
        <div class="product-item-card product-card rounded-2xl flex flex-col overflow-hidden border border-slate-200 bg-white hover:shadow-lg transition-all duration-300"
             data-name="<?= htmlspecialchars(strtolower($pname)) ?>"
             data-desc="<?= htmlspecialchars(strtolower($discription)) ?>"
             data-cat="<?= htmlspecialchars(strtolower($categories)) ?>"
             data-price="<?= $price ?>"
             data-stock="<?= $qty ?>">
          
          <!-- Image & Title Link to Details Page -->
          <a href="../pages/product_details.php?pid=<?= urlencode($pid) ?>" class="block group">
            <div class="product-img-wrapper aspect-[4/3] flex items-center justify-center p-4 bg-slate-50 relative border-b border-slate-100 overflow-hidden">
              <img src="../images/items/<?= rawurlencode($image) ?>" 
                   alt="<?= htmlspecialchars($pname) ?>"
                   class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                   onerror="this.src='https://placehold.co/400x300/f8fafc/64748b?text=<?= urlencode($pname) ?>';">
              
              <!-- Badges -->
              <div class="absolute top-3 left-3">
                <?php if ($qty > 0) { ?>
                  <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-600 text-white shadow-xs">
                    Available (<?= $qty ?>)
                  </span>
                <?php } else { ?>
                  <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-600 text-white shadow-xs">
                    Out of Stock
                  </span>
                <?php } ?>
              </div>

              <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-800 text-white uppercase tracking-wider">
                <?= htmlspecialchars($categories) ?>
              </span>
            </div>

            <!-- Product Info -->
            <div class="p-4 pb-2">
              <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-600 block mb-1">
                <?= htmlspecialchars($categories) ?>
              </span>

              <h2 class="text-base font-bold text-slate-900 truncate mb-1 group-hover:text-indigo-600 transition-colors" title="<?= htmlspecialchars($pname) ?>">
                <?= htmlspecialchars($pname) ?>
              </h2>

              <p class="text-xs text-slate-500 line-clamp-2 mb-2 min-h-[32px]">
                <?= htmlspecialchars($discription) ?>
              </p>
            </div>
          </a>

          <!-- Product Body -->
          <div class="px-4 pb-4 flex-1 flex flex-col justify-end">

            <div>
              <div class="flex items-center justify-between mb-3">
                <span class="text-base sm:text-lg font-black text-slate-900">
                  LKR. <?= number_format($price, 2) ?>
                </span>
              </div>

              <!-- Cart Form -->
              <form action="../lib/cart_backend.php" method="POST" class="space-y-2">
                <input type="hidden" name="pid" value="<?= htmlspecialchars($pid) ?>">
                <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                <div class="flex items-center gap-2">
                  <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 px-2 py-1">
                    <button type="button" onclick="var el = document.getElementById('qty-<?= $pid ?>'); if(el.value > 1) el.value--;"
                            class="w-6 h-6 flex items-center justify-center text-slate-600 hover:text-indigo-600 font-bold text-sm select-none">-</button>
                    <input type="number" id="qty-<?= $pid ?>" name="qty" value="1" min="1" max="<?= max(1, $qty) ?>"
                           class="w-8 text-center text-xs font-bold bg-transparent border-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    <button type="button" onclick="var el = document.getElementById('qty-<?= $pid ?>'); if(el.value < <?= $qty ?>) el.value++;"
                            class="w-6 h-6 flex items-center justify-center text-slate-600 hover:text-indigo-600 font-bold text-sm select-none">+</button>
                  </div>

                  <?php if ($qty > 0) { ?>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                      <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Add to Cart
                      </button>
                    <?php } else { ?>
                      <button type="button" onclick="openLoginModalDirect('signin');" class="flex-1 py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Add to Cart
                      </button>
                    <?php } ?>
                  <?php } else { ?>
                    <button disabled type="button" class="flex-1 py-2 px-3 rounded-xl bg-slate-100 text-slate-400 font-semibold text-xs cursor-not-allowed">
                      Out of Stock
                    </button>
                  <?php } ?>
                </div>
              </form>
            </div>
          </div>

        </div>
      <?php }
    } ?>
  </div>

  <!-- Empty Search Feedback -->
  <div id="noResultsState" class="hidden py-16 text-center">
    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
      <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>
    <h3 class="text-base font-bold text-slate-900 mb-1">No Products Found</h3>
    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">No products matched your search. Try adjusting your search query.</p>
    <button type="button" onclick="document.getElementById('productSearchInput').value=''; document.getElementById('inStockFilter').checked=false; filterCategoryTab('all', document.querySelector('.cattab-btn'));"
            class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-xs hover:bg-indigo-100 transition-colors">
      Reset Filters
    </button>
  </div>

</section>

<!-- Client-side Live Search, Tab & Sort Script -->
<script>
  let activeTabCat = 'all';

  function filterCategoryTab(cat, btn) {
    activeTabCat = cat.toLowerCase();
    document.querySelectorAll('.cattab-btn').forEach(b => {
      b.classList.remove('bg-white', 'text-indigo-600', 'shadow-xs', 'font-bold');
      b.classList.add('text-slate-600');
    });
    if (btn) {
      btn.classList.add('bg-white', 'text-indigo-600', 'shadow-xs', 'font-bold');
      btn.classList.remove('text-slate-600');
    }
    filterProducts();
  }

  function filterProducts() {
    const searchVal = document.getElementById('productSearchInput').value.toLowerCase().trim();
    const inStockOnly = document.getElementById('inStockFilter').checked;
    const cards = Array.from(document.querySelectorAll('.product-item-card'));
    let visibleCount = 0;

    cards.forEach(card => {
      const name = card.getAttribute('data-name') || '';
      const desc = card.getAttribute('data-desc') || '';
      const cat = (card.getAttribute('data-cat') || '').toLowerCase();
      const stock = parseInt(card.getAttribute('data-stock') || '0', 10);

      const matchesSearch = !searchVal || name.includes(searchVal) || desc.includes(searchVal);
      const matchesStock = !inStockOnly || stock > 0;
      const matchesCat = (activeTabCat === 'all') || cat.includes(activeTabCat);

      if (matchesSearch && matchesStock && matchesCat) {
        card.classList.remove('hidden');
        visibleCount++;
      } else {
        card.classList.add('hidden');
      }
    });

    const noResults = document.getElementById('noResultsState');
    if (noResults) {
      if (visibleCount === 0) {
        noResults.classList.remove('hidden');
      } else {
        noResults.classList.add('hidden');
      }
    }
  }

  function sortProducts() {
    const sortVal = document.getElementById('sortSelect').value;
    const grid = document.getElementById('productGrid');
    const cards = Array.from(document.querySelectorAll('.product-item-card'));

    cards.sort((a, b) => {
      const priceA = parseFloat(a.getAttribute('data-price') || '0');
      const priceB = parseFloat(b.getAttribute('data-price') || '0');
      const nameA = a.getAttribute('data-name') || '';
      const nameB = b.getAttribute('data-name') || '';

      if (sortVal === 'price-asc') return priceA - priceB;
      if (sortVal === 'price-desc') return priceB - priceA;
      if (sortVal === 'name-asc') return nameA.localeCompare(nameB);
      return 0;
    });

    cards.forEach(card => grid.appendChild(card));
  }

  document.getElementById('productSearchInput').addEventListener('input', filterProducts);
  document.getElementById('inStockFilter').addEventListener('change', filterProducts);
  document.getElementById('sortSelect').addEventListener('change', sortProducts);
</script>

<?php 
include '../include/footer.php'; 
?>