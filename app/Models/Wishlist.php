<?php

// =================
// Model Wishlist
// =================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'product_id'
    ];

    // Relasi dengan tabel buyers
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }

    // Relasi dengan tabel products
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}