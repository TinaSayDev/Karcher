<?php

namespace App\Filament\Resources\AboutPageTranslations;

use App\Filament\Resources\AboutPageTranslations\Pages\EditAboutPageTranslation;
use App\Filament\Resources\AboutPageTranslations\Pages\ListAboutPageTranslations;
use App\Filament\Resources\AboutPageTranslations\Schemas\AboutPageTranslationForm;
use App\Filament\Resources\AboutPageTranslations\Tables\AboutPageTranslationsTable;
use App\Models\AboutPageTranslation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AboutPageTranslationResource extends Resource
{
    protected static ?string $model = AboutPageTranslation::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'Страница';

    public static function form(Schema $schema): Schema
    {
        return AboutPageTranslationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutPageTranslationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutPageTranslations::route('/'),
            'edit' => EditAboutPageTranslation::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string
    {
        return 'О нас';
    }

    public static function getPluralModelLabel(): string
    {
        return 'О нас';
    }

    public static function getNavigationLabel(): string
    {
        return 'О нас';
    }
}
