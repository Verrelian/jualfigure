<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Seller;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function showReceipt(Request $request, $payment_id)
    {
        $payment = Payment::with('seller')->findOrFail($payment_id);
        $backUrl = request()->query('back', url()->previous());

        $relatedPayments = Payment::where('order_id', $payment->order_id)->get();
        $isCart = $relatedPayments->count() > 1;

        $subtotal = null;
        $tax = null;
        $shipping = null;
        $bank_fee = null;
        $cartTotal = null;

        if ($isCart) {
            $subtotal = $relatedPayments->sum('price');
            $tax = 50000;
            $shipping = 100000;
            $bank_fee = match ($payment->payment_method) {
                'BANK BCA' => 350000,
                'BANK MANDIRI' => 300000,
                'BANK BNI' => 260000,
                'BANK BRI' => 250000,
                default => 0,
            };
            $cartTotal = $subtotal + $tax + $shipping + $bank_fee;
        }

        // Ambil nomor penjual jika statusnya CANCELLED
        $sellerPhone = null;
        if ($payment->transaction_status === 'CANCELLED') {
            $seller = Seller::find($payment->seller_id);
            $sellerPhone = $seller?->phone_number;
        }

        return view('payment-receipt', [
            'payment' => $payment,
            'payments' => $relatedPayments,
            'backUrl' => $backUrl,
            'isCart' => $isCart,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'bank_fee' => $bank_fee,
            'cartTotal' => $cartTotal,
            'sellerPhone' => $sellerPhone, // kirim ke Blade
        ]);
    }

    public function downloadReceipt($payment_id)
    {
        $payment = Payment::with('seller')->findOrFail($payment_id);

        $relatedPayments = Payment::where('order_id', $payment->order_id)->get();
        $isCart = $relatedPayments->count() > 1;

        $subtotal = null;
        $tax = null;
        $shipping = null;
        $bank_fee = null;
        $cartTotal = null;

        if ($isCart) {
            $subtotal = $relatedPayments->sum('price');
            $tax = 50000;
            $shipping = 100000;
            $bank_fee = match ($payment->payment_method) {
                'BANK BCA' => 350000,
                'BANK MANDIRI' => 300000,
                'BANK BNI' => 260000,
                'BANK BRI' => 250000,
                default => 0,
            };
            $cartTotal = $subtotal + $tax + $shipping + $bank_fee;
        }

        // Ambil nomor penjual jika statusnya CANCELLED
        $sellerPhone = null;
        if ($payment->transaction_status === 'CANCELLED') {
            $seller = Seller::find($payment->seller_id);
            $sellerPhone = $seller?->phone_number;
        }

        $pdf = Pdf::loadView('payment-receipt-pdf', [
            'payment' => $payment,
            'payments' => $relatedPayments,
            'isCart' => $isCart,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'bank_fee' => $bank_fee,
            'cartTotal' => $cartTotal,
            'sellerPhone' => $sellerPhone,
        ]);

        return $pdf->download('payment-receipt-' . $payment->order_id . '.pdf');
    }
}
