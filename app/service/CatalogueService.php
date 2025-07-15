<?php

namespace App\Service;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CatalogueService
{
    public Collection $categories;
    public Collection $products;

    public function __construct()
    {
        $this->categories = collect();
        $this->products = collect();
    }
    public function filterProductsPaginated(array $filters)
    {
        return Product::query()
            ->when(
                !empty($filters['category_id']),
                fn($q) =>
                $q->whereIn('category_id', $filters['category_id'])
            )
            ->when(
                $filters['min_price'],
                fn($q) =>
                $q->where('price', '>=', $filters['min_price'])
            )
            ->when(
                $filters['max_price'],
                fn($q) =>
                $q->where('price', '<=', $filters['max_price'])
            )
            ->when(
                !empty($filters['availability']),
                fn($q) =>
                $q->where(function ($query) use ($filters) {
                    foreach ($filters['availability'] as $status) {
                        if ($status === 'in_stock') {
                            $query->orWhere('stock', '>', 0);
                        } elseif ($status === 'out_of_stock') {
                            $query->orWhere('stock', '<=', 0);
                        }
                    }
                })
            )
            ->when(
                !empty($filters['ratings']),
                fn($q) =>
                $q->where(function ($query) use ($filters) {
                    foreach ($filters['ratings'] as $rating) {
                        $query->orWhere('rating', '>=', (int)$rating);
                    }
                })
            )
            ->latest()
            ->paginate(12);
    }



    /**
     * Fetch either a specific category (with children) or top-level parent categories.
     */
    public function fetchCategories(?string $slug = null): Collection
    {
        if ($slug) {
            $category = Category::with([
                'children' => fn($q) => $q->active()->withCount('products')
            ])
                ->active()
                ->where('slug', $slug)
                ->withCount('products')
                ->first();

            return $this->categories = collect([$category])->filter();
        }

        return $this->categories = Category::with([
            'children' => fn($q) => $q->active()->withCount('products')
        ])
            ->parents()
            ->active()
            ->withCount('products')
            ->orderBy('name')
            ->limit(7)
            ->get();
    }

    /**
     * Fetch all active products (can apply more filters).
     */
    public function fetchProducts(): Collection
    {
        return $this->products = Product::active()
            ->get();
    }

    /**
     * Fetch active products for a specific category and its children.
     */
    public function fetchProductsByCategory(string $categorySlug): Collection
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        // Include child categories if they exist
        $categoryIds = [$category->id];

        if ($category->children()->exists()) {
            $categoryIds = array_merge(
                $categoryIds,
                $category->children()->pluck('id')->toArray()
            );
        }

        return $this->products = Product::with(['category', 'brand'])
            ->whereIn('category_id', $categoryIds)
            ->active()
            ->get();
    }

    /**
     * Fetch featured and active products.
     */
    public function fetchFeaturedProducts(int $limit = 8): Collection
    {
        return $this->products = Product::featured()
            ->with(['category', 'brand'])
            ->limit($limit)
            ->get();
    }

    /**
     * Filter products with dynamic filters.
     */
    public function filterProducts(array $filters): Collection
    {
        $query = Product::with(['category', 'brand'])->active();

        if (!empty($filters['category_id'])) {
            $query->whereIn('category_id', (array) $filters['category_id']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['availability'])) {
            if (in_array('in_stock', $filters['availability'])) {
                $query->where('stock_quantity', '>', 0);
            }

            if (in_array('out_of_stock', $filters['availability'])) {
                $query->orWhere('stock_quantity', '<=', 0);
            }
        }

        // Rating filter (future proofing)
        if (!empty($filters['ratings'])) {
            $query->whereIn('rating', $filters['ratings']); // Assumes you add 'rating' field
        }

        return $this->products = $query->get();
    }
}
