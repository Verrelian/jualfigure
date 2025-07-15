<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Buyer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BuyerHistoryController extends Controller
{
    public function placed()
    {
        session(['history_last_tab' => 'history.placed']);
        $buyer = AuthController::getAuthenticatedUser();

        $groupedOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('payment_status', 'UNPAID')
            ->where('expired_at', '>', now())
            ->orderBy('payment_date', 'desc')
            ->get()
            ->groupBy('order_id');

        $orders = $groupedOrders->map(function ($items) {
            $first = $items->first();

            return (object)[
                'payment_id'    => $first->payment_id,
                'order_id'      => $first->order_id,
                'product_name'  => $first->product_name,
                'payment_date'  => $first->payment_date,
                'extra_count'   => $items->count() - 1,
            ];
        });

        return view('pages.history-menu.placed', compact('orders'));
    }

    public function process()
    {
        session(['history_last_tab' => 'history.process']);
        $buyer = AuthController::getAuthenticatedUser();

        // Ambil semua order yang statusnya relevan
        $rawOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('payment_status', 'PAID')
            ->whereIn('transaction_status', ['NOT YET PROCESSED', 'PROCESSED'])
            ->orderBy('payment_date', 'desc')
            ->get();

        $grouped = $rawOrders->groupBy('order_id');

        // Satu baris per order
        $orders = $grouped->map(function ($items) {
            $first = $items->first();

            return (object)[
                'payment_id'         => $first->payment_id,
                'order_id'           => $first->order_id,
                'product_name'       => $first->product_name,
                'payment_date'       => $first->payment_date,
                'transaction_status' => $first->transaction_status,
                'extra_count'        => $items->count() - 1,
            ];
        })->values(); // Agar jadi Collection numerik, bukan associative

        return view('pages.history-menu.process', compact('orders'));
    }

    public function shipping()
    {
        session(['history_last_tab' => 'history.shipping']);
        $buyer = AuthController::getAuthenticatedUser();

        $rawOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('transaction_status', 'SHIPPING')
            ->orderBy('payment_date', 'desc')
            ->get();

        $grouped = $rawOrders->groupBy('order_id');

        $orders = $grouped->map(function ($items) {
            $first = $items->first();

            return (object)[
                'payment_id'    => $first->payment_id,
                'order_id'      => $first->order_id,
                'product_name'  => $first->product_name,
                'payment_date'  => $first->payment_date,
                'extra_count'   => $items->count() - 1,
            ];
        })->values();

        return view('pages.history-menu.shipping', compact('orders'));
    }

    public function delivered()
    {
        session(['history_last_tab' => 'history.delivered']);
        $buyer = AuthController::getAuthenticatedUser();

        $rawOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('transaction_status', 'DELIVERED')
            ->whereNotNull('completed_at')
            ->orderBy('payment_date', 'desc')
            ->get();

        $grouped = $rawOrders->groupBy('order_id');

        $orders = $grouped->map(function ($items) {
            $first = $items->first();

            return (object)[
                'payment_id'   => $first->payment_id,
                'order_id'     => $first->order_id,
                'product_name' => $first->product_name,
                'payment_date' => $first->payment_date,
                'extra_count'  => $items->count() - 1,
            ];
        })->values();

        return view('pages.history-menu.delivered', compact('orders'));
    }

    public function canceled()
    {
        session(['history_last_tab' => 'history.canceled']);
        $buyer = AuthController::getAuthenticatedUser();

        // Update transaksi yang expired otomatis
        Payment::where('payment_status', 'UNPAID')
            ->where('transaction_status', 'NOT YET PROCESSED')
            ->where('expired_at', '<', now())
            ->update(['transaction_status' => 'EXPIRED']);

        // Ambil data, grup per order_id
        $groupedOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->whereIn('transaction_status', ['CANCELED', 'EXPIRED'])
            ->orderBy('payment_date', 'desc')
            ->get()
            ->groupBy('order_id');

        // Persingkat dan seragamkan seperti 'placed'
        $orders = $groupedOrders->map(function ($items) {
            $first = $items->first();
            return (object)[
                'payment_id'    => $first->payment_id,
                'order_id'      => $first->order_id,
                'product_name'  => $first->product_name,
                'payment_date'  => $first->payment_date,
                'transaction_status' => $first->transaction_status,
                'extra_count'   => $items->count() - 1,
            ];
        });

        return view('pages.history-menu.canceled', compact('orders'));
    }

    public function completed()
    {
        session(['history_last_tab' => 'history.completed']);
        $buyer = AuthController::getAuthenticatedUser();

        $groupedOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('transaction_status', 'COMPLETED')
            ->whereNotNull('completed_at')
            ->orderBy('payment_date', 'desc')
            ->get()
            ->groupBy('order_id');

        $orders = $groupedOrders->map(function ($items) {
            $first = $items->first();

            return (object)[
                'payment_id'    => $first->payment_id,
                'order_id'      => $first->order_id,
                'product_name'  => $first->product_name,
                'payment_date'  => $first->payment_date,
                'extra_count'   => $items->count() - 1,
            ];
        });

        return view('pages.history-menu.completed', compact('orders'));
    }

    public function showPlaced($payment_id)
    {
        $firstPayment = Payment::where('payment_id', $payment_id)->firstOrFail();

        // Ambil semua item dengan order_id yang sama
        $relatedPayments = Payment::where('order_id', $firstPayment->order_id)->get();

        $subtotal = $relatedPayments->sum(function ($item) {
            return $item->price;
        });

        $shipping = 100000;
        $tax = 50000;
        $bankCharge = match ($firstPayment->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $total = $subtotal + $shipping + $tax + $bankCharge;
        $backUrl = request()->query('back', url()->previous());

        return view('pages.history-menu.placed-detail', compact(
            'relatedPayments',
            'firstPayment',
            'subtotal',
            'shipping',
            'tax',
            'bankCharge',
            'total',
            'backUrl'
        ));
    }

    public function showProcess($payment_id)
    {
        $firstPayment = Payment::where('payment_id', $payment_id)->firstOrFail();

        $relatedPayments = Payment::where('order_id', $firstPayment->order_id)->get();

        $subtotal = $relatedPayments->sum(function ($item) {
            return $item->price;
        });

        $shipping = 100000;
        $tax = 50000;
        $bankCharge = match ($firstPayment->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $total = $subtotal + $shipping + $tax + $bankCharge;
        $backUrl = request()->query('back', url()->previous());

        return view('pages.history-menu.process-detail', compact(
            'relatedPayments',
            'firstPayment',
            'subtotal',
            'shipping',
            'tax',
            'bankCharge',
            'total',
            'backUrl'
        ));
    }

    public function showShipping($payment_id)
    {
        $order = Payment::where('payment_id', $payment_id)->firstOrFail();
        $relatedPayments = Payment::where('order_id', $order->order_id)->get();

        return view('pages.history-menu.shipping-detail', compact('order', 'relatedPayments'));
    }

    public function showDelivered($payment_id)
    {
        $firstPayment = Payment::where('payment_id', $payment_id)->firstOrFail();

        $relatedPayments = Payment::where('order_id', $firstPayment->order_id)->get();

        $subtotal = $relatedPayments->sum(function ($item) {
            return $item->price;
        });

        $shipping = 100000;
        $tax = 50000;
        $bankCharge = match ($firstPayment->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $total = $subtotal + $shipping + $tax + $bankCharge;
        $backUrl = request()->query('back', url()->previous());

        return view('pages.history-menu.delivered-detail', compact(
            'relatedPayments',
            'firstPayment',
            'subtotal',
            'shipping',
            'tax',
            'bankCharge',
            'total',
            'backUrl'
        ));
    }

    public function showCompleted($payment_id)
    {
        $firstPayment = Payment::where('payment_id', $payment_id)->firstOrFail();

        $relatedPayments = Payment::where('order_id', $firstPayment->order_id)->get();

        $subtotal = $relatedPayments->sum(fn($item) => $item->price);

        $shipping = 100000;
        $tax = 50000;
        $bankCharge = match ($firstPayment->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $total = $subtotal + $shipping + $tax + $bankCharge;
        $backUrl = request()->query('back', url()->previous());

        return view('pages.history-menu.completed-detail', compact(
            'firstPayment',
            'relatedPayments',
            'subtotal',
            'shipping',
            'tax',
            'bankCharge',
            'total',
            'backUrl'
        ));
    }

    public function done($payment_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->firstOrFail();

        // Ambil semua payment dengan order_id yang sama
        $relatedPayments = Payment::where('order_id', $payment->order_id)->get();

        // Pastikan semua payment sudah dalam tahap DELIVERED
        $notDelivered = $relatedPayments->filter(fn($item) => $item->transaction_status !== 'DELIVERED');
        if ($notDelivered->count() > 0) {
            return response()->json(['error' => 'Beberapa item belum sampai tahap Delivered.'], 400);
        }

        // Update semua menjadi COMPLETED
        foreach ($relatedPayments as $item) {
            $item->transaction_status = 'COMPLETED';
            $item->save();
        }

        // Hitung total semua price_total (hanya dari satu payment karena sama aja nilainya)
        $total = $relatedPayments->sum('price_total');
        $exp = match (true) {
            $total < 1000000 => 300,
            $total <= 2000000 => 700,
            default => 1000,
        };

        // Tambahkan ke buyer
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

    public function fetchProcess()
    {
        $buyer = AuthController::getAuthenticatedUser();

        $rawOrders = Payment::where('buyer_id', $buyer->buyer_id)
            ->where('payment_status', 'PAID')
            ->whereIn('transaction_status', ['NOT YET PROCESSED', 'PROCESSED'])
            ->orderBy('payment_date', 'desc')
            ->get();

        $grouped = $rawOrders->groupBy('order_id');

        $orders = $grouped->map(function ($items) {
            $first = $items->first();
            return (object)[
                'payment_id'         => $first->payment_id,
                'order_id'           => $first->order_id,
                'product_name'       => $first->product_name,
                'payment_date'       => $first->payment_date,
                'transaction_status' => $first->transaction_status,
                'extra_count'        => $items->count() - 1,
            ];
        })->values();

        // Kirim partial blade yg isinya cuma <tr> untuk tbody
        return view('pages.partials.process-fetch', compact('orders'));
    }
}
