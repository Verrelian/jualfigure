<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>
        Payment Receipt
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet">
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
        <div class="bg-white w-full md:w-72 flex flex-col items-center gap-4 mt-10 p-8 border-r border-gray-300">
            @php
            $now = now();
            $isExpired = $payment->payment_status === 'UNPAID' && $payment->expired_at <= $now;
                $isCanceled=$payment->payment_status === 'PAID' && $payment->transaction_status === 'CANCELED';
                @endphp

                @php
                $isCompleted = $payment->transaction_status === 'COMPLETED';
                @endphp

                <div class="w-16 h-16 rounded-full border-4 flex items-center justify-center
@if ($isCompleted)
    border-blue-600 text-blue-600
@elseif ($isExpired || $isCanceled)
    border-red-600 text-red-600
@elseif ($payment->payment_status === 'PAID')
    border-green-600 text-green-600
@else
    border-yellow-500 text-yellow-500
@endif
">
                    @if ($isCompleted)
                    <!-- Ikon bintang atau centang premium -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                    @elseif ($isExpired || $isCanceled)
                    <!-- Ikon silang -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    @elseif ($payment->payment_status === 'PAID')
                    <!-- Ikon centang -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    @else
                    <!-- Ikon jam pasir -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 2h12M6 22h12M8 2v3a6 6 0 0012 0V2M8 22v-3a6 6 0 0112 0v3" />
                    </svg>
                    @endif
                </div>

                <div class="mt-2 font-semibold
@if ($isCompleted)
    text-blue-700
@elseif ($isExpired || $isCanceled)
    text-red-600
@elseif ($payment->payment_status === 'PAID')
    text-green-700
@else
    text-yellow-600
@endif
">
                    @if ($isCompleted)
                    <p class="text-center">Order completed successfully!</p>
                    @elseif ($isExpired)
                    This payment has expired !
                    @elseif ($isCanceled)
                    <p class="text-center">Your order has been canceled !</p>
                    @elseif ($payment->payment_status === 'PAID')
                    <p class="text-center">Your order has been processed !</p>
                    @else
                    Waiting for payment..
                    <p class="text-center" id="countdown"></p>
                    @endif
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
                @php
                $bankMap = [
                'BANK BNI' => 'bni',
                'BANK BRI' => 'bri',
                'BANK BCA' => 'bca',
                'BANK MANDIRI' => 'mandiri',
                ];

                $bank = $bankMap[$payment->payment_method] ?? 'bni';
                @endphp

                @php
                $now = now();
                $isExpired = $payment->payment_status === 'UNPAID' && $payment->expired_at <= $now;
                    $isCanceled=$payment->payment_status === 'PAID' && $payment->transaction_status === 'CANCELED';
                    @endphp

                    <div class="mt-auto pt-6">
                        @if ($payment->payment_status === 'UNPAID' && !$isExpired && !$isCanceled)
                        <a href="{{ route('bank.payment', ['bank' => $bank]) }}"
                            class="mt-auto w-44 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-center block">
                            Pay Now
                        </a>
                        @elseif ($payment->payment_status === 'PAID')
                        <a href="{{ route('payment.receipt.download', $payment->payment_id) }}"
                            class="mt-auto w-44 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-center block">
                            Download Receipt
                        </a>
                        @endif
                    </div>

        </div>
        <!-- Right panel -->
        <div class="flex-1 bg-white p-8 flex flex-col gap-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-900 text-xl">
                    Payment Receipt
                </h2>
                <a href="{{ url('/history') }}"
                    aria-label="Close"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </a>
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
                    <div class="flex justify-between items-center font-semibold mb-2">
                        @if ($payment->payment_status === 'UNPAID' && !$isExpired && !$isCanceled)
                        <span>Virtual Account Number:</span>
                        <div class="flex items-center gap-2">
                            <span id="va-number" class="font-mono text-sm">{{ $payment->payment_code }}</span>
                            <button onclick="copyVANumber()" class="hover:opacity-75 transition" title="Copy">
                                <img src="{{ asset('images/copy-icon.png') }}" alt="Copy" class="w-5 h-5">
                            </button>
                        </div>
                        @endif
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
                @if ($isCart)
                <div class="flex justify-between mb-2">
                    <span class="w-1/4 font-semibold">Product:</span>
                    <div class="flex-1 text-right space-y-1">
                        @foreach ($payments as $p)
                        <div>{{ $p->product_name }} x{{ $p->quantity }}</div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="flex justify-between mb-2">
                    <span>Product:</span>
                    <span>{{ $payment->product_name }}</span>
                </div>
                <div class="flex justify-between mb-2 border-t border-gray-300 pt-2">
                    <span>Quantity:</span>
                    <span>{{ $payment->quantity }}</span>
                </div>
                @endif
                @if ($isCart)
                <div class="flex justify-between mb-2 border-t border-gray-300 pt-2">
                    <span>Subtotal:</span>
                    <span>IDR {{ number_format($subtotal) }}</span>
                </div>
                <div class="flex justify-between font-bold border-t border-gray-300 pt-2 text-gray-900">
                    <span>Total (Tax + Shipping + Fee):</span>
                    <span>IDR {{ number_format($cartTotal, 2, ',', '.') }}</span>
                </div>
                @else
                <div class="flex justify-between mb-2 border-t border-gray-300 pt-2">
                    <span>Subtotal:</span>
                    <span>IDR {{ number_format($payment->price) }}</span>
                </div>
                <div class="flex justify-between font-bold border-t border-gray-300 pt-2 text-gray-900">
                    <span>Total (Tax + Shipping + Fee):</span>
                    <span>IDR {{ number_format($payment->price_total, 2, ',', '.') }}</span>
                </div>
                @endif
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
            <div class="mt-auto pt-6 flex justify-end">
                <a href="{{ url('/pages/history/placed') }}" class="bg-blue-600 text-white text-center text-sm font-semibold w-1/4 px-5 py-2 rounded-md hover:bg-blue-700 transition">
                    Done
                </a>
            </div>
        </div>
    </div>
    @if ($payment->payment_status === 'UNPAID')
    <script>
        function copyVANumber() {
            const vaText = document.getElementById('va-number');
            const textToCopy = vaText.textContent || vaText.innerText;

            navigator.clipboard.writeText(textToCopy).then(() => {
                showToast("Copied !");
            }).catch(err => {
                showToast("Failed to Copy !");
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.remove('opacity-0');
            toast.classList.add('opacity-100');

            setTimeout(() => {
                toast.classList.add('opacity-0');
                toast.classList.remove('opacity-100');
            }, 2000);
        }

        const expiredAt = new Date("{{ $payment->expired_at }}").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = expiredAt - now;

            if (distance <= 0) {
                document.getElementById("countdown").innerHTML = "Expired";
                // Optional: Reload or disable buttons
                location.reload();
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = `${minutes}m ${seconds}s`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
    @endif

    @if ($payment->payment_status === 'PAID' && $payment->transaction_status === 'CANCELED')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Order Cancelled',
                html: 'Seller has canceled your order due to technical issues. Your money will be refunded within 2x24 hours.<br><br><strong>Contact : {{ $payment->seller->phone_number ?? 'Tidak tersedia' }}</strong> <br>for more info',
                confirmButtonText: 'Oke',
                customClass: {
                    confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded'
                }
            });
        });
    </script>
    @endif

</body>
<div id="toast" class="fixed left-1/2 bottom-52 transform -translate-x-1/2 bg-none text-black text-sm px-4 py-2 rounded opacity-0 transition-opacity duration-300 z-50">
    Copied !
</div>

</html>