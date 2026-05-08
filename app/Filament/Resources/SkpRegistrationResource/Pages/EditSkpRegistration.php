<?php

namespace App\Filament\Resources\SkpRegistrationResource\Pages;

use App\Filament\Resources\SkpRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSkpRegistration extends EditRecord
{
    protected static string $resource = SkpRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
