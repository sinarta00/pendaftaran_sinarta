<?php

namespace App\Filament\Resources\TotRegistrationResource\Pages;

use App\Filament\Resources\TotRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTotRegistrations extends ListRecords
{
    protected static string $resource = TotRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
