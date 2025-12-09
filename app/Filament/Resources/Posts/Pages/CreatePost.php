<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->translations = $data['translations'];
        unset($data['translations']);
        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->translations as $locale => $tr) {
            $this->record->translations()->create([
                'locale' => $locale,
                'title' => $tr['title'] ?? '',
                'excerpt' => $tr['excerpt'] ?? '',
                'content' => $tr['content'] ?? '',
            ]);
        }
    }
}
