@extends('layout.app')

@section('type', ucfirst($manufacture) . ' - Figure Collection Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 py-8 min-h-[75vh]">

    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 md:space-x-4 text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 font-medium">Home</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-xs"></i>
            </li>
            <li>
                <a href="{{ route('explore') }}" class="hover:text-blue-600 font-medium">Explore</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-xs"></i>
            </li>
            <li class="text-blue-600 font-semibold">{{ $manufacture }}</li>
        </ol>
    </nav>

    <!-- UPDATED Header dengan Logo -->
    <div class="text-center mb-10">
        <div class="flex flex-col items-center">
            {{-- Logo Manufacture --}}
            <div class="mb-6 w-32 h-32 rounded-full overflow-hidden shadow-lg bg-white p-4">
                <img src="{{ asset($manufactureLogo) }}"
                     alt="{{ $manufacture }} Logo"
                     class="w-full h-full object-contain object-center">
            </div>

            {{-- Nama dan Info --}}
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $manufacture }}</h1>

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
                <p class="text-gray-600 mt-3 max-w-md">{{ $descriptions[$manufacture] }}</p>
            @endif
        </div>
    </div>

    {{-- Filter/Sort Bar --}}
    <div class="flex justify-between items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
        <div class="flex items-center space-x-4">
            <span class="text-gray-600 font-medium">Sort by:</span>
            <select onchange="window.location.href = '?sort=' + this.value"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Popular</option>
                <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>

        <div class="text-sm text-gray-500">
            Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results
        </div>
    </div>

    <!-- Produk Grid -->
    @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $item)
                <a href="{{ route('product.detail', $item->product_id) }}"
                   class="border rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all bg-white transform hover:scale-105">

                    {{-- Product Image --}}
                    <div class="relative w-full h-48 bg-gray-100">
                        <img src="{{ asset($item->gambar_url) }}"
                             alt="{{ $item->product_name }}"
                             class="w-full h-full object-cover object-center">

                        {{-- Stock Badge --}}
                        @if($item->stock <= 5)
                            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                Only {{ $item->stock }} left
                            </div>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4">
                        <h3 class="text-base font-semibold text-gray-800 truncate">{{ $item->product_name }}</h3>
                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($item->description, 50) }}</p>

                        {{-- Price and Rating --}}
                        <div class="flex justify-between items-center mt-3">
                            <p class="text-blue-600 font-bold text-lg">{{ $item->formatted_harga }}</p>
                            @if($item->rating_total > 0)
                                <div class="flex items-center text-yellow-500">
                                    <i class="fas fa-star text-xs"></i>
                                    <span class="text-xs text-gray-600 ml-1">{{ $item->rating_total }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $products->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center text-gray-500 py-20 bg-gray-50 rounded-xl">
            <div class="mb-6">
                <img src="{{ asset($manufactureLogo) }}"
                     alt="{{ $manufacture }}"
                     class="w-24 h-24 object-contain mx-auto opacity-50">
            </div>
            <p class="text-xl font-semibold text-gray-700">No Products Found</p>
            <p class="text-gray-500 mt-2">Sorry, no products available for <strong>{{ $manufacture }}</strong> at the moment.</p>
            <a href="{{ route('explore') }}"
               class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg transition-all transform hover:scale-105">
               <i class="fas fa-arrow-left mr-2"></i>Back to Explore
            </a>
        </div>
    @endif
</div>
@endsection