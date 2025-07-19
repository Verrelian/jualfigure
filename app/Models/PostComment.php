<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'parent_id',
        'level',
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    // Relasi ke User (Buyer) yang membuat komentar
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'user_id', 'buyer_id');
    }

    // Relasi ke parent comment
    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    // Relasi ke replies (child comments)
    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')
                    ->orderBy('created_at', 'asc');
    }

    // Untuk mendapatkan semua replies secara rekursif
    public function allReplies()
    {
        return $this->replies()->with('allReplies');
    }

    // Scope untuk mendapatkan only parent comments
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope untuk mendapatkan replies dari parent tertentu
    public function scopeRepliesOf($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    // Check apakah comment ini adalah reply
    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    // Check apakah comment ini punya replies
    public function hasReplies()
    {
        return $this->replies()->exists();
    }

    // Get total replies count
    public function getRepliesCountAttribute()
    {
        return $this->replies()->count();
    }
}