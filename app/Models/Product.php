<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes, HasUuids, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'brand_id',
        'name',
        'slug',
        'main_image',
        'images',
        'description',
        'original_price',
        'discount',
        'price',
        'stock_quantity',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'images' => 'array',
        'stock_quantity' => 'integer',
        'original_price' => 'float',
        'price' => 'float',
        'discount' => 'float',
    ];

    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->id)) {
                $product->id = (string) Str::uuid();
            }

            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug . '-' . substr($product->id, 0, 4);
                $originalSlug = $slug;
                $i = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $i++;
                }

                $product->slug = $slug;
            }

            self::calculateDiscountedPrice($product);
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug . '-' . substr($product->id, 0, 4);
                $originalSlug = $slug;
                $i = 1;

                while (
                    static::where('slug', $slug)
                    ->where('id', '!=', $product->id)
                    ->exists()
                ) {
                    $slug = $originalSlug . '-' . $i++;
                }

                $product->slug = $slug;
            }

            self::calculateDiscountedPrice($product);
        });
    }

    protected static function calculateDiscountedPrice($product)
    {
        if ($product->original_price && $product->discount) {
            $discountAmount = $product->original_price * ($product->discount / 100);
            $product->price = round($product->original_price - $discountAmount, 2);
        } elseif ($product->original_price && empty($product->price)) {
            $product->price = $product->original_price;
        }
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}
