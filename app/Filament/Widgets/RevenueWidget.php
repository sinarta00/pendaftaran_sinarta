<?php
// app/Filament/Widgets/RevenueWidget.php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\TotRegistration;
use App\Models\SkpRegistration;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueWidget extends BaseWidget
{
    protected static ?string $heading = 'Ringkasan Pendapatan';
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        // Total revenue from payments
        $totalRevenue = Payment::where('status', 'confirmed')->sum('amount');
        
        // Revenue this month
        $thisMonthRevenue = Payment::where('status', 'confirmed')
            ->whereMonth('payment_date', now()->month)
            ->sum('amount');
        
        // TOT paid registrations (estimated revenue)
        $totRevenue = TotRegistration::where('status', 'paid')->sum('total_payment');
        
        // SKP paid registrations (estimated revenue) 
        $skpRevenue = SkpRegistration::where('status', 'paid')->sum('total_payment');
        
        // Pending payments (potential revenue)
        $pendingRevenue = Payment::where('status', 'pending')->sum('remaining_amount');

        return [
            Stat::make('Total Pendapatan AK3U', 'Rp ' . number_format($totalRevenue))
                ->description('Dari pembayaran terkonfirmasi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pendapatan TOT', 'Rp ' . number_format($totRevenue))
                ->description('Total dari registrasi lunas')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make('Pendapatan SKP', 'Rp ' . number_format($skpRevenue))
                ->description('Total dari registrasi lunas')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('warning'),

            Stat::make('Bulan Ini', 'Rp ' . number_format($thisMonthRevenue))
                ->description('Pendapatan bulan ini')
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->color('primary'),

            Stat::make('Potensi Pendapatan', 'Rp ' . number_format($pendingRevenue))
                ->description('Dari sisa pembayaran pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color('secondary'),
        ];
    }
}