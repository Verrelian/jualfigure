<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specification; // jangan lupa import model Specification

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tblproduk'; // sesuai tabel kamu

    protected $fillable = [
        'nama',
        'deskripsi',
        'type',
        'harga',
        'stok',
        'gambar'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    // Relasi: 1 produk punya banyak Specification
    public function specification()
    {
        return $this->hasOne(Specification::class, 'product_id', 'id');
        // pastikan FK di tabel Specification adalah product_id
    }

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp' . number_format($this->harga, 0, ',', '.');
    }

    // Accessor untuk gambar URL
    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    // Scope untuk produk yang masih ada stok
    public function scopeInStock($query)
    {
        return $query->where('stok', '>', 0);
    }

    // Scope untuk produk berdasarkan type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
