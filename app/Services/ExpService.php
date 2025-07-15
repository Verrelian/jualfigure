<?php

namespace App\Services;

use App\Models\Leaderboard;
use App\Models\Buyer;
use Illuminate\Support\Facades\DB;

class ExpService
{
    public function updateUserExp($payment)
    {
        $buyerId = $payment->buyer_id;
        $quantity = $payment->quantity;
        $totalSpent = $payment->price_total;

        DB::transaction(function () use ($buyerId, $quantity, $totalSpent) {
            // Update Bulk Buyer
            $this->updateLeaderboardEntry($buyerId, 'bulk_buyer', [
                'total_items' => $quantity,
                'exp_increment' => Leaderboard::calculateExp('bulk_buyer', $quantity)
            ]);

            // Update Loyal Hunter
            $this->updateLeaderboardEntry($buyerId, 'loyal_hunter', [
                'total_transactions' => 1,
                'exp_increment' => Leaderboard::calculateExp('loyal_hunter', 1)
            ]);

            // Update Premium Collector
            $this->updateLeaderboardEntry($buyerId, 'premium_collector', [
                'total_spent' => $totalSpent,
                'exp_increment' => Leaderboard::calculateExp('premium_collector', $totalSpent)
            ]);

            // Update total EXP di buyer table
            $this->updateBuyerTotalExp($buyerId);
        });
    }

    private function updateLeaderboardEntry($buyerId, $type, $data)
    {
        $leaderboard = Leaderboard::firstOrCreate(
            ['buyer_id' => $buyerId, 'type' => $type],
            [
                'exp' => 0,
                'total_items' => 0,
                'total_transactions' => 0,
                'total_spent' => 0
            ]
        );

        // Update EXP
        $leaderboard->exp += $data['exp_increment'];

        // Update counters
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

    private function updateBuyerTotalExp($buyerId)
    {
        // Hitung total EXP dari semua kategori
        $totalExp = Leaderboard::where('buyer_id', $buyerId)->sum('exp');

        // Update di buyer table
        Buyer::where('buyer_id', $buyerId)->update(['exp' => $totalExp]);
    }
}