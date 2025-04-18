<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login MOLE</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }

    .form-container {
      position: relative;
      overflow: hidden;
      transition: height 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .form-section {
      opacity: 0;
      position: absolute;
      width: 100%;
      pointer-events: none;
      transform: translateY(20px);
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .form-section.active {
      opacity: 1;
      position: relative;
      pointer-events: all;
      transform: translateY(0);
    }

    .tab-button {
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      position: relative;
    }

    .tab-button:hover {
      transform: translateY(-2px);
    }

    .tab-button.active:after {
      content: '';
      position: absolute;
      bottom: -3px;
      left: 50%;
      transform: translateX(-50%);
      width: 30%;
      height: 3px;
      background-color: currentColor;
      border-radius: 3px;
    }

    input {
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    input:focus {
      border-bottom-width: 2px;
    }

    button {
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-300 to-gray-100">

  <div class="w-full max-w-md bg-white bg-opacity-70 backdrop-blur-lg rounded-xl shadow-xl p-8">
    <!-- Logo -->
    <div class="flex flex-col items-center mb-6">
      <img src="images/mole.png" alt="MOLE Logo" class="w-56 mb-2">
      <h1 class="text-xl font-bold text-center text-black">
        <span class="text-green-600 font-bold" id="title-text">Login</span> nih kalo udah!
      </h1>
    </div>

    <!-- Tabs (Login/Register Switch) -->
    <div class="flex justify-center mb-6 gap-2">
      <button id="login-tab" class="tab-button active px-6 py-2 bg-black text-white rounded-l-lg shadow">Login</button>
      <button id="register-tab" class="tab-button px-6 py-2 bg-white text-black rounded-r-lg shadow">Register</button>
    </div>

    <!-- Forms Container -->
    <div class="form-container">
      <!-- Login Form -->
      <div id="login-form" class="form-section active">
        <form method="POST" action="#">
          <div class="mb-4">
            <label for="login-username" class="block text-sm font-semibold text-gray-700">Username</label>
            <input type="text" id="login-username" name="username" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Enter your username">
          </div>

          <div class="mb-4">
            <label for="login-password" class="block text-sm font-semibold text-gray-700">Password</label>
            <input type="password" id="login-password" name="password" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Enter your password">
          </div>

          <div class="flex items-center justify-between mb-6">
            <div>
              <input id="remember" name="remember" type="checkbox" class="mr-2 text-purple-600">
              <label for="remember" class="text-sm text-gray-700">Remember me</label>
            </div>
            <div>
              <a href="#" id="forgot-password-link" class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-300">Forgot Password?</a>
            </div>
          </div>

          <button type="submit" class="w-full bg-blue-100 hover:bg-blue-200 text-black font-semibold py-2 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
            Login
          </button>
        </form>
      </div>

      <!-- Register Form -->
      <div id="register-form" class="form-section">
        <form method="POST" action="#">
          <div class="mb-4">
            <label for="register-username" class="block text-sm font-semibold text-gray-700">Username</label>
            <input type="text" id="register-username" name="username" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Choose a username">
          </div>

          <div class="mb-4">
            <label for="register-email" class="block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" id="register-email" name="email" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Enter your email">
          </div>

          <div class="mb-4">
            <label for="register-password" class="block text-sm font-semibold text-gray-700">Password</label>
            <input type="password" id="register-password" name="password" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Create a password">
          </div>

          <div class="mb-4">
            <label for="confirm-password" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
            <input type="password" id="confirm-password" name="password_confirmation" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Confirm your password">
          </div>

          <button type="submit" class="w-full bg-blue-100 hover:bg-blue-200 text-black font-semibold py-2 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
            Register
          </button>
        </form>
      </div>

      <!-- Forgot Password Form -->
      <div id="forgot-password-form" class="form-section">
        <form method="POST" action="#">
          <div class="mb-4">
            <p class="text-sm text-gray-600 mb-4">Enter your email address and we'll send you a link to reset your password.</p>

            <label for="reset-email" class="block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" id="reset-email" name="email" class="mt-1 w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-black px-1 py-1" placeholder="Enter your email">
          </div>

          <button type="submit" class="w-full bg-blue-100 hover:bg-blue-200 text-black font-semibold py-2 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg mb-4">
            Send Reset Link
          </button>

          <div class="text-center">
            <a href="#" id="back-to-login" class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-300">Back to Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Function to switch forms
      function switchForm(hideForm, showForm) {
        // First hide currently active form
        $(hideForm).removeClass('active');

        // After a small delay, show the new form
        setTimeout(function() {
          $(showForm).addClass('active');
        }, 300);
      }

      // Handle login tab click
      $('#login-tab').click(function() {
        if ($(this).hasClass('active')) return;

        // Update tab styles
        $(this).addClass('bg-black text-white active').removeClass('bg-white text-black');
        $('#register-tab').addClass('bg-white text-black').removeClass('bg-black text-white active');

        // Update title
        $('#title-text').text('Login');

        // Find currently active form and switch to login form
        var activeForm = $('.form-section.active');
        switchForm(activeForm, '#login-form');
      });

      // Handle register tab click
      $('#register-tab').click(function() {
        if ($(this).hasClass('active')) return;

        // Update tab styles
        $(this).addClass('bg-black text-white active').removeClass('bg-white text-black');
        $('#login-tab').addClass('bg-white text-black').removeClass('bg-black text-white active');

        // Update title
        $('#title-text').text('Register');

        // Find currently active form and switch to register form
        var activeForm = $('.form-section.active');
        switchForm(activeForm, '#register-form');
      });

      // Handle forgot password link click
      $('#forgot-password-link').click(function(e) {
        e.preventDefault();

        // Remove active state from tabs
        $('.tab-button').removeClass('active bg-black text-white').addClass('bg-white text-black');

        // Update title
        $('#title-text').text('Forgot Password');

        // Find currently active form and switch to forgot password form
        var activeForm = $('.form-section.active');
        switchForm(activeForm, '#forgot-password-form');
      });

      // Handle back to login link click
      $('#back-to-login').click(function(e) {
        e.preventDefault();

        // Update tab styles
        $('#login-tab').addClass('bg-black text-white active').removeClass('bg-white text-black');
        $('#register-tab').addClass('bg-white text-black').removeClass('bg-black text-white active');

        // Update title
        $('#title-text').text('Login');

        // Find currently active form and switch to login form
        var activeForm = $('.form-section.active');
        switchForm(activeForm, '#login-form');
      });
    });
  </script>
</body>
</html>
