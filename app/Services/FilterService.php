<?php

namespace App\Services;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Builder;

class FilterService
{
    protected array $sortOptions = [
        'newest' => ['created_at', 'desc'],
        'oldest' => ['created_at', 'asc'],
        'price_low' => ['price', 'asc'],
        'price_high' => ['price', 'desc'],
        'popular' => ['sold', 'desc'],
        'rating' => ['rating_total', 'desc']
    ];

    public function apply(Builder $query, array $filters): Builder
    {
        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Type filter - handle array
        if (!empty($filters['type'])) {
            if (is_array($filters['type'])) {
                $query->whereIn('type', $filters['type']);
            } else {
                $query->where('type', $filters['type']);
            }
        }

        // Price range filter
        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }
        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        // Specification filters - handle arrays
        if (!empty($filters['scale']) || !empty($filters['material']) ||
            !empty($filters['manufacture']) || !empty($filters['series'])) {

            $query->whereHas('specification', function($q) use ($filters) {
                if (!empty($filters['scale'])) {
                    if (is_array($filters['scale'])) {
                        $q->whereIn('scale', $filters['scale']);
                    } else {
                        $q->where('scale', $filters['scale']);
                    }
                }
                if (!empty($filters['material'])) {
                    if (is_array($filters['material'])) {
                        $q->whereIn('material', $filters['material']);
                    } else {
                        $q->where('material', $filters['material']);
                    }
                }
                if (!empty($filters['manufacture'])) {
                    if (is_array($filters['manufacture'])) {
                        $q->whereIn('manufacture', $filters['manufacture']);
                    } else {
                        $q->where('manufacture', $filters['manufacture']);
                    }
                }
                if (!empty($filters['series'])) {
                    if (is_array($filters['series'])) {
                        $q->whereIn('series', $filters['series']);
                    } else {
                        $q->where('series', $filters['series']);
                    }
                }
            });
        }

        // Sort
        $sort = $filters['sort'] ?? 'newest';
        if (isset($this->sortOptions[$sort])) {
            [$column, $direction] = $this->sortOptions[$sort];
            $query->orderBy($column, $direction);
        }

        return $query;
    }

    public function getFilterOptions(): array
    {
        return [
            'types' => Produk::select('type')->distinct()->orderBy('type')->pluck('type'),
            'scales' => Produk::join('specification', 'products.product_id', '=', 'specification.product_id')
                             ->select('scale')
                             ->whereNotNull('scale')
                             ->distinct()
                             ->orderBy('scale')
                             ->pluck('scale'),
            'materials' => Produk::join('specification', 'products.product_id', '=', 'specification.product_id')
                                ->select('material')
                                ->whereNotNull('material')
                                ->distinct()
                                ->orderBy('material')
                                ->pluck('material'),
            'manufactures' => Produk::join('specification', 'products.product_id', '=', 'specification.product_id')
                                   ->select('manufacture')
                                   ->whereNotNull('manufacture')
                                   ->distinct()
                                   ->orderBy('manufacture')
                                   ->pluck('manufacture'),
            'series' => Produk::join('specification', 'products.product_id', '=', 'specification.product_id')
                             ->select('series')
                             ->whereNotNull('series')
                             ->distinct()
                             ->orderBy('series')
                             ->pluck('series'),
            'price_range' => [
                'min' => Produk::min('price'),
                'max' => Produk::max('price')
            ]
        ];
    }
}