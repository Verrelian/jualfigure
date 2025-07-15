<?php

namespace App\Http\Controllers;

// app/Http/Controllers/BuyerProfileController.php

use App\Models\Buyer;
use App\Models\Post;
use Illuminate\Http\Request;

class BuyerProfileController extends Controller
{
    public function show(Buyer $buyer)
    {
        // Ambil semua posts milik buyer ini
        $posts = Post::where('user_id', $buyer->buyer_id)
                    ->withCount(['likes', 'comments'])
                    ->with(['buyer', 'comments.buyer'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Hitung statistik profil
        $stats = [
            'total_posts' => $posts->count(),
            'total_likes' => $posts->sum('likes_count'),
            'total_comments' => $posts->sum('comments_count'),
        ];

        return view('pages.posts.profile', compact('buyer', 'posts', 'stats'));
    }

}