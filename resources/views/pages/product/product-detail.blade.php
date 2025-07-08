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

            {{-- Title, Price, Stock --}}
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6">{{ $product['title'] }}</h1>
            <div class="text-2xl font-bold text-gray-900 mb-4">{{ $product['price'] }}</div>
            <div class="text-gray-600 mb-4">Stock: {{ $product['stock'] }}</div>

            {{-- Description --}}
            <div class="mb-8 text-gray-600">{{ $product['description'] }}</div>

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

                {{-- Action Buttons --}}
                <div class="flex space-x-3">
                    <button id="addToCartBtn" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-md flex items-center justify-center space-x-2"
                        data-product-id="{{ $product['product_id'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13v6a1 1 0 001 1h10a1 1 0 001-1v-6M9 19v2m6-2v2" />
                        </svg>
                        <span>Add to Cart</span>
                    </button>

                    <a href="{{ route('checkout.form', $product['product_id']) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-md flex items-center justify-center">
                        Buy Now
                    </a>

                    <button id="wishlistBtn" class="border border-gray-300 hover:border-gray-400 p-3 rounded-md" data-product-id="{{ $product['product_id'] }}">
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
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
            addToCartBtn.addEventListener('click', () => {
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
