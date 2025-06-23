@extends('layout.apps')

@section('content')
<div class="flex min-h-screen">
  @include('component.seller.sidebar')

  <main class="flex-1 bg-gray-50 p-6">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-800">💰 Laporan Penjualan</h1>
      <p class="text-gray-600 mt-1">Pantau performa penjualan Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm">Total Pendapatan</p>
            <p class="text-2xl font-bold">Rp{{ number_format($total_revenue ?? 0, 0, ',', '.') }}</p>
          </div>
          <div class="text-3xl opacity-80">💵</div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-100 text-sm">Jumlah Transaksi</p>
            <p class="text-2xl font-bold">{{ $total_transactions ?? 0 }}</p>
          </div>
          <div class="text-3xl opacity-80">📊</div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-purple-100 text-sm">Produk Terjual</p>
            <p class="text-2xl font-bold">{{ $total_products_sold ?? 0 }}</p>
          </div>
          <div class="text-3xl opacity-80">📦</div>
        </div>
      </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">📋 Riwayat Penjualan</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($sales_history as $sale)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($sale->payment_date)->format('d M Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                #{{ $sale->order_id }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $sale->buyer->name ?? 'Customer' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                Rp{{ number_format($sale->price_total, 0, ',', '.') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                  ✅ Selesai
                </span>
              </td>
            </tr>
            @empty
            <!-- Sample Data -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">30 Apr 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#1024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">John Doe</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp250.000</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                  ✅ Selesai
                </span>
              </td>
            </tr>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">29 Apr 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#1023</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Jane Smith</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp180.000</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                  ⏳ Pending
                </span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if(isset($sales_history) && method_exists($sales_history, 'links'))
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $sales_history->links() }}
      </div>
      @endif
    </div>
  </main>
</div>
@endsection