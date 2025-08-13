<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductService
{
    protected Collection $products;
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->products = $this->fetchProducts();
    }

    protected function fetchProducts(): Collection
    {
        $query = Product::with(['category', 'reviews'])->active();

        if ($this->request->has('category')) {
            $categories = (array) $this->request->input('category');
            $query->whereHas('category', function ($q) use ($categories) {
                $q->whereIn('name', $categories);
            });
        }

        if ($this->request->has('min_price') || $this->request->has('max_price')) {
            $minPrice = max(0, $this->request->input('min_price', 0));
            $maxPrice = $this->request->input('max_price', PHP_INT_MAX);
            $query->whereBetween('discounted_price', [$minPrice, $maxPrice]);
        }

        if ($this->request->has('min_rating')) {
            $query->where('rating', '>=', $this->request->input('min_rating', 0));
        }

        if ($this->request->boolean('is_featured')) {
            $query->where('is_featured', true);
        }

        return $query->get();
    }

    public function filterProducts(array $filters = []): self
    {
        $validator = Validator::make($filters, [
            'category' => 'sometimes|array',
            'category.*' => 'string',
            'min_price' => 'sometimes|numeric|min:0',
            'max_price' => 'sometimes|numeric|min:0',
            'min_rating' => 'sometimes|numeric|min:0|max:5',
            'is_featured' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->products = $this->fetchProducts();
        return $this;
    }

    public function getProducts(): array
    {
        return $this->mapProducts($this->products);
    }
    public function getPaginatedProducts(int $perPage = 12): LengthAwarePaginator
    {
        $paginator = Product::with(['category', 'reviews'])
            ->active()
            ->paginate($perPage);

        return $this->transformPaginatedProducts($paginator);
    }

    /**
     * Transform paginated products into the mapped array format.
     */
    protected function transformPaginatedProducts(LengthAwarePaginator $paginator): LengthAwarePaginator
    {
        $paginator->getCollection()->transform(function ($product) {
            $images = is_array($product->images) ? collect($product->images)->map(function ($image, $index) use ($product) {
                $colors = $product->variant_colors ?? [];
                return [
                    'url' => filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image),
                    'name' => $colors[$index] ?? 'Default',
                    'active' => $index === 0,
                ];
            })->toArray() : [];

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'main_image' => $product->main_image_url ?? asset('products/main/placeholder.jpg'),
                'images' => $images,
                'category' => [
                    'name' => $product->category?->name ?? 'Uncategorized',
                    'slug' => $product->category?->slug ?? 'uncategorized',
                ],
                'price' => $product->discounted_price,
                'formatted_price' => $product->formatted_price,
                'formatted_original_price' => $product->formatted_original_price,
                'rating' => $product->rating ?? 0,
                'reviews' => $product->reviews->count(),
                'discount' => $product->discount,
                'is_active' => $product->is_active,
                'is_featured' => $product->is_featured,
                'variant_colors' => $product->variant_colors ?? [],
                'seo_url' => route('shop.index', [
                    'category' => $product->category?->slug ?? 'uncategorized',
                    'product' => $product->slug
                ]),
            ];
        });

        return $paginator;
    }


    protected function mapProducts(Collection $products): array
    {
        return $products->map(function ($product) {
            $images = is_array($product->images) ? collect($product->images)->map(function ($image, $index) use ($product) {
                $colors = $product->variant_colors ?? [];
                return [
                    'url' => filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image),
                    'name' => $colors[$index] ?? 'Default',
                    'active' => $index === 0,
                ];
            })->toArray() : [];

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'main_image' => $product->main_image_url ?? asset('products/main/placeholder.jpg'),
                'images' => $images,
                'category' => [
                    'name' => $product->category?->name ?? 'Uncategorized',
                    'slug' => $product->category?->slug ?? 'uncategorized',
                ],
                'price' => $product->discounted_price,
                'formatted_price' => $product->formatted_price,
                'formatted_original_price' => $product->formatted_original_price,
                'rating' => $product->rating ?? 0,
                'reviews' => $product->reviews->count(),
                'discount' => $product->discount,
                'is_active' => $product->is_active,
                'is_featured' => $product->is_featured,
                'variant_colors' => $product->variant_colors ?? [],
                'seo_url' => route('shop.index', ['category' => $product->category?->slug ?? 'uncategorized', 'product' => $product->slug]),
            ];
        })->toArray();
    }
}
