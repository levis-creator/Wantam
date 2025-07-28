<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue (KES)';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'bar'; // You can change to 'line', 'pie', etc.
    }

    protected function getData(): array
    {
        $year = now()->year;

        // Fetch completed payments for the current year with paid_at timestamp
        $payments = Payment::completed()
            ->whereYear('paid_at', $year)
            ->get(['amount', 'paid_at']);

        // Initialize 12 months with 0 revenue
        $monthlyRevenue = collect(range(1, 12))->mapWithKeys(function ($month) {
            $monthName = Carbon::create()->month($month)->format('M');
            return [$monthName => 0];
        });

        // Sum payments per month
        foreach ($payments as $payment) {
            $month = Carbon::parse($payment->paid_at)->format('M');
            $monthlyRevenue[$month] += $payment->amount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (KES)',
                    'data' => array_values($monthlyRevenue->toArray()),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.7)', // Tailwind Green
                    'borderColor' => '#22C55E',
                    'fill' => true,
                ],
            ],
            'labels' => array_keys($monthlyRevenue->toArray()),
        ];
    }
}
