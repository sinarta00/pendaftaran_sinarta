<?php

namespace App\Filament\Resources\EmailAttachmentSettingResource\Pages;

use App\Filament\Resources\EmailAttachmentSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmailAttachmentSettings extends ManageRecords
{
    protected static string $resource = EmailAttachmentSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
