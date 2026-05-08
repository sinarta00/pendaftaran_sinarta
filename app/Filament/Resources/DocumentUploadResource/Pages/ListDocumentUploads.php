<?php

namespace App\Filament\Resources\DocumentUploadResource\Pages;

use App\Filament\Resources\DocumentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentUploads extends ListRecords
{
    protected static string $resource = DocumentUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
