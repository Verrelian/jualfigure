<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentReceipt;
use App\Services\ExpService;
use Illuminate\Support\Facades\Log;

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

        // Ambil satu payment (untuk validasi awal)
        $payment = Payment::where('payment_code', $request->payment_code)
            ->where('payment_method', 'LIKE', '%' . strtoupper($request->bank) . '%')
            ->whereDoesntHave('receipt')
            ->first();

        if (!$payment) {
            return back()->with('error', 'Virtual Account Number tidak valid, sudah digunakan, atau tidak sesuai bank.');
        }

        $orderId = $payment->order_id;

        // Ambil semua payment dengan order_id yang sama
        $relatedPayments = Payment::where('order_id', $orderId)->get();

        $isCart = $relatedPayments->count() > 1;

        // Biaya tetap
        $bankCharge = match ($payment->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };
        $tax = 50000;
        $shipping = 100000;

        if ($isCart) {
            $subtotal = $relatedPayments->sum('price');
            $total = $subtotal + $tax + $shipping + $bankCharge;

            session([
                'inquired' => true,
                'is_cart' => true,
                'payments' => $relatedPayments,
                'cart_summary' => (object)[
                    'order_id' => $orderId,
                    'payment_method' => $payment->payment_method,
                    'payment_code' => $payment->payment_code,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'bank_fee' => $bankCharge,
                    'total' => $total,
                ]
            ]);
        } else {
            // Mode normal
            $priceqty = $payment->price;
            $price_total = $priceqty + $shipping + $tax + $bankCharge;

            session([
                'inquired' => true,
                'is_cart' => false,
                'payment' => (object)[
                    'payment_id' => $payment->payment_id,
                    'product_id' => $payment->product_id,
                    'buyer_id' => $payment->buyer_id,
                    'order_id' => $orderId,
                    'payment_method' => $payment->payment_method,
                    'payment_code' => $payment->payment_code,
                    'product_name' => $payment->product_name,
                    'quantity' => $payment->quantity,
                    'price' => $priceqty,
                    'price_total' => $price_total,
                    'bank_charge' => $bankCharge,
                    'shipping' => $shipping,
                    'tax' => $tax,
                ]
            ]);
        }

        return redirect()->route('bank.payment', ['bank' => $request->bank]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,payment_id',
        ]);

        $firstPayment = Payment::findOrFail($request->payment_id);

        // Cegah pembayaran ganda
        if ($firstPayment->receipt) {
            session()->forget(['inquired', 'payment']);
            return back()->with('error', 'Payment already completed.');
        }

        // Ambil semua item dengan order_id yang sama (untuk cart)
        $relatedPayments = Payment::where('order_id', $firstPayment->order_id)->get();

        // Tentukan biaya bank berdasarkan metode pembayaran
        $bankCharge = match ($firstPayment->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $shipping = 100000;
        $tax = 50000;

        // Hitung total semua item
        $totalPriceItems = $relatedPayments->sum('price');
        $price_total = $totalPriceItems + $shipping + $tax + $bankCharge;

        // Simpan ke tabel payment_receipt (cukup 1x)
        PaymentReceipt::create([
            'product_id'     => $firstPayment->product_id, // Bisa salah satu
            'buyer_id'       => $firstPayment->buyer_id,
            'payment_id'     => $firstPayment->payment_id,
            'order_id'       => $firstPayment->order_id,
            'payment_date'   => now(),
            'payment_method' => $firstPayment->payment_method,
            'payment_code'   => $firstPayment->payment_code,
            'price_total'    => $price_total,
        ]);

        // Update semua item dengan order_id yg sama
        Payment::where('order_id', $firstPayment->order_id)->update([
            'payment_status'      => 'PAID',
            'payment_date'        => now(),
            'transaction_status'  => 'NOT YET PROCESSED',
            'payment_code'        => $firstPayment->payment_code,
        ]);

        // Trigger EXP untuk setiap produk
        //foreach ($relatedPayments as $item) {
        //    try {
        //        $this->expService->updateUserExp($item);
        //    } catch (\Exception $e) {
        //        Log::error('EXP Update Error (ID ' . $item->payment_id . '): ' . $e->getMessage());
        //    }
        //}

        // Bersihkan session
        session()->forget(['inquired', 'payment']);

        // Redirect ke halaman struk (pakai payment_id awal)
        $bankSlug = strtolower(str_replace('BANK ', '', $firstPayment->payment_method));
        return redirect()->route('bank.payment', ['bank' => $bankSlug])
            ->with([
                'payment_success' => true,
                'receipt_payment_id' => $firstPayment->payment_id
            ]);
    }
}
