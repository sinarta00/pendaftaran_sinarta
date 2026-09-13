<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Ak3uBnspRenewalResource\Pages;
use App\Mail\Ak3uBnspRenewalPaymentConfirmation;
use App\Models\Ak3uBnspRenewal;
use App\Exports\Ak3uBnspRenewalsExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class Ak3uBnspRenewalResource extends Resource
{
    protected static ?string $model = Ak3uBnspRenewal::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationLabel = 'Perpanjangan AK3U BNSP';
    protected static ?string $navigationGroup = 'AK3U Management';

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
                ->label('Nomor WhatsApp')
                ->required(),
            Forms\Components\TextInput::make('nik')
                ->label('NIK')
                ->required(),
            Forms\Components\TextInput::make('diploma_number')
                ->label('Nomor Ijazah')
                ->required(),
            Forms\Components\Select::make('gender')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),
            Forms\Components\Select::make('blood_type')
                ->label('Golongan Darah')
                ->options([
                    'A' => 'A',
                    'B' => 'B',
                    'AB' => 'AB',
                    'O' => 'O',
                ])
                ->required(),
            Forms\Components\Select::make('education')
                ->label('Pendidikan Terakhir')
                ->options([
                    'SMA' => 'SMA/SMK/Sederajat',
                    'D3' => 'D3',
                    'S1' => 'S1',
                    'S2' => 'S2',
                    'S3' => 'S3',
                ])
                ->required(),
            Forms\Components\TextInput::make('company_name')
                ->label('Nama Perusahaan')
                ->required(),
            Forms\Components\Textarea::make('company_address')
                ->label('Alamat Perusahaan')
                ->required(),
            Forms\Components\TextInput::make('old_sk_number')
                ->label('No. SK / Sertifikat Lama'),
            Forms\Components\TextInput::make('old_license_number')
                ->label('No. Lisensi / Kartu Lama'),
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
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Perusahaan')
                    ->searchable(),
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
                    ->action(fn () => Excel::download(new Ak3uBnspRenewalsExport, 'perpanjangan_ak3u_bnsp.xlsx'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Ak3uBnspRenewal $record): bool => $record->status === 'pending')
                    ->action(function (Ak3uBnspRenewal $record): void {
                        $record->update(['status' => 'confirmed']);
                    }),
                Tables\Actions\Action::make('mark_paid')
                    ->label('Tandai Lunas')
                    ->icon('heroicon-o-currency-dollar')
                    ->visible(fn (Ak3uBnspRenewal $record): bool => $record->status === 'confirmed')
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
                    ->action(function (array $data, Ak3uBnspRenewal $record): void {
                        $record->update([
                            'status' => 'paid',
                            'invoice_number' => $data['invoice_number'],
                            'payment_date' => $data['payment_date'],
                            'total_payment' => $data['total_payment']
                        ]);

                        Mail::to($record->email)->send(new Ak3uBnspRenewalPaymentConfirmation($record));
                    }),
                Tables\Actions\Action::make('view_documents')
                    ->label('Lihat Berkas')
                    ->icon('heroicon-o-folder-open')
                    ->url(fn (Ak3uBnspRenewal $record): string => Ak3uBnspRenewalDocumentResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAk3uBnspRenewals::route('/'),
            'create' => Pages\CreateAk3uBnspRenewal::route('/create'),
            'edit' => Pages\EditAk3uBnspRenewal::route('/{record}/edit'),
        ];
    }
}
