<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Models\CategoryTranslation;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $category = $this->record->load('translations');

        foreach (['ru', 'en', 'uz'] as $locale) {
            $t = $category->translations->firstWhere('locale', $locale);
            $data['translations'][$locale] = [
                'name' => $t->name ?? '',
                'slug' => $t->slug ?? '',
                'description' => $t->description ?? '',
            ];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->translations = $data['translations'] ?? [];
        unset($data['translations']);
        return $data;
    }

    protected function afterSave(): void
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
