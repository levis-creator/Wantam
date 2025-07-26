<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'product_id',
        'inventory_id', // Optional: links to inventory variant like size
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    /**
     * Relationship: Belongs to an Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: Belongs to a Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    /**
     * Accessor: Total cost for this item (price * quantity).
     */
    public function getTotalCostAttribute(): float
    {
        return $this->price * $this->quantity;
    }
}
