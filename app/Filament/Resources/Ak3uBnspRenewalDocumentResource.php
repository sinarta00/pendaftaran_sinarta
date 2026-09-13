<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Ak3uBnspRenewalDocumentResource\Pages;
use App\Models\Ak3uBnspRenewal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class Ak3uBnspRenewalDocumentResource extends Resource
{
    protected static ?string $model = Ak3uBnspRenewal::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Berkas Perpanjangan AK3U BNSP';
    protected static ?string $navigationGroup = 'AK3U Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Peserta')
                ->schema([
                    Forms\Components\TextInput::make('registration_number')
                        ->label('Nomor Registrasi')
                        ->disabled(),
                    Forms\Components\TextInput::make('full_name')
                        ->label('Nama Lengkap')
                        ->disabled(),
                    Forms\Components\TextInput::make('company_name')
                        ->label('Perusahaan')
                        ->disabled(),
                ]),

            Forms\Components\Section::make('Dokumen Perpanjangan AK3U BNSP')
                ->schema([
                    Forms\Components\FileUpload::make('ktp_file')
                        ->label('KTP')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('work_certificate')
                        ->label('Surat Keterangan Kerja')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('diploma_file')
                        ->label('Ijazah')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('ak3u_certificate')
                        ->label('Sertifikat AK3U BNSP')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('photo_file')
                        ->label('Pas Foto')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('full_work_certificate')
                        ->label('Surat Keterangan Bekerja Penuh')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('company_application_later')
                        ->label('Surat Permohonan Perusahaan')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('skp__later')
                        ->label('Sertifikat Lama')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('license_later')
                        ->label('Lisensi Lama')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('activity_report_later')
                        ->label('Laporan Kegiatan')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                ]),
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
                Tables\Columns\IconColumn::make('ktp_file')
                    ->label('KTP')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('ak3u_certificate')
                    ->label('AK3U BNSP')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('photo_file')
                    ->label('Foto')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('download_all')
                    ->label('Download ZIP')
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->action(function (Ak3uBnspRenewal $record) {
                        $zipFileName = $record->registration_number . '_ak3u_bnsp_renewal_documents.zip';

                        return response()->streamDownload(function () use ($record) {
                            $zip = new \ZipArchive();
                            $tempFile = tempnam(sys_get_temp_dir(), 'ak3u_bnsp_zip');

                            if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
                                $fields = [
                                    'ktp_file' => 'KTP',
                                    'work_certificate' => 'Surat_Kerja',
                                    'diploma_file' => 'Ijazah',
                                    'ak3u_certificate' => 'Sertifikat_AK3U_BNSP',
                                    'photo_file' => 'Foto',
                                    'full_work_certificate' => 'Surat_Kerja_Penuh',
                                    'company_application_later' => 'Surat_Permohonan_Perusahaan',
                                    'skp__later' => 'Sertifikat_Lama',
                                    'license_later' => 'Lisensi_Lama',
                                    'activity_report_later' => 'Laporan_Kegiatan',
                                ];

                                foreach ($fields as $field => $name) {
                                    if ($record->$field && Storage::disk('public')->exists($record->$field)) {
                                        $filePath = Storage::disk('public')->path($record->$field);
                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        $archiveFileName = $name . '.' . $extension;
                                        $zip->addFile($filePath, $archiveFileName);
                                    }
                                }
                                $zip->close();
                            }

                            readfile($tempFile);
                            unlink($tempFile);
                        }, $zipFileName);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAk3uBnspRenewalDocuments::route('/'),
            'view' => Pages\ViewAk3uBnspRenewalDocument::route('/{record}'),
        ];
    }
}
