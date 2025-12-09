<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Models\CategoryTranslation;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->translations = $data['translations'] ?? [];
        unset($data['translations']);
        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->translations as $locale => $fields) {
            CategoryTranslation::updateOrCreate(
                ['category_id' => $this->record->id, 'locale' => $locale],
                [
                    'name'        => $fields['name'] ?? '',
                    'slug'        => $fields['slug'] ?? '',
                    'description' => $fields['description'] ?? '',
                ]
            );
        }
    }
}
