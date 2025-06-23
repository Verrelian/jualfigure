<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Services\FilterService;


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

    public function explore(Request $request)
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


        // Dengan ini:
        $filterService = new \App\Services\FilterService();
        $query = Produk::with(['specification', 'seller'])->where('type', $initialType);
        $products = $filterService->apply($query, $request->all())->paginate(12);
        $filterOptions = $filterService->getFilterOptions();

        // Dan update return view:
        return view('pages.general.explore', [
            'categories' => $categorySlugs,
            'initialCategory' => $initialCategory,
            'products' => $products,
            'filterOptions' => $filterOptions,
            'activeFilters' => $request->all()
        ]);
    }

    public function getProductsByCategory(Request $request)
    {
        // Step 1: Mapping slug ke nama tipe
        $categoryMap = [
            'nendoroid' => 'Nendoroid',
            'popup'     => 'Pop Up Parade',
            'hottoys'   => 'Hot Toys'
        ];

        $categorySlug = $request->query('category', 'nendoroid');
        $type = $categoryMap[$categorySlug] ?? 'Nendoroid';

        // Step 2: Build query dasar
        $query = Produk::with(['specification', 'seller'])
                    ->where('type', $type)
                    ->inStock()
                    ->orderBy('created_at', 'desc');

        // Step 3: Apply filters via service
        $filters = array_merge($request->all(), ['type' => $type]);
        $filterService = new FilterService();
        $products = $filterService->apply($query, $filters)->paginate(12);

        // Step 4: AJAX response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $products->map(function($product) {
                    return [
                        'product_id'  => $product->product_id,
                        'name'        => $product->product_name,
                        'type'        => $product->type,
                        'harga'       => $product->formatted_harga,
                        'gambar_url'  => $product->gambar_url,
                        'stok'        => $product->stock
                    ];
                }),
                'category' => $categorySlug
            ]);
        }

        // Step 5: Fallback view
        return view('partials.explore.products', [
            'products' => $products,
            'category' => $categorySlug
        ]);
    }
    public function filter(Request $request)
    {
        $filterService = new \App\Services\FilterService();
        $query = Produk::with(['specification', 'seller']);
        $products = $filterService->apply($query, $request->all())->paginate(12);

        // Return JSON response aja
        return response()->json([
            'success' => true,
            'products' => $products->map(function($product) {
                return [
                    'product_id' => $product->product_id,
                    'name' => $product->product_name,
                    'type' => $product->type,
                    'harga' => $product->formatted_harga,
                    'gambar_url' => $product->gambar_url,
                    'stok' => $product->stock,
                    'specifications' => $product->specification ? [
                        'scale' => $product->specification->scale,
                        'material' => $product->specification->material,
                        'manufacture' => $product->specification->manufacture,
                        'series' => $product->specification->series
                    ] : null
                ];
            })
        ]);
    }
        public function getFilterOptions()
    {
        $filterService = new \App\Services\FilterService();
        return response()->json($filterService->getFilterOptions());
    }

}