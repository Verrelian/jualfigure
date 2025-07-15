<?php

namespace App\Services;

use App\Models\Leaderboard;
use App\Models\Buyer;
use App\Models\PaymentReceipt;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExpService
{
    /**
     * Memperbarui EXP leaderboard mingguan berdasarkan transaksi pengguna.
     * Dipanggil setiap kali user menyelesaikan pembayaran.
     */
    public function updateWeeklyLeaderboard($buyerId)
    {
        // Ambil transaksi 7 hari terakhir
        $receipts = PaymentReceipt::where('buyer_id', $buyerId)
            ->whereBetween('payment_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->get()
            ->groupBy(fn($r) => Carbon::parse($r->payment_date)->toDateString());

        $loyal = 0;
        $bulk = 0;
        $premium = 0;

        foreach ($receipts as $day => $transactions) {
            $total = $transactions->sum('price_total');
            $items = $transactions->sum('qty');

            if ($total < 500000) {
                $loyal++;
            } elseif ($total <= 1500000) {
                $bulk++;
            } elseif ($total > 2000000 && $items === 1) {
                $premium++;
            }
        }

        DB::transaction(function () use ($buyerId, $receipts, $loyal, $bulk, $premium) {
            $total_items = $receipts->flatten()->sum('qty');
            $total_transactions = $receipts->flatten()->count();
            $total_spent = $receipts->flatten()->sum('price_total');

            // Loyal Hunter: 7 hari berturut-turut beli < 500rb
            if ($loyal == 7) {
                $this->updateLeaderboardEntry($buyerId, 'loyal_hunter', [
                    'total_transactions' => $total_transactions,
                    'exp_increment' => 300 * 7,
                ]);
            }

            // Bulk Buyer: 7 hari berturut-turut beli <= 1.5jt
            if ($bulk == 7) {
                $this->updateLeaderboardEntry($buyerId, 'bulk_buyer', [
                    'total_items' => $total_items,
                    'exp_increment' => 700 * 7,
                ]);
            }

            // Premium Collector: >= 2 hari beli >2jt hanya 1 item
            if ($premium >= 2) {
                $this->updateLeaderboardEntry($buyerId, 'premium_collector', [
                    'total_spent' => $total_spent,
                    'exp_increment' => 1000 * $premium,
                ]);
            }

            $this->updateBuyerTotalExp($buyerId);
        });
    }

    /**
     * Menyimpan atau memperbarui entry leaderboard
     */
    private function updateLeaderboardEntry($buyerId, $type, $data)
    {
        $leaderboard = Leaderboard::firstOrCreate(
            ['buyer_id' => $buyerId, 'type' => $type],
            ['exp' => 0, 'total_items' => 0, 'total_transactions' => 0, 'total_spent' => 0]
        );

        // ✅ Tambah EXP, bukan timpa
        $leaderboard->exp += $data['exp_increment'];

        if (isset($data['total_items'])) {
            $leaderboard->total_items += $data['total_items'];
        }
        if (isset($data['total_transactions'])) {
            $leaderboard->total_transactions += $data['total_transactions'];
        }
        if (isset($data['total_spent'])) {
            $leaderboard->total_spent += $data['total_spent'];
        }

        $leaderboard->last_updated = now();
        $leaderboard->save();
    }

    /**
     * Sinkron total EXP buyer dari semua leaderboard
     */
    private function updateBuyerTotalExp($buyerId)
    {
        $totalExp = Leaderboard::where('buyer_id', $buyerId)->sum('exp');
        Buyer::where('buyer_id', $buyerId)->update(['exp' => $totalExp]);
    }

    /**
     * Mendapatkan level dan progress berdasarkan total EXP
     */
    public static function getLevelInfo($exp)
    {
        $levels = [
            1 => 0,
            2 => 1000,
            3 => 3000,
            4 => 6000,
            5 => 10000,
        ];

        $currentLevel = 1;
        $nextLevelExp = null;

        foreach ($levels as $level => $requiredExp) {
            if ($exp >= $requiredExp) {
                $currentLevel = $level;
            } else {
                $nextLevelExp = $requiredExp;
                break;
            }
        }

        return [
            'level' => $currentLevel,
            'next_exp' => $nextLevelExp,
            'current_exp' => $exp,
            'exp_to_next' => $nextLevelExp ? $nextLevelExp - $exp : 0,
            'progress' => $nextLevelExp ? round($exp / $nextLevelExp * 100, 1) : 100,
        ];
    }
    public static function getCategoryLevelInfo($buyerId)
    {
        $types = ['loyal_hunter', 'bulk_buyer', 'premium_collector'];
        $result = [];

        foreach ($types as $type) {
            $exp = Leaderboard::where('buyer_id', $buyerId)
                ->where('type', $type)
                ->value('exp') ?? 0;

            $result[$type] = self::getLevelInfo($exp);
        }

        return $result;
    }
    public static function getTopTitle($buyerId)
    {
        $types = ['loyal_hunter', 'bulk_buyer', 'premium_collector'];
        $titles = [
            'loyal_hunter' => 'Loyal Hunter',
            'bulk_buyer' => 'Bulk Buyer',
            'premium_collector' => 'Premium Collector',
        ];

        // 1. Cek apakah dia peringkat 1 global dengan EXP memadai (min 1000)
        foreach ($types as $type) {
            $topBuyer = Leaderboard::where('type', $type)
                ->orderByDesc('exp')
                ->first();

            $userExp = Leaderboard::where('type', $type)
                ->where('buyer_id', $buyerId)
                ->value('exp') ?? 0;

            if ($topBuyer && $topBuyer->buyer_id === $buyerId && $userExp >= 1000) {
                return '🏆 No. 1 ' . $titles[$type];
            }
        }

        // 2. Kalau tidak, ambil kategori dengan EXP terbesar
        $levels = self::getCategoryLevelInfo($buyerId);
        $bestType = collect($levels)->sortByDesc('current_exp')->keys()->first();

        return 'Lvl ' . $levels[$bestType]['level'] . ' ' . $titles[$bestType];
    }


}
