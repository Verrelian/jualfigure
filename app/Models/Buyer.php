<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Pastikan ini pakai backslash
use App\Models\Post; // Pastikan ini pakai backslash
use App\Models\PostLike; // Pastikan ini pakai backslash
use App\Models\PostComment; // Pastikan ini pakai backslash

class Buyer extends Model
{
    protected $primaryKey = 'buyer_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'username', 'name', 'email', 'password', 'address',
        'birthdate', 'exp', 'bio', 'phone_number', 'avatar',
    ];

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default_avatar.jpg');
    }

    /**
     * Relasi: Seorang Buyer memiliki banyak Posts.
     * foreign_key di tabel posts: 'user_id'
     * local_key di tabel buyers: 'buyer_id' (primaryKey)
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', $this->primaryKey); // UBAH DARI 'buyer_id' MENJADI 'user_id'
    }

    /**
     * Relasi: Seorang Buyer memiliki banyak Likes pada Posts.
     * foreign_key di tabel post_likes: 'user_id'
     * local_key di tabel buyers: 'buyer_id'
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class, 'user_id', $this->primaryKey);
    }

    /**
     * Relasi: Seorang Buyer memiliki banyak Comments pada Posts.
     * foreign_key di tabel post_comments: 'user_id'
     * local_key di tabel buyers: 'buyer_id'
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'user_id', $this->primaryKey);
    }
}
