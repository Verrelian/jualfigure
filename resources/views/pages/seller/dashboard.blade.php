@extends('layout.apps')

@section('content')
<div class="flex w-full h-screen overflow-hidden">
  @include('component.seller.sidebar')
  <!-- Main Content -->
  <main class="flex-1 bg-gray-200 p-6 overflow-y-auto">

    <!-- Greeting Section -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white p-6 rounded-xl shadow mb-6 flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold">Halo, Verrel! 👋</h2>
        <p class="text-sm">Selamat datang kembali. Yuk cek performa tokomu hari ini!</p>
      </div>
      <img src="{{ asset('img/avatar.png') }}" alt="Avatar" class="w-16 h-16 rounded-full border-2 border-white shadow">
    </div>

    <!-- Sales Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Orders</p>
        <p class="text-xl font-bold">1,271</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Items Sold</p>
        <p class="text-xl font-bold">31</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Returned Items</p>
        <p class="text-xl font-bold">6</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Delivered Orders</p>
        <p class="text-xl font-bold">22</p>
      </div>
    </div>

    <!-- Progress Target -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <h2 class="text-lg font-semibold mb-2">Target Penjualan Bulan Ini</h2>
      <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
        <div class="bg-green-500 h-4 rounded-full" style="width: 65%"></div>
      </div>
      <p class="text-sm text-gray-600">Rp6.500.000 dari Rp10.000.000</p>
    </div>

    <!-- Quick Notice -->
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow mb-6">
      <p><strong>Perhatian:</strong> Ada 3 pesanan yang belum dikirim. Segera proses sebelum pelanggan komplain!</p>
    </div>

    <!-- Latest Orders Table -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-lg font-semibold mb-4">Pesanan Terbaru</h2>
      <table class="min-w-full text-left text-sm">
        <thead>
          <tr class="border-b">
            <th class="py-2 px-4 font-medium">Order</th>
            <th class="py-2 px-4 font-medium">Tanggal</th>
            <th class="py-2 px-4 font-medium">Customer</th>
            <th class="py-2 px-4 font-medium">Total</th>
            <th class="py-2 px-4 font-medium">Status Pembayaran</th>
            <th class="py-2 px-4 font-medium">Status Pengiriman</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2 px-4">#2050</td>
            <td class="py-2 px-4">Hari ini, 6:55</td>
            <td class="py-2 px-4">Guy Hawkins</td>
            <td class="py-2 px-4">Rp98.990</td>
            <td class="py-2 px-4"><span class="bg-gray-200 px-2 py-1 rounded text-xs">Paid</span></td>
            <td class="py-2 px-4"><span class="bg-yellow-200 px-2 py-1 rounded text-xs">Unfulfilled</span></td>
          </tr>
          <!-- Tambahkan baris lainnya jika diperlukan -->
        </tbody>
      </table>
    </div>
    <!-- Top Products -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <h2 class="text-lg font-semibold mb-4">Produk Terlaris</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-100 p-3 rounded shadow-sm text-center">
          <img src="{{ asset('img/produk1.jpg') }}" alt="Produk" class="w-16 h-16 mx-auto mb-2 object-cover rounded">
          <p class="text-sm font-semibold">Zoro Figure</p>
          <p class="text-xs text-gray-500">Terjual 134x</p>
        </div>
        <!-- Tambahkan lebih banyak produk jika diperlukan -->
      </div>
    </div>

              <!-- Script Logout -->
              <script>
                function logout() {
                  localStorage.removeItem('currentUser');
                  window.location.href = '/mole/login';
                }
              </script>
  </main>
</div>
@endsection
