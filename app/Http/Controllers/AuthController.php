<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
            'password' => 'required',
            'role'     => 'required|in:pembeli,penjual',
        ]);

        // Cari user berdasarkan username dan role
        $user = User::where('role', $request->role)
                    ->where(function($query) use ($request) {
                        $query->where('name', $request->identity)
                            ->orWhere('email', $request->identity);
                    })
                    ->first();

        // Cek apakah user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Login manual
            Auth::login($user);
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if ($user->role === 'penjual') {
                return redirect()->route('seller.dashboardp');
            } else {
                return redirect()->route('dashboard');
            }
        }
            return back()
        ->withInput($request->only('identity', 'role'))
        ->with('error', 'Username/email, password, atau role salah.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pembeli', // default role saat register
            'username' => $request->username,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}