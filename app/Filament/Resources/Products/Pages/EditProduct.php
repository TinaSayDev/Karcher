<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translations = $this->record->translations->keyBy('locale');

        $data['translations'] = [
            'ru' => [
                'name' => $translations['ru']->name ?? '',
                'slug' => $translations['ru']->slug ?? '',
                'short_description' => $translations['ru']->short_description ?? '',
                'description' => $translations['ru']->description ?? '',
                'specifications' => $translations['ru']->specifications ?? '',
                'equipment' => $translations['ru']->equipment ?? '',
            ],
            'uz' => [
                'name' => $translations['uz']->name ?? '',
                'slug' => $translations['uz']->slug ?? '',
                'short_description' => $translations['uz']->short_description ?? '',
                'description' => $translations['uz']->description ?? '',
                'specifications' => $translations['uz']->specifications ?? '',
                'equipment' => $translations['uz']->equipment ?? '',
            ],
            'en' => [
                'name' => $translations['en']->name ?? '',
                'slug' => $translations['en']->slug ?? '',
                'short_description' => $translations['en']->short_description ?? '',
                'description' => $translations['en']->description ?? '',
                'specifications' => $translations['en']->specifications ?? '',
                'equipment' => $translations['en']->equipment ?? '',
            ],
        ];

        return $data;
    }


    protected function afterSave(): void
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
