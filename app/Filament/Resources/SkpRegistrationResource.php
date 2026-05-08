<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkpRegistrationResource\Pages;
use App\Mail\SkpPaymentConfirmation;
use App\Models\SkpRegistration;
use App\Exports\SkpRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class SkpRegistrationResource extends Resource
{
    protected static ?string $model = SkpRegistration::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'SKP Registration';
    protected static ?string $navigationGroup = 'SKP Management';

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
            Forms\Components\Select::make('type')
                ->label('Jenis')
                ->options([
                    'penerbitan' => 'Penerbitan',
                    'perpanjangan' => 'Perpanjangan'
                ]),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Dikonfirmasi',
                    'paid' => 'Lunas'
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'penerbitan' => 'info',
                        'perpanjangan' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'paid' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis')
                    ->options([
                        'penerbitan' => 'Penerbitan',
                        'perpanjangan' => 'Perpanjangan'
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Dikonfirmasi',
                        'paid' => 'Lunas'
                    ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn () => Excel::download(new SkpRegistrationsExport, 'skp_registrations.xlsx'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (SkpRegistration $record): bool => $record->status === 'pending')
                    ->action(function (SkpRegistration $record): void {
                        $record->update(['status' => 'confirmed']);
                    }),
                Tables\Actions\Action::make('mark_paid')
                    ->label('Tandai Lunas')
                    ->icon('heroicon-o-currency-dollar')
                    ->visible(fn (SkpRegistration $record): bool => $record->status === 'confirmed')
                    ->form([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Bayar')
                            ->required(),
                        Forms\Components\TextInput::make('total_payment')
                            ->label('Total Bayar')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                    ])
                    ->action(function (array $data, SkpRegistration $record): void {
                        $record->update([
                            'status' => 'paid',
                            'invoice_number' => $data['invoice_number'],
                            'payment_date' => $data['payment_date'],
                            'total_payment' => $data['total_payment']
                        ]);
                        
                        Mail::to($record->email)->send(new SkpPaymentConfirmation($record));
                    }),
                Tables\Actions\Action::make('view_documents')
                    ->label('Lihat Berkas')
                    ->icon('heroicon-o-folder-open')
                    ->url(fn (SkpRegistration $record): string => SkpDocumentResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkpRegistrations::route('/'),
            'create' => Pages\CreateSkpRegistration::route('/create'),
            'edit' => Pages\EditSkpRegistration::route('/{record}/edit'),
        ];
    }
}