@extends('layout.app')

@section('type', 'Explore - Figure Collection Store')

@section('content')
    <!-- Search & Filter Bar -->
    <div id="explore-root" data-fetch-url="{{ route('products.by-category') }}">
    <div class="bg-white p-6 rounded-lg shadow-md mb-8 mt-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="search-input" placeholder="Search figures, characters, series..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <div class="flex gap-3">
                <select id="category-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option value="nendoroid" {{ $initialCategory == 'nendoroid' ? 'selected' : '' }}>Nendoroid</option>
                    <option value="popup" {{ $initialCategory == 'popup' ? 'selected' : '' }}>Pop Up Parade</option>
                    <option value="hottoys" {{ $initialCategory == 'hottoys' ? 'selected' : '' }}>Hot Toys</option>
                </select>
                <select id="price-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Price: All</option>
                    <option value="0-30">Under $30</option>
                    <option value="30-60">$30 - $60</option>
                    <option value="60-999">$60+</option>
                </select>
                <button id="apply-filters" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">Explore</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Explore Header with Stats -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Explore Collections</h1>
            <p class="text-gray-600">Discover amazing figures from your favorite series</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Showing <span id="product-count">{{ count($products) }}</span>+ figures</p>
            <p class="text-sm text-gray-500">across 15+ categories</p>
        </div>
    </div>

    <!-- Featured Banner -->
    <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg p-8 mb-10 text-white">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">🎉 Limited Edition Drop!</h2>
                <p class="text-lg opacity-90">Exclusive figures available now</p>
                <p class="text-sm opacity-75">Only 48 hours left!</p>
            </div>
            <button class="mt-4 md:mt-0 bg-white text-purple-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition-colors">
                Shop Limited Edition
            </button>
        </div>
    </div>

    <!-- Category Cards -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Browse by Category</h2>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View All Categories</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Nendoroid Category -->
            <div class="category-card relative rounded-lg overflow-hidden shadow-lg bg-gray-800 group cursor-pointer transform hover:scale-105 transition-transform {{ $initialCategory == 'nendoroid' ? 'ring-4 ring-blue-500' : '' }}"
                 data-category="nendoroid">
                <div class="aspect-[4/3] w-full">
                    <img src="{{ asset('images/p6.jpg') }}" alt="Nendoroid" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/60 to-transparent text-white p-4">
                    <h3 class="font-bold text-lg mb-1">Nendoroid</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm">Popular</span>
                            <span class="ml-1 text-yellow-500">★★★★★</span>
                        </div>
                        <span class="text-sm bg-red-500 px-2 py-1 rounded-full">150+ items</span>
                    </div>
                    <p class="text-xs mt-2 opacity-80">Cute chibi-style collectibles</p>
                </div>
            </div>

            <!-- Pop Up Parade Category -->
            <div class="category-card relative rounded-lg overflow-hidden shadow-lg bg-gray-800 group cursor-pointer transform hover:scale-105 transition-transform {{ $initialCategory == 'popup' ? 'ring-4 ring-blue-500' : '' }}"
                 data-category="popup">
                <img src="{{ asset('images/p3.png') }}" alt="Pop Up Parade" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/60 to-transparent text-white p-4">
                    <h3 class="font-bold text-lg mb-1">Pop Up Parade</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm">Trending</span>
                            <span class="ml-1 text-green-500">🔥</span>
                        </div>
                        <span class="text-sm bg-blue-500 px-2 py-1 rounded-full">80+ items</span>
                    </div>
                    <p class="text-xs mt-2 opacity-80">Affordable premium figures</p>
                </div>
            </div>

            <!-- Hot Toys Category -->
            <div class="category-card relative rounded-lg overflow-hidden shadow-lg bg-gray-800 group cursor-pointer transform hover:scale-105 transition-transform {{ $initialCategory == 'hottoys' ? 'ring-4 ring-blue-500' : '' }}"
                 data-category="hottoys">
                <img src="{{ asset('images/figure4.jpg') }}" alt="Hot Toys" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/60 to-transparent text-white p-4">
                    <h3 class="font-bold text-lg mb-1">Hot Toys</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm">Premium</span>
                            <span class="ml-1 text-yellow-500">👑</span>
                        </div>
                        <span class="text-sm bg-purple-500 px-2 py-1 rounded-full">45+ items</span>
                    </div>
                    <p class="text-xs mt-2 opacity-80">Ultra-detailed collectibles</p>
                </div>
            </div>
        </div>
    </div>
        <!-- Loading Indicator -->
    <div id="loading-indicator" class="hidden text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
        <p class="mt-2 text-gray-600">Loading products...</p>
    </div>

    <!-- Products Section -->
    <div class="bg-gray-200 p-4 rounded-md mb-7">
        <h2 class="text-lg font-bold mb-3" id="products-title">
            {{ $categories[$initialCategory] ?? 'All Products' }}
        </h2>
        <div id="products-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $product)
                @include('component.product-card', [
                    'product_id' => $product->product_od,
                    'image' => $product->gambar_url,
                    'type' => $product->type,
                    'title' => $product->nama,
                    'price' => $product->formatted_harga ?? '$' . number_format($product->harga, 2)
                ])
            @endforeach
        </div>

        <!-- No Products Message -->
        <div id="no-products" class="hidden text-center py-8">
            <p class="text-gray-600">No products found matching your criteria.</p>
            <button id="clear-filters" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Trending This Week -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold">📈 Trending This Week</h2>
                <p class="text-gray-600 text-sm">Most viewed and purchased figures</p>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View All Trending</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @for($i = 1; $i <= 5; $i++)
            <div class="relative group">
                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full z-10">
                    #{{ $i }}
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Popular Collections -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold">🌟 Popular Collections</h2>
                <p class="text-gray-600 text-sm">Shop by your favorite anime & game series</p>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Browse All Series</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        </div>
    </div>

    <!-- Price Range Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-green-100 p-6 rounded-lg text-center border border-green-200">
            <i class="fas fa-dollar-sign text-3xl text-green-600 mb-3"></i>
            <h3 class="font-bold text-lg mb-2">Budget Friendly</h3>
            <p class="text-green-700 mb-4">Under $30</p>
            <button class="price-range-btn bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors" data-range="0-30">
                Shop Now
            </button>
        </div>
        <div class="bg-blue-100 p-6 rounded-lg text-center border border-blue-200">
            <i class="fas fa-star text-3xl text-blue-600 mb-3"></i>
            <h3 class="font-bold text-lg mb-2">Premium Quality</h3>
            <p class="text-blue-700 mb-4">$30 - $80</p>
            <button class="price-range-btn bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors" data-range="30-80">
                Explore
            </button>
        </div>
        <div class="bg-purple-100 p-6 rounded-lg text-center border border-purple-200">
            <i class="fas fa-crown text-3xl text-purple-600 mb-3"></i>
            <h3 class="font-bold text-lg mb-2">Luxury Collection</h3>
            <p class="text-purple-700 mb-4">$80+</p>
            <button class="price-range-btn bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors" data-range="80-999">
                View All
            </button>
        </div>
    </div>

    <!-- New Releases -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold">🆕 Latest Arrivals</h2>
                <p class="text-gray-600 text-sm">Fresh from Japan - Just landed!</p>
            </div>
            <div class="flex gap-3">
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option>All New</option>
                    <option>This Week</option>
                    <option>This Month</option>
                </select>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View All New</a>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-gray-50 p-6 rounded-lg mb-10">
        <h3 class="text-lg font-bold mb-4 text-center">Quick Navigation</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
            <a href="#" class="text-center p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fas fa-fire text-red-500 mb-2"></i>
                <p class="text-sm font-medium">Hot Deals</p>
            </a>
            <a href="#" class="text-center p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fas fa-clock text-blue-500 mb-2"></i>
                <p class="text-sm font-medium">Pre-Orders</p>
            </a>
            <a href="#" class="text-center p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fas fa-star text-yellow-500 mb-2"></i>
                <p class="text-sm font-medium">Top Rated</p>
            </a>
            <a href="#" class="text-center p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fas fa-percentage text-green-500 mb-2"></i>
                <p class="text-sm font-medium">On Sale</p>
            </a>
            <a href="#" class="text-center p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fas fa-gift text-purple-500 mb-2"></i>
                <p class="text-sm font-medium">Gift Cards</p>
            </a>
            <a href="#" class="text-center p-3 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fas fa-headset text-indigo-500 mb-2"></i>
                <p class="text-sm font-medium">Support</p>
            </a>
        </div>
    </div>
<script src="{{ asset('js/explore.js') }}"></script>

@endsection