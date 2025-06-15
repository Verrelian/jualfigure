<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        BNI Virtual Account
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-white text-gray-900 font-sans p-12">
    <header class="flex items-center space-x-2 mb-6 border-b border-gray-200 pb-4">
        <img src="{{ asset('images/Logo-BNI.png') }}" class="w-48 h-20 object-contain" />
        <h1 class="px-5 text-5xl font-normal">
            Virtual Account
        </h1>
    </header>

    @if (!session('inquired') && !session('payment_success'))
    <!-- FORM INPUT VA NUMBER -->
    <form action="{{ route('bank.validate.va') }}" method="POST" class="max-w-lg">
        @csrf
        <label class="block text-sm text-gray-600 mb-2" for="va-number">
            Virtual Account Number
        </label>
        <input name="payment_code" id="va-number" type="text"
            class="w-full rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
            placeholder="Masukkan kode VA Anda" required />
        <input type="hidden" name="bank" value="bni">

        <button class="mt-6 bg-[#002147] text-white px-5 py-3 rounded-md text-base font-normal" type="submit">
            Inquire
        </button>
    </form>
    @endif

    @if (session('error'))
    <div class="mt-4 bg-red-100 text-red-700 px-4 py-2 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    @if (session('inquired') && session('payment'))

    <h2 class="text-2xl font-semibold mb-2">Payment Summary</h2>
    <ul class="text-md text-gray-700 space-y-1">
        <li class="mt-6 text-lg"><strong>Product :</strong> {{ session('payment')->product_name }}</li>
        <li class="mt-2 text-lg"><strong>Qty :</strong> {{ session('payment')->quantity }}</li>
        <li class="mt-2 text-lg"><strong>Price :</strong> IDR {{ number_format(session('payment')->price) }}</li>
        <li class="mt-2 text-lg"><strong>Shipping :</strong> IDR {{ number_format(session('payment')->shipping) }}</li>
        <li class="mt-2 text-lg"><strong>Tax :</strong> IDR {{ number_format(session('payment')->tax) }}</li>
        <li class="mt-2 text-lg"><strong>Total :</strong> <span class="text-lg font-bold text-green-700">IDR {{ number_format(session('payment')->price_total) }}</span></li>
    </ul>

    <!-- Tombol Pay -->
    <form action="{{ route('bank.process.payment') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="payment_id" value="{{ session('payment')->payment_id }}">
        <button type="submit" class="w-44 mt-8 bg-green-700 text-white px-4 py-2 rounded-md">Pay</button>
    </form>

    @endif

    @if (session('payment_success') && session('receipt_payment_id'))
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        Payment Successful!
    </div>

    <a href="{{ route('payment.receipt', ['payment_id' => session('receipt_payment_id')]) }}"
        class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Back to Receipt
    </a>
    @endif

</body>

</html>