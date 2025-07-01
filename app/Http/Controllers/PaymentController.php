<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function showReceipt( Request $request, $payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $backUrl = request()->query('back', url()->previous());

        return view('payment-receipt', compact('payment', 'backUrl'));
    }

    public function downloadReceipt($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $pdf = Pdf::loadView('payment-receipt-pdf', compact('payment'));
        return $pdf->download('payment-receipt-' . $payment->order_id . '.pdf');
    }
}
