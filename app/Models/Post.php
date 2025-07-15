<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan ini pakai backslash
use Illuminate\Database\Eloquent\Model; // Pastikan ini pakai backslash
use Illuminate\Support\Facades\Storage; // Pastikan ini pakai backslash

class Post extends Model
{
    use HasFactory;

    // Tambahkan 'user_id' ke fillable, bukan 'buyer_id'
    protected $fillable = ['title', 'description', 'image', 'status', 'user_id'];
    // Primary key adalah 'id' dari $table->id() di migrasi
    // protected $primaryKey = 'post_id'; // Hapus/komen out ini jika PK adalah 'id'

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    // Relasi ke model Buyer
    // foreign_key di tabel posts adalah 'user_id'
    // owner_key di tabel buyers adalah 'buyer_id'
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'user_id', 'buyer_id'); // UBAH dari 'buyer_id' menjadi 'user_id'
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default_post.jpg');
    }
        public function images()
    {
        return $this->hasMany(PostImage::class);
    }

}
