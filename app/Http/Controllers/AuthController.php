<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $credentials = [
        'name' => $request->username,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Tidak cek role di Auth::attempt, cek manual
        if ($user->role === 'penjual') {
            return redirect('/seller/crud');
        }
        return redirect('/dashboard');
    }

    return back()->with('error', 'Username atau password salah.');
}



    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembeli',
            'username' => $request->username,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
