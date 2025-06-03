<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function showReceipt($payment_id)
    {
        $payment = Payment::findOrFail($payment_id); // cari data by payment_id
        return view('payment-receipt', compact('payment')); // kirim ke view
    }

    public function downloadReceipt($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $pdf = Pdf::loadView('payment-receipt-pdf', compact('payment'));
        return $pdf->download('payment-receipt-' . $payment->order_id . '.pdf');
    }
}
