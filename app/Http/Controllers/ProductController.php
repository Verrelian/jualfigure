<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Changed from Product to Produk

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.product-detail');
    }

    public function show($id)
    {
        // Eager load the specification relationship
        $product = Produk::with('specification')->findOrFail($id);

        // Get related products (3 random products of the same type, excluding current product)
        $relatedProducts = Produk::where('id', '!=', $id)
            ->byType($product->type) // Using the scope from the model
            ->inStock() // Using the scope from the model
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->map(function ($relatedProduct) {
                return [
                    'id' => $relatedProduct->id,
                    'image' => $relatedProduct->gambar_url, // Using the accessor
                    'title' => $relatedProduct->nama,
                    'type' => $relatedProduct->type,
                    'price' => $relatedProduct->formatted_harga, // Using the accessor
                    'description' => $relatedProduct->deskripsi,
                    'specifications' => $relatedProduct->specification ? [
                        'Scale' => $relatedProduct->specification->scale ?? 'N/A',
                        'Material' => $relatedProduct->specification->material ?? 'N/A',
                        'Manufacture' => $relatedProduct->specification->manufacture ?? 'N/A',
                        'Release Date' => $relatedProduct->specification->release_date ?? 'N/A',
                        'Series' => $relatedProduct->specification->series ?? 'N/A'
                    ] : []
                ];
            })
            ->toArray();

        return view('pages.product-detail', [
            'product' => [
                'id' => $product->id,
                'image' => $product->gambar_url, // Using the accessor
                'title' => $product->nama,
                'type' => $product->type,
                'price' => $product->formatted_harga, // Using the accessor
                'description' => $product->deskripsi,
                'specifications' => $product->specification ? [
                    'Scale' => $product->specification->scale ?? 'N/A',
                    'Material' => $product->specification->material ?? 'N/A',
                    'Manufacture' => $product->specification->manufacture ?? 'N/A',
                    'Release Date' => $product->specification->release_date ?? 'N/A',
                    'Series' => $product->specification->series ?? 'N/A'
                ] : []
            ],
            'relatedProducts' => $relatedProducts
        ]);
    }
}