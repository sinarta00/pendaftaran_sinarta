<?php
// app/Filament/Widgets/OverviewStatsWidget.php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\TotRegistration;
use App\Models\SkpRegistration;
use App\Models\TrainingSchedule;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalAK3U = Participant::count();
        $totalTOT = TotRegistration::count();
        $totalSKP = SkpRegistration::count();
        $totalTrainingSchedules = TrainingSchedule::where('is_active', true)->count();

        // Pending registrations
        $pendingAK3U = Participant::where('status', 'pending')->count();
        $pendingTOT = TotRegistration::where('status', 'pending')->count();
        $pendingSKP = SkpRegistration::where('status', 'pending')->count();
        $totalPending = $pendingAK3U + $pendingTOT + $pendingSKP;

        // This month registrations
        $thisMonthAK3U = Participant::whereMonth('created_at', now()->month)->count();
        $thisMonthTOT = TotRegistration::whereMonth('created_at', now()->month)->count();
        $thisMonthSKP = SkpRegistration::whereMonth('created_at', now()->month)->count();
        $thisMonthTotal = $thisMonthAK3U + $thisMonthTOT + $thisMonthSKP;

        return [
            Stat::make('Total Pendaftaran AK3U', $totalAK3U)
                ->description('Kemnaker & BNSP')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Pendaftaran TOT', $totalTOT)
                ->description('Training of Trainers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([3, 7, 5, 8, 12, 6, 9]),

            Stat::make('Total Pendaftaran SKP', $totalSKP)
                ->description('Penerbitan & Perpanjangan')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('warning')
                ->chart([2, 5, 3, 8, 6, 10, 4]),

            Stat::make('Jadwal Training Aktif', $totalTrainingSchedules)
                ->description('Training tersedia')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Menunggu Konfirmasi', $totalPending)
                ->description("{$pendingAK3U} AK3U, {$pendingTOT} TOT, {$pendingSKP} SKP")
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),

            Stat::make('Pendaftaran Bulan Ini', $thisMonthTotal)
                ->description("AK3U: {$thisMonthAK3U}, TOT: {$thisMonthTOT}, SKP: {$thisMonthSKP}")
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}