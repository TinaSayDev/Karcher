<?php

namespace App\Filament\Resources\Products;

use App\Models\Product;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Products\Pages;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use BackedEnum;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Section::make('Основные данные')
                    ->schema([
                        Forms\Components\TextInput::make('code')->label('Код'),
                        Forms\Components\TextInput::make('price_new')->label('Цена'),
                        Forms\Components\TextInput::make('price_old')->label('Старая цена'),
                        Select::make('category_id')
                            ->label('Категория')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'id' // что угодно реальное, не используется
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->name_ru)
                            ->searchable()
                            ->preload()
                            ->required(),
                        /*Forms\Components\Select::make('category_id')
                            ->relationship('category', 'id')
                            ->label('Категория'),*/
                        Forms\Components\FileUpload::make('image_main')
                            ->label('Главная картинка')
                            ->disk('public')              // сохраняем в storage/app/public
                            ->directory('products')          // папка storage/app/public/posts
                            ->image()
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->label('Галерея')
                            ->disk('public')              // сохраняем в storage/app/public
                            ->directory('products')          // папка storage/app/public/posts
                            ->visibility('public'),
                    ]),

                Section::make('Переводы')
                    ->schema([

                        Tabs::make('Translations')->tabs([
                            Tab::make('RU')->schema([
                                Forms\Components\TextInput::make('translations.ru.name')->label('Название'),
                                Forms\Components\TextInput::make('translations.ru.slug')->label('Slug'),
                                Forms\Components\Textarea::make('translations.ru.short_description')->label('Короткое описание'),
                                Forms\Components\RichEditor::make('translations.ru.description')->label('Описание'),
                                Forms\Components\Textarea::make('translations.ru.specifications')->label('Характеристики'),
                                Forms\Components\Textarea::make('translations.ru.equipment')->label('Комплектация'),
                            ]),

                            Tab::make('UZ')->schema([
                                Forms\Components\TextInput::make('translations.uz.name')->label('Название'),
                                Forms\Components\TextInput::make('translations.uz.slug')->label('Slug'),
                                Forms\Components\Textarea::make('translations.uz.short_description')->label('Короткое описание'),
                                Forms\Components\RichEditor::make('translations.uz.description')->label('Описание'),
                                Forms\Components\Textarea::make('translations.uz.specifications')->label('Характеристики'),
                                Forms\Components\Textarea::make('translations.uz.equipment')->label('Комплектация'),
                            ]),

                            Tab::make('EN')->schema([
                                Forms\Components\TextInput::make('translations.en.name')->label('Название'),
                                Forms\Components\TextInput::make('translations.en.slug')->label('Slug'),
                                Forms\Components\Textarea::make('translations.en.short_description')->label('Короткое описание'),
                                Forms\Components\RichEditor::make('translations.en.description')->label('Описание'),
                                Forms\Components\Textarea::make('translations.en.specifications')->label('Характеристики'),
                                Forms\Components\Textarea::make('translations.en.equipment')->label('Комплектация'),
                            ]),
                        ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('category.translations.name')
                    ->label('Категория (RU)')
                    ->getStateUsing(fn($record) =>
                    optional(
                        $record->category?->translations
                            ->where('locale', 'ru')
                            ->first()
                    )?->name
                    ),

                Tables\Columns\TextColumn::make('name_ru')
                    ->label('Название (RU)')
                    ->getStateUsing(fn($record) =>
                    optional(
                        $record->translations
                            ->where('locale', 'ru')
                            ->first()
                    )?->name
                    )
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image_main')->label('Фото'),

                Tables\Columns\TextColumn::make('price_new')->label('Цена'),
            ])
            ->actions([
                EditAction::make()
            ]);
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
