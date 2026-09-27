/**
 * TecHub Core Interaction Script
 * Handles modals (Login & Sign Up), dropdowns (Cart & Profile), mobile menu, and toast alerts.
 */

// Helper: Open Modal with smooth transition
function openModal(overlay, container) {
  if (!overlay || !container) return;
  overlay.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
  setTimeout(() => {
    overlay.classList.remove('opacity-0');
    container.classList.remove('scale-95');
  }, 10);
}

// Helper: Close Modal with smooth transition
function closeModal(overlay, container) {
  if (!overlay || !container) return;
  overlay.classList.add('opacity-0');
  container.classList.add('scale-95');
  document.body.style.overflow = '';
  setTimeout(() => {
    overlay.classList.add('hidden');
  }, 300);
}

// Global Direct Modal Triggers
function openLoginModalDirect(tab = 'signin') {
  const loginOverlay = document.getElementById('login-modal-overlay');
  const loginContainer = loginOverlay ? loginOverlay.querySelector('div') : null;
  const signupOverlay = document.getElementById('signup-modal-overlay');
  const signupContainer = signupOverlay ? signupOverlay.querySelector('div') : null;

  if (tab === 'signup') {
    if (loginOverlay && !loginOverlay.classList.contains('hidden')) {
      closeModal(loginOverlay, loginContainer);
      setTimeout(() => {
        openModal(signupOverlay, signupContainer);
      }, 300);
    } else {
      openModal(signupOverlay, signupContainer);
    }
  } else {
    if (signupOverlay && !signupOverlay.classList.contains('hidden')) {
      closeModal(signupOverlay, signupContainer);
      setTimeout(() => {
        openModal(loginOverlay, loginContainer);
      }, 300);
    } else {
      openModal(loginOverlay, loginContainer);
    }
  }
}

// Toast Alert Function
function showAlert(type, title, message) {
  const alertContainer = document.getElementById('alert-container');
  if (!alertContainer) return;

  const alertElement = document.createElement('div');
  alertElement.className = `alert alert-${type}`;

  let iconSvg = '';
  switch (type) {
    case 'error':
      iconSvg = `<svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>`;
      break;
    case 'success':
      iconSvg = `<svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>`;
      break;
    default:
      iconSvg = `<svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>`;
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
    }, 400);
  }, 4500);
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const openLoginBtn = document.getElementById('openLoginModal');
  const closeLoginBtn = document.getElementById('closeLoginModal');
  const loginOverlay = document.getElementById('login-modal-overlay');
  const loginContainer = loginOverlay ? loginOverlay.querySelector('div') : null;

  // Sign Up Modal
  const closeSignupBtn = document.getElementById('closeSignupModal');
  const signupOverlay = document.getElementById('signup-modal-overlay');
  const signupContainer = signupOverlay ? signupOverlay.querySelector('div') : null;

  // Switch links between Login and Sign Up
  const openSignupFromLoginLink = document.getElementById('openSignupFromLogin');
  const openLoginFromSignupLink = document.getElementById('openLoginFromSignup');

  // Open Login Modal
  if (openLoginBtn) {
    openLoginBtn.addEventListener('click', (e) => {
      e.preventDefault();
      openLoginModalDirect('signin');
    });
  }

  // Close Login Modal
  if (closeLoginBtn && loginOverlay && loginContainer) {
    closeLoginBtn.addEventListener('click', () => {
      closeModal(loginOverlay, loginContainer);
    });
  }

  if (loginOverlay && loginContainer) {
    loginOverlay.addEventListener('click', (e) => {
      if (e.target === loginOverlay) {
        closeModal(loginOverlay, loginContainer);
      }
    });
  }

  // Close Sign Up Modal
  if (closeSignupBtn && signupOverlay && signupContainer) {
    closeSignupBtn.addEventListener('click', () => {
      closeModal(signupOverlay, signupContainer);
    });
  }

  if (signupOverlay && signupContainer) {
    signupOverlay.addEventListener('click', (e) => {
      if (e.target === signupOverlay) {
        closeModal(signupOverlay, signupContainer);
      }
    });
  }

  // Switch to Sign Up
  if (openSignupFromLoginLink) {
    openSignupFromLoginLink.addEventListener('click', (e) => {
      e.preventDefault();
      openLoginModalDirect('signup');
    });
  }

  // Switch to Login
  if (openLoginFromSignupLink) {
    openLoginFromSignupLink.addEventListener('click', (e) => {
      e.preventDefault();
      openLoginModalDirect('signin');
    });
  }

  // Profile Image Selection Preview in Signup
  const profileImageInput = document.getElementById('profileImageInput');
  const fileNameDisplay = document.getElementById('fileName');
  if (profileImageInput && fileNameDisplay) {
    profileImageInput.addEventListener('change', function () {
      if (this.files && this.files.length > 0) {
        fileNameDisplay.textContent = this.files[0].name;
      } else {
        fileNameDisplay.textContent = 'Select profile image';
      }
    });
  }

  // User Profile Dropdown in Header
  const userDropdownBtn = document.getElementById('userDropdownBtn');
  const userDropdown = document.getElementById('userDropdown');
  if (userDropdownBtn && userDropdown) {
    userDropdownBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      userDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target) && e.target !== userDropdownBtn && !userDropdownBtn.contains(e.target)) {
        userDropdown.classList.add('hidden');
      }
    });
  }

  // ── Cart Dropdown (AJAX, zero page reloads) ────────────────────────────────
  const cartBtn      = document.getElementById('cartBtn');
  const cartDropdown = document.getElementById('cartDropdown');
  const closeCartBtn = document.getElementById('closeCart');
  const CART_URL     = window.CART_AJAX_URL || null;

  function escHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function updateCartBadge(count) {
    // Button badge (top-right on Cart button)
    const btnBadge = cartBtn ? cartBtn.querySelector('span.bg-blue-600') : null;
    if (btnBadge) {
      if (count > 0) {
        btnBadge.textContent = count;
        btnBadge.classList.remove('hidden');
      } else {
        btnBadge.classList.add('hidden');
      }
    }
    // Header badge inside dropdown
    const headerBadge = document.getElementById('cartBadgeHeader');
    if (headerBadge) {
      if (count > 0) {
        headerBadge.textContent = count;
        headerBadge.classList.remove('hidden');
      } else {
        headerBadge.classList.add('hidden');
      }
    }
    // Footer count
    const footerCount = document.getElementById('cartFooterCount');
    if (footerCount) {
      footerCount.textContent = count + ' item' + (count !== 1 ? 's' : '') + ' in bag';
    }
  }

  function renderCartItems(data) {
    const container = document.getElementById('cartItems');
    if (!container) return;

    if (!data.success || data.items.length === 0) {
      container.innerHTML = `
        <div style="padding:2.5rem 0; text-align:center;">
          <svg style="width:2.5rem;height:2.5rem;margin:0 auto 0.5rem;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          <p style="color:#6b7280;font-size:0.8125rem;font-weight:600;margin:0;">Your bag is empty</p>
          <p style="color:#9ca3af;font-size:0.7rem;margin:0.25rem 0 0;">Add items to get started</p>
        </div>`;
      updateCartBadge(0);
      return;
    }

    updateCartBadge(data.count);

    const baseImgUrl = 'http://sales-project.test/images/items/';
    container.innerHTML = data.items.map(item => `
      <div class="cart-item" data-order-id="${escHtml(item.order_id)}" data-pid="${escHtml(item.pid)}"
           style="display:flex;align-items:center;gap:0.625rem;padding:0.5rem 0.375rem;border-radius:0.75rem;border:1px solid #f3f4f6;background:#f9fafb;margin-bottom:0.375rem;">
        <div style="width:50px;height:50px;flex-shrink:0;border-radius:0.625rem;overflow:hidden;background:#fff;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;">
          <img src="${baseImgUrl}${encodeURIComponent(item.image)}"
               alt="${escHtml(item.pname)}"
               style="width:100%;height:100%;object-fit:contain;padding:3px;"
               onerror="this.src='https://placehold.co/50x50/f3f4f6/9ca3af?text=Item';">
        </div>
        <div style="flex:1;min-width:0;">
          <p style="margin:0;font-size:0.75rem;font-weight:700;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.2;">${escHtml(item.pname)}</p>
          <p style="margin:0.125rem 0 0;font-size:0.6875rem;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${escHtml(item.categories)}</p>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.375rem;">
            <span style="font-size:0.6875rem;color:#6b7280;font-weight:500;">Qty: ${item.qty}</span>
            <span style="font-size:0.75rem;font-weight:700;color:#111827;">LKR ${parseFloat(item.price).toLocaleString('en-LK', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
          </div>
        </div>
        <button class="cart-delete-btn"
                style="width:1.75rem;height:1.75rem;flex-shrink:0;border:none;background:transparent;border-radius:0.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#d1d5db;transition:all 0.15s;"
                title="Remove" data-order-id="${escHtml(item.order_id)}" data-pid="${escHtml(item.pid)}">
          <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
        </button>
      </div>
    `).join('');

    // Bind delete buttons
    container.querySelectorAll('.cart-delete-btn').forEach(btn => {
      btn.addEventListener('mouseenter', () => { btn.style.color = '#ef4444'; btn.style.background = '#fef2f2'; });
      btn.addEventListener('mouseleave', () => { btn.style.color = '#d1d5db'; btn.style.background = 'transparent'; });
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const orderId = btn.dataset.orderId;
        const pid     = btn.dataset.pid;
        const row     = btn.closest('.cart-item');
        if (row) { row.style.opacity = '0.4'; row.style.pointerEvents = 'none'; }

        const fd = new FormData();
        fd.append('action', 'delete');
        fd.append('order_id', orderId);
        fd.append('pid', pid);

        fetch(CART_URL, { method: 'POST', body: fd, credentials: 'same-origin' })
          .then(r => r.json())
          .then(data => renderCartItems(data))
          .catch(() => { if (row) { row.style.opacity = ''; row.style.pointerEvents = ''; } });
      });
    });
  }

  function loadCart() {
    if (!CART_URL) return;
    const container = document.getElementById('cartItems');
    if (container) {
      container.innerHTML = `<div style="padding:2rem 0;text-align:center;">
        <svg style="width:1.5rem;height:1.5rem;margin:0 auto;color:#d1d5db;" class="animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
      </div>`;
    }
    fetch(CART_URL, { credentials: 'same-origin' })
      .then(r => r.json())
      .then(data => renderCartItems(data))
      .catch(() => {
        if (container) container.innerHTML = `<p class="text-center text-xs py-8" style="color:#64748b">Could not load cart</p>`;
      });
  }

  if (cartBtn && cartDropdown) {
    cartBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isHidden = cartDropdown.classList.contains('hidden');
      cartDropdown.classList.toggle('hidden');
      if (isHidden) loadCart(); // fetch fresh data every time cart opens
    });

    if (closeCartBtn) {
      closeCartBtn.addEventListener('click', () => cartDropdown.classList.add('hidden'));
    }

    document.addEventListener('click', (e) => {
      if (!cartDropdown.contains(e.target) && e.target !== cartBtn && !cartBtn.contains(e.target)) {
        cartDropdown.classList.add('hidden');
      }
    });
  }


  // Mobile Navigation Toggle
  const mobileNavToggle = document.getElementById('mobileNavToggle');
  const mobileNavMenu = document.getElementById('mobileNavMenu');
  if (mobileNavToggle && mobileNavMenu) {
    mobileNavToggle.addEventListener('click', () => {
      mobileNavMenu.classList.toggle('hidden');
    });
  }

  // Keyboard Escape Handler
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (loginOverlay && !loginOverlay.classList.contains('hidden')) {
        closeModal(loginOverlay, loginContainer);
      }
      if (signupOverlay && !signupOverlay.classList.contains('hidden')) {
        closeModal(signupOverlay, signupContainer);
      }
      if (userDropdown) userDropdown.classList.add('hidden');
      if (cartDropdown) cartDropdown.classList.add('hidden');
      if (mobileNavMenu) mobileNavMenu.classList.add('hidden');
    }
  });
});
