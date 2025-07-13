<?php
// app/Models/Leaderboard.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $table = 'leaderboards';

    protected $primaryKey = 'leaderboard_id';
    protected $fillable = [
        'buyer_id', 'type', 'exp', 'total_items',
        'total_transactions', 'total_spent', 'last_updated'
    ];

    public $timestamps = false;

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }

    // Helper method untuk calculate EXP
    public static function calculateExp($type, $value)
    {
        switch ($type) {
            case 'bulk_buyer':
                return $value * 10; // 10 EXP per item
            case 'loyal_hunter':
                return 50; // 50 EXP per transaction
            case 'premium_collector':
                return floor($value / 1000); // 1 EXP per 1000 rupiah
            default:
                return 0;
        }
    }

    // Get leaderboard by type
    public static function getTopUsers($type, $limit = 10)
    {
        return self::with('buyer')
            ->where('type', $type)
            ->orderBy('exp', 'desc')
            ->limit($limit)
            ->get();
    }
}