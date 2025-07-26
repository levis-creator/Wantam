<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Inventory extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'product_id',
        'size',
        'stock',
    ];

    protected $casts = [
        'stock' => 'integer',
    ];

    /**
     * The product this inventory belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if a specific size is in stock.
     */
    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
