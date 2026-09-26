<?php
include '../include/header.php';
include "../include/connection.php";
if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Fetch all rows
$query = "SELECT * FROM businessregistration";
$result = mysqli_query($con, $query);
$suppliers = [];
$total_count = 0;
$approved_count = 0;
$pending_count = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $suppliers[] = $row;
        $total_count++;
        if ($row['approve'] == '1') {
            $approved_count++;
        } else {
            $pending_count++;
        }
    }
}
?>

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="page-title">Supplier Management</h1>
        <p class="page-subtitle">Review and verify supplier business registrations</p>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="kpi-card" onclick="setQuickStatus('')" title="Show all suppliers">
        <div>
            <div class="text-xs font-medium text-slate-400">Total Registered</div>
            <div class="text-2xl font-bold text-white mt-1"><?= $total_count ?></div>
            <div class="text-xs text-slate-500 mt-0.5">All applications</div>
        </div>
        <div class="kpi-icon-wrapper bg-slate-800 text-slate-300 border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card" onclick="setQuickStatus('approved')" title="Filter approved suppliers">
        <div>
            <div class="text-xs font-medium text-slate-400">Approved</div>
            <div class="text-2xl font-bold text-emerald-400 mt-1"><?= $approved_count ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Verified active</div>
        </div>
        <div class="kpi-icon-wrapper bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

    <div class="kpi-card" onclick="setQuickStatus('pending')" title="Filter pending reviews">
        <div>
            <div class="text-xs font-medium text-slate-400">Pending Review</div>
            <div class="text-2xl font-bold text-amber-400 mt-1"><?= $pending_count ?></div>
            <div class="text-xs text-slate-500 mt-0.5">Needs action</div>
        </div>
        <div class="kpi-icon-wrapper bg-amber-500/10 text-amber-400 border border-amber-500/20">
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
        <input type="text" id="search-input" class="filter-input" placeholder="Search by name, email, or registration ID...">
    </div>

    <div class="flex items-center gap-1.5 overflow-x-auto py-1">
        <button type="button" class="filter-pill active" data-pill-status="" onclick="setQuickStatus('')">All</button>
        <button type="button" class="filter-pill" data-pill-status="approved" onclick="setQuickStatus('approved')">Approved</button>
        <button type="button" class="filter-pill" data-pill-status="pending" onclick="setQuickStatus('pending')">Pending</button>
    </div>

    <select id="type-filter" class="filter-select">
        <option value="">All Types</option>
        <option value="sole">Sole Proprietorship</option>
        <option value="partner">Partnership</option>
        <option value="pvt">Private Limited</option>
        <option value="public">Public Limited</option>
    </select>

    <button class="btn-clear" onclick="clearFilters()">Reset</button>

    <div class="text-xs text-slate-400 ml-auto flex items-center gap-1.5">
        <span id="result-count">Showing <?= $total_count ?> suppliers</span>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <div class="overflow-x-auto max-h-[620px] overflow-y-auto">
        <table id="supplierTable">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Business</th>
                    <th>Email</th>
                    <th>Registered</th>
                    <th>Phone</th>
                    <th>Reg. ID</th>
                    <th>Type</th>
                    <th>Certificate</th>
                    <th class="text-right">Status / Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($suppliers as $row) {
                    $user_id      = $row['user_id'];
                    $bname        = $row['bname'];
                    $date         = $row['date'];
                    $bregid       = $row['bregid'];
                    $bnumber      = $row['bnumber'];
                    $btype        = $row['btype'];
                    $bcertificate = $row['bcertificate'];
                    $blogo        = $row['blogo'];
                    $approve      = $row['approve'];

                    $user_email = 'N/A';
                    $query = "SELECT * FROM users WHERE user_id='$user_id'";
                    $user_result = mysqli_query($con, $query);
                    if ($user_result) {
                        while ($user_row = mysqli_fetch_assoc($user_result)) {
                            $user_email = $user_row['email'];
                        }
                    }

                    $is_approved = ($approve == '1');
                ?>
                <tr data-email="<?= htmlspecialchars(strtolower($user_email)) ?>"
                    data-bname="<?= htmlspecialchars(strtolower($bname)) ?>"
                    data-bregid="<?= htmlspecialchars(strtolower($bregid)) ?>"
                    data-btype="<?= htmlspecialchars(strtolower($btype)) ?>"
                    data-status="<?= $is_approved ? 'approved' : 'pending' ?>">
                    
                    <td class="whitespace-nowrap">
                        <img class="product-thumb previewable-image"
                            src="../../images/logo/<?= htmlspecialchars($blogo) ?>"
                            alt="<?= htmlspecialchars($bname) ?> Logo"
                            data-title="<?= htmlspecialchars($bname) ?> Logo"
                            onerror="this.src='../../images/logo/default-logo.png'; this.onerror=null;">
                    </td>

                    <td class="whitespace-nowrap">
                        <div class="font-medium text-white text-sm"><?= htmlspecialchars($bname) ?></div>
                        <div class="text-xs text-slate-500">ID: #<?= htmlspecialchars($user_id) ?></div>
                    </td>

                    <td class="whitespace-nowrap text-sm text-slate-300">
                        <?= htmlspecialchars($user_email) ?>
                    </td>

                    <td class="whitespace-nowrap text-xs text-slate-400">
                        <?= htmlspecialchars($date) ?>
                    </td>

                    <td class="whitespace-nowrap text-sm text-slate-300 font-mono">
                        <?= htmlspecialchars($bnumber) ?>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="text-xs font-mono text-slate-300 bg-slate-800 border border-slate-700 px-2 py-0.5 rounded">
                            <?= htmlspecialchars($bregid) ?>
                        </span>
                    </td>

                    <td class="whitespace-nowrap">
                        <span class="badge badge-slate"><?= htmlspecialchars($btype) ?></span>
                    </td>

                    <td class="whitespace-nowrap">
                        <?php if (!empty($bcertificate)) { ?>
                            <a href="../../files/certificate/<?= htmlspecialchars($bcertificate) ?>" target="_blank"
                                class="inline-flex items-center gap-1.5 text-xs text-blue-400 hover:text-blue-300 hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                <span>View PDF</span>
                            </a>
                        <?php } else { ?>
                            <span class="text-xs text-slate-500">—</span>
                        <?php } ?>
                    </td>

                    <td class="whitespace-nowrap text-right">
                        <?php if (!$is_approved) { ?>
                            <div class="flex items-center justify-end gap-2">
                                <span class="badge badge-yellow">Pending</span>
                                <a href="../lib/approve.php?id=<?= $row['id'] ?>"
                                    onclick="return confirm('Approve registration for <?= htmlspecialchars(addslashes($bname)) ?>?')"
                                    class="action-btn-success">
                                    Approve
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="flex items-center justify-end gap-2">
                                <span class="badge badge-green">Approved</span>
                                <a href="../lib/Deapprove.php?id=<?= $row['id'] ?>"
                                    onclick="return confirm('Revoke approval for <?= htmlspecialchars(addslashes($bname)) ?>?')"
                                    class="action-btn-danger">
                                    Revoke
                                </a>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden text-center py-12 px-4">
        <p class="text-sm text-slate-400">No suppliers matched your search criteria.</p>
        <button onclick="clearFilters()" class="btn-clear mt-3">Reset Filters</button>
    </div>
</div>

<script>
let currentStatus = '';

function setQuickStatus(status) {
    currentStatus = status;
    document.querySelectorAll('.filter-pill').forEach(pill => {
        if (pill.getAttribute('data-pill-status') === status) {
            pill.classList.add('active');
        } else {
            pill.classList.remove('active');
        }
    });
    filterTable();
}

function filterTable() {
    const search = document.getElementById('search-input').value.trim().toLowerCase();
    const typeVal = document.getElementById('type-filter').value.toLowerCase();
    const rows = document.querySelectorAll('#supplierTable tbody tr');
    let visible = 0;

    rows.forEach(row => {
        const email = row.dataset.email || '';
        const bname = row.dataset.bname || '';
        const bregid = row.dataset.bregid || '';
        const btype = row.dataset.btype || '';
        const status = row.dataset.status || '';

        const matchSearch = !search || email.includes(search) || bname.includes(search) || bregid.includes(search);
        const matchType = !typeVal || btype.includes(typeVal);
        const matchStatus = !currentStatus || status === currentStatus;

        if (matchSearch && matchType && matchStatus) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    const resultCountEl = document.getElementById('result-count');
    if (resultCountEl) {
        resultCountEl.textContent = `Showing ${visible} of ${rows.length} suppliers`;
    }

    const emptyEl = document.getElementById('empty-state');
    if (emptyEl) {
        emptyEl.classList.toggle('hidden', visible > 0);
    }
}

function clearFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('type-filter').value = '';
    setQuickStatus('');
}

document.getElementById('search-input').addEventListener('input', filterTable);
document.getElementById('type-filter').addEventListener('change', filterTable);

filterTable();
</script>

<?php
include '../include/footer.php';
?>