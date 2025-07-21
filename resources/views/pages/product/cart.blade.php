@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Keranjang Belanja</h1>
            <p class="text-gray-600">Kelola produk pilihan Anda sebelum checkout</p>
        </div>

        <!-- Cart Container -->
        <div id="cart-container" class="space-y-8">
            <!-- Loading State -->
            <div class="flex items-center justify-center py-16">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="ml-4 text-gray-600 text-lg">Memuat keranjang...</p>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<script>
    const baseUrl = "{{ url('/') }}";

    document.addEventListener("DOMContentLoaded", function () {
        loadCart();

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        function showLoading() {
            const container = document.getElementById('cart-container');
            container.innerHTML = `
                <div class="flex items-center justify-center py-16">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                    <p class="ml-4 text-gray-600 text-lg">Memuat keranjang...</p>
                </div>
            `;
        }

        function showMessage(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const icon = type === 'success' ? '✓' : '✗';

            toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full opacity-0`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <span class="text-xl mr-2">${icon}</span>
                    <p class="font-medium">${message}</p>
                </div>
            `;

            toastContainer.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);

            // Animate out
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        function loadCart() {
            fetch("{{ route('cart.data') }}")
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    const container = document.getElementById('cart-container');

                    if (!data.success || data.data.length === 0) {
                        container.innerHTML = `
                            <div class="max-w-md mx-auto text-center">
                                <div class="bg-white rounded-2xl shadow-xl p-12 transform hover:scale-105 transition-transform duration-300">
                                    <div class="mb-8">
                                        <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8.1"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Keranjang Masih Kosong</h3>
                                        <p class="text-gray-600 mb-8">Belum ada produk yang dipilih. Yuk mulai belanja sekarang!</p>
                                    </div>
                                    <a href='{{ route('explore') }}' class='inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200'>
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Mulai Belanja
                                    </a>
                                </div>
                            </div>`;
                        return;
                    }

                    let html = '<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">';
                    let grandTotal = 0;

                    // Cart Items Column
                    html += '<div class="lg:col-span-2 space-y-4">';
                    html += '<h2 class="text-2xl font-bold text-gray-900 mb-6">Produk dalam Keranjang</h2>';

                    data.data.forEach((item, index) => {
                        const total = item.price * item.quantity;
                        grandTotal += total;

                        const imageSrc = item.image && item.image.trim() !== ''
                            ? `${baseUrl}/images/${item.image}`
                            : `${baseUrl}/images/no-image.jpg`;

                        html += `
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden transform hover:scale-[1.02] transition-transform" data-id="${item.id}">
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row gap-6">
                                    <div class="relative group">
                                        <img src="${imageSrc}" alt="${item.name}"
                                            class="w-full sm:w-32 h-32 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300"
                                            onerror="this.onerror=null; this.src='/mole/images/no-image.jpg'">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-300"></div>
                                    </div>

                                    <div class="flex-1 space-y-3">
                                        <h3 class="text-xl font-bold text-gray-900">${item.name}</h3>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                                                ${formatRupiah(item.price)} / item
                                            </span>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-medium">
                                                Total: ${formatRupiah(total)}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-center gap-4">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-colors duration-200">
                                            <button class="qty-decrease p-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-l-xl transition-colors duration-200" data-id="${item.id}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <input type="number" min="1" max="99" value="${item.quantity}"
                                                class="qty-input w-16 p-3 text-center border-0 bg-transparent focus:ring-0 font-semibold text-gray-900"
                                                data-id="${item.id}" readonly>
                                            <button class="qty-increase p-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-r-xl transition-colors duration-200" data-id="${item.id}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Delete Button -->
                                        <button class="btn-delete p-3 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl transition-colors duration-200" data-id="${item.id}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });

                    html += '</div>';

                    // Summary Column
                    html += `
                        <div class="lg:col-span-1">
                            <div class="sticky top-8">
                                <div class="bg-white rounded-2xl shadow-lg p-8">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Ringkasan Belanja</h2>

                                    <div class="space-y-4 mb-6">
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Jumlah Item:</span>
                                            <span class="font-semibold text-gray-900">${data.data.length} produk</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Subtotal:</span>
                                            <span class="font-semibold text-gray-900">${formatRupiah(grandTotal)}</span>
                                        </div>
                                    </div>

                                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4 mb-6">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900">Total Belanja:</span>
                                            <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                                ${formatRupiah(grandTotal)}
                                            </span>
                                        </div>
                                    </div>

                                    <a href="{{ route('checkout.cart') }}" class="w-full bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        Lanjut ke Checkout
                                    </a>

                                    <div class="mt-4 text-center">
                                        <a href='{{ route('products') }}' class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Lanjut Belanja
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    html += '</div>';

                    container.innerHTML = html;
                    attachEventListeners();
                })
                .catch(error => {
                    console.error('Error loading cart:', error);
                    showMessage('Gagal memuat keranjang', 'error');
                });
        }

        function attachEventListeners() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');

                    // Custom confirmation dialog
                    if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                        showLoading();
                        fetch(`${baseUrl}/cart/remove/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            if (!res.ok) throw new Error(`HTTP ${res.status}`);
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showMessage('Item berhasil dihapus dari keranjang');
                                loadCart();
                            } else {
                                showMessage(data.message || 'Gagal menghapus item', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('Gagal menghapus item', 'error');
                        });
                    }
                });
            });

            document.querySelectorAll('.qty-decrease').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const input = document.querySelector(`.qty-input[data-id="${id}"]`);
                    const currentQty = parseInt(input.value);
                    if (currentQty > 1) {
                        updateQuantity(id, currentQty - 1);
                    }
                });
            });

            document.querySelectorAll('.qty-increase').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const input = document.querySelector(`.qty-input[data-id="${id}"]`);
                    const currentQty = parseInt(input.value);
                    if (currentQty < 99) {
                        updateQuantity(id, currentQty + 1);
                    }
                });
            });
        }

        function updateQuantity(id, newQty) {
            fetch(`${baseUrl}/cart/update/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showMessage('Quantity berhasil diperbarui');
                    loadCart();
                } else {
                    showMessage(data.message || 'Gagal update quantity', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Gagal update quantity', 'error');
            });
        }
    });
</script>

@endsection