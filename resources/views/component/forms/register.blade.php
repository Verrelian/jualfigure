<div id="register-form" class="form-section">
@if ($errors->any() && session('old_tab') === 'register')
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5 ml-4">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <form action="{{ route('auth.register') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label for="register-username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
      <input
        type="text"
        id="register-username"
        name="username"
        value="{{ old('username') }}"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Enter your full name"
        required
      >
      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div>
      <label for="register-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input
        type="email"
        id="register-email"
        name="email"
        value="{{ old('email') }}"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Enter your email"
        required
      >
      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div>
      <label for="register-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input
        type="password"
        id="register-password"
        name="password"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Enter your password"
        required
      ><small class="text-gray-500 text-xs">Minimal 8 karakter</small>

      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div>
      <label for="register-password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
      <input
        type="password"
        id="register-password-confirm"
        name="password_confirmation"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Confirm your password"
        required
      ><small class="text-gray-500 text-xs">Minimal 8 karakter</small>

      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div>
      <label for="register-role" class="block text-sm font-medium text-gray-700 mb-1">Daftar sebagai</label>
      <select id="register-role" name="role" required
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none text-gray-700">
        <option value="" disabled selected>Pilih jenis pengguna</option>
        <option value="buyer">Pembeli</option>
        <option value="seller">Penjual</option>
      </select>
    </div>

    <div class="flex items-center">
      <input type="checkbox" id="terms" name="terms" required class="rounded border-gray-300 text-green-600 focus:ring-green-500">
      <label for="terms" class="ml-2 text-sm text-gray-600">
        I agree to the <a href="#" class="text-green-600 hover:text-green-700">Terms and Conditions</a>
      </label>
    </div>

    <button
      type="submit"
      class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transform hover:scale-[1.02] active:scale-[0.98] font-medium"
    >
      Register
    </button>
  </form>
</div>