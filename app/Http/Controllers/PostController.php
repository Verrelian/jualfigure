<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Menampilkan daftar post
    public function index()
    {
        $posts = Post::withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.posts.feed', compact('posts'));
    }

    // Menampilkan form create
    public function create()
    {
        return view('pages.posts.create');
    }

    // Menyimpan post baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            // Simpan gambar ke public/postfeed
            $imageName = 'postf/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('postf'), $imageName);
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName, // Simpan path relatif
            'status' => 'active',
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dibuat!');
    }
    // app/Http/Controllers/PostController.php
    public function like(Post $post)
    {
        // Jika belum login, redirect ke halaman login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu');
        }

        $existingLike = PostLike::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return back()->with('info', 'Like dihapus');
        }

        PostLike::create([
            'post_id' => $post->id,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Post disukai!');
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|min:3|max:500'
        ]);

        // Jika belum login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu');
        }

        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }
}
