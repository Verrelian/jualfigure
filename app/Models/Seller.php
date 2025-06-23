<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $primaryKey = 'seller_id';
    protected $fillable = [
    'username',
    'name',
    'email',
    'password',
    'address',
    'birthdate',
    'exp',
    'bio',
    'phone_number',
    'avatar',
    'nickname',
];

    public $timestamps = false;
    public $incrementing = true;
}
