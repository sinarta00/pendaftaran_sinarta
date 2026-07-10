<?php
// app/Filament/Resources/SkpDocumentResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\SkpDocumentResource\Pages;
use App\Models\SkpRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class SkpDocumentResource extends Resource
{
    protected static ?string $model = SkpRegistration::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'SKP Documents';
    protected static ?string $navigationGroup = 'SKP Management';

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
                    Forms\Components\TextInput::make('type')
                        ->label('Jenis')
                        ->disabled(),
                ]),
            
            Forms\Components\Section::make('Dokumen SKP')
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
                        ->label('Sertifikat AK3U')
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
                        ->label('SKP')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('license_later')
                        ->label('Izin')
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\IconColumn::make('ktp_file')
                    ->label('KTP')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('ak3u_certificate')
                    ->label('AK3U')
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
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'penerbitan' => 'Penerbitan',
                        'perpanjangan' => 'Perpanjangan'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('download_all')
                    ->label('Download ZIP')
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->action(function (SkpRegistration $record) {
                        $zipFileName = $record->registration_number . '_skp_documents.zip';
                        
                        return response()->streamDownload(function () use ($record) {
                            $zip = new \ZipArchive();
                            $tempFile = tempnam(sys_get_temp_dir(), 'skp_documents_zip');
                            
                            if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
                                $fields = [
                                    'ktp_file' => 'KTP',
                                    'work_certificate' => 'Surat_Kerja',
                                    'diploma_file' => 'Ijazah',
                                    'ak3u_certificate' => 'Sertifikat_AK3U',
                                    'photo_file' => 'Foto',
                                    'full_work_certificate' => 'Surat_Kerja_Penuh'
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
            'index' => Pages\ListSkpDocuments::route('/'),
            'view' => Pages\ViewSkpDocument::route('/{record}'),
        ];
    }
}