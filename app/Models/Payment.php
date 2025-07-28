<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

/**
 * Class Payment
 *
 * Represents a payment made by a customer for an order.
 * Each payment:
 * - Belongs to one order
 * - Has a payment method and status (enum-based)
 * - Has an amount and timestamp when the payment was completed
 *
 * This model is used to track completed payments for revenue reporting.
 */
class Payment extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates that the model's primary key is not auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     * These are fields that can be safely filled using create() or fill().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',          // Foreign key to the related order
        'payment_method',    // Enum: mpesa, paypal, etc.
        'transaction_id',    // External transaction ID (e.g. from payment gateway)
        'amount',            // Total amount paid
        'status',            // Enum: completed, failed, etc.
        'paid_at',           // Timestamp when payment was completed
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'float',
        'payment_method' => PaymentMethod::class,
        'status' => PaymentStatus::class,
        'paid_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the order associated with this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope to only completed payments.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Completed);
    }

    /**
     * Scope to only pending payments.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Pending);
    }

    /**
     * Scope to only failed payments.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Failed);
    }

    /**
     * Scope to get monthly revenue summary for a specific year.
     * Used for revenue charts and reports.
     *
     * @param Builder $query
     * @param int $year
     * @return Builder
     */
    public function scopeRevenuePerMonth(Builder $query, int $year): Builder
    {
        return $query
            ->selectRaw("strftime('%m', paid_at) as month, SUM(amount) as revenue")
            ->whereYear('paid_at', $year)
            ->where('status', PaymentStatus::Completed)
            ->groupBy('month')
            ->orderBy('month');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the formatted amount (KES 1,000.00).
     *
     * @return string
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'KES ' . number_format($this->amount, 2);
    }
}
