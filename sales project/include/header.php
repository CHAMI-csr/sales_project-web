<?php
session_start();

?>
<?php
include_once '../include/connection.php';
if (isset($_SESSION['type']) && $_SESSION['type'] == 'supplier') {
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM businessregistration WHERE user_id='" . $user_id . "'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $approve = $row['approve'];
      $_SESSION['approve'] = $approve;

    }

  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TecHub - Mobile Phone Shop</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css" />

<body class="bg-gray-50 min-h-screen">
  <!-- Header Navigation -->
  <header class="bg-white shadow-lg border-b-2 border-blue-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="../pages/home.php">
            <h1
              class="text-2xl font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
              TecHub
            </h1>
            <p class="text-xs text-gray-500">Mobile Phone Shop</p>
        </div></a>

        <!-- Navigation -->
        <nav class="hidden md:flex space-x-6">
          <a href="../pages/phones.php"
            class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border border-gray-300 hover:border-blue-600 hover:bg-blue-50">Phones</a>
          <a href="../pages/items.php"
            class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border border-gray-300 hover:border-blue-600 hover:bg-blue-50">Accessories</a>
          <a href="../pages/contact.php"
            class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border border-gray-300 hover:border-blue-600 hover:bg-blue-50">Contact</a>
        </nav>

        <!-- Login Button -->
        <?php
        if (isset($_SESSION['username'])) {
          ?>
          <div class="flex items-center space-x-4">






            <!-- Dropdown -->
            <div class="relative">
              <button
                class="block w-[45px] h-[45px] rounded-full overflow-hidden focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform duration-200 transform hover:scale-105">
                <img class="w-full h-full object-cover" src="../images/profile_images/<?php echo $_SESSION['image']; ?>"
                  alt="Profile photo">
              </button>

              <!-- Dropdown Menu -->

              <div
                class="dropdown absolute bg-white mt-2 rounded-xl shadow-xl border border-gray-100 py-1 overflow-hidden">
                <p class="px-4 py-2 text-blue-700 font-semibold text-sm bg-blue-50 rounded-lg mb-1">
                  Hello!<br>
                  <span class="font-bold"><?php echo ($_SESSION['username']); ?></span>
                </p>
                <span class="block px-4 py-1 text-xs text-gray-500 rounded bg-gray-100 mt-1">
                  <?php echo ($_SESSION['email']); ?>
                </span>
                <div class="border-t border-gray-100 my-1"></div>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Your Profile
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Settings
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <a href="../pages/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Sign out
                </a>
              </div>
            </div>
            <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'supplier') { ?>
              <?php if (isset($_SESSION['approve']) && $_SESSION['approve'] == '1') { ?>
                <a href="../pages/Supplier_Dashboard.php"
                  class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border border-gray-300 hover:border-blue-600 hover:bg-blue-50">
                  Supplier Dashboard</a>
              <?php } else { ?>
                <a href="../pages/Business_reg.php"
                  class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border border-gray-300 hover:border-blue-600 hover:bg-blue-50">
                  Business Register</a>
              <?php } ?>
            <?php } ?>
            <button id="cartBtn"
              class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-full shadow-md hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
              🛒 Cart
            </button>


          </div>
        </div>
      <?php } else { ?>

        <div class="flex items-center space-x-4">
          <div class="hidden md:flex items-center text-sm text-gray-600">
          </div>
          <button id="openLoginModal"
            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
            Login
          </button>
        <?php } ?>
      </div>
    </div>
  </header>


  <!-- Login Modal Overlay -->
  <div id="login-modal-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden transition-opacity duration-300 opacity-0">

    <!-- Modal Container -->
    <div
      class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl w-11/12 max-w-lg mx-auto transform scale-95 transition-transform duration-300">

      <!-- Modal Header -->
      <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold">Log in or sign up in seconds</h2>
        <button id="closeLoginModal" class="text-gray-500 hover:text-gray-900 transition-colors duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <p class="text-sm text-gray-500">
        Use your email or another service to continue with TecHub. It's free!
      </p>

      <!-- Login Form -->
      <form class="login-modal-overlay" action="../lib/login-backend.php" method="post">
        <div class="flex-column">
          <label>Email </label>
        </div>
        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
            <g data-name="Layer 3" id="Layer_3">
              <path
                d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
              </path>
            </g>
          </svg>
          <input placeholder="Enter your Email" name="email" class="input" type="text">
        </div>

        <div class="flex-column">
          <label>Password </label>
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
          <input placeholder="Enter your Password" name="password" class="input" type="password">
        </div>

        <div class="flex-row">
          <div>
            <input type="radio">
            <label>Remember me </label>
          </div>
          <span class="span">Forgot password?</span>
        </div>
        <button class="button-submit" name="login">Sign In</button>
        <p class="p">Don't have an account? <span class="span">Sign Up</span>

        </p>
        <p class="p line">Or With</p>

        <div class="flex-row">
          <button class="btn google">
            <svg xml:space="preserve" style="enable-background:new 0 0 512 512;" viewBox="0 0 512 512" y="0px" x="0px"
              xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" width="20"
              version="1.1">
              <path d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
                c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
                C103.821,274.792,107.225,292.797,113.47,309.408z" style="fill:#FBBB00;"></path>
              <path d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
                c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
                c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"
                style="fill:#518EF8;"></path>
              <path d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
                  c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
                  c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z" style="fill:#28B446;"></path>
              <path d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
                c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
                C318.115,0,375.068,22.126,419.404,58.936z" style="fill:#F14336;"></path>

            </svg>

            Google

          </button><button class="btn apple">
            <svg xml:space="preserve" style="enable-background:new 0 0 22.773 22.773;" viewBox="0 0 22.773 22.773"
              y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Capa_1"
              width="20" height="20" version="1.1">
              <g>
                <g>
                  <path
                    d="M15.769,0c0.053,0,0.106,0,0.162,0c0.13,1.606-0.483,2.806-1.228,3.675c-0.731,0.863-1.732,1.7-3.351,1.573 c-0.108-1.583,0.506-2.694,1.25-3.561C13.292,0.879,14.557,0.16,15.769,0z">
                  </path>
                  <path
                    d="M20.67,16.716c0,0.016,0,0.03,0,0.045c-0.455,1.378-1.104,2.559-1.896,3.655c-0.723,0.995-1.609,2.334-3.191,2.334 c-1.367,0-2.275-0.879-3.676-0.903c-1.482-0.024-2.297,0.735-3.652,0.926c-0.155,0-0.31,0-0.462,0 c-0.995-0.144-1.798-0.932-2.383-1.642c-1.725-2.098-3.058-4.808-3.306-8.276c0-0.34,0-0.679,0-1.019 c0.105-2.482,1.311-4.5,2.914-5.478c0.846-0.52,2.009-0.963,3.304-0.765c0.555,0.086,1.122,0.276,1.619,0.464 c0.471,0.181,1.06,0.502,1.618,0.485c0.378-0.011,0.754-0.208,1.135-0.347c1.116-0.403,2.21-0.865,3.652-0.648 c1.733,0.262,2.963,1.032,3.723,2.22c-1.466,0.933-2.625,2.339-2.427,4.74C17.818,14.688,19.086,15.964,20.67,16.716z">
                  </path>
                </g>
              </g>
            </svg>

            Apple

          </button>
        </div>
      </form>

      <div class="text-xs text-gray-400 mt-4">
        By continuing, you agree to TecHub's
        <a href="#" class="underline text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">Terms
          of
          Use</a>.
        Read our
        <a href="#"
          class="underline text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">Privacy
          Policy</a>.
      </div>

      <hr class="my-4 border-gray-200">

    </div>

  </div>
  <div id="signup-modal-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden transition-opacity duration-300 opacity-0 overflow-auto">
    <!-- Modal Container -->
    <div
      class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl w-11/12 max-w-lg mx-auto transform scale-95 transition-transform duration-300 overflow-y-auto max-h-screen">
      <!-- Modal Header -->
      <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold">Create a new account</h2>
        <button id="closeSignupModal" class="text-gray-500 hover:text-gray-900 transition-colors duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <p class="text-sm text-gray-500">
        Create your TecHub account to start shopping. It's free!
      </p>

      <!-- Register Form with matching login form styling -->
      <form action="../lib/reg_backend.php" class="login-modal-overlay" method="post" enctype="multipart/form-data">
        <br>
        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20" fill="currentColor">
            <path
              d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          <input placeholder="Enter your first name" name="first_name" class="input" type="text">
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20" fill="currentColor">
            <path
              d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          <input placeholder="Enter your last name" name="last_name" class="input" type="text">
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20" fill="currentColor">
            <path
              d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.1 3.89 23 5 23H19C20.1 23 21 22.1 21 21V9M19 9H14V4H19V9Z" />
          </svg>
          <input placeholder="Choose a username" name="username" class="input" type="text">
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
            <g data-name="Layer 3" id="Layer_3">
              <path
                d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
              </path>
            </g>
          </svg>
          <input placeholder="Enter your email" name="email" class="input" type="email">
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
            <path
              d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
            </path>
            <path
              d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
            </path>
          </svg>
          <input placeholder="Create a password" name="password" class="input" type="password">
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
            <path
              d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
            </path>
            <path
              d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
            </path>
          </svg>
          <input placeholder="Confirm your password" name="confirm_password" class="input" type="password">
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
            </path>
          </svg>
          <input type="file" id="profileImageInput" name="profile_image" accept="image/*" class="input"
            style="display:none;">
          <label for="profileImageInput" class="input flex items-center justify-between cursor-pointer">
            <span id="fileName" class="truncate text-gray-500">Select profile image</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 ml-2" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </label>
          <script>
            document.getElementById('profileImageInput').addEventListener('change', function (e) {
              var fileName = e.target.files.length ? e.target.files[0].name : 'Select profile image';
              document.getElementById('fileName').textContent = fileName;
            });
          </script>
        </div>
        <br>

        <div class="inputForm">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20" fill="currentColor">
            <path
              d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.54 8H17c-.8 0-1.54.37-2.01 1l-2.41 3.19c-.32.42-.26 1.02.15 1.36l2.5 2.1L16 18v4h4z" />
          </svg>
          <div class="flex flex-col space-y-2">
            <div class="flex space-x-4">
              <label class="flex items-center">
                <input type="radio" name="account_type" value="customer" required class="form-radio text-blue-600">
                <span class="ml-2">Customer</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="account_type" value="supplier" required class="form-radio text-blue-600">
                <span class="ml-2">Supplier</span>
              </label>
            </div>
          </div>
        </div>

        <div class="flex-row">
          <div>
            <input type="checkbox" required>
            <label>I agree to Terms & Conditions</label>
          </div>
        </div>

        <button name="submit" class="button-submit">Sign Up</button>
        <p class="p">Already have an account? <span class="span" id="openLoginFromSignup">Log In</span></p>
      </form>

      <div class="text-xs text-gray-400 mt-4">
        By continuing, you agree to TecHub's
        <a href="#" class="underline text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">Terms
          of Use</a>.
        Read our
        <a href="#"
          class="underline text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">Privacy
          Policy</a>.
      </div>

      <hr class="my-4 border-gray-200">
    </div>
  </div>
  </div>
  <!-- Side Cart -->
  <div id="cartDropdown"
    class="cart-dropdown hidden absolute top-16 right-5 w-80 bg-white rounded-lg shadow-xl p-4 z-50">
    <div class="flex justify-between items-center mb-2 font-bold">
      <span>✅ Added to Bag</span>
      <button
        class="close-btn text-xl font-bold p-1 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400"
        id="closeCart">×</button>
    </div>
    <?php
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $query = "SELECT * FROM ordertable WHERE user_id='$user_id'";
      $result = mysqli_query($con, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        $pname = $row['pname'];
        $categories = $row['categories'];
        $discription = $row['discription'];
        $qty = $row['qty'];
        $price = $row['price'];
        $pid = $row['pid'];
        $order_id = $row['orderid'];

        $query2 = "SELECT * FROM production WHERE pid='$pid'";
        $img_result = mysqli_query($con, $query2);
        $image = '';
        if (mysqli_num_rows($img_result) > 0) {
          $img_row = mysqli_fetch_assoc($img_result);
          $image = $img_row['image'];
        }







        ?>

        <div class="flex gap-2 mb-4">
          <img src="../images/items/<?= $image ?>" alt="Product" class="w-16 h-16 object-cover rounded-md">
          <div class="flex flex-col">
            <h4 class="m-0 text-sm font-semibold"><?= $pname ?></h4>
            <p class="m-0 text-xs text-gray-500 mt-0.5"><?= $categories ?></p>
            <p class="m-0 text-xs text-gray-500 mt-0.5"><?= $discription ?></p>
            <strong class="text-sm font-bold text-gray-900 mt-0">Qty-<?= $qty ?></strong>
            <strong class="text-sm font-bold text-gray-900 mt-1">LKR.<?= $price ?></strong>
            <hr class="my-2 border-black-200">
            <a href="../lib/cart_delete.php?order_id=<?= $order_id ?>&pid=<?= $pid ?>">🗑️</a>
          </div>
        </div>
        <hr class="my-2 border-black-200">
      <?php }
    } ?>

    <div class="flex justify-between gap-2">
      <?php
      $cart_count = 0;
      if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $count_query = "SELECT COUNT(*) as cnt FROM ordertable WHERE user_id='$user_id'";
        $count_result = mysqli_query($con, $count_query);
        if ($count_result) {
          $count_row = mysqli_fetch_assoc($count_result);
          $cart_count = $count_row['cnt'];
          $_SESSION['cart_count'] = $cart_count;
        }
      }
      ?>
      <a href="../pages/Bag.php"></a>
      <p class="flex-1 py-2 px-4 rounded-full text-sm font-semibold">
        Total items🛒 (<?php echo $cart_count; ?>)
      </p>
      <a href="../payHere/">
        <button
          class="flex-1 py-2 px-4 rounded-full text-sm font-semibold bg-black text-white hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-700">Checkout</button>
      </a>

    </div>
  </div>


  <script src="../js/loging.js"></script>
  <script>
    function toggleBodyScroll(isModalOpen) {
      document.body.style.overflow = isModalOpen ? 'hidden' : '';
    }
    document.getElementById('openLoginModal').addEventListener('click', function () {
      toggleBodyScroll(true);
    });
    document.getElementById('closeLoginModal').addEventListener('click', function () {
      toggleBodyScroll(false);
    });
    document.getElementById('openLoginFromSignup').addEventListener('click', function () {
      toggleBodyScroll(true);
    });
    document.getElementById('closeSignupModal').addEventListener('click', function () {
      toggleBodyScroll(false);
    });
  </script>
  <script>
    const cartBtn = document.getElementById('cartBtn');
    const cartDropdown = document.getElementById('cartDropdown');
    const closeCart = document.getElementById('closeCart');

    // Show mini cart
    cartBtn.addEventListener('click', () => {
      cartDropdown.classList.remove('hidden');
    });

    // Close mini cart
    closeCart.addEventListener('click', () => {
      cartDropdown.classList.add('hidden');
    });

    // Optional: click outside to close
    document.addEventListener('click', (e) => {
      if (!cartDropdown.contains(e.target) && e.target !== cartBtn) {
        cartDropdown.classList.add('hidden');
      }
    });
  </script>
  <?php


  if (isset($_GET['error'])) {
    switch ($_GET['error']) {
      case 'First_Name':
        $error_message = 'First name is required!';
        break;
      case 'Last_Name':
        $error_message = 'Last name is required!';
        break;
      case 'User_Name':
        $error_message = 'Username is required!';
        break;
      case 'Email':
        $error_message = 'Email is required!';
        break;
      case 'password_mismatch':
        $error_message = 'Passwords do not match!';
        break;
      case 'Password':
        $error_message = 'Password is required!';
        break;
      case 'large_file':
        $error_message = 'Image is too large! Maximum size allowed is 2MB.';
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
      case 'image_size';
        $error_message = 'Image is too large! Maximum size allowed is 2MB.';
        break;

    }
    $alert_type = 'error';
  } elseif (isset($_GET['success'])) {
    $error_message = 'Registration successful!';
    $alert_type = 'success';
  }
  ?>
  <div id="alert-container"></div>
  <link rel="stylesheet" href="../css/alert.css">

  <script>
    function showAlert(type, title, message) {
      const alertContainer = document.getElementById('alert-container');
      const alertElement = document.createElement('div');
      alertElement.className = `alert alert-${type}`;

      let iconSvg;
      switch (type) {
        case 'error':
          iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>`;
          break;
        case 'success':
          iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>`;
          break;
        case 'info':
        default:
          iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z"/></svg>`;
          break;
      }

      alertElement.innerHTML = `
            ${iconSvg}
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <div class="alert-message">${message}</div>
            </div>
        `;
      alertContainer.appendChild(alertElement);

      setTimeout(() => {
        alertElement.classList.add('show');
      }, 10);

      setTimeout(() => {
        alertElement.classList.remove('show');
        setTimeout(() => {
          alertElement.remove();
        }, 500);
      }, 5000);
    }

    <?php if ($error_message): ?>
      showAlert('<?php echo $alert_type; ?>', '<?php echo ucfirst($alert_type); ?>', '<?php echo $error_message; ?>');
    <?php endif; ?>
  </script>
  <script>
    window.onload = function () {

      if (window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        url.searchParams.delete('success');
        window.history.replaceState({ path: url.href }, '', url.href);
      }
    };
  </script>

  <div class="container">