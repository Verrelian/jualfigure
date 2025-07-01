<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaderboard;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'bulk_buyer');

        // Validasi type
        if (!in_array($type, ['bulk_buyer', 'loyal_hunter', 'premium_collector'])) {
            $type = 'bulk_buyer';
        }

        $leaderboards = Leaderboard::getTopUsers($type, 10);

        return view('pages.general.leaderboard', compact('leaderboards', 'type'));
    }

    public function getLeaderboardData(Request $request)
    {
        $type = $request->get('type', 'bulk_buyer');

        if (!in_array($type, ['bulk_buyer', 'loyal_hunter', 'premium_collector'])) {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $leaderboards = Leaderboard::getTopUsers($type, 10);

        return response()->json([
            'success' => true,
            'data' => $leaderboards
        ]);
    }
}