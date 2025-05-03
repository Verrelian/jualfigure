<aside class="w-64 bg-white border-b border-gray-200 shadow-sm text-black flex flex-col p-4 space-y-6">

  <!-- Seller Profile -->
  <div class="flex items-center space-x-3 p-2 rounded bg-gray-700">
    <img src="{{ asset('images/figure1.png') }}" alt="Avatar" class="h-10 w-10 rounded-full">
    <div>
      <p class="text-sm font-semibold">Verrelian</p>
      <p class="text-xs text-gray-300">Verrelian@gmail.com</p>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="space-y-2">
    <a href="/mole/seller/crud" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
    <a href="/mole/seller/product" class="block py-2 px-3 rounded hover:bg-gray-700">Produk</a>
    <a href="/mole/seller/order" class="block py-2 px-3 rounded hover:bg-gray-700">Pesanan</a>
    <a href="/mole/seller/laporan" class="block py-2 px-3 rounded hover:bg-gray-700">Laporan Penjualan</a>
    <a href="#" onclick="logout()" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 me-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                  </path>
                </svg>
                Keluar
              </a>

              <!-- Script Logout -->
              <script>
                function logout() {
                  localStorage.removeItem('currentUser');
                  window.location.href = '/mole/login';
                }
              </script>
  </nav>
</aside>
