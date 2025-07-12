<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Buyer extends Model
{
    protected $primaryKey = 'buyer_id'; // Primary key bukan 'id'
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'username', 'name', 'email', 'password', 'address',
        'birthdate', 'exp', 'bio', 'phone_number', 'avatar',
    ];

    /**
     * Akses URL avatar default jika belum ada
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default_avatar.jpg');
    }

    /**
     * Relasi Buyer -> Posts (One to Many)
     * foreign key di tabel posts adalah 'user_id'
     * local key di buyers adalah 'buyer_id'
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'buyer_id');
    }

    /**
     * Relasi Buyer -> Likes (One to Many)
     * foreign key di post_likes adalah 'user_id'
     * local key di buyers adalah 'buyer_id'
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class, 'user_id', 'buyer_id');
    }

    /**
     * Relasi Buyer -> Comments (One to Many)
     * foreign key di post_comments adalah 'user_id'
     * local key di buyers adalah 'buyer_id'
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'user_id', 'buyer_id');
    }

    /**
     * Supaya route model binding memakai buyer_id, bukan id
     */
    public function getRouteKeyName()
    {
        return 'buyer_id';
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(Buyer::class, 'followers', 'following_id', 'follower_id');
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(Buyer::class, 'followers', 'follower_id', 'following_id');
    }
    public function isFollowing($buyerId): bool
    {
        return $this->following()->where('following_id', $buyerId)->exists();
    }
}
