<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    public function edit()
    {
        // Tampilkan halaman edit profil seller
        return view('pages.seller.edit_profile');
    }

    public function updateProfile(Request $request)
    {
        // Validasi dan update profil seller
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            // Tambahkan sesuai kebutuhan
        ]);

        // Contoh: update ke user login
        $user = session('user');
        $user->update($validated);

        return redirect()->route('seller.profile.show')->with('success', 'Profil berhasil diperbarui');
    }

    public function posts()
    {
        return view('pages.seller.posts');
    }

    public function toys()
    {
        return view('pages.seller.toys');
    }
}
