@extends('layout.apps')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Detail Pesanan</h2>

    <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
    <p><strong>Nama Pembeli:</strong> {{ $payment->name }}</p>
    <p><strong>Produk:</strong> {{ $payment->product_name }}</p>
    <p><strong>Jumlah:</strong> {{ $payment->quantity }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($payment->price_total, 0, ',', '.') }}</p>
    <p><strong>Status Pembayaran:</strong> {{ $payment->payment_status }}</p>
    <p><strong>Status Transaksi:</strong> {{ $payment->transaction_status }}</p>
    <p><strong>Alamat:</strong> {{ $payment->address }}</p>
    <p><strong>No. HP:</strong> {{ $payment->phone_number }}</p>
</div>
@endsection