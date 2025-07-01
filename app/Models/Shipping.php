<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shipping';
    protected $primaryKey = 'shipping_id';
    protected $fillable = [
        'payment_id',
        'status',
        'location',
        'description',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
}
