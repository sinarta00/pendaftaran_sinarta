<?php
// app/Filament/Resources/PaymentResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('participant_id')
                ->label('Peserta')
                ->relationship('participant', 'full_name')
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('invoice_number')
                ->label('Nomor Invoice')
                ->maxLength(255),
            Forms\Components\Select::make('payment_type')
                ->label('Jenis Pembayaran')
                ->options([
                    'dp' => 'DP',
                    'full' => 'Pelunasan'
                ])
                ->required(),
            Forms\Components\TextInput::make('amount')
                ->label('Jumlah')
                ->numeric()
                ->prefix('Rp')
                ->required(),
            Forms\Components\TextInput::make('remaining_amount')
                ->label('Sisa Pembayaran')
                ->numeric()
                ->prefix('Rp')
                ->default(0),
            Forms\Components\DatePicker::make('payment_date')
                ->label('Tanggal Pembayaran'),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Dikonfirmasi'
                ])
                ->default('pending')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('participant.registration_number')
                    ->label('No. Registrasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('participant.full_name')
                    ->label('Nama Peserta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dp' => 'warning',
                        'full' => 'success',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_type')
                    ->label('Jenis Pembayaran')
                    ->options([
                        'dp' => 'DP',
                        'full' => 'Pelunasan'
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Dikonfirmasi'
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}