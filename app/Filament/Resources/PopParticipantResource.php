<?php
// app/Filament/Resources/PopParticipantResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PopParticipantResource\Pages;
use App\Mail\PopDPConfirmation;
use App\Mail\PopPaymentComplete;
use App\Models\PopParticipant;
use App\Models\PopPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class PopParticipantResource extends Resource
{
    protected static ?string $model = PopParticipant::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Peserta POP';
    protected static ?string $navigationGroup = 'POP BNSP Management';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('registration_number')
                ->label('Nomor Registrasi')
                ->disabled(),
            Forms\Components\TextInput::make('full_name')
                ->label('Nama Lengkap')
                ->required(),
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label('No. Telepon')
                ->required(),
            Forms\Components\Select::make('category')
                ->label('Kategori')
                ->options([
                    'online' => 'Online (Rp 3.800.000)',
                    'hybrid' => 'Hybrid (Rp 4.800.000)'
                ])
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'dp_paid' => 'DP Dibayar',
                    'full_paid' => 'Lunas'
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'online' => 'Online (3.8jt)',
                        'hybrid' => 'Hybrid (4.8jt)',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'online' => 'info',
                        'hybrid' => 'warning',
                        default => 'gray',
                    }),
                    Tables\Columns\TextColumn::make('trainingSchedule.name')
    ->label('Jadwal Pelatihan')
    ->searchable(),

Tables\Columns\TextColumn::make('trainingSchedule.start_date')
    ->label('Tanggal Mulai')
    ->date('d M Y'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'dp_paid' => 'warning',
                        'full_paid' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'dp_paid' => 'DP Dibayar',
                        'full_paid' => 'Lunas',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'online' => 'Online',
                        'hybrid' => 'Hybrid'
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'dp_paid' => 'DP Dibayar',
                        'full_paid' => 'Lunas'
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // ACTION KONFIRMASI DP
                Tables\Actions\Action::make('confirm_dp')
                    ->label('Konfirmasi DP')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (PopParticipant $record): bool => $record->status === 'pending')
                    ->form([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->required()
                            ->default(now()),
                        Forms\Components\TextInput::make('dp_amount')
                            ->label('Jumlah DP')
                            ->numeric()
                            ->default(1000000)
                            ->required(),
                    ])
                    ->action(function (array $data, PopParticipant $record): void {
                        // Update participant status
                        $record->update(['status' => 'dp_paid']);
                        
                        // Update payment record
                        $payment = $record->payments()->where('payment_type', 'dp')->first();
                        $payment->update([
                            'invoice_number' => $data['invoice_number'],
                            'payment_date' => $data['payment_date'],
                            'amount' => $data['dp_amount'],
                            'status' => 'confirmed'
                        ]);
                        
                        // Send confirmation email
                        Mail::to($record->email)->send(new PopDPConfirmation($record, $payment));
                        
                        Notification::make()
                            ->success()
                            ->title('DP Dikonfirmasi')
                            ->body('Email konfirmasi telah dikirim dengan link upload dokumen')
                            ->send();
                    }),
                
                // ACTION KONFIRMASI PELUNASAN
                Tables\Actions\Action::make('confirm_full_payment')
                    ->label('Konfirmasi Pelunasan')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->visible(fn (PopParticipant $record): bool => $record->status === 'dp_paid')
                    ->form([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Pelunasan')
                            ->required()
                            ->default(now()),
                    ])
                    ->action(function (array $data, PopParticipant $record): void {
                        // Update participant status
                        $record->update(['status' => 'full_paid']);
                        
                        // Create full payment record
                        $dpPayment = $record->payments()->where('payment_type', 'dp')->first();
                        $fullPayment = PopPayment::create([
                            'pop_participant_id' => $record->id,
                            'invoice_number' => $data['invoice_number'],
                            'payment_type' => 'full',
                            'amount' => $dpPayment->remaining_amount,
                            'payment_date' => $data['payment_date'],
                            'status' => 'confirmed'
                        ]);
                        
                        // Send completion email
                        Mail::to($record->email)->send(new PopPaymentComplete($record, $fullPayment));
                        
                        Notification::make()
                            ->success()
                            ->title('Pelunasan Dikonfirmasi')
                            ->body('Peserta telah lunas, email konfirmasi telah dikirim')
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPopParticipants::route('/'),
            'create' => Pages\CreatePopParticipant::route('/create'),
            'edit' => Pages\EditPopParticipant::route('/{record}/edit'),
        ];
    }
}