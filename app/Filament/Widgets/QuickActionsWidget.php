<?php
// app/Filament/Widgets/QuickActionsWidget.php

namespace App\Filament\Widgets;

use App\Filament\Resources\ParticipantResource;
use App\Filament\Resources\TrainingScheduleResource;
use App\Filament\Resources\ReferralCodeResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;
use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'actions' => [
                Action::make('create_training')
                    ->label('Tambah Jadwal Training')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->size(ActionSize::Large)
                    ->url(TrainingScheduleResource::getUrl('create')),

                Action::make('create_referral')
                    ->label('Buat Kode Referral')
                    ->icon('heroicon-o-tag')
                    ->color('success')
                    ->size(ActionSize::Large)
                    ->url(ReferralCodeResource::getUrl('create')),

                Action::make('view_participants')
                    ->label('Kelola Peserta')
                    ->icon('heroicon-o-users')
                    ->color('warning')
                    ->size(ActionSize::Large)
                    ->url(ParticipantResource::getUrl('index')),

                Action::make('pending_confirmations')
                    ->label('Konfirmasi Pending')
                    ->icon('heroicon-o-clock')
                    ->color('danger')
                    ->size(ActionSize::Large)
                    ->url(ParticipantResource::getUrl('index', ['tableFilters[status][value]' => 'pending'])),
            ]
        ];
    }
}