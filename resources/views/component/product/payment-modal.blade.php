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