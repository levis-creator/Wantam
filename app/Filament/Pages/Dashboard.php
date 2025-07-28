<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -1;

    public function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            Widgets\RevenueChart::class,
            Widgets\LatestOrders::class,
        ];
    }
}
