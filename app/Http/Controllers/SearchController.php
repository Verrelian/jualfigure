<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\produk;


class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('search_keyword');

        $produk = Produk::with('specification')
            ->where('product_name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->get();

        return view('pages.search.result', compact('produk', 'keyword'));
    }

}
