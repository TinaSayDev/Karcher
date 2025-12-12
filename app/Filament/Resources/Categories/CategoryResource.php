<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Models\Category;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    /* ---------------- FORM ---------------- */
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('parent_id')
                ->label('Родительская категория')
                ->options(Category::all()->pluck('ru_name', 'id'))
                ->searchable()
                ->placeholder('Без родителя'),

            Forms\Components\FileUpload::make('image')
                ->label('Изображение')
                ->disk('public')
                ->directory('categories')
                ->visibility('public')
                ->image(),

            // RU
            Section::make('Русский')
                ->schema([
                    Forms\Components\TextInput::make('translations.ru.name')->label('Название (RU)')->required(),
                    Forms\Components\TextInput::make('translations.ru.slug')->label('Slug (RU)')->required(),
                    Forms\Components\Textarea::make('translations.ru.description')->label('Описание (RU)')->rows(4),
                ])
                ->collapsible(),

            // EN
            Section::make('English')
                ->schema([
                    Forms\Components\TextInput::make('translations.en.name')->label('Название (EN)')->required(),
                    Forms\Components\TextInput::make('translations.en.slug')->label('Slug (EN)')->required(),
                    Forms\Components\Textarea::make('translations.en.description')->label('Описание (EN)')->rows(4),
                ])
                ->collapsible(),

            // UZ
            Section::make('O‘zbekcha')
                ->schema([
                    Forms\Components\TextInput::make('translations.uz.name')->label('Название (UZ)')->required(),
                    Forms\Components\TextInput::make('translations.uz.slug')->label('Slug (UZ)')->required(),
                    Forms\Components\Textarea::make('translations.uz.description')->label('Описание (UZ)')->rows(4),
                ])
                ->collapsible(),
        ]);
    }

    /* ---------------- TABLE ---------------- */
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('parent_id')
            ->columns([
                Tables\Columns\TextColumn::make('ru_name')
                    ->label('Название (RU)')
                    ->formatStateUsing(fn($state, $record) => str_repeat('— ', $record->level) . ($record->parent_id ? '📄 ' : '📁 ') . ($state ?? '—'))
                    ->searchable()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
