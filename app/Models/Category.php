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
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     */
    protected $keyType = 'string';

    /**
     * Mass assignable attributes.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'is_active',
    ];

    /**
     * Attribute type casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Eager-load children automatically if needed.
     *
     * (Uncomment if you commonly access children)
     */
    // protected $with = ['children'];

    /**
     * Self-referencing parent relationship.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Self-referencing children relationship.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Accessor for full image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Scope for active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive categories.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Boot method to auto-generate slugs on create/update.
     */
    protected static function booted(): void
    {
        static::creating(function (self $category) {
            $category->slug = self::generateSlug($category->name, $category->parent_id);
        });

        static::updating(function (self $category) {
            if ($category->isDirty('name') || $category->isDirty('parent_id')) {
                $category->slug = self::generateSlug($category->name, $category->parent_id);
            }
        });
    }

    /**
     * Generate slug including parent prefix if applicable.
     */
    protected static function generateSlug(string $name, ?string $parentId): string
    {
        $baseSlug = Str::slug($name);

        if ($parentId) {
            $parent = self::find($parentId);
            if ($parent) {
                return $parent->slug . '-' . $baseSlug;
            }
        }

        return $baseSlug;
    }
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
