        const cartItems = document.getElementById('cartItems');
        const subtotalEl = document.getElementById('subtotal');
        const shippingEl = document.getElementById('shipping');
        const finalTotalEl = document.getElementById('finalTotal');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const notification = document.getElementById('notification');
        const baseUrl = document.querySelector('meta[name="base-url"]').content;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        let cart = [];
        const shippingCost = 15000;

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        function showNotification(message, type = 'success') {
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        function updateCartDisplay() {
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Keranjang Anda Masih Kosong</h3>
                        <p>Silakan tambahkan produk ke keranjang untuk melanjutkan belanja</p>
                    </div>
                `;
                document.getElementById('cartTotal').style.display = 'none';
                checkoutBtn.disabled = true;
                return;
            }

            let subtotal = 0;
            cartItems.innerHTML = cart.map(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                // Handle image path - jika ada base URL untuk gambar, sesuaikan di sini
                const imagePath = item.image ? `${baseUrl}/asset/images/${item.image}` : 'https://via.placeholder.com/80x80?text=No+Image';

                return `
                    <div class="cart-item">
                        <img src="${imagePath}" alt="${item.name}" class="item-image" onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            <div class="item-type">${item.product?.type || 'Produk'}</div>
                            <div class="item-price">${formatCurrency(item.price)}</div>
                        </div>
                        <div class="quantity-controls">
                            <button class="qty-btn" onclick="changeQuantity(${item.product_id}, ${item.quantity - 1})" ${item.quantity <= 1 ? 'disabled' : ''}>
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="quantity">${item.quantity}</span>
                            <button class="qty-btn" onclick="changeQuantity(${item.product_id}, ${item.quantity + 1})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <button class="remove-btn" onclick="removeItem(${item.product_id})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                `;
            }).join('');

            subtotalEl.textContent = formatCurrency(subtotal);
            shippingEl.textContent = formatCurrency(shippingCost);
            finalTotalEl.textContent = formatCurrency(subtotal + shippingCost);
            document.getElementById('cartTotal').style.display = 'block';
            checkoutBtn.disabled = false;
        }

        async function fetchCart() {
            try {
                console.log('Fetching cart from:', `${baseUrl}/cart/data`);
                const response = await fetch(`${baseUrl}/cart/data`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    }
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Cart data received:', data);

                if (data.success && data.data) {
                    cart = data.data;
                    updateCartDisplay();
                    showNotification(data.message || 'Keranjang berhasil dimuat');
                } else {
                    throw new Error(data.message || 'Gagal memuat data keranjang');
                }
            } catch (error) {
                console.error('Error fetching cart:', error);
                showNotification('Gagal memuat keranjang: ' + error.message, 'error');
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Gagal Memuat Keranjang</h3>
                        <p>Terjadi kesalahan saat memuat data keranjang</p>
                        <button onclick="fetchCart()" style="margin-top: 15px; padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Coba Lagi
                        </button>
                    </div>
                `;
            }
        }

        async function changeQuantity(productId, newQty) {
            if (newQty <= 0) {
                return removeItem(productId);
            }

            const item = cart.find(i => i.product_id === productId);
            if (!item) {
                showNotification('Item tidak ditemukan', 'error');
                return;
            }

            try {
                const response = await fetch(`${baseUrl}/cart/update/${item.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({ quantity: newQty })
                });

                const data = await response.json();
                if (data.success) {
                    // Update local cart data
                    item.quantity = newQty;
                    item.total_price = item.price * newQty;
                    updateCartDisplay();
                    showNotification('Jumlah berhasil diupdate');
                } else {
                    throw new Error(data.message || 'Gagal update jumlah');
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
                showNotification('Gagal update jumlah: ' + error.message, 'error');
            }
        }

        async function removeItem(productId) {
            const item = cart.find(i => i.product_id === productId);
            if (!item) {
                showNotification('Item tidak ditemukan', 'error');
                return;
            }

            if (!confirm(`Yakin ingin menghapus ${item.name} dari keranjang?`)) {
                return;
            }

            try {
                const response = await fetch(`${baseUrl}/cart/remove/${item.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    }
                });

                const data = await response.json();
                if (data.success) {
                    // Remove from local cart
                    cart = cart.filter(i => i.product_id !== productId);
                    updateCartDisplay();
                    showNotification('Item berhasil dihapus');
                } else {
                    throw new Error(data.message || 'Gagal hapus item');
                }
            } catch (error) {
                console.error('Error removing item:', error);
                showNotification('Gagal hapus item: ' + error.message, 'error');
            }
        }

        async function checkout() {
            if (cart.length === 0) {
                showNotification('Keranjang masih kosong', 'error');
                return;
            }

            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            if (!confirm(`Checkout ${totalItems} item dengan total ${formatCurrency(subtotal + shippingCost)}?`)) {
                return;
            }

            try {
                const response = await fetch(`${baseUrl}/cart/checkout`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        items: cart,
                        subtotal: subtotal,
                        shipping: shippingCost,
                        total: subtotal + shippingCost
                    })
                });

                const data = await response.json();
                if (data.success) {
                    cart = [];
                    updateCartDisplay();
                    showNotification('Checkout berhasil! Terima kasih telah berbelanja.');
                } else {
                    throw new Error(data.message || 'Checkout gagal');
                }
            } catch (error) {
                console.error('Error during checkout:', error);
                showNotification('Checkout gagal: ' + error.message, 'error');
            }
        }

        // Event listeners
        checkoutBtn.addEventListener('click', checkout);

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, fetching cart...');
            fetchCart();
        });