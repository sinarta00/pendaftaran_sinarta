<?php
// app/Filament/Resources/ReferralCodeResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralCodeResource\Pages;
use App\Models\ReferralCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferralCodeResource extends Resource
{
    protected static ?string $model = ReferralCode::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kode Referral';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('Kode')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            Forms\Components\TextInput::make('description')
                ->label('Deskripsi')
                ->maxLength(255),
            Forms\Components\TextInput::make('discount_amount')
                ->label('Diskon (Rupiah)')
                ->numeric()
                ->prefix('Rp')
                ->default(0),
            Forms\Components\TextInput::make('discount_percentage')
                ->label('Diskon (%)')
                ->numeric()
                ->suffix('%')
                ->minValue(0)
                ->maxValue(100)
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
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('Diskon (Rp)')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('Diskon (%)')
                    ->suffix('%'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
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
            'index' => Pages\ListReferralCodes::route('/'),
            'create' => Pages\CreateReferralCode::route('/create'),
            'edit' => Pages\EditReferralCode::route('/{record}/edit'),
        ];
    }
}