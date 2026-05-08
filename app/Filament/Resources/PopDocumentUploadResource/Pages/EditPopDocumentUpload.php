<?php

namespace App\Filament\Resources\PopDocumentUploadResource\Pages;

use App\Filament\Resources\PopDocumentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPopDocumentUpload extends EditRecord
{
    protected static string $resource = PopDocumentUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
