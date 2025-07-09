@extends('layout.app')

@section('title', $product['title'] . ' - Figure Collection Store')

@section('content')
<div class="container mx-auto p-4">
    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Home</a>
        <span>/</span>
        <a href="{{ route('explore') }}" class="hover:text-gray-900 transition-colors">Products</a>
        <span>/</span>
        <span class="text-gray-900">{{ $product['title'] }}</span>
    </nav>

    {{-- Product Detail Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        {{-- Product Image --}}
        <div class="relative">
            <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden group">
                <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}"
                    class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105"
                    onerror="this.src='https://via.placeholder.com/600x600/f8fafc/94a3b8?text=No+Image'">
            </div>

            {{-- Thumbnail --}}
            <div class="flex space-x-2 mt-4">
                <div class="w-16 h-16 bg-gray-50 border-2 border-gray-300 rounded-md flex items-center justify-center">
                    <img src="{{ asset($product['image']) }}" alt="Thumbnail"
                        class="w-full h-full object-contain rounded-sm">
                </div>
            </div>
        </div>

        {{-- Product Info --}}
        <div class="lg:pl-8">
            {{-- Category and Rating --}}
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $product['type'] }}</span>
            </div>

            {{-- Star Rating --}}
            @php
                $rating = $product['rating_total'] ?? 0;
                $fullStars = floor($rating);
                $hasHalfStar = ($rating - $fullStars) >= 0.25 && ($rating - $fullStars) < 0.75;
                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
            @endphp
            <div class="mb-4 flex items-center gap-0.5 text-yellow-400 text-lg">
                @for ($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i> @endfor
                @if ($hasHalfStar) <i class="fas fa-star-half-alt"></i> @endif
                @for ($i = 0; $i < $emptyStars; $i++) <i class="far fa-star"></i> @endfor
                <span class="ml-1 text-gray-600 text-xs">({{ number_format($rating, 1) }})</span>
            </div>

        <!-- Product Title -->
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6 leading-tight">
            {{ $product['title'] }}
        </h1>

        <!-- Price -->
        <div class="flex items-center space-x-3 mb-4">
            <span class="text-2xl font-bold text-gray-900">{{ $product['price'] }}</span>
        </div>

        <!-- Stock -->
        <div class="mb-4">
            <p class="text-gray-600 leading-relaxed">Stock: {{ $product['stock'] }}</p>
        </div>

        <!-- Description -->
        <div class="mb-8">
            <p class="text-gray-600 leading-relaxed">{{ $product['description'] }}</p>
        </div>

        {{-- Specifications --}}
        <div class="mb-8">
            <h3 class="font-semibold text-gray-900 mb-4">Specifications</h3>
            <div class="space-y-3">
                @foreach($product['specifications'] as $key => $value)
                <div class="flex justify-between border-b py-2">
                    <span class="text-sm text-gray-600">{{ $key }}</span>
                    <span class="text-sm font-medium text-gray-900">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>

            {{-- Quantity & Action --}}
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-900">Quantity</label>
                    <div class="flex items-center border border-gray-300 rounded-md">
                        <button id="decrementQuantity" class="px-3 py-1 hover:bg-gray-50">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" id="quantity" value="1" min="1"
                            class="w-16 text-center py-1 border-0 focus:ring-0 text-sm">
                        <button id="incrementQuantity" class="px-3 py-1 hover:bg-gray-50">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <span class="text-sm text-gray-500">{{ $product['stock'] }} in stock</span>
                </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <!-- Add to Cart Button -->
            <button id="addToCartBtn"
                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-md font-medium transition-colors flex items-center justify-center space-x-2"
                data-product-id="{{ $product['product_id'] }}"
                data-product-name="{{ $product['title'] }}"
                data-product-price="{{ str_replace(['Rp ', '.'], ['', ''], $product['price']) }}"
                data-product-image="{{ $product['image'] }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h10a1 1 0 001-1v-6M9 19v2m6-2v2" />
                </svg>
                <span>Add to Cart</span>
            </button>

            <!-- Buy Now Button -->
            <a href="{{ route('checkout.form', $product['product_id']) }}"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-center text-white py-3 px-6 rounded-md font-medium transition-colors flex items-center justify-center">
                Buy Now
            </a>

            <!-- Wishlist Button -->
            <button id="wishlistBtn"
                class="border border-gray-300 hover:border-gray-400 p-3 rounded-md transition-colors group {{ $wishlisted ? 'wishlist-active' : '' }}"
                data-product-id="{{ $product['product_id'] }}"
                title="Add to Wishlist">
                <svg class="w-5 h-5 transition-colors {{ $wishlisted ? 'text-red-500' : 'text-gray-600 group-hover:text-red-500' }}"
                    fill="{{ $wishlisted ? 'currentColor' : 'none' }}"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5
               4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5
               4.5 0 00-6.364 0z" />
                </svg>
            </button>
        </div>

        <!-- Success/Error Message -->
        <div id="cartMessage" class="hidden mt-4 p-3 rounded-md"></div>

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

<!-- Related Products Section -->
@if(isset($relatedProducts) && count($relatedProducts) > 0)
<div class="mt-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
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
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
@endif
</div>

{{-- Related products, etc --}}
{{-- ... --}}

{{-- Quantity + Cart Script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addToCartBtn = document.getElementById('addToCartBtn');
        const incrementBtn = document.getElementById('incrementQuantity');
        const decrementBtn = document.getElementById('decrementQuantity');
        const quantityInput = document.getElementById('quantity');
        const maxStock = {{ $product['stock'] }};

        if (addToCartBtn && quantityInput) {
            addToCartBtn.addEventListener('click',() => {
                const productId = addToCartBtn.dataset.productId;
                const quantity = parseInt(quantityInput.value);

                fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId, quantity })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.success ? '✅ ' + data.message : '❌ ' + data.message);
                    if (data.success) updateCartBadge();
                })
                .catch(err => {
                    console.error('Add to cart error:', err);
                    alert('❌ Terjadi kesalahan saat menambahkan ke keranjang');
                });
            });
        }

        if (incrementBtn && quantityInput) {
            incrementBtn.addEventListener('click', () => {
                let current = parseInt(quantityInput.value);
                if (current < maxStock) quantityInput.value = current + 1;
            });
        }

        if (decrementBtn && quantityInput) {
            decrementBtn.addEventListener('click', () => {
                let current = parseInt(quantityInput.value);
                if (current > 1) quantityInput.value = current - 1;
            });
        }

        function updateCartBadge() {
            fetch("{{ route('cart.count') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.getElementById('cart-badge');
                        if (badge) badge.innerText = data.count;
                    }
                });
        }
    });
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
