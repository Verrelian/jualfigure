<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.product.product-detail');
    }

    public function show($product_id)
    {
        // Eager load the specification relationship
        $product = Produk::with('specification')->findOrFail($product_id);

        // Get related products (3 random products of the same type, excluding current product)
        $relatedProducts = Produk::where('product_id', '!=', $product_id)
            ->byType($product->type) // Using the scope from the model
            ->inStock() // Using the scope from the model
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->map(function ($relatedProduct) {
                return [
                    'product_id' => $relatedProduct->product_id,
                    'image' => $relatedProduct->gambar_url, // Using the accessor
                    'title' => $relatedProduct->product_name, // Fixed: use product_name
                    'type' => $relatedProduct->type,
                    'price' => $relatedProduct->formatted_harga, // Using the accessor
                    'description' => $relatedProduct->description,
                    'stock' => $relatedProduct->stock,
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

        return view('pages.product.product-detail', [
            'product' => [
                'product_id' => $product->product_id,
                'image' => $product->gambar_url, // Using the accessor
                'title' => $product->product_name, // Fixed: use product_name
                'type' => $product->type,
                'price' => $product->formatted_harga, // Using the accessor
                'description' => $product->description,
                'stock' => $product->stock,
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

    public function explore()
    {
        // Ambil semua type unik dari database
        $categories = Produk::select('type')
                          ->distinct()
                          ->orderBy('type')
                          ->pluck('type')
                          ->toArray();

        // Format untuk tampilan dengan slug mapping
        $categorySlugs = [
            'nendoroid' => 'Nendoroid',
            'popup' => 'Pop Up Parade',
            'hottoys' => 'Hot Toys'
        ];

        // Get initial category from URL parameter
        $initialCategory = request()->query('category', 'nendoroid');
        $initialType = $categorySlugs[$initialCategory] ?? $categories[0] ?? 'Nendoroid';

        // Get initial products
        $products = Produk::where('type', $initialType)
                         ->inStock()
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('pages.general.explore', [
            'categories' => $categorySlugs,
            'initialCategory' => $initialCategory,
            'products' => $products
        ]);
    }

    public function getProductsByCategory(Request $request)
    {
        // Category slug to type mapping
        $categoryMap = [
            'nendoroid' => 'Nendoroid',
            'popup' => 'Pop Up Parade',
            'hottoys' => 'Hot Toys'
        ];

        $categorySlug = $request->query('category', 'nendoroid');
        $type = $categoryMap[$categorySlug] ?? 'Nendoroid';

        $products = Produk::where('type', $type)
                         ->inStock()
                         ->orderBy('created_at', 'desc')
                         ->get();

        // Return JSON response for AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $products->map(function($product) {
                    return [
                        'product_id' => $product->product_id,
                        'name' => $product->product_name, // Fixed: use product_name
                        'type' => $product->type,
                        'harga' => $product->formatted_harga,
                        'gambar_url' => $product->gambar_url,
                        'stok' => $product->stock // Fixed: use stock not stok
                    ];
                }),
                'category' => $categorySlug
            ]);
        }

        // Fallback for non-AJAX requests
        return view('partials.explore.products', ['products' => $products]);
    }
}