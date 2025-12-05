<?php

namespace App\Filament\Resources\AboutPageTranslations\Pages;

use App\Filament\Resources\AboutPageTranslations\AboutPageTranslationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutPageTranslations extends ListRecords
{
    protected static string $resource = AboutPageTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // CreateAction::make(),
        ];
    }

}
