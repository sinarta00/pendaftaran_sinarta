<?php

namespace App\Filament\Resources\TotRegistrationResource\Pages;

use App\Filament\Resources\TotRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTotRegistration extends EditRecord
{
    protected static string $resource = TotRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
