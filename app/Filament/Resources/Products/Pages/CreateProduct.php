<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $translations = $data['translations'];
        unset($data['translations']);

        // сохраним product сначала
        $product = $this->record;

        foreach ($translations as $locale => $fields) {
            $product->translations()->updateOrCreate(
                ['locale' => $locale],
                $fields
            );
        }

        return $data;
    }

}
