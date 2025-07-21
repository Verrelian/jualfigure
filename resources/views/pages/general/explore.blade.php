@extends('layout.app')

@section('type', 'Explore - Figure Collection Store')

@section('content')
    <!-- Search & Filter Bar -->
    <div id="explore-root" data-fetch-url="{{ route('products.by-category') }}">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 mt-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">

                {{-- ✅ Search Form dengan fungsi working --}}
                <form action="{{ route('search') }}" method="GET" class="flex-1 max-w-md w-full">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search_keyword" id="search-input" placeholder="Search figures, characters, series..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                            required />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Home</a>
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
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nendoroid Category -->
                <a href="{{ route('category.results', 'nendoroid') }}"
                class="category-card relative rounded-lg overflow-hidden shadow-lg bg-gray-800 group cursor-pointer transform hover:scale-105 transition-transform">
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
                            {{-- UBAH BAGIAN INI --}}
                            <span class="text-sm bg-red-500 px-2 py-1 rounded-full">{{ $categoryCounts['nendoroid'] ?? 0 }}+ items</span>
                        </div>
                        <p class="text-xs mt-2 opacity-80">Cute chibi-style collectibles</p>
                    </div>
                </a>

                <!-- Pop Up Parade Category -->
                <a href="{{ route('category.results', 'popup') }}"
                class="category-card relative rounded-lg overflow-hidden shadow-lg bg-gray-800 group cursor-pointer transform hover:scale-105 transition-transform">
                    <img src="{{ asset('images/p3.png') }}" alt="Pop Up Parade" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/60 to-transparent text-white p-4">
                        <h3 class="font-bold text-lg mb-1">Pop Up Parade</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-sm">Trending</span>
                                <span class="ml-1 text-green-500">🔥</span>
                            </div>
                            {{-- UBAH BAGIAN INI --}}
                            <span class="text-sm bg-blue-500 px-2 py-1 rounded-full">{{ $categoryCounts['popup'] ?? 0 }}+ items</span>
                        </div>
                        <p class="text-xs mt-2 opacity-80">Affordable premium figures</p>
                    </div>
                </a>

                <!-- Hot Toys Category -->
                <a href="{{ route('category.results', 'hottoys') }}"
                class="category-card relative rounded-lg overflow-hidden shadow-lg bg-gray-800 group cursor-pointer transform hover:scale-105 transition-transform">
                    <img src="{{ asset('images/figure4.jpg') }}" alt="Hot Toys" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/60 to-transparent text-white p-4">
                        <h3 class="font-bold text-lg mb-1">Hot Toys</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-sm">Premium</span>
                                <span class="ml-1 text-yellow-500">👑</span>
                            </div>
                            {{-- UBAH BAGIAN INI --}}
                            <span class="text-sm bg-purple-500 px-2 py-1 rounded-full">{{ $categoryCounts['hottoys'] ?? 0 }}+ items</span>
                        </div>
                        <p class="text-xs mt-2 opacity-80">Ultra-detailed collectibles</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- No Products Message -->
        <div id="no-products" class="hidden text-center py-8">
            <p class="text-gray-600">No products found matching your criteria.</p>
            <button id="clear-filters" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Clear Filters
            </button>
        </div>

                {{-- PERUBAHAN 2: Update Browse by Manufacture dengan count dinamis --}}
                @php
                $brands = [
                    [
                        'name' => 'Bandai',
                        'image' => 'images/brands/bandai.jpg',
                        'tag' => 'Popular',
                        'color' => 'red'
                    ],
                    [
                        'name' => 'Banpresto',
                        'image' => 'images/brands/banpresto.jpg',
                        'tag' => 'Trending',
                        'color' => 'blue'
                    ],
                    [
                        'name' => 'Good Smile Company',
                        'image' => 'images/brands/goodsmile.png',
                        'tag' => 'Premium',
                        'color' => 'purple'
                    ],
                    [
                        'name' => 'Kotobukiya',
                        'image' => 'images/brands/kotobukiya.png',
                        'tag' => 'Limited',
                        'color' => 'green'
                    ],
                    [
                        'name' => 'Max Factory',
                        'image' => 'images/brands/max-factory.png',
                        'tag' => 'Classic',
                        'color' => 'yellow'
                    ],
                    [
                        'name' => 'Funko',
                        'image' => 'images/brands/funko.jpg',
                        'tag' => 'Cute',
                        'color' => 'pink'
                    ]
                ];
                @endphp

                <h3 class="text-xl font-semibold mt-10 mb-4">Browse by Manufacture</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($brands as $brand)
                        <a href="{{ route('explore.manufacture', ['manufacture' => urlencode($brand['name'])]) }}"
                        class="relative rounded-xl overflow-hidden shadow group transition hover:shadow-lg bg-white">

                            <!-- Gambar -->
                            <img src="{{ asset($brand['image']) }}"
                                alt="{{ $brand['name'] }}"
                                class="w-full h-52 object-cover object-center group-hover:scale-105 transition duration-300">

                            <!-- Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                <h4 class="text-white text-lg font-bold">{{ $brand['name'] }}</h4>
                                <p class="text-sm text-white/90">{{ $brand['tag'] }}</p>
                                {{-- UBAH BAGIAN INI --}}
                                <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full bg-{{ $brand['color'] }}-600 text-white">
                                    {{ $manufactureCounts[$brand['name']] ?? 0 }}+ items
                                </span>
                            </div>
                        </a>
                    @endforeach
            </div>
@endsection

{{-- BUAT SECTION SCRIPTS TERPISAH --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryCards = document.querySelectorAll('.category-card');

        categoryCards.forEach(card => {
            card.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Update visual state
                categoryCards.forEach(c => c.classList.remove('ring-4', 'ring-blue-500'));
                this.classList.add('ring-4', 'ring-blue-500');

                // Redirect ke route explore dengan parameter category
                window.location.href = `{{ route('explore') }}?category=${category}`;
            });
        });

        // Price range buttons (yang sudah ada tetap sama)
        const priceButtons = document.querySelectorAll('.price-range-btn');
        priceButtons.forEach(button => {
            button.addEventListener('click', function() {
                const range = this.getAttribute('data-range');
                const currentCategory = new URLSearchParams(window.location.search).get('category') || 'nendoroid';
                window.location.href = `{{ route('explore') }}?category=${currentCategory}&price_range=${range}`;
            });
        });
    });
</script>
@endsection