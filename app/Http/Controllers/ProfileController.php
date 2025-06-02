<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dahulu.');
        }

        $user = Auth::user();

        // SESUAIKAN dengan lokasi view Anda - pilih salah satu:
        return view('pages.user.profile', compact('user')); // Jika file di resources/views/profile.blade.php
        // return view('pages.user.profile', compact('user')); // Jika file di resources/views/pages/user/profile.blade.php
    }

    public function edit()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        return view('pages.user.edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
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

        // SESUAIKAN dengan route name yang ada di web.php Anda:
        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
        // return redirect()->route('pages.user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}