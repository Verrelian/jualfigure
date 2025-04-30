@extends('layout.apps')

@section('content')
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-gray-800 text-white p-4 space-y-4">
    <h2 class="text-xl font-bold mb-6">MOLE Seller</h2>
    <nav class="space-y-2">
      <a href="/dashboard" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
      <a href="/products" class="block py-2 px-3 rounded hover:bg-gray-700">Produk</a>
      <a href="/orders" class="block py-2 px-3 rounded hover:bg-gray-700">Pesanan</a>
      <a href="/sales-report" class="block py-2 px-3 rounded bg-gray-700">Laporan Penjualan</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 bg-gray-100 p-6">
    <h1 class="text-2xl font-semibold mb-4">Laporan Penjualan</h1>

    <!-- Ringkasan Penjualan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Pendapatan</p>
        <p class="text-xl font-bold">Rp5.200.000</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Jumlah Transaksi</p>
        <p class="text-xl font-bold">127</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Produk Terjual</p>
        <p class="text-xl font-bold">389</p>
      </div>
    </div>

    <!-- Tabel Riwayat Penjualan -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-lg font-semibold mb-4">Riwayat Penjualan</h2>
      <table class="min-w-full text-left text-sm">
        <thead>
          <tr class="border-b">
            <th class="py-2 px-4 font-medium">Tanggal</th>
            <th class="py-2 px-4 font-medium">Order ID</th>
            <th class="py-2 px-4 font-medium">Jumlah</th>
            <th class="py-2 px-4 font-medium">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2 px-4">30 Apr 2025</td>
            <td class="py-2 px-4">#ORD1024</td>
            <td class="py-2 px-4">Rp250.000</td>
            <td class="py-2 px-4"><span class="bg-green-200 px-2 py-1 rounded text-xs">Selesai</span></td>
          </tr>
          <!-- Tambahkan data lainnya -->
        </tbody>
      </table>
    </div>
  </main>
</div>
@endsection
