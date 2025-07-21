<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['nullable', 'regex:/^(\+62|62|0)[0-9]{9,12}$/'],
            'subject' => 'required|string',
            'message' => 'required|string',
            'terms' => 'accepted',
        ]);

        // (Opsional) Simpan ke database
        // ContactMessage::create($validated); ← butuh model & migration

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
