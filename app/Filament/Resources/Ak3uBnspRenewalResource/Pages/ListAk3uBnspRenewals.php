<?php

namespace App\Filament\Resources\Ak3uBnspRenewalResource\Pages;

use App\Filament\Resources\Ak3uBnspRenewalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAk3uBnspRenewals extends ListRecords
{
    protected static string $resource = Ak3uBnspRenewalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
