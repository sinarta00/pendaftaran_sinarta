<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailAttachmentSettingResource\Pages;
use App\Filament\Resources\EmailAttachmentSettingResource\RelationManagers;
use App\Models\EmailAttachmentSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailAttachmentSettingResource extends Resource
{
    protected static ?string $model = EmailAttachmentSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
       return $form->schema([
            Forms\Components\TextInput::make('label')
                ->label('Nama (untuk admin, misal: "Email Kemnaker Perusahaan")')
                ->required(),

            Forms\Components\Select::make('key')
                ->label('Berlaku untuk')
                ->options([
                    \App\Mail\RegistrationConfirmation::class => 'Konfirmasi Umum',
                    \App\Mail\RegistrationConfirmation2::class => 'Konfirmasi Kemnaker (Company)',
                ])
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\FileUpload::make('attachment_path')
                ->label('File PDF')
                ->disk('public')
                ->directory('email-attachments')
                ->acceptedFileTypes(['application/pdf'])
                ->downloadable()
                ->openable(),

            Forms\Components\TextInput::make('attachment_name')
                ->label('Nama file saat dikirim (misal: Panduan.pdf)'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('key')->label('Kategori')->limit(30),
                Tables\Columns\TextColumn::make('attachment_name')->label('File'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmailAttachmentSettings::route('/'),
        ];
    }    
}
