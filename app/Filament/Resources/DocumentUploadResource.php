<?php
// app/Filament/Resources/DocumentUploadResource.php

namespace App\Filament\Resources;

use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\DocumentUploadResource\Pages;
use App\Models\DocumentUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentUploadResource extends Resource
{
    protected static ?string $model = DocumentUpload::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static ?string $navigationLabel = 'Upload Dokumen';
    protected static ?string $navigationGroup = 'AK3U Management';
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('participant.full_name')
                ->label('Nama Peserta')
                ->disabled(),
            Forms\Components\TextInput::make('ktp_number')
                ->label('Nomor KTP'),
            Forms\Components\TextInput::make('diploma_number')
                ->label('Nomor Ijazah'),
            
            // File preview sections
            Forms\Components\Section::make('Dokumen Upload')
                ->schema([
                    Forms\Components\FileUpload::make('scan_diploma')
                        ->label('Scan Ijazah')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('scan_ktp')
                        ->label('Scan KTP')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('scan_photo')
                        ->label('Scan Foto')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('health_certificate')
                        ->label('Surat Sehat')
                        ->disk('public')
                        ->downloadable()
                        ->disabled()
                        ->visible(fn ($record) => $record && $record->health_certificate),
                    Forms\Components\FileUpload::make('cv_file')
                        ->label('CV')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('integrity_pact')
                        ->label('Pakta Integritas')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                   Forms\Components\FileUpload::make('work_certificate')
    ->label('Surat Kerja')
    ->disk('public')
    ->downloadable()
    ->disabled()
    ->visible(fn ($record) => $record && $record->work_certificate),
                    Forms\Components\FileUpload::make('company_npwp')
                        ->label('NPWP Perusahaan')
                        ->disk('public')
                        ->downloadable()
                        ->disabled()
                        ->visible(fn ($record) => $record && $record->company_npwp),
                ])
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
                Tables\Columns\TextColumn::make('participant.type')
                    ->label('Jenis AK3U')
                    ->badge(),
                Tables\Columns\TextColumn::make('ktp_number')
                    ->label('No. KTP')
                    ->searchable(),
                Tables\Columns\IconColumn::make('scan_diploma')
                    ->label('Ijazah')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('scan_ktp')
                    ->label('KTP')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('scan_photo')
                    ->label('Foto')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('participant.type')
                    ->label('Jenis AK3U')
                    ->relationship('participant', 'type')
                    ->options([
                        'kemnaker' => 'Kemnaker',
                        'bnsp' => 'BNSP'
                    ]),
            ])
            ->defaultGroup('participant.type')
            ->groups([
                 Tables\Grouping\Group::make('participant.type')
                    ->label('Jenis AK3U')
                    ->collapsible(),
            ])
            ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\ActionGroup::make([
            Tables\Actions\Action::make('download_zip')
                ->label('Download ZIP')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->action(function (DocumentUpload $record) {

                    $zip = new \ZipArchive();

                    $fileName = $record->participant->registration_number . '_documents.zip';

                    $tempFile = storage_path('app/temp/' . $fileName);

                    // pastikan folder temp ada
                    if (!file_exists(storage_path('app/temp'))) {
                        mkdir(storage_path('app/temp'), 0755, true);
                    }

                    if ($zip->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

                        $fields = [
                            'scan_diploma' => 'Ijazah',
                            'scan_ktp' => 'KTP',
                            'scan_photo' => 'Foto',
                            'health_certificate' => 'Surat_Sehat',
                            'cv_file' => 'CV',
                            'integrity_pact' => 'Pakta_Integritas',
                            'work_certificate' => 'Surat_Kerja',
                            'company_npwp' => 'NPWP_Perusahaan',
                        ];

                        foreach ($fields as $field => $name) {

                            if ($record->$field) {

                                $filePath = storage_path('app/public/' . $record->$field);

                                if (file_exists($filePath)) {

                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                                    $zip->addFile(
                                        $filePath,
                                        $name . '.' . $extension
                                    );
                                }
                            }
                        }

                        $zip->close();
                    }

                    return response()->download($tempFile)->deleteFileAfterSend(true);
                }), 
            Tables\Actions\Action::make('download_diploma')
                ->label('Download Ijazah')
                ->icon('heroicon-o-document')
                ->visible(fn (DocumentUpload $record): bool => (bool) $record->scan_diploma)
                ->action(function (DocumentUpload $record) {
                    return response()->download(
                        storage_path('app/public/' . $record->scan_diploma)
                    );
                }),

            Tables\Actions\Action::make('download_ktp')
                ->label('Download KTP')
                ->icon('heroicon-o-identification')
                ->visible(fn (DocumentUpload $record): bool => (bool) $record->scan_ktp)
                ->action(function (DocumentUpload $record) {
                    return response()->download(
                        storage_path('app/public/' . $record->scan_ktp)
                    );
                }),

            Tables\Actions\Action::make('download_photo')
                ->label('Download Foto')
                ->icon('heroicon-o-photo')
                ->visible(fn (DocumentUpload $record): bool => (bool) $record->scan_photo)
                ->action(function (DocumentUpload $record) {
                    return response()->download(
                        storage_path('app/public/' . $record->scan_photo)
                    );
                }),
            ])
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentUploads::route('/'),
            'view' => Pages\ViewDocumentUpload::route('/{record}'),
        ];
    }
}
