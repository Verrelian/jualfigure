<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProductBuyerController extends Controller
{
    public function show()
    {
        $data = Produk::all(); // lebih umum dan clean pakai all()

        // Kirim seluruh data produk ke view, tidak perlu pisah array per atribut
        return view('dashboard', compact('data'));
    }
}
