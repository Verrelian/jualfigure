<?php
// =================
// WishlistController
// =================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Buyer;

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $productId = $request->input('product_id');
        
        // Ambil buyer_id dari user yang sedang login
        // Asumsi: user memiliki relasi dengan buyer atau buyer_id disimpan di session/user
        $buyerId = $this->getBuyerId();
        
        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'Data buyer tidak ditemukan'
            ], 400);
        }

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
            // Tambahkan ke wishlist
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
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $buyerId = $this->getBuyerId();
        
        if (!$buyerId) {
            return response()->json(['count' => 0]);
        }

        $count = Wishlist::where('buyer_id', $buyerId)->count();
        
        return response()->json(['count' => $count]);
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $buyerId = $this->getBuyerId();
        
        if (!$buyerId) {
            return redirect()->back()->with('error', 'Data buyer tidak ditemukan');
        }

        // Ambil semua wishlist dengan relasi product
        $wishlists = Wishlist::where('buyer_id', $buyerId)
                            ->with('product')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $productId = $request->input('product_id');
        $buyerId = $this->getBuyerId();

        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'Data buyer tidak ditemukan'
            ], 400);
        }

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
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $buyerId = $this->getBuyerId();

        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'Data buyer tidak ditemukan'
            ], 400);
        }

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

    /**
     * Helper method untuk mendapatkan buyer_id
     * Sesuaikan dengan struktur aplikasi Anda
     */
    private function getBuyerId()
    {
        // Opsi 1: Jika buyer_id disimpan di tabel users
        // return Auth::user()->buyer_id;

        // Opsi 2: Jika ada relasi antara users dan buyers
        // return Auth::user()->buyer->buyer_id;

        // Opsi 3: Jika buyer_id disimpan di session
        // return session('buyer_id');

        // Opsi 4: Jika user_id sama dengan buyer_id
        // return Auth::id();

        // Opsi 5: Cari buyer berdasarkan user_id (jika ada kolom user_id di tabel buyers)
        $buyer = Buyer::where('user_id', Auth::id())->first();
        return $buyer ? $buyer->buyer_id : null;

        // Pilih salah satu opsi di atas sesuai dengan struktur database Anda
        // Untuk sementara, saya gunakan opsi 5 sebagai contoh
    }
}