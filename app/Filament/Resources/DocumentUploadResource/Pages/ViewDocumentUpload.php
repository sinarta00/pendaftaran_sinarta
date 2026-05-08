<?php

namespace App\Filament\Resources\DocumentUploadResource\Pages;

use App\Filament\Resources\DocumentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDocumentUpload extends ViewRecord
{
    protected static string $resource = DocumentUploadResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(), // Disable edit jika tidak perlu
        ];
    }
}