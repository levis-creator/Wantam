<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * Class Order
 *
 * Represents a customer's order. An order:
 * - Belongs to a user
 * - Has many order items (each containing product, quantity, etc.)
 * - Can have one payment record
 * - Has a dynamically calculated total (not stored in DB)
 */
class Order extends Model
{
    use HasFactory, HasUuids;

    // ================================
    // Mass assignable fields
    // ================================
    /**
     * The attributes that are mass assignable (safe for fill/create).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',           // FK: customer who placed the order
        'status',            // Enum (pending, completed, etc.)
        'payment_method',    // Enum (paypal, mpesa, etc.)
        'shipping_address',  // Shipping location
    ];

    // ================================
    // Casts
    // ================================
    /**
     * Cast attributes to their appropriate data types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    // ================================
    // Appended Accessors
    // ================================
    /**
     * Dynamically add the "total" attribute to JSON responses.
     *
     * @var array<int, string>
     */
    protected $appends = ['total'];

    // ================================
    // Relationships
    // ================================

    /**
     * Get the user who placed the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items associated with this order.
     * Each item contains product/variant info, quantity, and pricing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment details associated with the order (if any).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // ================================
    // Accessors
    // ================================

    /**
     * Dynamically compute the total cost of the order.
     * Sums the total_cost of each order item.
     *
     * Usage: $order->total
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        // Assumes each OrderItem has a getTotalCostAttribute()
        return $this->items->sum('total_cost');
    }

    // ================================
    // Scopes
    // ================================

    /**
     * Scope to retrieve only completed orders.
     *
     * Usage: Order::completed()->get();
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', OrderStatus::Completed);
    }
}
