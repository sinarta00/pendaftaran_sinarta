<?php

namespace App\Filament\Resources\Ak3uBnspRenewalResource\Pages;

use App\Filament\Resources\Ak3uBnspRenewalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAk3uBnspRenewal extends EditRecord
{
    protected static string $resource = Ak3uBnspRenewalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
