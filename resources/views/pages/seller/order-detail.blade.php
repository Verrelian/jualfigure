@extends('layout.apps')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Order Detail</h2>

    <p><strong>Order ID:</strong> {{ $order_id }}</p>
    <p><strong>Nama Pembeli:</strong> {{ $buyer_name }}</p>
    <p><strong>Alamat:</strong> {{ $address }}</p>
    <p><strong>No. HP:</strong> {{ $phone }}</p>
    <p><strong>Status Pembayaran:</strong> {{ $status }}</p>
    <p><strong>Status Transaksi:</strong> {{ $transaction_status }}</p>

    <hr class="my-4">

    <h3 class="text-xl font-semibold mb-2">Daftar Produk</h3>
    <ul class="space-y-2 text-lg">
        @foreach ($payments as $p)
        <li>• {{ $p->product_name }} x{{ $p->quantity }} — Rp{{ number_format($p->price, 0, ',', '.') }}</li>
        @endforeach
    </ul>

    <p class="mt-4 text-xl font-bold text-green-700">
        Total: Rp{{ number_format($total, 0, ',', '.') }}
    </p>
</div>
@endsection