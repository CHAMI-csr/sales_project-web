<?php 
include '../include/header.php'; 
?>

<!-- Contact Hero Banner -->
<section class="bg-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto text-center">
    <nav class="flex items-center justify-center gap-2 text-xs text-slate-400 mb-4">
      <a href="../pages/home.php" class="hover:text-white transition-colors">Home</a>
      <span>/</span>
      <span class="text-indigo-400 font-semibold">Contact Us</span>
    </nav>
    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mb-3">
      Contact Us
    </h1>
    <p class="text-slate-300 text-base sm:text-lg max-w-xl mx-auto">
      Do you have any problems with this? Contact us now!
    </p>
  </div>
</section>

<!-- Contact Section (Form & Info Cards) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Contact Form Column (7 cols) -->
    <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
      <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-6">Send us a Message</h2>

      <form onsubmit="event.preventDefault(); showAlert('success', 'Message Sent!', 'Thank you! We have received your message and will respond shortly.'); this.reset();" class="space-y-4">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="contact-first-name" class="block text-xs font-semibold text-slate-700 mb-1">First Name</label>
            <input type="text" id="contact-first-name" required placeholder="John"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:bg-white transition-colors">
          </div>

          <div>
            <label for="contact-last-name" class="block text-xs font-semibold text-slate-700 mb-1">Last Name</label>
            <input type="text" id="contact-last-name" required placeholder="Doe"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:bg-white transition-colors">
          </div>
        </div>

        <div>
          <label for="contact-email" class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
          <input type="email" id="contact-email" required placeholder="john@example.com"
                 class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:bg-white transition-colors">
        </div>

        <div>
          <label for="contact-phone" class="block text-xs font-semibold text-slate-700 mb-1">Phone Number</label>
          <input type="tel" id="contact-phone" placeholder="+94 (71) 123-4567"
                 class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:bg-white transition-colors">
        </div>

        <div>
          <label for="contact-message" class="block text-xs font-semibold text-slate-700 mb-1">Message</label>
          <textarea id="contact-message" rows="4" required placeholder="Tell us about your problem..."
                    class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:bg-white transition-colors"></textarea>
        </div>

        <button type="submit"
                class="w-full py-3 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white font-semibold text-sm shadow transition-all flex items-center justify-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
          Send Message
        </button>
      </form>
    </div>

    <!-- Contact Info Cards Column (5 cols) -->
    <div class="lg:col-span-5 space-y-4">
      
      <!-- Card 1: Office Address -->
      <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
          <h3 class="text-sm font-bold text-slate-900">Office Address</h3>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            123 Main Street<br>Wilpattuwa, Galle<br>Sri Lanka
          </p>
        </div>
      </div>

      <!-- Card 2: Phone -->
      <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
        <div>
          <h3 class="text-sm font-bold text-slate-900">Phone</h3>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            +94 (71) 123-4567<br>+94 (71) 987-6543
          </p>
        </div>
      </div>

      <!-- Card 3: Email -->
      <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
          <h3 class="text-sm font-bold text-slate-900">Email</h3>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            hello@techub.com<br>support@techub.com
          </p>
        </div>
      </div>

      <!-- Card 4: Business Hours -->
      <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
          <h3 class="text-sm font-bold text-slate-900">Business Hours</h3>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            Monday - Friday: 9:00 AM - 6:00 PM<br>
            Saturday: 10:00 AM - 4:00 PM<br>
            Sunday: Closed
          </p>
        </div>
      </div>

      <!-- Follow Us -->
      <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-3">Follow Us</h3>
        <div class="flex items-center gap-3">
          <a href="#" aria-label="Facebook" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="#" aria-label="Twitter" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.936 9.936 0 0024 4.59z"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-blue-700 hover:text-white text-slate-600 flex items-center justify-center transition-colors">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
        </div>
      </div>

    </div>

  </div>
</section>

<?php 
include '../include/footer.php'; 
?>