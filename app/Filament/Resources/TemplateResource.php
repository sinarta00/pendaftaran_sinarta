<?php
// app/Filament/Resources/TemplateResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateResource\Pages;
use App\Models\Template;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Template';
    protected static ?string $navigationGroup = 'AK3U Management';
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Template')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('type')
                ->label('Jenis Template')
                ->options([
                    'integrity_pact' => 'Pakta Integritas',
                    'kemnaker_integrity_pact' => 'Pakta Integritas Kemnaker',
                    'bnsp_integrity_pact' => 'Pakta Integritas BNSP',
                    'other' => 'Lainnya'
                ])
                ->required(),
            Forms\Components\FileUpload::make('file_path')
                ->label('File')
                ->disk('public')
                ->directory('templates')
                ->acceptedFileTypes(['application/pdf'])
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Template')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Template')
                    ->options([
                        'integrity_pact' => 'Pakta Integritas',
                        'other' => 'Lainnya'
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}