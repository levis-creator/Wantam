<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Processing = 'processing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [
                $case->value => ucfirst($case->value),
            ])
            ->toArray();
    }
}
