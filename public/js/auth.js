/**
 * Authentication System JavaScript
 * Complete external file for handling authentication forms, validation, and notifications
 */

// Toast Notification System
console.log('[auth.js] Loaded!');

class ToastManager {
  constructor() {
    this.container = document.getElementById('toast-container');
  }

  show(message, type = 'success', duration = 5000) {
    const toast = this.createToast(message, type);
    this.container.appendChild(toast);

    // Trigger enter animation
    setTimeout(() => {
      toast.classList.add('toast-enter-active');
      toast.classList.remove('toast-enter');
    }, 10);

    // Auto remove
    setTimeout(() => {
      this.remove(toast);
    }, duration);

    return toast;
  }

  createToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast-enter bg-white border-l-4 p-4 rounded-r-lg shadow-lg max-w-sm ${
      type === 'success' ? 'border-green-500' :
      type === 'error' ? 'border-red-500' :
      type === 'warning' ? 'border-yellow-500' : 'border-blue-500'
    }`;

    const iconColor = {
      success: 'text-green-500',
      error: 'text-red-500',
      warning: 'text-yellow-500',
      info: 'text-blue-500'
    }[type];

    const iconPath = {
      success: 'M5 13l4 4L19 7',
      error: 'M6 18L18 6M6 6l12 12',
      warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z',
      info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    }[type];

    toast.innerHTML = `
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <p class="text-sm font-medium text-gray-900">${message}</p>
        </div>
        <div class="ml-auto pl-3">
          <button class="toast-close inline-flex text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
      </div>
    `;

    // Add close functionality
    toast.querySelector('.toast-close').addEventListener('click', () => {
      this.remove(toast);
    });

    return toast;
  }

  remove(toast) {
    toast.classList.add('toast-exit-active');
    toast.classList.remove('toast-enter-active');

    setTimeout(() => {
      if (toast.parentNode) {
        toast.parentNode.removeChild(toast);
      }
    }, 300);
  }
}

// Error Alert Management
class ErrorAlertManager {
  constructor() {
    this.alert = document.getElementById('global-error-alert');
    this.errorList = document.getElementById('error-list');
    this.closeBtn = document.getElementById('close-error-alert');

    if (this.closeBtn) {
      this.closeBtn.addEventListener('click', () => {
        this.hide();
      });
    }
  }

  show(errors) {
    if (!this.errorList) return;

    this.errorList.innerHTML = '';

    if (Array.isArray(errors)) {
      const ul = document.createElement('ul');
      ul.className = 'list-disc list-inside space-y-1';
      errors.forEach(error => {
        const li = document.createElement('li');
        li.textContent = error;
        ul.appendChild(li);
      });
      this.errorList.appendChild(ul);
    } else {
      this.errorList.textContent = errors;
    }

    if (this.alert) {
      this.alert.classList.remove('hidden');
    }
  }

  hide() {
    if (this.alert) {
      this.alert.classList.add('hidden');
    }
  }
}

// Authentication Form Manager
class AuthFormManager {
  constructor() {
    this.toastManager = new ToastManager();
    this.errorAlertManager = new ErrorAlertManager();

    this.init();
  }

  init() {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => {
        this.setupEventHandlers();
        this.handleServerMessages();
      });
    } else {
      this.setupEventHandlers();
      this.handleServerMessages();
    }
  }

  setupEventHandlers() {
    // Form switching functionality
    this.setupTabSwitching();

    // Form validation
    this.setupFormValidation();

    // Forgot password functionality
    this.setupForgotPassword();

    // Real-time validation
    this.setupRealTimeValidation();
  }

  setupTabSwitching() {
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const backToLoginLink = document.getElementById('back-to-login');
    const titleText = document.getElementById('title-text');

    // Handle login tab click
    if (loginTab) {
      loginTab.addEventListener('click', (e) => {
        e.preventDefault();
        if (loginTab.classList.contains('active')) return;

        loginTab.classList.add('bg-black', 'text-white', 'active');
        loginTab.classList.remove('bg-white', 'text-black');

        if (registerTab) {
          registerTab.classList.add('bg-white', 'text-black');
          registerTab.classList.remove('bg-black', 'text-white', 'active');
        }

        if (titleText) titleText.textContent = 'Login';

        const activeForm = document.querySelector('.form-section.active');
        this.switchForm(activeForm, document.getElementById('login-form'));
        this.errorAlertManager.hide();
      });
    }

    // Handle register tab click
    if (registerTab) {
      registerTab.addEventListener('click', (e) => {
        e.preventDefault();
        if (registerTab.classList.contains('active')) return;

        registerTab.classList.add('bg-black', 'text-white', 'active');
        registerTab.classList.remove('bg-white', 'text-black');

        if (loginTab) {
          loginTab.classList.add('bg-white', 'text-black');
          loginTab.classList.remove('bg-black', 'text-white', 'active');
        }

        if (titleText) titleText.textContent = 'Register';

        const activeForm = document.querySelector('.form-section.active');
        this.switchForm(activeForm, document.getElementById('register-form'));
        this.errorAlertManager.hide();
      });
    }

    // Handle forgot password link click
    if (forgotPasswordLink) {
      forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();

        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(btn => {
          btn.classList.remove('active', 'bg-black', 'text-white');
          btn.classList.add('bg-white', 'text-black');
        });

        if (titleText) titleText.textContent = 'Forgot Password';

        const activeForm = document.querySelector('.form-section.active');
        this.switchForm(activeForm, document.getElementById('forgot-password-form'));
        this.errorAlertManager.hide();
      });
    }

    // Handle back to login link click
    if (backToLoginLink) {
      backToLoginLink.addEventListener('click', (e) => {
        e.preventDefault();

        if (loginTab) {
          loginTab.classList.add('bg-black', 'text-white', 'active');
          loginTab.classList.remove('bg-white', 'text-black');
        }

        if (registerTab) {
          registerTab.classList.add('bg-white', 'text-black');
          registerTab.classList.remove('bg-black', 'text-white', 'active');
        }

        if (titleText) titleText.textContent = 'Login';

        const activeForm = document.querySelector('.form-section.active');
        this.switchForm(activeForm, document.getElementById('login-form'));
        this.errorAlertManager.hide();
      });
    }
  }

  switchForm(hideForm, showForm) {
    if (hideForm) {
      hideForm.classList.remove('active');
    }

    setTimeout(() => {
      if (showForm) {
        showForm.classList.add('active');
      }
    }, 300);
  }

  setupFormValidation() {
    // Login form validation
    const loginForm = document.querySelector('#login-form form');
    if (loginForm) {
      loginForm.addEventListener('submit', (e) => {
        if (!this.validateForm('#login-form')) {
          e.preventDefault();
        }
      });
    }

    // Register form validation
    const registerForm = document.querySelector('#register-form form');
    if (registerForm) {
      registerForm.addEventListener('submit', (e) => {
        if (!this.validateForm('#register-form')) {
          e.preventDefault();
        }
      });
    }
  }

  setupForgotPassword() {
  const forgotPasswordForm = document.getElementById('forgot-password-form-element');

  if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', (e) => {
      const identityInput = document.getElementById('reset-identity');
      const identity = identityInput ? identityInput.value.trim() : '';

      if (identity === '') {
        e.preventDefault(); // ❗ Cegah hanya jika kosong
        this.toastManager.show('Please enter your email or username', 'error');
        return;
      }

      if (identity.includes('@')) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(identity)) {
          e.preventDefault(); // ❗ Cegah hanya jika format salah
          this.toastManager.show('Please enter a valid email address', 'error');
          return;
        }
      }

      // ✅ Jangan preventDefault kalau semua valid
      // Biarkan Laravel yang handle di backend
    });
  }
}


  setupRealTimeValidation() {
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
      input.addEventListener('blur', () => {
        this.validateInput(input);
      });
    });
  }

  validateInput(input) {
    const errorDiv = input.parentNode.querySelector('.error-message');
    const value = input.value.trim();

    // Clear previous errors
    if (errorDiv) {
      errorDiv.classList.add('hidden');
      errorDiv.textContent = '';
    }
    input.classList.remove('border-red-500');

    if (input.hasAttribute('required') && value === '') {
      this.showInputError(input, errorDiv, 'This field is required');
    } else if (input.type === 'email' && value !== '') {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        this.showInputError(input, errorDiv, 'Please enter a valid email address');
      }
    } else if (input.name === 'password' && value !== '' && value.length < 8) {
      this.showInputError(input, errorDiv, 'Password must be at least 8 characters');
    } else if (input.name === 'password_confirmation' && value !== '') {
      const passwordInput = document.getElementById('register-password');
      const password = passwordInput ? passwordInput.value : '';
      if (password !== value) {
        this.showInputError(input, errorDiv, 'Passwords do not match');
      }
    }
  }

  showInputError(input, errorDiv, message) {
    if (errorDiv) {
      errorDiv.classList.remove('hidden');
      errorDiv.textContent = message;
    }
    input.classList.add('border-red-500');
  }

  validateForm(formSelector) {
    let isValid = true;
    const form = document.querySelector(formSelector);

    if (!form) return false;

    const requiredInputs = form.querySelectorAll('input[required]');

    requiredInputs.forEach(input => {
      const errorDiv = input.parentNode.querySelector('.error-message');
      const value = input.value.trim();

      // Clear previous errors
      if (errorDiv) {
        errorDiv.classList.add('hidden');
        errorDiv.textContent = '';
      }
      input.classList.remove('border-red-500');

      if (value === '') {
        this.showInputError(input, errorDiv, 'This field is required');
        isValid = false;
      } else if (input.type === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
          this.showInputError(input, errorDiv, 'Please enter a valid email address');
          isValid = false;
        }
      } else if (input.name === 'password' && value.length < 8) {
        this.showInputError(input, errorDiv, 'Password must be at least 8 characters');
        isValid = false;
      }
    });

    // Password confirmation validation for register form
    if (formSelector === '#register-form') {
      const passwordInput = document.getElementById('register-password');
      const confirmInput = document.getElementById('register-password-confirm');

      if (passwordInput && confirmInput) {
        const password = passwordInput.value;
        const confirmPassword = confirmInput.value;
        const confirmErrorDiv = confirmInput.parentNode.querySelector('.error-message');

        if (password !== confirmPassword && confirmPassword !== '') {
          this.showInputError(confirmInput, confirmErrorDiv, 'Passwords do not match');
          isValid = false;
        }
      }
    }

    return isValid;
  }

  handleServerMessages() {
    // This method will be called with server data from Blade template
    // The actual implementation will be in the Blade file
  }

  // Public methods for handling server messages from Blade
  showSuccessMessage(message) {
    this.toastManager.show(message, 'success');
  }

  showErrorMessage(message) {
    this.toastManager.show(message, 'error');
  }

  showErrorAlert(errors) {
    this.errorAlertManager.show(errors);
  }

  switchToRegisterTab() {
    const registerTab = document.getElementById('register-tab');
    if (registerTab) {
      registerTab.click();
    }
  }
}

// Initialize when DOM is ready
let authFormManager;

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    authFormManager = new AuthFormManager();
  });
} else {
  authFormManager = new AuthFormManager();
}

// Export for global access
window.AuthFormManager = AuthFormManager;
window.authFormManager = authFormManager;