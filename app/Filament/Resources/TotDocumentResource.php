<?php
// app/Filament/Resources/TotDocumentResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TotDocumentResource\Pages;
use App\Models\TotRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class TotDocumentResource extends Resource
{
    protected static ?string $model = TotRegistration::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationLabel = 'TOT Documents';
    protected static ?string $navigationGroup = 'TOT Management';

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
                    Forms\Components\TextInput::make('level')
                        ->label('Level TOT')
                        ->disabled(),
                ]),
            
            Forms\Components\Section::make('Dokumen Wajib')
                ->schema([
                    Forms\Components\FileUpload::make('photo_file')
                        ->label('Pas Foto')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('ktp_file')
                        ->label('KTP')
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
                ]),
            
            Forms\Components\Section::make('Dokumen Level 3')
                ->schema([
                    Forms\Components\FileUpload::make('tot_assistant_cert')
                        ->label('Sertifikat TOT Asisten')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('work_exp_assistant')
                        ->label('Pengalaman Kerja Asisten')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                ])
                ->visible(fn ($record) => $record && $record->level == '3'),
            
            Forms\Components\Section::make('Dokumen Level 4')
                ->schema([
                    Forms\Components\FileUpload::make('tot_instructor_cert')
                        ->label('Sertifikat TOT Instruktur')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('work_exp_instructor')
                        ->label('Pengalaman Kerja Instruktur')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                ])
                ->visible(fn ($record) => $record && $record->level == '4'),
            
            Forms\Components\Section::make('Dokumen Level 5')
                ->schema([
                    Forms\Components\FileUpload::make('kkni_level4_cert')
                        ->label('Sertifikat KKNI Level 4')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('work_exp_instructor')
                        ->label('Pengalaman Kerja Instruktur')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                ])
                ->visible(fn ($record) => $record && $record->level == '5'),
            
            Forms\Components\Section::make('Dokumen Level 6')
                ->schema([
                    Forms\Components\FileUpload::make('kkni_level4_cert')
                        ->label('Sertifikat KKNI Level 4')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('work_exp_senior')
                        ->label('Pengalaman Kerja Senior')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                ])
                ->visible(fn ($record) => $record && $record->level == '6'),
            
            Forms\Components\Section::make('Dokumen Opsional')
                ->schema([
                    Forms\Components\FileUpload::make('senior_instructor_cert')
                        ->label('Sertifikat Instruktur Senior')
                        ->disk('public')
                        ->downloadable()
                        ->openable()
                        ->disabled(),
                    Forms\Components\FileUpload::make('master_instructor_cert')
                        ->label('Sertifikat Instruktur Master')
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
                Tables\Columns\TextColumn::make('level')
                    ->label('Level')
                    ->badge(),
                Tables\Columns\IconColumn::make('photo_file')
                    ->label('Foto')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('ktp_file')
                    ->label('KTP')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('diploma_file')
                    ->label('Ijazah')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        '3' => 'Level 3',
                        '4' => 'Level 4', 
                        '5' => 'Level 5',
                        '6' => 'Level 6'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('download_all')
                        ->label('Download ZIP')
                        ->icon('heroicon-o-archive-box-arrow-down')
                        ->action(function (TotRegistration $record) {
                            $zipFileName = $record->registration_number . '_tot_documents.zip';
                            
                            return response()->streamDownload(function () use ($record) {
                                $zip = new \ZipArchive();
                                $tempFile = tempnam(sys_get_temp_dir(), 'tot_documents_zip');
                                
                                if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
                                    $fields = [
                                        'photo_file' => 'Foto',
                                        'ktp_file' => 'KTP',
                                        'diploma_file' => 'Ijazah',
                                        'tot_assistant_cert' => 'TOT_Asisten',
                                        'tot_instructor_cert' => 'TOT_Instruktur',
                                        'kkni_level4_cert' => 'KKNI_Level4',
                                        'work_exp_assistant' => 'Pengalaman_Asisten',
                                        'work_exp_instructor' => 'Pengalaman_Instruktur',
                                        'work_exp_senior' => 'Pengalaman_Senior',
                                        'senior_instructor_cert' => 'Instruktur_Senior',
                                        'master_instructor_cert' => 'Instruktur_Master'
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
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTotDocuments::route('/'),
            'view' => Pages\ViewTotDocument::route('/{record}'),
        ];
    }
}