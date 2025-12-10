<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('code'),
                TextInput::make('price_old')
                    ->numeric(),
                TextInput::make('price_new')
                    ->numeric(),
                FileUpload::make('image_main')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public'),
                TextInput::make('images'),
                TextInput::make('catalog_images'),
                Toggle::make('is_hit')
                    ->required(),
                Toggle::make('is_new')
                    ->required(),
                Toggle::make('is_recommended')
                    ->required(),
                Toggle::make('is_sale')
                    ->required(),
            ]);
    }
}
