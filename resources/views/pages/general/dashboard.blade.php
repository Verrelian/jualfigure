@extends('layout.app')

@section('title', 'Home Page | Marketplace of Legends')
@section('banner')
    <img src="{{ asset('images/banner3.jpg') }}" alt="Dashboard Banner" class="absolute inset-0 w-full h-full object-cover z-0">
@endsection
@section('content')
<div class="px-4 md:px-8 lg:px-12">
    @php
        $trendingProducts = App\Models\Produk::inRandomOrder()->inStock()->take(6)->get();
        $regularProducts = App\Models\Produk::inRandomOrder()->inStock()->take(8)->get();
        $newProducts = App\Models\Produk::latest()->inStock()->take(4)->get();
    @endphp

    <!-- Categories Section -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center">
            <i class="fas fa-robot text-3xl text-blue-600 mb-3"></i>
            <h3 class="font-semibold text-gray-800">Action Figures</h3>
            <p class="text-sm text-gray-600 mt-1">Premium collectibles</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center">
            <i class="fas fa-heart text-3xl text-pink-600 mb-3"></i>
            <h3 class="font-semibold text-gray-800">Anime Figures</h3>
            <p class="text-sm text-gray-600 mt-1">Limited edition</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center">
            <i class="fas fa-star text-3xl text-yellow-600 mb-3"></i>
            <h3 class="font-semibold text-gray-800">Exclusive</h3>
            <p class="text-sm text-gray-600 mt-1">Rare collections</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow text-center">
            <i class="fas fa-fire text-3xl text-red-600 mb-3"></i>
            <h3 class="font-semibold text-gray-800">Hot Deals</h3>
            <p class="text-sm text-gray-600 mt-1">Special offers</p>
        </div>
    </div>
    <!-- Search Banner -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg p-8 mb-12 text-white">
            <form action="{{ route('search') }}" method="GET">
            <input type="hidden" name="source" value="dashboard"> {{-- Tambahkan ini --}}
            <h2 class="text-2xl font-bold mb-4">Cari Produk Favoritmu</h2>

            <div class="flex flex-col md:flex-row items-center gap-4">
                {{-- Input --}}
                <div class="relative w-full md:flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" name="search_keyword" required
                        class="w-full py-3 pl-10 pr-4 rounded-lg text-gray-900 focus:outline-none"
                        placeholder="Cari produk, pelanggan, pesanan..." />
                </div>

                {{-- Tombol --}}
                <button type="submit"
                    class="bg-white text-purple-600 font-bold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Trending Products -->
    <div class="bg-white p-6 md:p-8 rounded-lg mb-12 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">🔥 Trending Now</h2>
        </div>
        <div class="flex space-x-4 md:space-x-6 overflow-x-auto scrollbar-hide pb-2">
            @foreach($trendingProducts as $product)
                <div class="flex-shrink-0 w-36 md:w-44 lg:w-52">
                    @include('component.product-ranking', [
                        'product_id' => $product->product_id,
                        'image' => $product->image,
                        'type' => $product->type,
                        'title' => $product->name,
                        'price' => $product->formatted_harga,
                        'rating' => $product->rating_total
                    ])
                </div>
            @endforeach
        </div>
    </div>

    <!-- New Arrivals -->
    <div class="bg-white p-6 md:p-8 rounded-lg mb-12 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">✨ New Arrivals</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($newProducts as $product)
                <div class="bg-gray-50 rounded-lg p-4">
                    @include('component.product-card', [
                        'product_id' => $product->product_id,
                        'image' => $product->image,
                        'type' => $product->type,
                        'title' => $product->nama,
                        'price' => $product->formatted_harga
                    ])
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Products Grid -->
    <div class="bg-white p-6 md:p-8 rounded-lg mb-12 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">🌟 Featured Collection</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($regularProducts as $product)
                <div>
                    @include('component.product-card', [
                        'product_id' => $product->product_id,
                        'image' => $product->image,
                        'type' => $product->type,
                        'title' => $product->nama,
                        'price' => $product->formatted_harga
                    ])
                </div>
            @endforeach
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="text-center p-6">
            <i class="fas fa-shipping-fast text-4xl text-green-600 mb-4"></i>
            <h3 class="text-lg font-semibold mb-2">Free Shipping</h3>
            <p class="text-gray-600">Free delivery on orders over $50</p>
        </div>
        <div class="text-center p-6">
            <i class="fas fa-shield-alt text-4xl text-blue-600 mb-4"></i>
            <h3 class="text-lg font-semibold mb-2">Secure Payment</h3>
            <p class="text-gray-600">100% secure payment protection</p>
        </div>
        <div class="text-center p-6">
            <i class="fas fa-undo text-4xl text-orange-600 mb-4"></i>
            <h3 class="text-lg font-semibold mb-2">Easy Returns</h3>
            <p class="text-gray-600">30-day return guarantee</p>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="bg-gray-800 text-white rounded-lg p-8 mb-12">
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Stay Updated!</h2>
            <p class="mb-6 opacity-90">Get the latest news about new arrivals and exclusive deals</p>
            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg text-gray-800">
                <button
                    onclick="alert('Terima kasih! Email kamu sudah tercatat untuk newsletter.')"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold transition-colors">
                    Subscribe
                </button>

            </div>
        </div>
    </div>
</div>
@endsection