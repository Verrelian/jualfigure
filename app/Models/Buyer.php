<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $primaryKey = 'buyer_id';
    protected $fillable = [
    'username',
    'name',
    'email',
    'password',
    'address',
    'exp',
    'bio',
    'phone_number',
];

    public $timestamps = false;
    public $incrementing = true;
}
