<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $table = 'payment_receipt';
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'product_id',
        'buyer_id',
        'payment_id',
        'order_id',
        'payment_date',
        'payment_method',
        'payment_code',
        'price_total',
        'qty', // tambahkan ini
    ];

    public $timestamps = false;

    // Relasi ke Payment (jika dibutuhkan)
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    // (Opsional) Relasi ke Buyer
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    // (Opsional) Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id')->withDefault();
    }
}
