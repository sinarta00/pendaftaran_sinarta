<?php
// app/Filament/Widgets/UpcomingTrainingWidget.php

namespace App\Filament\Widgets;

use App\Models\TrainingSchedule;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingTrainingWidget extends BaseWidget
{
    protected static ?string $heading = 'Jadwal Training Mendatang';
    protected static ?int $sort = 6;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TrainingSchedule::query()
                    ->where('is_active', true)
                    ->where('start_date', '>=', now())
                    ->withCount('participants')
                    ->orderBy('start_date')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Training')
                    ->searchable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'kemnaker' => 'success',
                        'bnsp' => 'info',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d/m/Y'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(20),
                Tables\Columns\TextColumn::make('participants_count')
                    ->label('Peserta')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('max_participants')
                    ->label('Max')
                    ->badge()
                    ->color('secondary'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->weight('medium'),
            ])
            ->paginated([5, 10, 25]);
    }
}