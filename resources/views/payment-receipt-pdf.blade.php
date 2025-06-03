<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Payment Receipt
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-4xl w-full bg-white rounded-md shadow-lg flex flex-col md:flex-row overflow-hidden" style="min-height: 480px">
        <!-- Left panel -->
        <div class="bg-white w-full md:w-72 flex flex-col items-center justify-center gap-4 p-8 border-r border-gray-200">
            <img alt="Green check mark icon inside a circle representing payment success" class="w-16 h-16" height="64" src="https://storage.googleapis.com/a1aa/image/2099399e-07b6-4db3-deab-f00430368fd9.jpg" width="64" />
            <div class="text-center">
                <p class="text-green-700 font-semibold text-sm">
                    Payment info!
                </p>
                <p class="text-xs text-gray-600 mt-1 leading-tight">
                    Your order has been processed..
                </p>
            </div>
            <!-- Left panel -->
            <div class="w-full mt-6 text-xs text-gray-700">
                <div class="flex justify-between mb-1">
                    <span>Order ID:</span>
                    <span class="font-bold">{{ $payment->order_id }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span>Date:</span>
                    <span>{{ $payment->payment_date }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span>Name:</span>
                    <span>{{ $payment->name }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span>Phone:</span>
                    <span>{{ $payment->phone_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Address:</span>
                    <span class="text-right">{{ $payment->address }}</span>
                </div>
                <!-- Right panel -->
                <div class="flex-1 bg-white p-8 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-semibold text-gray-900 text-base">
                            Payment Receipt
                        </h2>
                        <button aria-label="Close" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-times">
                            </i>
                        </button>
                    </div>
                    <div class="border border-gray-100 rounded-md p-6 mb-6">
                        <div class="flex flex-col items-center mb-4">
                            <img alt="Green check mark icon inside a circle representing payment success" class="w-12 h-12 mb-2" height="48" src="https://storage.googleapis.com/a1aa/image/2099399e-07b6-4db3-deab-f00430368fd9.jpg" width="48" />
                            <p class="text-green-700 font-semibold text-sm">
                                Payment!
                            </p>
                            <p class="text-gray-700 text-xs text-center max-w-[320px]">
                                Your order has been Add to order status please check.
                            </p>
                        </div>
                        <p class="text-gray-700 text-xs mb-4 max-w-[320px]">
                            Info:If you done for payment please check your order list
                            <br />
                            Name Store:Market Place of Legends
                        </p>
                        <!-- Right panel: Payment Method & Status -->
                        <div class="text-xs text-gray-700 max-w-[320px]">
                            <div class="flex justify-between mb-1">
                                <span>Payment Method:</span>
                                <span>{{ $payment->payment_method }}</span>
                            </div>
                            <div class="flex justify-between font-semibold mb-1">
                                <span>Virtual Account Number:</span>
                                <span>{{ $payment->payment_code }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Payment Status:</span>
                                <span>{{ $payment->payment_status }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Transaction Status:</span>
                                <span>{{ $payment->transaction_status }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="border border-gray-100 rounded-md p-4 mb-6 max-w-[320px] text-xs text-gray-700">
                        <p class="font-semibold mb-3 text-gray-900">
                            Order Details
                        </p>
                        <!-- Order Details -->
                        <div class="flex justify-between mb-1">
                            <span>Product:</span>
                            <span>{{ $payment->product_name }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Quantity:</span>
                            <span>{{ $payment->quantity }}</span>
                        </div>
                        <div class="flex justify-between mb-1 border-t border-gray-200 pt-2">
                            <span>Subtotal:</span>
                            <span>IDR {{ number_format($payment->price, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Shipping:</span>
                            <span>IDR 8,000.00</span> <!-- Placeholder tetap -->
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Tax:</span>
                            <span>IDR 0.00</span> <!-- Placeholder tetap -->
                        </div>
                        <div class="flex justify-between font-bold border-t border-gray-200 pt-2 text-gray-900">
                            <span>Total:</span>
                            <span>IDR {{ number_format($payment->price_total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs max-w-[320px] mb-6 leading-relaxed">
                        Please complete your payment by transferring to the virtual account
                        number shown above. Your order will be processed once payment is
                        verified.
                        <br />
                        Estimated delivery:
                        <span class="font-semibold">
                            3-5 business days
                        </span>
                        after payment
                        verification.
                    </p>
                </div>
            </div>
</body>

</html>