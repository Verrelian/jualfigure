<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaymentReceipt;
use App\Models\Leaderboard;
use Illuminate\Support\Carbon;

class UpdateLeaderboard extends Command
{
    protected $signature = 'leaderboard:update';
    protected $description = 'Update EXP dan kategori leaderboard berdasarkan histori transaksi 7 hari terakhir';

    public function handle()
    {
        $this->info('Proses update leaderboard dimulai...');

        $buyers = PaymentReceipt::select('buyer_id')->distinct()->get();

        foreach ($buyers as $buyer) {
            $receipts = PaymentReceipt::where('buyer_id', $buyer->buyer_id)
                ->whereBetween('payment_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                ->get();

            if ($receipts->isEmpty()) {
                continue; // lewati kalau gak ada transaksi
            }

            $dailyCounts = $receipts->groupBy(fn($r) => Carbon::parse($r->payment_date)->toDateString());

            $loyal = 0;
            $bulk = 0;
            $premium = 0;

            foreach ($dailyCounts as $date => $transactions) {
                $total = $transactions->sum('price_total');
                $items = $transactions->sum('qty');

                if ($total < 500000) {
                    $loyal++;
                } elseif ($total <= 1500000) {
                    $bulk++;
                } elseif ($total > 2000000 && $items == 1) {
                    $premium++;
                }
            }

            // Hitung total untuk disimpan di leaderboard
            $total_items = $receipts->sum('qty');
            $total_transactions = $dailyCounts->count();
            $total_spent = $receipts->sum('price_total');

            if ($loyal >= 1) {
                Leaderboard::updateOrCreate(
                    ['buyer_id' => $buyer->buyer_id, 'type' => 'loyal_hunter'],
                    [
                        'exp' => $loyal * 300,
                        'total_items' => $total_items,
                        'total_transactions' => $total_transactions,
                        'total_spent' => $total_spent,
                        'last_updated' => now()
                    ]
                );
            }

            if ($bulk >= 1) {
                Leaderboard::updateOrCreate(
                    ['buyer_id' => $buyer->buyer_id, 'type' => 'bulk_buyer'],
                    [
                        'exp' => $bulk * 700,
                        'total_items' => $total_items,
                        'total_transactions' => $total_transactions,
                        'total_spent' => $total_spent,
                        'last_updated' => now()
                    ]
                );
            }

            if ($premium >= 1) {
                Leaderboard::updateOrCreate(
                    ['buyer_id' => $buyer->buyer_id, 'type' => 'premium_collector'],
                    [
                        'exp' => $premium * 1000,
                        'total_items' => $total_items,
                        'total_transactions' => $total_transactions,
                        'total_spent' => $total_spent,
                        'last_updated' => now()
                    ]
                );
            }
        }

        $this->info('Leaderboard berhasil diperbarui.');
    }
}
