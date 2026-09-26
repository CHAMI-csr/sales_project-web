            </main>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-xl w-full bg-slate-900 border border-slate-700 rounded-xl p-4 shadow-2xl" id="modalBox" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h4 id="previewModalCaption" class="text-sm font-medium text-slate-200 truncate">Image Preview</h4>
                <button onclick="closeImageModal()" class="text-slate-400 hover:text-white p-1 rounded-md hover:bg-slate-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-2 flex items-center justify-center min-h-[220px] max-h-[70vh] overflow-hidden">
                <img id="previewModalImg" src="" alt="Preview" class="max-w-full max-h-[65vh] rounded-lg object-contain">
            </div>
        </div>
    </div>

    <script>
        // Toggle mobile sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar && backdrop) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }
        }

        // Image Preview Modal
        function showImageModal(src, title) {
            const modal = document.getElementById('imagePreviewModal');
            const img = document.getElementById('previewModalImg');
            const caption = document.getElementById('previewModalCaption');
            if (modal && img && src) {
                img.src = src;
                caption.textContent = title || 'Image Preview';
                modal.classList.remove('hidden');
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('imagePreviewModal');
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeImageModal();
        });

        // Highlight active link
        (function () {
            const path = window.location.pathname.toLowerCase();
            const map = {
                'manage.php': { id: 'nav-manage', title: 'Suppliers' },
                'prodouct.php': { id: 'nav-product', title: 'Products' },
                'ordertable.php': { id: 'nav-orders', title: 'Orders' },
                'history.php': { id: 'nav-history', title: 'Order History' }
            };

            const breadcrumbEl = document.getElementById('pageBreadcrumb');
            for (const [file, info] of Object.entries(map)) {
                if (path.includes(file)) {
                    const el = document.getElementById(info.id);
                    if (el) el.classList.add('custom-active-link');
                    if (breadcrumbEl) breadcrumbEl.textContent = info.title;
                    break;
                }
            }

            document.querySelectorAll('.product-thumb, .previewable-image').forEach(img => {
                img.addEventListener('click', function () {
                    showImageModal(this.src, this.alt || this.getAttribute('data-title'));
                });
            });
        })();
    </script>
</body>
</html>