<aside class="w-64 h-screen bg-white text-gray-800 border-r border-gray-200 shadow-sm flex flex-col p-5 space-y-6 font-medium">

  <!-- Seller Profile -->
  <div class="flex items-center space-x-4 bg-gray-100 p-4 rounded-lg">
    <img src="{{ asset('images/figure1.png') }}" alt="Avatar" class="h-12 w-12 rounded-full border">
    <div>
      <p class="text-base font-semibold">Verrelian</p>
      <p class="text-sm text-gray-500">verrelian@gmail.com</p>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="flex flex-col space-y-1">
    <a href="/mole/seller/dashboardp" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 transition">
      <span>📊 Dashboard</span>
    </a>
    <a href="/mole/seller/product" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 transition">
      <span>📦 Produk</span>
    </a>
    <a href="/mole/seller/order" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 transition">
      <span>🧾 Pesanan</span>
    </a>
    <a href="/mole/seller/laporan" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 transition">
      <span>📈 Laporan</span>
    </a>
    <a href="#" onclick="logout()" class="flex items-center px-4 py-2 rounded text-red-600 hover:bg-red-100 transition">
      <span>🚪 Keluar</span>
    </a>
  </nav>

  <script>
    function logout() {
      localStorage.removeItem('currentUser');
      window.location.href = '/mole/login';
    }
  </script>
</aside>
