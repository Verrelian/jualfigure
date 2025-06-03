<div id="login-form" class="form-section active">
  <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label for="username" class="block text-sm font-semibold text-gray-700">Username</label>
      <input
      type="text"
      id="username"
      name="username"
      class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
      placeholder="Enter your username"
      required>

      <label for="login-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input
        type="email"
        id="login-email"
        name="email"
        value="{{ old('email') }}"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Enter your email"
        required
      >
      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div>
      <label for="login-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input
        type="password"
        id="login-password"
        name="password"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Enter your password"
        required
      >
      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div class="flex items-center justify-between text-sm">
      <label class="flex items-center">
        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
        <span class="ml-2 text-gray-600">Remember me</span>
      </label>
      <a href="#" id="forgot-password-link" class="text-green-600 hover:text-green-700 transition-colors">
        Forgot Password?
      </a>
    </div>

    <button
      type="submit"
      class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transform hover:scale-[1.02] active:scale-[0.98] font-medium"
    >
      Login
    </button>
  </form>
</div>
