<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model with slug and UUID generation.
     */
    protected static function booted(): void
    {
        // Generate UUID and slug during creation
        static::creating(function ($brand) {
            if (empty($brand->id)) {
                $brand->id = (string) Str::uuid();
            }

            if (empty($brand->slug)) {
                $baseSlug = Str::slug($brand->name);
                $slug = $baseSlug . '-' . substr($brand->id, 0, 8);
                $originalSlug = $slug;
                $i = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $i++;
                }

                $brand->slug = $slug;
            }
        });

        // Regenerate slug if name is updated
        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $baseSlug = Str::slug($brand->name);
                $slug = $baseSlug . '-' . substr($brand->id, 0, 8);
                $originalSlug = $slug;
                $i = 1;

                while (
                    static::where('slug', $slug)
                    ->where('id', '!=', $brand->id)
                    ->exists()
                ) {
                    $slug = $originalSlug . '-' . $i++;
                }

                $brand->slug = $slug;
            }
        });
    }

    /**
     * Accessor for full logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    /**
     * Scope to filter active brands.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get all products associated with this brand.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
