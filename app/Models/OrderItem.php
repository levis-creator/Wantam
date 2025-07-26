<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The primary key type.
     */
    protected $keyType = 'string';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id', // updated from inventory_id for better clarity
        'price',
        'quantity',
    ];

    /**
     * Attribute type casting.
     */
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
     * Relationship: Belongs to a Product Variant (size/color).
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Accessor: Get the total cost for this item (price * quantity).
     */
    public function getTotalCostAttribute(): float
    {
        return $this->price * $this->quantity;
    }
}
