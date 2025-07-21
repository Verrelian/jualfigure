@extends('layout.app')

@section('type', ucfirst($manufacture) . ' - Figure Collection Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 py-8 min-h-[75vh]">

    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 md:space-x-4 text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 font-medium transition-colors duration-200">Home</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            </li>
            <li>
                <a href="{{ route('explore') }}" class="hover:text-blue-600 font-medium transition-colors duration-200">Explore</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            </li>
            <li class="text-blue-600 font-semibold">{{ $manufacture }}</li>
        </ol>
    </nav>

    <!-- IMPROVED Header dengan Logo -->
    <div class="text-center mb-10">
        <div class="flex flex-col items-center">
            {{-- Logo Manufacture --}}
            <div class="mb-6 w-28 h-28 md:w-32 md:h-32 rounded-2xl overflow-hidden shadow-xl bg-white p-4 border-4 border-blue-100 hover:border-blue-200 transition-all duration-300">
                <img src="{{ asset($manufactureLogo) }}"
                     alt="{{ $manufacture }} Logo"
                     class="w-full h-full object-contain object-center">
            </div>

            {{-- Nama dan Info --}}
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">{{ $manufacture }}</h1>

            {{-- Deskripsi singkat (opsional) --}}
            @php
            $descriptions = [
                'Bandai' => 'Premium Japanese toy and hobby manufacturer',
                'Banpresto' => 'Popular anime figure and prize collections',
                'Good Smile Company' => 'Creators of Nendoroid and high-quality figures',
                'Kotobukiya' => 'Detailed model kits and premium collectibles',
                'Max Factory' => 'Figma series and articulated action figures',
                'Funko' => 'Pop! vinyl figures and collectibles',
            ];
            @endphp

            @if(isset($descriptions[$manufacture]))
                <p class="text-gray-600 text-lg mt-2 mb-4 max-w-md">{{ $descriptions[$manufacture] }}</p>
                {{-- Stats atau info tambahan --}}
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 bg-gray-50 px-6 py-3 rounded-full">
                    <span class="flex items-center">
                        <i class="fas fa-box mr-2 text-blue-500"></i>
                        {{ $products->total() }} Products
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-star mr-2 text-yellow-500"></i>
                        Premium Quality
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- IMPROVED Filter/Sort Bar --}}
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        {{-- Sort Options --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <span class="text-gray-700 font-semibold text-sm">Sort by:</span>
            <div class="flex flex-wrap gap-2">
                <button onclick="updateSort('latest')"
                        class="sort-btn px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $sort == 'latest' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Latest
                </button>
                <button onclick="updateSort('popular')"
                        class="sort-btn px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $sort == 'popular' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Popular
                </button>
                <button onclick="updateSort('price_low')"
                        class="sort-btn px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $sort == 'price_low' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Price: Low to High
                </button>
                <button onclick="updateSort('price_high')"
                        class="sort-btn px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $sort == 'price_high' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Price: High to Low
                </button>
            </div>
        </div>

        {{-- Results Info --}}
        <div class="flex items-center justify-between lg:justify-end gap-4">
            <div class="text-sm text-gray-500 flex items-center gap-2">
                <i class="fas fa-grid-3x3 text-gray-400"></i>
                <span>Showing {{ $products->firstItem() ?: 0 }}-{{ $products->lastItem() ?: 0 }} of {{ $products->total() }} results</span>
            </div>
            {{-- View Toggle (Optional) --}}
            <div class="hidden md:flex items-center gap-1 bg-gray-100 p-1 rounded-lg">
                <button class="p-2 text-blue-600 bg-white rounded-md shadow-sm">
                    <i class="fas fa-th text-sm"></i>
                </button>
                <button class="p-2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-list text-sm"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- IMPROVED Produk Grid -->
    @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $item)
                <a href="{{ route('product.detail', $item->product_id) }}"
                   class="group border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl bg-white transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1">

                    {{-- Product Image --}}
                    <div class="relative w-full h-48 md:h-56 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                        <img src="{{ asset($item->gambar_url) }}"
                             alt="{{ $item->product_name }}"
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">

                        {{-- Stock Badge --}}
                        @if($item->stock <= 5)
                            <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                Only {{ $item->stock }} left
                            </div>
                        @endif

                        {{-- Wishlist Button --}}
                        <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center hover:bg-white transition-colors">
                                <i class="fas fa-heart text-gray-400 hover:text-red-500 text-sm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4 md:p-5">
                        {{-- Category Badge --}}
                        <div class="mb-2">
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                {{ $manufacture }}
                            </span>
                        </div>

                        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                            {{ $item->product_name }}
                        </h3>

                        <p class="text-xs md:text-sm text-gray-500 mb-3 line-clamp-2">
                            {{ Str::limit($item->description, 60) }}
                        </p>

                        {{-- Price and Rating --}}
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-blue-600 font-bold text-lg md:text-xl">{{ $item->formatted_harga }}</p>
                            @if($item->rating_total > 0)
                                <div class="flex items-center text-yellow-500">
                                    <i class="fas fa-star text-xs"></i>
                                    <span class="text-xs text-gray-600 ml-1 font-medium">{{ $item->rating_total }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">New</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- IMPROVED Pagination -->
        <div class="mt-12 flex justify-center">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2">
                {{ $products->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    @else
        {{-- IMPROVED Empty State --}}
        <div class="text-center text-gray-500 py-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl border-2 border-dashed border-gray-200">
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-white rounded-full shadow-lg p-6 mb-4">
                    <img src="{{ asset($manufactureLogo) }}"
                         alt="{{ $manufacture }}"
                         class="w-full h-full object-contain opacity-50">
                </div>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full mx-auto"></div>
            </div>

            <h3 class="text-2xl font-bold text-gray-700 mb-3">No Products Found</h3>
            <p class="text-gray-500 text-lg mb-8 max-w-md mx-auto">
                Sorry, no products available for <strong class="text-gray-700">{{ $manufacture }}</strong> at the moment.
                Check back soon for new arrivals!
            </p>

            <div class="space-y-4">
                <a href="{{ route('explore') }}"
                   class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl shadow-lg transition-all duration-200 transform hover:scale-105 font-semibold">
                   <i class="fas fa-arrow-left mr-3"></i>
                   Back to Explore
                </a>

                <div class="text-sm text-gray-400">
                    <p>or browse other manufacturers</p>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- JavaScript untuk Sort Function --}}
<script>
function updateSort(sortType) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortType);
    window.location.href = url.toString();
}

function addToCart(productId) {
    // Add your cart logic here
    console.log('Adding product ' + productId + ' to cart');
    // You can implement AJAX call to add to cart
}
</script>

{{-- Custom CSS --}}
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions */
* {
    transition-property: transform, shadow, colors;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Loading skeleton (optional) */
.product-skeleton {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .5; }
}
</style>
@endsection