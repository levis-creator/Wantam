<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $baseSlug = Str::slug($brand->name);
            $brand->slug = $baseSlug . '-' . Str::substr($brand->id, 0, 8); // First 8 chars of UUID
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $baseSlug = Str::slug($brand->name);
                $brand->slug = $baseSlug . '-' . Str::substr($brand->id, 0, 8);
            }
        });
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
