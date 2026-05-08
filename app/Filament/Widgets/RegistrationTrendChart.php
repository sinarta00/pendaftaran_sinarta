<?php
// app/Filament/Widgets/RegistrationTrendChart.php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\TotRegistration;
use App\Models\SkpRegistration;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;

class RegistrationTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Pendaftaran (6 Bulan Terakhir)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $ak3uTrend = Trend::model(Participant::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        $totTrend = Trend::model(TotRegistration::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        $skpTrend = Trend::model(SkpRegistration::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'AK3U (Kemnaker & BNSP)',
                    'data' => $ak3uTrend->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
                [
                    'label' => 'TOT',
                    'data' => $totTrend->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(147, 51, 234)',
                    'backgroundColor' => 'rgba(147, 51, 234, 0.1)',
                ],
                [
                    'label' => 'SKP',
                    'data' => $skpTrend->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(245, 158, 11)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                ],
            ],
            'labels' => $ak3uTrend->map(fn (TrendValue $value) =>
                Carbon::parse($value->date)->format('M Y')
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
        ];
    }
}
