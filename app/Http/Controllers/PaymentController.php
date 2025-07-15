<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function showReceipt(Request $request, $payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $backUrl = request()->query('back', url()->previous());

        // Cek apakah ini mode cart (jika ada lebih dari 1 produk dengan order_id yang sama)
        $relatedPayments = Payment::where('order_id', $payment->order_id)->get();
        $isCart = $relatedPayments->count() > 1;

        // Default nilai
        $subtotal = null;
        $tax = null;
        $shipping = null;
        $bank_fee = null;
        $cartTotal = null;

        if ($isCart) {
            // Kalkulasi cart
            $subtotal = $relatedPayments->sum('price');

            // Gunakan dari salah satu payment (bebas karena semua pakai value yang sama)
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
        ]);
    }

    public function downloadReceipt($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $pdf = Pdf::loadView('payment-receipt-pdf', compact('payment'));
        return $pdf->download('payment-receipt-' . $payment->order_id . '.pdf');
    }
}
