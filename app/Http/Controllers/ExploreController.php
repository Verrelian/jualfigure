<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        // Get all products for initial count
        $products = Product::where('status', 'active')->get();
        $initialCategory = $request->get('category', 'all');

        return view('explore', compact('products', 'initialCategory'));
    }

    public function showCategory(Request $request, $category)
    {
        // Validate category
        $validCategories = ['nendoroid', 'popup', 'hottoys', 'scale-figure', 'figma', 'prize-figure'];

        if (!in_array($category, $validCategories)) {
            abort(404, 'Category not found');
        }

        // Get products by category with pagination
        $query = Product::where('status', 'active')
                       ->where('category', $category);

        // Apply additional filters if provided
        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Get category info
        $categoryInfo = $this->getCategoryInfo($category);

        // Get price range for filters
        $priceRange = Product::where('category', $category)
                            ->where('status', 'active')
                            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
                            ->first();

        return view('explore.category', compact('products', 'category', 'categoryInfo', 'priceRange'));
    }

    public function showPriceRange(Request $request, $range)
    {
        // Parse price range (format: "30-80" or "80-999")
        $rangeParts = explode('-', $range);

        if (count($rangeParts) !== 2) {
            abort(404, 'Invalid price range format');
        }

        $minPrice = (float) $rangeParts[0];
        $maxPrice = (float) $rangeParts[1];

        // Get products by price range
        $query = Product::where('status', 'active')
                       ->whereBetween('price', [$minPrice, $maxPrice]);

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->orderBy('price', 'asc');
            }
        } else {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(12);

        $priceRangeInfo = [
            'min' => $minPrice,
            'max' => $maxPrice,
            'title' => $this->getPriceRangeTitle($minPrice, $maxPrice)
        ];

        return view('explore.price-range', compact('products', 'priceRangeInfo'));
    }

    private function getCategoryInfo($category)
    {
        $categoryData = [
            'nendoroid' => [
                'name' => 'Nendoroid',
                'description' => 'Cute chibi-style collectible figures with interchangeable parts',
                'image' => 'images/p6.jpg',
                'characteristics' => ['Chibi style', 'Interchangeable parts', 'Compact size', 'High quality']
            ],
            'popup' => [
                'name' => 'Pop Up Parade',
                'description' => 'Affordable premium figures with excellent quality and detail',
                'image' => 'images/p3.png',
                'characteristics' => ['Premium quality', 'Affordable price', 'Great detail', 'Popular series']
            ],
            'hottoys' => [
                'name' => 'Hot Toys',
                'description' => 'Ultra-detailed premium collectibles with movie-accurate details',
                'image' => 'images/figure4.jpg',
                'characteristics' => ['Movie accurate', 'Premium materials', 'Highly detailed', 'Limited edition']
            ],
            'scale-figure' => [
                'name' => 'Scale Figure',
                'description' => 'Highly detailed figures in various scales',
                'image' => 'images/scale-figure.jpg',
                'characteristics' => ['Various scales', 'High detail', 'Premium quality', 'Collectible']
            ],
            'figma' => [
                'name' => 'Figma',
                'description' => 'Poseable action figures with multiple accessories',
                'image' => 'images/figma.jpg',
                'characteristics' => ['Fully poseable', 'Multiple accessories', 'Durable joints', 'Action ready']
            ],
            'prize-figure' => [
                'name' => 'Prize Figure',
                'description' => 'Quality figures at budget-friendly prices',
                'image' => 'images/prize-figure.jpg',
                'characteristics' => ['Budget friendly', 'Good quality', 'Popular characters', 'Great value']
            ]
        ];

        return $categoryData[$category] ?? null;
    }

    private function getPriceRangeTitle($min, $max)
    {
        if ($min == 0 && $max <= 30) {
            return 'Budget Friendly - Under $30';
        } elseif ($min >= 30 && $max <= 80) {
            return 'Premium Quality - $30 - $80';
        } elseif ($min >= 80) {
            return 'Luxury Collection - $80+';
        } else {
            return "Price Range $" . number_format($min) . " - $" . number_format($max);
        }
    }
}