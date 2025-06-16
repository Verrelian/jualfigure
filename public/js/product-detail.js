document.addEventListener('DOMContentLoaded', function () {
    // ENHANCED DEBUG WISHLIST FUNCTIONALITY
    const wishlistBtn = document.getElementById('wishlistBtn');

    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = this.getAttribute('data-product-id');
            const button = this;

            console.log('=== WISHLIST DEBUG START ===');
            console.log('Product ID:', productId);

            // Validasi product ID
            if (!productId || productId === 'null' || productId === 'undefined') {
                console.error('❌ Invalid Product ID:', productId);
                showNotification('Product ID tidak valid', 'error');
                return;
            }

            // Validasi CSRF token
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenElement) {
                console.error('❌ CSRF token meta tag not found');
                showNotification('CSRF token tidak ditemukan. Pastikan <meta name="csrf-token"> ada di <head>', 'error');
                return;
            }

            const csrfToken = csrfTokenElement.getAttribute('content');
            if (!csrfToken) {
                console.error('❌ CSRF token is empty');
                showNotification('CSRF token kosong', 'error');
                return;
            }

            console.log('✅ Product ID:', productId);
            console.log('✅ CSRF Token (first 10 chars):', csrfToken.substring(0, 10) + '...');

            // Disable button sementara
            button.disabled = true;
            button.style.opacity = '0.7';

            const requestData = {
                product_id: productId
            };

            console.log('📤 Request data:', requestData);
            console.log('📤 Request URL:', window.location.origin + '/mole/wishlist/add');

            // Kirim request AJAX dengan debugging lengkap
            fetch('/mole/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(requestData)

            })
            .then(response => {
                console.log('📥 Response status:', response.status);
                console.log('📥 Response ok:', response.ok);
                console.log('📥 Response headers:');

                // Log semua response headers
                for (let [key, value] of response.headers.entries()) {
                    console.log(`   ${key}: ${value}`);
                }

                // Ambil response sebagai text dulu untuk debugging
                return response.text().then(text => {
                    console.log('📥 Raw response body:', text);
                    console.log('📥 Response length:', text.length);

                    // Cek apakah response kosong
                    if (!text || text.trim() === '') {
                        throw new Error('Empty response from server');
                    }

                    // Cek apakah response adalah HTML (error page)
                    if (text.trim().startsWith('<!DOCTYPE') || text.trim().startsWith('<html')) {
                        console.error('❌ Received HTML instead of JSON (likely an error page)');
                        console.log('HTML content preview:', text.substring(0, 500) + '...');
                        throw new Error('Server returned HTML error page instead of JSON');
                    }

                    // Coba parse sebagai JSON
                    try {
                        const data = JSON.parse(text);
                        console.log('✅ Parsed JSON data:', data);
                        return { data, status: response.status, ok: response.ok };
                    } catch (e) {
                        console.error('❌ JSON parse error:', e);
                        console.error('❌ Failed to parse text:', text);

                        // Coba lihat apakah ada karakter aneh
                        console.log('Text char codes:', Array.from(text.substring(0, 50)).map(c => c.charCodeAt(0)));

                        throw new Error(`Invalid JSON response. Server returned: "${text.substring(0, 200)}..."`);
                    }
                });
            })
            .then(({ data, status, ok }) => {
                console.log('📊 Processing response:', { data, status, ok });

                if (!ok) {
                    console.error('❌ Response not OK:', status);

                    if (status === 401) {
                        throw new Error('UNAUTHORIZED');
                    } else if (status === 422) {
                        const errorMessage = data.message || data.error || 'Validation error';
                        console.error('❌ Validation error:', data);
                        throw new Error(`VALIDATION_ERROR: ${errorMessage}`);
                    } else if (status === 404) {
                        throw new Error('ROUTE_NOT_FOUND: Route /mole/wishlist/add tidak ditemukan');
                    } else if (status === 500) {
                        console.error('❌ Server error:', data);
                        throw new Error('SERVER_ERROR');
                    } else {
                        throw new Error(`HTTP_ERROR_${status}: ${data.message || 'Unknown error'}`);
                    }
                }

                if (data.success) {
                    console.log('🎉 Wishlist success!');
                    updateWishlistButton(button, true);
                    showNotification(data.message || 'Produk berhasil ditambahkan ke wishlist!', 'success');
                    updateWishlistCounter();
                } else {
                    console.error('❌ Operation failed:', data);
                    showNotification(data.message || 'Gagal menambahkan ke wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('💥 Wishlist Error:', error);
                console.error('💥 Error stack:', error.stack);

                let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                if (error.message === 'UNAUTHORIZED') {
                    errorMessage = 'Silakan login terlebih dahulu';
                    setTimeout(() => {
                        if (confirm('Anda perlu login. Redirect ke halaman login?')) {
                            window.location.href = '/login';
                        }
                    }, 2000);
                } else if (error.message.startsWith('VALIDATION_ERROR:')) {
                    errorMessage = error.message.replace('VALIDATION_ERROR: ', '');
                } else if (error.message.startsWith('ROUTE_NOT_FOUND:')) {
                    errorMessage = 'Route tidak ditemukan. Periksa konfigurasi route.';
                } else if (error.message === 'SERVER_ERROR') {
                    errorMessage = 'Server error. Periksa log server.';
                } else if (error.message.includes('Invalid JSON')) {
                    errorMessage = 'Server mengirim response yang tidak valid.';
                } else if (error.message.includes('HTML error page')) {
                    errorMessage = 'Server mengirim halaman error. Periksa route dan controller.';
                } else if (error.message.includes('Empty response')) {
                    errorMessage = 'Server mengirim response kosong.';
                } else if (error.message.includes('Failed to fetch')) {
                    errorMessage = 'Koneksi gagal. Periksa koneksi internet.';
                }

                showNotification(errorMessage, 'error');
            })
            .finally(() => {
                console.log('🏁 Request finished');
                // Re-enable button
                button.disabled = false;
                button.style.opacity = '1';
                console.log('=== WISHLIST DEBUG END ===');
            });
        });
    } else {
        console.error('❌ Wishlist button not found!');
    }
});

// Enhanced notification function
function showNotification(message, type) {
    console.log(`📢 Notification: [${type.toUpperCase()}] ${message}`);

    const existingNotification = document.querySelector('.wishlist-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `wishlist-notification fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm transform translate-x-full transition-transform duration-300 ${
        type === 'success'
            ? 'bg-green-500 text-white'
            : 'bg-red-500 text-white'
    }`;

    notification.innerHTML = `
        <div class="flex items-start">
            <div class="flex-1">
                <div class="text-sm font-medium mb-1">${type === 'success' ? '✅ Berhasil' : '❌ Error'}</div>
                <div class="text-xs opacity-90">${message}</div>
            </div>
            <button class="ml-3 text-white hover:text-gray-200 flex-shrink-0" onclick="this.closest('.wishlist-notification').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }
    }, 7000);
}

function updateWishlistButton(button, isWishlisted) {
    const svg = button.querySelector('svg');
    if (svg) {
        if (isWishlisted) {
            svg.style.fill = 'currentColor';
            svg.classList.remove('text-gray-600');
            svg.classList.add('text-red-500');
            button.classList.add('wishlist-active');
        } else {
            svg.style.fill = 'none';
            svg.classList.remove('text-red-500');
            svg.classList.add('text-gray-600');
            button.classList.remove('wishlist-active');
        }
    }
}

function updateWishlistCounter() {
    console.log('🔄 Updating wishlist counter...');
    // Implementation here
}

// Comprehensive debug function
function fullDebugInfo() {
    console.log('=== FULL DEBUG INFO ===');
    console.log('Current URL:', window.location.href);
    console.log('User Agent:', navigator.userAgent);
    console.log('Document ready state:', document.readyState);

    // Check all important elements
    const elements = {
        'wishlistBtn': document.getElementById('wishlistBtn'),
        'csrf-token': document.querySelector('meta[name="csrf-token"]'),
    };

    for (let [name, element] of Object.entries(elements)) {
        console.log(`${name}:`, element ? '✅ Found' : '❌ Missing');
        if (element) {
            console.log(`  - Element:`, element);
            if (element.hasAttributes()) {
                console.log(`  - Attributes:`);
                for (let attr of element.attributes) {
                    console.log(`    ${attr.name}: ${attr.value}`);
                }
            }
        }
    }

    // Check if routes exist (you can test this manually)
    console.log('🧪 Testing route accessibility...');
    fetch('/mole/wishlist/add', {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(response => {
        console.log('Route /mole/wishlist/add status:', response.status);
        if (response.status === 405) {
            console.log('✅ Route exists (405 = Method Not Allowed for GET, which is expected)');
        } else if (response.status === 404) {
            console.log('❌ Route not found!');
        } else {
            console.log('ℹ️ Unexpected status:', response.status);
        }
    })
    .catch(e => console.error('Route test failed:', e));

    console.log('=====================');
}

// Run debug when page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(fullDebugInfo, 1000);
});