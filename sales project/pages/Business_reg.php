<?php 
include '../include/header.php'; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '../pages/home.php?error=login_error';</script>";
    exit();
}
?>

<!-- Supplier Registration Hero -->
<section class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto text-center">
    <nav class="flex items-center justify-center gap-2 text-xs text-slate-400 mb-3">
      <a href="../pages/home.php" class="hover:text-white transition-colors">Home</a>
      <span>/</span>
      <span class="text-indigo-400 font-semibold">Supplier Portal</span>
    </nav>
    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-3">
      Supplier Registration
    </h1>
    <p class="text-slate-300 text-sm max-w-xl mx-auto leading-relaxed">
      Register your business to sell mobile phones, audio devices, and accessories on TecHub.
    </p>
  </div>
</section>

<!-- Error / Success Alerts -->
<?php
$error_messages = [
    'Business_Name'       => 'Business name is required.',
    'large_file'          => 'Certificate file is too large. Maximum size is 2 MB.',
    'invalid_file'        => 'Invalid certificate file. Please upload a PDF, PNG, or JPG.',
    'invalid_image'       => 'Invalid logo file. Please upload a PNG or JPG image.',
    'Business_Number'     => 'Contact number is required.',
    'Business_Reg_ID'     => 'Business Registration Number (BRN) is required.',
    'Business_Logo'       => 'Business logo is required.',
    'Business_Type'       => 'Please select at least one product category.',
    'Business_Certificate'=> 'Business registration certificate is required.',
    'already_registered'  => 'You have already submitted a business registration.',
    'register_error'      => 'A database error occurred. Please try again later.',
];
if (isset($_GET['error']) && array_key_exists($_GET['error'], $error_messages)): ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
  <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4 text-sm font-medium shadow-sm">
    <svg class="w-5 h-5 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span><?= htmlspecialchars($error_messages[$_GET['error']]) ?></span>
  </div>
</div>
<?php endif; ?>

<!-- Registration Form Container -->

<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 pb-20">
  <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-10">
    
    <div class="border-b border-slate-100 pb-5 mb-6">
      <h2 class="text-xl font-black text-slate-900">Business Details & Verification</h2>
      <p class="text-xs text-slate-500 mt-1">Please provide accurate business registration details for expedited administrative approval.</p>
    </div>

    <form action="../lib/submit_form.php" method="POST" enctype="multipart/form-data" class="space-y-6">
      
      <!-- Section 1: Business Info -->
      <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600">Company Information</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="bname" class="block text-xs font-bold text-slate-700 mb-1.5">Business Name</label>
            <div class="techub-input-group !h-12">
              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
              <input type="text" id="bname" name="bname" maxlength="30" required placeholder="e.g. Apex Cellular Store">
            </div>
          </div>

          <div>
            <label for="date" class="block text-xs font-bold text-slate-700 mb-1.5">Registration Date</label>
            <div class="techub-input-group !h-12">
              <input type="date" id="date" name="date" required class="text-sm">
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="bnumber" class="block text-xs font-bold text-slate-700 mb-1.5">Contact Number</label>
            <div class="techub-input-group !h-12">
              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
              <input type="text" id="bnumber" name="bnumber" maxlength="15" required placeholder="0761234567">
            </div>
          </div>

          <div>
            <label for="bregid" class="block text-xs font-bold text-slate-700 mb-1.5">Business Registration No. (BRN)</label>
            <div class="techub-input-group !h-12">
              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              <input type="text" id="bregid" name="bregid" maxlength="15" required placeholder="PV123456">
            </div>
          </div>
        </div>
      </div>

      <!-- Section 2: Product Categories Offered -->
      <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-2">Categories You Provide</h3>
        <p class="text-xs text-slate-500 mb-3">Select all product types you plan to sell on TecHub:</p>
        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 hover:border-indigo-400 cursor-pointer bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 transition-colors">
            <input type="checkbox" id="phones" name="btype[]" value="Phones" class="rounded text-indigo-600 focus:ring-indigo-500">
            <span class="text-xs font-bold text-slate-800">Phones</span>
          </label>

          <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 hover:border-indigo-400 cursor-pointer bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 transition-colors">
            <input type="checkbox" id="headphones" name="btype[]" value="Headphones" class="rounded text-indigo-600 focus:ring-indigo-500">
            <span class="text-xs font-bold text-slate-800">Headphones</span>
          </label>

          <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 hover:border-indigo-400 cursor-pointer bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 transition-colors">
            <input type="checkbox" id="backcovers" name="btype[]" value="Back Covers" class="rounded text-indigo-600 focus:ring-indigo-500">
            <span class="text-xs font-bold text-slate-800">Covers</span>
          </label>

          <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 hover:border-indigo-400 cursor-pointer bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 transition-colors">
            <input type="checkbox" id="chargers" name="btype[]" value="Chargers" class="rounded text-indigo-600 focus:ring-indigo-500">
            <span class="text-xs font-bold text-slate-800">Chargers</span>
          </label>
        </div>
      </div>

      <!-- Section 3: Document Uploads -->
      <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600">Verification Documents</h3>

        <!-- Certificate Upload -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Business Registration Certificate (PDF or Image)</label>
          <div class="p-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-400 transition-colors bg-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
              </div>
              <div>
                <span id="certFileName" class="text-xs font-semibold text-slate-700">Upload BR certificate document</span>
                <p class="text-[10px] text-slate-400">PDF, PNG, or JPG up to 5MB</p>
              </div>
            </div>
            <label class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100 cursor-pointer transition-colors shadow-xs">
              Browse
              <input type="file" name="bcertificate" required class="hidden" onchange="document.getElementById('certFileName').textContent = this.files[0]?.name || 'Upload BR certificate document';">
            </label>
          </div>
        </div>

        <!-- Logo Upload -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Business Store Logo</label>
          <div class="p-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-400 transition-colors bg-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              </div>
              <div>
                <span id="logoFileName" class="text-xs font-semibold text-slate-700">Upload square business logo</span>
                <p class="text-[10px] text-slate-400">PNG or JPG, Recommended 400x400</p>
              </div>
            </div>
            <label class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100 cursor-pointer transition-colors shadow-xs">
              Browse
              <input type="file" name="blogo" required class="hidden" onchange="document.getElementById('logoFileName').textContent = this.files[0]?.name || 'Upload square business logo';">
            </label>
          </div>
        </div>

      </div>

      <div class="pt-4 border-t border-slate-100">
        <button type="submit" name="submit" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm shadow-md shadow-emerald-600/30 transition-all flex items-center justify-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Submit Application for Verification
        </button>
      </div>

    </form>
  </div>
</section>

<?php include '../include/footer.php'; ?>