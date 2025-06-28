<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.general.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required',
            'password' => 'required|min:8',
            'role'     => 'required|in:buyer,seller',
        ]);

        $user = null;

        if ($request->role === 'buyer') {
            $user = Buyer::where('email', $request->identity)
                        ->orWhere('username', $request->identity)
                        ->first();
        } elseif ($request->role === 'seller') {
            $user = Seller::where('email', $request->identity)
                        ->orWhere('username', $request->identity)
                        ->first();
        }

        if (!$user) {
         return back()->withInput($request->only('identity', 'role'))
                 ->with('error', 'Username atau email tidak ditemukan.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withInput($request->only('identity', 'role'))
                 ->with('error', 'Password salah.');
        }

        // --- PERBAIKAN: Hanya simpan data primitif ke session ---
        session([
            'role' => $request->role,
            // $user->getKey() akan mengembalikan primary key model (buyer_id atau id)
            'user_id' => $user->getKey(),
            'username' => $user->username,
            'email' => $user->email,
            // Dapatkan URL avatar melalui accessor, pastikan method_exists
            'buyer_avatar_url' => ($request->role === 'buyer' && method_exists($user, 'getAvatarUrlAttribute'))
                                  ? $user->avatar_url
                                  : asset('images/default_avatar.jpg'),
        ]);
        // --- AKHIR PERBAHAN ---

        return redirect()->route($request->role === 'seller' ? 'seller.dashboard' : 'dashboard');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:buyers,username|unique:sellers,username',
            'email'    => 'required|email|unique:buyers,email|unique:sellers,email',
            'password' => 'required|confirmed|min:8',
            'role'     => 'required|in:buyer,seller',
            'name'     => 'nullable|string|max:255',
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'name'     => $request->name ?? '',
        ];

        if ($request->role === 'buyer') {
            $data = array_merge($data, [
                'address'      => '',
                'exp'          => 0,
                'bio'          => '',
                'phone_number' => 0,
                'avatar'       => null,
            ]);
            Buyer::create($data);
        } else {
            Seller::create($data);
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public static function getSellerID()
    {
        if (session('role') === 'seller' && session('user_id')) {
            return session('user_id');
        }
        return null;
    }
}
