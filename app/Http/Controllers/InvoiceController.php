<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentReceipt;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel PaymentReceipt
        $sales_history = PaymentReceipt::with(['buyer', 'product'])
            ->latest('payment_date')
            ->paginate(10);

        // Hitung statistik - handle kalau kosong
        $total_revenue = PaymentReceipt::sum('price_total') ?: 0;
        $total_transactions = PaymentReceipt::count() ?: 0;
        $total_products_sold = PaymentReceipt::count() ?: 0;

        // Kalau data kosong, buat collection kosong
        if($sales_history->isEmpty()) {
            $sales_history = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]),
                0,
                10,
                1,
                ['path' => request()->url()]
            );
        }

        return view('pages.seller.laporan', compact(
            'sales_history',
            'total_revenue',
            'total_transactions',
            'total_products_sold'
        ));
    }
}