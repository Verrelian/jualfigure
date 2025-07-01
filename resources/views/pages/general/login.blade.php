<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login MOLE</title>
  <link rel="icon" href="{{ asset('images/favicon.jpg') }}" type="image/jpg">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-300 to-gray-100">

  <!-- Toast Notification Container -->
  <div id="toast-container" class="fixed top-5 right-5 z-50 space-y-3 max-w-sm w-full"></div>

  <div class="w-full max-w-md bg-white bg-opacity-70 backdrop-blur-lg rounded-xl shadow-xl p-8">
    <!-- Logo -->
    <div class="flex flex-col items-center mb-6">
      <img src="images/mole.png" alt="MOLE Logo" class="w-56 mb-2">
      <h1 class="text-xl font-bold text-center text-black">
        <span class="text-green-600 font-bold" id="title-text">Login</span>
      </h1>
    </div>

    <!-- Tabs (Login/Register Switch) -->
    <div class="flex justify-center mb-6 gap-2">
      <button id="login-tab" class="tab-button active px-6 py-2 bg-black text-white rounded-l-lg shadow">Login</button>
      <button id="register-tab" class="tab-button px-6 py-2 bg-white text-black rounded-r-lg shadow">Register</button>
    </div>

    <!-- Global Error Alert (for server-side validation errors) -->
    <div id="global-error-alert" class="hidden mb-4 p-4 bg-red-50 border border-red-200 rounded-lg alert-slide-down">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <div class="ml-3 flex-1">
          <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
          <div id="error-list" class="mt-2 text-sm text-red-700 max-h-32 overflow-y-auto custom-scrollbar">
            <!-- Error messages will be populated here -->
          </div>
        </div>
        <div class="ml-auto pl-3">
          <button id="close-error-alert" class="inline-flex text-red-400 hover:text-red-600 focus:outline-none">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div class="form-container">
      @include('component.forms.login')
      @include('component.forms.register')
      @include('component.forms.forgot-password')
    </div>

  </div>

  <!-- Load External auth.js -->
  <script src="{{ asset('js/auth.js') }}"></script>

  <!-- Handle Server-side Messages -->
  <script>
    @if (session('old_tab') === 'register')
  // Tunggu hingga tab siap
  setTimeout(() => {
    document.querySelector('#login-tab').classList.remove('active');
    document.querySelector('#register-tab').classList.add('active');
    document.querySelector('#login-form').classList.remove('active');
    document.querySelector('#register-form').classList.add('active');
  }, 100); // delay agar DOM siap
@endif

  document.addEventListener('DOMContentLoaded', function () {
    const checkAuthManager = () => {
      if (window.authFormManager) {
        handleServerMessages();
      } else {
        setTimeout(checkAuthManager, 50); // Retry setiap 50ms
      }
    };

    checkAuthManager();
  });

  function handleServerMessages() {
    // Success message dari session
    @if (session('success'))
      window.authFormManager.showSuccessMessage(@json(session('success')));
    @endif

    // Error biasa dari session
    @if (session('error'))
      window.authFormManager.showErrorMessage(@json(session('error')));
    @endif

    // Validasi errors (dari Validator Laravel)
    @if ($errors->any())
      const errors = @json($errors->all());
      window.authFormManager.showErrorAlert(errors);

      // Kalau dari form register, switch ke tab register
      @if (session('old_tab') === 'register' || old('email'))
        window.authFormManager.switchToRegisterTab();
      @endif
    @endif
  }
</script>
</body>
</html>