<?php

namespace App\Mappers;

use Illuminate\Support\Collection;
use App\Models\Product;

/**
 * Class ProductMapper
 *
 * Responsible for transforming Product model instances into
 * structured arrays for API or frontend consumption.
 *
 * Following SOLID principles:
 * - **Single Responsibility**: Only handles data mapping logic.
 * - **Open/Closed**: Easy to extend mapping without modifying core logic.
 * - **Dependency Inversion**: Works with Eloquent models but not tightly coupled.
 */
class ProductMapper
{
    /**
     * Map a single Product model to an array structure.
     *
     * @param Product $product The product instance to map.
     * @return array Structured product data for API/frontend.
     */
    public static function mapSingle(Product $product): array
    {
        // Process product images (ensuring URLs and assigning variant color names)
        $images = is_array($product->images)
            ? collect($product->images)->map(function ($image, int $index) use ($product) {
                $colors = $product->variant_colors ?? [];

                return [
                    'url'    => filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image),
                    'name'   => $colors[$index] ?? 'Default',
                    'active' => $index === 0, // First image is active by default
                ];
            })->toArray()
            : [];

        return [
            'id'                       => $product->id,
            'name'                     => $product->name,
            'slug'                     => $product->slug,
            'main_image'               => $product->main_image_url ?? asset('products/main/placeholder.jpg'),
            'images'                   => $images,
            'category'                 => [
                'name' => $product->category?->name ?? 'Uncategorized',
                'slug' => $product->category?->slug ?? 'uncategorized',
            ],
            'price'                    => $product->discounted_price,
            'formatted_price'          => $product->formatted_price,
            'formatted_original_price' => $product->formatted_original_price,
            'rating'                   => $product->rating ?? 0,
            'reviews'                  => $product->reviews->count(),
            'discount'                 => $product->discount,
            'is_active'                => (bool) $product->is_active,
            'is_featured'              => (bool) $product->is_featured,
            'variant_colors'           => $product->variant_colors ?? [],
            'seo_url'                  => route('shop.index', [
                'category' => $product->category?->slug ?? 'uncategorized',
                'product'  => $product->slug
            ]),
        ];
    }

    /**
     * Map a collection of Product models into an array of structured data.
     *
     * @param Collection<int, Product> $products A collection of Product models.
     * @return array An array of structured product data.
     */
    public static function mapCollection(Collection $products): array
    {
        return $products
            ->map(fn(Product $product) => self::mapSingle($product))
            ->toArray();
    }
}
