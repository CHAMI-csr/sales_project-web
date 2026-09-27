<?php
include '../include/header.php';
include "../include/connection.php";
if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Fetch all active orders
$query = "SELECT * FROM ordertable";
$result = mysqli_query($con, $query);
$orders = [];
$total_orders = 0;
$total_revenue = 0;
$total_units = 0;
$today_orders_count = 0;
$today_date = date('Y-m-d');
$categories_list = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
        $total_orders++;
        $qty = intval($row['qty']);
        $price = floatval($row['price']);
        $total_revenue += $price;
        $total_units += $qty;

        if (!empty($row['orderdate']) && strpos($row['orderdate'], $today_date) !== false) {
            $today_orders_count++;
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
        <h1 class="page-title">Orders</h1>
        <p class="page-subtitle">Track incoming orders and customer details</p>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Orders</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $total_orders ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Active records</div>
        </div>
        <div class="kpi-icon-wrapper bg-slate-800 text-slate-300 border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Value</div>
            <div class="text-xl font-bold text-white mt-1">LKR <?= number_format($total_revenue, 2) ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Gross amount</div>
        </div>
        <div class="kpi-icon-wrapper bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Units Ordered</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $total_units ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Item quantity</div>
        </div>
        <div class="kpi-icon-wrapper bg-blue-500/10 text-blue-400 border border-blue-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Today's Orders</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $today_orders_count ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Placed today</div>
        </div>
        <div class="kpi-icon-wrapper bg-slate-800 text-slate-300 border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
        <input type="text" id="search-input" class="filter-input" placeholder="Search customer, email, product, or PID...">
    </div>

    <select id="category-filter" class="filter-select">
        <option value="">All Categories</option>
        <?php foreach ($categories_list as $cat) { ?>
            <option value="<?= htmlspecialchars(strtolower($cat)) ?>"><?= htmlspecialchars($cat) ?></option>
        <?php } ?>
    </select>

    <button class="btn-clear" onclick="clearFilters()">Reset</button>

    <div class="text-xs text-slate-400 ml-auto flex items-center gap-1.5">
        <span id="result-count">Showing <?= $total_orders ?> orders</span>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="overflow-x-auto max-h-[620px] overflow-y-auto">
        <table id="orderTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Order Date</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>PID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $row) {
                    $user_id     = $row['user_id']     ?? '';
                    $pid         = $row['pid']         ?? '';
                    $pname       = $row['pname']       ?? 'Unknown Product';
                    $price       = floatval($row['price']  ?? 0);
                    $discription = $row['discription'] ?? '';
                    $qty         = intval($row['qty']  ?? 0);
                    $categories  = $row['categories']  ?? '';
                    $date        = $row['orderdate']   ?? '';

                    // image is not stored in ordertable — fetch from production by pid
                    $image = 'default.png';
                    $safe_pid = mysqli_real_escape_string($con, $pid);
                    $img_result = mysqli_query($con, "SELECT image FROM production WHERE pid='$safe_pid' LIMIT 1");
                    if ($img_result && $img_row = mysqli_fetch_assoc($img_result)) {
                        $image = $img_row['image'] ?? 'default.png';
                    }

                    $user_name = 'Customer';
                    $email = 'N/A';
                    $safe_uid = mysqli_real_escape_string($con, $user_id);
                    $user_result = mysqli_query($con, "SELECT username, email FROM users WHERE user_id='$safe_uid' LIMIT 1");
                    if ($user_result && $user_row = mysqli_fetch_assoc($user_result)) {
                        $user_name = $user_row['username'] ?? 'Customer';
                        $email     = $user_row['email']    ?? 'N/A';
                    }
                ?>
                <tr data-username="<?= htmlspecialchars(strtolower($user_name)) ?>"
                    data-email="<?= htmlspecialchars(strtolower($email)) ?>"
                    data-pname="<?= htmlspecialchars(strtolower($pname)) ?>"
                    data-pid="<?= htmlspecialchars(strtolower($pid)) ?>"
                    data-category="<?= htmlspecialchars(strtolower($categories)) ?>">
                    
                    <td class="whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <img class="product-thumb previewable-image"
                                src="<?= STORE_URL ?>/images/items/<?= rawurlencode($image) ?>"
                                alt="<?= htmlspecialchars($pname) ?>"
                                data-title="<?= htmlspecialchars($pname) ?>"
                                onerror="this.onerror=null; this.src='https://placehold.co/48x48/1e293b/64748b?text=IMG';">
                            <div>
                                <div class="font-medium text-white text-sm hover:text-blue-400 transition cursor-pointer"
                                     onclick="showImageModal('<?= STORE_URL ?>/images/items/<?= rawurlencode($image) ?>', '<?= htmlspecialchars(addslashes($pname)) ?>')">
                                    <?= htmlspecialchars($pname) ?>
                                </div>
                                <div class="text-xs text-slate-500 font-mono">PID: #<?= htmlspecialchars($pid) ?></div>
                            </div>
                        </div>
                    </td>

                    <td class="whitespace-nowrap font-medium text-white text-sm">
                        <?= htmlspecialchars($user_name) ?>
                    </td>

                    <td class="whitespace-nowrap text-sm text-slate-300">
                        <?= htmlspecialchars($email) ?>
                    </td>

                    <td class="whitespace-nowrap text-xs text-slate-400">
                        <?= htmlspecialchars($date) ?>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="badge badge-slate font-medium">
                            <?= $qty ?> pcs
                        </span>
                    </td>

                    <td class="whitespace-nowrap font-medium text-white text-sm">
                        LKR <?= number_format($price, 2) ?>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="badge badge-blue">
                            <?= htmlspecialchars($categories) ?>
                        </span>
                    </td>

                    <td class="whitespace-nowrap text-xs font-mono text-slate-400">
                        <?= htmlspecialchars($pid) ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden text-center py-12 px-4">
        <p class="text-sm text-slate-400">No orders matched your search criteria.</p>
        <button onclick="clearFilters()" class="btn-clear mt-3">Reset Filters</button>
    </div>
</div>

<script>
function filterTable() {
    const search = document.getElementById('search-input').value.trim().toLowerCase();
    const category = document.getElementById('category-filter').value.toLowerCase();
    const rows = document.querySelectorAll('#orderTable tbody tr');
    let visible = 0;

    rows.forEach(row => {
        const username = row.dataset.username || '';
        const email = row.dataset.email || '';
        const pname = row.dataset.pname || '';
        const pid = row.dataset.pid || '';
        const cat = row.dataset.category || '';

        const matchSearch = !search || username.includes(search) || email.includes(search) || pname.includes(search) || pid.includes(search);
        const matchCategory = !category || cat.includes(category);

        if (matchSearch && matchCategory) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    const resultCountEl = document.getElementById('result-count');
    if (resultCountEl) {
        resultCountEl.textContent = `Showing ${visible} of ${rows.length} orders`;
    }

    const emptyEl = document.getElementById('empty-state');
    if (emptyEl) {
        emptyEl.classList.toggle('hidden', visible > 0);
    }
}

function clearFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('category-filter').value = '';
    filterTable();
}

document.getElementById('search-input').addEventListener('input', filterTable);
document.getElementById('category-filter').addEventListener('change', filterTable);

filterTable();
</script>

<?php
include '../include/footer.php';
?>