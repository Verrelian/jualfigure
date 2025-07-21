<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Services\FilterService;
use App\Models\Wishlist;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', null);
        $priceRange = $request->get('price_range', null);

        $query = Produk::where('status', 'active');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($priceRange) {
            $rangeParts = explode('-', $priceRange);
            if (count($rangeParts) === 2) {
                $minPrice = (float) $rangeParts[0];
                $maxPrice = (float) $rangeParts[1];
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        }

        $products = $query->get();
        $initialCategory = $category ?? 'all';


        return view('explore', compact('products', 'initialCategory'));
    }

    public function show($product_id)
    {
        $product = Produk::with('specification')->findOrFail($product_id);

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

        $wishlisted = false;
        if (session('user_id') && session('role') === 'buyer') {
            $wishlisted = Wishlist::where('buyer_id', session('user_id'))
                ->where('product_id', $product->product_id)
                ->exists();
        }

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
        $categorySlugs = [
            'nendoroid' => 'Nendoroid',
            'popup' => 'Pop Up Parade',
            'hottoys' => 'Hot Toys'
        ];

        $initialCategory = request()->query('category', 'nendoroid');
        $initialType = $categorySlugs[$initialCategory] ?? 'Nendoroid';

        $filterService = new FilterService();
        $query = Produk::with(['specification', 'seller'])->where('type', $initialType);
        $filterOptions = $filterService->getFilterOptions();
        $products = $filterService->apply($query, $request->all())->paginate(12);

           // TAMBAHAN: Hitung jumlah produk per kategori (REAL COUNT dari database)
        $categoryCounts = [
            'nendoroid' => Produk::where('type', 'Nendoroid')->where('stock', '>', 0)->count(),
            'popup' => Produk::where('type', 'Pop Up Parade')->where('stock', '>', 0)->count(),
            'hottoys' => Produk::where('type', 'Hot Toys')->where('stock', '>', 0)->count(),
        ];

        // Query dinamis untuk manufaktur
        $manufactureCounts = Produk::select('specification.manufacture', DB::raw('count(*) as total'))
            ->join('specification', 'products.product_id', '=', 'specification.product_id')
            ->where('products.stock', '>', 0)
            ->groupBy('specification.manufacture')
            ->pluck('total', 'specification.manufacture')
            ->toArray();

        return view('pages.general.explore', [
            'categories' => $categorySlugs,
            'initialCategory' => $initialCategory,
            'products' => $products,
            'filterOptions' => $filterOptions,
            'activeFilters' => $request->all(),
            'manufactureCounts' => $manufactureCounts,
            'categoryCounts' => $categoryCounts // TAMBAHKAN INI
        ]);
    }


    public function getProductsByCategory(Request $request)
    {
        $categoryMap = [
            'nendoroid' => 'Nendoroid',
            'popup'     => 'Pop Up Parade',
            'hottoys'   => 'Hot Toys'
        ];

        $categorySlug = $request->query('category', 'nendoroid');
        $type = $categoryMap[$categorySlug] ?? 'Nendoroid';

        $query = Produk::with(['specification', 'seller'])
            ->where('type', $type)
            ->inStock()
            ->orderBy('created_at', 'desc');

        $filters = array_merge($request->all(), ['type' => $type]);
        $filterService = new FilterService();
        $products = $filterService->apply($query, $filters)->paginate(12);

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

        return view('partials.explore.products', [
            'products' => $products,
            'category' => $categorySlug
        ]);
    }

    public function filter(Request $request)
    {
        $filterService = new FilterService();
        $query = Produk::with(['specification', 'seller']);
        $products = $filterService->apply($query, $request->all())->paginate(12);

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
        $filterService = new FilterService();
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
        $sort = $request->get('sort', 'latest');

        $query = Produk::with(['specification', 'seller'])
            ->where('type', $type)
            ->where('stock', '>', 0);

        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('rating_total', 'desc');
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

    // 🔥 BARU: hasil berdasarkan manufacture
    public function manufactureResults($manufactureSlug, Request $request)
    {
        $manufacture = urldecode($manufactureSlug);

        // TAMBAHAN: Data logo untuk setiap manufacture
        $manufactureLogos = [
            'Bandai' => 'images/brands/bandai.jpg',
            'Banpresto' => 'images/brands/banpresto.jpg',
            'Good Smile Company' => 'images/brands/goodsmile.png',
            'Kotobukiya' => 'images/brands/kotobukiya.jpg',
            'Max Factory' => 'images/brands/maxfactory.jpg',
            'Funko' => 'images/brands/funko.jpg',

        ];


        $query = Produk::with(['specification', 'seller'])
            ->whereHas('specification', function ($q) use ($manufacture) {
                $q->where('manufacture', $manufacture);
            })
            ->where('stock', '>', 0);

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('rating_total', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        $totalProducts = $query->count();

        // TAMBAHAN: Ambil logo untuk manufacture ini
        $manufactureLogo = $manufactureLogos[$manufacture] ?? 'images/brands/default.jpg';
        return view('pages.search.manufacture-result', [
            'products' => $products,
            'manufacture' => $manufacture,
            'manufactureLogo' => $manufactureLogo, // TAMBAHKAN INI
            'totalProducts' => $totalProducts,
            'sort' => $sort
        ]);
    }
}
