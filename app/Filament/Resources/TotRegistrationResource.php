<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TotRegistrationResource\Pages;
use App\Mail\TotPaymentConfirmation;
use App\Models\TotRegistration;
use App\Exports\TotRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class TotRegistrationResource extends Resource
{
    protected static ?string $model = TotRegistration::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'TOT Registration';
    protected static ?string $navigationGroup = 'TOT Management';
    
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
            Forms\Components\Select::make('level')
                ->label('Level TOT')
                ->options([
                    '3' => 'Level 3',
                    '4' => 'Level 4',
                    '5' => 'Level 5',
                    '6' => 'Level 6'
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
                Tables\Columns\TextColumn::make('level')
                    ->label('Level')
                    ->badge(),
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
                Tables\Filters\SelectFilter::make('level')
                    ->label('Level TOT')
                    ->options([
                        '3' => 'Level 3',
                        '4' => 'Level 4',
                        '5' => 'Level 5',
                        '6' => 'Level 6'
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
                    ->action(fn () => Excel::download(new TotRegistrationsExport, 'tot_registrations.xlsx'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Registrasi TOT')
                    ->modalDescription('Apakah yakin ingin menghapus data ini? Semua file dokumen yang diupload akan ikut terhapus permanen.')
                    ->modalSubmitActionLabel('Ya, Hapus'),
                Tables\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (TotRegistration $record): bool => $record->status === 'pending')
                    ->action(function (TotRegistration $record): void {
                        $record->update(['status' => 'confirmed']);
                    }),
                Tables\Actions\Action::make('mark_paid')
                    ->label('Tandai Lunas')
                    ->icon('heroicon-o-currency-dollar')
                    ->visible(fn (TotRegistration $record): bool => $record->status === 'confirmed')
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
                    ->action(function (array $data, TotRegistration $record): void {
                        $record->update([
                            'status' => 'paid',
                            'invoice_number' => $data['invoice_number'],
                            'payment_date' => $data['payment_date'],
                            'total_payment' => $data['total_payment']
                        ]);
                        
                        Mail::to($record->email)->send(new TotPaymentConfirmation($record));
                    }),
                Tables\Actions\Action::make('view_documents')
                    ->label('Lihat Berkas')
                    ->icon('heroicon-o-folder-open')
                    ->url(fn (TotRegistration $record): string => TotDocumentResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                    
                
            ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make()
                            ->requiresConfirmation()
                            ->modalHeading('Hapus Registrasi Terpilih')
                            ->modalDescription('Apakah yakin ingin menghapus semua data yang dipilih? Semua file dokumen akan ikut terhapus permanen.')
                            ->modalSubmitActionLabel('Ya, Hapus Semua')
                            ->before(function (\Illuminate\Database\Eloquent\Collection $records) {
                                $fileColumns = [
                                    'photo_file',
                                    'ktp_file',
                                    'diploma_file',
                                    'tot_assistant_cert',
                                    'tot_instructor_cert',
                                    'kkni_level4_cert',
                                    'work_exp_assistant',
                                    'work_exp_instructor',
                                    'work_exp_senior',
                                    'senior_instructor_cert',
                                    'master_instructor_cert',
                                ];
                
                                foreach ($records as $record) {
                                    foreach ($fileColumns as $column) {
                                        if ($record->$column) {
                                            \Illuminate\Support\Facades\Storage::disk('public')->delete($record->$column);
                                        }
                                    }
                                }
                            }),
                    ]),
                ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTotRegistrations::route('/'),
            'create' => Pages\CreateTotRegistration::route('/create'),
            'edit' => Pages\EditTotRegistration::route('/{record}/edit'),
        ];
    }
}