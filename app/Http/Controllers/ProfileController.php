<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer; // Ganti sesuai model user yang kamu pakai

class ProfileController extends Controller
{
    public function show()
    {
        // Gunakan session, bukan Auth
        if (!session()->has('user') || session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login dahulu.');
        }

        $user = Buyer::find(session('user')->buyer_id); // Ambil dari database supaya data up-to-date
        return view('pages.user.profile', compact('user'));
    }

    public function edit()
    {
        if (!session()->has('user') || session('role') !== 'buyer') {
            return redirect()->route('login');
        }

        $user = Buyer::find(session('user')->buyer_id);
        return view('pages.user.edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        if (!session()->has('user') || session('role') !== 'buyer') {
            return redirect()->route('login');
        }

        $user = Buyer::find(session('user')->buyer_id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:buyers,username,' . $user->buyer_id . ',buyer_id',
            'email' => 'required|email|unique:buyers,email,' . $user->buyer_id . ',buyer_id',
            'nickname' => 'nullable|string',
            'country' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'name', 'username', 'email', 'nickname', 'country', 'birthdate', 'phone', 'address', 'bio'
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->avatar->extension();
            $path = $request->avatar->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        // Simpan ulang data yang baru ke session
        session(['user' => $user]);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
