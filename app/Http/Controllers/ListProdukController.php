<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ListProdukController extends Controller
{
    public function show()
    {
        $data = Produk::orderBy('harga', 'desc')->get(); # untuk menampilkan data dari database berdasarkan urutan harga dari besar ke keil
        #$produk = Produk::where('harga', '>', 100000)->get(); #dengan kondisi
        foreach ($data as $produk) {
            $nama[] = $produk->nama;
            $desc[] = $produk->deskripsi;
            $harga[] = $produk->harga;
        }
        return view('listproduk', compact('nama', 'desc', 'harga'));
    }
}
