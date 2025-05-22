<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'status'];

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('images/default-post.jpg');
    }
}
