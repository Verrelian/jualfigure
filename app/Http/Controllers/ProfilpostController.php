<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // Dummy data dulu kalau belum pakai database
        $posts = [
            ['title' => 'My First Post', 'description' => 'This is my first post!', 'photo' => 'image/toy1.jpg'],
            ['title' => 'Another Toy', 'description' => 'Cool stuff I got today.', 'photo' => 'image/toy2.jpg'],
        ];

        return view('profile_posts', compact('posts'));
    }

    public function create()
    {
        return view('create_post');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Dummy simpan (belum database)
        return redirect()->route('profile.posts')->with('success', 'Post created!');
    }
}
