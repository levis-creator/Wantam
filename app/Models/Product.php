<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

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
        'is_active',
        'is_featured',
        'rating',
    ];

    protected $casts = [
        'images' => 'array',
        'original_price' => 'float',
        'discount' => 'float',
        'price' => 'float',
        'rating' => 'float',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'main_image_url',
        'images_urls',
        'in_stock',
        'total_stock',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->generateId();
            $product->generateSlug();
            $product->calculateDiscountedPrice();
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name')) {
                $product->generateSlug();
            }
            $product->calculateDiscountedPrice();
        });
    }

    protected function generateId(): void
    {
        if (empty($this->id)) {
            $this->id = (string) Str::uuid();
        }
    }

    protected function generateSlug(): void
    {
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug . '-' . substr($this->id, 0, 4);
        $originalSlug = $slug;
        $i = 1;

        while (
            static::where('slug', $slug)
            ->where('id', '!=', $this->id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $i++;
        }

        $this->slug = $slug;
    }

    protected function calculateDiscountedPrice(): void
    {
        if ($this->original_price && $this->discount) {
            $discountAmount = $this->original_price * ($this->discount / 100);
            $this->price = round($this->original_price - $discountAmount, 2);
        } elseif ($this->original_price && empty($this->price)) {
            $this->price = $this->original_price;
        }
    }

    // ========================
    // Accessors (Laravel 12 style using asset())
    // ========================

    public function getMainImageUrlAttribute(): ?string
    {
        return $this->main_image
            ? asset('storage/' . ltrim($this->main_image, '/'))
            : null;
    }

    public function getImagesUrlsAttribute(): array
    {
        return is_array($this->images)
            ? collect($this->images)
            ->filter()
            ->map(fn($image) => asset('storage/' . ltrim($image, '/')))
            ->toArray()
            : [];
    }

    public function getInStockAttribute(): bool
    {
        return $this->variants()->where('stock', '>', 0)->exists();
    }

    public function getTotalStockAttribute(): int
    {
        return $this->variants()->sum('stock');
    }

    // ====================
    // Relationships
    // ====================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // ====================
    // Scopes
    // ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}
