<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class IncomeStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. Hitung Total Uang (Hanya yang Completed)
        $totalRevenue = Transaction::where('status', 'completed')->sum('total_price');

        // 2. Hitung Pendapatan Bulan Ini
        $revenueThisMonth = Transaction::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // 3. Total Transaksi Selesai
        $totalOrders = Transaction::where('status', 'completed')->count();

        return [
            Stat::make('Total Pendapatan (Semua Waktu)', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Uang masuk bersih')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'), // Hijau

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($revenueThisMonth, 0, ',', '.'))
                ->description(Carbon::now()->format('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'), // Biru

            Stat::make('Total Cucian Selesai', $totalOrders . ' Transaksi')
                ->description('Pelanggan puas')
                ->color('warning'), // Kuning
        ];
    }
}