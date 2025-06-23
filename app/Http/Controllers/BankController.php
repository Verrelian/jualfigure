<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentReceipt;
use App\Services\ExpService;

class BankController extends Controller
{
    protected $expService;

    public function __construct(ExpService $expService)
    {
        $this->expService = $expService;
    }

    public function showPaymentPage($bank)
    {
        $allowedBanks = ['bca', 'mandiri', 'bni', 'bri'];

        if (!in_array(strtolower($bank), $allowedBanks)) {
            abort(404);
        }

        return view('bank-' . strtolower($bank));
    }

    public function validateVA(Request $request)
    {
        $request->validate([
            'payment_code' => 'required|string',
            'bank' => 'required|string',
        ]);

        $payment = Payment::where('payment_code', $request->payment_code)
            ->where('payment_method', 'LIKE', '%' . strtoupper($request->bank) . '%')
            ->whereDoesntHave('receipt')
            ->first();

        if (!$payment) {
            return back()->with('error', 'Virtual Account Number tidak valid, sudah digunakan, atau tidak sesuai bank.');
        }

        // Simpan flag untuk satu kali redirect
        session()->flash('just_inquired', true);

        // Fix syntax error
        $priceqty = $payment->price * $payment->quantity;

        session([
            'inquired' => true,
            'payment' => (object)[
                'payment_id' => $payment->payment_id,
                'product_id' => $payment->product_id,
                'buyer_id' => $payment->buyer_id,
                'order_id' => $payment->order_id,
                'payment_method' => $payment->payment_method,
                'payment_code' => $payment->payment_code,
                'product_name' => $payment->product_name,
                'quantity' => $payment->quantity,
                'price' => $priceqty,
                'price_total' => $payment->price_total,
                'shipping' => 50000,
                'tax' => 100000,
            ]
        ]);

        return redirect()->route('bank.payment', ['bank' => $request->bank]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,payment_id',
        ]);

        $payment = Payment::findOrFail($request->payment_id);

        // Cegah pembayaran ganda
        if ($payment->receipt) {
            session()->forget(['inquired', 'payment']);
            return back()->with('error', 'Payment already completed.');
        }

        // Hitung shipping dan tax (disesuaikan jika nanti dinamis)
        $shipping = 50000;
        $tax = 100000;
        $price_total = $payment->price + $shipping + $tax;

        // Simpan ke tabel payment_receipt
        PaymentReceipt::create([
            'product_id'     => $payment->product_id,
            'buyer_id'       => $payment->buyer_id,
            'payment_id'     => $payment->payment_id,
            'order_id'       => $payment->order_id,
            'payment_date'   => now(),
            'payment_method' => $payment->payment_method,
            'payment_code'   => $payment->payment_code,
            'price_total'    => $price_total,
        ]);

        // Update status pembayaran di tabel payments
        $payment->update([
            'payment_status' => 'PAID',
            'transaction_status' => 'PROCESSED',
        ]);

        // 🎯 TRIGGER EXP UPDATE
        try {
            $this->expService->updateUserExp($payment);
        } catch (\Exception $e) {
            // Log error tapi jangan break payment flow
            \Log::error('EXP Update Error: ' . $e->getMessage());
        }

        // Hapus session agar tidak tampil terus
        session()->forget(['inquired', 'payment']);

        // Redirect ke halaman struk pembayaran
        $bankSlug = strtolower(str_replace('BANK ', '', $payment->payment_method));
        return redirect()->route('bank.payment', ['bank' => $bankSlug])
            ->with([
                'payment_success' => true,
                'receipt_payment_id' => $payment->payment_id
            ]);
    }
}