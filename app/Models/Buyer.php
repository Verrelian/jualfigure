<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $primaryKey = 'buyer_id';
    protected $fillable = ['phone_number', 'name', 'address'];
    public $timestamps = false;
    public $incrementing = true;
}
