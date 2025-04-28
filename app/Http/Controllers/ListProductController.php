<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListProductController extends Controller
{
    public function index()
    {    $data = [
            ['id' => 1, 'produk' => 'Action Figure Naruto'],
            ['id' => 2, 'produk' => 'Action Figure Sakura'],
            ['id' => 3, 'produk' => 'Action Figure Sasuke']
        ];

        return view('list_product', ['data' => $data]);
    }
}
