<?php
include '../include/header.php';
include "../include/connection.php";
if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Fetch all products
$query = "SELECT * FROM production";
$result = mysqli_query($con, $query);
$products = [];
$total_products = 0;
$in_stock_count = 0;
$low_stock_count = 0;
$out_of_stock_count = 0;
$total_inventory_value = 0;
$categories_list = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
        $total_products++;
        $qty = intval($row['qty']);
        $price = floatval($row['price']);
        $total_inventory_value += ($price * $qty);

        if ($qty == 0) {
            $out_of_stock_count++;
        } elseif ($qty <= 5) {
            $low_stock_count++;
        } else {
            $in_stock_count++;
        }

        if (!empty($row['categories']) && !in_array($row['categories'], $categories_list)) {
            $categories_list[] = $row['categories'];
        }
    }
}
?>

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Product Management</h1>
        <p class="page-subtitle">Monitor supplier inventory, catalog pricing, and stock levels</p>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="kpi-card" onclick="setQuickStock('')" title="Show all products">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Products</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $total_products ?></div>
            <div class="text-xs text-slate-500 mt-0.5"><?= count($categories_list) ?> categories</div>
        </div>
        <div class="kpi-icon-wrapper bg-slate-800 text-slate-300 border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card" onclick="setQuickStock('instock')" title="Filter in-stock products">
        <div>
            <div class="text-xs font-medium text-slate-400">In Stock</div>
            <div class="text-2xl font-bold text-emerald-400 mt-1"><?= $in_stock_count ?></div>
            <div class="text-xs text-slate-500 mt-0.5">> 5 units</div>
        </div>
        <div class="kpi-icon-wrapper bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card" onclick="setQuickStock('lowstock')" title="Filter low stock products">
        <div>
            <div class="text-xs font-medium text-slate-400">Low Stock</div>
            <div class="text-2xl font-bold text-amber-400 mt-1"><?= $low_stock_count ?></div>
            <div class="text-xs text-slate-500 mt-0.5">1-5 units remaining</div>
        </div>
        <div class="kpi-icon-wrapper bg-amber-500/10 text-amber-400 border border-amber-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Stock Value</div>
            <div class="text-xl font-bold text-white mt-1">LKR <?= number_format($total_inventory_value, 2) ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Inventory worth</div>
        </div>
        <div class="kpi-icon-wrapper bg-blue-500/10 text-blue-400 border border-blue-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filter-bar bg-[#1e293b] p-3 rounded-lg border border-slate-700">
    <div class="filter-input-wrapper flex-1">
        <svg class="filter-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="search-input" class="filter-input" placeholder="Search product name, business, or PID...">
    </div>

    <div class="flex items-center gap-1.5 overflow-x-auto py-1">
        <button type="button" class="filter-pill active" data-pill-stock="" onclick="setQuickStock('')">All</button>
        <button type="button" class="filter-pill" data-pill-stock="instock" onclick="setQuickStock('instock')">In Stock</button>
        <button type="button" class="filter-pill" data-pill-stock="lowstock" onclick="setQuickStock('lowstock')">Low Stock</button>
        <button type="button" class="filter-pill" data-pill-stock="outofstock" onclick="setQuickStock('outofstock')">Out of Stock</button>
    </div>

    <select id="category-filter" class="filter-select">
        <option value="">All Categories</option>
        <?php foreach ($categories_list as $cat) { ?>
            <option value="<?= htmlspecialchars(strtolower($cat)) ?>"><?= htmlspecialchars($cat) ?></option>
        <?php } ?>
    </select>

    <button class="btn-clear" onclick="clearFilters()">Reset</button>

    <div class="text-xs text-slate-400 ml-auto flex items-center gap-1.5">
        <span id="result-count">Showing <?= $total_products ?> products</span>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="overflow-x-auto max-h-[620px] overflow-y-auto">
        <table id="productTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Date Added</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $row) {
                    $user_id     = $row['user_id']    ?? '';
                    $pid         = $row['pid']         ?? '';
                    $pname       = $row['pname']       ?? '';
                    $price       = floatval($row['price'] ?? 0);
                    $discription = $row['discription'] ?? '';
                    $image       = $row['image']       ?? '';
                    $qty         = intval($row['qty']  ?? 0);
                    $categories  = $row['categories']  ?? '';
                    $date        = $row['Add_date']    ?? '';

                    $bname = 'N/A';
                    $safe_uid = mysqli_real_escape_string($con, $user_id);
                    $user_result = mysqli_query($con, "SELECT bname FROM businessregistration WHERE user_id='$safe_uid' LIMIT 1");
                    if ($user_result && $user_row = mysqli_fetch_assoc($user_result)) {
                        $bname = $user_row['bname'] ?? 'N/A';
                    }

                    if ($qty <= 0) {
                        $stock_status = 'outofstock';
                        $qty_badge = 'badge-red';
                        $qty_text = 'Out of Stock';
                    } elseif ($qty <= 5) {
                        $stock_status = 'lowstock';
                        $qty_badge = 'badge-yellow';
                        $qty_text = $qty . ' left';
                    } else {
                        $stock_status = 'instock';
                        $qty_badge = 'badge-green';
                        $qty_text = $qty . ' in stock';
                    }
                ?>
                <tr data-pname="<?= htmlspecialchars(strtolower($pname)) ?>"
                    data-bname="<?= htmlspecialchars(strtolower($bname)) ?>"
                    data-pid="<?= htmlspecialchars(strtolower($pid)) ?>"
                    data-category="<?= htmlspecialchars(strtolower($categories)) ?>"
                    data-stock="<?= $stock_status ?>">
                    
                    <td class="whitespace-nowrap">
                        <img class="product-thumb previewable-image"
                            src="<?= STORE_URL ?>/images/items/<?= rawurlencode($image) ?>"
                            alt="<?= htmlspecialchars($pname) ?>"
                            data-title="<?= htmlspecialchars($pname) ?>"
                            onerror="this.onerror=null; this.src='https://placehold.co/48x48/1e293b/64748b?text=IMG';">
                    </td>

                    <td class="max-w-xs">
                        <div class="font-medium text-white text-sm"><?= htmlspecialchars($pname) ?></div>
                        <div class="text-xs text-slate-500 font-mono">PID: #<?= htmlspecialchars($pid) ?></div>
                        <?php if (!empty($discription)) { ?>
                            <div class="text-xs text-slate-400 mt-1 line-clamp-1" title="<?= htmlspecialchars($discription) ?>">
                                <?= htmlspecialchars($discription) ?>
                            </div>
                        <?php } ?>
                    </td>

                    <td class="whitespace-nowrap">
                        <div class="text-sm font-medium text-white"><?= htmlspecialchars($bname) ?></div>
                        <div class="text-xs text-slate-500">ID: #<?= htmlspecialchars($user_id) ?></div>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="badge badge-slate"><?= htmlspecialchars($categories) ?></span>
                    </td>

                    <td class="whitespace-nowrap font-medium text-white text-sm">
                        LKR <?= number_format($price, 2) ?>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="badge <?= $qty_badge ?>"><?= $qty_text ?></span>
                    </td>

                    <td class="whitespace-nowrap text-xs text-slate-400">
                        <?= htmlspecialchars($date) ?>
                    </td>

                    <td class="whitespace-nowrap text-right">
                        <a href="../lib/delete.php?pid=<?= htmlspecialchars($pid) ?>&user_id=<?= htmlspecialchars($user_id) ?>"
                            onclick="return confirm('Permanently delete <?= htmlspecialchars(addslashes($pname)) ?>?')"
                            class="action-btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden text-center py-12 px-4">
        <p class="text-sm text-slate-400">No products matched your search criteria.</p>
        <button onclick="clearFilters()" class="btn-clear mt-3">Reset Filters</button>
    </div>
</div>

<script>
let currentStockStatus = '';

function setQuickStock(stock) {
    currentStockStatus = stock;
    document.querySelectorAll('.filter-pill').forEach(pill => {
        if (pill.getAttribute('data-pill-stock') === stock) {
            pill.classList.add('active');
        } else {
            pill.classList.remove('active');
        }
    });
    filterTable();
}

function filterTable() {
    const search = document.getElementById('search-input').value.trim().toLowerCase();
    const category = document.getElementById('category-filter').value.toLowerCase();
    const rows = document.querySelectorAll('#productTable tbody tr');
    let visible = 0;

    rows.forEach(row => {
        const pname = row.dataset.pname || '';
        const bname = row.dataset.bname || '';
        const pid = row.dataset.pid || '';
        const cat = row.dataset.category || '';
        const stock = row.dataset.stock || '';

        const matchSearch = !search || pname.includes(search) || bname.includes(search) || pid.includes(search);
        const matchCategory = !category || cat.includes(category);
        const matchStock = !currentStockStatus || stock === currentStockStatus;

        if (matchSearch && matchCategory && matchStock) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    const resultCountEl = document.getElementById('result-count');
    if (resultCountEl) {
        resultCountEl.textContent = `Showing ${visible} of ${rows.length} products`;
    }

    const emptyEl = document.getElementById('empty-state');
    if (emptyEl) {
        emptyEl.classList.toggle('hidden', visible > 0);
    }
}

function clearFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('category-filter').value = '';
    setQuickStock('');
}

document.getElementById('search-input').addEventListener('input', filterTable);
document.getElementById('category-filter').addEventListener('change', filterTable);

filterTable();
</script>

<?php
include '../include/footer.php';
?>