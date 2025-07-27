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
}
