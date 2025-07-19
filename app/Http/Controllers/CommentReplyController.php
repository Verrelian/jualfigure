<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Menampilkan semua comments untuk post tertentu
    public function index($postId)
    {
        ]);

        if (session('role') !== 'buyer' || !session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $comment = PostComment::create([
            'post_id' => $postId,
            'user_id' => session('user_id'),
            'comment' => $request->comment,
            'parent_id' => null,
            'level' => 0
        ]);

        $comment->load('buyer:buyer_id,name,avatar');

        return response()->json([
            'success' => true,
            'data' => $comment,
            'message' => 'Comment berhasil ditambahkan'
        ]);
    }

    // Membuat reply untuk comment tertentu
    public function reply(Request $request, $commentId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        if (session('role') !== 'buyer' || !session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $parentComment = PostComment::findOrFail($commentId);

        // Batasi level reply maksimal 3 level
        if ($parentComment->level >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'Maksimal 3 level reply'
            ], 400);
        }

        $reply = PostComment::create([
            'post_id' => $parentComment->post_id,
            'user_id' => session('user_id'),
            'comment' => $request->comment,
            'parent_id' => $commentId,
            'level' => $parentComment->level + 1
        ]);

        $reply->load('buyer:buyer_id,name,avatar');

        return response()->json([
            'success' => true,
            'data' => $reply,
            'message' => 'Reply berhasil ditambahkan'
        ]);
    }

    // Get replies untuk comment tertentu
    public function getReplies($commentId)
    {
        $replies = PostComment::where('parent_id', $commentId)
            ->with('buyer:buyer_id,name,avatar')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $replies
        ]);
    }

    // Delete comment
    public function destroy($commentId)
    {
        if (session('role') !== 'buyer' || !session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $comment = PostComment::findOrFail($commentId);

        // Pastikan hanya pemilik comment yang bisa delete
        if ($comment->user_id !== session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus comment orang lain'
            ], 403);
        }

        $comment->delete(); // Akan otomatis delete semua replies karena cascade

        return response()->json([
            'success' => true,
            'message' => 'Comment berhasil dihapus'
        ]);
    }
}$comments = PostComment::where('post_id', $postId)
            ->parents() // Hanya parent comments
            ->with([
                'buyer:buyer_id,name,avatar', // Sesuaikan kolom yang dibutuhkan
                'allReplies.buyer:buyer_id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    // Membuat comment baru (parent comment)
    public function store(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',