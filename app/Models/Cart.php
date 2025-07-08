<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'buyer_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'buyer_id' => 'integer',
        'product_id' => 'integer'
    ];

    /**
     * Relasi ke Buyer
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Scope untuk filter berdasarkan buyer
     */
    public function scopeForBuyer($query, $buyerId)
    {
        return $query->where('buyer_id', $buyerId);
    }

    /**
     * Get total price untuk cart item ini
     */
    public function getTotalPriceAttribute()
    {
        if ($this->product) {
            // Handle different price formats
            $price = $this->product->price;

            // If price is string with "Rp" format
            if (is_string($price) && strpos($price, 'Rp') !== false) {
                $price = (int) str_replace(['Rp ', '.', ','], ['', '', ''], $price);
            } else {
                // If price is already numeric
                $price = (int) $price;
            }

            return $price * $this->quantity;
        }
        return 0;
    }

    /**
     * Static method untuk mendapatkan total items di cart untuk buyer
     */
    public static function getTotalItemsForBuyer($buyerId)
    {
        return static::where('buyer_id', $buyerId)->sum('quantity');
    }

    /**
     * Static method untuk mendapatkan subtotal untuk buyer
     */
    public static function getSubtotalForBuyer($buyerId)
    {
        $cartItems = static::with('product')->where('buyer_id', $buyerId)->get();
        return $cartItems->sum(function($item) {
            return $item->total_price;
        });
    }

    /**
     * Static method untuk clear cart setelah checkout
     */
    public static function clearCartForBuyer($buyerId)
    {
        return static::where('buyer_id', $buyerId)->delete();
    }
}