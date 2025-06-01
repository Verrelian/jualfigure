<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Seller',
            'username' => 'selleruser',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
            'role' => 'penjual',
        ]);
    }
}
