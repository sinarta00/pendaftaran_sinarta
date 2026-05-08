<?php

namespace App\Filament\Resources\PopDocumentUploadResource\Pages;

use App\Filament\Resources\PopDocumentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPopDocumentUploads extends ListRecords
{
    protected static string $resource = PopDocumentUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
