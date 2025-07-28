<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
                ->description('Total registered users')
                ->icon('heroicon-o-users'),

            Stat::make('Orders', Order::count())
                ->description('Total orders placed')
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Revenue', 'KES ' . number_format(Payment::sum('amount')))
                ->description('Total paid amount')
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
