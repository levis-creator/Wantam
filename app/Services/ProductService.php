<?php

namespace App\Services;

use App\Mappers\ProductMapper;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Builder;

/**
 * ProductService
 *
 * Handles product retrieval, filtering, and formatting for display.
 * Decoupled from HTTP layer for use in APIs, CLI commands, or background jobs.
 */
class ProductService
{
    /** @var Collection Cached product collection for non-paginated queries */
    protected Collection $products;

    /** @var array Validated filters applied to queries */
    protected array $filters = [];

    /** @var int Number of products retrieved in non-paginated calls */
    public int $productsCount = 0;

    public function __construct()
    {
        $this->products = collect();
    }

    /**
     * Filter products based on provided criteria and store results in memory.
     *
     * @param array $filters
     * @return self
     * @throws ValidationException
     */
    public function filterProducts(array $filters = []): self
    {
        $this->filters = $this->validateFilters($filters);
        $this->products = $this->buildQuery($this->filters)->get();
        $this->productsCount = $this->products->count();

        return $this;
    }

    /**
     * Retrieve all filtered products (non-paginated).
     *
     * @return array
     */
    public function getProducts(): array
    {
        return ProductMapper::mapCollection($this->products);
    }
    /**
     * Retrieve paginated products with optional search term.
     *
     * This method fetches products that are active (is_active = 1),
     * eager loads their category and reviews, and applies an optional
     * search filter on the product name. The results are returned as
     * a paginated collection.
     *
     * @param int $perPage  Number of items per page for pagination.
     * @param string|null $search Optional search keyword to filter products by name.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedProducts(int $perPage, ?string $search = null): LengthAwarePaginator
    {
        $query = Product::with(['category', 'reviews'])->active(); // ✅ Using 'active' scope

        // Apply search filter if keyword provided
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    /**
     * Retrieve active products with prioritization by category.
     *
     * This method fetches active products, eager loads category & reviews,
     * and prioritizes products belonging to a given category by ordering
     * them first, while still including all other active products.
     *
     * It also supports an optional search filter on the product name.
     *
     * Example:
     * - If $categorySlug = "electronics", all electronics will appear
     *   first in the paginated results, followed by all other categories.
     *
     * @param string $categorySlug  The slug of the category to prioritize.
     * @param int $perPage          Number of items per page (default 12).
     * @param string|null $search   Optional search keyword to filter products by name.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductsByCategory(string $categorySlug, int $perPage = 12, ?string $search = null): LengthAwarePaginator
    {
        $query = Product::with(['category', 'reviews'])
            ->where('products.is_active', 1); // ✅ Explicitly qualify column name

        // Apply search filter if keyword provided
        if (!empty($search)) {
            $query->where('products.name', 'like', "%{$search}%"); // ✅ Qualified with table name
        }

        // Join categories to check the slug for prioritization
        $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*') // ✅ Ensure only product fields are selected
            ->orderByRaw("CASE WHEN categories.slug = ? THEN 0 ELSE 1 END", [$categorySlug]) // ✅ Prioritize matching category
            ->orderBy('products.created_at', 'desc'); // ✅ Secondary sort (latest products first)

        return $query->paginate($perPage);
    }


    /**
     * Count total active products.
     *
     * @return int
     */
    public function productsCount(): int
    {
        return Product::active()->count();
    }

    /**
     * Get a single active product by slug.
     *
     * @param string $slug
     * @return array
     */
    public function getProductBySlug(string $slug): array
    {
        $product = Product::with(['category', 'reviews'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        return ProductMapper::mapSingle($product);
    }
    /**
     * Get related products by category.
     *
     * This method fetches products that belong to the same category
     * as the given product, excluding the current product itself.
     * It only retrieves active products, randomizes them,
     * and limits the results to the specified number.
     *
     * @param int $productId The ID of the current product.
     * @param int $limit The maximum number of related products to return (default: 6).
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedProducts($productId, int $limit = 6)
    {
        // Retrieve the current product or fail if not found
        $product = Product::findOrFail($productId);

        // Query products in the same category, excluding the current product
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Exclude the current product
            ->active() // Scope: only active products
            ->inRandomOrder() // Randomize the order
            ->take($limit) // Limit the number of results
            ->get(); // Fetch the results
    }


    /**
     * Build a query with optional filters.
     *
     * @param array $filters
     * @return Builder
     */
    protected function buildQuery(array $filters = []): Builder
    {
        $query = Product::with(['category', 'reviews'])->active();

        if (!empty($filters['category'])) {
            $query->whereHas('category', fn($q) => $q->whereIn('name', $filters['category']));
        }

        if (isset($filters['min_price']) || isset($filters['max_price'])) {
            $min = $filters['min_price'] ?? 0;
            $max = $filters['max_price'] ?? PHP_INT_MAX;
            $query->whereBetween('discounted_price', [$min, $max]);
        }

        if (!empty($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        if (!empty($filters['is_featured'])) {
            $query->where('is_featured', true);
        }

        return $query;
    }

    /**
     * Validate and sanitize filter input.
     *
     * @param array $filters
     * @return array
     * @throws ValidationException
     */
    protected function validateFilters(array $filters): array
    {
        $validator = Validator::make($filters, [
            'category'    => 'sometimes|array',
            'category.*'  => 'string',
            'min_price'   => 'sometimes|numeric|min:0',
            'max_price'   => 'sometimes|numeric|min:0',
            'min_rating'  => 'sometimes|numeric|min:0|max:5',
            'is_featured' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
