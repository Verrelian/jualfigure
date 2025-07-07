<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceipt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        // Data penjualan
        $sales_history = PaymentReceipt::with(['buyer', 'product'])
            ->whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->latest('payment_date')
            ->paginate(10);

        // Statistik bulan ini
        $total_revenue = PaymentReceipt::whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->sum('price_total');

        $total_transactions = PaymentReceipt::whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->count();

        $total_products_sold = PaymentReceipt::whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->sum('qty');

        // Perbandingan bulan lalu
        $prev_month = Carbon::create($tahun, $bulan)->subMonth();
        $prev_revenue = PaymentReceipt::whereYear('payment_date', $prev_month->year)
            ->whereMonth('payment_date', $prev_month->month)
            ->sum('price_total');

        $revenue_change = $prev_revenue > 0 ? (($total_revenue - $prev_revenue) / $prev_revenue) * 100 : 0;

        // Rata-rata per hari
        $days_in_month = Carbon::create($tahun, $bulan)->daysInMonth;
        $avg_daily_revenue = $total_revenue / $days_in_month;

        // Top 3 produk terlaris
        $top_products = PaymentReceipt::with('product')
            ->select('product_id', \DB::raw('SUM(qty) as total_qty'), \DB::raw('SUM(price_total) as total_revenue'))
            ->whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->limit(3)
            ->get();

        // Penjualan per minggu (untuk chart sederhana)
        $weekly_sales = PaymentReceipt::selectRaw('WEEK(payment_date) as week, SUM(price_total) as total')
            ->whereYear('payment_date', $tahun)
            ->whereMonth('payment_date', $bulan)
            ->groupBy('week')
            ->get();

        return view('pages.seller.laporan', compact(
            'sales_history',
            'total_revenue',
            'total_transactions',
            'total_products_sold',
            'bulan',
            'tahun',
            'revenue_change',
            'avg_daily_revenue',
            'top_products',
            'weekly_sales'
        ));
    }
}