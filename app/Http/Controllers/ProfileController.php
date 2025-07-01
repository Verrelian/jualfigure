<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use App\Models\Post; // Penting: Pastikan ini di-import

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login.
     * Rute: /user/profile
     */
    public function show()
    {
        // Memeriksa status login melalui session
        if (!session()->has('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login dahulu.');
        }

        // Ambil buyer_id dari session untuk user yang sedang login
        // Pastikan konversi ke (int) jika primary key di DB adalah integer
        $loggedInBuyerId = (int) session('user_id');

        // Mengambil data user dari database, termasuk postingan terkait
        $user = Buyer::with('posts')->find($loggedInBuyerId);

        // Jika user tidak ditemukan di DB (meskipun ada di session), hapus session dan redirect
        if (!$user) {
            session()->forget(['user_id', 'role', 'username', 'email', 'buyer_avatar_url']);
            return redirect()->route('login')->with('error', 'Profil Anda tidak ditemukan di database atau sesi kadaluarsa. Silakan login kembali.');
        }

        return view('pages.user.profile', compact('user'));
    }

    /**
     * Menampilkan profil pengguna lain berdasarkan buyer_id dari URL.
     * Rute: /profile/{buyer_id}
     *
     * @param  string $buyer_id ID pengguna yang profilnya ingin ditampilkan dari URL.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function showOtherUser($buyer_id)
    {
        // Cek apakah user yang sedang login (jika ada) mencoba melihat profilnya sendiri
        if (session()->has('user_id') && session('role') === 'buyer') {
            // Pastikan perbandingan ID dilakukan dengan tipe data yang konsisten
            if ((int) session('user_id') === (int) $buyer_id) {
                return redirect()->route('user.profile'); // Redirect ke rute profil pribadi
            }
        }

        // Mengambil data user dari database berdasarkan buyer_id dari URL
        // Pastikan $buyer_id dikonversi ke int jika primary key adalah int
        $user = Buyer::with('posts')->find((int) $buyer_id);

        // Jika user tidak ditemukan, tampilkan halaman 404
        if (!$user) {
            abort(404, 'Profil pengguna tidak ditemukan.');
        }

        return view('pages.user.profile', compact('user'));
    }

    public function edit()
    {
        if (!session()->has('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login');
        }
        $user = Buyer::find((int) session('user_id'));
        if (!$user) {
            session()->forget(['user_id', 'role', 'username', 'email', 'buyer_avatar_url']);
            return redirect()->route('login')->with('error', 'Profil tidak ditemukan untuk diedit. Silakan login kembali.');
        }
        return view('pages.user.edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        if (!session()->has('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login');
        }

        $user = Buyer::find((int) session('user_id'));
        if (!$user) {
             return redirect()->route('login')->with('error', 'Profil tidak ditemukan untuk diperbarui. Silakan login kembali.');
        }

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:buyers,username,' . $user->buyer_id . ',buyer_id',
            'email' => 'required|email|unique:buyers,email,' . $user->buyer_id . ',buyer_id',
            'nickname' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Pertahankan jika fitur upload avatar masih diinginkan
        ]);

        $data = $request->only([
            'name', 'username', 'email', 'nickname', 'country', 'birthdate', 'phone_number', 'address', 'bio'
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->avatar->extension();
            $path = $request->avatar->storeAs('avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        // Perbarui data primitif di session setelah update
        session([
            'username' => $user->username,
            'email' => $user->email,
            'buyer_avatar_url' => $user->avatar_url, // Memastikan URL avatar di session terbaru
        ]);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
