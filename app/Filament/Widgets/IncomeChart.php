<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeChart extends ChartWidget
{
    // 👇 HAPUS kata 'static' di sini
    protected ?string $heading = 'Grafik Pendapatan Tahun Ini';
    
    // Static boleh dipakai untuk $sort karena di induknya juga static
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::query(Transaction::where('status', 'completed'))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('total_price');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}