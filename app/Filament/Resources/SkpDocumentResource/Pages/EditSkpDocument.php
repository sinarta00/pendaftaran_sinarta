<?php

namespace App\Filament\Resources\SkpDocumentResource\Pages;

use App\Filament\Resources\SkpDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSkpDocument extends EditRecord
{
    protected static string $resource = SkpDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
