<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Список категорий';
    }

    public function getBreadcrumb(): string
    {
        return 'Категории';
    }

    public static function getCreateButtonLabel(): string
    {
        return 'Добавить категорию';
    }
}
