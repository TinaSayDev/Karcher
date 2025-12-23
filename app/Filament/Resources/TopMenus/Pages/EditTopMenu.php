<?php

namespace App\Filament\Resources\TopMenus\Pages;

use App\Filament\Resources\TopMenus\TopMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTopMenu extends EditRecord
{
    protected static string $resource = TopMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

}
