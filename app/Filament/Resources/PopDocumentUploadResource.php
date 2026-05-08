<?php
// app/Filament/Resources/PopDocumentUploadResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PopDocumentUploadResource\Pages;
use App\Models\PopDocumentUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PopDocumentUploadResource extends Resource
{
    protected static ?string $model = PopDocumentUpload::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static ?string $navigationLabel = 'Dokumen POP';
    protected static ?string $navigationGroup = 'POP BNSP Management';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('participant.full_name')
                ->label('Nama Peserta')
                ->disabled(),
            Forms\Components\TextInput::make('ktp_number')
                ->label('Nomor KTP')
                ->disabled(),
            Forms\Components\TextInput::make('diploma_number')
                ->label('Nomor Ijazah')
                ->disabled(),
            
            Forms\Components\Section::make('Dokumen Upload')
                ->schema([
                    Forms\Components\FileUpload::make('scan_ktp')
                        ->label('Scan KTP')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('scan_diploma')
                        ->label('Scan Ijazah')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('cv_file')
                        ->label('CV')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('work_certificate')
                        ->label('SK Kerja')
                        ->disk('public')
                        ->downloadable()
                        ->disabled()
                        ->visible(fn ($record) => $record && $record->work_certificate),
                    Forms\Components\FileUpload::make('mining_experience_letter')
                        ->label('Surat Pengalaman Kerja Tambang')
                        ->disk('public')
                        ->downloadable()
                        ->disabled(),
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
                Tables\Columns\TextColumn::make('participant.category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'online' => 'Online',
                        'hybrid' => 'Hybrid',
                        default => $state,
                    }),
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
                Tables\Columns\IconColumn::make('mining_experience_letter')
                    ->label('Pengalaman')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('participant.category')
                    ->label('Kategori')
                    ->relationship('participant', 'category')
                    ->options([
                        'online' => 'Online',
                        'hybrid' => 'Hybrid'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    // Download ZIP
                    Tables\Actions\Action::make('download_zip')
                        ->label('Download ZIP')
                        ->icon('heroicon-o-archive-box-arrow-down')
                        ->color('success')
                        ->action(function (PopDocumentUpload $record) {
                            return response()->streamDownload(function () use ($record) {
                                $zip = new \ZipArchive();
                                $fileName = $record->participant->registration_number . '_documents.zip';
                                $tempFile = tempnam(sys_get_temp_dir(), $fileName);
                                
                                if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
                                    $fields = [
                                        'scan_diploma' => 'Ijazah',
                                        'scan_ktp' => 'KTP',
                                        'cv_file' => 'CV',
                                        'work_certificate' => 'SK_Kerja',
                                        'mining_experience_letter' => 'Pengalaman_Tambang'
                                    ];
                                    
                                    foreach ($fields as $field => $name) {
                                        if ($record->$field && Storage::disk('public')->exists($record->$field)) {
                                            $filePath = Storage::disk('public')->path($record->$field);
                                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                            $zip->addFile($filePath, $name . '.' . $extension);
                                        }
                                    }
                                    $zip->close();
                                }
                                
                                readfile($tempFile);
                                unlink($tempFile);
                            }, $fileName);
                        }),
                    
                    // Download KTP
                    Tables\Actions\Action::make('download_ktp')
                        ->label('Download KTP')
                        ->icon('heroicon-o-identification')
                        ->color('info')
                        ->visible(fn (PopDocumentUpload $record): bool => (bool) $record->scan_ktp)
                        ->url(fn (PopDocumentUpload $record) => asset('storage/' . $record->scan_ktp))
                        ->openUrlInNewTab(),
                    
                    // Download Ijazah
                    Tables\Actions\Action::make('download_diploma')
                        ->label('Download Ijazah')
                        ->icon('heroicon-o-document')
                        ->color('info')
                        ->visible(fn (PopDocumentUpload $record): bool => (bool) $record->scan_diploma)
                        ->url(fn (PopDocumentUpload $record) => asset('storage/' . $record->scan_diploma))
                        ->openUrlInNewTab(),
                    
                    // Download CV
                    Tables\Actions\Action::make('download_cv')
                        ->label('Download CV')
                        ->icon('heroicon-o-document-text')
                        ->color('info')
                        ->visible(fn (PopDocumentUpload $record): bool => (bool) $record->cv_file)
                        ->url(fn (PopDocumentUpload $record) => asset('storage/' . $record->cv_file))
                        ->openUrlInNewTab(),
                    
                    // Download SK Kerja
                    Tables\Actions\Action::make('download_work_cert')
                        ->label('Download SK Kerja')
                        ->icon('heroicon-o-document-check')
                        ->color('info')
                        ->visible(fn (PopDocumentUpload $record): bool => (bool) $record->work_certificate)
                        ->url(fn (PopDocumentUpload $record) => asset('storage/' . $record->work_certificate))
                        ->openUrlInNewTab(),
                    
                    // Download Pengalaman Tambang
                    Tables\Actions\Action::make('download_experience')
                        ->label('Download Pengalaman')
                        ->icon('heroicon-o-briefcase')
                        ->color('info')
                        ->visible(fn (PopDocumentUpload $record): bool => (bool) $record->mining_experience_letter)
                        ->url(fn (PopDocumentUpload $record) => asset('storage/' . $record->mining_experience_letter))
                        ->openUrlInNewTab(),
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPopDocumentUploads::route('/'),
            'view' => Pages\ViewPopDocumentUpload::route('/{record}'),
        ];
    }
}