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
 * Represents a customer order in the system.
 * Each order belongs to one user and contains multiple order items.
 */
class Order extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates the attributes that are mass assignable.
     * These can be safely assigned via create() or fill().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',           // ID of the user who placed the order
        'status',            // Enum value: pending, processing, completed, etc.
        'payment_method',    // Enum: paypal, mpesa, credit_card, etc.
        'shipping_address',  // Address to ship to
    ];

    /**
     * Casts allow us to transform attributes into appropriate data types or enums.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total' => 'float',
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    // ================================
    // Relationships
    // ================================

    /**
     * Relationship: An order belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: An order has many items.
     * Each item includes product/variant and quantity.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship: An order has one payment record (optional).
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // ================================
    // Accessors
    // ================================

    /**
     * Accessor: Calculate the total cost of the order dynamically.
     * This sums the total_cost from all related order items.
     *
     * Usage: $order->total
     */
    public function getTotalAttribute(): float
    {
        return $this->items->sum('total_cost'); // each order item must have a total_cost accessor
    }

    // ================================
    // Scopes
    // ================================

    /**
     * Scope: Filter only completed orders.
     *
     * Usage: Order::completed()->get();
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', OrderStatus::Completed);
    }
}
