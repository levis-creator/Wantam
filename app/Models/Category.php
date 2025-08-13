<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The type of the model's primary key.
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'is_active',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent category (if any).
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get all children categories.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the full URL of the category image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Get the count of products in this category.
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured categories.
     */
    public function scopeIsFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include inactive categories.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope to get only top-level categories (no parent).
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get all products under this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    /**
     * Scope a query to only include categories that have images.
     */
    public function scopeHasImage($query)
    {
        return $query->whereNotNull('image')->where('image', '!=', '');
    }

    /**
     * Use the slug instead of the ID in route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Boot method to generate slug and UUID on create/update.
     */
    protected static function booted(): void
    {
        static::creating(function (self $category) {
            if (empty($category->id)) {
                $category->id = (string) Str::uuid();
            }

            if (empty($category->slug)) {
                $category->slug = self::generateSlug($category->name, $category->parent_id);
            }
        });

        static::updating(function (self $category) {
            if ($category->isDirty('name') || $category->isDirty('parent_id')) {
                $category->slug = self::generateSlug($category->name, $category->parent_id, $category->id);
            }
        });
    }

    /**
     * Generate a unique slug based on name and parent category.
     */
    protected static function generateSlug(string $name, ?string $parentId, ?string $currentId = null): string
    {
        $baseSlug = Str::slug($name);

        if ($parentId) {
            $parent = self::find($parentId);
            if ($parent) {
                $baseSlug = $parent->slug . '-' . $baseSlug;
            }
        }

        $slug = $baseSlug;
        $i = 1;

        while (self::where('slug', $slug)
            ->when($currentId, fn($query) => $query->where('id', '!=', $currentId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $i++;
        }

        return $slug;
    }
}
