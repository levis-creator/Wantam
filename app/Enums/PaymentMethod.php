<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Mpesa = 'mpesa';
    case Card = 'card';
    case PayPal = 'paypal';
    case BankTransfer = 'bank_transfer';
    case Cash = 'cash';
    case CashOnDelivery = 'cash_on_delivery';

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [
                $case->value => ucfirst(str_replace('_', ' ', $case->value))
            ])
            ->toArray();
    }
}
