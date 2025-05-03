@extends('layout.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Order Status</h1>

    @if(isset($order))
        {{-- Detail pesanan tunggal --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold">{{ $order['title'] }}</h2>
                    <p class="text-sm text-gray-600">Order ID: #{{ $order['id'] }}</p>
                </div>
                <div>
                    @php
                        $statusColor = match($order['status']) {
                            'processing' => 'bg-yellow-100 text-yellow-800',
                            'shipping' => 'bg-blue-100 text-blue-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'done' => 'bg-gray-100 text-gray-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                        $statusLabel = ucfirst($order['status']);
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
            
            {{-- Tampilkan pesan konfirmasi jika status 'done' --}}
            @if($order['status'] === 'done')
                <div class="bg-green-50 text-green-800 p-4 rounded-md mb-4">
                    <p>Thank you! Your order has been Packed.</p>
                </div>
            @endif
            
            <p class="text-sm text-gray-600">Order date: {{ $order['date'] }}</p>
            
            {{-- Informasi produk --}}
            <div class="mt-4">
                <h3 class="font-medium mb-2">Product</h3>
                <div class="flex gap-4">
                    <img src="{{ asset($order['product']['image']) }}" alt="Product Image" class="w-16 h-16 object-cover rounded-md">
                    <div>
                        <p class="font-semibold">{{ $order['product']['name'] }}</p>
                        <p class="text-sm text-gray-500">{{ $order['product']['specs'] }}</p>
                        <p class="text-sm mt-1">Quantity: {{ $order['product']['quantity'] }}</p>
                    </div>
                </div>
            </div>
            
            {{-- Tombol kembali ke daftar pesanan --}}
            <div class="mt-6">
                <a href="{{ route('order.status') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium">
                    Back to All Orders
                </a>
            </div>
        </div>
    @else
        {{-- Daftar semua pesanan --}}
        <div class="grid gap-4">
            @foreach($orders as $order)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold">{{ $order['title'] }}</h2>
                            <p class="text-sm text-gray-600">Order ID: #{{ $order['id'] }}</p>
                            <p class="text-sm text-gray-600">Date: {{ $order['date'] }}</p>
                        </div>
                        <div class="flex flex-col items-end">
                            @php
                                $statusColor = match($order['status']) {
                                    'processing' => 'bg-yellow-100 text-yellow-800',
                                    'shipping' => 'bg-blue-100 text-blue-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'done' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                $statusLabel = ucfirst($order['status']);
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }} mb-2">
                                {{ $statusLabel }}
                            </span>
                            <a href="{{ route('order.status', ['id' => $order['id']]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection