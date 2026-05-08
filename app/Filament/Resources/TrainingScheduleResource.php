<?php
// app/Filament/Resources/TrainingScheduleResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingScheduleResource\Pages;
use App\Models\TrainingSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingScheduleResource extends Resource
{
    protected static ?string $model = TrainingSchedule::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Jadwal Training';
    protected static ?string $navigationGroup = 'AK3U Management';
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Training')
                ->required()
                ->maxLength(255),
            Forms\Components\DatePicker::make('start_date')
                ->label('Tanggal Mulai')
                ->required(),
            Forms\Components\DatePicker::make('end_date')
                ->label('Tanggal Selesai')
                ->required(),
            Forms\Components\TextInput::make('location')
                ->label('Lokasi')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('type')
                ->label('Jenis AK3U')
                ->options([
                    'kemnaker' => 'Kemnaker',
                    'bnsp' => 'BNSP',
                    'pop' => 'POP BNSP',
                ])
                ->required(),
            Forms\Components\TextInput::make('price')
                ->label('Harga')
                ->numeric()
                ->prefix('Rp')
                ->required(),
            Forms\Components\TextInput::make('max_participants')
                ->label('Maksimal Peserta')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Training')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'kemnaker' => 'success',
                        'bnsp' => 'warning',
                        'pop' => 'info',
                    }),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('participants_count')
                    ->label('Peserta')
                    ->counts('participants'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis AK3U')
                    ->options([
                        'kemnaker' => 'Kemnaker',
                        'bnsp' => 'BNSP',
                        'pop' => 'POP BNSP',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingSchedules::route('/'),
            'create' => Pages\CreateTrainingSchedule::route('/create'),
            'edit' => Pages\EditTrainingSchedule::route('/{record}/edit'),
        ];
    }
}