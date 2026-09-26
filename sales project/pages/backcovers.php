<?php include '../include/header.php'; ?>
<link rel="stylesheet" href="../css/alert.css">

<div class="h-[100rem]">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 p-4">
        <?php
        $query = "SELECT * FROM production WHERE categories='Chargers' OR categories='Backcovers'";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $pname = $row['pname'];
            $price = $row['price'];
            $discription = $row['discription'];
            $image = $row['image'];
            $qty = $row['qty'];
            $categories = $row['categories'];
            $pid = $row['pid'];
            ?>
            <div
                class="product-card bg-white rounded-lg shadow-xl overflow-hidden transition-transform duration-300 ease-in-out hover:scale-105">
                <div class="relative">
                    <img class="w-full h-32 object-cover rounded-t-lg" src="../images/items/<?= $image ?>" alt="Cool Gadget"
                        onerror="this.onerror=null;this.src='https://placehold.co/400x300/e5e7eb/6b7280?text=Image+Not+Found';">
                    <?php if ($qty == 0) { ?>
                        <span
                            class="absolute top-1 left-1 bg-red-600 text-white text-[0.6rem] font-semibold px-1 py-0.5 rounded-full shadow-lg">Out
                            of Stock</span>
                    <?php } else { ?>
                        <span
                            class="absolute top-1 left-1 bg-indigo-600 text-white text-[0.6rem] font-semibold px-1 py-0.5 rounded-full shadow-lg">Available</span>
                    <?php } ?>
                </div>

                <div class="p-3">
                    <h2 class="text-base font-bold text-gray-900 mb-0.5"><?= $pname ?></h2>
                    <h3 class="text-xs font-semibold text-indigo-500 mb-1 uppercase tracking-wide"><?= $categories ?></h3>
                    <p class="text-gray-600 mb-2 text-[0.6rem]">
                        <?= $discription ?>
                    </p>

                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xl font-bold text-gray-900">LKR.<?= $price ?></span>
                        <div class="flex items-center text-yellow-400">
                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 7.41l6.572-.955L10 1l2.939 5.455 6.572.955-4.756 4.135 1.123 6.545z" />
                            </svg>
                            <span class="ml-0.5 text-gray-700 text-xs font-semibold">4.8</span>
                        </div>
                    </div>

                    <form action="../lib/cart_backend.php" method="post">
                        <div class="flex items-center justify-between mt-1 mb-3">
                            <span class="text-xs font-medium text-gray-700">Quantity</span>
                            <div class="flex items-center space-x-1">
                                <button
                                    class="decrement-btn bg-gray-200 text-gray-800 px-1.5 py-0.5 rounded-full text-xs hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                                    type="button"
                                    onclick="var qtyInput = document.getElementById('qty-<?= $row['id'] ?>'); if(qtyInput.value > 1) qtyInput.value--;">-</button>
                                <input id="qty-<?= $row['id'] ?>" name="qty" type="number"
                                    class="quantity-display text-sm font-semibold text-gray-900 w-10 text-center border rounded"
                                    value="1" min="1" max="<?= $qty ?>" style="width: 2.5rem;" />
                                <button
                                    class="increment-btn bg-gray-200 text-gray-800 px-1.5 py-0.5 rounded-full text-xs hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                                    type="button"
                                    onclick="var qtyInput = document.getElementById('qty-<?= $row['id'] ?>'); if(qtyInput.value < <?= $qty ?>) qtyInput.value++;">+</button>
                            </div>
                        </div>
                        <input type="hidden" name="pid" value="<?= $pid ?>">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <button
                                class="w-full bg-indigo-600 text-white font-semibold py-1.5 px-3 rounded-full shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-0.5 text-xs"
                                type="submit">
                                Add to Cart
                            </button>
                        <?php } else { ?>
                            <button onclick="showAlert('error', 'Failed', 'Please login And try again.')"
                                class="w-full bg-indigo-600 text-white font-semibold py-1.5 px-3 rounded-full shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-0.5 text-xs"
                                type="button">
                                Add to Cart
                            </button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <div id="alert-container"></div>
</div>


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
</script>

<?php include '../include/footer.php'; ?>