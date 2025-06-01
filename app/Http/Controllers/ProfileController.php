<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login dahulu.');
    }

<<<<<<< HEAD
    $user = Auth::user();
    return view('profile', compact('user'));
}

public function edit()
{
    if (!Auth::check()) {
        return redirect()->route('login');
=======
    // Menampilkan halaman edit profil
    public function edit()
    {
        // Jika user sudah login, ambil data user dari sesi
        $user = Auth::user();

        // Jika user belum login, tampilkan data user contoh
        if (!$user) {
            $user = (object) [
                'id' => 999,
                'username' => 'User Tamu',
                'email' => 'tamu@example.com'
            ];
        }

        return view('pages.user.edit_profile', compact('user'));
>>>>>>> 3717c2b6068b1c4bcec4b725aacde1c16b6bd018
    }

    $user = Auth::user();
    return view('edit_profile', compact('user'));
}

public function update(Request $request)
{
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

<<<<<<< HEAD
    $data = $request->only([
        'name', 'username', 'email', 'nickname', 'country', 'birthdate', 'phone', 'address', 'bio'
    ]);

    if ($request->hasFile('avatar')) {
        $filename = time() . '.' . $request->avatar->extension();
        $path = $request->avatar->storeAs('avatars', $filename, 'public');
        $data['avatar'] = $path;
=======
        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('pages.user.profile')->with('success', 'Profile updated successfully');
>>>>>>> 3717c2b6068b1c4bcec4b725aacde1c16b6bd018
    }

    $user->update($data);

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
}
}