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
    'birthdate',
    'exp',
    'bio',
    'phone_number',
    'avatar',
    'country',
    'nickname',
];

    public $timestamps = false;
    public $incrementing = true;
}
