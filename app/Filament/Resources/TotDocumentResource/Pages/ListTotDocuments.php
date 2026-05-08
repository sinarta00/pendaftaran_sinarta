<?php

namespace App\Filament\Resources\TotDocumentResource\Pages;

use App\Filament\Resources\TotDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTotDocuments extends ListRecords
{
    protected static string $resource = TotDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
