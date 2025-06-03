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

        .checkmark-circle {
            width: 80px;
            height: 80px;
            border: 4px solid #28a745;
            border-radius: 50%;
            position: relative;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkmark-circle::after {
            content: "";
            width: 20px;
            height: 40px;
            border-right: 4px solid #28a745;
            border-bottom: 4px solid #28a745;
            transform: rotate(45deg);
            position: absolute;
            bottom: 20%;
            left: 35%;
        }
    </style>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen p-4">
    <div class="h-screen max-w-4xl w-full bg-white rounded-md shadow-lg flex flex-col md:flex-row overflow-hidden" style="min-height: 480px">
        <!-- Left panel -->
        <div class="bg-white w-full md:w-72 flex flex-col items-center justify-center gap-4 mt-10 p-8 border-r border-gray-300">
            <div class="w-16 h-16 rounded-full border-4 border-[#2f9e44] flex items-center justify-center">
                <svg class="w-8 h-8 text-[#2f9e44]" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="text-center">
                <p class="text-xs text-black mt-3 leading-tight">
                    Your order has been processed..
                </p>
            </div>
            <!-- Left panel -->
            <div class="w-full mt-10 text-xs text-black">
                <div class="flex justify-between mb-3">
                    <span>Order ID:</span>
                    <span class="font-bold">{{ $payment->order_id }}</span>
                </div>
                <div class="flex justify-between mb-3">
                    <span>Date:</span>
                    <span>{{ $payment->payment_date }}</span>
                </div>
                <div class="flex justify-between mb-3">
                    <span>Name:</span>
                    <span>{{ $payment->name }}</span>
                </div>
                <div class="flex justify-between mb-3">
                    <span>Phone:</span>
                    <span>{{ $payment->phone_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Address:</span>
                    <span class="text-right">{{ $payment->address }}</span>
                </div>
            </div>
            <a href="{{ route('payment.receipt.download', ['payment_id' => $payment->payment_id]) }}" class="mt-auto w-full border border-gray-300 text-gray-700 text-xs py-2 rounded-md hover:bg-gray-50 transition text-center block">
                Download Receipt
            </a>

        </div>
        <!-- Right panel -->
        <div class="flex-1 bg-white p-8 flex flex-col gap-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-900 text-xl">
                    Payment Receipt
                </h2>
                <button aria-label="Close" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times">
                    </i>
                </button>
            </div>
            <div class="border border-gray-300 rounded-md p-6 mb-8">
                <div class="flex flex-col items-center mb-4">
                    <p class="text-green-700 mb-3 font-semibold text-base">
                        Payment Info!
                    </p>
                    <p class="text-gray-500 text-xs text-center w-full">
                        Your order has been Add to order status, please check !
                        <br>
                        Info : If you done for payment please check your order list
                    </p>
                </div>
                <!-- Right panel: Payment Method & Status -->
                <div class="text-xs text-black w-full">
                    <div class="flex justify-between mb-2">
                        <span>Name Store:</span>
                        <span>Market Place of Legends</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Payment Method:</span>
                        <span>{{ $payment->payment_method }}</span>
                    </div>
                    <div class="flex justify-between font-semibold mb-2">
                        <span>Virtual Account Number:</span>
                        <span>{{ $payment->payment_code }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Payment Status:</span>
                        <span>{{ $payment->payment_status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Transaction Status:</span>
                        <span>{{ $payment->transaction_status }}</span>
                    </div>
                </div>
            </div>
            <div class="border border-transparent rounded-md p-4 mb-7 w-full text-xs text-black">
                <p class="font-semibold mb-3 text-base text-black">
                    Order Details
                </p>
                <!-- Order Details -->
                <div class="flex justify-between mb-2">
                    <span>Product:</span>
                    <span>{{ $payment->product_name }}</span>
                </div>
                <div class="flex justify-between mb-2 border-t border-gray-300 pt-2">
                    <span>Quantity:</span>
                    <span>{{ $payment->quantity }}</span>
                </div>
                <div class="flex justify-between mb-2 border-t border-gray-300 pt-2">
                    <span>Subtotal:</span>
                    <span>IDR {{ number_format($payment->price, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold border-t border-gray-300 pt-2 text-gray-900">
                    <span>Total (Tax + Shipping):</span>
                    <span>IDR {{ number_format($payment->price_total, 2, ',', '.') }}</span>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs text-left w-full mb-6 leading-relaxed">
                    Please complete your payment by transferring to the virtual account
                    number shown above. Your order will be processed once payment is
                    verified.
                    <br>
                    Estimated delivery:
                    <span class="font-semibold">
                        3-5 business days
                    </span>
                    after payment
                    verification.
                </p>
            </div>
            <div class="mt-1 pt-3 pb-3">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white text-center text-sm font-semibold w-1/4 px-5 py-2 rounded-md hover:bg-blue-700 transition">
                        Done
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>