<?php

namespace App\Models;

use App\Enums\ShippingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Shipping extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'address_id',
        'city',
        'postal_code',
        'country',
        'tracking_number',
        'status',
    ];
    protected $casts = [
        'status' => ShippingStatus::class,
    ];
    /**
     * Get the order associated with this shipping.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the address associated with this shipping.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
