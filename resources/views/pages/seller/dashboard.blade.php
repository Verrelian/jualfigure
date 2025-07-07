@extends('layout.apps')

@section('content')
<div class="flex w-full h-screen overflow-hidden">
  @include('component.seller.sidebar')

  <!-- Main Content -->
  <main class="flex-1 bg-gray-50 p-6 overflow-y-auto">

    <!-- Greeting Section -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white p-6 rounded-xl shadow-lg mb-6 flex items-center justify-between relative overflow-hidden">
      <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
      <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12"></div>
      <div class="relative z-10">
        <h2 class="text-3xl font-bold">Halo, {{ session('user')->name ?? session('user')->username }}! 🎯</h2>
        <p class="text-blue-100 mt-2">Action Figure Store Dashboard - Pantau performa toko Anda</p>
      </div>
      <div class="relative z-10">
        <img src="{{ session('user')->avatar ? asset('storage/' . session('user')->avatar) : asset('images/muka.jpg') }}"
             alt="Avatar" class="w-20 h-20 rounded-full border-4 border-white shadow-xl">
      </div>
    </div>
{{-- Debug Data --}}
<pre>
  Revenue: @json($revenueStats)
  Product: @json($productPerformance)
  Target: @json($targetProgress)
</pre>
    <!-- Revenue & Performance Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <!-- Revenue Today -->
      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border-l-4 border-green-500">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500 font-medium">Revenue Hari Ini</p>
            <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($revenueStats['revenue_today'], 0, ',', '.') }}</p>
            <p class="text-xs {{ $revenueStats['revenue_today_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
              {{ $revenueStats['revenue_today_change'] >= 0 ? '+' : '' }}{{ $revenueStats['revenue_today_change'] }}% dari kemarin
            </p>
          </div>
        </div>
      </div>

      <!-- Revenue This Month -->
      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border-l-4 border-blue-500">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500 font-medium">Revenue Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($revenueStats['revenue_month'], 0, ',', '.') }}</p>
            <p class="text-xs {{ $revenueStats['revenue_month_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
              {{ $revenueStats['revenue_month_change'] >= 0 ? '+' : '' }}{{ $revenueStats['revenue_month_change'] }}% dari bulan lalu
            </p>
          </div>
        </div>
      </div>

      <!-- Total Products -->
      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border-l-4 border-purple-500">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500 font-medium">Total Produk</p>
            <p class="text-2xl font-bold text-gray-800">{{ $revenueStats['total_products'] }}</p>
            <p class="text-xs text-blue-600">{{ $revenueStats['active_products'] }} produk aktif</p>
          </div>
        </div>
      </div>

      <!-- Average Rating -->
      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border-l-4 border-yellow-500">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-lg">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500 font-medium">Rating Rata-rata</p>
            <p class="text-2xl font-bold text-gray-800">{{ $productPerformance['average_rating'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">{{ $ratingOverview['total_rated_products'] }} produk dirating</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Target Progress -->
    <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Target Penjualan Bulan Ini</h3>
        <span class="text-sm text-gray-500">{{ $targetProgress['progress_percentage'] }}% tercapai</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
        <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full shadow-sm"
             style="width: {{ min($targetProgress['progress_percentage'], 100) }}%"></div>
      </div>
      <div class="flex justify-between items-center">
        <div>
          <p class="text-sm text-gray-600">Rp{{ number_format($targetProgress['current_revenue'], 0, ',', '.') }} dari Rp{{ number_format($targetProgress['target_revenue'], 0, ',', '.') }}</p>
          <p class="text-xs text-gray-500">Sisa {{ $targetProgress['days_left'] }} hari lagi</p>
        </div>
        <div class="text-right">
          <p class="text-sm font-semibold text-green-600">Rp{{ number_format($targetProgress['remaining_amount'], 0, ',', '.') }} lagi</p>
          <p class="text-xs text-gray-500">untuk mencapai target</p>
        </div>
      </div>
    </div>

    <!-- Low Stock Alert -->
    @if($lowStockProducts->count() > 0)
    <div class="bg-gradient-to-r from-red-400 to-pink-400 text-white p-6 rounded-xl shadow-lg mb-6">
      <div class="flex items-center mb-4">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
        <div>
          <h3 class="text-lg font-semibold">Peringatan Stock Menipis! ⚠️</h3>
          <p class="text-sm opacity-90">{{ $lowStockProducts->count() }} produk memerlukan restok segera</p>
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($lowStockProducts as $product)
        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-3 text-center">
          <img src="{{ $product['image'] ? asset('images/' . $product['image']) : asset('images/default-product.jpg') }}"
               alt="{{ $product['product_name'] }}"
               class="w-16 h-16 mx-auto mb-2 object-cover rounded-lg">
          <p class="text-xs font-medium truncate mb-1">{{ $product['product_name'] }}</p>
          <p class="text-xs opacity-75">Sisa: {{ $product['stock'] }} unit</p>
          <span class="inline-block px-2 py-1 text-xs bg-red-500 text-white rounded-full mt-1">
            {{ $product['urgency'] == 'critical' ? 'KRITIS' : 'PERLU RESTOK' }}
          </span>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Bottom Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Rating Overview -->
      <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-800">Rating Produk</h3>
          <span class="text-sm text-gray-500">{{ $ratingOverview['total_rated_products'] }} produk</span>
        </div>

        <div class="space-y-3 mb-4">
          @for($i = 5; $i >= 1; $i--)
          <div class="flex items-center">
            <span class="w-8 text-sm">{{ $i }}⭐</span>
            <div class="flex-1 mx-3 bg-gray-200 rounded-full h-2">
              <div class="bg-yellow-400 h-2 rounded-full"
                   style="width: {{ $ratingOverview['total_rated_products'] > 0 ? ($ratingOverview['rating_distribution'][$i] / $ratingOverview['total_rated_products']) * 100 : 0 }}%"></div>
            </div>
            <span class="text-xs text-gray-500 w-8">{{ $ratingOverview['rating_distribution'][$i] }}</span>
          </div>
          @endfor
        </div>

        @if($ratingOverview['low_rating_products']->count() > 0)
        <div class="border-t pt-4">
          <p class="text-sm font-medium text-red-600 mb-2">Produk dengan Rating Rendah:</p>
          @foreach($ratingOverview['low_rating_products'] as $product)
          <div class="flex items-center justify-between p-2 bg-red-50 rounded mb-2">
            <div class="flex items-center">
              <img src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default-product.jpg') }}"
                   alt="{{ $product->product_name }}" class="w-8 h-8 rounded object-cover mr-2">
              <span class="text-sm">{{ $product->product_name }}</span>
            </div>
            <span class="text-sm text-red-600">{{ $product->rating_total }}⭐</span>
          </div>
          @endforeach
        </div>
        @endif
      </div>

      <!-- Monthly Performance -->
      <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-800">Performance 6 Bulan Terakhir</h3>
          <span class="text-sm text-gray-500">Revenue</span>
        </div>

        <div class="space-y-3">
          @foreach($monthlyPerformance as $month)
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">{{ $month['month'] }}</span>
            <div class="flex items-center">
              <div class="w-32 mx-3 bg-gray-200 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full"
                     style="width: {{ $month['revenue'] > 0 ? min(($month['revenue'] / max(collect($monthlyPerformance)->pluck('revenue')->max(), 1)) * 100, 100) : 0 }}%"></div>
              </div>
              <span class="text-xs text-gray-500 w-20 text-right">
                Rp{{ number_format($month['revenue'], 0, ',', '.') }}
              </span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script>
      function logout() {
        localStorage.removeItem('currentUser');
        window.location.href = '/mole/login';
      }

      // Animation for stats cards
      document.addEventListener('DOMContentLoaded', function() {
        const statsElements = document.querySelectorAll('.text-2xl');
        statsElements.forEach((element, index) => {
          element.style.opacity = '0';
          element.style.transform = 'translateY(20px)';
          setTimeout(() => {
            element.style.transition = 'all 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
          }, index * 100);
        });
      });
    </script>
  </main>
</div>
@endsection