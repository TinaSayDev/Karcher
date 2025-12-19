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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
                    Forms\Components\TextInput::make('translations.ru.name')
                        ->label('Название (RU)')
                        ->required()
                        ->afterStateUpdated(fn ($state, $set) =>
                        $set('translations.ru.slug', str($state)->slug())
                        ),
                    Forms\Components\TextInput::make('translations.ru.slug')->label('Slug (RU) -- Создается автоматически при сохранении')->required(),
                    Forms\Components\Textarea::make('translations.ru.description')->label('Описание (RU)')->rows(4),
                ])
                ->collapsible(),

// EN
            Section::make('English')
                ->schema([
                    Forms\Components\TextInput::make('translations.en.name')
                        ->label('Название (EN)')
                        ->required()
                        ->afterStateUpdated(fn ($state, $set) =>
                        $set('translations.en.slug', str($state)->slug())
                        ),
                    Forms\Components\TextInput::make('translations.en.slug')->label('Slug (EN) -- Создается автоматически при сохранении')->required(),
                    Forms\Components\Textarea::make('translations.en.description')->label('Описание (EN)')->rows(4),
                ])
                ->collapsible(),

// UZ
            Section::make('O‘zbekcha')
                ->schema([
                    Forms\Components\TextInput::make('translations.uz.name')
                        ->label('Название (UZ)')
                        ->required()
                        ->afterStateUpdated(fn ($state, $set) =>
                        $set('translations.uz.slug', str($state)->slug())
                        ),
                    Forms\Components\TextInput::make('translations.uz.slug')->label('Slug (UZ) -- Создается автоматически при сохранении')->required(),
                    Forms\Components\Textarea::make('translations.uz.description')->label('Описание (UZ)')->rows(4),
                ])
                ->collapsible(),

        ]);
    }

    /* ---------------- TABLE ---------------- */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ru_name')
                    ->label('Название (RU)')
                    ->formatStateUsing(fn($state, $record) => str_repeat('— ', $record->level) . ($state ?? '—'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_id')
                    ->label('Родитель')
                    ->formatStateUsing(fn($state, $record) => $record->parent?->ru_name ?? '-')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    protected static function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getTableQuery()->with('parent')->orderBy('parent_id')->orderBy('id');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Категории';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Категории';
    }

    public static function getNavigationLabel(): string
    {
        return 'Категории';
    }

    public static function getNavigationSort(): ?int
    {
        return 3; // порядок внутри группы
    }
}
