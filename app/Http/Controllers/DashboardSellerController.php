<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\PaymentReceipt;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardSellerController extends Controller
{
    public function index()
    {
        $sellerId = session('user')->id;

        $revenueStats = $this->getRevenueStats($sellerId);
        $productPerformance = $this->getProductPerformance($sellerId);
        $targetProgress = $this->getSalesTargetProgress($sellerId);
        $lowStockProducts = $this->getLowStockProducts($sellerId);
        $ratingOverview = $this->getRatingOverview($sellerId);
        $monthlyPerformance = $this->getMonthlyPerformance($sellerId);

        return view('pages.seller.dashboard', compact(
            'revenueStats',
            'productPerformance',
            'targetProgress',
            'lowStockProducts',
            'ratingOverview',
            'monthlyPerformance'
        ));
    }

    private function getRevenueStats($sellerId)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $baseQuery = PaymentReceipt::with('payment')
            ->whereHas('payment', fn($q) => $q->where('seller_id', $sellerId)
                ->whereIn('payment_status', ['PAID'])
            );

        $revenueToday = (clone $baseQuery)->whereDate('payment_date', $today)->sum('price_total');
        $revenueYesterday = (clone $baseQuery)->whereDate('payment_date', $yesterday)->sum('price_total');
        $revenueThisMonth = (clone $baseQuery)->where('payment_date', '>=', $thisMonth)->sum('price_total');
        $revenueLastMonth = (clone $baseQuery)
            ->where('payment_date', '>=', $lastMonth)
            ->where('payment_date', '<', $thisMonth)
            ->sum('price_total');

        $todayChange = $revenueYesterday > 0 ? round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100) : 0;
        $monthChange = $revenueLastMonth > 0 ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100) : 0;

        $totalProducts = Produk::where('seller_id', $sellerId)->count();
        $activeProducts = Produk::where('seller_id', $sellerId)->where('stock', '>', 0)->count();

        return [
            'revenue_today' => $revenueToday,
            'revenue_today_change' => $todayChange,
            'revenue_month' => $revenueThisMonth,
            'revenue_month_change' => $monthChange,
            'total_products' => $totalProducts,
            'active_products' => $activeProducts
        ];
    }

    private function getProductPerformance($sellerId)
    {
        $totalSold = Produk::where('seller_id', $sellerId)->sum('sold');

        $lowRatingProducts = Produk::where('seller_id', $sellerId)
            ->where('rating_total', '<', 3.5)
            ->where('rating_total', '>', 0)
            ->count();

        $bestProduct = Produk::where('seller_id', $sellerId)
            ->orderBy('sold', 'desc')
            ->first();

        $avgRating = Produk::where('seller_id', $sellerId)
            ->where('rating_total', '>', 0)
            ->avg('rating_total');

        return [
            'total_sold' => $totalSold,
            'low_rating_count' => $lowRatingProducts,
            'best_product' => $bestProduct,
            'average_rating' => round($avgRating, 1)
        ];
    }

    private function getSalesTargetProgress($sellerId)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $monthlyRevenue = PaymentReceipt::with('payment')
            ->whereYear('payment_date', $currentYear)
            ->whereMonth('payment_date', $currentMonth)
            ->whereHas('payment', fn($q) => $q->where('seller_id', $sellerId)
                ->whereIn('payment_status', ['PAID']))
            ->sum('price_total');

        $monthlyTarget = 10_000_000;
        $progress = $monthlyTarget > 0 ? ($monthlyRevenue / $monthlyTarget) * 100 : 0;
        $remaining = $monthlyTarget - $monthlyRevenue;
        $daysLeft = Carbon::now()->daysInMonth - Carbon::now()->day;

        return [
            'current_revenue' => $monthlyRevenue,
            'target_revenue' => $monthlyTarget,
            'progress_percentage' => round($progress),
            'remaining_amount' => $remaining,
            'days_left' => $daysLeft
        ];
    }

    private function getLowStockProducts($sellerId)
    {
        return Produk::where('seller_id', $sellerId)
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(6)
            ->get()
            ->map(function($product) {
                return [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'stock' => $product->stock,
                    'image' => $product->image,
                    'price' => $product->price,
                    'sold' => $product->sold,
                    'urgency' => $product->stock <= 2 ? 'critical' : 'warning'
                ];
            });
    }

    private function getRatingOverview($sellerId)
    {
        $products = Produk::where('seller_id', $sellerId)
            ->where('rating_total', '>', 0)
            ->get();

        $ratingDistribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        foreach ($products as $product) {
            $rating = floor($product->rating_total);
            if ($rating >= 1 && $rating <= 5) {
                $ratingDistribution[$rating]++;
            }
        }

        return [
            'total_rated_products' => $products->count(),
            'average_rating' => round($products->avg('rating_total'), 1),
            'rating_distribution' => $ratingDistribution,
            'low_rating_products' => $products->where('rating_total', '<', 3)->take(3)
        ];
    }

    private function getMonthlyPerformance($sellerId)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $revenue = PaymentReceipt::with('payment')
                ->whereMonth('payment_date', $date->month)
                ->whereYear('payment_date', $date->year)
                ->whereHas('payment', fn($q) => $q->where('seller_id', $sellerId)
                    ->whereIn('payment_status', ['PAID']))
                ->sum('price_total');

            $months[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ];
        }

        return $months;
    }
}
