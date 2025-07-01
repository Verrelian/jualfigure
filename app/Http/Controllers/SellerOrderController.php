<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Payment;
use App\Models\Produk;

class SellerOrderController extends Controller
{
    public function index()
    {
        $sellerId = \App\Http\Controllers\AuthController::getSellerID();

        if (!$sellerId) {
            abort(403, 'Unauthorized');
        }

        $orders = Payment::where('seller_id', $sellerId)
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.seller.order', compact('orders'));
    }

    public function process($payment_id)
{
    $order = Payment::where('payment_id', $payment_id)->firstOrFail();

    if ($order->payment_status === 'PAID' && $order->transaction_status === 'NOT YET PROCESSED') {
        // Ambil produk berdasarkan ID dari payment
        $product = Produk::where('product_id', $order->product_id)->first();

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan.'], 404);
        }

        // Validasi stok cukup
        if ($product->stock < $order->quantity) {
            return response()->json(['error' => 'Stok produk tidak mencukupi.'], 400);
        }

        // Kurangi stok
        $product->stock -= $order->quantity;

        // Tambahkan ke total penjualan
        $product->sold += $order->quantity;

        // Simpan perubahan produk
        $product->save();

        // Update status transaksi
        $order->transaction_status = 'PROCESSED';
        $order->shipping_ready_at = Carbon::now()->addSecond(10);
        $order->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['error' => 'Pesanan tidak dapat diproses.'], 400);
}

    public function cancel($payment_id)
    {
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();

        if (in_array($order->payment_status, ['PAID']) && $order->transaction_status !== 'CANCELED') {
            $order->transaction_status = 'CANCELED';
            $order->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Pesanan tidak dapat dibatalkan.'], 400);
    }

    public function show()
    {
        $order = Payment::findOrFail();
        return view('pages.seller.order-detail', compact('payment'));
    }

    public function fetch($payment_id)
    {
        $sellerId = \App\Http\Controllers\AuthController::getSellerID();

        $order = Payment::where('seller_id', $sellerId)
        ->where('payment_id', $payment_id)
        ->firstOrFail();

        return response()->json([
            'id'              => $order->payment_id,
            'order_id'        => $order->order_id,
            'name'            => $order->name,
            'date'            => \Carbon\Carbon::parse($order->payment_date)->format('d M Y H:i'),
            'status'          => $order->payment_status === 'PAID'
                ? ($order->transaction_status === 'PROCESSED' ? 'Diproses' : 'Menunggu Konfirmasi')
                : 'Belum Dibayar',
            'total'           => number_format($order->price_total, 0, ',', '.'),
            'address'         => $order->address,
            'items'           => [
                [
                    'name'     => $order->product_name,
                    'qty'      => $order->quantity,
                    'price'    => number_format($order->price, 0, ',', '.'),
                    'subtotal' => number_format($order->price * $order->quantity, 0, ',', '.'),
                ]
            ],
            'raw_status'  => $order->transaction_status,
            'display_status' => $this->getOrderStatus($order),
        ]);
    }

    public function getOrderStatus($payment)
    {
        if ($payment->payment_status === 'UNPAID') {
            return now()->gt($payment->expired_at) ? 'Expired' : 'Waiting for payment';
        }

        if ($payment->payment_status === 'PAID') {
            switch ($payment->transaction_status) {
                case 'CANCELED':
                    return 'Canceled';
                case 'NOT YET PROCESSED':
                    return 'Waiting confirmation';
                case 'PROCESSED':
                    return 'Processed';
                case 'SHIPPING':
                    return 'Shipping';
                case 'DELIVERED':
                    return 'Delivered';
                case 'COMPLETED':
                    return 'Completed';
                default:
                    return 'N/A';
            }
        }

        return 'Unknown';
    }
}
