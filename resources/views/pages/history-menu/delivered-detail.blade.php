@extends('layout.history-menu')

@section('title', 'Delivered Detail')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    'COMPLETED' => 100,
    ];

    $currentKey = $firstPayment->transaction_status ?? 'UNPAID';
    $progressPercent = $statusProgress[$currentKey] ?? 0;

    $steps = [
    ['label' => 'Order Placed', 'icon' => 'fas fa-check'],
    ['label' => 'Processing', 'icon' => 'fas fa-hourglass-half'],
    ['label' => 'Shipping', 'icon' => 'fas fa-truck'],
    ['label' => 'Delivered', 'icon' => 'fas fa-box'],
    ];

    $activeStep = match ($currentKey) {
    'COMPLETED' => 4,
    'DELIVERED' => 3,
    'SHIPPING' => 3,
    'PROCESSED' => 2,
    'NOT YET PROCESSED' => 1,
    'PAID', 'UNPAID' => 1,
    default => 1,
    };
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

    <!-- Milestone Shipping -->
    @php
    $milestones = [
    'order_ship_out' => 'At Warehouse',
    'order_display' => 'Arrived at Transit Hub',
    'haven_staged' => 'At Destination Distribution Center',
    'out_for_delivery' => 'With Delivery Courier',
    'mission_accomplished' => 'Delivered to Recipient'
    ];

    $shippingData = \App\Models\Shipping::where('payment_id', $firstPayment->payment_id)->get()->keyBy('status');
    @endphp

    <div class="bg-white shadow-sm p-4 border-t border-gray-200 mt-4 rounded-b-lg">
        <h2 class="text-lg font-semibold mb-4">Order History</h2>
        <div class="relative pl-6">
            <div class="absolute top-0 left-2 w-0.5 h-full bg-gray-200"></div>
            @foreach ($milestones as $status => $label)
            @php
            $milestone = $shippingData->get($status);
            $isCompleted = !is_null($milestone);
            @endphp
            <div class="mb-6 relative">
                <div class="absolute -left-4 w-4 h-4 rounded-full border-2 border-white 
                        {{ $isCompleted ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                <div class="ml-4">
                    <h3 class="font-medium {{ $isCompleted ? 'text-black' : 'text-gray-500' }}">{{ $label }}</h3>
                    @if ($isCompleted)
                    <p class="text-xs text-gray-500">Last updated: {{ \Carbon\Carbon::parse($milestone->created_at)->format('d M Y, H:i') }}</p>
                    <p class="text-xs text-gray-600 mt-1">Current Location: {{ $milestone->location }}</p>
                    <p class="text-xs text-gray-600">{{ $milestone->description }}</p>
                    @else
                    <p class="text-xs text-gray-400">Pending delivery update</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Done Button -->
    <div class="mt-4 text-center">
        <div class="bg-white shadow-sm px-6 py-4 border border-gray-200 rounded-lg inline-block mx-auto mt-4 text-center">
            <p class="text-2xl font-semibold text-gray-700 m-6">
                Has the package arrived ?
            </p>
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-8 rounded-md done-btn"
                data-id="{{ $firstPayment->payment_id }}">
                Yes !
            </button>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.done-btn').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.getAttribute('data-id');

            fetch(`/mole/pages/history/${paymentId}/done`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.error || 'Something went wrong.'
                        });
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Retrieved!',
                        text: 'Order completed successfully and experience added!',
                        timer: 2000,
                        timerProgressBar: true,
                        customClass: {
                            confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded'
                        }
                    }).then(() => {
                        window.location.href = `/mole/pages/history/completed/${paymentId}`;
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Failed to connect to server.'
                    });
                });
        });
    });
</script>
@endsection