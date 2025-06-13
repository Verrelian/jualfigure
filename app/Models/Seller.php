<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $primaryKey = 'seller_id';
    protected $fillable = [
    'username',
    'email',
    'password',
];

    public $timestamps = false;
    public $incrementing = true;
}
