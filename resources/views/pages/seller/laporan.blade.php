@extends('layout.apps')

@section('content')
<div class="flex min-h-screen">
  <!-- Sidebar -->
   @include('component.seller.sidebar')
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
