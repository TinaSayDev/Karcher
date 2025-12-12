<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $translations = $data['translations'] ?? [];
        unset($data['translations']);

        foreach ($translations as $locale => $fields) {
            // Извлекаем поля tabs
            $tabs = $fields['tabs'] ?? [];
            unset($fields['tabs']);

            $this->record->translations()->updateOrCreate(
                ['locale' => $locale],
                array_merge($fields, ['tabs' => $tabs])
            );
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        foreach ($this->form->getState()['translations'] as $locale => $fields) {
            $record->translations()->updateOrCreate(
                ['locale' => $locale],
                $fields
            );
        }

        $record->moveFilesToProductFolder();
    }

}
