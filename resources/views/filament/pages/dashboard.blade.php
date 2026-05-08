<x-filament::page>
    {{-- Overview Stats (Full Width) --}}
    <x-filament-widgets
        :widgets="[
            App\Filament\Widgets\OverviewStatsWidget::class,
        ]"
        :columns="[
            'default' => 1,
        ]"
    />

    {{-- Quick Actions (jejer horizontal) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <x-filament-widgets
            :widgets="[
                App\Filament\Widgets\QuickActionsWidget::class,
            ]"
            :columns="[
                'default' => 1,
            ]"
        />
    </div>

    {{-- Upcoming Training (kiri) + Status Distribution (kanan) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
        <x-filament-widgets
            :widgets="[
                App\Filament\Widgets\UpcomingTrainingWidget::class,
            ]"
            :columns="[
                'default' => 1,
            ]"
        />

        <x-filament-widgets
            :widgets="[
                App\Filament\Widgets\StatusDistributionWidget::class,
            ]"
            :columns="[
                'default' => 1,
            ]"
        />
    </div>
</x-filament::page>
