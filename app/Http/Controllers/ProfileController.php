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

    $user = Auth::user();
    return view('profile', compact('user'));
}

public function edit()
{
    if (!Auth::check()) {
        return redirect()->route('login');
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

    $data = $request->only([
        'name', 'username', 'email', 'nickname', 'country', 'birthdate', 'phone', 'address', 'bio'
    ]);

    if ($request->hasFile('avatar')) {
        $filename = time() . '.' . $request->avatar->extension();
        $path = $request->avatar->storeAs('avatars', $filename, 'public');
        $data['avatar'] = $path;
    }

    $user->update($data);

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
}
}