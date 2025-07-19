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
            <button id="clearWishlist" class="text-sm text-gray-600 hover:text-red-600 flex items-center" style="display: {{ $wishlists && $wishlists->count() > 0 ? 'flex' : 'none' }};">
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
                                <div class="h-48 overflow-hidden bg-gray-100">
                                    @if($wishlist->product->image)
                                        <img src="{{ asset('images/' . $wishlist->product->image) }}"
                                             alt="{{ $wishlist->product->name }}"
                                             class="product-image w-full h-full object-cover transition-transform hover:scale-105"
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'; this.classList.add('placeholder');">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <button class="remove-wishlist absolute top-2 right-2 bg-white rounded-full p-1 shadow-md hover:bg-gray-100 transition-colors" data-product-id="{{ $wishlist->product->product_id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.225 4.811a1 1 0 00-1.414 1.414L10.586 12 4.81 17.775a1 1 0 101.414 1.414L12 13.414l5.775 5.775a1 1 0 001.414-1.414L13.414 12l5.775-5.775a1 1 0 00-1.414-1.414L12 10.586 6.225 4.81z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-4">
                            <span class="product-type inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold mb-2">
                                {{ $wishlist->product->type ?? 'Figure' }}
                            </span>
                            <h3 class="product-title font-semibold text-sm mb-1 text-gray-800 line-clamp-2" title="{{ $wishlist->product->name }}">
                                {{ $wishlist->product->name }}
                            </h3>
                            <div class="product-price text-red-600 font-bold text-lg mb-3">
                                Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty state message -->
                <div id="emptyWishlist" class="col-span-full flex flex-col items-center justify-center py-16">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300 mb-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-700 mb-3">Your wishlist is empty</h3>
                        <p class="text-gray-500 mb-8 text-lg max-w-md mx-auto">Discover amazing figures and add them to your wishlist to keep track of your favorites!</p>
                        <a href="{{ route('explore') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Explore Collection
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Loading overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">Processing...</span>
        </div>
    </div>

    <!-- Custom CSS for better image handling -->
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-image.placeholder {
            filter: grayscale(100%);
            opacity: 0.5;
        }

        .wishlist-item:hover {
            transform: translateY(-2px);
        }

        .wishlist-item {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clearWishlistBtn = document.getElementById('clearWishlist');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Function to show/hide loading
            function showLoading() {
                loadingOverlay.classList.remove('hidden');
            }

            function hideLoading() {
                loadingOverlay.classList.add('hidden');
            }

            // Function to display notification
            function showNotification(message, isSuccess = true) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full ${isSuccess ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        ${isSuccess ?
                            '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' :
                            '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>'
                        }
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Animate out and remove
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }, 3500);
            }

            // Remove single item from wishlist
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-wishlist')) {
                    e.preventDefault();
                    const button = e.target.closest('.remove-wishlist');
                    const productId = button.getAttribute('data-product-id');
                    const wishlistItem = button.closest('.wishlist-item');
                    const productTitle = wishlistItem.querySelector('.product-title').textContent;

                    // Disable button and show loading
                    button.disabled = true;
                    button.style.opacity = '0.5';
                    button.style.pointerEvents = 'none';

                    fetch('/mole/wishlist/remove', {
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
                            // Add fade out animation
                            wishlistItem.style.transition = 'all 0.3s ease';
                            wishlistItem.style.opacity = '0';
                            wishlistItem.style.transform = 'scale(0.95)';

                            setTimeout(() => {
                                wishlistItem.remove();

                                // Check if wishlist is empty
                                const remainingItems = document.querySelectorAll('.wishlist-item');
                                if (remainingItems.length === 0) {
                                    showEmptyState();
                                    // Hide clear button
                                    if (clearWishlistBtn) {
                                        clearWishlistBtn.style.display = 'none';
                                    }
                                }
                            }, 300);

                            showNotification(data.message || `${productTitle} removed from wishlist`);

                            // Update wishlist counter
                            updateWishlistCounter();
                        } else {
                            showNotification(data.message || 'Failed to remove item from wishlist', false);
                            // Re-enable button
                            button.disabled = false;
                            button.style.opacity = '1';
                            button.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred. Please try again.', false);
                        // Re-enable button
                        button.disabled = false;
                        button.style.opacity = '1';
                        button.style.pointerEvents = 'auto';
                    });
                }
            });

            // Buy now button handler
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-to-cart')) {
                    e.preventDefault();
                    const button = e.target.closest('.add-to-cart');
                    const productId = button.getAttribute('data-product-id');

                    // Add loading state to button
                    const originalContent = button.innerHTML;
                    button.innerHTML = `
                        <svg class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    `;
                    button.disabled = true;

                    setTimeout(() => {
                        window.location.href = `/product/${productId}`;
                    }, 500);
                }
            });

            // Clear entire wishlist
            if (clearWishlistBtn) {
                clearWishlistBtn.addEventListener('click', function() {
                    const wishlistItems = document.querySelectorAll('.wishlist-item');
                    if (wishlistItems.length === 0) return;

                    if (confirm('Are you sure you want to clear your entire wishlist? This action cannot be undone.')) {
                        showLoading();

                        fetch('/mole/wishlist/clear', {
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
                            hideLoading();
                            if (data.success) {
                                // Fade out all items
                                wishlistItems.forEach((item, index) => {
                                    setTimeout(() => {
                                        item.style.transition = 'all 0.3s ease';
                                        item.style.opacity = '0';
                                        item.style.transform = 'scale(0.95)';
                                    }, index * 100);
                                });

                                setTimeout(() => {
                                    showEmptyState();
                                    clearWishlistBtn.style.display = 'none';
                                }, wishlistItems.length * 100 + 300);

                                showNotification(data.message || 'Wishlist has been cleared');

                                // Update wishlist counter
                                updateWishlistCounter();
                            } else {
                                showNotification(data.message || 'Failed to clear wishlist', false);
                            }
                        })
                        .catch(error => {
                            hideLoading();
                            console.error('Error:', error);
                            showNotification('An error occurred. Please try again.', false);
                        });
                    }
                });
            }

            // Function to show empty state
            function showEmptyState() {
                const container = document.getElementById('wishlistContainer');
                container.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-16">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300 mb-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-700 mb-3">Your wishlist is empty</h3>
                            <p class="text-gray-500 mb-8 text-lg max-w-md mx-auto">Discover amazing figures and add them to your wishlist to keep track of your favorites!</p>
                            <a href="/explore" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Explore Collection
                            </a>
                        </div>
                    </div>
                `;
            }

            // Function to update wishlist counter
            function updateWishlistCounter() {
                fetch('/mole/wishlist/count')
                    .then(response => response.json())
                    .then(data => {
                        const wishlistCountElement = document.getElementById('wishlistCount');
                        if (wishlistCountElement && data.count !== undefined) {
                            wishlistCountElement.textContent = data.count;
                            if (data.count === 0) {
                                wishlistCountElement.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => console.error('Error updating wishlist counter:', error));
            }
        });
    </script>
@endsection