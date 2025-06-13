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
            'password' => 'required',
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

        if ($user && Hash::check($request->password, $user->password)) {
            session(['role' => $request->role, 'user_id' => $user->getKey()]);
            return redirect()->route($request->role === 'seller' ? 'seller.dashboardp' : 'dashboard');
        }

        return back()->withInput($request->only('identity', 'role'))
                     ->with('error', 'Username/email, password, atau role salah.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
            'role'     => 'required|in:buyer,seller',
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($request->role === 'buyer') {
            $data = array_merge($data, [
                'name'         => $request->username,
                'address'      => '',
                'exp'          => 0,
                'bio'          => '',
                'phone_number' => 0,
            ]);
            Buyer::create($data);
        } elseif ($request->role === 'seller') {
            Seller::create($data);
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
