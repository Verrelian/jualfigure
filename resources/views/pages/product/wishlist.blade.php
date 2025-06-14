@extends('layout.app')

@section('title', 'My Wishlist - Figure Collection Store')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-blue-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800">My Wishlist</span>
        </div>

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Wishlist</h1>
            <button id="clearWishlist" class="text-sm text-gray-600 hover:text-red-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Clear Wishlist
            </button>
        </div>

        <!-- Wishlist Content -->
        <div id="wishlistContainer" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @if($wishlists && $wishlists->count() > 0)
                @foreach($wishlists as $wishlist)
                    <div class="wishlist-item bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow" data-product-id="{{ $wishlist->product->product_id }}">
                        <div class="relative">
                            <a href="{{ route('product.detail', $wishlist->product->product_id) }}" class="product-link">
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ $wishlist->product->image ?? '/images/placeholder.jpg' }}" alt="{{ $wishlist->product->name }}" class="product-image w-full h-full object-cover transition-transform hover:scale-105">
                                </div>
                            </a>
                            <button class="remove-wishlist absolute top-2 right-2 bg-white rounded-full p-1 shadow-md hover:bg-gray-100" data-product-id="{{ $wishlist->product->product_id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-4">
                            <span class="product-type inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold mb-2">{{ $wishlist->product->category ?? 'Figure' }}</span>
                            <h3 class="product-title font-semibold text-sm mb-1 truncate">{{ $wishlist->product->name }}</h3>
                            <div class="product-price text-red-600 font-bold">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</div>
                            <div class="mt-3">
                                <button class="add-to-cart w-full bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm font-semibold flex items-center justify-center" data-product-id="{{ $wishlist->product->product_id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty state message -->
                <div id="emptyWishlist" class="col-span-full flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Your wishlist is empty</h3>
                    <p class="text-gray-500 mb-6 text-center">Explore our collection and add your favorite figures!</p>
                    <a href="{{ route('explore') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold">
                        Explore Collection
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clearWishlistBtn = document.getElementById('clearWishlist');

            // Function to display notification
            function showNotification(message, isSuccess = true) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-opacity duration-300 ${isSuccess ? 'bg-gray-800 text-white' : 'bg-red-500 text-white'}`;
                notification.innerText = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Remove single item from wishlist
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-wishlist')) {
                    e.preventDefault();
                    const button = e.target.closest('.remove-wishlist');
                    const productId = button.getAttribute('data-product-id');
                    const wishlistItem = button.closest('.wishlist-item');
                    const productTitle = wishlistItem.querySelector('.product-title').textContent;

                    // Disable button
                    button.disabled = true;
                    button.style.opacity = '0.5';

                    fetch('/wishlist/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Remove item from DOM
                            wishlistItem.remove();
                            
                            // Check if wishlist is empty
                            const remainingItems = document.querySelectorAll('.wishlist-item');
                            if (remainingItems.length === 0) {
                                // Show empty state
                                const container = document.getElementById('wishlistContainer');
                                container.innerHTML = `
                                    <div class="col-span-full flex flex-col items-center justify-center py-12">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <h3 class="text-xl font-bold text-gray-700 mb-2">Your wishlist is empty</h3>
                                        <p class="text-gray-500 mb-6 text-center">Explore our collection and add your favorite figures!</p>
                                        <a href="{{ route('explore') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold">
                                            Explore Collection
                                        </a>
                                    </div>
                                `;
                            }

                            showNotification(data.message || `${productTitle} removed from wishlist`);
                            
                            // Update wishlist counter
                            updateWishlistCounter();
                        } else {
                            showNotification(data.message || 'Failed to remove item from wishlist', false);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred. Please try again.', false);
                    })
                    .finally(() => {
                        // Re-enable button
                        button.disabled = false;
                        button.style.opacity = '1';
                    });
                }
            });

            // Buy now button handler
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-to-cart')) {
                    e.preventDefault();
                    const button = e.target.closest('.add-to-cart');
                    const productId = button.getAttribute('data-product-id');
                    window.location.href = `/product/${productId}`;
                }
            });

            // Clear entire wishlist
            clearWishlistBtn.addEventListener('click', function() {
                const wishlistItems = document.querySelectorAll('.wishlist-item');
                if (wishlistItems.length === 0) return;

                if (confirm('Are you sure you want to clear your wishlist?')) {
                    // Disable button
                    clearWishlistBtn.disabled = true;
                    clearWishlistBtn.style.opacity = '0.5';

                    fetch('/wishlist/clear', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Clear all items from DOM
                            wishlistItems.forEach(item => item.remove());
                            
                            // Show empty state
                            const container = document.getElementById('wishlistContainer');
                            container.innerHTML = `
                                <div class="col-span-full flex flex-col items-center justify-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <h3 class="text-xl font-bold text-gray-700 mb-2">Your wishlist is empty</h3>
                                    <p class="text-gray-500 mb-6 text-center">Explore our collection and add your favorite figures!</p>
                                    <a href="{{ route('explore') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold">
                                        Explore Collection
                                    </a>
                                </div>
                            `;

                            showNotification(data.message || 'Wishlist has been cleared');
                            
                            // Update wishlist counter
                            updateWishlistCounter();
                        } else {
                            showNotification(data.message || 'Failed to clear wishlist', false);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred. Please try again.', false);
                    })
                    .finally(() => {
                        // Re-enable button
                        clearWishlistBtn.disabled = false;
                        clearWishlistBtn.style.opacity = '1';
                    });
                }
            });

            // Function to update wishlist counter
            function updateWishlistCounter() {
                fetch('/wishlist/count')
                    .then(response => response.json())
                    .then(data => {
                        const wishlistCountElement = document.getElementById('wishlistCount');
                        if (wishlistCountElement && data.count !== undefined) {
                            wishlistCountElement.textContent = data.count;
                        }
                    })
                    .catch(error => console.error('Error updating wishlist counter:', error));
            }
        });
    </script>
@endsection