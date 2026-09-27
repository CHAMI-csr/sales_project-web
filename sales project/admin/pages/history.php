<?php
include '../include/header.php';
include "../include/connection.php";
if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Fetch all order history
$query = "SELECT * FROM orderhistory";
$result = mysqli_query($con, $query);
$history_rows = [];
$total_income = 0;
$total_units_sold = 0;
$total_orders = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $history_rows[] = $row;
        $total_orders++;
        $price = floatval($row['totalprice']);
        $qty = intval($row['qty']);
        $total_income += $price;
        $total_units_sold += $qty;
    }
}

$avg_order_value = ($total_orders > 0) ? ($total_income / $total_orders) : 0;
?>

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Order History</h1>
        <p class="page-subtitle">Archive of all completed transactions and revenue</p>
    </div>

    <button onclick="generatePDF()" id="pdfButton" class="btn-primary flex-shrink-0">
        <svg id="pdfIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <span id="pdfButtonText">Export PDF</span>
    </button>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Income</div>
            <div class="text-2xl font-bold text-emerald-400 mt-1">LKR <?= number_format($total_income, 2) ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Lifetime revenue</div>
        </div>
        <div class="kpi-icon-wrapper bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Completed Orders</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $total_orders ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Processed orders</div>
        </div>
        <div class="kpi-icon-wrapper bg-slate-800 text-slate-300 border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Units Sold</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $total_units_sold ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Products sold</div>
        </div>
        <div class="kpi-icon-wrapper bg-blue-500/10 text-blue-400 border border-blue-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div class="text-xs font-medium text-slate-400">Avg. Order Value</div>
            <div class="text-xl font-bold text-white mt-1">LKR <?= number_format($avg_order_value, 2) ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Per transaction</div>
        </div>
        <div class="kpi-icon-wrapper bg-slate-800 text-slate-300 border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
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
        <input type="text" id="search-input" class="filter-input" placeholder="Search customer, seller, business, or product...">
    </div>

    <div class="flex items-center gap-2">
        <input type="date" id="date-from" class="filter-input" style="min-width:140px; padding-left:10px;" title="From Date">
        <span class="text-xs text-slate-500">to</span>
        <input type="date" id="date-to" class="filter-input" style="min-width:140px; padding-left:10px;" title="To Date">
    </div>

    <div class="flex items-center gap-1.5 overflow-x-auto py-1">
        <button type="button" class="filter-pill active" data-date-range="" onclick="setQuickDate('')">All</button>
        <button type="button" class="filter-pill" data-date-range="thismonth" onclick="setQuickDate('thismonth')">This Month</button>
        <button type="button" class="filter-pill" data-date-range="thisyear" onclick="setQuickDate('thisyear')">This Year</button>
    </div>

    <button class="btn-clear" onclick="clearFilters()">Reset</button>

    <div class="text-xs text-slate-400 ml-auto flex items-center gap-1.5">
        <span id="result-count">Showing <?= $total_orders ?> records</span>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="overflow-x-auto max-h-[620px] overflow-y-auto">
        <table id="myTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Seller</th>
                    <th>Business</th>
                    <th>PID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($history_rows as $row) {
                    $user_id  = $row['user_id']    ?? '';
                    $pname    = $row['pnames']      ?? '';
                    $price    = floatval($row['totalprice'] ?? 0);
                    $qty      = intval($row['qty']  ?? 0);
                    $order_id = $row['orderid']     ?? '';
                    $date     = $row['date']        ?? '';
                    $pid      = $row['pid']         ?? '';

                    $seller_name   = 'Unknown';
                    $business_name = 'Unknown';

                    $safe_pid = mysqli_real_escape_string($con, $pid);
                    $product_result = mysqli_query($con, "SELECT user_id FROM production WHERE pid='$safe_pid' LIMIT 1");
                    if ($product_result && $product_row = mysqli_fetch_assoc($product_result)) {
                        $seller_id = $product_row['user_id'];
                        $safe_sid  = mysqli_real_escape_string($con, $seller_id);

                        $seller_result = mysqli_query($con, "SELECT username FROM users WHERE user_id='$safe_sid' LIMIT 1");
                        if ($seller_result && $seller_row = mysqli_fetch_assoc($seller_result)) {
                            $seller_name = $seller_row['username'] ?? 'Unknown';
                        }

                        $business_result = mysqli_query($con, "SELECT bname FROM businessregistration WHERE user_id='$safe_sid' LIMIT 1");
                        if ($business_result && $business_row = mysqli_fetch_assoc($business_result)) {
                            $business_name = $business_row['bname'] ?? 'Unknown';
                        }
                    }

                    $user_name = 'Customer';
                    $email     = 'N/A';
                    $safe_uid  = mysqli_real_escape_string($con, $user_id);
                    $user_result = mysqli_query($con, "SELECT username, email FROM users WHERE user_id='$safe_uid' LIMIT 1");
                    if ($user_result && $user_row = mysqli_fetch_assoc($user_result)) {
                        $user_name = $user_row['username'] ?? 'Customer';
                        $email     = $user_row['email']    ?? 'N/A';
                    }
                ?>
                <tr data-username="<?= htmlspecialchars(strtolower($user_name)) ?>"
                    data-email="<?= htmlspecialchars(strtolower($email)) ?>"
                    data-seller="<?= htmlspecialchars(strtolower($seller_name)) ?>"
                    data-bname="<?= htmlspecialchars(strtolower($business_name)) ?>"
                    data-pname="<?= htmlspecialchars(strtolower($pname)) ?>"
                    data-pid="<?= htmlspecialchars(strtolower($pid)) ?>"
                    data-date="<?= htmlspecialchars($date) ?>"
                    data-price="<?= $price ?>">
                    
                    <td class="whitespace-nowrap">
                        <div class="font-medium text-white text-sm"><?= htmlspecialchars($user_name) ?></div>
                        <div class="text-xs text-slate-400"><?= htmlspecialchars($email) ?></div>
                    </td>

                    <td class="whitespace-nowrap">
                        <div class="font-medium text-white text-sm"><?= htmlspecialchars($pname) ?></div>
                        <div class="text-xs text-slate-500 font-mono">OID: #<?= htmlspecialchars($order_id) ?></div>
                    </td>

                    <td class="whitespace-nowrap font-medium text-white text-sm">
                        <?= $qty ?>
                    </td>

                    <td class="whitespace-nowrap font-medium text-emerald-400 text-sm">
                        LKR <?= number_format($price, 2) ?>
                    </td>

                    <td class="whitespace-nowrap text-xs text-slate-400">
                        <?= htmlspecialchars($date) ?>
                    </td>

                    <td class="whitespace-nowrap text-sm text-slate-300">
                        <?= htmlspecialchars($seller_name) ?>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="badge badge-slate">
                            <?= htmlspecialchars($business_name) ?>
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
        <p class="text-sm text-slate-400">No historical records matched your filters.</p>
        <button onclick="clearFilters()" class="btn-clear mt-3">Reset Filters</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function setQuickDate(range) {
    const fromInput = document.getElementById('date-from');
    const toInput = document.getElementById('date-to');
    const now = new Date();
    const pad = num => String(num).padStart(2, '0');

    if (range === 'thismonth') {
        const firstDay = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-01`;
        const lastDay = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate())}`;
        fromInput.value = firstDay;
        toInput.value = lastDay;
    } else if (range === 'thisyear') {
        fromInput.value = `${now.getFullYear()}-01-01`;
        toInput.value = `${now.getFullYear()}-12-31`;
    } else {
        fromInput.value = '';
        toInput.value = '';
    }

    document.querySelectorAll('.filter-pill[data-date-range]').forEach(pill => {
        if (pill.getAttribute('data-date-range') === range) {
            pill.classList.add('active');
        } else {
            pill.classList.remove('active');
        }
    });

    filterTable();
}

function filterTable() {
    const search = document.getElementById('search-input').value.trim().toLowerCase();
    const dateFrom = document.getElementById('date-from').value;
    const dateTo = document.getElementById('date-to').value;
    const rows = document.querySelectorAll('#myTable tbody tr');
    let visible = 0;

    rows.forEach(row => {
        const username = row.dataset.username || '';
        const email = row.dataset.email || '';
        const seller = row.dataset.seller || '';
        const bname = row.dataset.bname || '';
        const pname = row.dataset.pname || '';
        const pid = row.dataset.pid || '';
        const rowDate = row.dataset.date || '';

        const matchSearch = !search || username.includes(search) || email.includes(search) ||
                            seller.includes(search) || bname.includes(search) ||
                            pname.includes(search) || pid.includes(search);

        let matchDate = true;
        if (dateFrom && rowDate) matchDate = matchDate && (rowDate >= dateFrom);
        if (dateTo && rowDate) matchDate = matchDate && (rowDate <= dateTo);

        if (matchSearch && matchDate) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    const resultCountEl = document.getElementById('result-count');
    if (resultCountEl) {
        resultCountEl.textContent = `Showing ${visible} of ${rows.length} records`;
    }

    const emptyEl = document.getElementById('empty-state');
    if (emptyEl) {
        emptyEl.classList.toggle('hidden', visible > 0);
    }
}

function clearFilters() {
    document.getElementById('search-input').value = '';
    setQuickDate('');
}

document.getElementById('search-input').addEventListener('input', filterTable);
document.getElementById('date-from').addEventListener('change', filterTable);
document.getElementById('date-to').addEventListener('change', filterTable);

filterTable();

function generatePDF() {
    const btn = document.getElementById('pdfButton');
    const btnText = document.getElementById('pdfButtonText');
    const originalText = btnText.textContent;
    btn.disabled = true;
    btnText.textContent = 'Exporting...';

    const { jsPDF } = window.jspdf;
    const element = document.getElementById('myTable');

    html2canvas(element, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#1e293b'
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgWidth = 190;
        const pageHeight = 297;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        let heightLeft = imgHeight;
        let position = 20;

        pdf.setFontSize(14);
        pdf.setTextColor(15, 23, 42);
        pdf.text('Order History Report', 105, 12, { align: 'center' });

        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        pdf.save(`Order_History_${new Date().toISOString().slice(0, 10)}.pdf`);
    }).catch(err => {
        console.error('PDF Export Error:', err);
        alert('Could not export PDF. Please try again.');
    }).finally(() => {
        btn.disabled = false;
        btnText.textContent = originalText;
    });
}
</script>

<?php
include '../include/footer.php';
?>