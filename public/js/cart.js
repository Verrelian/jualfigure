// Add to Cart Functionality
document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('addToCartBtn');
    const quantityInput = document.getElementById('quantity');
    const cartMessage = document.getElementById('cartMessage');

    // Quantity controls
    const decrementBtn = document.getElementById('decrementQuantity');
    const incrementBtn = document.getElementById('incrementQuantity');

    // Quantity increment/decrement
    decrementBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    incrementBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue < 25) { // max stock
            quantityInput.value = currentValue + 1;
        }
    });

    // Add to Cart functionality
    addToCartBtn.addEventListener('click', function() {
        const button = this;
        const productId = button.dataset.productId;
        const productName = button.dataset.productName;
        const quantity = parseInt(quantityInput.value) || 1;

        // Disable button sementara
        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Adding...
        `;

        // AJAX request ke Laravel
            fetch(addToCartUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success message
                showMessage('✅ ' + productName + ' berhasil ditambahkan ke keranjang!', 'success');

                // Update cart count jika ada
                updateCartCount();

            } else {
                // Error message
                showMessage('❌ ' + (data.message || 'Gagal menambahkan ke keranjang'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('❌ Terjadi kesalahan. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Reset button
            button.disabled = false;
            button.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h10a1 1 0 001-1v-6M9 19v2m6-2v2"/>
                </svg>
                <span>Add to Cart</span>
            `;
        });
    });

    // Function untuk show message
    function showMessage(message, type) {
        cartMessage.className = `mt-4 p-3 rounded-md ${type === 'success' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200'}`;
        cartMessage.textContent = message;
        cartMessage.classList.remove('hidden');

        // Hide after 5 seconds
        setTimeout(() => {
            cartMessage.classList.add('hidden');
        }, 5000);
    }

    // Function untuk update cart count (opsional)
    function updateCartCount() {
        fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = data.count || 0;
            });
        })
        .catch(error => console.log('Cart count update failed:', error));
    }
});