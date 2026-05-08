<?php

namespace App\Filament\Resources\PopParticipantResource\Pages;

use App\Filament\Resources\PopParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPopParticipants extends ListRecords
{
    protected static string $resource = PopParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
