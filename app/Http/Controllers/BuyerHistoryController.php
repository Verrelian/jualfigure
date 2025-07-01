<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Buyer;
use Carbon\Carbon;

class BuyerHistoryController extends Controller
{
    public function placed()
    {
        session(['history_last_tab' => 'history.placed']);
        $buyer = AuthController::getAuthenticatedUser();

        $orders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('payment_status', 'UNPAID')
            ->where('expired_at', '>', now())
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.history-menu.placed', compact('orders'));
    }

    public function process()
    {
        session(['history_last_tab' => 'history.process']);
        $buyer = AuthController::getAuthenticatedUser();

        $orders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('payment_status', 'PAID')
            ->whereIn('transaction_status', ['NOT YET PROCESSED', 'PROCESSED'])
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.history-menu.process', compact('orders'));
    }

    public function shipping()
    {
        session(['history_last_tab' => 'history.shipping']);
        $buyer = AuthController::getAuthenticatedUser();

        $orders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('transaction_status', 'SHIPPING')
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.history-menu.shipping', compact('orders'));
    }

    public function delivered()
    {
        session(['history_last_tab' => 'history.delivered']);
        $buyer = AuthController::getAuthenticatedUser();

        $orders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('transaction_status', 'DELIVERED')
            ->whereNotNull('completed_at')
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.history-menu.delivered', compact('orders'));
    }

    public function canceled()
    {
        session(['history_last_tab' => 'history.canceled']);
        $buyer = AuthController::getAuthenticatedUser();

        $orders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where(function ($query) {
                $query->where('transaction_status', 'CANCELED')
                    ->orWhere(function ($q) {
                        $q->where('payment_status', 'PAID')
                            ->where('expired_at', '<', now());
                    });
            })
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.history-menu.canceled', compact('orders'));
    }

    public function completed()
    {
        session(['history_last_tab' => 'history.completed']);
        $buyer = AuthController::getAuthenticatedUser();

        $orders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('transaction_status', 'COMPLETED')
            ->whereNotNull('completed_at')
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('pages.history-menu.completed', compact('orders'));
    }

    public function showPlaced($payment_id)
    {
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        $backUrl = request()->query('back', url()->previous());
        return view('pages.history-menu.placed-detail', compact('order', 'backUrl'));
    }

    public function showProcess($payment_id)
    {
        $backUrl = request()->query('back', url()->previous());
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        return view('pages.history-menu.process-detail', compact('order', 'backUrl'));
    }

    public function showShipping($payment_id)
    {
        $backUrl = request()->query('back', url()->previous());
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        return view('pages.history-menu.shipping-detail', compact('order', 'backUrl'));
    }

    public function showDelivered($payment_id)
    {
        $backUrl = request()->query('back', url()->previous());
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        return view('pages.history-menu.delivered-detail', compact('order', 'backUrl'));
    }

    public function showCompleted($payment_id)
    {
        $backUrl = request()->query('back', url()->previous());
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        return view('pages.history-menu.completed-detail', compact('order', 'backUrl'));
    }

    public function showCanceled($payment_id)
    {
        $backUrl = request()->query('back', url()->previous());
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        return view('pages.history-menu.canceled-detail', compact('order', 'backUrl'));
    }

    public function done($payment_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->firstOrFail();

        if ($payment->transaction_status !== 'DELIVERED') {
            return response()->json(['error' => 'Pesanan belum sampai tahap Delivered.'], 400);
        }

        $payment->transaction_status = 'COMPLETED';
        $payment->save();

        // Hitung EXP
        $total = (int) $payment->price_total;
        $exp = match (true) {
            $total < 1000000 => 300,
            $total <= 2000000 => 700,
            default => 1000
        };

        $buyer = Buyer::find($payment->buyer_id);
        if ($buyer) {
            $buyer->exp = ($buyer->exp ?? 0) + $exp;
            $buyer->save();
        }

        return response()->json(['success' => true]);
    }

    public function rate(Request $request, $payment_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $payment = Payment::where('payment_id', $payment_id)->firstOrFail();

        if ($payment->transaction_status !== 'COMPLETED') {
            return response()->json(['error' => 'Pesanan belum selesai.'], 400);
        }

        $payment->rating = $request->rating;
        $payment->save();

        // Hitung ulang rata-rata rating untuk produk ini
        $product = $payment->product;
        if ($product) {
            $average = Payment::where('product_id', $product->product_id)
                ->whereNotNull('rating')
                ->avg('rating');

            $product->rating_total = round($average, 1); // format seperti 4.7
            $product->save();
        }

        return response()->json(['success' => true]);
    }
}
