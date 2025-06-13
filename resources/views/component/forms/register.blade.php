@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div id="register-form" class="form-section">
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
      >
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
      >
      <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
    </div>

    <div class="flex items-center">
      <input type="checkbox" id="terms" name="terms" required class="rounded border-gray-300 text-green-600 focus:ring-green-500">
      <label for="terms" class="ml-2 text-sm text-gray-600">
        I agree to the <a href="#" class="text-green-600 hover:text-green-700">Terms and Conditions</a>
      </label>
    </div>
    <div>
  <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Daftar sebagai</label>
  <select id="role" name="role" required
    class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none text-gray-700">
    <option value="" disabled selected>Pilih jenis pengguna</option>
    <option value="buyer">Pembeli</option>
    <option value="seller">Penjual</option>
  </select>
</div>


    <button
      type="submit"
      class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transform hover:scale-[1.02] active:scale-[0.98] font-medium"
    >
      Register
    </button>
  </form>
</div>
