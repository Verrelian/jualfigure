@extends('layout.app')

@section('title', $product['title'] . ' - Figure Collection Store')

@section('content')

<div class="container mx-auto p-4">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Home</a>
        <span>/</span>
        <a href="{{ route('explore') }}" class="hover:text-gray-900 transition-colors">Products</a>
        <span>/</span>
        <span class="text-gray-900">{{ $product['title'] }}</span>
    </nav>

        <!-- Product Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Image -->
            <div class="relative">
                <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden group">
                    <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}"
                        class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105"
                        onerror="this.src='https://via.placeholder.com/600x600/f8fafc/94a3b8?text=No+Image'">
                </div>

                <!-- Thumbnail Gallery (if you have multiple images) -->
                <div class="flex space-x-2 mt-4">
                    <div class="w-16 h-16 bg-gray-50 rounded-md border-2 border-gray-300 flex items-center justify-center">
                        <img src="{{ asset($product['image']) }}" alt="Thumbnail"
                            class="w-full h-full object-contain rounded-sm">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="lg:pl-8">
                <!-- Product Category -->
                <div class="flex items-center space-x-3 mb-4">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $product['type'] }}</span>
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <span class="text-xs text-gray-500 ml-1">4.8</span>
                    </div>
                </div>

                <!-- Product Title -->
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $product['title'] }}
                </h1>

                <!-- Price -->
                <div class="flex items-center space-x-3 mb-8">
                    <span class="text-2xl font-bold text-gray-900">{{ $product['price'] }}</span>
                    <span class="text-sm text-gray-500 line-through">Rp 1.200.000</span>
                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Save 15%</span>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">{{ $product['description'] }}</p>
                </div>

                <!-- Specifications -->
                <div class="mb-8">
                    <h3 class="font-semibold text-gray-900 mb-4">Specifications</h3>
                    <div class="space-y-3">
                        @foreach($product['specifications'] as $key => $value)
                            <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                                <span class="text-sm text-gray-600">{{ $key }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quantity & Actions -->
                <div class="space-y-6">
                    <!-- Quantity Selector -->
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-900">Quantity</label>
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button id="decrementQuantity" class="px-3 py-1 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" id="quantity" name="quantity" min="1" value="1"
                                class="w-16 text-center py-1 border-0 focus:ring-0 text-sm">
                            <button id="incrementQuantity" class="px-3 py-1 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-gray-500">25 in stock</span>
                    </div>

                    <!-- Action Buttons -->
                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('checkout.form', $product['product_id']) }}"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-center text-white py-3 px-6 rounded-md font-medium transition-colors">
                            Buy Now
                        </a>
                        <button id="wishlistBtn"
                                class="border border-gray-300 hover:border-gray-400 p-3 rounded-md transition-colors group"
                                data-product-id="{{ $product['product_id'] }}"
                                title="Add to Wishlist">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-red-500 transition-colors"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <!-- Trust Indicators -->
                    <div class="flex items-center space-x-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs text-gray-600">Authentic</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-xs text-gray-600">Fast Shipping</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            <span class="text-xs text-gray-600">1 Year Warranty</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="lg:pl-8">


            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="group">
                        <a href="{{ route('product.detail', $relatedProduct['product_id']) }}">
                            <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden mb-3">
                                <img src="{{ asset($relatedProduct['image']) }}" alt="{{ $relatedProduct['title'] }}"
                                    class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                                    onerror="this.src='https://via.placeholder.com/300x300/f8fafc/94a3b8?text=No+Image'">
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $relatedProduct['type'] }}</p>
                                <h3 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $relatedProduct['title'] }}
                                </h3>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-gray-900">{{ $relatedProduct['price'] }}</span>
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
<!-- DEBUG LOGIN STATUS -->
<script>
console.log('=== DEBUG LOGIN STATUS ===');
console.log('User ID:', @json(session('user_id')));
console.log('Role:', @json(session('role')));
console.log('Is Logged In:', @json(session('user_id') ? true : false));
console.log('All Session:', @json(session()->all()));
console.log('===============================');
</script>
    <script src="{{ asset('js/product-detail.js') }}"></script>
@endsection