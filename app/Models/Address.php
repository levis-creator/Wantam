<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Address extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'is_default',
    ];

    protected $appends = ['full_address'];
    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shipping associated with this address.
     */
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }

    /**
     * Get the orders associated with this address.
     */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get a readable full address.
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->city}, {$this->postal_code}, {$this->country}";
    }
}
