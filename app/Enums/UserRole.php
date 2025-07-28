<?php

namespace App\Enums;

enum UserRole: string
{
    case User = 'user';
    case Admin = 'admin';
    case Seller = 'seller';

    public static function options(): array
    {
        return [
            self::User->value => 'User',
            self::Admin->value => 'Admin',
            self::Seller->value => 'Seller',
        ];
    }
}
