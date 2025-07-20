<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentReceipt;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'name',
        'quantity',
        'payment_method',
        'product_name',
        'type',
        'image',
        'price',
        'price_total',
        'address',
        'order_id',
        'payment_code',
        'phone_number',
        'transaction_status',
        'payment_date',
        'payment_status',
        'expired_at',
        'completed_at',
        'shipping_ready_at',
        'rating'
    ];
    public $timestamps = false;

    public function receipt()
    {
        return $this->hasOne(PaymentReceipt::class, 'payment_id');
    }

    public function shipping()
    {
        return $this->hasMany(Shipping::class, 'payment_id', 'payment_id');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
