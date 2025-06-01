<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan halaman profil pengguna
    public function show()
    {
        // Jika user sudah login, ambil data user dari sesi
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            // Jika user belum login, tampilkan data user contoh
            $user = (object) [
                'id' => 999,
                'username' => 'User Tamu',
                'email' => 'tamu@example.com',
                'name' => 'Tamu User',
                'bio' => 'This is a sample bio.',
            ];
        }

        return view('profile', compact('user'));
    }

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
    }

    // Memperbarui data profil pengguna
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Mengambil user yang sedang login
        $user = Auth::user();

        // Perbarui data user
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'bio' => $request->bio,
        ]);

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('pages.user.profile')->with('success', 'Profile updated successfully');
    }
}