<div id="login-form" class="form-section active">
  <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
    @csrf

    {{-- Pilihan Tipe Pengguna --}}
    <div>
      <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Login sebagai</label>
      <select id="role" name="role" required
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none text-gray-700">
        <option value="" disabled selected>Pilih jenis pengguna</option>
        <option value="pembeli">Pembeli</option>
        <option value="penjual">Penjual</option>
      </select>
    </div>

    {{-- Username atau Email --}}
    <div>
      <label for="login-identity" class="block text-sm font-medium text-gray-700 mb-1">Username atau Email</label>
      <input
        type="text"
        id="login-identity"
        name="identity"
        value="{{ old('identity') }}"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Masukkan username atau email"
        required
      >
      @error('identity')
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- Password --}}
    <div>
      <label for="login-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input
        type="password"
        id="login-password"
        name="password"
        class="w-full px-4 py-3 border-b border-gray-300 bg-transparent focus:border-green-500 focus:outline-none placeholder-gray-500"
        placeholder="Masukkan password"
        required
      >
      @error('password')
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- Remember Me dan Lupa Password --}}
    <div class="flex items-center justify-between text-sm">
      <label class="flex items-center">
        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
        <span class="ml-2 text-gray-600">Ingat saya</span>
      </label>
      <a href="#" id="forgot-password-link" class="text-green-600 hover:text-green-700 transition-colors">
        Lupa Password?
      </a>
    </div>

    {{-- Tombol Login --}}
    <button
      type="submit"
      class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transform hover:scale-[1.02] active:scale-[0.98] font-medium"
    >
      Login
    </button>
  </form>
</div>
