<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Enums\OrderStatus;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Order Status Distribution';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'doughnut'; // or 'pie', 'bar'
    }

    protected function getData(): array
    {
        // Get counts grouped by status
        $counts = Order::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Label and color mapping (customize as needed)
        $labels = [];
        $data = [];
        $colors = [];

        foreach (OrderStatus::cases() as $case) {
            $label = $case->name; // Or $case->label if you have custom labels
            $labels[] = ucfirst($label);
            $data[] = $counts[$case->value] ?? 0;

            // Assign custom colors per status (optional)
            $colors[] = match ($case) {
                OrderStatus::Pending => '#facc15',      // yellow
                OrderStatus::Processing => '#38bdf8',   // blue
                OrderStatus::Completed => '#22c55e',    // green
                OrderStatus::Cancelled => '#ef4444',    // red
                default => '#a3a3a3',                   // gray
            };
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
