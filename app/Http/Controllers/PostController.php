<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::withCount(['likes', 'comments'])
            ->with(['buyer', 'comments.buyer']) // Tambahkan eager loading komentar dan pembuatnya
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.posts.feed', compact('posts'));
    }

    /**
     * Menampilkan form create post
     */
    public function create()
    {
        if (session('role') !== 'buyer' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai buyer untuk membuat post.');
        }

        return view('pages.posts.create');
    }

    /**
     * Menyimpan postingan baru
     */
        public function store(Request $request)
        {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $userId = session('user_id');

            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'active',
                'user_id' => $userId,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('post_images', 'public');
                    $post->images()->create(['image' => $path]);
                }
            }

            return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
        }

    /**
     * Menyukai atau batal menyukai postingan
     */
    public function like(Post $post)
    {
        if (session('role') !== 'buyer' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        $userId = session('user_id');

        $existingLike = PostLike::where('post_id', $post->id)
            ->where('user_id', $userId) // PERBAIKAN: Pastikan ini menggunakan 'user_id'
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return back()->with('info', 'Like dihapus.');
        }

        PostLike::create([
            'post_id' => $post->id,
            'user_id' => $userId // PERBAIKAN PENTING: Tambahkan 'user_id' di sini!
        ]);

        return back()->with('success', 'Post disukai!');
    }

    /**
     * Menambahkan komentar ke postingan
     */
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|min:3|max:500'
        ]);

        if (session('role') !== 'buyer' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        $post->comments()->create([
            'user_id' => session('user_id'),
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }


}
