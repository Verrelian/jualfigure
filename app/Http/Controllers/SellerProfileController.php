<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;

class SellerProfileController extends Controller
{
    public function show()
{
    if (!session()->has('user') || session('role') !== 'seller') {
        return redirect()->route('login');
    }

    $user = Seller::find(session('user')->seller_id);
    session(['user' => $user]); // refresh session supaya data paling baru
    return view('pages.seller.profile', compact('user'));
}

    public function edit()
    {
        if (!session()->has('user') || session('role') !== 'seller') {
            return redirect()->route('login');
        }

        $user = Seller::find(session('user')->seller_id);
        return view('pages.seller.edit_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!session()->has('user') || session('role') !== 'seller') {
            return redirect()->route('login');
        }

        $user = Seller::find(session('user')->seller_id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:sellers,username,' . $user->seller_id . ',seller_id',
            'email' => 'required|email|unique:sellers,email,' . $user->seller_id . ',seller_id',
            'nickname' => 'nullable|string',
            'country' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'name', 'username', 'email', 'nickname', 'country',
            'birthdate', 'phone_number', 'address', 'bio'
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->avatar->extension();
            $path = $request->avatar->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);
        session(['user' => $user->fresh()]); // ambil ulang data dari database
        return redirect()->route('seller.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}