<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specification; // jangan lupa import model Specification

class Produk extends Model
{
    use HasFactory;

    protected $table = 'products'; // sesuai tabel kamu

    protected $fillable = [
        'product_name',
        'description',
        'type',
        'price',
        'stock',
        'sold',
        'rating_total',
        'images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relasi: 1 produk punya banyak Specification
    public function specification()
    {
        return $this->hasOne(Specification::class, 'product_id', 'product_id');
        // pastikan FK di tabel Specification adalah product_id
    }

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    // Accessor untuk gambar URL
    public function getGambarUrlAttribute()
    {
        return $this->images ? asset('images/' . $this->images) : null;
    }

    // Scope untuk produk yang masih ada stock
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Scope untuk produk berdasarkan type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
