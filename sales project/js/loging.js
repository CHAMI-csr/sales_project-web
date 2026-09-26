// Get references for the login modal and its elements
const openLoginModalBtn = document.getElementById('openLoginModal');
const closeLoginModalBtn = document.getElementById('closeLoginModal');
const loginModalOverlay = document.getElementById('login-modal-overlay');
const loginModalContainer = loginModalOverlay.querySelector('div');

// Get references for the new sign-up modal and its elements
const closeSignupModalBtn = document.getElementById('closeSignupModal');
const signupModalOverlay = document.getElementById('signup-modal-overlay');
const signupModalContainer = signupModalOverlay.querySelector('div');

// Get the links to switch between modals
const openSignupLink = document.querySelector('#login-modal-overlay .p .span');
const openLoginLinkFromSignup = document.getElementById('openLoginFromSignup');

// A reusable function to open a modal with animation
const openModal = (modalOverlay, modalContainer) => {
    modalOverlay.classList.remove('hidden');
    setTimeout(() => {
        modalOverlay.classList.remove('opacity-0');
        modalContainer.classList.remove('scale-95');
    }, 10);
};

// A reusable function to close a modal with animation
const closeModal = (modalOverlay, modalContainer) => {
    modalOverlay.classList.add('opacity-0');
    modalContainer.classList.add('scale-95');
    setTimeout(() => {
        modalOverlay.classList.add('hidden');
    }, 300);
};

// Event listener for opening the login modal
openLoginModalBtn.addEventListener('click', () => {
    openModal(loginModalOverlay, loginModalContainer);
});

// Event listener for closing the login modal
closeLoginModalBtn.addEventListener('click', () => {
    closeModal(loginModalOverlay, loginModalContainer);
});

// Event listener for closing the login modal by clicking outside
loginModalOverlay.addEventListener('click', (event) => {
    if (event.target === loginModalOverlay) {
        closeModal(loginModalOverlay, loginModalContainer);
    }
});

// Event listener for switching from login to sign-up
openSignupLink.addEventListener('click', (event) => {
    event.preventDefault();
    closeModal(loginModalOverlay, loginModalContainer);
    setTimeout(() => {
        openModal(signupModalOverlay, signupModalContainer);
    }, 300); // Wait for the login modal to close before opening the sign-up modal
});

// Event listener for closing the sign-up modal
closeSignupModalBtn.addEventListener('click', () => {
    closeModal(signupModalOverlay, signupModalContainer);
});

// Event listener for closing the sign-up modal by clicking outside
signupModalOverlay.addEventListener('click', (event) => {
    if (event.target === signupModalOverlay) {
        closeModal(signupModalOverlay, signupModalContainer);
    }
});

// Event listener for switching from sign-up to login
openLoginLinkFromSignup.addEventListener('click', () => {
    closeModal(signupModalOverlay, signupModalContainer);
    setTimeout(() => {
        openModal(loginModalOverlay, loginModalContainer);
    }, 300); // Wait for the sign-up modal to close before opening the login modal
});

// Handle ESC key press to close the currently open modal
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        if (!loginModalOverlay.classList.contains('hidden')) {
            closeModal(loginModalOverlay, loginModalContainer);
        } else if (!signupModalOverlay.classList.contains('hidden')) {
            closeModal(signupModalOverlay, signupModalContainer);
        }
    }
});
