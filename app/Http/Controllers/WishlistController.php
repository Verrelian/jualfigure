<?php
// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Buyer;
use App\Models\Produk; // TAMBAHKAN INI

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        // GANTI Auth::check() dengan session check
        if (!session('user_id') || session('role') !== 'buyer') {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $productId = $request->input('product_id');
        $buyerId = session('user_id'); // Langsung ambil dari session

        // Validasi input
        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Product ID tidak valid'
            ], 400);
        }

        // Cek apakah produk sudah ada di wishlist
        $exists = Wishlist::where('buyer_id', $buyerId)
                         ->where('product_id', $productId)
                         ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di wishlist'
            ]);
        }

        try {
            Wishlist::create([
                'buyer_id' => $buyerId,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke wishlist'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk ke wishlist: ' . $e->getMessage()
            ], 500);
        }
    }

    public function count()
    {
        if (!session('user_id') || session('role') !== 'buyer') {
            return response()->json(['count' => 0]);
        }

        $buyerId = session('user_id');
        $count = Wishlist::where('buyer_id', $buyerId)->count();

        return response()->json(['count' => $count]);
    }

    public function index()
    {
        if (!session('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login');
        }

        $buyerId = session('user_id');

        $wishlists = Wishlist::where('buyer_id', $buyerId)
                            ->with('product')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('pages.product.wishlist', compact('wishlists'));
    }

    public function remove(Request $request)
    {
        if (!session('user_id') || session('role') !== 'buyer') {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $productId = $request->input('product_id');
        $buyerId = session('user_id');

        try {
            $deleted = Wishlist::where('buyer_id', $buyerId)
                              ->where('product_id', $productId)
                              ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil dihapus dari wishlist'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan di wishlist'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk dari wishlist: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clear()
    {
        if (!session('user_id') || session('role') !== 'buyer') {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $buyerId = session('user_id');

        try {
            $deleted = Wishlist::where('buyer_id', $buyerId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Wishlist berhasil dikosongkan',
                'deleted_count' => $deleted
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengosongkan wishlist: ' . $e->getMessage()
            ], 500);
        }
    }
}