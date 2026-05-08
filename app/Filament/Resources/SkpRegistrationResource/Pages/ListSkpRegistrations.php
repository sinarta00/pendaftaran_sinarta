<?php

namespace App\Filament\Resources\SkpRegistrationResource\Pages;

use App\Filament\Resources\SkpRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSkpRegistrations extends ListRecords
{
    protected static string $resource = SkpRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
