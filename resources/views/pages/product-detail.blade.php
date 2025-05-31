@extends('layout.app')

@section('title', $product['title'] . ' - Figure Collection Store')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-blue-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ $product['title'] }}</span>
        </div>

        <!-- Product Detail -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row">
                <!-- Product Image -->
                <div class="md:w-1/2 mb-6 md:mb-0">
                    <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="max-w-full h-auto max-h-96 object-contain">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:w-1/2 md:pl-8">
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold mb-3">{{ $product['type'] }}</span>
                    <h1 class="text-2xl font-bold mb-3">{{ $product['title'] }}</h1>
                    <div class="text-xl font-bold text-red-600 mb-4">{{ $product['price'] }}</div>

                    <div class="mb-6">
                        <p class="text-gray-700">{{ $product['description'] }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">Specifications</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @foreach($product['specifications'] as $key => $value)
                                <div class="flex border-b border-gray-200 py-2 last:border-b-0">
                                    <span class="font-semibold w-1/3">{{ $key }}</span>
                                    <span class="text-gray-700 w-2/3">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <div class="flex items-center">
                            <button id="decrementQuantity" class="px-3 py-1 bg-gray-200 rounded-l-md hover:bg-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" id="quantity" name="quantity" min="1" value="1"
                                class="w-16 text-center py-1 border-gray-300 focus:ring-blue-500 focus:border-blue-500 block shadow-sm border-y">
                            <button id="incrementQuantity" class="px-3 py-1 bg-gray-200 rounded-r-md hover:bg-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button id="buyNowBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-semibold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Buy Now
                        </button>
                        <button id="wishlistBtn" class="border border-gray-300 hover:bg-gray-100 px-4 py-2 rounded-md flex items-center wishlist-btn">
                         <svg id="heartIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                         </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

<!-- Payment Modal  -->
<div id="paymentModal" class="fixed inset-0 bg-gray-900 bg-opacity-95 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-900 rounded-lg w-full max-w-4xl p-4 shadow-xl text-white flex flex-col" style="height: auto; max-height: 80vh;">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xl font-bold" id="orderNumber">#{{ mt_rand(1000000, 9999999) }}</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex flex-1 overflow-hidden">
            <!-- Left Side - Product Info -->
            <div class="w-1/2 pr-4 overflow-y-auto">
                <div class="text-gray-400 text-sm mb-4">
                    <p id="orderDate"></p>
                    <p class="mt-1">Estimated Delivery: 3-5 business days</p>
                </div>

                <!-- Item Details -->
                <div class="flex mb-4">
                    <div class="w-1/3">
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="w-full h-auto rounded">
                    </div>
                    <div class="w-2/3 pl-4">
                        <div class="flex items-start mb-1">
                            <span class="inline-block bg-pink-500 h-3 w-3 rounded-full mr-2 mt-1"></span>
                            <span class="font-semibold">Item</span>
                        </div>
                        <p class="text-sm mb-1">Product: {{ $product['title'] }}</p>
                        <p class="text-sm mb-1">Company: {{ $product['specifications']['Manufacture'] }}</p>
                        <p class="text-sm mb-1">Condition: Opened Box (Near Mint)</p>
                        <p class="text-sm">Quantity: <span id="modalQuantity">1</span>x</p>

                        <p class="text-sm mt-4 text-gray-400">
                            As her popularity never seems to lose any momentum, she's back again! Featuring multiple interchangeable parts, singing pose, silly "hatsune miku" face, and her iconic look.
                        </p>
                    </div>
                </div>

                <p class="text-sm text-gray-400 mb-4">
                   REMINDER!!JANGAN SAMPAI SALAH BELI KETIKA SUDAH CHECKOUT BARANG ANDA AKAN MASUK PESANAN..
                </p>
            </div>

            <!-- Right Side - Payment Info -->
            <div class="w-1/2 pl-4 border-l border-gray-700 overflow-y-auto">
                <!-- Payment Method Section -->
                <div class="mb-4">
                    <label class="block text-gray-400 mb-2">Payment Method</label>
                    <div class="relative">
                        <select id="paymentMethod" class="block w-full bg-gray-800 border border-gray-700 rounded py-2 pl-3 pr-10 text-white appearance-none focus:outline-none focus:border-blue-500">
                            <option value="">Select payment method</option>
                            <option value="bca">BCA Bank Transfer</option>
                            <option value="bni">BNI Bank Transfer</option>
                            <option value="mandiri">Mandiri Bank Transfer</option>
                            <option value="bri">BRI Bank Transfer</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Price Details -->
                <div class="text-gray-400 text-sm">
                    <div id="priceDetails">
                        <div class="flex justify-between py-2">
                            <span>Description</span>
                            <span id="basePrice">IDR {{ number_format(floatval(str_replace('$', '', $product['price'])) * 15000, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-800">
                            <span>Subtotal (<span id="summaryQuantity">1</span> item)</span>
                            <span id="subtotalPrice">IDR {{ number_format(floatval(str_replace('$', '', $product['price'])) * 15000, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-800">
                            <span>Shipping</span>
                            <span id="shippingPrice">IDR 8,000.00</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-800">
                            <span>Estimated Tax(5%)</span>
                            <span id="taxPrice">IDR {{ number_format(floatval(str_replace('$', '', $product['price'])) * 15000 * 0.05, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-800 font-bold">
                            <span>Total</span>
                            <span id="totalPrice">IDR {{ number_format(floatval(str_replace('$', '', $product['price'])) * 15000 * 1.05 + 8000, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button id="confirmPayment" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded font-medium text-center">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Bukti Pembayaran -->
<div id="buktiModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-800 text-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Upload Bukti Pembayaran</h2>
            <button onclick="closeBuktiModal()" class="text-gray-400 hover:text-white">
                &times;
            </button>
        </div>

        <p class="mb-2 text-sm text-gray-300">
            Silakan transfer ke nomor rekening berikut dan upload bukti pembayaran:
        </p>

        <div class="mb-4">
            <p><strong>Bank:</strong> BCA</p>
            <p><strong>No. Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> PT MOLE Store</p>
        </div>

        <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
            <label for="buktiPembayaran" class="block text-sm mb-1">Upload Bukti:</label>
            <input type="file" name="buktiPembayaran" id="buktiPembayaran" required
                   class="block w-full text-sm text-gray-300 bg-gray-700 rounded p-2 mb-4">

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>
<!-- Payment Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-3xl shadow-xl max-h-[80vh] overflow-y-auto">
        <div class="flex">
            <!-- Left Side - Success Icon and Basic Info -->
            <div class="w-1/3 p-4 bg-gray-50 rounded-l-lg flex flex-col items-center justify-center">
                <img src="{{ asset('images/success-icon.png') }}" alt="Success" class="w-20 h-20 mb-4" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMGY5ZDU4IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9ImZlYXRoZXIgZmVhdGhlci1jaGVjay1jaXJjbGUiPjxwYXRoIGQ9Ik0yMiAxMS4wOFYxMmExMCAxMCAwIDEgMS01LjkzLTkuMTQiPjwvcGF0aD48cG9seWxpbmUgcG9pbnRzPSIyMiA0IDEyIDE0LjAxIDkgMTEuMDEiPjwvcG9seWxpbmU+PC9zdmc+'; this.classList.add('p-2')">
                <h4 class="text-center text-lg font-bold text-green-600 mb-2">Payment info!</h4>
                <p class="text-center text-sm text-gray-600 mb-6">Your order has been processed..</p>

                <div class="flex flex-col w-full space-y-1 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-semibold" id="receiptOrderNumber"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span id="receiptDate"></span>
                    </div>
                </div>

                <div class="mt-auto w-full">
                    <button id="downloadReceipt" class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded font-medium">
                        Download Receipt
                    </button>
                </div>
            </div>

            <!-- Right Side - Order Details -->
            <div class="w-2/3 p-4 overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Payment Receipt</h3>
                    <button id="closeReceiptModal" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Receipt Content -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/success-icon.png') }}" alt="Success" class="w-16 h-16" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMGY5ZDU4IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9ImZlYXRoZXIgZmVhdGhlci1jaGVjay1jaXJjbGUiPjxwYXRoIGQ9Ik0yMiAxMS4wOFYxMmExMCAxMCAwIDEgMS01LjkzLTkuMTQiPjwvcGF0aD48cG9seWxpbmUgcG9pbnRzPSIyMiA0IDEyIDE0LjAxIDkgMTEuMDEiPjwvcG9seWxpbmU+PC9zdmc+'; this.classList.add('p-2')">
                    </div>
                    <h4 class="text-center text-xl font-bold text-green-600 mb-2">Payment!</h4>
                    <p class="text-center text-gray-600 mb-4">Your order has been Add to order status please check.</p>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Info:If you done for payment please check your order list</span>
                            <span class="font-semibold" id="receiptOrderNumber2"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Name Store:Market Place of Legends</span>
                            <span id="receiptDate2"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Payment Method:</span>
                            <span id="receiptPaymentMethod"></span>
                        </div>
                        <div class="flex justify-between text-sm font-semibold">
                            <span class="text-gray-600">Virtual Account Number:</span>
                            <span id="virtualAccountNumber"></span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-semibold mb-3 text-gray-800">Order Details</h5>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Product:</span>
                            <span class="text-right">{{ $product['title'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Quantity:</span>
                            <span id="receiptQuantity">1</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2 pt-2 border-t border-gray-200">
                            <span class="text-gray-600">Subtotal:</span>
                            <span id="receiptSubtotal"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Shipping:</span>
                            <span id="receiptShipping"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Tax:</span>
                            <span id="receiptTax"></span>
                        </div>
                        <div class="flex justify-between font-bold pt-2 border-t border-gray-200">
                            <span>Total:</span>
                            <span id="receiptTotal"></span>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 mb-6">
                    <p class="mb-2">Please complete your payment by transferring to the virtual account number shown above. Your order will be processed once payment is verified.</p>
                    <p>Estimated delivery: <span class="font-semibold">3-5 business days</span> after payment verification.</p>
                </div>

                <div class="text-right">
                    <a href="{{ url('/order-status') }}">
                    <button id="closeReceiptBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                        Done
                    </button></a>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Related Products -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('product.detail', $relatedProduct['id']) }}">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset($relatedProduct['image']) }}" alt="{{ $relatedProduct['title'] }}" class="w-full h-full object-cover transition-transform hover:scale-105">
                            </div>
                            <div class="p-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold mb-2">{{ $relatedProduct['type'] }}</span>
                                <h3 class="font-semibold text-sm mb-1 truncate">{{ $relatedProduct['title'] }}</h3>
                                <div class="text-red-600 font-bold">{{ $relatedProduct['price'] }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mendapatkan tanggal dan waktu saat ini dalam format yang diinginkan
    function getCurrentDateTime() {
        const now = new Date();

        // Format tanggal: DD/MM/YYYY
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const year = now.getFullYear();

        // Format waktu: HH:MM:SS
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
    }

    // Elements for payment modal
    const buyNowBtn = document.getElementById('buyNowBtn');
    const paymentModal = document.getElementById('paymentModal');
    const closeModal = document.getElementById('closeModal');
    const confirmPayment = document.getElementById('confirmPayment');
    const paymentMethod = document.getElementById('paymentMethod');

    // Elements for receipt modal
    const receiptModal = document.getElementById('receiptModal');
    const closeReceiptModal = document.getElementById('closeReceiptModal');
    const closeReceiptBtn = document.getElementById('closeReceiptBtn');
    const downloadReceipt = document.getElementById('downloadReceipt');

    // Elements for bukti pembayaran modal
    const buktiModal = document.getElementById('buktiModal');

    // Generate random order number
    const orderNumber = document.getElementById('orderNumber')?.textContent || 'ORD-' + Math.floor(100000 + Math.random() * 900000);

    // Function to close bukti modal
    function closeBuktiModal() {
        buktiModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Open payment modal when Buy Now button is clicked
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // Update order date with current date and time when Buy Now is clicked
            const orderDateElement = document.getElementById('orderDate');
            if (orderDateElement) {
                orderDateElement.textContent = getCurrentDateTime();
            }

            paymentModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        });
    }

    // Close payment modal when close button is clicked
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            paymentModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scrolling
        });
    }

    // Close payment modal when clicking outside the modal content
    if (paymentModal) {
        paymentModal.addEventListener('click', function(e) {
            if (e.target === paymentModal) {
                paymentModal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Enable scrolling
            }
        });
    }

    // Handle payment confirmation
    if (confirmPayment) {
        confirmPayment.addEventListener('click', function() {
            if (paymentMethod.value === '') {
                alert('Please select a payment method');
                return;
            }

            // Close payment modal
            paymentModal.classList.add('hidden');

            // Show bukti pembayaran modal
            buktiModal.classList.remove('hidden');
        });
    }

    // Show receipt after bukti pembayaran is submitted
    if (buktiModal) {
        const buktiForm = buktiModal.querySelector('form');
        if (buktiForm) {
            buktiForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent actual form submission

                // Close bukti modal
                closeBuktiModal();

                // Prepare receipt data
                document.getElementById('receiptOrderNumber').textContent = orderNumber;
                document.getElementById('receiptDate').textContent = document.getElementById('orderDate').textContent;
                document.getElementById('receiptPaymentMethod').textContent = paymentMethod.options[paymentMethod.selectedIndex].text;

                // Generate random virtual account number based on selected bank
                let bankPrefix = '';
                switch(paymentMethod.value) {
                    case 'bca': bankPrefix = '014'; break;
                    case 'bni': bankPrefix = '009'; break;
                    case 'mandiri': bankPrefix = '008'; break;
                    case 'bri': bankPrefix = '002'; break;
                    default: bankPrefix = '123';
                }
                const virtualAccount = bankPrefix + Math.floor(10000000000 + Math.random() * 90000000000);
                document.getElementById('virtualAccountNumber').textContent = virtualAccount;

                // Set price details
                document.getElementById('receiptSubtotal').textContent = document.getElementById('subtotalPrice').textContent;
                document.getElementById('receiptShipping').textContent = document.getElementById('shippingPrice').textContent;
                document.getElementById('receiptTax').textContent = document.getElementById('taxPrice').textContent;
                document.getElementById('receiptTotal').textContent = document.getElementById('totalPrice').textContent;

                // Show receipt modal
                receiptModal.classList.remove('hidden');
            });
        }
    }

    // Close receipt modal buttons
    if (closeReceiptModal) {
        closeReceiptModal.addEventListener('click', function() {
            receiptModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scrolling
        });
    }

    if (closeReceiptBtn) {
        closeReceiptBtn.addEventListener('click', function() {
            receiptModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scrolling
        });
    }

    // Close receipt modal when clicking outside the modal content
    if (receiptModal) {
        receiptModal.addEventListener('click', function(e) {
            if (e.target === receiptModal) {
                receiptModal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Enable scrolling
            }
        });
    }

    // Download receipt functionality
    if (downloadReceipt) {
        downloadReceipt.addEventListener('click', function() {
            alert('Receipt download functionality would be implemented here. In a real application, this would generate a PDF or print version of the receipt.');
        });
    }

    // Update bank account information in the bukti modal when payment method changes
    if (paymentMethod) {
        paymentMethod.addEventListener('change', function() {
            const bank = this.value;
            let accountNumber = '';
            let accountName = 'PT MOLE Store';

            switch(bank) {
                case 'bca':
                    accountNumber = '1234567890';
                    break;
                case 'bni':
                    accountNumber = '0987654321';
                    break;
                case 'mandiri':
                    accountNumber = '2468135790';
                    break;
                case 'bri':
                    accountNumber = '1357924680';
                    break;
                default:
                    accountNumber = '1234567890';
            }

            // Update the bank account information in the bukti modal
            const bankNameElement = document.querySelector('#buktiModal strong:nth-of-type(1)');
            const accountNumberElement = document.querySelector('#buktiModal strong:nth-of-type(2)');
            const accountNameElement = document.querySelector('#buktiModal strong:nth-of-type(3)');

            if (bankNameElement && bankNameElement.nextSibling) {
                bankNameElement.nextSibling.textContent = ': ' + bank.toUpperCase();
            }
            if (accountNumberElement && accountNumberElement.nextSibling) {
                accountNumberElement.nextSibling.textContent = ': ' + accountNumber;
            }
            if (accountNameElement && accountNameElement.nextSibling) {
                accountNameElement.nextSibling.textContent = ': ' + accountName;
            }
        });
    }

    // Wishlist functionality
    const wishlistBtn = document.getElementById('wishlistBtn');
    const heartIcon = document.getElementById('heartIcon');

    if (wishlistBtn && heartIcon) {
        try {
            const productId = productId || null; // This would be set by your template
            const productTitle = productTitle || "Product";
            const productImage = productImage || "";
            const productPrice = productPrice || "";
            const productType = productType || "";
            const productManufacture = productManufacture || "";

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

            // Function to check if product is in wishlist
            function isInWishlist(productId) {
                const wishlist = getWishlist();
                return wishlist.some(item => item.id === productId);
            }

            // Function to get wishlist from localStorage
            function getWishlist() {
                const wishlistData = localStorage.getItem('wishlist');
                return wishlistData ? JSON.parse(wishlistData) : [];
            }

            // Function to save wishlist to localStorage
            function saveWishlist(wishlist) {
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                updateWishlistCount();
            }

            // Function to update wishlist count
            function updateWishlistCount() {
                const wishlist = getWishlist();
                const wishlistCountElement = document.getElementById('wishlistCount');
                if (wishlistCountElement) {
                    wishlistCountElement.textContent = wishlist.length;
                }
            }

            // Function to toggle wishlist
            function toggleWishlist() {
                const wishlist = getWishlist();
                const productInWishlist = isInWishlist(productId);

                if (productInWishlist) {
                    // Remove from wishlist
                    const updatedWishlist = wishlist.filter(item => item.id !== productId);
                    saveWishlist(updatedWishlist);
                    updateHeartIcon(false);
                    showNotification(`${productTitle} removed from wishlist`);
                } else {
                    // Add to wishlist
                    const product = {
                        id: productId,
                        title: productTitle,
                        price: productPrice,
                        image: productImage,
                        type: productType,
                        isWishlisted: true,
                        specifications: {
                            Manufacture: productManufacture
                        }
                    };
                    wishlist.push(product);
                    saveWishlist(wishlist);
                    updateHeartIcon(true);
                    showNotification(`${productTitle} added to wishlist`);
                }
            }

            // Function to update heart icon appearance
            function updateHeartIcon(isWishlisted) {
                if (isWishlisted) {
                    heartIcon.setAttribute('fill', 'currentColor');
                    heartIcon.style.color = '#e53e3e'; // Red color
                } else {
                    heartIcon.setAttribute('fill', 'none');
                    heartIcon.style.color = ''; // Default color
                }
            }

            // Initialize heart icon state
            if (productId) {
                updateHeartIcon(isInWishlist(productId));
            }

            // Initialize wishlist count
            updateWishlistCount();

            // Event listener for wishlist button
            wishlistBtn.addEventListener('click', toggleWishlist);
        } catch (error) {
            console.error("Error initializing wishlist:", error);
        }
    }
});
</script>
@endsection