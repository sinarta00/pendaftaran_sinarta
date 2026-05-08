<?php
// app/Filament/Widgets/RecentActivitiesWidget.php

namespace App\Filament\Widgets;

use App\Models\Participant;
use App\Models\TotRegistration;
use App\Models\SkpRegistration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivitiesWidget extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Terbaru';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Combine all recent registrations
                Participant::query()
                    ->select([
                        'id',
                        'registration_number',
                        'full_name as name',
                        'email',
                        'status',
                        'created_at',
                        \DB::raw("'AK3U' as type"),
                        \DB::raw("CASE WHEN type = 'kemnaker' THEN 'Kemnaker' ELSE 'BNSP' END as subtype")
                    ])
                    ->union(
                        TotRegistration::query()
                            ->select([
                                'id',
                                'registration_number',
                                'full_name as name',
                                'email',
                                'status',
                                'created_at',
                                \DB::raw("'TOT' as type"),
                                \DB::raw("CONCAT('Level ', level) as subtype")
                            ])
                    )
                    ->union(
                        SkpRegistration::query()
                            ->select([
                                'id',
                                'registration_number',
                                'full_name as name',
                                'email',
                                'status',
                                'created_at',
                                \DB::raw("'SKP' as type"),
                                'type as subtype'
                            ])
                    )
                    ->orderBy('created_at', 'desc')
                    ->limit(15)
            )
            ->columns([
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'AK3U' => 'primary',
                        'TOT' => 'info',
                        'SKP' => 'warning',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('subtype')
                    ->label('Kategori')
                    ->badge()
                    ->color('secondary'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'dp_paid', 'confirmed' => 'warning',
                        'full_paid', 'paid' => 'success',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25]);
    }
}