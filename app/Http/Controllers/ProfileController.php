<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use App\Models\Post;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login.
     * Route: /user/profile
     */
    public function show()
    {
        if (!session()->has('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Silakan login dahulu.');
        }

        $buyer = Buyer::findOrFail((int) session('user_id'));
        return $this->showProfile($buyer);
    }

    /**
     * Menampilkan profil pengguna lain berdasarkan buyer_id dari URL.
     * Route: /profile/{buyer_id}
     *
     * PERBAIKAN: Gunakan parameter $buyer_id langsung, bukan model binding
     */
    public function showOther($buyer_id)
    {
        // Debug info untuk troubleshooting
        $debug = [
            'method' => 'showOther() - Profil Orang Lain',
            'session_user_id' => session('user_id'),
            'url_buyer_id' => $buyer_id,
        ];

        // Pastikan menggunakan buyer_id dari URL, bukan dari session
        $buyer = Buyer::where('buyer_id', $buyer_id)->firstOrFail();

        $debug['buyer_name'] = $buyer->name;
        $debug['buyer_username'] = $buyer->username;
        $debug['is_same_as_session'] = (int)session('user_id') === (int)$buyer->buyer_id;

        // Uncomment untuk debugging
        // dd($debug);

        return $this->showProfile($buyer);
    }

    /**
     * Method private untuk handle logic profil (DRY principle)
     */
    private function showProfile(Buyer $buyer)
    {
        // Debug untuk memastikan data yang benar
        $debug = [
            '$user->buyer_id' => $buyer->buyer_id,
            '$user->name' => $buyer->name,
            '$user->username' => $buyer->username,
            '$user->email' => $buyer->email,
            'session(\'user_id\')' => session('user_id'),
            'session(\'username\')' => session('username'),
        ];

        $posts = Post::where('user_id', $buyer->buyer_id)
            ->withCount(['likes', 'comments'])
            ->with(['buyer', 'images', 'comments.buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_posts' => $posts->count(),
            'total_likes' => $posts->sum('likes_count'),
            'total_comments' => $posts->sum('comments_count'),
        ];

        // Deteksi apakah ini profil sendiri atau orang lain
        $isOwnProfile = session()->has('user_id') && (int)session('user_id') === (int)$buyer->buyer_id;
        $isFollowing = false;
        if (!$isOwnProfile) {
            $viewerId = session('user_id');
            $viewer = Buyer::find($viewerId);
            $isFollowing = $viewer && $viewer->isFollowing($buyer->buyer_id);
        }

        $debug['$isOwnProfile'] = $isOwnProfile;
        $debug['Posts count'] = $posts->count();

        if ($posts->count() > 0) {
            $debug['Posts user_id check'] = 'First post user_id: ' . $posts->first()->user_id;
        }

        // Uncomment untuk debugging
        // dd($debug);

        return view('pages.user.profile', [
            'user' => $buyer,
            'posts' => $posts,
            'stats' => $stats,
            'isOwnProfile' => $isOwnProfile,
            'isFollowing' => $isFollowing // Kirim ke view

        ]);
    }

    /**
     * Menampilkan semua posts dari user tertentu
     * Route: /user/posts/{buyer_id?}
     */
    public function userPosts($buyer_id = null)
    {
        if ($buyer_id) {
            $buyer = Buyer::where('buyer_id', $buyer_id)->firstOrFail();
        } else {
            $buyer = Buyer::findOrFail(session('user_id'));
        }

        $posts = $buyer->posts()
            ->with(['images', 'comments.buyer'])
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_posts' => $posts->count(),
            'total_likes' => $posts->sum('likes_count'),
            'total_comments' => $posts->sum('comments_count')
        ];

        $isOwnProfile = session()->has('user_id') && (int)session('user_id') === (int)$buyer->buyer_id;


        return view('pages.posts.profile', [
            'buyer' => $buyer,
            'posts' => $posts,
            'stats' => $stats,
            'isOwnProfile' => $isOwnProfile
        ]);
    }

    /**
     * Toggle follow/unfollow user
     */
    public function toggleFollow(Request $request, $buyerId)
    {
        if (!session()->has('user_id')) {
            return back()->with('error', 'Silakan login dahulu.');
        }

        $user = Buyer::findOrFail((int) session('user_id'));
        $target = Buyer::where('buyer_id', $buyerId)->firstOrFail();

        if ($user->buyer_id === $target->buyer_id) {
            return back()->with('error', 'Tidak bisa mengikuti diri sendiri.');
        }

        if ($user->isFollowing($buyerId)) {
            $user->following()->detach($buyerId);
            $message = 'Berhasil unfollow ' . $target->name;
        } else {
            $user->following()->attach($buyerId);
            $message = 'Berhasil follow ' . $target->name;
        }

        return back()->with('success', $message);
    }


    public function likePost(Post $post)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = (int) session('user_id');
        $existingLike = $post->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $userId]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count()
        ]);
    }

    /**
     * Add comment to post
     */
    public function commentPost(Request $request, Post $post)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = $post->comments()->create([
            'user_id' => (int) session('user_id'),
            'content' => $request->content
        ]);

        $comment->load('buyer');

        return response()->json([
            'comment' => $comment,
            'comments_count' => $post->comments()->count()
        ]);
    }

    /**
     * Toggle follow/unfollow user
     */

    /**
     * Edit profile form
     */
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

    /**
     * Update profile
     */
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
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

        session([
            'username' => $user->username,
            'email' => $user->email,
            'buyer_avatar_url' => $user->avatar_url,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
