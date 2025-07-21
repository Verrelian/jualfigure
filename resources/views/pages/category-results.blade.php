@extends('layout.app')

@section('type', ucfirst($category) . ' - Figure Collection Store')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('explore') }}" class="text-gray-700 hover:text-blue-600">Explore</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">{{ $categoryName }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $categoryName }} Collection</h1>
            <p class="text-gray-600">Showing {{ $totalProducts }} figures in this category</p>
        </div>
        <div class="flex gap-3">
            <form method="GET" class="flex gap-3 items-center">
                <input type="hidden" name="category" value="{{ $category }}">
                <select name="sort" class="px-4 py-2 border border-gray-300 rounded-lg" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sort by Latest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <div class="aspect-square w-full overflow-hidden">
                <img src="{{ asset($product->gambar_url) }}" alt="{{ $product->product_name }}"
                class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-2 line-clamp-2">{{ $product->product_name }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $product->type }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-blue-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                </div>
                <a href="{{ route('product.detail', $product->product_id) }}"
                   class="mt-3 w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                    View Details
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Products Found</h3>
            <p class="text-gray-500">Sorry, no products available in this category at the moment.</p>
            <a href="{{ route('explore') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Back to Explore
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-12">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection