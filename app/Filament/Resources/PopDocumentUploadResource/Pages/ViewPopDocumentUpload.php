<?php

namespace App\Filament\Resources\PopDocumentUploadResource\Pages;

use App\Filament\Resources\PopDocumentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPopDocumentUpload extends ViewRecord
{
    protected static string $resource = PopDocumentUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
