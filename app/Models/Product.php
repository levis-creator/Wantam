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

    /**
     * Indicates that the primary key is not auto-incrementing.
     */
    public $incrementing = false;

    /**
     * Indicates the type of the primary key.
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     */
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
        'rating',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'images' => 'array',
        'stock_quantity' => 'integer',
        'original_price' => 'float',
        'discount' => 'float',
        'price' => 'float',
        'rating' => 'float',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * The "booted" method of the model to handle events.
     */
    protected static function booted(): void
    {
        // When creating a new product
        static::creating(function (Product $product) {
            $product->generateId();            // Set UUID if not provided
            $product->generateSlug();          // Auto-generate unique slug
            $product->calculateDiscountedPrice(); // Calculate final price after discount
        });

        // When updating an existing product
        static::updating(function (Product $product) {
            if ($product->isDirty('name')) {
                $product->generateSlug(); // Regenerate slug if name changes
            }

            $product->calculateDiscountedPrice(); // Recalculate price
        });
    }

    /**
     * Generate UUID for the product if it's not already set.
     */
    protected function generateId(): void
    {
        if (empty($this->id)) {
            $this->id = (string) Str::uuid();
        }
    }

    /**
     * Generate a unique slug from the product name.
     */
    protected function generateSlug(): void
    {
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug . '-' . substr($this->id, 0, 4);
        $originalSlug = $slug;
        $i = 1;

        // Ensure uniqueness of the slug
        while (
            static::where('slug', $slug)
            ->where('id', '!=', $this->id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $i++;
        }

        $this->slug = $slug;
    }

    /**
     * Calculate final price after applying discount.
     */
    protected function calculateDiscountedPrice(): void
    {
        if ($this->original_price && $this->discount) {
            $discountAmount = $this->original_price * ($this->discount / 100);
            $this->price = round($this->original_price - $discountAmount, 2);
        } elseif ($this->original_price && empty($this->price)) {
            $this->price = $this->original_price;
        }
    }

    /**
     * Accessor: Check if the product is in stock.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    // ====================
    // Relationships
    // ====================

    /**
     * Get the category this product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand this product belongs to.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all reviews associated with this product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all advertisements where this product is featured.
     */
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    // ====================
    // Query Scopes
    // ====================

    /**
     * Scope: Filter only active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter featured and active products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}
