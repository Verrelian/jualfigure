@extends('layous.apps')

@section('content')
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-gray-800 text-white p-4 space-y-4">
    <h2 class="text-xl font-bold mb-6">MOLE Seller</h2>
    <nav class="space-y-2">
      <a href="/dashboard" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
      <a href="sclass="block py-2 px-3 rounded hover:bg-gray-700">Produk</a>
      <a href="/orders" class="block py-2 px-3 rounded bg-gray-700">Pesanan</a>
      <a href="/sales-report" class="block py-2 px-3 rounded hover:bg-gray-700">Laporan Penjualan</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 bg-gray-100 p-6">
    <h1 class="text-2xl font-semibold mb-4">Kelola Pesanan</h1>

    <!-- Tabel Pesanan -->
    <div class="bg-white p-4 rounded shadow">
      <table class="min-w-full text-left text-sm">
        <thead>
          <tr class="border-b">
            <th class="py-2 px-4 font-medium">Order ID</th>
            <th class="py-2 px-4 font-medium">Pelanggan</th>
            <th class="py-2 px-4 font-medium">Tanggal</th>
            <th class="py-2 px-4 font-medium">Total</th>
            <th class="py-2 px-4 font-medium">Status</th>
            <th class="py-2 px-4 font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2 px-4">#ORD1024</td>
            <td class="py-2 px-4">Budi Santoso</td>
            <td class="py-2 px-4">30 Apr 2025</td>
            <td class="py-2 px-4">Rp250.000</td>
            <td class="py-2 px-4">
              <span class="bg-yellow-200 px-2 py-1 rounded text-xs">Menunggu Konfirmasi</span>
            </td>
            <td class="py-2 px-4 space-x-2">
              <form method="POST" action="/orders/confirm/1024" class="inline">
                @csrf
                <button class="text-green-600 hover:underline">Konfirmasi</button>
              </form>
              <form method="POST" action="/orders/cancel/1024" class="inline">
                @csrf
                <button class="text-red-600 hover:underline">Batalkan</button>
              </form>
            </td>
          </tr>
          <!-- Tambahkan data lainnya -->
        </tbody>
      </table>
    </div>
  </main>
</div>
@endsection
