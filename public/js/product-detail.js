document.addEventListener('DOMContentLoaded', function () {
    // ENHANCED DEBUG WISHLIST FUNCTIONALITY
    const wishlistBtn = document.getElementById('wishlistBtn');

    wishlistBtn.addEventListener('click', function(e) {
    e.preventDefault();

    const productId = this.getAttribute('data-product-id');
    const button = this;
    const isWishlisted = button.classList.contains('wishlist-active');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Disable button sementara
    button.disabled = true;
    button.style.opacity = '0.7';

    const url = isWishlisted ? '/mole/wishlist/remove' : '/mole/wishlist/add';
    const actionText = isWishlisted ? 'menghapus dari' : 'menambahkan ke';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateWishlistButton(button, !isWishlisted);
            showNotification(data.message || `Berhasil ${actionText} wishlist`, 'success');
            updateWishlistCounter();
        } else {
            showNotification(data.message || `Gagal ${actionText} wishlist`, 'error');
        }
    })
    .catch(error => {
        console.error('Wishlist error:', error);
        showNotification('Terjadi kesalahan. Coba lagi nanti.', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.style.opacity = '1';
    });
});
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