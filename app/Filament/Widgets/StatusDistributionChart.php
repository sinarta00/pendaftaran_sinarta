<?php
// app/Filament/Widgets/StatusDistributionChart.php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\TotRegistration;
use App\Models\SkpRegistration;
use Filament\Widgets\ChartWidget;

class StatusDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Pendaftaran';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // AK3U Status
        $ak3uPending = Participant::where('status', 'pending')->count();
        $ak3uDpPaid = Participant::where('status', 'dp_paid')->count();
        $ak3uFullPaid = Participant::where('status', 'full_paid')->count();

        // TOT Status
        $totPending = TotRegistration::where('status', 'pending')->count();
        $totConfirmed = TotRegistration::where('status', 'confirmed')->count();
        $totPaid = TotRegistration::where('status', 'paid')->count();

        // SKP Status
        $skpPending = SkpRegistration::where('status', 'pending')->count();
        $skpConfirmed = SkpRegistration::where('status', 'confirmed')->count();
        $skpPaid = SkpRegistration::where('status', 'paid')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Pendaftaran',
                    'data' => [
                        $ak3uPending + $totPending + $skpPending, // Pending/Menunggu
                        $ak3uDpPaid + $totConfirmed + $skpConfirmed, // DP/Dikonfirmasi
                        $ak3uFullPaid + $totPaid + $skpPaid, // Lunas
                    ],
                    'backgroundColor' => [
                        'rgb(239, 68, 68)',   // Red for pending
                        'rgb(245, 158, 11)',  // Yellow for dp/confirmed
                        'rgb(34, 197, 94)',   // Green for paid
                    ],
                ],
            ],
            'labels' => ['Menunggu', 'Dikonfirmasi/DP', 'Lunas'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}