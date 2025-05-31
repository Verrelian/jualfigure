@extends('layout.app')

@section('type', 'Explore - Figure Collection Store')

@section('content')
    <!-- Explore Header -->
    <div class="flex justify-center mt-5 mb-7">
        <div class="w-full text-center">
            <h1 class="text-3xl font-bold">Explore</h1>
        </div>
    </div>

    <!-- Category Cards -->
    <div class="grid grid-cols-3 gap-4 mb-10">
        <!-- Nendoroid Category -->
        <div class="category-card relative rounded-lg overflow-hidden shadow-md bg-gray-800 cursor-pointer transition-transform duration-300 hover:scale-105 {{ $initialCategory == 'nendoroid' ? 'ring-4 ring-blue-500' : '' }}" 
             data-category="nendoroid">
            <div class="aspect-[4/3] w-full">
                <img src="{{ asset('images/p6.jpg') }}" alt="Nendoroid" class="w-full h-80 object-cover">
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2">
                <h3 class="font-bold text-sm">Nendoroid</h3>
                <div class="flex items-center">
                    <span class="text-xs">Popular</span>
                    <span class="ml-1 text-yellow-500">★</span>
                </div>
            </div>
        </div>

        <!-- Pop Up Parade Category -->
        <div class="category-card relative rounded-lg overflow-hidden shadow-md bg-gray-800 cursor-pointer transition-transform duration-300 hover:scale-105 {{ $initialCategory == 'popup' ? 'ring-4 ring-blue-500' : '' }}" 
             data-category="popup">
            <img src="{{ asset('images/p3.png') }}" alt="Pop Up Parade" class="w-full h-80 object-cover">
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2">
                <h3 class="font-bold text-sm">Pop Up Parade</h3>
                <div class="flex items-center">
                    <span class="text-xs">Trending</span>
                </div>
            </div>
        </div>

        <!-- Hot Toys Category -->
        <div class="category-card relative rounded-lg overflow-hidden shadow-md bg-gray-800 cursor-pointer transition-transform duration-300 hover:scale-105 {{ $initialCategory == 'hottoys' ? 'ring-4 ring-blue-500' : '' }}" 
             data-category="hottoys">
            <img src="{{ asset('images/figure4.jpg') }}" alt="Hot Toys" class="w-full h-80 object-cover">
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2">
                <h3 class="font-bold text-sm">Hot Toys</h3>
                <div class="flex items-center">
                    <span class="text-xs">Premium</span>
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
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3" id="products-title">
            {{ $categories[$initialCategory] ?? 'Products' }}
        </h2>
        <div id="products-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $product)
                @include('component.product-card', [
                    'id' => $product->id,
                    'image' => $product->gambar_url,
                    'type' => $product->type,
                    'title' => $product->nama,
                    'price' => $product->formatted_harga
                ])
            @endforeach
        </div>
        
        <!-- No Products Message -->
        <div id="no-products" class="hidden text-center py-8">
            <p class="text-gray-600">No products found in this category.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryCards = document.querySelectorAll('.category-card');
            const productsContainer = document.getElementById('products-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            const noProductsMessage = document.getElementById('no-products');
            const productsTitle = document.getElementById('products-title');
            
            // Category name mapping
            const categoryNames = {
                'nendoroid': 'Nendoroid',
                'popup': 'Pop Up Parade',
                'hottoys': 'Hot Toys'
            };

            categoryCards.forEach(card => {
                card.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    // Update active state
                    categoryCards.forEach(c => c.classList.remove('ring-4', 'ring-blue-500'));
                    this.classList.add('ring-4', 'ring-blue-500');
                    
                    // Update URL without page reload
                    const url = new URL(window.location);
                    url.searchParams.set('category', category);
                    window.history.pushState({}, '', url);
                    
                    // Update products title
                    productsTitle.textContent = categoryNames[category] || 'Products';
                    
                    // Show loading
                    showLoading();
                    
                    // Fetch products via AJAX
                    fetchProducts(category);
                });
            });

            function showLoading() {
                productsContainer.style.display = 'none';
                noProductsMessage.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');
            }

            function hideLoading() {
                loadingIndicator.classList.add('hidden');
                productsContainer.style.display = 'grid';
            }

            function fetchProducts(category) {
                fetch(`{{ route('products.by-category') }}?category=${category}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    
                    if (data.success && data.products.length > 0) {
                        renderProducts(data.products);
                        noProductsMessage.classList.add('hidden');
                    } else {
                        productsContainer.innerHTML = '';
                        noProductsMessage.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();
                    productsContainer.innerHTML = '<div class="col-span-full text-center text-red-500">Error loading products. Please try again.</div>';
                });
            }

            function renderProducts(products) {
                productsContainer.innerHTML = products.map(product => `
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <a href="/product/${product.id}" class="block">
                            <div class="aspect-square w-full">
                                <img src="${product.gambar_url}" alt="${product.nama}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3">
                                <p class="text-xs text-gray-500 mb-1">${product.type}</p>
                                <h3 class="font-semibold text-sm mb-2 line-clamp-2">${product.nama}</h3>
                                <p class="text-lg font-bold text-blue-600">${product.harga}</p>
                                <div class="mt-2">
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">
                                        Stock: ${product.stok}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                `).join('');
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(event) {
                const urlParams = new URLSearchParams(window.location.search);
                const category = urlParams.get('category') || 'nendoroid';
                
                // Update active card
                categoryCards.forEach(c => c.classList.remove('ring-4', 'ring-blue-500'));
                const activeCard = document.querySelector(`[data-category="${category}"]`);
                if (activeCard) {
                    activeCard.classList.add('ring-4', 'ring-blue-500');
                }
                
                // Update title and fetch products
                productsTitle.textContent = categoryNames[category] || 'Products';
                showLoading();
                fetchProducts(category);
            });
        });
    </script>

@endsection