<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Services\FilterService;
use App\Models\Wishlist;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', null);
        $priceRange = $request->get('price_range', null);

        $query = Product::where('status', 'active');

        // Filter kategori jika ada
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        // Filter rentang harga jika ada
        if ($priceRange) {
            $rangeParts = explode('-', $priceRange);
            if (count($rangeParts) === 2) {
                $minPrice = (float) $rangeParts[0];
                $maxPrice = (float) $rangeParts[1];
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        }

        $products = $query->get(); // atau bisa pakai paginate()
        $initialCategory = $category ?? 'all';

        return view('explore', compact('products', 'initialCategory'));
    }

    public function show($product_id)
    {
        // Ambil produk
        $product = Produk::with('specification')->findOrFail($product_id);

        // Ambil produk terkait
        $relatedProducts = Produk::where('product_id', '!=', $product_id)
            ->byType($product->type)
            ->inStock()
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->map(function ($relatedProduct) {
                return [
                    'product_id' => $relatedProduct->product_id,
                    'image' => $relatedProduct->gambar_url,
                    'title' => $relatedProduct->product_name,
                    'type' => $relatedProduct->type,
                    'price' => $relatedProduct->formatted_harga,
                    'description' => $relatedProduct->description,
                    'stock' => $relatedProduct->stock,
                    'rating_total' => $relatedProduct->rating_total,
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

        // Cek apakah user sudah wishlist produk ini
        $wishlisted = false;
        if (session('user_id') && session('role') === 'buyer') {
            $wishlisted = Wishlist::where('buyer_id', session('user_id'))
                ->where('product_id', $product->product_id)
                ->exists();
        }

        // Kembalikan ke view
        return view('pages.product.product-detail', [
            'product' => [
                'product_id' => $product->product_id,
                'image' => $product->gambar_url,
                'title' => $product->product_name,
                'type' => $product->type,
                'price' => $product->formatted_harga,
                'description' => $product->description,
                'stock' => $product->stock,
                'rating_total' => $product->rating_total,
                'specifications' => $product->specification ? [
                    'Scale' => $product->specification->scale ?? 'N/A',
                    'Material' => $product->specification->material ?? 'N/A',
                    'Manufacture' => $product->specification->manufacture ?? 'N/A',
                    'Release Date' => $product->specification->release_date ?? 'N/A',
                    'Series' => $product->specification->series ?? 'N/A'
                ] : []
            ],
            'relatedProducts' => $relatedProducts,
            'wishlisted' => $wishlisted
        ]);
    }

    public function explore(Request $request)
    {
        // Mapping category slug ke type database (CUMA INI YANG DIUBAH)
        $categorySlugs = [
            'nendoroid' => 'Nendoroid',
            'popup' => 'Pop Up Parade',
            'hottoys' => 'Hot Toys'
        ];

        // Get initial category dari URL parameter
        $initialCategory = request()->query('category', 'nendoroid');
        $initialType = $categorySlugs[$initialCategory] ?? 'Nendoroid';

        // Pake FilterService yang udah ada (TETEP PAKE INI)
        $filterService = new \App\Services\FilterService();
        $query = Produk::with(['specification', 'seller'])->where('type', $initialType);
        $filterOptions = $filterService->getFilterOptions();
        $products = $filterService->apply($query, $request->all())->paginate(12);

        // Return view tetep sama
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
        // Mapping slug ke nama tipe (CUMA INI YANG DIUBAH)
        $categoryMap = [
            'nendoroid' => 'Nendoroid',
            'popup'     => 'Pop Up Parade',
            'hottoys'   => 'Hot Toys'
        ];

        $categorySlug = $request->query('category', 'nendoroid');
        $type = $categoryMap[$categorySlug] ?? 'Nendoroid';

        // Build query dasar
        $query = Produk::with(['specification', 'seller'])
            ->where('type', $type)
            ->inStock()
            ->orderBy('created_at', 'desc');

        // Apply filters via service (TETEP PAKE FILTERSERVICE)
        $filters = array_merge($request->all(), ['type' => $type]);
        $filterService = new FilterService();
        $products = $filterService->apply($query, $filters)->paginate(12);

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $products->map(function ($product) {
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

        // Fallback view
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

        // Return JSON response
        return response()->json([
            'success' => true,
            'products' => $products->map(function ($product) {
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
    public function categoryResults($category, Request $request)
    {
        $categoryMap = [
            'nendoroid' => 'Nendoroid',
            'popup'     => 'Pop Up Parade',
            'hottoys'   => 'Hot Toys'
        ];

        if (!isset($categoryMap[$category])) {
            abort(404, 'Category not found');
        }

        $type = $categoryMap[$category];
        $categoryName = $categoryMap[$category];

        // Ambil sort dari request
        $sort = $request->get('sort', 'latest');

        // Mulai query
        $query = Produk::with(['specification', 'seller'])
            ->where('type', $type)
            ->where('stock', '>', 0);

        // Terapkan sorting
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('rating_total', 'desc'); // asumsi popular berdasarkan rating_total
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        $totalProducts = Produk::where('type', $type)
            ->where('stock', '>', 0)
            ->count();

        return view('pages.category-results', [
            'products' => $products,
            'category' => $category,
            'categoryName' => $categoryName,
            'totalProducts' => $totalProducts,
            'sort' => $sort
        ]);
    }

}