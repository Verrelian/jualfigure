<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini jika model menggunakan factory

class PostLike extends Model
{
    // Jika primary key Anda bukan 'id', definisikan di sini
    // protected $primaryKey = 'id'; // Biasanya default jika $table->id() di migrasi

    // Pastikan ini terisi dengan kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'post_id',
        'user_id', // <<<--- TAMBAHKAN BARIS INI
    ];

    // Jika Anda tidak menggunakan timestamps (created_at, updated_at), set ini false
    // public $timestamps = false;

    // Relasi ke Post
    public function post()
    {
        // Asumsi primary key Post adalah 'id'
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    // Relasi ke User (Buyer) yang melakukan like
    public function user()
    {
        // Asumsi primary key Buyer adalah 'buyer_id'
        return $this->belongsTo(Buyer::class, 'user_id', 'buyer_id');
    }
}