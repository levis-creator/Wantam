<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
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
    ];

    protected $casts = [
        'images' => 'array',
        'original_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'main_image_url',
        'images_urls',
        'in_stock',
        'total_stock',
        'rating',
        'discounted_price',
        'formatted_price',
        'formatted_original_price',
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
            if ($product->isDirty(['original_price', 'discount'])) {
                $product->calculateDiscountedPrice();
            }
        });
    }

    protected function generateId(): void
    {
        $this->id = $this->id ?? (string) Str::orderedUuid();
    }

    protected function generateSlug(): void
    {
        $this->slug = Str::slug($this->name) . '-' . substr((string) Str::uuid(), 0, 8);
    }
    protected function calculateDiscountedPrice(): void
    {
        if ($this->original_price && $this->discount > 0) {
            $discountAmount = $this->original_price * ($this->discount / 100);
            $this->price = round($this->original_price - $discountAmount, 2);
        } else {
            $this->price = $this->original_price;
        }
    }

    // ========================
    // Accessors
    // ========================

    public function getMainImageUrlAttribute(): ?string
    {
        if (empty($this->main_image)) {
            return null;
        }

        return filter_var($this->main_image, FILTER_VALIDATE_URL)
            ? $this->main_image
            : Storage::url($this->main_image);
    }

    public function getImagesUrlsAttribute(): array
    {
        if (empty($this->images) || !is_array($this->images)) {
            return [];
        }

        return collect($this->images)
            ->filter()
            ->map(function ($image) {
                return filter_var($image, FILTER_VALIDATE_URL)
                    ? $image
                    : Storage::url($image);
            })
            ->toArray();
    }

    public function getInStockAttribute(): bool
    {
        if (!$this->relationLoaded('variants')) {
            return $this->variants()->where('stock', '>', 0)->exists();
        }

        return $this->variants->contains('stock', '>', 0);
    }

    public function getTotalStockAttribute(): int
    {
        if (!$this->relationLoaded('variants')) {
            return $this->variants()->sum('stock');
        }

        return $this->variants->sum('stock');
    }

    public function getRatingAttribute(): ?float
    {
        if (!$this->relationLoaded('reviews')) {
            return $this->reviews()->avg('rating') ?: null;
        }

        return round($this->reviews->avg('rating'), 1);
    }

    public function getDiscountedPriceAttribute(): float
    {
        return $this->price;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2);
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? number_format($this->original_price, 2) : null;
    }

    // ====================
    // Relationships
    // ====================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategorized',
        ]);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class)->withDefault();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('price');
    }

    // ====================
    // Scopes
    // ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeMinRating($query, $rating)
    {
        return $query->whereHas('reviews', function ($q) use ($rating) {
            $q->selectRaw('avg(rating) as avg_rating')
                ->havingRaw('avg_rating >= ?', [$rating]);
        });
    }

    public function scopeIsFeatured($query)
    {
        return $query->where('is_featured', true)->active();
    }

    public function scopeWithDiscount($query)
    {
        return $query->where('discount', '>', 0);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }
}
