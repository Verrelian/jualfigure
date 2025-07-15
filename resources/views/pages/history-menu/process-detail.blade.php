@extends('layout.history-menu')

@section('title', 'Process Detail')

@section('historyContent')
<div class="container mx-auto px-4 py-6 min-w-full">
    <!-- Header -->
    <div class="bg-white rounded-t-lg shadow-sm p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-bold">Order {{ $firstPayment->order_id }}</h1>
            <a href="{{ route('payment.receipt', ['payment_id' => $firstPayment->payment_id]) }}" class="text-sm text-blue-600 hover:underline">View Invoice</a>
        </div>
    </div>

    @php
    $statusProgress = [
    'UNPAID' => 25,
    'PAID' => 25,
    'NOT YET PROCESSED' => 37.5,
    'PROCESSED' => 50,
    'SHIPPING' => 75,
    'DELIVERED' => 100,
    ];

    if ($firstPayment->transaction_status === 'DELIVERED') {
    $currentKey = 'DELIVERED';
    $activeStep = 3;
    } elseif ($firstPayment->transaction_status === 'SHIPPING') {
    $currentKey = 'SHIPPING';
    $activeStep = 2.5;
    } elseif ($firstPayment->payment_status === 'PAID' && $firstPayment->transaction_status === 'PROCESSED') {
    $currentKey = 'PROCESSED';
    $activeStep = 2;
    } elseif ($firstPayment->payment_status === 'PAID' && $firstPayment->transaction_status === 'NOT YET PROCESSED') {
    $currentKey = 'NOT YET PROCESSED';
    $activeStep = 1;
    } elseif ($firstPayment->payment_status === 'PAID') {
    $currentKey = 'PAID';
    $activeStep = 1;
    } else {
    $currentKey = 'UNPAID';
    $activeStep = 1;
    }

    $progressPercent = $statusProgress[$currentKey];

    $steps = [
    ['label' => 'Order Placed', 'icon' => 'fas fa-check'],
    ['label' => 'Processing', 'icon' => 'fas fa-hourglass-half'],
    ['label' => 'Shipping', 'icon' => 'fas fa-truck'],
    ['label' => 'Delivered', 'icon' => 'fas fa-box'],
    ];
    @endphp

    <!-- Milestone Horizontal -->
    <div class="bg-white shadow-sm p-4 border-t border-gray-200">
        <div class="flex justify-between mb-6 relative z-10">
            @foreach ($steps as $index => $step)
            <div class="text-center w-1/4">
                <div class="w-8 h-8 rounded-full 
                    {{ $activeStep > $index ? 'bg-green-500' : ($activeStep == $index ? 'bg-blue-500' : 'bg-gray-300') }} 
                    text-white flex items-center justify-center mx-auto mb-2">
                    <i class="{{ $step['icon'] }} text-sm"></i>
                </div>
                <p class="text-xs font-medium 
                    {{ $activeStep > $index ? 'text-green-500' : ($activeStep == $index ? 'text-blue-500' : 'text-gray-500') }}">
                    {{ $step['label'] }}
                </p>
            </div>
            @endforeach
        </div>

        <!-- Progress bar -->
        <div class="relative h-2">
            <div class="absolute top-0 left-0 w-full h-2 bg-gray-200 rounded-full"></div>
            <div class="absolute top-0 left-0 h-2 bg-blue-500 rounded-full transition-all duration-300 ease-in-out"
                style="width: {{ $progressPercent }}%"></div>
        </div>
    </div>

    <!-- Shipping Info -->
    <div class="bg-white shadow-sm p-4 border-t border-gray-200">
        <h2 class="text-lg font-semibold mb-3">Shipping Info</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Recipient</p>
                <p class="text-sm font-medium">{{ $firstPayment->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Phone</p>
                <p class="text-sm font-medium">{{ $firstPayment->phone_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Address</p>
                <p class="text-sm font-medium">{{ $firstPayment->address }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Estimated</p>
                <p class="text-sm font-medium">3-5 business days</p>
            </div>
        </div>
    </div>

    <!-- Product Detail -->
    <div class="bg-white shadow-sm p-4 border-t border-gray-200">
        <h2 class="text-lg font-semibold mb-3">Product Detail</h2>
        @foreach ($relatedPayments as $item)
        <div class="flex border-b border-gray-200 pb-4 mb-4 rounded-md p-2 hover:bg-gray-50">
            <div class="w-20 h-20 flex-shrink-0">
                <img src="{{ asset('images/' . $item->image) }}" alt="Product" class="w-full h-full object-cover rounded-md">
            </div>
            <div class="ml-4 flex-grow">
                <h3 class="font-medium">{{ $item->product_name }}</h3>
                <p class="text-sm text-gray-500">Type: {{ $item->type }}</p>
                <div class="flex justify-between mt-2">
                    <span class="text-sm">x{{ $item->quantity }}</span>
                    <span class="text-sm font-semibold">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
        <div class="flex justify-between border-b border-gray-200 py-2 text-sm">
            <span>Subtotal</span>
            <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between font-bold border-t border-gray-200 pt-2 text-gray-900 text-sm">
            <span>Total (Tax + Shipping + Fee):</span>
            <span>IDR {{ number_format($total, 2, ',', '.') }}</span>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('history.process') }}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-8 rounded-md">
                Done
            </button>
        </a>
    </div>
</div>

@endsection