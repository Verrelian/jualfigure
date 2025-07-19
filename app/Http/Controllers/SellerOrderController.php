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

        $grouped = Payment::selectRaw('MIN(payment_id) as payment_id')
            ->where('seller_id', $sellerId)
            ->groupBy('order_id')
            ->pluck('payment_id');

        $orders = Payment::whereIn('payment_id', $grouped)->get();

        return view('pages.seller.order', compact('orders'));
    }

    public function process($payment_id)
    {
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();

        // Ambil semua record 1 transaksi berdasarkan order_id (bisa cart, bisa 1 produk)
        $relatedOrders = Payment::where('order_id', $order->order_id)->get();

        // Cek apakah semua order ini statusnya masih "NOT YET PROCESSED"
        $shouldProcess = $relatedOrders->every(function ($item) {
            return $item->transaction_status === 'NOT YET PROCESSED';
        });

        if (!$shouldProcess) {
            return response()->json(['error' => 'Beberapa item sudah diproses sebelumnya.'], 400);
        }

        // Proses setiap item dalam order ini
        foreach ($relatedOrders as $item) {
            $product = Produk::where('product_id', $item->product_id)->first();
            if (!$product) continue;

            // Pastikan stok cukup
            if ($product->stock < $item->quantity) continue;

            // Kurangi stok dan tambahkan ke sold
            $product->stock -= $item->quantity;
            $product->sold += $item->quantity;
            $product->save();

            // Update status transaksi
            $item->transaction_status = 'PROCESSED';
            $item->shipping_ready_at = Carbon::now()->addSeconds(5);
            $item->save();
        }

        return response()->json(['success' => true]);
    }

    public function cancel($payment_id)
    {
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();

        // Ambil semua pesanan dalam 1 order_id
        $relatedOrders = Payment::where('order_id', $order->order_id)
            ->where('payment_status', 'PAID')
            ->where('transaction_status', 'NOT YET PROCESSED')
            ->get();

        if ($relatedOrders->isEmpty()) {
            return response()->json(['error' => 'Pesanan tidak dapat dibatalkan.'], 400);
        }

        foreach ($relatedOrders as $item) {
            $item->transaction_status = 'CANCELED';
            $item->save();
        }

        return response()->json(['success' => true]);
    }

    public function show($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);

        // Ambil semua item dalam 1 pesanan
        $relatedPayments = Payment::where('order_id', $payment->order_id)->get();

        return view('pages.seller.order-detail', [
            'order_id' => $payment->order_id,
            'buyer_name' => $payment->name,
            'payments' => $relatedPayments,
            'total' => $relatedPayments->sum('price_total'),
            'status' => $payment->payment_status,
            'transaction_status' => $payment->transaction_status,
            'address' => $payment->address,
            'phone' => $payment->phone_number,
        ]);
    }

    public function fetch($payment_id)
    {
        $sellerId = AuthController::getSellerID();

        $payment = Payment::where('payment_id', $payment_id)->firstOrFail();
        $relatedPayments = Payment::where('order_id', $payment->order_id)->get();
        $order = Payment::where('seller_id', $sellerId)
            ->where('payment_id', $payment_id)
            ->firstOrFail();

        $subtotal = $relatedPayments->sum('price');
        $shipping = 100000;
        $tax = 50000;

        $paymentMethod = $relatedPayments[0]->payment_method ?? '';
        $bankCharge = match ($paymentMethod) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $total = $subtotal + $shipping + $tax + $bankCharge;

        return response()->json([
            'id'              => $order->payment_id,
            'order_id'        => $order->order_id,
            'name'            => $order->name,
            'date'            => \Carbon\Carbon::parse($order->payment_date)->format('d M Y H:i'),
            'status'          => $order->payment_status === 'PAID'
                ? ($order->transaction_status === 'PROCESSED' ? 'Diproses' : 'Menunggu Konfirmasi')
                : 'Belum Dibayar',
            'total' => number_format($total, 0, ',', '.'),
            'address'         => $order->address,
            'items' => $relatedPayments->map(function ($p) {
                return [
                    'name'     => $p->product_name,
                    'qty'      => $p->quantity,
                    'price'    => number_format($p->price, 0, ',', '.'),
                    'subtotal' => number_format($p->price, 0, ',', '.'),
                ];
            }),
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
