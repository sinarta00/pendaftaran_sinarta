<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Mail\InvoiceSent;
use App\Mail\DPConfirmation;
use App\Mail\PaymentComplete;
use App\Models\Participant;
use App\Models\Payment;
use App\Exports\ParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Peserta';
    protected static ?string $navigationGroup = 'AK3U Management';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('registration_number')
                ->label('Nomor Registrasi')
                ->disabled(),
            Forms\Components\Select::make('type')
                ->label('Jenis AK3U')
                ->options([
                    'kemnaker' => 'Kemnaker',
                    'bnsp' => 'BNSP'
                ]),
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
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'documents_uploaded' => 'Dokumen Diupload',
                    'documents_verified' => 'Dokumen Terverifikasi',
                    'invoice_sent' => 'Invoice Terkirim',
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'kemnaker' => 'success',
                        'bnsp' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('participant_category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'personal' => 'Personal',
                        'company' => 'Perusahaan',
                        default => '-',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'personal' => 'info',
                        'company' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'documents_uploaded' => 'info',
                        'documents_verified' => 'primary',
                        'invoice_sent' => 'warning',
                        'dp_paid' => 'warning',
                        'full_paid' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'documents_uploaded' => 'Dokumen Diupload',
                        'documents_verified' => 'Dokumen Terverifikasi',
                        'invoice_sent' => 'Invoice Terkirim',
                        'dp_paid' => 'DP Dibayar',
                        'full_paid' => 'Lunas',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis AK3U')
                    ->options([
                        'kemnaker' => 'Kemnaker',
                        'bnsp' => 'BNSP'
                    ]),
                Tables\Filters\SelectFilter::make('participant_category')
                    ->label('Kategori Peserta')
                    ->options([
                        'personal' => 'Personal',
                        'company' => 'Perusahaan'
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'documents_uploaded' => 'Dokumen Diupload',
                        'documents_verified' => 'Dokumen Terverifikasi',
                        'invoice_sent' => 'Invoice Terkirim',
                        'dp_paid' => 'DP Dibayar',
                        'full_paid' => 'Lunas'
                    ]),
            ])
            // 👇 TAMBAH TABS DI SINI
            ->defaultGroup('type')
            ->groups([
                Tables\Grouping\Group::make('type')
                    ->label('Jenis AK3U')
                    ->collapsible(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_kemnaker')
                    ->label('Export Kemnaker')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        return Excel::download(
                            new ParticipantsExport('kemnaker'), 
                            'participants_kemnaker_' . date('Y-m-d') . '.xlsx'
                        );
                    }),
                Tables\Actions\Action::make('export_bnsp')
                    ->label('Export BNSP')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('warning')
                    ->action(function () {
                        return Excel::download(
                            new ParticipantsExport('bnsp'), 
                            'participants_bnsp_' . date('Y-m-d') . '.xlsx'
                        );
                    }),
            ])
            ->actions([
                
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('view_detail')
                ->label('Detail')
                ->icon('heroicon-o-eye')
                ->modalHeading('Detail Peserta')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup')
               ->mountUsing(function (Forms\ComponentContainer $form, Participant $record) {
                    $form->fill([
                        'registration_number' => $record->registration_number,
                        'full_name' => $record->full_name,
                        'email' => $record->email,
                        'phone' => $record->phone,
                        'type' => strtoupper($record->type),
                        'participant_category' => ucfirst($record->participant_category),
                        'status' => ucfirst(str_replace('_', ' ', $record->status)),
                        'birth_place' => $record->birth_place,
                        'birth_date' => $record->birth_date?->format('d-m-Y'),
                        'gender' => $record->gender === 'L' ? 'Laki-laki' : 'Perempuan',       // ✅ tambah
                        'golongan_darah' => $record->golongan_darah ?? '-',
                        'domisili_kota' => $record->domisili_kota,                               // ✅ tambah
                        'jurusan' => $record->jurusan,                                           // ✅ tambah
                        'institution_name' => $record->institution_name,                         // ✅ tambah
                        'employment_status' => $record->employment_status ?? '-',                // ✅ tambah
                        'work_company_name' => $record->work_company_name ?? '-',                // ✅ tambah
                        'training_purpose' => $record->training_purpose,                         // ✅ tambah
                        'education' => $record->education ?? $record->education_bnsp ?? '-',
                        'jadwal_pelatihan' => $record->trainingSchedule?->name ?? '-',
                        'shirt_size' => $record->shirt_size,
                        'information_source' => $record->information_source,
                        'referral_code' => $record->referral_code ?? '-',                        // ✅ tambah
                        'company_name' => $record->company_name ?? '-',
                        'company_address' => $record->company_address ?? '-',
                        'company_phone' => $record->company_phone ?? '-',
                        'tanggal_daftar' => $record->created_at->format('d-m-Y H:i'),
                        'info_referal' => $record->referral_code ?? "-",
                    ]);
                })
                ->form(function (Participant $record): array {
                    return [
                        Forms\Components\Section::make('Data Utama')
                            ->schema([
                                Forms\Components\TextInput::make('registration_number')->label('No Registrasi')->disabled(),
                                Forms\Components\TextInput::make('full_name')->label('Nama Lengkap')->disabled(),
                                Forms\Components\TextInput::make('email')->disabled(),
                                Forms\Components\TextInput::make('phone')->label('No Telepon')->disabled(),
                                Forms\Components\TextInput::make('type')->label('Jenis AK3U')->disabled(),
                                Forms\Components\TextInput::make('participant_category')->label('Kategori')->disabled(),
                                Forms\Components\TextInput::make('status')->disabled(),
                                Forms\Components\TextInput::make('tanggal_daftar')->label('Tanggal Daftar')->disabled(),
                            ])
                            ->columns(2),
                
                        Forms\Components\Section::make('Data Pribadi')
                            ->schema([
                                Forms\Components\TextInput::make('birth_place')->label('Tempat Lahir')->disabled(),
                                Forms\Components\TextInput::make('birth_date')->label('Tanggal Lahir')->disabled(),
                                Forms\Components\TextInput::make('gender')->label('Jenis Kelamin')->disabled(),
                                Forms\Components\TextInput::make('golongan_darah')->label('Golongan Darah')->disabled(),
                                Forms\Components\TextInput::make('domisili_kota')->label('Kota Domisili')->disabled(),
                                Forms\Components\TextInput::make('jurusan')->label('Jurusan')->disabled(),
                                Forms\Components\TextInput::make('institution_name')->label('Nama Institusi')->disabled(),
                                Forms\Components\TextInput::make('education')->label('Pendidikan')->disabled(),
                                Forms\Components\TextInput::make('shirt_size')->label('Ukuran Baju')->disabled(),
                            ])
                            ->columns(2),
                
                        Forms\Components\Section::make('Pekerjaan')
                            ->schema([
                                Forms\Components\TextInput::make('employment_status')->label('Status Pekerjaan')->disabled(),
                                Forms\Components\TextInput::make('work_company_name')->label('Nama Perusahaan Kerja')->disabled(),
                            ])
                            ->columns(2),
                
                        Forms\Components\Section::make('Pelatihan')
                            ->schema([
                                Forms\Components\TextInput::make('jadwal_pelatihan')->label('Jadwal Pelatihan')->disabled(),
                                Forms\Components\TextInput::make('training_purpose')->label('Tujuan Pelatihan')->disabled(),
                                Forms\Components\TextInput::make('information_source')->label('Sumber Informasi')->disabled(),
                                Forms\Components\TextInput::make('referral_code')->label('Kode Referral')->disabled(),
                                Forms\Components\TextInput::make('info_referal')->label('Info Referral')->disabled(),
                            ])
                            ->columns(2),
                
                        Forms\Components\Section::make('Data Perusahaan')
                            ->schema([
                                Forms\Components\TextInput::make('company_name')->label('Nama Perusahaan')->disabled(),
                                Forms\Components\TextInput::make('company_address')->label('Alamat Perusahaan')->disabled(),
                                Forms\Components\TextInput::make('company_phone')->label('Telepon Perusahaan')->disabled(),
                            ])
                            ->columns(2)
                            ->visible($record->participant_category === 'company'), // ✅ akses $record langsung
                    ];
                }),

                
                // 👇 ACTION KONFIRMASI DOKUMEN (untuk company)
                Tables\Actions\Action::make('verify_documents')
                    ->label('Verifikasi Dokumen')
                    ->icon('heroicon-o-check-badge')
                    ->color('primary')
                    ->visible(fn (Participant $record): bool => 
                        $record->type === 'kemnaker' && 
                        $record->participant_category === 'company' &&
                        in_array($record->status, ['pending', 'documents_uploaded'])
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Dokumen')
                    ->modalDescription('Apakah dokumen peserta sudah lengkap dan sesuai?')
                    ->action(function (Participant $record): void {
                        $record->update(['status' => 'documents_verified']);
                        
                        Notification::make()
                            ->success()
                            ->title('Dokumen Terverifikasi')
                            ->body('Dokumen peserta telah diverifikasi. Silakan kirim invoice.')
                            ->send();
                    }),
                
                // 👇 ACTION KIRIM INVOICE (untuk company)
                Tables\Actions\Action::make('send_invoice')
                    ->label('Kirim Invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->visible(fn (Participant $record): bool => 
                        $record->type === 'kemnaker' && 
                        $record->participant_category === 'company' &&
                        $record->status === 'documents_verified'
                    )
                    ->form([
                        Forms\Components\FileUpload::make('invoice_file')
                            ->label('Upload Invoice (PDF)')
                            ->disk('public')
                            ->directory('invoices')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->required(),
                    ])
                    ->action(function (array $data, Participant $record): void {
                        // Update participant dengan file invoice dan status
                        $record->update([
                            'invoice_file' => $data['invoice_file'],
                            'status' => 'invoice_sent'
                        ]);
                        
                        // Kirim email dengan attachment invoice
                        Mail::to($record->email)->send(new InvoiceSent($record));
                        
                        Notification::make()
                            ->success()
                            ->title('Invoice Terkirim')
                            ->body('Invoice telah dikirim ke ' . $record->email)
                            ->send();
                    }),
                
                // 👇 ACTION KONFIRMASI PELUNASAN (untuk company - langsung lunas tanpa DP)
                Tables\Actions\Action::make('confirm_full_payment_company')
                    ->label('Konfirmasi Pelunasan')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->visible(fn (Participant $record): bool => 
                        $record->type === 'kemnaker' && 
                        $record->participant_category === 'company' &&
                        $record->status === 'invoice_sent'
                    )
                    ->form([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->required()
                            ->default(now()),
                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah Pembayaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                    ])
                    ->action(function (array $data, Participant $record): void {
                        // Update status participant
                        $record->update(['status' => 'full_paid']);
                        
                        // Buat payment record
                        $payment = Payment::create([
                            'participant_id' => $record->id,
                            'invoice_number' => $data['invoice_number'],
                            'payment_type' => 'full',
                            'amount' => $data['amount'],
                            'payment_date' => $data['payment_date'],
                            'status' => 'confirmed'
                        ]);
                        
                        // Kirim email konfirmasi
                        Mail::to($record->email)->send(new PaymentComplete($record, $payment));
                        
                        Notification::make()
                            ->success()
                            ->title('Pembayaran Dikonfirmasi')
                            ->body('Peserta telah lunas')
                            ->send();
                    }),
                
                // 👇 ACTION KONFIRMASI DP (untuk personal - flow lama)
                Tables\Actions\Action::make('confirm_dp')
                    ->label('Konfirmasi DP')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Participant $record): bool => 
                        $record->participant_category === 'personal' &&
                        $record->status === 'pending'
                    )
                    ->form([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->required(),
                        Forms\Components\TextInput::make('dp_amount')
                            ->label('Jumlah DP')
                            ->numeric()
                            ->default(1000000)
                            ->required(),
                    ])
                    ->action(function (array $data, Participant $record): void {
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
                        Mail::to($record->email)->send(new DPConfirmation($record, $payment));
                        
                        Notification::make()
                            ->success()
                            ->title('DP Dikonfirmasi')
                            ->send();
                    }),
                
                // 👇 ACTION KONFIRMASI PELUNASAN (untuk personal - flow lama)
                Tables\Actions\Action::make('confirm_full_payment')
                    ->label('Konfirmasi Pelunasan')
                    ->icon('heroicon-o-currency-dollar')
                    ->visible(fn (Participant $record): bool => 
                        $record->participant_category === 'personal' &&
                        $record->status === 'dp_paid'
                    )
                    ->form([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Pelunasan')
                            ->required(),
                    ])
                    ->action(function (array $data, Participant $record): void {
                        // Update participant status
                        $record->update(['status' => 'full_paid']);
                        
                        // Create full payment record
                        $dpPayment = $record->payments()->where('payment_type', 'dp')->first();
                        $fullPayment = Payment::create([
                            'participant_id' => $record->id,
                            'invoice_number' => $data['invoice_number'],
                            'payment_type' => 'full',
                            'amount' => $dpPayment->remaining_amount,
                            'payment_date' => $data['payment_date'],
                            'status' => 'confirmed'
                        ]);
                        
                        // Send completion email
                        Mail::to($record->email)->send(new PaymentComplete($record, $fullPayment));
                        
                        Notification::make()
                            ->success()
                            ->title('Pelunasan Dikonfirmasi')
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}