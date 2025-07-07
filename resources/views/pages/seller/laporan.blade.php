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

    <!-- Filter -->
    <form method="GET" action="{{ route('seller.laporan') }}" class="mb-6 flex items-center gap-2">
      <select name="bulan" class="border px-3 py-2 rounded">
        @foreach(range(1, 12) as $b)
          <option value="{{ sprintf('%02d', $b) }}" {{ $bulan == sprintf('%02d', $b) ? 'selected' : '' }}>
            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
          </option>
        @endforeach
      </select>

      <select name="tahun" class="border px-3 py-2 rounded">
        @for($y = now()->year; $y >= 2020; $y--)
          <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Filter
      </button>
    </form>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm">Total Pendapatan</p>
            <p class="text-2xl font-bold">Rp{{ number_format($total_revenue ?? 0, 0, ',', '.') }}</p>
            <p class="text-green-100 text-xs mt-1">
              @if($revenue_change > 0)
                ↗️ +{{ number_format($revenue_change, 1) }}% vs bulan lalu
              @elseif($revenue_change < 0)
                ↘️ {{ number_format($revenue_change, 1) }}% vs bulan lalu
              @else
                ➡️ Sama dengan bulan lalu
              @endif
            </p>
          </div>
          <div class="text-3xl opacity-80">💵</div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-100 text-sm">Jumlah Transaksi</p>
            <p class="text-2xl font-bold">{{ $total_transactions ?? 0 }}</p>
            <p class="text-blue-100 text-xs mt-1">
              Rata-rata: {{ $total_transactions > 0 ? number_format($total_revenue / $total_transactions, 0, ',', '.') : 0 }}/transaksi
            </p>
          </div>
          <div class="text-3xl opacity-80">📊</div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-purple-100 text-sm">Produk Terjual</p>
            <p class="text-2xl font-bold">{{ $total_products_sold ?? 0 }}</p>
            <p class="text-purple-100 text-xs mt-1">Item terjual</p>
          </div>
          <div class="text-3xl opacity-80">📦</div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-orange-100 text-sm">Rata-rata Harian</p>
            <p class="text-2xl font-bold">Rp{{ number_format($avg_daily_revenue ?? 0, 0, ',', '.') }}</p>
            <p class="text-orange-100 text-xs mt-1">Per hari</p>
          </div>
          <div class="text-3xl opacity-80">📅</div>
        </div>
      </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">🏆 Top 3 Produk Terlaris</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($top_products as $index => $product)
        <div class="border rounded-lg p-4 {{ $index == 0 ? 'border-yellow-400 bg-yellow-50' : ($index == 1 ? 'border-gray-400 bg-gray-50' : 'border-orange-400 bg-orange-50') }}">
          <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
              <img src="{{ $product->product->image ? asset('images/' . $product->product->image) : asset('images/no-image.png') }}"
                   alt="{{ $product->product->product_name ?? 'Produk' }}"
                   class="w-12 h-12 object-cover rounded-lg">
            </div>
            <div class="flex-1">
              <p class="font-semibold text-gray-800">{{ $product->product->product_name ?? 'Produk' }}</p>
              <p class="text-sm text-gray-600">{{ $product->total_qty }} terjual</p>
              <p class="text-sm font-semibold text-gray-800">Rp{{ number_format($product->total_revenue, 0, ',', '.') }}</p>
            </div>
            <div class="text-2xl">
              {{ $index == 0 ? '🥇' : ($index == 1 ? '🥈' : '🥉') }}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Chart Sederhana -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">📈 Tren Penjualan Mingguan</h2>
      <div class="flex items-end h-40 space-x-2">
        @foreach($weekly_sales as $week)
        <div class="flex flex-col items-center">
          <div class="bg-blue-500 w-8 rounded-t" style="height: {{ ($week->total / $weekly_sales->max('total')) * 120 }}px"></div>
          <span class="text-xs text-gray-600 mt-1">W{{ $week->week }}</span>
          <span class="text-xs text-gray-500">{{ number_format($week->total/1000, 0) }}K</span>
        </div>
        @endforeach
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
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
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
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-3">
                  <div class="flex-shrink-0">
                    <img src="{{ $sale->product->image ? asset('images/' . $sale->product->image) : asset('images/no-image.png') }}"
                         alt="{{ $sale->product->product_name ?? 'Produk' }}"
                         class="w-10 h-10 object-cover rounded-lg">
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ $sale->product->product_name ?? 'Produk' }}</p>
                    <p class="text-sm text-gray-600">Qty: {{ $sale->qty }}</p>
                  </div>
                </div>
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
            <tr>
              <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada transaksi di bulan ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(isset($sales_history) && method_exists($sales_history, 'links'))
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $sales_history->links() }}
      </div>
      @endif
    </div>
  </main>
</div>
@endsection