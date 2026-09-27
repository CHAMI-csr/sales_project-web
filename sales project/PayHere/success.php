<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful — TecHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8 sm:p-10 max-w-lg w-full text-center space-y-6">
        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Payment Successful!</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                Thank you for your order. Your transaction has been approved by PayHere and is being prepared for dispatch.
            </p>
        </div>

        <div class="bg-emerald-50/80 border border-emerald-200/60 rounded-2xl p-4 text-xs font-semibold text-emerald-800">
            ✓ Order confirmation and delivery tracking details have been logged to your account.
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <a href="../pages/home.php" class="flex-1 py-3 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition-colors block">
                Continue Shopping
            </a>
            <a href="../PayHere/" class="py-3 px-5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors block">
                View Orders
            </a>
        </div>
    </div>
</body>
</html>