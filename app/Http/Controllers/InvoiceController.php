<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceipt;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        // Ambil data penjualan berdasarkan bulan & tahun
        $sales_history = PaymentReceipt::with(['buyer', 'product'])
            ->whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->latest('payment_date')
            ->paginate(10);

        // Hitung statistik
        $total_revenue = PaymentReceipt::whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->sum('price_total');

        $total_transactions = PaymentReceipt::whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->count();

        $total_products_sold = PaymentReceipt::whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->sum('qty'); // Pastikan kolom qty ada

        return view('pages.seller.laporan', compact(
            'sales_history',
            'total_revenue',
            'total_transactions',
            'total_products_sold',
            'bulan',
            'tahun'
        ));
    }
}
