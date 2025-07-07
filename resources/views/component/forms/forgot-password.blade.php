
<div id="forgot-password-form" class="form-section">
  <form id="forgot-password-form-element" action="{{ route('forgot.submit') }}" method="POST" class="space-y-4">
    @csrf
    <div class="text-center mb-4">
      <p class="text-gray-600 text-sm">Enter your email address and we'll send you a link to reset your password.</p>
    </div>

    <div>
      <label for="reset-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input
        type="text"
        id="reset-identity"
        name="identity"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Enter your email"
        required
      >
      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <button
      type="submit"
      class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transform hover:scale-[1.02] active:scale-[0.98] font-medium"
    >
      Send Reset Link
    </button>

    <div class="text-center">
      <a href="#" id="back-to-login" class="text-green-600 hover:text-green-700 text-sm transition-colors">
        ← Back to Login
      </a>
    </div>
  </form>
</div>
