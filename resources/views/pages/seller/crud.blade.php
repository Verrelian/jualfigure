@extends('layout.apps')

@section('content')
<div class="flex w-full h-screen overflow-hidden">
  @include('component.seller.sidebar')

  <!-- Main Content -->
  <main class="flex-1 bg-gray-500 p-2 sm:p-4 lg:p-6 xl:p-8 overflow-auto">
    <h1 class="text-2xl font-semibold mb-4">Welcome Aboard Seller</h1>

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
          <!-- Add more rows here -->
        </tbody>
      </table>
    </div>
  </main>
</div>
@endsection
