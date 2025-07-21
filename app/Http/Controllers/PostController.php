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
            ->with([
                'buyer',
                'comments' => function($query) {
                    $query->parents() // Hanya parent comments
                          ->with(['buyer', 'allReplies.buyer'])
                          ->orderBy('created_at', 'desc');
                }
            ])
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
            $filename = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->move(public_path('images/post'), $filename);
            $post->images()->create(['image' => 'images/post/' . $filename]);
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
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return back()->with('info', 'Like dihapus.');
        }

        PostLike::create([
            'post_id' => $post->id,
            'user_id' => $userId
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

        $comment = $post->comments()->create([
            'user_id' => session('user_id'),
            'comment' => $request->comment,
            'parent_id' => null,
            'level' => 0
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }

    /**
     * Menambahkan reply ke komentar
     */
    public function replyComment(Request $request, $commentId)
    {
        $request->validate([
            'comment' => 'required|min:3|max:500'
        ]);

        if (session('role') !== 'buyer' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        $parentComment = PostComment::findOrFail($commentId);

        // Batasi level reply maksimal 3 level
        if ($parentComment->level >= 2) {
            return back()->with('error', 'Maksimal 3 level reply');
        }

        $reply = PostComment::create([
            'post_id' => $parentComment->post_id,
            'user_id' => session('user_id'),
            'comment' => $request->comment,
            'parent_id' => $commentId,
            'level' => $parentComment->level + 1
        ]);

        return back()->with('success', 'Reply berhasil ditambahkan!');
    }

    /**
     * Menghapus komentar
     */
    public function deleteComment($commentId)
    {
        if (session('role') !== 'buyer' || !session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        $comment = PostComment::findOrFail($commentId);

        // Pastikan hanya pemilik comment yang bisa delete
        if ($comment->user_id !== session('user_id')) {
            return back()->with('error', 'Tidak bisa menghapus comment orang lain');
        }

        $comment->delete(); // Akan otomatis delete semua replies karena cascade

        return back()->with('success', 'Comment berhasil dihapus!');
    }
    public function destroy(Post $post)
    {
        if (session('user_id') !== $post->user_id) {
            return back()->with('error', 'Kamu tidak bisa menghapus postingan orang lain.');
        }

        // Hapus file gambar di public
        foreach ($post->images as $image) {
            $imagePath = public_path($image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Hapus data relasi
        $post->images()->delete();
        $post->likes()->delete();
        $post->comments()->delete();
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil dihapus.');
    }

}