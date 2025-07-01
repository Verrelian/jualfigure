@extends('layout.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-semibold mb-6">🛒 Keranjang Belanja Kamu</h2>

    <div id="cart-container" class="space-y-4">
        <p class="text-gray-500">Memuat keranjang...</p>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        loadCart();

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        function loadCart() {
            fetch("{{ route('cart.data') }}")
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('cart-container');
                    if (!data.success || data.data.length === 0) {
                        container.innerHTML = `
                            <div class="text-center text-gray-500">
                                <p>Keranjang kosong.</p>
                                <a href='{{ route('products') }}' class='mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded'>Belanja Sekarang</a>
                            </div>`;
                        return;
                    }

                    let html = '';
                    let grandTotal = 0;

                    data.data.forEach(item => {
                        const total = item.price * item.quantity;
                        grandTotal += total;

                        html += `
                        <div class="flex flex-col md:flex-row items-center bg-white shadow rounded p-4 gap-4" data-id="${item.id}">
                            <img src="/images/${item.image}" alt="${item.name}" class="w-24 h-24 object-cover rounded border">
                            <div class="flex-1 space-y-1">
                                <h3 class="font-medium text-lg">${item.name}</h3>
                                <p class="text-gray-500">Harga: ${formatRupiah(item.price)}</p>
                                <p class="text-gray-500">Total: ${formatRupiah(total)}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="number" min="1" max="99" value="${item.quantity}" class="qty-input w-16 p-1 border rounded text-center">
                                <button class="btn-delete text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>`;
                    });

                    html += `
                        <div class="text-right mt-6">
                            <h4 class="text-xl font-semibold">Total Belanja: ${formatRupiah(grandTotal)}</h4>
                            <button class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded disabled:opacity-50 cursor-not-allowed" disabled>
                                Checkout (Belum aktif)
                            </button>
                        </div>
                    `;

                    container.innerHTML = html;

                    // Hapus item
                    document.querySelectorAll('.btn-delete').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const id = this.closest('[data-id]').getAttribute('data-id');
                            if (confirm('Hapus item ini dari keranjang?')) {
                                fetch(`/cart/remove/${id}`, {
                                    method: 'DELETE',
                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                }).then(() => loadCart());
                            }
                        });
                    });

                    // Update qty
                    document.querySelectorAll('.qty-input').forEach(input => {
                        input.addEventListener('change', function () {
                            const id = this.closest('[data-id]').getAttribute('data-id');
                            const qty = this.value;

                            fetch(`/cart/update/${id}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ quantity: qty })
                            }).then(() => loadCart());
                        });
                    });
                });
        }
    });
</script>
@endsection
