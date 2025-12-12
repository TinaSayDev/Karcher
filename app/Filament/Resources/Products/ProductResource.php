<?php

namespace App\Filament\Resources\Products;

use App\Models\Product;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Filament\Resources\Products\Pages;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use BackedEnum;
use Filament\Forms\Components\Toggle;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Основные данные')
                ->schema([
                Forms\Components\TextInput::make('code')->label('Код'),
                Forms\Components\TextInput::make('price_new')->label('Цена'),
                Forms\Components\TextInput::make('price_old')->label('Старая цена'),

                Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'id')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name_ru)
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\FileUpload::make('image_main')
                    ->label('Главная картинка')
                    ->disk('public')
                    ->directory('temp/products')
                    ->image(),

                Forms\Components\FileUpload::make('images')
                    ->label('Галерея')
                    ->disk('public')
                    ->directory('temp/products')
                    ->multiple(),

                    Toggle::make('is_hit')->label('Хит'),
                    Toggle::make('is_new')->label('Новинка'),
                    Toggle::make('is_recommended')->label('Рекомендуемое'),
                    Toggle::make('is_sale')->label('Акция'),
            ]),

            Section::make('Переводы')
                ->schema([
                Tabs::make('Translations')->tabs([

                    // RU
                    Tab::make('RU')->schema([
                        Forms\Components\TextInput::make('translations.ru.name')
                            ->label('Название')
                            ->required()
                            ->afterStateUpdated(fn($state, $set) =>
                            $set('translations.ru.slug', str($state)->slug())
                            ),

                        Forms\Components\TextInput::make('translations.ru.slug')
                            ->label('Slug (RU)'),

                        Forms\Components\Textarea::make('translations.ru.short_description'),
                        Forms\Components\RichEditor::make('translations.ru.description'),
                        Forms\Components\Textarea::make('translations.ru.specifications'),
                        Forms\Components\Textarea::make('translations.ru.equipment'),
                    ]),

                    // UZ
                    Tab::make('UZ')->schema([
                        Forms\Components\TextInput::make('translations.uz.name')
                            ->label('Название')
                            ->afterStateUpdated(fn($state, $set) =>
                            $set('translations.uz.slug', str($state)->slug())
                            ),

                        Forms\Components\TextInput::make('translations.uz.slug'),
                        Forms\Components\Textarea::make('translations.uz.short_description'),
                        Forms\Components\RichEditor::make('translations.uz.description'),
                        Forms\Components\Textarea::make('translations.uz.specifications'),
                        Forms\Components\Textarea::make('translations.uz.equipment'),
                    ]),

                    // EN
                    Tab::make('EN')->schema([
                        Forms\Components\TextInput::make('translations.en.name')
                            ->label('Название')
                            ->afterStateUpdated(fn($state, $set) =>
                            $set('translations.en.slug', str($state)->slug())
                            ),

                        Forms\Components\TextInput::make('translations.en.slug'),
                        Forms\Components\Textarea::make('translations.en.short_description'),
                        Forms\Components\RichEditor::make('translations.en.description'),
                        Forms\Components\Textarea::make('translations.en.specifications'),
                        Forms\Components\Textarea::make('translations.en.equipment'),
                    ]),

                ]),
            ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.translations.name')
                    ->label('Категория (RU)')
                    ->getStateUsing(fn($record) =>
                    optional($record->category?->translations->where('locale', 'ru')->first())?->name
                    ),

                Tables\Columns\TextColumn::make('name_ru')
                    ->label('Название (RU)')
                    ->getStateUsing(fn($record) =>
                    optional($record->translations->where('locale', 'ru')->first())?->name
                    )
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image_main')->label('Фото'),
                Tables\Columns\TextColumn::make('price_new')->label('Цена'),
            ])
            ->recordActions([ EditAction::make() ])
            ->bulkActions([ DeleteBulkAction::make() ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
