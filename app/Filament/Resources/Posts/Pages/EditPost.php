<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['translations'] = [
            'ru' => [
                'title' => $this->record->translation('ru')->title ?? '',
                'excerpt' => $this->record->translation('ru')->excerpt ?? '',
                'content' => $this->record->translation('ru')->content ?? '',
            ],
            'uz' => [
                'title' => $this->record->translation('uz')->title ?? '',
                'excerpt' => $this->record->translation('uz')->excerpt ?? '',
                'content' => $this->record->translation('uz')->content ?? '',
            ],
            'en' => [
                'title' => $this->record->translation('en')->title ?? '',
                'excerpt' => $this->record->translation('en')->excerpt ?? '',
                'content' => $this->record->translation('en')->content ?? '',
            ],
        ];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->translations = $data['translations'];
        unset($data['translations']);
        return $data;
    }

    protected function afterSave(): void
    {
        foreach ($this->translations as $locale => $tr) {
            $this->record->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $tr['title'] ?? '',
                    'excerpt' => $tr['excerpt'] ?? '',
                    'content' => $tr['content'] ?? '',
                ]
            );
        }
    }
}
