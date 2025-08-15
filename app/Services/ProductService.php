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
     * @param int $perPage
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(int $perPage, ?string $search = null): LengthAwarePaginator
    {
        $query = Product::with(['category', 'reviews'])->active();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

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
