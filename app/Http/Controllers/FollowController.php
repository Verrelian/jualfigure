<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\buyer;

class FollowController extends Controller
{
    public function follow($id)
    {
        $user = auth()->user();
        if ($user->id == $id) {
            return back()->with('error', 'Cannot follow yourself!');
        }

        $user->followings()->syncWithoutDetaching([$id]);
        return back()->with('success', 'Followed successfully!');
    }

    public function unfollow($id)
    {
        $user = auth()->user();
        $user->followings()->detach($id);
        return back()->with('success', 'Unfollowed successfully!');
    }
}
