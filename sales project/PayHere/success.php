<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-lg w-full text-center">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-6">Thank you for your purchase. Your order has been placed and will be processed shortly.</p>
        <div class="bg-green-50 rounded-lg p-4 mb-6">
            <p class="text-green-700 font-semibold">Confirmation details have been sent to your email address.</p>
        </div>
        <a href="../index.php" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-md transition duration-300">
            Continue Shopping
        </a>
    </div>
</body>
</html>