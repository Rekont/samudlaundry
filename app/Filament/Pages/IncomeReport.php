<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\IncomeStatsOverview;
use App\Filament\Widgets\IncomeChart;

class IncomeReport extends Page
{
    // 1. Icon: Gunakan tipe data lengkap (Fix error sebelumnya)
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationLabel = 'Laporan Keuangan';

    protected static ?string $title = 'Laporan Pendapatan & Transaksi';

    // 2. View: HAPUS kata 'static' di sini (Fix error 'Cannot redeclare...')
    protected string $view = 'filament.pages.income-report';

    protected function getHeaderWidgets(): array
    {
        return [
            IncomeStatsOverview::class,
            IncomeChart::class,
        ];
    }
}