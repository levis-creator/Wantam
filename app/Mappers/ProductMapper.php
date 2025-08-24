<?php

namespace App\Mappers;

use Illuminate\Support\Collection;
use App\Models\Product;

/**
 * Class ProductMapper
 *
 * Responsible for transforming Product model instances into
 * structured arrays optimized for **API responses**, **frontend rendering**,
 * and **SEO-friendly presentation**.
 *
 * 🔑 SOLID Principles:
 * - **Single Responsibility** → Only handles data mapping logic, not querying or rendering.
 * - **Open/Closed** → Can be extended (e.g., add more SEO fields) without altering core mapping.
 * - **Dependency Inversion** → Works with Eloquent models but outputs plain arrays,
 *   making it reusable for APIs, Blade, or Livewire.
 */
class ProductMapper
{
    /**
     * Map a single Product model into a structured, SEO-friendly array.
     *
     * @param Product $product The Product instance to map.
     * @return array Structured product data ready for API/frontend consumption.
     */
    public static function mapSingle(Product $product): array
    {
        /**
         * Process product images:
         * - Converts relative paths into full asset URLs.
         * - Associates images with variant color names (if available).
         * - Ensures the **first image is marked active** → useful for carousels.
         * - Adds descriptive `name` values → improves **SEO image alt attributes**.
         */
        $images = is_array($product->images)
            ? collect($product->images)->map(function ($image, int $index) use ($product) {
                $colors = $product->variant_colors ?? [];

                return [
                    'url'    => filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image),
                    'name'   => $colors[$index] ?? 'Default',
                    'active' => $index === 0, // First image is the primary display image
                ];
            })->toArray()
            : [];

        return [
            // Core identifiers
            'id'         => $product->id,
            'name'       => $product->name,
            'slug'       => $product->slug,
            'description' => $product->description,
            /**
             * Main Image:
             * - Ensures SEO fallback → if no image exists, a placeholder is used.
             * - Useful for social media previews (OpenGraph/Twitter Cards).
             */
            'main_image' => $product->main_image_url ?? asset('products/main/placeholder.jpg'),

            // Multiple images with color associations
            'images'     => $product->images_urls ?? [],

            /**
             * Category info → structured for breadcrumbs and SEO hierarchy
             * (e.g., "Home > Category > Product").
             */
            'category'   => [
                'id'   => $product->category?->id,
                'name' => $product->category?->name ?? 'Uncategorized',
                'slug' => $product->category?->slug ?? 'uncategorized',
            ],

            // Pricing (SEO: structured data for Google Shopping)
            'price'                    => $product->discounted_price,
            'formatted_price'          => $product->formatted_price,
            'formatted_original_price' => $product->formatted_original_price,

            // Product reputation signals
            'rating'   => $product->rating ?? 0, // Helps Google rich snippets
            'reviews'  => $product->reviews->count(),

            // Discount and availability signals
            'discount'    => $product->discount,
            'is_active'   => (bool) $product->is_active,
            'is_featured' => (bool) $product->is_featured,

            // Variants (colors, sizes, etc.)
            'variant_colors' => $product->variant_colors ?? [],


            /**
             * SEO URL:
             * - Category + Product slug for keyword-rich URLs.
             * - Example: /shop/electronics/samsung-galaxy-s21
             * - This structure boosts **Google indexing & CTR**.
             */
            'seo_url' => route('shop.index', [
                'category' => $product->category?->slug ?? 'uncategorized',
                'product'  => $product->slug
            ]),

            // SEO meta data
            'meta_title'       => $product->meta_title ?? $product->name,
            'meta_description' => $product->meta_description ?? $product->description,
        ];
    }

    /**
     * Map a collection of Product models into an array of structured, SEO-friendly data.
     *
     * @param Collection<int, Product> $products A collection of Product models.
     * @return array List of structured product data, ready for grids, lists, or carousels.
     */
    public static function mapCollection(Collection $products): array
    {
        return $products
            ->map(fn(Product $product) => self::mapSingle($product))
            ->toArray();
    }
}
