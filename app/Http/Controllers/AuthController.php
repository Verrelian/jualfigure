<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
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

        // jika lolos semua, login
        session([
        'role' => $request->role,
        'user_id' => $user->getKey(),
        'user_data' => $user->toArray(),
        'user' => $user,
        ]);

return redirect()->route($request->role === 'seller' ? 'seller.dashboard' : 'dashboard');
    }

    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email'    => 'required|email',
        'password' => 'required|confirmed|min:8',
        'role'     => 'required|in:buyer,seller',
    ]);

    // Cek apakah email atau username sudah ada
    $emailExists = Buyer::where('email', $request->email)->exists()
        || Seller::where('email', $request->email)->exists();

    $usernameExists = Buyer::where('username', $request->username)->exists()
        || Seller::where('username', $request->username)->exists();

    // Simpan error manual
    $errors = [];
    if ($emailExists) {
        $errors[] = 'Email sudah terdaftar.';
    }
    if ($usernameExists) {
        $errors[] = 'Username sudah terdaftar.';
    }

    // Kalau ada error, kembali ke halaman register
    if (!empty($errors)) {
        return back()
            ->withErrors($errors)
            ->withInput()
            ->with('old_tab', 'register'); // Penting agar tetap di tab register
    }

    // Simpan user baru
    $data = [
        'username' => $request->username,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ];

    if ($request->role === 'buyer') {
        $data = array_merge($data, [
            'name'         => '',
            'address'      => '',
            'exp'          => 0,
            'bio'          => '',
            'phone_number' => 0,
        ]);
        Buyer::create($data);
    } else {
        Seller::create($data);
    }

    // Redirect ke login jika berhasil
    return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
}



    public function logout()
    {
        // Clear auth jika menggunakan guard
        // Auth::logout();

        session()->flush();
        return redirect()->route('login');
    }

    // Helper method untuk mengecek apakah user sudah login
    public static function getAuthenticatedUser()
    {
        if (!session('user_id') || !session('role')) {
            return null;
        }

        $role = session('role');
        $userId = session('user_id');

        if ($role === 'buyer') {
            return Buyer::find($userId);
        } elseif ($role === 'seller') {
            return Seller::find($userId);
        }

        return null;
    }

    // Helper method untuk mendapatkan seller ID
    public static function getSellerID()
    {
        if (session('role') === 'seller' && session('user_id')) {
            return session('user_id');
        }
        return null;
    }
}