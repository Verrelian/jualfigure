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
    ];
    public $timestamps = false;

    public function receipt()
    {
        return $this->hasOne(PaymentReceipt::class, 'payment_id');
    }
}
