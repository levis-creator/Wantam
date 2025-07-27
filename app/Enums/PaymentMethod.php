<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Mpesa = 'mpesa';
    case Card = 'card';
    case PayPal = 'paypal';
    case BankTransfer = 'bank_transfer';
    case Cash = 'cash';
}
