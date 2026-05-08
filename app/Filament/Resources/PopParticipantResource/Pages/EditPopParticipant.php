<?php

namespace App\Filament\Resources\PopParticipantResource\Pages;

use App\Filament\Resources\PopParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPopParticipant extends EditRecord
{
    protected static string $resource = PopParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
