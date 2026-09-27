<?php 
session_start();
define('STORE_URL', 'http://sales-project.test');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sales Management</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-[#0f172a] text-slate-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') { ?>
            <!-- Mobile Sidebar Backdrop -->
            <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

            <!-- Sidebar -->
            <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0f172a] border-r border-slate-800 flex flex-col flex-shrink-0 -translate-x-full md:translate-x-0 md:static transition-transform duration-200 ease-in-out">
                
                <!-- Brand / Logo -->
                <div class="h-16 px-6 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-white tracking-tight text-base">SalesPanel</span>
                    </div>

                    <!-- Mobile Close Button -->
                    <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white p-1 rounded-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Admin Profile Info -->
                <div class="px-5 py-4 border-b border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                            <?php if (!empty($_SESSION['image'])) { ?>
                                <img class="w-full h-full object-cover"
                                    src="../../images/profile_images/<?php echo htmlspecialchars($_SESSION['image']); ?>"
                                    alt="Profile"
                                    onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                                <span class="hidden text-xs font-semibold text-slate-300">
                                    <?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?>
                                </span>
                            <?php } else { ?>
                                <span class="text-xs font-semibold text-slate-300">
                                    <?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?>
                                </span>
                            <?php } ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-white truncate"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
                            <div class="text-xs text-slate-400">Administrator</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <div class="px-3 pb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Management</div>

                    <a href="../pages/manage.php" class="custom-link" id="nav-manage">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Suppliers</span>
                    </a>

                    <a href="../pages/prodouct.php" class="custom-link" id="nav-product">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                        <span>Products</span>
                    </a>

                    <a href="../pages/ordertable.php" class="custom-link" id="nav-orders">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Orders</span>
                    </a>

                    <a href="../pages/history.php" class="custom-link" id="nav-history">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Order History</span>
                    </a>
                </nav>

                <!-- Logout Button -->
                <div class="p-3 border-t border-slate-800">
                    <a href="logout.php" onclick="return confirm('Are you sure you want to sign out?')"
                        class="flex items-center gap-2.5 w-full py-2.5 px-3 rounded-lg text-slate-400 hover:text-red-400 hover:bg-slate-800 text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Sign Out</span>
                    </a>
                </div>
            </aside>
        <?php } ?>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#0f172a]">
            
            <!-- Top Header Bar -->
            <header class="h-16 bg-[#0f172a] border-b border-slate-800 flex items-center justify-between px-4 sm:px-6 z-20 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg bg-slate-800 border border-slate-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <div class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span>Admin</span>
                            <span class="text-slate-600">/</span>
                            <span class="text-slate-200 font-medium" id="pageBreadcrumb">Dashboard</span>
                        </div>
                    </div>
                </div>

                <!-- Top Right Shortcuts -->
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-xs text-slate-400 bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-700">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span><?php echo date('M d, Y'); ?></span>
                    </div>
                    <a href="../../index.php" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg border border-slate-700 transition">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>View Store</span>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">