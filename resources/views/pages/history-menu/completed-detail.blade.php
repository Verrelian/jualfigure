@extends('layout.history-menu')

@section('title', 'Completed Detail')
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

    if ($firstPayment->transaction_status === 'COMPLETED') {
    $currentKey = 'COMPLETED';
    $activeStep = 4;
    } elseif ($firstPayment->transaction_status === 'DELIVERED') {
    $currentKey = 'DELIVERED';
    $activeStep = 3;
    } elseif ($firstPayment->transaction_status === 'SHIPPING') {
    $currentKey = 'SHIPPING';
    $activeStep = 3;
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
        <div
            class="flex border-b border-gray-200 pb-4 mb-4 rounded-md p-2 hover:bg-gray-50 cursor-pointer relative group"
            onclick="openRatingModal('{{ $item->payment_id }}', {{ $item->rating ?? 0 }})">
            <div class="w-20 h-20 flex-shrink-0 relative overflow-hidden rounded-md">
                <img src="{{ asset('images/' . $item->image) }}" alt="Product" class="w-full h-full object-cover rounded-md">

                <div class="absolute top-0 left-0 transform -rotate-45 -translate-x-7 translate-y-3 w-24 text-center text-xs font-semibold py-px 
                {{ $item->rating === null ? 'bg-gray-500/70 text-black' : 'bg-yellow-500/70 text-white' }}">
                    {{ $item->rating === null ? 'UNRATED' : 'RATED' }}
                </div>
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
            <!-- Vertical Line -->
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
                    <p class="text-xs text-gray-500">
                        Last updated: {{ \Carbon\Carbon::parse($milestone->created_at)->format('d M Y, H:i') }}
                    </p>
                    <p class="text-xs text-gray-600 mt-1">
                        Current Location: {{ $milestone->location }}
                    </p>
                    <p class="text-xs text-gray-600">
                        {{ $milestone->description }}
                    </p>
                    @else
                    <p class="text-xs text-gray-400">Pending delivery update</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if ($firstPayment->transaction_status === 'SHIPPING')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentId = @json($firstPayment->payment_id);
            const csrfToken = @json(csrf_token());

            function checkAndUpdateStage() {
                fetch(`/mole/shipping/progress-data/${paymentId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.diff >= 10) {
                            fetch(`/mole/shipping/next-stage/${paymentId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.stage_index !== undefined) {
                                        location.reload();
                                    }
                                });
                        }
                    });
            }

            setInterval(checkAndUpdateStage, 3000);
        });
    </script>
    @endif

    <div id="ratingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-md text-center">
            <h2 class="text-lg font-semibold mb-4">Is the package in line with your expectations?</h2>

            <div id="stars" class="flex justify-center space-x-2 mb-6 select-none">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" aria-label="Rate {{ $i }} star" class="focus:outline-none" data-value="{{ $i }}">
                    <i class="fas fa-star text-gray-400 text-4xl cursor-pointer"></i>
                    </button>
                    @endfor
            </div>

            <input type="hidden" id="active_payment_id" value="">

            <div class="flex justify-center gap-4 mt-4">
                <button onclick="closeRatingModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                    Cancel
                </button>
                <button id="submitRating" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-6 rounded">
                    Rating!
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    let selectedRating = 0;

    function openRatingModal(paymentId, existingRating) {
        selectedRating = existingRating || 0;
        document.getElementById('active_payment_id').value = paymentId;
        updateStars(selectedRating);
        document.getElementById('ratingModal').classList.remove('hidden');
        document.getElementById('ratingModal').classList.add('flex');
    }

    function closeRatingModal() {
        selectedRating = 0;
        updateStars(0);
        document.getElementById('ratingModal').classList.remove('flex');
        document.getElementById('ratingModal').classList.add('hidden');
    }

    function updateStars(rating) {
        const stars = document.querySelectorAll('#stars button i');
        stars.forEach((star, index) => {
            star.classList.toggle('text-yellow-400', index < rating);
            star.classList.toggle('text-gray-400', index >= rating);
        });
    }

    document.querySelectorAll('#stars button').forEach(button => {
        button.addEventListener('click', () => {
            selectedRating = parseInt(button.getAttribute('data-value'));
            updateStars(selectedRating);
        });
    });

    document.getElementById('submitRating').addEventListener('click', () => {
        const paymentId = document.getElementById('active_payment_id').value;

        if (selectedRating === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Silakan pilih rating terlebih dahulu.'
            });
            return;
        }

        fetch(`/mole/pages/history/${paymentId}/rate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    rating: selectedRating
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You!',
                        text: 'Rating added successfully!',
                        customClass: {
                            confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.error || 'Terjadi kesalahan.',
                        customClass: {
                            confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded'
                        }
                    });
                }
            });
    });
</script>

@endsection