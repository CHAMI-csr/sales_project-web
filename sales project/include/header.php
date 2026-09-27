<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/connection.php';

// Calculate live cart items count
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $current_uid = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $cnt_query = "SELECT COUNT(*) as cnt FROM ordertable WHERE user_id='$current_uid'";
    $cnt_res = mysqli_query($con, $cnt_query);
    if ($cnt_res && $cnt_row = mysqli_fetch_assoc($cnt_res)) {
        $cart_count = (int)$cnt_row['cnt'];
        $_SESSION['cart_count'] = $cart_count;
    }
}

// Supplier approval check
if (isset($_SESSION['type']) && $_SESSION['type'] === 'supplier' && isset($_SESSION['user_id'])) {
    $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $query = "SELECT * FROM businessregistration WHERE user_id='$user_id'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['approve'] = $row['approve'];
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TecHub - Mobile Phone Shop</title>
  
  <!-- Tailwind CSS & Bootstrap -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <!-- Site Stylesheets -->
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/alert.css" />
  <!-- Global JS config injected by PHP -->
  <script>
    window.CART_AJAX_URL = '<?= "http://" . $_SERVER["HTTP_HOST"] . "/lib/cart_ajax.php" ?>';
  </script>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col font-sans text-slate-800 antialiased">

  <!-- Top Announcement Bar -->
  <div class="bg-slate-900 text-slate-300 text-[11px] py-1.5 px-4 border-b border-slate-800">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1">
      <div class="flex items-center gap-4">
        <span class="flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          Hotline: <strong class="text-white">+94 77 123 4567</strong>
        </span>
        <span class="hidden md:inline-flex items-center gap-1.5 text-slate-400">
          <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Main Street, Galle
        </span>
      </div>
      <div class="flex items-center gap-4 text-slate-300">
        <span class="flex items-center gap-1">
          <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
          100% Genuine with Warranty
        </span>
        <span class="hidden sm:inline">|</span>
        <span class="hidden sm:inline">Islandwide Fast Delivery</span>
      </div>
    </div>
  </div>
  
  <!-- Header Navigation -->
  <header class="bg-white/95 backdrop-blur-md shadow-xs border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="../pages/home.php" class="flex items-center gap-2 group">
            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-lg shadow-sm group-hover:bg-blue-700 transition-colors">
              T
            </div>
            <div>
              <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight">
                Tec<span class="text-blue-600">Hub</span>
              </span>
              <span class="text-[10px] font-semibold text-slate-400 tracking-wider uppercase block -mt-0.5">Mobile Store · Galle</span>
            </div>
          </a>
        </div>

        <!-- Navigation -->
        <nav class="hidden md:flex items-center space-x-1">
          <a href="../pages/home.php"
            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-150 <?= ($current_page === 'home.php') ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
            Home
          </a>
          <a href="../pages/phones.php"
            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-150 <?= ($current_page === 'phones.php') ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
            Smartphones
          </a>
          <a href="../pages/headphones.php"
            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-150 <?= ($current_page === 'headphones.php') ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
            Headphones
          </a>
          <a href="../pages/backcovers.php"
            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-150 <?= ($current_page === 'backcovers.php') ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
            Accessories
          </a>
          <a href="../pages/contact.php"
            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-150 <?= ($current_page === 'contact.php') ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
            Contact
          </a>
        </nav>

        <!-- Right Side: Login or Profile & Cart -->
        <div class="flex items-center space-x-2.5">
          
          <?php if (isset($_SESSION['username'])) { ?>
            <!-- User Profile Dropdown -->
            <div class="relative">
              <button id="userDropdownBtn"
                class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-100 focus:outline-none transition-colors border border-slate-200">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center font-bold text-xs text-blue-600">
                  <?php
                  $avatar_file = !empty($_SESSION['image']) ? '../images/profile_images/' . rawurlencode($_SESSION['image']) : '';
                  if ($avatar_file && file_exists(__DIR__ . '/../images/profile_images/' . $_SESSION['image'])) { ?>
                    <img class="w-full h-full object-cover" src="<?= $avatar_file ?>" alt="Profile photo">
                  <?php } else { ?>
                    <span><?= strtoupper(substr($_SESSION['username'], 0, 2)) ?></span>
                  <?php } ?>
                </div>
                <span class="hidden sm:inline-block text-xs font-semibold text-slate-700 pr-1">
                  <?= htmlspecialchars($_SESSION['username']) ?>
                </span>
                <svg class="w-3.5 h-3.5 text-slate-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>

              <!-- Dropdown Menu -->
              <div id="userDropdown"
                class="dropdown hidden absolute right-0 mt-2 z-50 min-w-[220px] rounded-2xl overflow-hidden shadow-2xl border border-slate-700/60"
                style="background:#0f172a;">

                <!-- Profile Header -->
                <div class="px-4 py-3.5" style="background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%); border-bottom:1px solid rgba(255,255,255,0.07);">
                  <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-1">Signed in as</p>
                  <p class="font-bold text-white text-sm truncate leading-tight"><?= htmlspecialchars($_SESSION['username']) ?></p>
                  <p class="text-[11px] text-slate-400 truncate mt-0.5"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
                </div>

                <!-- Menu Items -->
                <div class="py-1.5 px-1.5 space-y-0.5">
                  <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'supplier') { ?>
                    <?php if (isset($_SESSION['approve']) && $_SESSION['approve'] == '1') { ?>
                      <a href="../pages/Supplier_Dashboard.php"
                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition-all group">
                        <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Supplier Dashboard
                      </a>
                    <?php } else { ?>
                      <a href="../pages/Business_reg.php"
                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition-all group">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Register Business
                      </a>
                    <?php } ?>
                  <?php } ?>

                  <a href="../PayHere/"
                    class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition-all group">
                    <svg class="w-3.5 h-3.5 text-blue-400 group-hover:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    My Orders / Checkout
                  </a>
                </div>

                <!-- Sign Out -->
                <div class="px-1.5 pb-1.5" style="border-top:1px solid rgba(255,255,255,0.07);">
                  <a href="../pages/logout.php"
                    class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all mt-1 group">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign out
                  </a>
                </div>
              </div>
            </div>

            <!-- Supplier Dashboard Quick Button -->
            <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'supplier') { ?>
              <?php if (isset($_SESSION['approve']) && $_SESSION['approve'] == '1') { ?>
                <a href="../pages/Supplier_Dashboard.php"
                  class="hidden sm:inline-block text-slate-700 hover:text-blue-600 px-3 py-1.5 rounded-xl text-xs font-semibold border border-slate-200 hover:border-blue-600 hover:bg-blue-50 transition-all">
                  Dashboard
                </a>
              <?php } else { ?>
                <a href="../pages/Business_reg.php"
                  class="hidden sm:inline-block text-slate-700 hover:text-blue-600 px-3 py-1.5 rounded-xl text-xs font-semibold border border-slate-200 hover:border-blue-600 hover:bg-blue-50 transition-all">
                  Register Business
                </a>
              <?php } ?>
            <?php } ?>

            <!-- Cart Trigger Button -->
            <button id="cartBtn"
              class="bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-3.5 rounded-xl shadow-xs transition-all duration-150 focus:outline-none flex items-center gap-1.5 text-xs">
              <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
              <span>Cart</span>
              <?php if ($cart_count > 0) { ?>
                <span class="bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold ml-0.5">
                  <?= $cart_count ?>
                </span>
              <?php } ?>
            </button>

          <?php } else { ?>
            <!-- Login Button -->
            <button id="openLoginModal"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-5 py-2 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
              <span>Sign In</span>
            </button>
          <?php } ?>

          <!-- Mobile Hamburger -->
          <button id="mobileNavToggle" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>

        </div>
      </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobileNavMenu" class="hidden md:hidden border-t border-gray-200 bg-white px-4 py-3 space-y-2">
      <a href="../pages/home.php" class="block px-3 py-2 rounded-lg text-sm font-medium <?= ($current_page === 'home.php') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' ?>">Home</a>
      <a href="../pages/phones.php" class="block px-3 py-2 rounded-lg text-sm font-medium <?= ($current_page === 'phones.php') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' ?>">Phones</a>
      <a href="../pages/headphones.php" class="block px-3 py-2 rounded-lg text-sm font-medium <?= ($current_page === 'headphones.php') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' ?>">Headphones</a>
      <a href="../pages/backcovers.php" class="block px-3 py-2 rounded-lg text-sm font-medium <?= ($current_page === 'backcovers.php') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' ?>">Accessories</a>
      <a href="../pages/contact.php" class="block px-3 py-2 rounded-lg text-sm font-medium <?= ($current_page === 'contact.php') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' ?>">Contact</a>
      
      <div class="border-t border-gray-100 pt-2 mt-2">
        <?php if (!isset($_SESSION['username'])) { ?>
          <button onclick="openLoginModalDirect('signin');"
            class="w-full text-left px-3 py-2 rounded-lg text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
            Sign In / Register
          </button>
        <?php } else { ?>
          <a href="../pages/logout.php" class="block px-3 py-2 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50">Sign Out</a>
        <?php } ?>
      </div>
    </div>
  </header>

  <!-- Side Cart Dropdown -->
  <div id="cartDropdown"
    class="cart-dropdown hidden fixed top-[72px] right-4 w-[340px] sm:w-[380px] bg-white rounded-2xl shadow-2xl z-50 overflow-hidden border border-gray-100">

    <!-- Cart Header -->
    <div class="flex justify-between items-center px-5 py-3.5 border-b border-gray-100">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <span class="text-sm font-bold text-gray-900">My Bag</span>
        <span id="cartBadgeHeader" class="bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold hidden"></span>
      </div>
      <button id="closeCart" class="close-btn w-7 h-7 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-all focus:outline-none">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Cart Items: rendered by JS -->
    <div id="cartItems" class="max-h-[280px] overflow-y-auto px-3 py-2 space-y-2" style="scrollbar-width:thin;">
      <div class="py-10 text-center text-gray-300">
        <svg class="w-6 h-6 mx-auto animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
      </div>
    </div>

    <!-- Footer -->
    <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50">
      <div class="flex items-center justify-between mb-3">
        <span id="cartFooterCount" class="text-xs text-gray-500 font-medium"></span>
      </div>
      <a href="<?= (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../../PayHere/' : '../PayHere/' ?>"
         class="flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
        Proceed to Checkout
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>


  <!-- Login Modal Overlay -->
  <div id="login-modal-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden transition-opacity duration-300 opacity-0 p-4">

    <!-- Modal Container -->
    <div
      class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl w-full max-w-md mx-auto transform scale-95 transition-transform duration-300">

      <!-- Modal Header -->
      <div class="flex justify-between items-start mb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Log in to TecHub</h2>
          <p class="text-xs text-gray-500 mt-1">
            Use your email or username to continue. It's free!
          </p>
        </div>
        <button id="closeLoginModal" class="text-gray-400 hover:text-gray-900 transition-colors p-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Login Form -->
      <form class="login-modal-overlay space-y-3" action="../lib/login-backend.php" method="post">
        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

        <div class="flex-column">
          <label class="text-xs font-semibold text-gray-700">Email or Username</label>
        </div>
        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
            <g data-name="Layer 3" id="Layer_3">
              <path
                d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
              </path>
            </g>
          </svg>
          <input placeholder="Enter your Email or Username" name="email" class="input" type="text" required>
        </div>

        <div class="flex-column">
          <label class="text-xs font-semibold text-gray-700">Password</label>
        </div>
        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
            <path
              d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
            </path>
            <path
              d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
            </path>
          </svg>
          <input placeholder="Enter your Password" name="password" class="input" type="password" required>
        </div>

        <div class="flex-row">
          <div class="flex items-center gap-1.5">
            <input type="checkbox" id="rememberCheck" class="rounded text-blue-600">
            <label for="rememberCheck" class="text-xs text-gray-600 cursor-pointer">Remember me</label>
          </div>
          <span class="span text-xs">Forgot password?</span>
        </div>

        <button class="button-submit" name="login" type="submit">Sign In</button>
        
        <p class="p text-xs">Don't have an account? <span class="span font-bold text-blue-600 cursor-pointer" id="openSignupFromLogin">Sign Up</span></p>
        
        <p class="p line text-xs text-gray-400">Or With</p>

        <div class="flex gap-2">
          <button type="button" class="btn google flex items-center justify-center gap-2 border border-gray-200 rounded-lg py-2 flex-1 text-xs font-medium hover:bg-gray-50">
            <svg viewBox="0 0 512 512" width="16" height="16">
              <path d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456C103.821,274.792,107.225,292.797,113.47,309.408z" fill="#FBBB00"></path>
              <path d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z" fill="#518EF8"></path>
              <path d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z" fill="#28B446"></path>
              <path d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0C318.115,0,375.068,22.126,419.404,58.936z" fill="#F14336"></path>
            </svg>
            Google
          </button>
          <button type="button" class="btn apple flex items-center justify-center gap-2 border border-gray-200 rounded-lg py-2 flex-1 text-xs font-medium hover:bg-gray-50">
            <svg viewBox="0 0 22.773 22.773" width="16" height="16">
              <path d="M15.769,0c0.053,0,0.106,0,0.162,0c0.13,1.606-0.483,2.806-1.228,3.675c-0.731,0.863-1.732,1.7-3.351,1.573 c-0.108-1.583,0.506-2.694,1.25-3.561C13.292,0.879,14.557,0.16,15.769,0z" fill="#000"></path>
              <path d="M20.67,16.716c0,0.016,0,0.03,0,0.045c-0.455,1.378-1.104,2.559-1.896,3.655c-0.723,0.995-1.609,2.334-3.191,2.334 c-1.367,0-2.275-0.879-3.676-0.903c-1.482-0.024-2.297,0.735-3.652,0.926c-0.155,0-0.31,0-0.462,0 c-0.995-0.144-1.798-0.932-2.383-1.642c-1.725-2.098-3.058-4.808-3.306-8.276c0-0.34,0-0.679,0-1.019 c0.105-2.482,1.311-4.5,2.914-5.478c0.846-0.52,2.009-0.963,3.304-0.765c0.555,0.086,1.122,0.276,1.619,0.464 c0.471,0.181,1.06,0.502,1.618,0.485c0.378-0.011,0.754-0.208,1.135-0.347c1.116-0.403,2.21-0.865,3.652-0.648 c1.733,0.262,2.963,1.032,3.723,2.22c-1.466,0.933-2.625,2.339-2.427,4.74C17.818,14.688,19.086,15.964,20.67,16.716z" fill="#000"></path>
            </svg>
            Apple
          </button>
        </div>
      </form>

      <div class="text-xs text-gray-400 mt-4 text-center">
        By continuing, you agree to TecHub's
        <a href="#" class="underline text-blue-600">Terms of Use</a> &
        <a href="#" class="underline text-blue-600">Privacy Policy</a>.
      </div>

    </div>
  </div>

  <!-- Sign Up Modal Overlay -->
  <div id="signup-modal-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden transition-opacity duration-300 opacity-0 overflow-y-auto p-4">
    
    <!-- Modal Container -->
    <div
      class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl w-full max-w-md mx-auto transform scale-95 transition-transform duration-300 my-8">
      
      <!-- Modal Header -->
      <div class="flex justify-between items-start mb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Create a new account</h2>
          <p class="text-xs text-gray-500 mt-1">
            Create your TecHub account to start shopping. It's free!
          </p>
        </div>
        <button id="closeSignupModal" class="text-gray-400 hover:text-gray-900 transition-colors p-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Register Form -->
      <form action="../lib/reg_backend.php" class="login-modal-overlay space-y-3" method="post" enctype="multipart/form-data">
        
        <div class="grid grid-cols-2 gap-2">
          <div class="inputForm">
            <input placeholder="First name" name="first_name" class="input" type="text" required>
          </div>
          <div class="inputForm">
            <input placeholder="Last name" name="last_name" class="input" type="text" required>
          </div>
        </div>

        <div class="inputForm">
          <input placeholder="Choose username" name="username" class="input" type="text" required>
        </div>

        <div class="inputForm">
          <input placeholder="Enter your email" name="email" class="input" type="email" required>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="inputForm">
            <input placeholder="Password" name="password" class="input" type="password" required>
          </div>
          <div class="inputForm">
            <input placeholder="Confirm" name="confirm_password" class="input" type="password" required>
          </div>
        </div>

        <!-- Profile Image Picker -->
        <div class="inputForm">
          <input type="file" id="profileImageInput" name="profile_image" accept="image/*" class="hidden" required>
          <label for="profileImageInput" class="w-full flex items-center justify-between cursor-pointer px-1">
            <span id="fileName" class="truncate text-xs text-gray-500">Select profile image</span>
            <svg class="h-4 w-4 text-gray-400 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          </label>
        </div>

        <!-- Account Type -->
        <div class="flex items-center justify-around py-2 bg-gray-50 rounded-xl border border-gray-200">
          <label class="flex items-center text-xs font-semibold text-gray-700 cursor-pointer">
            <input type="radio" name="account_type" value="customer" checked class="form-radio text-blue-600 mr-2">
            Customer
          </label>
          <label class="flex items-center text-xs font-semibold text-gray-700 cursor-pointer">
            <input type="radio" name="account_type" value="supplier" class="form-radio text-blue-600 mr-2">
            Supplier
          </label>
        </div>

        <div class="flex items-center">
          <input type="checkbox" id="agreeTerms" required class="rounded text-blue-600 mr-2">
          <label for="agreeTerms" class="text-xs text-gray-500">I agree to Terms & Conditions</label>
        </div>

        <button name="submit" type="submit" class="button-submit">Sign Up</button>
        <p class="p text-xs">Already have an account? <span class="span font-bold text-blue-600 cursor-pointer" id="openLoginFromSignup">Log In</span></p>
      </form>
    </div>
  </div>

  <!-- Alert Container -->
  <div id="alert-container"></div>

  <?php
  $error_message = '';
  $alert_type = 'info';

  if (isset($_GET['error'])) {
      $alert_type = 'error';
      switch ($_GET['error']) {
          case 'First_Name':
              $error_message = 'First name is required!';
              break;
          case 'Last_Name':
              $error_message = 'Last name is required!';
              break;
          case 'User_Name':
          case 'Username':
              $error_message = 'Username is required!';
              break;
          case 'Email':
              $error_message = 'Email address is required!';
              break;
          case 'password_mismatch':
              $error_message = 'Passwords do not match!';
              break;
          case 'Password':
              $error_message = 'Password is required!';
              break;
          case 'Confirm_Password':
              $error_message = 'Please confirm your password!';
              break;
          case 'large_file':
          case 'image_size':
              $error_message = 'Image is too large! Maximum size allowed is 2MB.';
              break;
          case 'Profile_Image':
              $error_message = 'Please select a profile picture.';
              break;
          case 'User_Exist':
              $error_message = 'This username or email is already taken.';
              break;
          case 'login_error':
              $error_message = 'Invalid username or password.';
              break;
          case 'stmt_failed':
              $error_message = 'Something went wrong, please try again!';
              break;
          case 'add_error':
              $error_message = 'Could not add item to cart. Please try again.';
              break;
      }
  } elseif (isset($_GET['success'])) {
      $alert_type = 'success';
      $error_message = 'Registration successful! Please log in.';
  }
  ?>

  <main class="flex-grow">