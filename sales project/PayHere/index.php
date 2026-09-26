<?php
session_start();
include "../include/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-100 flex items-center justify-center p-4 min-h-screen">
    <div class="bg-white rounded-lg shadow-lg flex flex-col md:flex-row max-w-7xl w-full">
        <!-- Left Panel - Product List -->
        <div class="p-6 w-full md:w-3/5">
            <!-- Header with Breadcrumb -->
            <div class="text-sm text-gray-400 mb-6">
                <a href="#" class="text-orange-500 font-medium">TECHUB</a> >
            </div>

            <!-- Product Items -->
            <div id="product-list">
                <?php
                $totalPrice = 0;

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
                        $totalPrice += $price;

                        ?>
                        <!-- Product 1 -->
                        <div class="flex items-center p-4 border-b border-gray-200">
                            <input type="checkbox" class="product-checkbox form-checkbox text-blue-600 rounded"
                                data-price="10974" checked>
                            <div class="relative w-20 h-20 mr-4">
                                <img src="../images/items/<?= $image ?>" alt="Item"
                                    class="w-20 h-20 object-contain rounded-md mr-4">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-800"><?= $pname ?></h3>
                                <p class="text-sm text-gray-500"><?= $discription ?></p>
                            </div>
                            <div class="text-right min-w-[150px]">
                                <p class="font-semibold text-gray-800 product-price">Rs.<?= $price ?></p>
                                <div class="flex items-center justify-end mt-2 text-gray-500">
                                    <span class="mr-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg></span>
                                    <a href="../lib/cart_delete.php?order_id=<?= $order_id ?>&pid=<?= $pid ?>">
                                        <span class="mr-2 cursor-pointer remove-item"><svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg></span>
                                    </a>

                                    <div class="flex items-center">

                                        <p class="text-sm text-gray-500e">QTY-<?= $qty ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>



            </div>
        </div>
        <?php $_SESSION['total_price'] = $totalPrice;?>

        <!-- Right Panel - Order Summary -->
        <div class="p-6 w-full md:w-2/5">
            <div class="border border-gray-200 bg-white rounded-md p-6">
                <h2 class="text-xl font-semibold mb-6">Order Summary</h2>
                <div class="flex justify-between mb-3">
                    <span>Subtotal (<span id="item-count"><?=$_SESSION['cart_count']?></span> items)</span>
                    <span id="subtotal">Rs. <?= number_format($totalPrice, 2) ?></span>
                </div>
                <div class="flex justify-between mb-3">
                    <span>Shipping Fee</span>
                    <span>Rs. 500</span>
                </div>
                <div class="flex items-center mb-6">
                    <input type="text" placeholder="Enter Voucher Code"
                        class="flex-1 p-2 border border-gray-300 rounded-l-md outline-none">
                    <button class="bg-gray-200 text-gray-600 p-2 font-medium rounded-r-md">APPLY</button>
                </div>
                <div class="border-t border-gray-200 pt-6 mt-6 font-bold">
                    <span>Total</span>
                    <span id="total-amount" class="text-orange-500 text-xl font-bold">Rs.
                        <?= number_format($totalPrice, 2) ?></span>
                </div>
                <button class="bg-orange-500 text-white font-semibold p-3 rounded-md w-full cursor-pointer mt-6">PROCEED
                    TO CHECKOUT(<span id="total-items-checkout"><?= $_SESSION['cart_count'] ?></span>)</button>
            </div>

            <!-- Payment Methods -->
            <div class="border border-gray-200 bg-white rounded-md p-6 mt-6">
                <h3 class="text-lg font-medium mb-4">We Accept</h3>
                <div class="flex flex-wrap items-center">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/paypal.svg" alt="PayPal"
                        class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/visa.svg" alt="Visa"
                        class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/mastercard.svg"
                        alt="Mastercard" class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/americanexpress.svg"
                        alt="American Express" class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/discover.svg" alt="Discover"
                        class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/dinersclub.svg"
                        alt="Diners Club" class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/jcb.svg" alt="JCB"
                        class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/applepay.svg" alt="Apple Pay"
                        class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/googlepay.svg"
                        alt="Google Pay" class="h-8 mr-2 mb-2">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/klarna.svg" alt="Klarna"
                        class="h-8 mr-2 mb-2">


                </div>
            </div>

            <!-- PayHere Banner -->
            <div class="text-center mt-6">
                <div class="bg-white rounded-xl shadow-lg p-10 mx-auto w-full max-w-sm">
                    <div class="flex flex-col justify-center gap-10 place-content-center items-center">
                        <div class="items-center align-center mx-auto">
                            <button type="button" name="payBtn" onClick="paymentGateway()" id="payhere-button"
                                class="text-black hover:text-orange-300 bg-white hover:bg-blue-600 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2 mx-auto">
                                Pay with PayHere
                            </button>
                        </div>
                        <div>
                            <a href="https://www.payhere.lk" target="_blank">
                                <img src="https://www.payhere.lk/downloads/images/payhere_short_banner_dark.png"
                                    alt="PayHere" width="250" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tailwind Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

    <!-- PayHere Script -->
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <!-- Payment Process Script -->
    <script src="paymentGateway.js"></script>

</body>

</html>