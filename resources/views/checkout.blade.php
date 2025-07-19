<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>

<body class="bg-gray-50 min-h-screen">
    @php
    $isCart = isset($checkoutFromCart) && $checkoutFromCart;
    $product = $product ?? null;
    @endphp

    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/dashboard') }}">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-16 w-auto">
                    </a>
                    <div class="hidden md:block">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                            Complete Your Order
                        </h1>
                        <p class="text-sm text-gray-500">Complete your purchase safely</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="step-indicator step-active flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="text-sm font-medium text-blue-600">Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Kiri: Form Input -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl card-shadow p-8">
                    <div class="mb-8">
                        <h2 class="text-4xl font-bold text-gray-900 mb-2">Contact Information</h2>
                        <p class="text-gray-600">Please fill in your details to complete the order</p>
                    </div>

                    <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}" autocomplete="off" class="space-y-6">
                        @csrf
                        @if (!$isCart && isset($product))
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        @endif
                        @if ($isCart)
                        <input type="hidden" name="is_cart_checkout" value="1">
                        @endif

                        <!-- Phone Number -->
                        <div class="group">
                            <label class="block mb-3">
                                <div class="flex items-center space-x-2 mb-3">
                                    <i class="fas fa-phone text-blue-500"></i>
                                    <span class="text-lg font-semibold text-gray-700">Phone Number</span>
                                </div>
                                @if ($errors->has('phone_number'))
                                <p class="text-red-500 text-sm mb-2">{{ $errors->first('phone_number') }}</p>
                                @endif
                                @if(isset($buyer) && $buyer->phone_number)
                                <input
                                    type="text"
                                    name="phone_number"
                                    value="{{ $buyer->phone_number }}"
                                    readonly
                                    required
                                    class="block w-full h-14 text-lg px-4 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 focus:outline-none cursor-not-allowed"
                                    placeholder="08123456789">
                                @else
                                <input
                                    type="text"
                                    name="phone_number"
                                    value="{{ old('phone_number') }}"
                                    required
                                    class="input-focus block w-full h-14 text-lg px-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300"
                                    placeholder="08123456789">
                                @endif
                            </label>
                        </div>

                        <!-- Name -->
                        <div class="group">
                            <label class="block mb-3">
                                <div class="flex items-center space-x-2 mb-3">
                                    <i class="fas fa-user text-blue-500"></i>
                                    <span class="text-lg font-semibold text-gray-700">Full Name</span>
                                </div>
                                @if(!empty($buyer?->name))
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $buyer->name ?? '') }}"
                                    readonly
                                    class="block w-full h-14 text-lg px-4 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 focus:outline-none cursor-not-allowed"
                                    placeholder="John Doe">
                                @else
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="input-focus block w-full h-14 text-lg px-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300"
                                    placeholder="John Doe">
                                @endif
                            </label>
                        </div>

                        <!-- Address -->
                        <div class="group">
                            <label class="block mb-3">
                                <div class="flex items-center space-x-2 mb-3">
                                    <i class="fas fa-map-marker-alt text-blue-500"></i>
                                    <span class="text-lg font-semibold text-gray-700">Shipping Address</span>
                                </div>
                                <input
                                    type="text"
                                    name="address"
                                    value="{{ old('address', $buyer->address ?? '') }}"
                                    required
                                    class="input-focus block w-full h-14 text-lg px-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300"
                                    placeholder="Dusseldorf, Germany">
                            </label>
                        </div>

                        <!-- Quantity -->
                        @if (!$isCart && $product)
                        <div class="group">
                            <label class="block mb-6">
                                <div class="flex items-center space-x-2 mb-3">
                                    <i class="fas fa-cubes text-blue-500"></i>
                                    <span class="text-lg font-semibold text-gray-700">Quantity</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button type="button" onclick="decreaseQuantity()"
                                        class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-all duration-200">
                                        <i class="fas fa-minus text-gray-600"></i>
                                    </button>
                                    <input id="quantity" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                        class="input-focus w-20 h-12 text-xl font-semibold text-center border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                                        onchange="updateSubtotalOnly()">
                                    <button type="button" onclick="increaseQuantity()"
                                        class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-all duration-200">
                                        <i class="fas fa-plus text-gray-600"></i>
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <p class="text-m">Stock : {{ $product->stock }}</p>
                                </div>
                            </label>
                        </div>
                        @endif

                        <!-- Payment Method -->
                        <div class="group">
                            <div class="flex items-center space-x-2 mb-4">
                                <i class="fas fa-credit-card text-blue-500"></i>
                                <span class="text-2xl font-bold text-gray-900">Payment Method</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="payment-option border-2 border-gray-200 rounded-xl p-4" onclick="selectPayment('BANK BCA')">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="BANK BCA" class="text-blue-500">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">BCA</span>
                                            </div>
                                            <span class="font-semibold">Bank BCA</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2 ml-6">Admin fee: IDR 350,000</p>
                                </div>

                                <div class="payment-option border-2 border-gray-200 rounded-xl p-4" onclick="selectPayment('BANK MANDIRI')">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="BANK MANDIRI" class="text-blue-500">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-yellow-500 rounded flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">MDR</span>
                                            </div>
                                            <span class="font-semibold">Bank Mandiri</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2 ml-6">Admin fee: IDR 300,000</p>
                                </div>

                                <div class="payment-option border-2 border-gray-200 rounded-xl p-4" onclick="selectPayment('BANK BNI')">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="BANK BNI" class="text-blue-500">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-orange-500 rounded flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">BNI</span>
                                            </div>
                                            <span class="font-semibold">Bank BNI</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2 ml-6">Admin fee: IDR 260,000</p>
                                </div>

                                <div class="payment-option border-2 border-gray-200 rounded-xl p-4" onclick="selectPayment('BANK BRI')">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="BANK BRI" class="text-blue-500">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-red-500 rounded flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">BRI</span>
                                            </div>
                                            <span class="font-semibold">Bank BRI</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2 ml-6">Admin fee: IDR 250,000</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="checkoutBtn"
                            class="btn-hover w-full h-16 font-bold bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-xl text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                            disabled>
                            <i class="fas fa-lock"></i>
                            <span>Place Order</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kanan: Order Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="product-card rounded-2xl card-shadow overflow-hidden">
                        <!-- Header -->
                        <div class="gradient-bg text-white p-6">
                            <h3 class="text-xl font-bold flex items-center space-x-2">
                                <i class="fas fa-receipt"></i>
                                <span>Order Summary</span>
                            </h3>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            @if ($isCart)
                            <div class="space-y-3 mb-6">
                                @foreach ($cartItems as $item)
                                <a href="{{ route('product.detail', $item['product_id']) }}" class="block group border border-gray-200 rounded-lg p-3 hover:shadow transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition">
                                                {{ $item['name'] }}
                                            </h4>
                                            <p class="text-xs text-gray-500">{{ $item['type'] ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                        <div class="text-sm font-bold text-gray-800">
                                            Rp{{ number_format($item['total_price'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @elseif (!empty($product))
                            <div class="flex items-start space-x-4 mb-6">
                                <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-gray-900">{{ $product->product_name }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">{{ $product->type }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Price Breakdown -->
                            <div class="space-y-4 border-t pt-4">
                                @php $subtotalAmount = $isCart ? $subtotal : ($product->price ?? 0); @endphp
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span id="subtotal" class="font-semibold">IDR {{ number_format($subtotalAmount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 flex items-center space-x-1">
                                        <i class="fas fa-percentage text-xs"></i>
                                        <span>Tax</span>
                                    </span>
                                    <span id="tax" class="font-semibold">-</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 flex items-center space-x-1">
                                        <i class="fas fa-truck text-xs"></i>
                                        <span>Shipping</span>
                                    </span>
                                    <span id="shipping" class="font-semibold">-</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 flex items-center space-x-1">
                                        <i class="fas fa-university text-xs"></i>
                                        <span>Bank Fee</span>
                                    </span>
                                    <span id="bankCharge" class="font-semibold">-</span>
                                </div>

                                <div class="border-t pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-gray-900">Total</span>
                                        <span id="total" class="text-2xl font-bold price-highlight">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Notice -->
                        <div class="bg-red-50 border-t border-red-100 p-6">
                            <div class="flex items-start space-x-3">
                                <div class="relative">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                    <div class="absolute -inset-1 pulse-ring bg-red-500 rounded-full opacity-20"></div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-red-800 mb-2">Important Notice</h4>
                                    <p class="text-sm text-red-700 mb-1">Please review your order carefully before checkout.</p>
                                    <p class="text-sm text-red-700">Once confirmed, your order will be processed immediately.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data untuk JavaScript -->
    <script>
        // Data dari PHP untuk JavaScript
        const checkoutData = {
            isCart: @json($isCart),
            productPrice: @if(!$isCart && isset($product)) {{ $product->price }} @else 0 @endif,
            subtotalCart: @if($isCart) {{ $subtotal }} @else 0 @endif
        };
    </script>

    <!-- Include JavaScript -->
    <script src="{{ asset('js/checkout.js') }}"></script>
</body>

</html>